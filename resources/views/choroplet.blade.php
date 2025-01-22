@extends('layouts.app')

@php
    $province_name = ucwords(strtolower($province->name));
    $hasMap = true;
@endphp

@section('page-title', "Peta {$province_name}")

@section('content')
    <div class="flex flex-col justify-center items-center gap-6 px-4 py-8 mt-24">
        <h1 class="text-4xl font-semibold capitalize">Peta {{ $province_name }}</h1>
        <div class="flex flex-col items-center gap-2">
            <h2 class="text-xl">Information</h2>
            <div class="flex gap-4 mb-4">
                <select id="levelSelect" class="form-select">
                    <option value="province">Province Level</option>
                    <option value="regency">Regency Level</option>
                </select>
                <select id="yearSelect" class="form-select">
                    @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
                <select id="dataTypeSelect" class="form-select">
                    @foreach ($dataTypes as $category => $types)
                        <optgroup label="{{ $category }}">
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div id="map" class="h-[500px] rounded-2xl"></div>

@endsection

@section('latlong', "[$province->latitude, $province->longitude]")
@section('zoom', 7)

@push('scripts')
    <script>
        let geojson, info, legend, dataTypeSelect;
        const provinceId = {{ $province->id }};

        // Info control
        info = L.control();
        info.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };
        info.update = function(props) {
            let formattedValue = "Data Belum Tersedia";
            if (props && props.value) formattedValue = new Intl.NumberFormat().format(props ? props.value : 0);
            this._div.innerHTML = props ?
                `<b>${props.name}</b><br>${formattedValue} ${props.unit || ''}` :
                'Hover over an area';
        };
        info.addTo(map);

        // Legend control
        legend = L.control({
            position: 'bottomright'
        });

        function getColor(value, maxValue, property) {
            const percentage = maxValue ? value / maxValue : 0;
            const colors = {
                "Luas Wilayah": ['#FF0000', '#FFCCCC'], // Pink (gelap ke terang)
                "Populasi": ['#2b681e', '#b3e5a8'], // Merah
                "SMA": ['#505050', '#D9D9D9'], // Abu-abu
                "Lulusan SMA": ['#0000FF', '#99CCFF'], // Biru
                "Universitas / Sederajat": ['#0000FF', '#99CCFF'], // Biru
                "Lulusan S1": ['#FFD700', '#FFF5CC'], // Kuning
                "Pengangguran": ['#008000', '#99FF99'] // Hijau
            };

            const colorScale = colors[property] || ['#FFFFFF', '#E0E0E0']; // Default warna jika properti tidak ditemukan

            return percentage > 0.9 ? colorScale[0] :
                percentage > 0.7 ? lightenColor(colorScale[0], 0.2) :
                percentage > 0.5 ? lightenColor(colorScale[0], 0.4) :
                percentage > 0.3 ? lightenColor(colorScale[0], 0.6) :
                percentage > 0.1 ? lightenColor(colorScale[0], 0.8) :
                colorScale[1];
        }

        function lightenColor(color, percentage) {
            // Fungsi untuk mencerahkan warna
            const num = parseInt(color.slice(1), 16),
                amt = Math.round(2.55 * (percentage * 100)),
                R = (num >> 16) + amt,
                G = (num >> 8 & 0x00FF) + amt,
                B = (num & 0x0000FF) + amt;

            return `#${(0x1000000 + (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 + 
                (G < 255 ? G < 1 ? 0 : G : 255) * 0x100 + 
                (B < 255 ? B < 1 ? 0 : B : 255))
                .toString(16)
                .slice(1)}`;
        }

        function style(feature, maxValue) {
            return {
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(feature.properties.value || 0, maxValue, feature.properties.data_name)
            };
        }

        function highlightFeature(e) {
            const layer = e.target;
            layer.setStyle({
                weight: 5,
                color: '#666',
                dashArray: '',
                fillOpacity: 0.7
            });
            layer.bringToFront();
            info.update(layer.feature.properties);
        }

        function resetHighlight(e) {
            geojson.resetStyle(e.target);
            info.update();
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds());
        }

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToFeature
            });
        }

        async function loadGeoJSON() {
            const level = document.getElementById('levelSelect').value;
            const year = document.getElementById('yearSelect').value;
            const nameDataId = document.getElementById('dataTypeSelect').value;

            try {
                const response = await fetch(
                    `/geojson?province_id=${provinceId}&level=${level}&year=${year}&name_data_id=${nameDataId}`);
                const data = await response.json();

                if (geojson) {
                    map.removeLayer(geojson);
                }

                const maxValue = Math.max(...data.features.map(f => f.properties.value || 0));

                geojson = L.geoJSON(data, {
                    style: (feature) => style(feature, maxValue),
                    onEachFeature
                }).addTo(map);

                updateLegend(maxValue, data.properties?.data_name);
            } catch (error) {
                console.error('Error loading GeoJSON:', error);
            }
        }

        function updateLegend(maxValue, dataName) {
            if (legend._map) {
                map.removeControl(legend);
            }

            legend.onAdd = function() {
                const div = L.DomUtil.create('div', 'info legend');
                const grades = [0, 0.05, 0.1, 0.2, 0.3, 0.5, 0.7, 0.9];

                div.innerHTML = `<h4>${dataName || 'Legend'}</h4>`;

                const labels = grades.map((grade, index) => {
                    const value = Math.round(grade * maxValue);
                    const nextValue = grades[index + 1] ? Math.round(grades[index + 1] * maxValue) : null;

                    return (
                        `<i style="background:${getColor(value, maxValue)}"></i> ` +
                        `${value}${nextValue ? '&ndash;' + nextValue : '+'}`
                    );
                });

                div.innerHTML += labels.join('<br>');
                return div;
            };

            legend.addTo(map);
        }

        // Event listeners
        document.getElementById('levelSelect').addEventListener('change', loadGeoJSON);
        document.getElementById('yearSelect').addEventListener('change', loadGeoJSON);
        document.getElementById('dataTypeSelect').addEventListener('change', loadGeoJSON);

        // Initial load
        loadGeoJSON();
    </script>
@endpush

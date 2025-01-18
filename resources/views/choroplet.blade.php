@extends('layouts.map')

@php
    $province_name = ucwords(strtolower($province->name));
@endphp

@section('page-title', "Peta {$province_name}")

@section('content')
    <div class="flex flex-col justify-center items-center gap-6 px-4 py-8">
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
@endsection

@section('latlong', "[$province->latitude, $province->longitude]")
@section('zoom', 8)

@push('scripts')
    <script>
        let geojson, info, legend;
        const provinceId = {{ $province->id }};

        // Info control
        info = L.control();
        info.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info');
            this.update();
            return this._div;
        };
        info.update = function(props) {
            this._div.innerHTML = props ?
                `<b>${props.name}</b><br>${props.value} ${props.unit || ''}` :
                'Hover over an area';
        };
        info.addTo(map);

        // Legend control
        legend = L.control({
            position: 'bottomright'
        });

        function getColor(value, maxValue) {
            const percentage = maxValue ? value / maxValue : 0;
            return percentage > 0.9 ? '#800026' :
                percentage > 0.7 ? '#BD0026' :
                percentage > 0.5 ? '#E31A1C' :
                percentage > 0.3 ? '#FC4E2A' :
                percentage > 0.2 ? '#FD8D3C' :
                percentage > 0.1 ? '#FEB24C' :
                percentage > 0.05 ? '#FED976' :
                '#FFEDA0';
        }

        function style(feature, maxValue) {
            return {
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7,
                fillColor: getColor(feature.properties.value || 0, maxValue)
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

                updateLegend(maxValue, data.features[0]?.properties?.data_name);
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

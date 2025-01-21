@extends('layouts.app')

@section('page-title', 'Peta Indonesia')

@php
    $hasMap = true;
@endphp
@section('content')
    <div id="map" class="h-[500px] mt-24 rounded-2xl"></div>
@endsection

@push('scripts')
    <script>
        const data = @json($data);
        const show = '{{ $show }}';

        // render marker
        switch (show) {
            case 'earth-quakes':
                data.Infogempa.gempa.forEach(gempa => {
                    const latlong = gempa.Coordinates.split(",");
                    L.marker(latlong).addTo(map)
                        .bindPopup(gempa.Wilayah + " - " + gempa.Tanggal);
                });
                break;
            case 'regencies':
                data.forEach(regency => {
                    L.marker([regency.latitude, regency.longitude]).addTo(map)
                        .bindPopup(`<b>${regency.name}</b><br>${regency.province.name}`);
                });
                break;
            default:
                data.forEach(provincy => {
                    L.marker([provincy.latitude, provincy.longitude]).addTo(map)
                        .bindPopup(provincy.name);
                });
        }
    </script>
@endpush

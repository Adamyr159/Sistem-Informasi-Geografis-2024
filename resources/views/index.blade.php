@extends('layouts.map')

@section('page-title', 'Peta Indonesia')

@section('content')
    <div class="flex flex-col justify-center items-center gap-6 px-4 py-8">
        <h1 class="text-4xl font-semibold ">Peta Indonesia</h1>
        <div class="flex flex-col items-center gap-2">
            <h2 class="text-xl">Information</h2>
            <div class="flex items-center justify-center flex-wrap text-sm gap-2">
                <a href="/?show=provincies"
                    class="py-2 px-4 border rounded-full transition duration-300 {{ $show == 'provincies' ? 'bg-blue-500 text-white border-blue-500 hover:bg-blue-300' : 'border-slate-400 hover:bg-slate-100' }}">
                    Provincies
                </a>
                <a href="/?show=regencies"
                    class="py-2 px-4 border rounded-full transition duration-300 {{ $show == 'regencies' ? 'bg-blue-500 text-white border-blue-500 hover:bg-blue-300' : 'border-slate-400 hover:bg-slate-100' }}">
                    Regencies
                </a>
                <a href="/?show=earth-quakes"
                    class="py-2 px-4 border rounded-full  transition duration-300 {{ $show == 'earth-quakes' ? 'bg-blue-500 text-white hover:bg-blue-300' : 'border-slate-400 hover:bg-slate-100' }}">
                    Earth Quakes
                </a>
                <a href="{{ route('choroplet') }}"
                    class="py-2 px-4 border rounded-full  transition duration-300 border-slate-400 hover:bg-slate-100">
                    Choroplet
                </a>
            </div>
        </div>
    </div>
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

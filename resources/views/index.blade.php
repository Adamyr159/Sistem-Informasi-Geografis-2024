<!DOCTYPE html>
<html lang="en">

<head>
    <title>Peta</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        body {
            background:
                radial-gradient(farthest-side at -33.33% 50%, #0000 52%, #EBF1FF 54% 57%, #0000 59%) 0 calc(128px/2),
                radial-gradient(farthest-side at 50% 133.33%, #0000 52%, #EBF1FF 54% 57%, #0000 59%) calc(128px/2) 0,
                radial-gradient(farthest-side at 133.33% 50%, #0000 52%, #EBF1FF 54% 57%, #0000 59%),
                radial-gradient(farthest-side at 50% -33.33%, #0000 52%, #EBF1FF 54% 57%, #0000 59%),
                #FFFFFF;
            background-size: calc(128px/4.667) 128px, 128px calc(128px/4.667);
        }
    </style>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex flex-col justify-stretch min-h-screen">
        <div class="flex flex-col justify-center items-center gap-6 px-4 py-8">
            <h1 class="text-4xl font-semibold ">Peta Indonesia</h1>
            <div class="flex flex-col items-center gap-2">
                <h2 class="text-xl">Information</h2>
                <div class="flex items-center justify-center flex-wrap text-sm gap-2">
                    <a href="/?show=provincies"
                        class="py-2 px-4 border rounded-full transition duration-300 {{ $show == 'provincies' ? 'bg-blue-400 text-white border-blue-400 hover:bg-blue-300' : 'border-slate-400 hover:bg-slate-100' }}">
                        Provincies
                    </a>
                    <a href="/?show=regencies"
                        class="py-2 px-4 border rounded-full transition duration-300 {{ $show == 'regencies' ? 'bg-blue-400 text-white border-blue-400 hover:bg-blue-300' : 'border-slate-400 hover:bg-slate-100' }}">
                        Regencies
                    </a>
                    <a href="/?show=earth-quakes"
                        class="py-2 px-4 border rounded-full  transition duration-300 {{ $show == 'earth-quakes' ? 'bg-blue-400 text-white hover:bg-blue-300' : 'border-slate-400 hover:bg-slate-100' }}">
                        Earth Quakes
                    </a>
                </div>
            </div>
        </div>
        <div id="map" class="grow lg:max-h-[60vh]"></div>
        <footer class="mt-auto px-4 py-6 bg-white">
            <p class="text-sm text-center">Created with 🍵 &copy; SIG - 2025</p>
        </footer>
    </div>

    <script>
        var map = L.map('map').setView([-0.955539, 120.137163], 5);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 5,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

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
</body>

</html>

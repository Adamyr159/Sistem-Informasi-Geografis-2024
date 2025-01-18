<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('page-title', 'Peta')</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @vite('resources/css/app.css')
</head>

<body class="bg-pattern">
    <div class="flex flex-col justify-stretch min-h-screen">
        @yield('content')
        <div id="map" class="grow"></div>
        <footer class="mt-auto px-4 py-6 bg-white">
            <p class="text-sm text-center">Created with 🍵 &copy; SIG - 2025</p>
        </footer>
    </div>

    <script>
        let latlong = @yield('latlong', '[-0.955539, 120.137163]');
        let zoom = @yield('zoom', 5);

        const map = L.map('map').setView(latlong, zoom);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    </script>
    @stack('scripts')
</body>

</html>

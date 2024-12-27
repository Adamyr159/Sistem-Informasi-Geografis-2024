<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Praktikum Leaflet</title>
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""
    />

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script
      src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
      integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
      crossorigin=""
    ></script>
  </head>
  <body>
    <div id="map" style="height: 100vh;"></div>

    <script>
      let map = L.map("map").setView([-6.4025, 106.7942], 10);

      L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 15,
        attribution:
          '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      }).addTo(map);

      let loi = {
        type: "FeatureCollection",
        features: [
          {
            type: "Feature",
            properties: {
              nama: "Jakarta",
              Populasi: "11.000.000 jiwa",
              Tahun: 2022,
              Luas: "662 km²",
            },
            geometry: {
              type: "Point",
              coordinates: [106.84513, -6.208763],
            },
            id: 0,
          },
          {
            type: "Feature",
            properties: {
              nama: "Bogor",
              Luas: "118,5 km²",
              Populasi: "1.131.401 jiwa",
              Tahun: 2022,
            },
            geometry: {
              type: "Point",
              coordinates: [106.806038, -6.595038],
            },
            id: 1,
          },
          {
            type: "Feature",
            properties: {
              nama: "Depok",
              Luas: "200,3 km²",
              Populasi: "2.251.974 jiwa",
              Tahun: 2022,
            },
            geometry: {
              type: "Point",
              coordinates: [106.831679, -6.402484],
            },
            id: 2,
          },
          {
            type: "Feature",
            properties: {
              nama: "Tangerang",
              Luas: "164,5 km²",
              Populasi: "2.041.677 jiwa",
              Tahun: 2022,
            },
            geometry: {
              type: "Point",
              coordinates: [106.629663, -6.178306],
            },
            id: 3,
          },
          {
            type: "Feature",
            properties: {
              nama: "Bekasi",
              Luas: "210,5 km²",
              Populasi: "2.643.292 jiwa",
              Tahun: 2022,
            },
            geometry: {
              type: "Point",
              coordinates: [106.989615, -6.23827],
            },
            id: 4,
          },
        ],
      };

      let geojson = L.geoJSON(loi, {
        onEachFeature: function (feature, layer) {
          let popupContent = `
            <b>Nama:</b> ${feature.properties.nama}<br>
            <b>Luas:</b> ${feature.properties.Luas}<br>
            <b>Populasi:</b> ${feature.properties.Populasi}<br>
            <b>Tahun:</b> ${feature.properties.Tahun}`;
          layer.bindPopup(popupContent);
        },
      }).addTo(map);
    </script>
  </body>
</html>

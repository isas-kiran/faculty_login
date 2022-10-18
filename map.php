<!--<link href="map_js/OSMBuildings.css" rel="stylesheet">
<script src="map_js/OSMBuildings.js"></script>
  <div id="map"></div>
  <script>
  var map = new OSMBuildings({
    container: 'map',
    position: { latitude: 52.52111, longitude: 13.41078 },
    zoom: 16,
    minZoom: 15,
    maxZoom: 20,
    effects: ['shadows'],
    attribution: '© Data <a href="https://openstreetmap.org/copyright/">OpenStreetMap</a> © Map <a href="https://mapbox.com/">Mapbox</a> © 3D <a href="https://osmbuildings.org/copyright/">OSM Buildings</a>'
  }).appendTo(document.getElementById('map'));
  map.addMapTiles('https://{s}.tiles.mapbox.com/v3/[YOUR_MAPBOX_KEY]/{z}/{x}/{y}.png');
  map.addGeoJSONTiles('https://{s}.data.osmbuildings.org/0.2/anonymous/tile/{z}/{x}/{y}.json');
  </script>-->
  <html>
  <head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js"></script>
  </head>
  
  <body>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css"
  integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
  crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js"
  integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q=="
  crossorigin=""></script>
  <!--<div style="position: relative">
    <div id="map" style="height: 400px"></div>
    <script>
      var map = L.Wrld.map("map", "00954be5ef4e60aea1d8590588a2d26b", {
        center: [18.539222, 73.896502],
        zoom: 18
      });
    </script>

  </div>-->
  </body>
</html>
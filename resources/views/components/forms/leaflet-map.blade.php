@push('script-head')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush
<div class="{{ $columnSpan }} mb-3">
  <label class="form-label" for="{{ $name }}">{{ $label }}</label>
  <button type="button" id="get-location-btn" class="btn btn-sm btn-label-primary"><i class="ti ti-map-pin me-1"></i>My Location</button>

  <div class="w-full border border-primary mt-1" style="border-radius: 1rem">
    <div class="m-1 rounded-2xl" id="map" style="height: 300px; border-radius: 1rem"></div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <label for="{{ $name }}_lat" class="form-label">Latitude</label>
      <input type="text" class="form-control" id="{{ $name }}_lat" name="{{ $name }}_lat" value="{{ $latitude ?? '-8.633209816941502' }}" />
    </div>
    <div class="col-md-6">
      <label for="{{ $name }}_lng" class="form-label">Longitude</label>
      <input type="text" class="form-control" id="{{ $name }}_lng" name="{{ $name }}_lng" value="{{ $longitude ?? '115.13727289555332' }}" />
    </div>
  </div>
</div>

@push('script-vendor')
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
@endpush

@push('script')
  <script>
    var map;
    $(document).ready(function() {
      // Default coordinates, if no latitude and longitude are provided
      let lat = {{ $latitude ?? '-8.633209816941502' }};
      let lng = {{ $longitude ?? '115.13727289555332' }};

      // Initialize map
      map = L.map('map').setView([lat, lng], 13);
      // getLiveLocation()

      // Add OpenStreetMap tile layer to the map
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      // Add a draggable marker to the map
      let marker = L.marker([lat, lng], {
        draggable: true
      }).addTo(map);

      var latitude = document.getElementById('{{ $name }}_lat');
      var longtitude = document.getElementById('{{ $name }}_lng');

      // Update hidden input fields when marker is dragged
      marker.on('dragend', function(e) {
        let position = e.target.getLatLng();
        latitude.value = position.lat;
        longtitude.value = position.lng;
      });

      // Get the live location of the user
      function getLiveLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            function(position) {
              // Get the current position (latitude, longitude, and accuracy)
              let currentLat = position.coords.latitude;
              let currentLng = position.coords.longitude;
              let accuracy = position.coords.accuracy; // Accuracy in meters

              // Set the map view to the user's current location and adjust zoom based on accuracy
              let zoomLevel = accuracy < 100 ? 15 : (accuracy < 500 ? 13 : 10); // Adjust zoom level
              map.setView([currentLat, currentLng], zoomLevel);

              // Move the marker to the user's current location
              marker.setLatLng([currentLat, currentLng]);

              // Update the hidden input fields with the current position
              latitude.value = currentLat;
              longtitude.value = currentLng;
            },
            function(error) {
              alert('Unable to retrieve your location.');
            }, {
              enableHighAccuracy: true, // Try to get the most accurate location
              timeout: 10000, // Timeout after 10 seconds if location is not found
              maximumAge: 0 // Don't use cached location
            }
          );
        } else {
          alert("Geolocation is not supported by this browser.");
        }
      }

      // Attach event listener to the 'Get My Location' button
      document.getElementById('get-location-btn').addEventListener('click', getLiveLocation);

      // Enable the user to manually move the marker and update hidden fields
      marker.on('dragend', function(e) {
        let position = e.target.getLatLng();
        latitude.value = position.lat;
        longtitude.value = position.lng;
      });

      map.on("click", function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        if (!marker) {
          marker = L.marker(e.latlng).addTo(map);
        } else {
          marker.setLatLng(e.latlng);
        }
        latitude.value = lat;
        longtitude.value = lng;
      });

    });
  </script>
@endpush

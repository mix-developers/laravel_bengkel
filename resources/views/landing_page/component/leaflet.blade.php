<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        getLocation();
    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var latitude = position.coords.latitude.toFixed(6);
        var longitude = position.coords.longitude.toFixed(6);

        // Tampilkan koordinat
        var coordinatesElement = document.getElementById("coordinates");
        coordinatesElement.innerHTML = "Latitude: " + latitude + "<br>Longitude: " + longitude;

        // Isi nilai input dengan koordinat
        document.getElementById("latitude").value = latitude;
        document.getElementById("longitude").value = longitude;
        initMap(latitude, longitude);
    }

    function initMap(latitude, longitude) {
        var map = L.map('map').setView([latitude, longitude], 20);

        L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
            maxZoom: 19,
        }).addTo(map);

        L.marker([latitude, longitude]).addTo(map)
            .bindPopup('Lokasi Anda')
            .openPopup();
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                console.log("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                console.log("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                console.log("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                console.log("An unknown error occurred.");
                break;
        }
    }
</script>

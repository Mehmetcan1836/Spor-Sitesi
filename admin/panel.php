<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Lokasyon Paneli + Harita</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 10px; }
        #map { height: 500px; width: 100%; margin-top: 20px; }
    </style>
</head>
<body>

<h2>Lokasyon Yönetimi + Harita</h2>
<p><a href="logout.php">Çıkış Yap</a></p>

<h3>Yeni Lokasyon Ekle</h3>
<input type="text" id="name" placeholder="Ad">
<input type="text" id="description" placeholder="Açıklama">
<input type="number" id="lat" placeholder="Enlem" step="any">
<input type="number" id="lng" placeholder="Boylam" step="any">
<button onclick="addLocation()">Ekle</button>

<h3>Lokasyonlar</h3>
<table id="locationsTable"></table>

<h3>Canlı Harita</h3>
<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
var map = L.map('map').setView([39.925533, 32.866287], 6); // Türkiye merkezi
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

var markers = [];

function clearMarkers() {
    markers.forEach(m => map.removeLayer(m));
    markers = [];
}

function loadLocations() {
    fetch('../api/locations.php')
        .then(r => r.json())
        .then(data => {
            let table = `<tr><th>ID</th><th>Ad</th><th>Açıklama</th><th>Enlem</th><th>Boylam</th><th>İşlemler</th></tr>`;
            clearMarkers();
            data.forEach(loc => {
                table += `<tr>
                    <td>${loc.id}</td>
                    <td><input value="${loc.name}" id="name_${loc.id}"></td>
                    <td><input value="${loc.description}" id="desc_${loc.id}"></td>
                    <td><input type="number" value="${loc.lat}" id="lat_${loc.id}" step="any"></td>
                    <td><input type="number" value="${loc.lng}" id="lng_${loc.id}" step="any"></td>
                    <td>
                        <button onclick="updateLocation(${loc.id})">Güncelle</button>
                        <button onclick="deleteLocation(${loc.id})">Sil</button>
                    </td>
                </tr>`;

                let marker = L.marker([loc.lat, loc.lng]).addTo(map)
                    .bindPopup(`<b>${loc.name}</b><br>${loc.description}<br><a href="https://www.google.com/maps/dir/?api=1&destination=${loc.lat},${loc.lng}" target="_blank">Yol Tarifi</a>`);
                markers.push(marker);
            });
            document.getElementById('locationsTable').innerHTML = table;
        });
}

function addLocation() {
    const formData = new FormData();
    formData.append('id', Date.now());
    formData.append('name', document.getElementById('name').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('lat', document.getElementById('lat').value);
    formData.append('lng', document.getElementById('lng').value);

    fetch('../api/update_location.php', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                loadLocations();
            } else {
                alert("Hata: " + res.error);
            }
        });
}

function deleteLocation(id) {
    if (confirm("Silmek istediğinize emin misiniz?")) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('../api/delete_location.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    loadLocations();
                }
            });
    }
}

function updateLocation(id) {
    const formData = new FormData();
    formData.append('id', id);
    formData.append('name', document.getElementById(`name_${id}`).value);
    formData.append('description', document.getElementById(`desc_${id}`).value);
    formData.append('lat', document.getElementById(`lat_${id}`).value);
    formData.append('lng', document.getElementById(`lng_${id}`).value);

    fetch('../api/update_location.php', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                loadLocations();
            }
        });
}

loadLocations();
</script>

</body>
</html>

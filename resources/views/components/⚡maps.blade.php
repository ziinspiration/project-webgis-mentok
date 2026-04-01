<div wire:ignore>
    <div id="map" style="height: 500px;"></div>

  <script>

    function initMap() {

        if (window.map != undefined) { window.map.remove(); }

        window.map = L.map('map').setView([-2.065, 105.168], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(window.map);

        L.marker([-2.065, 105.168]).addTo(window.map)
            .bindPopup('Mentok, Bangka Barat')
            .openPopup();
    }

    document.addEventListener('DOMContentLoaded', initMap);
    document.addEventListener('livewire:navigated', initMap);
</script>
</div>

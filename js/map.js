document.addEventListener('DOMContentLoaded', function () {
    // Initialiser la carte
    const map = L.map('mapid', {
      center: [49.44218, 1.093852],
      zoom: 17,
  });
  
    // Ajouter les tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
  
    // Icône bleue pour les crèches normales
    let redIcon = L.icon({
      /*className: 'custom-icon',*/
      iconUrl: 'assets/images/red-marker.png',
      iconSize: [24, 24],
      iconAnchor: [12, 24]
    });
  
    // Ajouter un marqueur avec l'icône Font Awesome
    L.marker([49.44218, 1.093852], { icon: redIcon }).addTo(map)
        .bindPopup("25 rue Saint-Lô, Rouen, France");
  });
  
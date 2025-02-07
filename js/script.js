document.addEventListener('DOMContentLoaded', function () {
  // Initialiser la carte
  const map = L.map('mapid', {
    center: [49.44218, 1.093852],
    zoom: 18,
    zoomControl: false, // Désactiver le contrôle du zoom
    scrollWheelZoom: false // Désactiver le zoom par la molette de la souris
});

  // Ajouter les tuiles OpenStreetMap
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  // Créer une icône DivIcon personnalisée
  const awesomeDivIcon = L.divIcon({
    html: '<i class="fa fa-map-marker-alt"></i>',
    className: 'custom-div-icon',
    iconAnchor: [15, 42], 
    popupAnchor: [0, -42] 
  });

  // Ajouter un marqueur avec l'icône Font Awesome
  L.marker([49.44218, 1.093852], { icon: awesomeDivIcon }).addTo(map)
      .bindPopup("25 rue Saint-Lô, Rouen, France");
});

document.addEventListener('DOMContentLoaded', function() {
  const navbar = document.getElementById('mainNavbar')
  if (navbar) {
      const navbarToggler = navbar.querySelector('.navbar-toggler')
      const navbarCollapse = navbar.querySelector('.navbar-collapse')

      if (navbarToggler && navbarCollapse) {
          document.addEventListener('click', function(event) {
              if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                  const isClickInside = navbar.contains(event.target)
                  if (!isClickInside) {
                      navbarToggler.click()
                  }
              }
          })
      }
  }
})


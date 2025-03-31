document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('mainNavbar');
    if (navbar) {
        const navbarToggler = navbar.querySelector('.navbar-toggler');
        const navbarCollapse = navbar.querySelector('.navbar-collapse');

        if (navbarToggler && navbarCollapse) {
            // Ouvre/ferme le menu lorsque le bouton est cliqué
            navbarToggler.addEventListener('click', function() {
                navbarCollapse.classList.toggle('show');
            });

            // Ferme le menu lorsque l'on clique en dehors
            document.addEventListener('click', function(event) {
                // Si on est sur une largeur d'écran plus petite que 992px
                if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                    // Vérifie si le clic est en dehors du menu
                    const isClickInside = navbar.contains(event.target);
                    if (!isClickInside) {
                        navbarCollapse.classList.remove('show'); // Ferme le menu
                    }
                }
            });
        }
    }
});



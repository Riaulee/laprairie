function activeNavQuiSommesNous() {
    // Obtenez l'URL de la page actuelle
  var currentURL = window.location.href;

  // Vérifiez si l'URL correspond à celle du lien "Qui sommes-nous?"
  if (currentURL.includes("app_quisommesnous")) {
    document.getElementById('navQuiSommeNous').classList.add('active');
  }
};

function activeNav(elementId) {
  // Réinitialisez la classe "active" pour tous les éléments de navigation
  var navLinks = document.getElementsByClassName('nav-link');
  for (var i = 0; i < navLinks.length; i++) {
    navLinks[i].classList.remove('active');
  }

  // Ajoutez la classe "active" à l'élément de navigation cliqué
  document.getElementById(elementId).classList.add('active');
}

function activeNavActualite() {
    document.getElementById('navActualite').className='nav-link active'
}

function activePassezALAction() {
    document.getElementById('navPassezALAction').className='nav-link active'
}
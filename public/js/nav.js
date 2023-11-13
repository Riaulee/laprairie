
function activeNav(event) {
  // Réinitialisez la classe "active" pour tous les éléments de navigation
  // var navLinks = document.getElementsByClassName('nav-link');
  // for (var i = 0; i < navLinks.length; i++) {
  //   navLinks[i].classList.remove('active');
  //}
  // Ajoutez la classe "active" à l'élément de navigation cliqué
  console.log(event.target);
  event.target.classList.add('active');
}

addEventListener("DOMContentLoaded", (event) => {
  document.getElementById("navQuiSommeNous").addEventListener("click", activeNav);

});




function activeNavActualite() {
    document.getElementById('navActualite').className='nav-link active'
}

function activePassezALAction() {
    document.getElementById('navPassezALAction').className='nav-link active'
}
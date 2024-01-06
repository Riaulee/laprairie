// Sélectionne tous les éléments de message flash avec la classe CSS appropriée
var flashMessages = document.querySelectorAll('.alert');

// Parcoure chaque élément de message flash
flashMessages.forEach(function(flashMessage) {
    // Masque l'élément après 5 secondes
    setTimeout(function() {
        flashMessage.style.display = 'none';
    }, 5000); // 5000 millisecondes = 5 secondes
});

function scrollKrousel(direction, carouselId) {
    var container = document.querySelector('#' + carouselId);
    var scrollAmount = 230; // La largeur d'un élément de la liste, peut-être ajustée

    // La position maximale que le conteneur peut défiler sur la gauche (correspondant à l'extrémité droite).
    var maxScrollLeft = container.scrollWidth - container.clientWidth;

    if (direction === 'left') {
        // Si l'utilisateur est tout à gauche, défiler jusqu'à la toute fin.
        if (container.scrollLeft === 0) {
            container.scrollTo({
                top: 0,
                left: maxScrollLeft,
                behavior: 'smooth'
            });
        } else {
            // Défilement standard vers la gauche.
            container.scrollTo({
                top: 0,
                left: container.scrollLeft - scrollAmount,
                behavior: 'smooth'
            });
        }
    } else if (direction === 'right') {
        // Si l'utilisateur est tout à droite, revenir au début.
        if (container.scrollLeft === maxScrollLeft) {
            container.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        } else {
            // Défilement standard vers la droite.
            container.scrollTo({
                top: 0,
                left: container.scrollLeft + scrollAmount,
                behavior: 'smooth'
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
  checkArrowsForAllCarousels();
});

window.addEventListener('resize', function() {
  checkArrowsForAllCarousels();
});

function checkArrowsForAllCarousels() {
  var carousels = document.querySelectorAll('.ssjinstinct');

  carousels.forEach(function(carousel) {
    checkArrowVisibility(carousel);
  });
}

function checkArrowVisibility(carousel) {
  var items = carousel.querySelectorAll('li'),
      totalWidth = 0,
      ulElement = carousel.querySelector('ul'); // Sélectionne la liste <ul> correspondante

  items.forEach(function(item) {
    totalWidth += item.offsetWidth; // Ajoute la largeur de chaque élément à la largeur totale
  });

  // Flèches de navigation
  var leftArrow = carousel.querySelector('.ssj24-left-arrow'),
      rightArrow = carousel.querySelector('.ssj24-right-arrow');

  // Affiche ou masque les flèches selon que le contenu déborde ou non
  if (totalWidth > carousel.offsetWidth) {
    // Le contenu est plus large que le conteneur, afficher les flèches
    if(leftArrow) leftArrow.style.display = 'block';
    if(rightArrow) rightArrow.style.display = 'block';
    // S'assurer que le conteneur <ul> permet le défilement
    if(ulElement) ulElement.style.overflowX = 'scroll';
  } else {
    // Le contenu tient dans le conteneur, masquer les flèches
    if(leftArrow) leftArrow.style.display = 'none';
    if(rightArrow) rightArrow.style.display = 'none';
    // Passer le style de défilement du conteneur <ul> à initial
    if(ulElement) ulElement.style.overflowX = 'initial';
  }
}
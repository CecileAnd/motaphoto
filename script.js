document.addEventListener('DOMContentLoaded', function () {
  const cartes = Array.from(document.querySelectorAll('.carte'));
  const grille = document.querySelector('.grille-images');
  const btnChargerPlus = document.getElementById('btn-charger-plus');

  const selectCategorie = document.getElementById('filtre-categorie');
  const selectFormat = document.getElementById('filtre-format');
  const selectTri = document.getElementById('filtre-tri');

  // Masquer toutes sauf les 8 premières au chargement
  function afficherCartesInitiales() {
    cartes.forEach((carte, index) => {
      carte.style.display = index < 8 ? 'block' : 'none';
    });
    btnChargerPlus.style.display = cartes.length > 8 ? 'block' : 'none';
  }

  afficherCartesInitiales();

  // Charger toutes les cartes
  btnChargerPlus.addEventListener('click', () => {
    cartes.forEach(carte => (carte.style.display = 'block'));
    btnChargerPlus.style.display = 'none';
  });

  // Appliquer les filtres et le tri
  function appliquerFiltresEtTri() {
    let filteredCards = cartes;

    const selectedCategorie = selectCategorie.value;
    const selectedFormat = selectFormat.value;
    const selectedTri = selectTri.value;

    // Filtres
    if (selectedCategorie) {
      filteredCards = filteredCards.filter(card => card.dataset.categorie === selectedCategorie);
    }

    if (selectedFormat) {
      filteredCards = filteredCards.filter(card => card.dataset.format === selectedFormat);
    }

    // Tri
    filteredCards.sort((a, b) => {
      const dateA = new Date(a.dataset.date);
      const dateB = new Date(b.dataset.date);
      return selectedTri === 'ancienne' ? dateA - dateB : dateB - dateA;
    });

    // Affichage : masquer toutes puis afficher celles filtrées
    cartes.forEach(carte => (carte.style.display = 'none'));
    filteredCards.forEach(carte => (carte.style.display = 'block'));

    // Réorganiser visuellement dans le DOM
    filteredCards.forEach(carte => grille.appendChild(carte));

    // Cacher le bouton si toutes les cartes sont affichées
    btnChargerPlus.style.display = filteredCards.length <= 8 ? 'none' : 'block';
  }

  // Écouteurs sur les filtres
  selectCategorie.addEventListener('change', appliquerFiltresEtTri);
  selectFormat.addEventListener('change', appliquerFiltresEtTri);
  selectTri.addEventListener('change', appliquerFiltresEtTri);
});

document.addEventListener('DOMContentLoaded', function () {
  const cartes = Array.from(document.querySelectorAll('.carte'));
  const grille = document.querySelector('.grille-images');
  const btnChargerPlus = document.getElementById('btn-charger-plus');

  const filtres = document.querySelectorAll('.filtres');
  const zoneFiltres = document.querySelector('.zone-filtres');

  let cartesFiltrees = [];
  let limiteAffichage = 8;

  // filtres sélectionnés
  let filtreCategorie = "";
  let filtreFormat = "";
  let filtreTri = "recente";

  // afficher cartes filtrées et triées
  function appliquerFiltresEtTri() {
    cartesFiltrees = cartes.filter(carte => {
      const cat = carte.dataset.categorie;
      const fmt = carte.dataset.format;
      const matchCat = !filtreCategorie || cat === filtreCategorie;
      const matchFmt = !filtreFormat || fmt === filtreFormat;
      return matchCat && matchFmt;
    });

    cartesFiltrees.sort((a, b) => {
      const dateA = new Date(a.dataset.date);
      const dateB = new Date(b.dataset.date);
      return filtreTri === 'ancienne' ? dateA - dateB : dateB - dateA;
    });

    afficherCartesLimite(limiteAffichage);
  }

  function afficherCartesLimite(nb) {
    cartes.forEach(carte => carte.style.display = 'none');
    cartesFiltrees.forEach((carte, index) => {
      if (index < nb) {
        carte.style.display = 'block';
        grille.appendChild(carte);
      }
    });
    btnChargerPlus.style.display = cartesFiltrees.length > nb ? 'block' : 'none';
  }

  // bouton "Charger plus"
  btnChargerPlus.addEventListener('click', () => {
    limiteAffichage = cartesFiltrees.length;
    afficherCartesLimite(limiteAffichage);
  });

  // filtres déroulants
  filtres.forEach(filtre => {
    const btn = filtre.querySelector('.filtre-bouton');
    const options = filtre.querySelector('.filtre-options');

    btn.addEventListener('click', e => {
      e.stopPropagation();
      filtres.forEach(f => f !== filtre && f.classList.remove('open'));
      filtre.classList.toggle('open');
    });

    options.querySelectorAll('li').forEach(option => {
      option.addEventListener('click', e => {
        e.stopPropagation();
        const valeur = option.getAttribute('data-value');
        btn.innerHTML = option.textContent + ' <span class="chevron">▼</span>';

        const typeFiltre = filtre.getAttribute('data-filtre');
        if (typeFiltre === 'categorie') filtreCategorie = valeur;
        else if (typeFiltre === 'format') filtreFormat = valeur;
        else if (typeFiltre === 'tri') filtreTri = valeur;

        filtre.classList.remove('open');
        limiteAffichage = 8;
        appliquerFiltresEtTri();
      });
    });
  });

  // fermer les menus si clic ailleurs
  document.addEventListener('click', () => {
    filtres.forEach(f => f.classList.remove('open'));
  });

  appliquerFiltresEtTri();
});


// menu burger
document.addEventListener('DOMContentLoaded', () => {
  const burgerBtn = document.querySelector('.burger-menu');
  const menu = document.querySelector('.menu');

  // créer une croix à partir du bouton burger
  function updateBurgerIcon() {
    burgerBtn.textContent = menu.classList.contains('actif') ? '✕' : '☰';
  }

  burgerBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('actif');
    updateBurgerIcon();
  });

  // fermer le menu si clic en dehors
  document.addEventListener('click', (e) => {
    if (menu.classList.contains('actif') &&
        !menu.contains(e.target) &&
        !burgerBtn.contains(e.target)) {
      menu.classList.remove('actif');
      updateBurgerIcon();
    }
  });

const contactLink = document.getElementById("contact-link");
const modal = document.getElementById("modal");
const closeModalButton = modal.querySelector(".close-modal");

contactLink.addEventListener("click", (e) => {
  e.preventDefault(); // Empêche le lien de changer de page
  modal.classList.add("active");
});

closeModalButton.addEventListener("click", () => {
  modal.classList.remove("active");
});

modal.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.classList.remove("active");
  }
});

document.querySelectorAll('.carte').forEach(carte => {
  // création des éléments
  const iconeOeil = document.createElement('div');
  iconeOeil.className = 'icone-oeil';
  iconeOeil.innerHTML = '👁'; 

  const iconeFull = document.createElement('div');
  iconeFull.className = 'icone-fullscreen';
  iconeFull.innerHTML = '⛶'; 

  const infosBas = document.createElement('div');
  infosBas.className = 'infos-bas';
  const titre = carte.querySelector('img').alt;
  const categorie = carte.dataset.categorie;
  infosBas.innerHTML = `<span>${titre.toUpperCase()}</span><span>${categorie.toUpperCase()}</span>`;

  // insertion dans la carte
  carte.appendChild(iconeOeil);
  carte.appendChild(iconeFull);
  carte.appendChild(infosBas);
});

});

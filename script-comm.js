// Attendre que le DOM soit entièrement chargé avant d'exécuter le script
document.addEventListener('DOMContentLoaded', function () {

  // Récupère toutes les cartes (éléments avec la classe .carte) sous forme de tableau
  const cartes = Array.from(document.querySelectorAll('.carte'));

  // Récupère la grille qui contient les cartes
  const grille = document.querySelector('.grille-images');

  // Récupère le bouton "Charger plus"
  const btnChargerPlus = document.getElementById('btn-charger-plus');

  // Récupère tous les blocs de filtres et la zone globale des filtres
  const filtres = document.querySelectorAll('.filtres');
  const zoneFiltres = document.querySelector('.zone-filtres');

  // Liste des cartes après filtrage
  let cartesFiltrees = [];

  // Nombre de cartes à afficher initialement
  let limiteAffichage = 8;

  // Variables pour stocker les filtres sélectionnés
  let filtreCategorie = "";
  let filtreFormat = "";
  let filtreTri = ""; // Par défaut : tri par numéro d’image

  // Fonction qui filtre et trie les cartes
  function appliquerFiltresEtTri() {
    cartesFiltrees = cartes.filter(carte => {
      const cat = carte.dataset.categorie;
      const fmt = carte.dataset.format;

      // Vérifie si la carte correspond aux filtres (ou si le filtre est vide)
      const matchCat = !filtreCategorie || cat === filtreCategorie;
      const matchFmt = !filtreFormat || fmt === filtreFormat;

      return matchCat && matchFmt;
    });

    // Trie selon la date si le filtre tri est activé
    if (filtreTri === 'ancienne' || filtreTri === 'recente') {
      cartesFiltrees.sort((a, b) => {
        const dateA = new Date(a.dataset.date);
        const dateB = new Date(b.dataset.date);
        return filtreTri === 'ancienne' ? dateA - dateB : dateB - dateA;
      });
    } else {
      // Trie par numéro dans le nom du fichier image
      cartesFiltrees.sort((a, b) => {
        const getNumeroImage = (carte) => {
          const img = carte.querySelector('img');
          const src = img ? img.getAttribute('src') : '';
          const match = src.match(/nathalie-(\d+)\.jpe?g/i);
          return match ? parseInt(match[1], 10) : 0;
        };
        return getNumeroImage(a) - getNumeroImage(b);
      });
    }

    // Affiche les cartes filtrées, en respectant la limite
    afficherCartesLimite(limiteAffichage);
  }

  // Affiche seulement un nombre donné de cartes
  function afficherCartesLimite(nb) {
    // Cache toutes les cartes
    cartes.forEach(carte => carte.style.display = 'none');

    // Affiche seulement les nb premières cartes filtrées
    cartesFiltrees.forEach((carte, index) => {
      if (index < nb) {
        carte.style.display = 'block';
        grille.appendChild(carte); // Déplace la carte dans la grille
      }
    });

    // Affiche ou cache le bouton "Charger plus" selon le nombre de cartes restantes
    btnChargerPlus.style.display = cartesFiltrees.length > nb ? 'block' : 'none';
  }

  // Quand on clique sur "Charger plus"
  btnChargerPlus.addEventListener('click', () => {
    limiteAffichage = cartesFiltrees.length; // Affiche tout
    afficherCartesLimite(limiteAffichage);
  });

  // Gestion des filtres déroulants
  filtres.forEach(filtre => {
    const btn = filtre.querySelector('.filtre-bouton');
    const options = filtre.querySelector('.filtre-options');

    // Ouvrir ou fermer le menu de filtres au clic
    btn.addEventListener('click', e => {
      e.stopPropagation(); // Empêche la fermeture immédiate
      // Ferme les autres menus
      filtres.forEach(f => f !== filtre && f.classList.remove('open'));
      // Ouvre ou ferme le menu actuel
      filtre.classList.toggle('open');
    });

    // Quand on clique sur une option du filtre
    options.querySelectorAll('li').forEach(option => {
      option.addEventListener('click', e => {
        e.stopPropagation();
        const valeur = option.getAttribute('data-value');
        btn.innerHTML = option.textContent + ' <span class="chevron">⌄</span>';

        // Met à jour le filtre sélectionné
        const typeFiltre = filtre.getAttribute('data-filtre');
        if (typeFiltre === 'categorie') filtreCategorie = valeur;
        else if (typeFiltre === 'format') filtreFormat = valeur;
        else if (typeFiltre === 'tri') filtreTri = valeur;

        filtre.classList.remove('open');
        limiteAffichage = 8; // Réinitialise l’affichage
        appliquerFiltresEtTri();
      });
    });
  });

  // Ferme tous les menus si on clique ailleurs
  document.addEventListener('click', () => {
    filtres.forEach(f => f.classList.remove('open'));
  });

  // Lancement initial du filtrage
  appliquerFiltresEtTri();
});

// Gère le comportement du menu burger
document.addEventListener('DOMContentLoaded', () => {
  const burgerBtn = document.querySelector('.burger-menu');
  const menu = document.querySelector('.menu');

  // Change le symbole du bouton burger
  function updateBurgerIcon() {
    burgerBtn.textContent = menu.classList.contains('actif') ? '✕' : '☰';
  }

  // Ouvre ou ferme le menu quand on clique sur le burger
  burgerBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('actif');
    updateBurgerIcon();
  });

  // Ferme le menu si on clique en dehors
  document.addEventListener('click', (e) => {
    if (menu.classList.contains('actif') &&
        !menu.contains(e.target) &&
        !burgerBtn.contains(e.target)) {
      menu.classList.remove('actif');
      updateBurgerIcon();
    }
  });

  // Gestion de la modale contact
  const contactLink = document.getElementById("contact-link");
  const modal = document.getElementById("modal");
  const closeModalButton = modal.querySelector(".close-modal");

  // Ouvre la modale
  contactLink.addEventListener("click", (e) => {
    e.preventDefault();
    modal.classList.add("active");
  });

  // Ferme la modale avec le bouton
  closeModalButton.addEventListener("click", () => {
    modal.classList.remove("active");
  });

  // Ferme la modale en cliquant sur le fond
  modal.addEventListener("click", (event) => {
    if (event.target === modal) {
      modal.classList.remove("active");
    }
  });

  // Ajoute des icônes et infos en bas de chaque carte
  document.querySelectorAll('.carte').forEach(carte => {
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

    carte.appendChild(iconeOeil);
    carte.appendChild(iconeFull);
    carte.appendChild(infosBas);
  });
});
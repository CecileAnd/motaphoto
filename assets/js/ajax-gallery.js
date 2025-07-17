document.addEventListener('DOMContentLoaded', function () {
  let currentPage = 1;
  let loading = false;

  const filterState = {
    categorie: '',
    format: '',
    tri: 'date_desc'
  };

  function getFilters() {
    return { ...filterState };
  }

  function loadPhotos(isNewFilter = false) {
    if (loading) return;
    loading = true;

    const photoResults = document.getElementById('photo-results');
    const loadMoreBtn = document.getElementById('load-more');

    if (isNewFilter) {
      currentPage = 1;
      photoResults.innerHTML = '';
      if (loadMoreBtn) loadMoreBtn.style.display = 'block';
    } else {
      currentPage++;
    }

    const filters = getFilters();
    const data = new URLSearchParams();
    data.append('action', 'load_photos');
    data.append('nonce', ajaxGallery.nonce);
    data.append('page', currentPage);
    data.append('categorie', filters.categorie);
    data.append('format', filters.format);
    data.append('tri', filters.tri);

    fetch(ajaxGallery.ajaxurl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: data.toString(),
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.success && response.data.html.trim() !== '') {
          photoResults.insertAdjacentHTML('beforeend', response.data.html);

          if (typeof lightbox !== 'undefined') {
            lightbox.init();
          }

          // ✅ Mise à jour des miniatures par défaut après ajout au DOM
          if (typeof mettreAJourMiniatureParDefaut === 'function') {
            mettreAJourMiniatureParDefaut();
          }

          if (loadMoreBtn) {
            loadMoreBtn.style.display = response.data.has_more ? 'block' : 'none';
          }
        } else {
          if (currentPage === 1) {
            photoResults.innerHTML = '<p>Aucune photo trouvée.</p>';
          }
          if (loadMoreBtn) loadMoreBtn.style.display = 'none';
        }
      })
      .catch(() => {
        alert('Une erreur est survenue lors du chargement des photos.');
      })
      .finally(() => {
        loading = false;
      });
  }

  // Bouton "Charger plus"
  const loadMoreBtn = document.getElementById('load-more');
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', () => loadPhotos(false));
  }

  // Filtres personnalisés
  document.querySelectorAll('.filtres').forEach((filterWrapper) => {
    const button = filterWrapper.querySelector('.filtre-bouton');
    const options = filterWrapper.querySelectorAll('.filtre-options li');
    const filterType = filterWrapper.getAttribute('data-filter');

    button.addEventListener('click', () => {
      document.querySelectorAll('.filtres').forEach(f => {
        if (f !== filterWrapper) f.classList.remove('open');
      });
      filterWrapper.classList.toggle('open');
    });

    options.forEach((option) => {
      option.addEventListener('click', () => {
        filterState[filterType] = option.getAttribute('data-value') || '';
        button.querySelector('.filtre-titre').textContent = option.textContent;
        filterWrapper.classList.remove('open');
        loadPhotos(true);
      });
    });
  });

  // Fermer les menus au clic hors filtre
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.filtres')) {
      document.querySelectorAll('.filtres').forEach(f => f.classList.remove('open'));
    }
  });

  // Chargement initial
  loadPhotos(true);
});

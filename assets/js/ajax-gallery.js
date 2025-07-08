document.addEventListener('DOMContentLoaded', function () {
  let currentPage = 1;
  let loading = false;

  function getFilters() {
    return {
      categorie: jQuery('#categorie').val() || '',
      format: jQuery('#format').val() || '',
      tri: jQuery('#tri').val() || 'date_desc',
    };
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
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: data.toString(),
    })
      .then((response) => response.json())
      .then((response) => {
        if (response.success && response.data.html.trim() !== '') {
          photoResults.insertAdjacentHTML('beforeend', response.data.html);
          // Réinitialiser Lightbox2
          if (window.lightbox) {
          lightbox.init(); // recharge les images avec data-lightbox
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

  // Gestion bouton "Charger plus"
  const loadMoreBtn = document.getElementById('load-more');
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function () {
      loadPhotos(false);
    });
  }

  // Gestion filtres Select2 avec jQuery
  ['categorie', 'format', 'tri'].forEach((id) => {
    const element = jQuery('#' + id);
    if (element.length) {
      element.on('change', function () {
        loadPhotos(true);
      });
    }
  });
});

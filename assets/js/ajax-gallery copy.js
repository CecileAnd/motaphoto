document.addEventListener('DOMContentLoaded', function () {
  let currentPage = 1;
  let loading = false;

  function getFilters() {
    return {
      categorie: document.getElementById('categorie')?.value || '',
      format: document.getElementById('format')?.value || '',
      tri: document.getElementById('tri')?.value || 'date_desc',
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
      loadMoreBtn.style.display = 'block';
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
          loadMoreBtn.style.display = response.data.has_more ? 'block' : 'none';
        } else {
          if (currentPage === 1) {
            photoResults.innerHTML = '<p>Aucune photo trouvée.</p>';
          }
          loadMoreBtn.style.display = 'none';
        }
      })
      .catch(() => {
        alert('Une erreur est survenue lors du chargement des photos.');
      })
      .finally(() => {
        loading = false;
      });
  }

  const loadMoreBtn = document.getElementById('load-more');
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function () {
      loadPhotos(false);
    });
  }

  ['categorie', 'format', 'tri'].forEach((id) => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('change', function () {
        loadPhotos(true);
      });
    }
  });
});

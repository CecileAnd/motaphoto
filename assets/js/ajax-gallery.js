jQuery(document).ready(function ($) {
  let currentPage = 1; // page courante (1 déjà chargée)
  let loading = false;

  // Récupérer les valeurs des filtres
  function getFilters() {
    return {
      categorie: $('#categorie').val() || '',
      format: $('#format').val() || '',
      tri: $('#tri').val() || 'date_desc',
    };
  }

  // Charger les photos via AJAX
  function loadPhotos(isNewFilter = false) {
    if (loading) return; // éviter appels multiples
    loading = true;

    if (isNewFilter) {
      currentPage = 1;
      $('#photo-results').empty();
      $('#load-more').show();
    } else {
      currentPage++;
    }

    const filters = getFilters();

    $.ajax({
      url: ajaxGallery.ajaxurl,  // attention à ajaxGallery, pas mota_ajax
      type: 'POST',
      data: {
        action: 'load_photos',       // doit correspondre à la fonction PHP
        nonce: ajaxGallery.nonce,
        page: currentPage,
        categorie: filters.categorie,
        format: filters.format,
        tri: filters.tri,
      },
      success: function (response) {
        if (response.success && response.data.html.trim() !== '') {
          $('#photo-results').append(response.data.html);

          if (!response.data.has_more) {
            $('#load-more').hide();
          } else {
            $('#load-more').show();
          }
        } else {
          // Pas de résultats
          if (currentPage === 1) {
            $('#photo-results').html('<p>Aucune photo trouvée.</p>');
          }
          $('#load-more').hide();
        }
      },
      error: function () {
        alert('Une erreur est survenue lors du chargement des photos.');
      },
      complete: function () {
        loading = false;
      },
    });
  }

  // Clic sur "Charger plus"
  $('#load-more').on('click', function () {
    loadPhotos(false);
  });

  // Changement filtres recharge galerie
  $('#categorie, #format, #tri').on('change', function () {
    loadPhotos(true);
  });
});

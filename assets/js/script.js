document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('.filtre-select');
    const photos = document.querySelectorAll('.colonnes-images article');

    // Filtres JS pur (pour photos déjà chargées dans le DOM)
    function filtrePhotos() {
        const filtreCategorie = document.getElementById('filtre-categorie')?.value || '';
        const filtreAnnee = document.getElementById('filtre-annee')?.value || '';
        const filtreFormat = document.getElementById('filtre-format')?.value || '';
        const filtreType = document.getElementById('filtre-type')?.value || '';

        photos.forEach(photo => {
            const cat = photo.getAttribute('data-categorie');
            const annee = photo.getAttribute('data-annee');
            const format = photo.getAttribute('data-format');
            const type = photo.getAttribute('data-type');

            let show = true;
            if (filtreCategorie && filtreCategorie !== cat) show = false;
            if (filtreAnnee && filtreAnnee !== annee) show = false;
            if (filtreFormat && filtreFormat !== format) show = false;
            if (filtreType && filtreType !== type) show = false;

            photo.style.display = show ? 'block' : 'none';
        });
    }

    selects.forEach(select => {
        select.addEventListener('change', filtrePhotos);
    });

    // Filtres et pagination via AJAX
    const categorie = document.getElementById('categorie');
    const format = document.getElementById('format');
    const tri = document.getElementById('tri');
    const loadMoreBtn = document.getElementById('load-more');
    let paged = 2;

    // Chemin AJAX (à passer depuis WP via localisation JS)
    const ajaxurl = window.ajaxurl || '/wp-admin/admin-ajax.php';

    [categorie, format, tri].forEach(el => {
        if (el) {
            el.addEventListener('change', function () {
                const data = {
                    action: 'filter_photos',
                    categorie: categorie?.value || '',
                    format: format?.value || '',
                    tri: tri?.value || ''
                };

                fetch(ajaxurl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams(data)
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('photo-results').innerHTML = html;
                    paged = 2; // reset la pagination
                });
            });
        }
    });

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            const data = {
                action: 'load_more_photos',
                paged: paged,
                categorie: categorie?.value || '',
                format: format?.value || '',
                tri: tri?.value || ''
            };

            fetch(ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(data)
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('photo-results').insertAdjacentHTML('beforeend', html);
                paged++;
            });
        });
    }
});

jQuery(document).ready(function($){
    let paged = 1;
    const btnLoadMore = $('#load-more');
    const container = $('#photos-container');
    const filterCategorie = $('#filter-categorie');
    const filterFormat = $('#filter-format');

    function loadPhotos(reset = false) {
        if (reset) {
            paged = 1;
            container.html('');
        }

        $.ajax({
            url: mota_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mota_load_photos',
                nonce: mota_ajax.nonce,
                paged: paged,
                categorie: filterCategorie.val(),
                format: filterFormat.val(),
            },
            success: function(html) {
                if (html.trim().length) {
                    container.append(html);
                    btnLoadMore.show();
                    paged++;
                } else {
                    btnLoadMore.hide();
                }
            }
        });
    }

    filterCategorie.on('change', () => loadPhotos(true));
    filterFormat.on('change', () => loadPhotos(true));
    btnLoadMore.on('click', () => loadPhotos());

    loadPhotos();
});

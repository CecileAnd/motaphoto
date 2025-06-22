<?php
/**
 * Template Name: Galerie Photos AJAX
 */

get_header(); 

// Récupère les taxonomies pour les filtres
$categories = get_terms(['taxonomy' => 'photo_categorie', 'hide_empty' => false]);
$formats = get_terms(['taxonomy' => 'photo_format', 'hide_empty' => false]);
?>

<div class="zone-filtres">
    <div class="filtres-gauche">
        <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
            <div class="filtres">
                <label for="filter-categorie">Catégorie</label>
                <select id="filter-categorie" name="categorie">
                    <option value="">Toutes catégories</option>
                    <?php foreach ($categories as $cat) : ?>
                        <option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if (!empty($formats) && !is_wp_error($formats)) : ?>
            <div class="filtres">
                <label for="filter-format">Format</label>
                <select id="filter-format" name="format">
                    <option value="">Tous formats</option>
                    <?php foreach ($formats as $format) : ?>
                        <option value="<?php echo esc_attr($format->slug); ?>"><?php echo esc_html($format->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
    </div>
</div>

<div id="photos-container" class="colonnes-images">
    <!-- Les photos chargées via AJAX apparaîtront ici -->
</div>

<button id="load-more" style="display:none;">Charger plus</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let paged = 1;
    const btnLoadMore = document.getElementById('load-more');
    const container = document.getElementById('photos-container');
    const filterCategorie = document.getElementById('filter-categorie');
    const filterFormat = document.getElementById('filter-format');

    function loadPhotos(reset = false) {
        if (reset) {
            paged = 1;
            container.innerHTML = '';
        }

        const data = new FormData();
        data.append('action', 'mota_load_photos');
        data.append('nonce', '<?php echo wp_create_nonce("mota_ajax_nonce"); ?>');
        data.append('paged', paged);
        data.append('categorie', filterCategorie.value);
        data.append('format', filterFormat.value);

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            credentials: 'same-origin',
            body: data
        })
        .then(response => response.text())
        .then(html => {
            if (html.trim().length > 0) {
                container.insertAdjacentHTML('beforeend', html);
                btnLoadMore.style.display = 'block';
                paged++;
            } else {
                btnLoadMore.style.display = 'none';
            }
        });
    }

    filterCategorie.addEventListener('change', () => loadPhotos(true));
    filterFormat.addEventListener('change', () => loadPhotos(true));
    btnLoadMore.addEventListener('click', () => loadPhotos());

    // Chargement initial
    loadPhotos();
});
</script>

<style>
.colonnes-images {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.carte {
    border: 1px solid #ccc;
    padding: 10px;
}

.carte img {
    max-width: 100%;
    height: auto;
    display: block;
}
</style>

<?php get_footer(); ?>

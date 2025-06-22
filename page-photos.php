<?php
/**
 * Template Name: Galerie Photos
 */

get_header();
?>

<main id="primary" class="site-main galerie">

    <div class="zone-filtres">
        <div class="filtres-gauche">
            <!-- Catégories -->
            <?php
            $categories = get_terms(['taxonomy' => 'photo_categorie', 'hide_empty' => false]);
            if (!empty($categories) && !is_wp_error($categories)) : ?>
                <div class="filtres">
                    <span class="titre-filtres">Catégorie</span>
                    <select name="categorie" id="categorie">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Formats -->
            <?php
            $formats = get_terms(['taxonomy' => 'photo_format', 'hide_empty' => false]);
            if (!empty($formats) && !is_wp_error($formats)) : ?>
                <div class="filtres">
                    <span class="titre-filtres">Format</span>
                    <select name="format" id="format">
                        <option value="">Tous les formats</option>
                        <?php foreach ($formats as $format) : ?>
                            <option value="<?php echo esc_attr($format->slug); ?>"><?php echo esc_html($format->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
        </div>

        <div class="filtres-droite">
            <div class="filtres">
                <span class="titre-filtres">Trier par</span>
                <select name="tri" id="tri">
                    <option value="date_desc">Date décroissante</option>
                    <option value="date_asc">Date croissante</option>
                    <option value="title_asc">Titre A-Z</option>
                    <option value="title_desc">Titre Z-A</option>
                </select>
            </div>
        </div>
    </div>

    <div class="colonnes-images" id="photo-results">
        <?php
        $photos_query = new WP_Query([
            'post_type'      => 'photos',
            'posts_per_page' => 8, // 8 photos par défaut
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        if ($photos_query->have_posts()) :
            while ($photos_query->have_posts()) : $photos_query->the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('carte'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'image-carte']); ?>
                        </a>
                    <?php endif; ?>
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
    </div>

    <!-- Bouton Charger plus -->
    <div class="charger-plus-container">
        <button id="charger-plus" data-page="1">Charger plus</button>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorie = document.getElementById('categorie');
    const format = document.getElementById('format');
    const tri = document.getElementById('tri');
    const chargerPlus = document.getElementById('charger-plus');
    const photoResults = document.getElementById('photo-results');
    let page = 1;

    function fetchPhotos(resetPage = false) {
        if (resetPage) page = 1;

        const data = {
            action: 'filter_photos',
            categorie: categorie.value,
            format: format.value,
            tri: tri.value,
            paged: page
        };

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(data)
        })
        .then(response => response.text())
        .then(html => {
            if (resetPage) {
                photoResults.innerHTML = html;
            } else {
                photoResults.insertAdjacentHTML('beforeend', html);
            }
        });
    }

    [categorie, format, tri].forEach(el => el.addEventListener('change', function() {
        fetchPhotos(true);
    }));

    chargerPlus.addEventListener('click', function() {
        page++;
        fetchPhotos(false);
    });
});
</script>

<?php get_footer(); ?>

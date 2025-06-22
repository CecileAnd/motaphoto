<?php
/**
 * Template Name: Front Page - Galerie Photos
 */

get_header(); 

$post_type = get_post_type();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ($post_type === 'photos') : ?>

        <header class="entry-header">
            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <h2 class="entry-title"><?php the_title(); ?></h2>
        </header>

        <div class="entry-content">
            <?php
            the_content();

            $reference = get_field('reference');
            $categorie = get_field('categorie');
            $annee     = get_field('annee');
            $format    = get_field('format');
            $type      = get_field('type');
            ?>

            <ul class="photo-meta">
                <?php if ($reference) : ?>
                    <li><strong>Référence :</strong> <?php echo esc_html($reference); ?></li>
                <?php endif; ?>

                <?php if ($categorie) : ?>
                    <li><strong>Catégorie :</strong> <?php echo esc_html($categorie); ?></li>
                <?php endif; ?>

                <?php if ($annee) : ?>
                    <li><strong>Année :</strong> <?php echo esc_html($annee); ?></li>
                <?php endif; ?>

                <?php if ($format) : ?>
                    <li><strong>Format :</strong> <?php echo esc_html($format); ?></li>
                <?php endif; ?>

                <?php if ($type) : ?>
                    <li><strong>Type :</strong> <?php echo esc_html($type); ?></li>
                <?php endif; ?>
            </ul>
        </div>

    <?php else : ?>

        <header class="entry-header">
            <?php
            if (is_singular()) :
                the_title('<h1 class="entry-title">', '</h1>');
            else :
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;
            ?>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large'); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="entry-content">
            <?php
            if (is_singular()) {
                the_content();
            } else {
                the_excerpt();
            }
            ?>
        </div>

    <?php endif; ?>

<main id="primary" class="site-main galerie">

    <div class="zone-filtres">
        <div class="filtres-gauche">
            <!-- Catégories -->
            <?php
            $categories = get_terms(['taxonomy' => 'photo_categorie', 'hide_empty' => false]);
            if (!empty($categories) && !is_wp_error($categories)) :
            ?>
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
            if (!empty($formats) && !is_wp_error($formats)) :
            ?>
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
            <!-- Trier par -->
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
            'posts_per_page' => 8,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        if ($photos_query->have_posts()) :
            while ($photos_query->have_posts()) : $photos_query->the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('carte'); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', ['class' => 'image-carte']); ?>
                    </a>
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/default.jpg" alt="Image par défaut" class="image-carte">
                <?php endif; ?>

                <header class="entry-header">
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
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
    <div class="load-more-wrap">
        <button id="load-more">Charger plus</button>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorie = document.getElementById('categorie');
    const format = document.getElementById('format');
    const tri = document.getElementById('tri');
    const loadMoreBtn = document.getElementById('load-more');
    let paged = 2;

    [categorie, format, tri].forEach(el => el.addEventListener('change', function() {
        const data = {
            action: 'filter_photos',
            categorie: categorie.value,
            format: format.value,
            tri: tri.value
        };

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(data)
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('photo-results').innerHTML = html;
        });
    }));

    loadMoreBtn.addEventListener('click', function() {
        const data = {
            action: 'load_more_photos',
            paged: paged
        };

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
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
});
</script>

<?php get_footer(); ?>

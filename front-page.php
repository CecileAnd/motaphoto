<?php
/**
 * Template Name: Front Page - Galerie Photos
 */

get_header();

// Section Hero avec photo aléatoire
$args = [
    'post_type' => 'photos',
    'posts_per_page' => 1,
    'orderby' => 'rand',
];
$random_photo = new WP_Query($args);
if ($random_photo->have_posts()) :
    while ($random_photo->have_posts()) : $random_photo->the_post();
        if (has_post_thumbnail()) :
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            ?>
            <section class="hero-header" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                <div class="hero-overlay-text">Photographe&nbsp;Event</div>
            </section>
            <?php
        endif;
    endwhile;
    wp_reset_postdata();
endif;
?>

<main id="primary" class="site-main galerie">

    <div class="zone-filtres">
        <div class="filtres-gauche">
            <?php
            $categories = get_terms(['taxonomy' => 'photo_categorie', 'hide_empty' => false]);
            if (!empty($categories) && !is_wp_error($categories)) : ?>
                <div class="filtres">
                    <select name="categorie" id="categorie" class="select2-no-search select2-results">
                        <option value="">Catégories</option>
                        <?php foreach ($categories as $cat) : ?>
                            <option value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php
            $formats = get_terms(['taxonomy' => 'photo_format', 'hide_empty' => false]);
            if (!empty($formats) && !is_wp_error($formats)) : ?>
                <div class="filtres">
                    <select name="format" id="format" class="select2-no-search select2-results">
                        <option value="">Formats</option>
                        <?php foreach ($formats as $format) : ?>
                            <option value="<?php echo esc_attr($format->slug); ?>"><?php echo esc_html($format->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
        </div>

        <div class="filtres-droite">
            <div class="filtres">
                <select name="tri" id="tri" class="select2-no-search select2-results">
                    <option value="">Trier par</option>
                    <option value="date_desc">Date décroissante</option>
                    <option value="date_asc">Date croissante</option>
                </select>
            </div>
        </div>
    </div>

    <div class="colonnes-images" id="photo-results">
        <?php
        $photos_query = new WP_Query([
            'post_type' => 'photos',
            'posts_per_page' => 8,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);
        if ($photos_query->have_posts()) :
            while ($photos_query->have_posts()) : $photos_query->the_post();
                get_template_part('template-parts/photo', 'item');
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>Aucune photo trouvée.</p>';
        endif;
        ?>
    </div>

    <div class="load-more-wrap">
        <button id="load-more">Charger plus</button>
    </div>

</main>

<?php get_footer(); ?>
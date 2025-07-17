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
            $image_id = get_post_thumbnail_id(get_the_ID());
?>
<section class="hero-header">
  <?php
    echo wp_get_attachment_image($image_id, 'full', false, [
        'class' => 'hero-background',
        'alt'   => 'Photo d’en-tête aléatoire',
    ]);
  ?>
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

            <?php $categories = get_terms(['taxonomy' => 'photo_categorie', 'hide_empty' => false]); ?>
            <div class="filtres" data-filter="categorie">
                <button class="filtre-bouton" type="button">
                    <span class="filtre-titre">Catégories</span>
                    <img class="chevron" src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/chevron-down.png" alt="Chevron bas">
                </button>
                <ul class="filtre-options">
                    <li data-value=""> Catégories </li>
                    <?php foreach ($categories as $cat): ?>
                        <li data-value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php $formats = get_terms(['taxonomy' => 'photo_format', 'hide_empty' => false]); ?>
            <div class="filtres" data-filter="format">
                <button class="filtre-bouton" type="button">
                    <span class="filtre-titre">Formats</span>
                    <img class="chevron" src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/chevron-down.png" alt="Chevron bas">
                </button>
                <ul class="filtre-options">
                    <li data-value=""> Formats </li>
                    <?php foreach ($formats as $format): ?>
                        <li data-value="<?php echo esc_attr($format->slug); ?>"><?php echo esc_html($format->name); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="filtres-droite">
            <div class="filtres" data-filter="tri">
                <button class="filtre-bouton" type="button">
                    <span class="filtre-titre">Trier par</span>
                    <img class="chevron" src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/chevron-down.png" alt="Chevron bas">
                </button>
                <ul class="filtre-options">
                    <li data-value="date_desc">Date décroissante</li>
                    <li data-value="date_asc">Date croissante</li>
                </ul>
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

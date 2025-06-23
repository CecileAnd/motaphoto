<?php
/**
 * Template Name: Front Page - Galerie Photos
 */

get_header();
?>

<?php
$args = array(
    'post_type'      => 'photos',
    'posts_per_page' => 1,
    'orderby'        => 'rand',
);

$random_photo = new WP_Query($args);

if ($random_photo->have_posts()) :
    while ($random_photo->have_posts()) : $random_photo->the_post();
        if (has_post_thumbnail()) :
            $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
        ?>
            <section class="hero-header" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                <div class="hero-overlay-text">
                    Photographe&nbsp;Event
                </div>
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
            <!-- Catégories -->
            <?php
            $categories = get_terms(['taxonomy' => 'photo_categorie', 'hide_empty' => false]);
            if (!empty($categories) && !is_wp_error($categories)) :
            ?>
                <div class="filtres">
                    <select name="categorie" id="categorie">
                        <option value="">Catégories</option>
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
                    <select name="format" id="format">
                        <option value="">Formats</option>
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
                <select name="tri" id="tri">
                    <option value="">Trier par</option>
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

                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                if (!$image_url) {
                    $image_url = get_template_directory_uri() . '/images/default.jpg';
                }
                $title = get_the_title();
                $categorie = get_field('categorie');
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('carte'); ?>>
                <!-- Lien vers la page single de chaque photo -->
                <a href="<?php the_permalink(); ?>">
                    <img class="image-carte" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" />

                    <div class="overlay">
                        <div class="icone-full">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/Icon_fullscreen.png" alt="icone fullscreen" />
                        </div>
                        <div class="icone-oeil">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/Icon_eye.png" alt="icone oeil" />
                        </div>
                        <div class="infos-bas">
                            <span class="gauche">
                                <?php echo mb_strtoupper(html_entity_decode(get_the_title()), 'UTF-8'); ?>
                            </span>
                            <span class="droite">
                                <?php 
                                $categorie = get_field('categorie'); 
                                echo $categorie ? mb_strtoupper(html_entity_decode($categorie), 'UTF-8') : ''; 
                                ?>
                            </span>
                        </div>
                    </div>
                </a>
            </article>
        <?php
            endwhile;
            wp_reset_postdata();
        else : ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
    </div>

    <div class="load-more-wrap">
        <button id="load-more">Charger plus</button>
    </div>
</main>

<?php get_footer(); ?>

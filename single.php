<?php
get_header();

// Début de la boucle WordPress
if (have_posts()) :
    while (have_posts()) : the_post();

        // Variables dynamiques
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large'); // image à la une
        $titre_photo = get_the_title();

        // Champs personnalisés ACF
        $reference  = get_field('reference');
        /* $categorie = get_field('categorie');
        $format    = get_field('format'); */
        $type      = get_field('type');
        $annee     = get_field('annee');

        // Taxonomies (si jamais utilisées à la place des ACF)
        $categorie = get_the_terms(get_the_ID(), 'photo_categorie');
        $categorie = $categorie[0]->name;
        $format = get_the_terms(get_the_ID(), 'photo_format');
        $format = $format[0]->name;
?>
<main class="page-detail">
    <div class="container-detail">
        <div class="image-detail">
            <?php if ($image_url) : ?>
                <img class="principale" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($titre_photo); ?>" />
            <?php endif; ?>
        </div>
        <div class="infos">
            <div class="informations-detail">
                <h2 class="titre-photo"><?php echo nl2br(esc_html($titre_photo)); ?></h2>
                <ul class="meta-photo">
                    <?php if ($reference) : ?><li class="description-photo">Référence : <?php echo esc_html($reference); ?></li><?php endif; ?>
                    <?php if ($categorie) : ?><li class="description-photo">Catégorie : <?php echo esc_html($categorie); ?></li><?php endif; ?>
                    <?php if ($format) : ?><li class="description-photo">Format : <?php echo esc_html($format); ?></li><?php endif; ?>
                    <?php if ($type) : ?><li class="description-photo">Type : <?php echo esc_html($type); ?></li><?php endif; ?>
                    <?php if ($annee) : ?><li class="description-photo">Année : <?php echo esc_html($annee); ?></li><?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="bloc-separateur">
        <hr class="ligne-horizontale-longue-haut"/>
    </div>
    <section class="interet-photo">
        <div class="interet-contact">
            <p class="photo-interessante">Cette photo vous intéresse&nbsp;?</p>
            <a href="#contact" class="bouton-contact">Contact</a>
        </div>
        <div class="miniature-navigation">
            <div class="miniature-photo">
                <?php
                // Affiche une miniature aléatoire différente de celle courante
                $args = array(
                    'post_type'      => 'photos',
                    'posts_per_page' => 1,
                    'orderby'        => 'rand',
                    'post__not_in'   => array(get_the_ID()), // exclut la photo actuelle
                );
                $random_photo = new WP_Query($args);
                if ($random_photo->have_posts()) :
                    while ($random_photo->have_posts()) : $random_photo->the_post();
                        $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                        if ($thumb_url) : ?>
                            <img class="miniature" src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>" />
                        <?php endif;
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            <div class="navigation-fleches">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                <?php if (!empty($prev_post)) : ?>
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="fleche gauche" aria-label="Photo précédente">&#8592;</a>
                <?php endif; ?>
                <?php if (!empty($next_post)) : ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="fleche droite" aria-label="Photo suivante">&#8594;</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="bloc-separateur">
        <hr class="ligne-horizontale-longue"/>
    </div>

    <section class="suggestions">
        <h3 class="titre-suggestions">Vous aimerez aussi</h3>
        <div class="suggestions-grid">
            <?php
            // Affiche 2 suggestions aléatoires
            $suggestions = new WP_Query(array(
                'post_type'      => 'photos',
                'posts_per_page' => 2,
                'orderby'        => 'rand',
                'post__not_in'   => array(get_the_ID()),
            ));
            if ($suggestions->have_posts()) :
                while ($suggestions->have_posts()) : $suggestions->the_post();
                    $suggestion_thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    if ($suggestion_thumb) :
            ?>
                <div class="suggestion-item">
                    <a href="<?php the_permalink(); ?>">
                        <img class="image-suggestion" src="<?php echo esc_url($suggestion_thumb); ?>" alt="<?php the_title_attribute(); ?>" />
                    </a>
                </div>
            <?php
                    endif;
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>
</main>

<?php
    endwhile;
endif;

get_footer();
?>

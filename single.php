<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        $titre_photo = get_the_title();

        $reference  = get_field('reference');
        $type       = get_field('type');
        $annee      = get_field('annee');

        $categorie = get_the_terms(get_the_ID(), 'photo_categorie');
        $categorie = $categorie ? $categorie[0]->name : null;
        $format = get_the_terms(get_the_ID(), 'photo_format');
        $format = $format ? $format[0]->name : null;

        // Récupération des posts précédent et suivant normalement
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        $post_type = 'photos';

        // Si pas de post précédent, on récupère le dernier post publié (ordre date DESC)
        if (empty($prev_post)) {
            $args = array(
                'post_type'      => $post_type,
                'posts_per_page' => 1,
                'orderby'        => 'date',
                'order'          => 'DESC',
            );
            $last_post_query = new WP_Query($args);
            if ($last_post_query->have_posts()) {
                $last_post_query->the_post();
                $prev_post = get_post();
                wp_reset_postdata();
            }
        }

        // Si pas de post suivant, on récupère le premier post publié (ordre date ASC)
        if (empty($next_post)) {
            $args = array(
                'post_type'      => $post_type,
                'posts_per_page' => 1,
                'orderby'        => 'date',
                'order'          => 'ASC',
            );
            $first_post_query = new WP_Query($args);
            if ($first_post_query->have_posts()) {
                $first_post_query->the_post();
                $next_post = get_post();
                wp_reset_postdata();
            }
        }
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
            <a href="javascript:void(0);" class="contact-button" data-reference="<?php echo esc_attr($reference); ?>">Contact</a>
        </div>
    <?php
    $prev_post = get_previous_post();
    $next_post = get_next_post();

    $prev_thumb = $prev_post ? get_the_post_thumbnail_url($prev_post->ID, 'thumbnail') : '';
    $next_thumb = $next_post ? get_the_post_thumbnail_url($next_post->ID, 'thumbnail') : '';

    $default_thumb = $next_thumb ?: $prev_thumb;
    $default_title = $next_post ? get_the_title($next_post->ID) : ($prev_post ? get_the_title($prev_post->ID) : '');
    ?>

    <div class="miniature-navigation">
        <div class="miniature-photo">
            <a id="miniature-link"
            href="<?php echo esc_url($next_post ? get_permalink($next_post->ID) : ($prev_post ? get_permalink($prev_post->ID) : '#')); ?>">
                <img id="miniature-image"
                    class="miniature"
                    src="<?php echo esc_url($default_thumb); ?>"
                    alt="<?php echo esc_attr($default_title); ?>" />
            </a>
        </div>

        <div class="navigation-fleches">
            <?php if ($prev_post && $prev_thumb) : ?>
                <a href="<?php echo get_permalink($prev_post->ID); ?>"
                class="fleche gauche"
                aria-label="Photo précédente"
                data-thumb="<?php echo esc_url($prev_thumb); ?>"
                data-link="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                    &#8592;
                </a>
            <?php endif; ?>

            <?php if ($next_post && $next_thumb) : ?>
                <a href="<?php echo get_permalink($next_post->ID); ?>"
                class="fleche droite"
                aria-label="Photo suivante"
                data-thumb="<?php echo esc_url($next_thumb); ?>"
                data-link="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
                    &#8594;
                </a>
            <?php endif; ?>
        </div>
    </div>
    </section>

    <div class="bloc-separateur">
        <hr class="ligne-horizontale-longue"/>
    </div>

   <section class="suggestions">
    <h3 class="titre-suggestions">Vous aimerez aussi</h3>
    <?php
    if ($categorie) {
        $suggestions = new WP_Query(array(
            'post_type'      => 'photos',
            'posts_per_page' => 2,
            'orderby'        => 'rand',
            'post__not_in'   => array(get_the_ID()),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'photo_categorie',
                    'field'    => 'name',
                    'terms'    => $categorie,
                ),
            ),
        ));

        $found_posts = $suggestions->found_posts;
        if ($found_posts > 0) :
    ?>
    <div class="suggestions-grid <?php echo $found_posts === 1 ? 'une-suggestion' : ''; ?>">
        <?php
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
        ?>
    </div>
    <?php
        else :
            echo '<p class="aucune-suggestion">Aucune suggestion disponible dans la même catégorie.</p>';
        endif;
    }
    ?>
</section>


</main>

<?php
    endwhile;
endif;

get_footer();
?>

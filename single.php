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

        function convert_to_webp($url) {
    // Si l'URL termine par .jpg, .jpeg ou .png, on ajoute .webp à la fin sans enlever l'extension d'origine
    if (preg_match('/\.(jpe?g|png)$/i', $url)) {
        return $url . '.webp';
    }
    return $url;
}

        
/*         // Générer les URLs WebP pour l'image principale et miniatures (remplacement extension)
        function convert_to_webp($url) {
            return preg_replace('/\.(jpe?g|png)$/i', '.webp', $url);
        }
        $image_url_webp = $image_url ? convert_to_webp($image_url) : ''; */

        $prev_thumb = $prev_post ? get_the_post_thumbnail_url($prev_post->ID, 'thumbnail') : '';
        $next_thumb = $next_post ? get_the_post_thumbnail_url($next_post->ID, 'thumbnail') : '';

        $prev_thumb_webp = $prev_thumb ? convert_to_webp($prev_thumb) : '';
        $next_thumb_webp = $next_thumb ? convert_to_webp($next_thumb) : '';

        $default_thumb = $next_thumb ?: $prev_thumb;
        $default_thumb_webp = $next_thumb_webp ?: $prev_thumb_webp;

        $default_title = $next_post ? get_the_title($next_post->ID) : ($prev_post ? get_the_title($prev_post->ID) : '');

        $default_link = $next_post ? get_permalink($next_post->ID) : ($prev_post ? get_permalink($prev_post->ID) : '#');

?>

<main class="page-detail">
    <div class="container-detail">
        <div class="image-detail">
            <?php if ($image_url) : ?>
                <picture class="principale">
                    <source srcset="<?php echo esc_url($image_url_webp); ?>" type="image/webp" />
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($titre_photo); ?>" />
                </picture>
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

    <div class="miniature-navigation">
        <div class="miniature-photo">
            <a id="miniature-link" href="<?php echo esc_url($default_link); ?>">
                <picture>
                    <source srcset="<?php echo esc_url($default_thumb_webp); ?>" type="image/webp" />
                    <img id="miniature-image" class="miniature" src="<?php echo esc_url($default_thumb); ?>" alt="<?php echo esc_attr($default_title); ?>" />
                </picture>
            </a>
        </div>

        <div class="navigation-fleches">
            <?php if ($prev_post && $prev_thumb) : ?>
                <a href="<?php echo get_permalink($prev_post->ID); ?>"
                   class="fleche gauche"
                   aria-label="Photo précédente"
                   data-thumb="<?php echo esc_url($prev_thumb); ?>"
                   data-thumb-webp="<?php echo esc_url($prev_thumb_webp); ?>"
                   data-link="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
                   &#8592;
                </a>
            <?php endif; ?>

            <?php if ($next_post && $next_thumb) : ?>
                <a href="<?php echo get_permalink($next_post->ID); ?>"
                   class="fleche droite"
                   aria-label="Photo suivante"
                   data-thumb="<?php echo esc_url($next_thumb); ?>"
                   data-thumb-webp="<?php echo esc_url($next_thumb_webp); ?>"
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sélection des éléments
    const miniatureLink = document.getElementById('miniature-link');
    const miniatureImage = document.getElementById('miniature-image');
    const miniaturePicture = miniatureImage.closest('picture');

    // Flèches
    const prevArrow = document.querySelector('.navigation-fleches .fleche.gauche');
    const nextArrow = document.querySelector('.navigation-fleches .fleche.droite');

    function updateMiniature(thumb, thumbWebp, link, alt) {
        // Met à jour la miniature et le lien
        miniatureLink.href = link;

        // Met à jour le fallback img
        miniatureImage.src = thumb;
        miniatureImage.alt = alt || '';

        // Met à jour la source WebP (premier enfant source de picture)
        if (miniaturePicture) {
            const sourceWebp = miniaturePicture.querySelector('source[type="image/webp"]');
            if (sourceWebp) {
                sourceWebp.srcset = thumbWebp;
            }
        }
    }

    function onArrowHover(e) {
        const target = e.currentTarget;
        const thumb = target.getAttribute('data-thumb');
        const thumbWebp = target.getAttribute('data-thumb-webp');
        const link = target.getAttribute('data-link');
        const alt = target.getAttribute('aria-label');
        if (thumb && thumbWebp && link) {
            updateMiniature(thumb, thumbWebp, link, alt);
        }
    }

    function onArrowOut() {
        // Remet à la miniature par défaut (celle au chargement)
        // On pourrait stocker dans des variables la valeur initiale
        updateMiniature(
            '<?php echo esc_js($default_thumb); ?>',
            '<?php echo esc_js($default_thumb_webp); ?>',
            '<?php echo esc_js($default_link); ?>',
            '<?php echo esc_js($default_title); ?>'
        );
    }

    if (prevArrow) {
        prevArrow.addEventListener('mouseenter', onArrowHover);
        prevArrow.addEventListener('mouseleave', onArrowOut);
    }
    if (nextArrow) {
        nextArrow.addEventListener('mouseenter', onArrowHover);
        nextArrow.addEventListener('mouseleave', onArrowOut);
    }
});
</script>

<?php
    endwhile;
endif;

get_footer();
?>

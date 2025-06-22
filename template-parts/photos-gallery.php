<?php
// Récupérer les taxonomies pour filtres
$categories = get_terms(['taxonomy' => 'photo_categorie', 'hide_empty' => false]);
$formats    = get_terms(['taxonomy' => 'photo_format', 'hide_empty' => false]);
?>

<div class="zone-filtres">
    <div class="filtres-gauche">
        <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
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

        <?php if (!empty($formats) && !is_wp_error($formats)) : ?>
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

<div id="photos-container" class="colonnes-images">

<?php
// Query initiale : 8 photos, ordre par date desc
$args = [
    'post_type'      => 'photos',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('carte'); ?>>
        <?php 
        if (has_post_thumbnail()) {
            the_post_thumbnail('medium', ['class' => 'image-carte']);
        } else {
            // Fallback sur la première image attachée
            $attachments = get_attached_media('image', get_the_ID());
            if (!empty($attachments)) {
                $first_attachment = reset($attachments);
                echo wp_get_attachment_image($first_attachment->ID, 'medium', false, ['class' => 'image-carte']);
            } else {
                echo '<img src="' . get_template_directory_uri() . '/images/default-photo.jpg" alt="Image par défaut" class="image-carte" />';
            }
        }
        ?>

        <header class="entry-header">
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
        </header>

        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div>
    </article>

<?php
    endwhile;
    wp_reset_postdata();
else :
    echo '<p>Aucune photo trouvée.</p>';
endif;
?>

</div>

<button id="load-more-photos" class="btn-charger-plus">Charger plus</button>

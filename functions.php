<?php
// Ajouter image mise en avant
add_theme_support('post-thumbnails');

// Enregistre le CPT 'photos' 
function mota_register_photos_cpt() {
    $labels = [
        'name' => 'Photos',
        'singular_name' => 'Photo',
        'menu_name' => 'Photos',
        'add_new' => 'Ajouter',
        'add_new_item' => 'Ajouter une photo',
        'edit_item' => 'Modifier la photo',
        'new_item' => 'Nouvelle photo',
        'view_item' => 'Voir la photo',
        'search_items' => 'Chercher des photos',
        'not_found' => 'Aucune photo trouvée',
        'not_found_in_trash' => 'Aucune photo dans la corbeille',
        'all_items' => 'Toutes les photos',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'taxonomies' => ['photo_categorie', 'photo_format'],
        'menu_icon' => 'dashicons-format-image',
        'rewrite' => ['slug' => 'photos'],
    ];

    register_post_type('photos', $args);
}
add_action('init', 'mota_register_photos_cpt');

// Enregistre la taxonomie 'photo_categorie'
function mota_register_photo_categorie_taxonomy() {
    $labels = [
        'name' => 'Catégories',
        'singular_name' => 'Catégorie',
        'search_items' => 'Chercher des catégories',
        'all_items' => 'Toutes les catégories',
        'edit_item' => 'Modifier la catégorie',
        'update_item' => 'Mettre à jour la catégorie',
        'add_new_item' => 'Ajouter une catégorie',
        'new_item_name' => 'Nouvelle catégorie',
        'menu_name' => 'Catégories',
    ];

    register_taxonomy('photo_categorie', ['photos'], [
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'photo-categorie'],
    ]);
}
add_action('init', 'mota_register_photo_categorie_taxonomy');

// Enregistre la taxonomie 'photo_format'
function mota_register_photo_format_taxonomy() {
    $labels = [
        'name' => 'Formats',
        'singular_name' => 'Format',
        'search_items' => 'Chercher des formats',
        'all_items' => 'Tous les formats',
        'edit_item' => 'Modifier le format',
        'update_item' => 'Mettre à jour le format',
        'add_new_item' => 'Ajouter un format',
        'new_item_name' => 'Nouveau format',
        'menu_name' => 'Formats',
    ];

    register_taxonomy('photo_format', ['photos'], [
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'photo-format'],
    ]);
}
add_action('init', 'mota_register_photo_format_taxonomy');

// AJAX pour filtrer les photos
function mota_filter_photos() {
    $args = [
        'post_type'      => 'photos',
        'posts_per_page' => 8,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    if (!empty($_POST['categorie'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'photo_categorie',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['categorie']),
        ];
    }

    if (!empty($_POST['format'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'photo_format',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_POST['format']),
        ];
    }

    if (!empty($_POST['tri'])) {
        switch ($_POST['tri']) {
            case 'date_asc':
                $args['orderby'] = 'date';
                $args['order'] = 'ASC';
                break;
            case 'title_asc':
                $args['orderby'] = 'title';
                $args['order'] = 'ASC';
                break;
            case 'title_desc':
                $args['orderby'] = 'title';
                $args['order'] = 'DESC';
                break;
            default:
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
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
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_filter_photos', 'mota_filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'mota_filter_photos');

// AJAX pour le bouton "Charger plus"
function mota_load_more_photos() {
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = [
        'post_type'      => 'photos',
        'posts_per_page' => 8,
        'paged'         => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
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
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_load_more_photos', 'mota_load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'mota_load_more_photos');
?>

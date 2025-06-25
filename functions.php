<?php
// functions.php

function mon_theme_enqueue_select2() {
    // CSS de Select2
    wp_enqueue_style(
        'select2-css',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
    );

    // JS de Select2
    wp_enqueue_script(
        'select2-js',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        ['jquery'], // dépendance à jQuery
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_select2');

function mon_theme_enqueue_custom_scripts() {
    wp_enqueue_script(
        'select2-init',
        get_template_directory_uri() . '/assets/js/select2-init.js',
        ['jquery', 'select2-js'],
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_custom_scripts');


// Enqueue scripts et styles
function motaphoto_enqueue_scripts() {
    // Style principal
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());

    // Script principal (modale, menu burger, etc.)
    wp_enqueue_script(
        'mota-script',
        get_template_directory_uri() . '/assets/js/script.js',
        ['jquery'], // Dépend de jQuery
        null,
        true // Chargement en pied de page
    );

    // Script Ajax gallery
    wp_enqueue_script(
        'ajax-gallery',
        get_template_directory_uri() . '/assets/js/ajax-gallery.js',
        ['jquery'],
        '1.0',
        true
    );

    // Localisation pour AJAX
    wp_localize_script('ajax-gallery', 'ajaxGallery', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-gallery-nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_scripts');


// Enregistrement des menus
register_nav_menus([
    'header' => 'Menu principal',
    'footer' => 'Pied de page',
]);


// Enregistrement du CPT 'photos'
function motaphoto_register_cpt_photos() {
    $labels = [
        'name' => 'Photos',
        'singular_name' => 'Photo',
        'menu_name' => 'Photos',
        'all_items' => 'Toutes les photos',
        'add_new_item' => 'Ajouter une photo',
        'edit_item' => 'Modifier la photo',
        'new_item' => 'Nouvelle photo',
        'view_item' => 'Voir la photo',
        'search_items' => 'Rechercher des photos',
        'not_found' => 'Aucune photo trouvée',
        'not_found_in_trash' => 'Aucune photo trouvée dans la corbeille',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'photos'],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true,
    ];

    register_post_type('photos', $args);
}
add_action('init', 'motaphoto_register_cpt_photos');


// Enregistrement des taxonomies personnalisées
function motaphoto_register_taxonomies() {
    // Catégorie photo
    register_taxonomy('photo_categorie', 'photos', [
        'label' => 'Catégories photo',
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'rewrite' => ['slug' => 'photo-categorie'],
        'show_in_rest' => true,
    ]);

    // Format photo
    register_taxonomy('photo_format', 'photos', [
        'label' => 'Formats photo',
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'rewrite' => ['slug' => 'photo-format'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'motaphoto_register_taxonomies');


// Callback Ajax pour charger les photos filtrées + pagination
function motaphoto_load_photos_ajax() {
    check_ajax_referer('ajax-gallery-nonce', 'nonce');

    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $tri = isset($_POST['tri']) ? sanitize_text_field($_POST['tri']) : 'date_desc';

    $args = [
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => $paged,
    ];

    // Taxonomy query
    $tax_query = [];

    if ($categorie) {
        $tax_query[] = [
            'taxonomy' => 'photo_categorie',
            'field' => 'slug',
            'terms' => $categorie,
        ];
    }

    if ($format) {
        $tax_query[] = [
            'taxonomy' => 'photo_format',
            'field' => 'slug',
            'terms' => $format,
        ];
    }

    if (!empty($tax_query)) {
        if (count($tax_query) > 1) {
            $tax_query['relation'] = 'AND';
        }
        $args['tax_query'] = $tax_query;
    }

    // Tri
    switch ($tri) {
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
        case 'date_desc':
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Inclure un template part, ou code HTML ici :
            get_template_part('template-parts/photo', 'item');
        }
    }

    wp_reset_postdata();

    $html = ob_get_clean();

    $has_more = ($paged < $query->max_num_pages);

    wp_send_json_success([
        'html' => $html,
        'has_more' => $has_more,
    ]);
}
add_action('wp_ajax_load_photos', 'motaphoto_load_photos_ajax');
add_action('wp_ajax_nopriv_load_photos', 'motaphoto_load_photos_ajax');

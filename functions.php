<?php
// functions.php

add_theme_support('post-thumbnails');



// Enqueue styles & scripts


function motaphoto_enqueue_scripts() {
    // Style principal
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());

    // Style custom du thème
    wp_enqueue_style('motaphoto-theme-style', get_template_directory_uri() . '/assets/css/style.css');

    // Script principal (burger, modale, etc.)
    wp_enqueue_script(
        'mota-script',
        get_template_directory_uri() . '/assets/js/script.js',
        ['jquery'],
        null,
        true
    );

    // Script Ajax gallery
/*     wp_enqueue_script(
        'ajax-gallery',
        get_template_directory_uri() . '/assets/js/ajax-gallery.js',
        ['jquery'],
        '1.0',
        true
    ); */
        wp_enqueue_script('ajax-gallery', get_template_directory_uri() . '/assets/js/ajax-gallery.js', array(), null, true);

    // Localisation pour AJAX
/*     wp_localize_script('ajax-gallery', 'ajaxGallery', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-gallery-nonce'),
    ]); */

    wp_localize_script('ajax-gallery', 'ajaxGallery', array(
  'ajaxurl' => admin_url('admin-ajax.php'),
  'nonce'   => wp_create_nonce('load_photos_nonce'),
));


    // Script modale de contact
    wp_enqueue_script(
        'mon-theme-modal-contact',
        get_template_directory_uri() . '/assets/js/modal-contact.js',
        ['jquery'],
        filemtime(get_template_directory() . '/assets/js/modal-contact.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_scripts');


// Enqueue Select2 (CSS + JS) et initialisation
function mon_theme_enqueue_select2() {
    wp_enqueue_style(
        'select2-css',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
    );

    wp_enqueue_script(
        'select2-js',
        'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        ['jquery'],
        null,
        true
    );

    wp_enqueue_script(
        'select2-init',
        get_template_directory_uri() . '/assets/js/select2-init.js',
        ['jquery', 'select2-js'],
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_select2');



// Menus


register_nav_menus([
    'header' => 'Menu principal',
    'footer' => 'Pied de page',
]);


// Ajouter la classe .bouton-contact sur le menu "Contact"
add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
    if ($args->theme_location === 'header' && strtolower(trim($item->title)) === 'contact') {
        $atts['class'] = isset($atts['class']) ? $atts['class'] . ' bouton-contact' : 'bouton-contact';
        $atts['href'] = '#'; // évite une redirection vers une page "Contact"
    }
    return $atts;
}, 10, 3);



// CPT Photos


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



// Taxonomies personnalisées


function motaphoto_register_taxonomies() {
    register_taxonomy('photo_categorie', 'photos', [
        'label' => 'Catégories photo',
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'rewrite' => ['slug' => 'photo-categorie'],
        'show_in_rest' => true,
    ]);

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



// AJAX chargement des photos filtrées + pagination


function motaphoto_load_photos_ajax() {
    //check_ajax_referer('ajax-gallery-nonce', 'nonce');
    check_ajax_referer('load_photos_nonce', 'nonce');

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
        $args['tax_query'] = count($tax_query) > 1 ? array_merge(['relation' => 'AND'], $tax_query) : $tax_query;
    }

    // Tri
    switch ($tri) {
        case 'date_asc':
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
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

function motaphoto_enqueue_lightbox_assets() {
  // Lightbox2 CSS
  wp_enqueue_style(
    'lightbox-css',
    get_stylesheet_directory_uri() . '/assets/lightbox2/css/lightbox.min.css',
    [],
    '2.11.4'
  );

  // Lightbox2 JS
  wp_enqueue_script(
    'lightbox-js',
    get_stylesheet_directory_uri() . '/assets/lightbox2/js/lightbox.min.js',
    ['jquery'],
    '2.11.4',
    true
  );
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_lightbox_assets');



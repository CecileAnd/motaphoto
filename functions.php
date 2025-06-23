<?php
// Chargement des scripts et styles
function theme_enqueue_scripts() {
    // jQuery natif WordPress
    wp_enqueue_script('jquery');

    // Script principal du thème, dépend de jQuery
    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/assets/js/script.js',
        ['jquery'],
        null,
        true
    );

    // Lightbox2 JS, dépend de jQuery
    wp_enqueue_script(
        'lightbox2',
        'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js',
        ['jquery'],
        null,
        true
    );

    // Lightbox2 CSS
    wp_enqueue_style(
        'lightbox2-css',
        'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css',
        [],
        null
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Support images à la une
add_theme_support('post-thumbnails');

// Enregistrement des menus
function mon_theme_register_menus() {
    register_nav_menus([
        'menu-principal' => __('Menu Principal'),
        'menu-secondaire' => __('Menu Secondaire'),
        'footer' => __('Menu Pied de page')
    ]);
}
add_action('after_setup_theme', 'mon_theme_register_menus');


// Enregistrement du Custom Post Type 'photos'
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


// Enregistrement taxonomie 'photo_categorie'
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


// Enregistrement taxonomie 'photo_format'
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


// Ajout classe CSS "open-contact-modal" sur le lien "Contact" dans les menus
add_filter('nav_menu_link_attributes', 'ajouter_classe_contact', 10, 3);
function ajouter_classe_contact($atts, $item, $args) {
    if ($item->title === 'Contact') {
        $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'open-contact-modal';
    }
    return $atts;
}

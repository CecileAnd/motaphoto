<?php


// Ajouter les thumbnails dans les posts 


add_theme_support('post-thumbnails');


// enregistrer les menus 

function montheme_supports()
{
    register_nav_menu('header', 'En tête du menu');
    register_nav_menu('footer', 'Pied de page');
}

add_action('after_setup_theme', 'montheme_supports');



// 1. Déclaration du Custom Post Type "photos"
function create_photo_post_type() {
    register_post_type('photos', [
        'labels' => [
            'name' => __('Photos'),
            'singular_name' => __('Photo'),
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-image',
        'supports' => ['title', 'thumbnail', 'editor'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'photos'],
    ]);
}
add_action('init', 'create_photo_post_type');

// 2. Déclaration des taxonomies personnalisées
function create_photo_taxonomies() {
    register_taxonomy('photo_categorie', 'photos', [
        'label' => __('Catégories'),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'categorie-photo'],
    ]);
    register_taxonomy('photo_format', 'photos', [
        'label' => __('Formats'),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'format-photo'],
    ]);
}
add_action('init', 'create_photo_taxonomies');

// 3. Fonction d’import depuis CSV, sans doublons
function import_photos_from_csv() {
    $csv_path = WP_CONTENT_DIR . '/uploads/photos.csv';

    if (!file_exists($csv_path)) {
        // Fichier absent, on ne fait rien (pas d'erreur affichée)
        return;
    }

    if (($csv = fopen($csv_path, 'r')) === false) {
        return;
    }

    $header = fgetcsv($csv);
    if (!$header) {
        fclose($csv);
        return;
    }

    while (($row = fgetcsv($csv)) !== false) {
        $data = array_combine($header, $row);

        // Vérifier si un post avec ce titre existe déjà dans 'photos'
        if (get_page_by_title($data['title'], OBJECT, 'photos')) {
            continue; // On saute pour éviter doublon
        }

        $post_id = wp_insert_post([
            'post_title' => sanitize_text_field($data['title']),
            'post_type' => 'photos',
            'post_status' => 'publish',
        ]);

        if (!$post_id) continue;

        // Champs personnalisés
        update_post_meta($post_id, 'reference', sanitize_text_field($data['reference']));
        update_post_meta($post_id, 'annee', sanitize_text_field($data['annee']));
        update_post_meta($post_id, 'type', sanitize_text_field($data['type']));

        // Taxonomies
        wp_set_object_terms($post_id, sanitize_text_field($data['categorie']), 'photo_categorie');
        wp_set_object_terms($post_id, sanitize_text_field($data['format']), 'photo_format');

        // Image à la une, par titre de fichier (sans extension)
        $filename = pathinfo($data['file'], PATHINFO_FILENAME);
        $attachment = get_page_by_title($filename, OBJECT, 'attachment');
        if ($attachment) {
            set_post_thumbnail($post_id, $attachment->ID);
        }
    }
    fclose($csv);
}

// Pour lancer l'import UNE seule fois, décommente la ligne suivante,
// puis recharge une page admin, puis remets la ligne en commentaire.
// add_action('admin_init', 'import_photos_from_csv');

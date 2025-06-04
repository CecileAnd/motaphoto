<?php
function create_photo_post_type() {
    register_post_type('photo',
        array(
            'labels' => array(
                'name' => __('Photos'),
                'singular_name' => __('Photo')
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-format-image',
            'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'photos'),
        )
    );
}
add_action('init', 'create_photo_post_type');

function create_photo_taxonomies() {
    // Taxonomie Catégorie
    register_taxonomy(
        'photo_categorie',
        'photo',
        array(
            'label' => __('Catégories'),
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'categorie-photo'),
        )
    );

    // Taxonomie Format
    register_taxonomy(
        'photo_format',
        'photo',
        array(
            'label' => __('Formats'),
            'hierarchical' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'format-photo'),
        )
    );
}
add_action('init', 'create_photo_taxonomies');

function rsc_import_custom_meta_and_thumbnail() {
    // Chemin vers ton CSV dans le dossier wp-content/uploads (par exemple)
    $csv_file = WP_CONTENT_DIR . '/uploads/import.csv';

    if (!file_exists($csv_file)) {
        return; // Fichier CSV absent, on arrête
    }

    if (($handle = fopen($csv_file, 'r')) !== false) {
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== false) {
            // Récupérer les données selon l'ordre des colonnes
            $row = array_combine($header, $data);
            $title = $row['post_title'];
            $reference = $row['meta:reference'];
            $annee = $row['meta:annee'];
            $format = $row['meta:format'];
            $type = $row['meta:type'];
            $thumbnail_id = intval($row['meta:_thumbnail_id']);
            $category = $row['post_category'];

            // Trouver l'article par titre (suppose titre unique)
            $post = get_page_by_title($title, OBJECT, 'post');
            if ($post) {
                // Ajouter les meta personnalisées
                update_post_meta($post->ID, 'reference', $reference);
                update_post_meta($post->ID, 'annee', $annee);
                update_post_meta($post->ID, 'format', $format);
                update_post_meta($post->ID, 'type', $type);

                // Assigner l'image à la une si l'ID est valide
                if ($thumbnail_id > 0) {
                    set_post_thumbnail($post->ID, $thumbnail_id);
                }

                // Facultatif : assigner la catégorie si besoin (mais normalement OK)
                wp_set_post_terms($post->ID, [$category], 'category', true);
            }
        }
        fclose($handle);
    }
}
// Exécuter la fonction une fois après import
add_action('admin_init', 'rsc_import_custom_meta_and_thumbnail');

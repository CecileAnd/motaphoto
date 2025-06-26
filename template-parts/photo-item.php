<?php
// Fichier : template-parts/photo-item.php

$full_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$thumbnail_url  = get_the_post_thumbnail_url(get_the_ID(), 'full');
$titre          = get_the_title();
$categories     = get_the_terms(get_the_ID(), 'photo_categorie');
$cat_name       = $categories && !is_wp_error($categories) ? $categories[0]->name : '';
$fullscreen     = get_template_directory_uri() . '/assets/images/icons/Icon_fullscreen.png';
$eye            = get_template_directory_uri() . '/assets/images/icons/Icon_eye.png';
?>

<article class="carte">
  <img class="image-carte" src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($titre); ?>" />

  <div class="overlay">
    <div class="icone-full">
      <!-- Lien uniquement sur l’icône fullscreen -->
      <a href="<?php echo esc_url($full_image_url); ?>" data-lightbox="galerie" data-title="<?php echo esc_attr($titre); ?>">
        <img src="<?php echo esc_url($fullscreen); ?>" alt="icone fullscreen" />
      </a>
    </div>

    <div class="icone-oeil">
      <!-- Lien vers la page single.php du post -->
      <a href="<?php the_permalink(); ?>">
        <img src="<?php echo esc_url($eye); ?>" alt="icone oeil" />
      </a>
    </div>

    <div class="infos-bas">
      <span class="gauche"><?php echo esc_html($titre); ?></span>
      <span class="droite"><?php echo esc_html($cat_name); ?></span>
    </div>
  </div>
</article>

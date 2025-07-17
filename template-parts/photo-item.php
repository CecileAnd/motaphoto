<?php
$titre      = get_the_title();
$reference  = get_post_meta(get_the_ID(), 'reference', true);
$categories = get_the_terms(get_the_ID(), 'photo_categorie');
$cat_name   = $categories && !is_wp_error($categories) ? $categories[0]->name : '';
$fullscreen = get_template_directory_uri() . '/assets/images/icons/Icon_fullscreen.png';
$eye        = get_template_directory_uri() . '/assets/images/icons/Icon_eye.png';

$image_id   = get_post_thumbnail_id();
$full_image_url = wp_get_attachment_image_url($image_id, 'full'); // pour le lien fullscreen

// Préparer le contenu du data-title
$data_title = esc_html($reference);
if ($cat_name) {
  $data_title .= ' <span class="categorie">' . esc_html($cat_name) . '</span>';
}
?>

<article class="carte">
  <?php
  echo wp_get_attachment_image($image_id, 'medium_large', false, [
      'class' => 'image-carte',
      'alt'   => esc_attr($titre),
  ]);
  ?>

  <div class="lb-details">
    <span class="lb-caption"><?php echo esc_html($reference); ?></span>
    <span class="lb-categorie"><?php echo esc_html($cat_name); ?></span>
  </div>

  <div class="overlay">
    <div class="icone-full">
      <a href="<?php echo esc_url($full_image_url); ?>" data-lightbox="galerie" data-title='<?php echo $data_title; ?>'>
        <img src="<?php echo esc_url($fullscreen); ?>" alt="icone fullscreen" />
      </a>
    </div>

    <div class="icone-oeil">
      <a href="<?php the_permalink(); ?>">
        <img src="<?php echo esc_url($eye); ?>" alt="icone oeil" />
      </a>
    </div>

    <div class="infos-bas">
      <span class="gauche"><?php echo esc_html($reference); ?></span>
      <span class="droite"><?php echo esc_html($cat_name); ?></span>
    </div>
  </div>
</article>

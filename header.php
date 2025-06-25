<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Space+Mono&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css" />
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <header class="index">
    <div class="conteneur-principal">
      <div class="logo">
  <a href="<?php echo home_url(); ?>">
    <img class="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/logo-mota.png" alt="logo Nathalie Mota" />
  </a>
</div>

      <!-- Burger menu CSS -->
      <button class="burger-menu" aria-label="Ouvrir le menu" aria-expanded="false">
        <span class="burger-bar"></span>
        <span class="burger-bar"></span>
        <span class="burger-bar"></span>
      </button>

      <nav class="menu" aria-label="Menu principal" id="main-menu">
        <?php 
        wp_nav_menu([
          'theme_location' => 'header',
          'container' => false,
          'menu_class' => 'menu-list'
        ]); ?>
      </nav>
    </div>
  </header>

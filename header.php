<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
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
        <img class="logo" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/logo-mota.png" alt="logo Nathalie Mota" />
      </div>
      <button class="burger-menu" aria-label="Ouvrir le menu"><img class="burger-menu" src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/hamburger.png" alt="icon menu burger" />
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


 
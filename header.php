<!doctype html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  <link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/style.css" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<header>
    <div class="conteneur-principal">
      <div class="logo">
        <img class="logo" src="<?php echo get_template_directory_uri();?>/images/logo/logo-mota.png" alt="logo Nathalie Mota" />
      </div>
      <button class="burger-menu" aria-label="Ouvrir le menu">
      ☰
    </button>
      <nav class="menu" aria-label="Menu principal" id="main-menu">
        <a class="element-menu" href="#accueil">Accueil</a>
        <a class="element-menu" href="#a-propos">À propos</a>
        <a id="contact-link" class="element-menu" href="#contact">Contact</a>
      </nav>
    </div>
    <div class="image-header">
      <img class="image-header" src="<?php echo get_template_directory_uri();?>/images/Header.png" alt="image montrant des personnes de dos regardant d'autres personnes sous des lumières - inscription 'photographe event' sur l'image" />
    </div>
  </header>



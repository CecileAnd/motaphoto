<!doctype html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<nav>
	<img src="<?php echo get_template_directory_uri();?>/images/logo/logo-mota.png" width="200" alt="logo">
	<a href="#accueil">Accueil</a>
	<a href="#a-propos">À propos</a>
	<a href="#" id="open-contact">Contact</a>
</nav>



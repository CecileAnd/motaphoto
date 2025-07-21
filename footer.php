<footer class="pied-de-page">
   <?php 
    wp_nav_menu([
        'theme_location' => 'footer',
        'container' => false,
        'menu_class' => 'ul-pied-de-page',
        'menu_id' => 'pied-de-page',
    ]); 
    ?>
</footer>

<?php get_template_part('template-parts/modal-contact'); ?>

<?php wp_footer(); ?>

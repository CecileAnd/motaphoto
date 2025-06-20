  <footer class="pied-de-page">
     <?php 
      wp_nav_menu([
      'theme_location' => 'footer',
      'container' => false,
      'menu_class' => 'ul-pied-de-page',
      'menu_id' => 'pied-de-page'
      ]); ?>
  </footer>
<div class="modal" id="modal">
  <div class="modal-content">
    <button class="close-modal" aria-label="Fermer la modale">&times;</button>
    <h2>Contactez-nous</h2>
    <div id="contact-modal" class="modal">
    <?php echo do_shortcode('[contact-form-7 id="3c6e00f" title="Contact"]'); ?>
    </div>
  </div>
</div>
<?php wp_footer(); ?>
  <script src="<?php echo get_template_directory_uri();?>/assets/js/script.js"></script>
  <!-- JS Lightbox2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

</body>
</html>


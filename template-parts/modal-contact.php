<div class="modal" id="contact-modal" style="display: none;">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modal-title" tabindex="-1">
        <h2 id="modal-title" class="sr-only">Formulaire de contact</h2>
        <button class="close-modal" aria-label="Fermer la modale">&times;</button>

        <div class="contact-header">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contact-header/contact-header.png" alt="En-tête contact" />
        </div>

        <?php
        echo do_shortcode('[contact-form-7 id="3c6e00f" title="Contact"]');
        ?>
    </div>
</div>

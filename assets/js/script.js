jQuery(document).ready(function($) {
  // Ouvrir la modale au clic sur le lien Contact (avec classe open-contact-modal)
  $('.open-contact-modal').on('click', function(e) {
    e.preventDefault();
    $('#modal').fadeIn();
  });

  // Fermer la modale au clic sur le bouton fermer (la croix)
  $('.close-modal').on('click', function() {
    $('#modal').fadeOut();
  });

  // Fermer la modale si clic en dehors du contenu (sur le fond)
  $(document).on('click', function(e) {
    if ($(e.target).is('#modal')) {
      $('#modal').fadeOut();
    }
  });

  // Optional : fermer la modale avec la touche Échap
  $(document).on('keydown', function(e) {
    if (e.key === "Escape") {
      $('#modal').fadeOut();
    }
  });
});

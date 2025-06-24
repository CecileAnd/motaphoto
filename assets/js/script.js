console.log("script.js chargé");

jQuery(document).ready(function($) {
  // --- MODALE DE CONTACT ---
  $(document).on('click', 'li.open-contact-modal > a', function(e) {
    e.preventDefault();
    console.log('Ouverture modale demandée');
    $('#modal').fadeIn();  // Affiche la modale avec un effet fondu
  });

  $('.close-modal').on('click', function() {
    $('#modal').fadeOut(); // Ferme la modale avec un effet fondu
  });

  $(document).on('click', function(e) {
    if ($(e.target).is('#modal')) {
      $('#modal').fadeOut(); // Ferme la modale si clic en dehors du contenu
    }
  });

  $(document).on('keydown', function(e) {
    if (e.key === "Escape") {
      $('#modal').fadeOut(); // Ferme la modale avec la touche Échap
    }
  });

  // --- MENU BURGER ---
  $('.burger-menu').on('click', function () {
    $(this).toggleClass('open');
    $('.menu').toggleClass('active');

    const expanded = $(this).attr('aria-expanded') === 'true';
    $(this).attr('aria-expanded', !expanded);
  });

  $('.menu a').on('click', function () {
    $('.burger-menu').removeClass('open');
    $('.menu').removeClass('active');
    $('.burger-menu').attr('aria-expanded', 'false');
  });
});

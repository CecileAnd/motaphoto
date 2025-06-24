console.log("script.js chargé");

jQuery(document).ready(function($) {
  // --- MODALE DE CONTACT ---
  $(document).on('click', 'li.open-contact-modal > a', function(e) {
    e.preventDefault();
    $('#modal').fadeIn();
  });

  $('.close-modal').on('click', function() {
    $('#modal').fadeOut();
  });

  $(document).on('click', function(e) {
    if ($(e.target).is('#modal')) {
      $('#modal').fadeOut();
    }
  });

  $(document).on('keydown', function(e) {
    if (e.key === "Escape") {
      $('#modal').fadeOut();
    }
  });

  // --- MENU BURGER ---
  $('.burger-menu').on('click', function () {
    $(this).toggleClass('open');
    $('.menu').toggleClass('active');

    const expanded = $(this).attr('aria-expanded') === 'true';
    $(this).attr('aria-expanded', !expanded);
  });

  // Fermer le menu quand on clique sur un lien du menu (utile sur mobile)
  $('.menu a').on('click', function () {
    $('.burger-menu').removeClass('open').attr('aria-expanded', 'false');
    $('.menu').removeClass('active');
  });
});

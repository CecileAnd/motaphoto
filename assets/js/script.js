jQuery(document).ready(function($) {
  // --- MODALE ---
  $('.open-contact-modal').on('click', function(e) {
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

  $('.menu a').on('click', function () {
    $('.burger-menu').removeClass('open');
    $('.menu').removeClass('active');
    $('.burger-menu').attr('aria-expanded', 'false');
  });
});

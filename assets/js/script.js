console.log("script.js chargé");


// gestion miniatures
document.addEventListener("DOMContentLoaded", function () {
    const miniatureImage = document.getElementById("miniature-image");
    const miniatureLink = document.getElementById("miniature-link");

    if (!miniatureImage || !miniatureLink) return;

    const defaultSrc = miniatureImage.src;
    const defaultHref = miniatureLink.href;

    const fleches = document.querySelectorAll(".navigation-fleches .fleche");

    fleches.forEach((fleche) => {
        fleche.addEventListener("mouseenter", () => {
            const newSrc = fleche.getAttribute("data-thumb");
            const newHref = fleche.getAttribute("data-link");
            if (newSrc) miniatureImage.src = newSrc;
            if (newHref) miniatureLink.href = newHref;
        });

        fleche.addEventListener("mouseleave", () => {
            miniatureImage.src = defaultSrc;
            miniatureLink.href = defaultHref;
        });
    });
});

jQuery(document).ready(function($) {
  

  // --- MODALE DE CONTACT ---
  $(document).on('click', 'li.contact-button > a', function(e) {
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

/* //Prérenseignement champ référence
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('modal');

  // Cibler uniquement le bouton "Contact" dans .interet-contact
  const interetContactButton = document.querySelector('.interet-contact .bouton-contact');

  if (interetContactButton) {
    interetContactButton.addEventListener('click', function(event) {
      event.preventDefault();
      const reference = interetContactButton.getAttribute('data-reference');

      // Ouvre la modale
      modal.classList.add('show');

      // Remplit le champ référence
      const referenceField = document.getElementById('contact-reference');
      if (referenceField && reference) {
        referenceField.value = reference;
      }
    });
  }

  // Fermer la modale et vider le champ référence
  const closeModal = document.querySelector('.close-modal');
  if (closeModal) {
    closeModal.addEventListener('click', function() {
      modal.classList.remove('show');
      const referenceField = document.getElementById('contact-reference');
      if (referenceField) referenceField.value = '';
    });
  }
});
}); */


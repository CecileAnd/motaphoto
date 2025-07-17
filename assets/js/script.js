document.addEventListener("DOMContentLoaded", function () {
  // Miniatures (flèches gauche/droite)
  const miniatureImage = document.getElementById("miniature-image");
  const miniatureLink = document.getElementById("miniature-link");

  const flecheGauche = document.querySelector(".fleche.gauche");
  const flecheDroite = document.querySelector(".fleche.droite");

  const defaultThumb = miniatureImage ? miniatureImage.getAttribute("src") : "";
  const defaultLink = miniatureLink ? miniatureLink.getAttribute("href") : "";

  function setMiniature(thumb, link) {
    if (miniatureImage && miniatureLink) {
      miniatureImage.setAttribute("src", thumb);
      miniatureLink.setAttribute("href", link);
    }
  }

  if (flecheGauche) {
    flecheGauche.addEventListener("mouseenter", function () {
      const thumb = this.dataset.thumb;
      const link = this.dataset.link;
      setMiniature(thumb, link);
    });

    flecheGauche.addEventListener("mouseleave", function () {
      setMiniature(defaultThumb, defaultLink);
    });
  }

  if (flecheDroite) {
    flecheDroite.addEventListener("mouseenter", function () {
      const thumb = this.dataset.thumb;
      const link = this.dataset.link;
      setMiniature(thumb, link);
    });

    flecheDroite.addEventListener("mouseleave", function () {
      setMiniature(defaultThumb, defaultLink);
    });
  }

  // Menu burger
  const burger = document.querySelector('.burger-menu');
  const menu = document.querySelector('.menu');

  if (burger && menu) {
    burger.addEventListener('click', function () {
      menu.classList.toggle('open');
      const expanded = burger.getAttribute('aria-expanded') === 'true';
      burger.setAttribute('aria-expanded', !expanded);
    });
  }
});

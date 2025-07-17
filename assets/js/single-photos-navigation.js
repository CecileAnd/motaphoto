document.addEventListener('DOMContentLoaded', () => {
  // On récupère les éléments
  const miniatureImage = document.getElementById('miniature-image');
  const miniatureLink = document.getElementById('miniature-link');

  const flecheGauche = document.querySelector('.fleche.gauche');
  const flecheDroite = document.querySelector('.fleche.droite');

  if (!miniatureImage || !miniatureLink) return;

  // Stocker les valeurs par défaut pour remettre au survol out
  const defaultSrc = miniatureImage.src;
  const defaultAlt = miniatureImage.alt;
  const defaultHref = miniatureLink.href;

  // Fonction pour changer l'image miniature et le lien
  function changerMiniature(src, alt, href) {
    miniatureImage.src = src;
    miniatureImage.alt = alt;
    miniatureLink.href = href;
  }

  // Survol flèche gauche
  if (flecheGauche) {
    flecheGauche.addEventListener('mouseenter', () => {
      const thumb = flecheGauche.getAttribute('data-thumb');
      const link = flecheGauche.getAttribute('data-link');
      const alt = flecheGauche.getAttribute('aria-label') || 'Photo précédente';
      if (thumb && link) {
        changerMiniature(thumb, alt, link);
      }
    });
    flecheGauche.addEventListener('mouseleave', () => {
      changerMiniature(defaultSrc, defaultAlt, defaultHref);
    });
  }

  // Survol flèche droite
  if (flecheDroite) {
    flecheDroite.addEventListener('mouseenter', () => {
      const thumb = flecheDroite.getAttribute('data-thumb');
      const link = flecheDroite.getAttribute('data-link');
      const alt = flecheDroite.getAttribute('aria-label') || 'Photo suivante';
      if (thumb && link) {
        changerMiniature(thumb, alt, link);
      }
    });
    flecheDroite.addEventListener('mouseleave', () => {
      changerMiniature(defaultSrc, defaultAlt, defaultHref);
    });
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const selects = document.querySelectorAll('.filtre-select');
  const photos = document.querySelectorAll('.colonnes-images article');

  function filtrePhotos() {
    const filtreCategorie = document.getElementById('filtre-categorie').value;
    const filtreAnnee = document.getElementById('filtre-annee').value;
    const filtreFormat = document.getElementById('filtre-format').value;
    const filtreType = document.getElementById('filtre-type').value;

    photos.forEach(photo => {
      const cat = photo.getAttribute('data-categorie');
      const annee = photo.getAttribute('data-annee');
      const format = photo.getAttribute('data-format');
      const type = photo.getAttribute('data-type');

      let show = true;
      if (filtreCategorie && filtreCategorie !== cat) show = false;
      if (filtreAnnee && filtreAnnee !== annee) show = false;
      if (filtreFormat && filtreFormat !== format) show = false;
      if (filtreType && filtreType !== type) show = false;

      photo.style.display = show ? 'block' : 'none';
    });
  }

  selects.forEach(select => {
    select.addEventListener('change', filtrePhotos);
  });
});

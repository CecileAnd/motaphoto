document.addEventListener("DOMContentLoaded", function () {
    const miniatureImage = document.getElementById("miniature-image");
    const miniatureLink = document.getElementById("miniature-link");

    const flecheGauche = document.querySelector(".fleche.gauche");
    const flecheDroite = document.querySelector(".fleche.droite");

    const defaultThumb = miniatureImage.getAttribute("src");
    const defaultLink = miniatureLink.getAttribute("href");

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
});

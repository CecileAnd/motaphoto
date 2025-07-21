document.addEventListener('DOMContentLoaded', function() {
    const contactButtons = document.querySelectorAll('.contact-button');
    const modal = document.getElementById('contact-modal');
    const closeModal = modal.querySelector('.close-modal');
    const referenceInput = modal.querySelector('#photo-reference');

    contactButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const reference = this.dataset.reference || '';
            referenceInput.value = reference;
            modal.style.display = 'flex';
            referenceInput.focus();
        });
    });

    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Optionnel : fermer la modale avec la touche Échap
    document.addEventListener('keydown', function(e) {
        if (e.key === "Escape" && modal.style.display === 'flex') {
            modal.style.display = 'none';
        }
    });
});

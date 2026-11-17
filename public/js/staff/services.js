document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('addServiceModal');
    const openButton = document.getElementById('openAddService');
    const closeButton = document.getElementById('closeAddService');
    const cancelButton = document.getElementById('cancelAddService');

    if (!modal) return;

    function openModal() {
        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
    }

    openButton?.addEventListener('click', openModal);
    closeButton?.addEventListener('click', closeModal);
    cancelButton?.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    // Reopen the form if Laravel returns validation errors.
    if (modal.querySelector('.error-message') ||
        document.querySelector('.services-page .error-message')) {
        openModal();
    }
});

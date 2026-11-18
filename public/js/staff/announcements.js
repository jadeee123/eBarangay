document.addEventListener('DOMContentLoaded', function () {
    const addModal = document.getElementById('addAnnouncementModal');
    const editModal = document.getElementById('editAnnouncementModal');

    const openAddButton = document.getElementById('openAddAnnouncement');
    const closeAddButton = document.getElementById('closeAddAnnouncement');
    const cancelAddButton = document.getElementById('cancelAddAnnouncement');

    const closeEditButton = document.getElementById('closeEditAnnouncement');
    const cancelEditButton = document.getElementById('cancelEditAnnouncement');

    const editForm = document.getElementById('editAnnouncementForm');
    const editTitle = document.getElementById('editAnnouncementTitle');
    const editContent = document.getElementById('editAnnouncementContent');
    const editPublished = document.getElementById('editAnnouncementPublished');

    function openModal(modal) {
        if (modal) {
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
        }
    }

    openAddButton?.addEventListener('click', function () {
        openModal(addModal);
    });

    closeAddButton?.addEventListener('click', function () {
        closeModal(addModal);
    });

    cancelAddButton?.addEventListener('click', function () {
        closeModal(addModal);
    });

    closeEditButton?.addEventListener('click', function () {
        closeModal(editModal);
    });

    cancelEditButton?.addEventListener('click', function () {
        closeModal(editModal);
    });

    document.querySelectorAll('.edit-announcement-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            editTitle.value = this.dataset.title || '';
            editContent.value = this.dataset.content || '';
            editPublished.checked = this.dataset.published === '1';

           editForm.action = editForm.dataset.updateUrl + '/' + encodeURIComponent(id);
            openModal(editModal);
        });
    });

    [addModal, editModal].forEach(function (modal) {
        modal?.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal(modal);
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal(addModal);
            closeModal(editModal);
        }
    });
});

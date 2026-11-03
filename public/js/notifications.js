
document.addEventListener('DOMContentLoaded', function () {
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationPanel = document.getElementById('notificationPanel');

    if (!notificationBtn || !notificationPanel) {
        return;
    }

    function closeNotifications() {
        notificationPanel.hidden = true;
        notificationBtn.setAttribute('aria-expanded', 'false');
    }

    function toggleNotifications() {
        const isOpening = notificationPanel.hidden;

        notificationPanel.hidden = !isOpening;
        notificationBtn.setAttribute(
            'aria-expanded',
            String(isOpening)
        );
    }

    notificationBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        toggleNotifications();
    });

    notificationPanel.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.notification-wrapper')) {
            closeNotifications();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeNotifications();
            notificationBtn.focus();
        }
    });
});

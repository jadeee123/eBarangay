
document.addEventListener('DOMContentLoaded', function () {
    // Sidebar
    const staffLayout = document.getElementById('staffLayout');
    const menuToggle = document.getElementById('staffMenuToggle');
    const sidebarOverlay = document.getElementById('staffSidebarOverlay');

    // Notifications
    const notificationToggle = document.getElementById('staffNotificationToggle');
    const notificationPanel = document.getElementById('staffNotificationPanel');

    // Contact message popup
    const messageModal = document.getElementById('staffMessageModal');
    const closeMessageModal = document.getElementById('closeMessageModal');

    // Logout
    const logoutForm = document.getElementById('staffLogoutForm');
    const logoutTrigger = document.getElementById('staffLogoutTrigger');
    const logoutModal = document.getElementById('staffLogoutModal');
    const cancelLogout = document.getElementById('staffCancelLogout');
    const confirmLogout = document.getElementById('staffConfirmLogout');

    // Close mobile sidebar
    function closeSidebar() {
        if (!staffLayout || !menuToggle) return;

        staffLayout.classList.remove('sidebar-open');
        menuToggle.setAttribute('aria-expanded', 'false');

        if (sidebarOverlay) {
            sidebarOverlay.hidden = true;
        }
    }

    if (staffLayout && menuToggle) {
        menuToggle.addEventListener('click', function () {
            const isOpen = staffLayout.classList.toggle('sidebar-open');

            menuToggle.setAttribute('aria-expanded', String(isOpen));

            if (sidebarOverlay) {
                sidebarOverlay.hidden = !isOpen;
            }
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    document.querySelectorAll('.staff-nav-link').forEach(function (link) {
        link.addEventListener('click', closeSidebar);
    });

    // Notification panel
    function closeNotifications() {
        if (!notificationPanel || !notificationToggle) return;

        notificationPanel.hidden = true;
        notificationToggle.setAttribute('aria-expanded', 'false');
    }

    if (notificationToggle && notificationPanel) {
        notificationToggle.addEventListener('click', function (event) {
            event.stopPropagation();

            const willOpen = notificationPanel.hidden;

            notificationPanel.hidden = !willOpen;
            notificationToggle.setAttribute('aria-expanded', String(willOpen));
        });

        notificationPanel.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        document.addEventListener('click', function () {
            closeNotifications();
        });
    }

    // Contact message popup
    function openMessageModal(notification) {
        if (!messageModal) return;

        const sender = document.getElementById('messageSender');
        const email = document.getElementById('messageEmail');
        const subject = document.getElementById('messageSubject');
        const date = document.getElementById('messageDate');
        const fullText = document.getElementById('messageFullText');

        if (sender) sender.textContent = notification.dataset.name || '';
        if (email) email.textContent = notification.dataset.email || '';
        if (subject) subject.textContent = notification.dataset.subject || '';
        if (date) date.textContent = notification.dataset.date || '';
        if (fullText) fullText.textContent = notification.dataset.message || '';

        messageModal.hidden = false;
        const replyForm = document.getElementById('staffReplyForm');

if (replyForm) {
    replyForm.action = notification.dataset.replyUrl || '';
}

const replyMessage = document.getElementById('replyMessage');

if (replyMessage) {
    replyMessage.value = '';
}
    }

    document.querySelectorAll('.staff-notification-item').forEach(function (notification) {
        notification.addEventListener('click', function () {
            openMessageModal(notification);
        });

        notification.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openMessageModal(notification);
            }
        });
    });

    function closeMessageDetails() {
        if (messageModal) {
            messageModal.hidden = true;
        }
    }

    if (closeMessageModal) {
        closeMessageModal.addEventListener('click', closeMessageDetails);
    }

    if (messageModal) {
        messageModal.addEventListener('click', function (event) {
            if (event.target === messageModal) {
                closeMessageDetails();
            }
        });
    }

    // Logout confirmation
    function openLogoutModal() {
        if (!logoutModal) return;

        logoutModal.hidden = false;

        if (cancelLogout) {
            cancelLogout.focus();
        }
    }

    function closeLogoutModal() {
        if (!logoutModal) return;

        logoutModal.hidden = true;

        if (logoutTrigger) {
            logoutTrigger.focus();
        }
    }

    if (logoutTrigger && logoutModal && logoutForm) {
        logoutTrigger.addEventListener('click', openLogoutModal);

        if (cancelLogout) {
            cancelLogout.addEventListener('click', closeLogoutModal);
        }

        logoutModal.addEventListener('click', function (event) {
            if (event.target === logoutModal) {
                closeLogoutModal();
            }
        });

        if (confirmLogout) {
            confirmLogout.addEventListener('click', function () {
                logoutForm.submit();
            });
        }
    }

    // Escape closes open panels and modals
    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') return;

        closeNotifications();
        closeSidebar();
        closeMessageDetails();

        if (logoutModal && !logoutModal.hidden) {
            closeLogoutModal();
        }
    });
});

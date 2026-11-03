document.addEventListener('DOMContentLoaded', function () {

    const menuItems = document.querySelectorAll('.settings-menu-item');
    const panels = document.querySelectorAll('.settings-panel');

    menuItems.forEach(function (item) {
        item.addEventListener('click', function () {
            const panelName = item.dataset.panel;

            menuItems.forEach(function (menuItem) {
                menuItem.classList.remove('active');
            });

            panels.forEach(function (panel) {
                panel.classList.remove('active');
                panel.hidden = true;
            });

            item.classList.add('active');

            const selectedPanel = document.getElementById(
                panelName + '-panel'
            );

            if (selectedPanel) {
                selectedPanel.hidden = false;
                selectedPanel.classList.add('active');
            }
        });
    });

    function showMessage(id, message) {
        const element = document.getElementById(id);

        if (element) {
            element.textContent = message;
        }
    }

    const accountForm = document.getElementById('accountForm');

    if (accountForm) {
        accountForm.addEventListener('submit', function (event) {
            event.preventDefault();

            showMessage(
                'accountMessage',
                'Account saving is not connected to the database yet.'
            );
        });
    }

    const notificationForm = document.getElementById('notificationForm');

    if (notificationForm) {
        notificationForm.addEventListener('submit', function (event) {
            event.preventDefault();

            showMessage(
                'notificationMessage',
                'Notification preferences are not saved yet.'
            );
        });
    }

    const privacyForm = document.getElementById('privacyForm');

    if (privacyForm) {
        privacyForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const currentPassword =
                document.getElementById('currentPassword').value;

            const newPassword =
                document.getElementById('newPassword').value;

            const confirmPassword =
                document.getElementById('confirmPassword').value;

            if (!currentPassword || !newPassword || !confirmPassword) {
                showMessage(
                    'privacyMessage',
                    'Please complete all password fields.'
                );
                return;
            }

            if (newPassword !== confirmPassword) {
                showMessage(
                    'privacyMessage',
                    'The new passwords do not match.'
                );
                return;
            }

            showMessage(
                'privacyMessage',
                'Password updating requires secure Laravel backend validation.'
            );
        });
    }
});

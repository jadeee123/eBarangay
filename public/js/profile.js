document.addEventListener('DOMContentLoaded', function () {

    const params = new URLSearchParams(window.location.search);
    const requestedPanel = params.get('panel');
    
    if (requestedPanel) {
    const targetMenu = document.querySelector(
        `.settings-menu-item[data-panel="${requestedPanel}"]`
    );

    if (targetMenu) {
        targetMenu.click();
    }
}

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

    const notificationForm = document.getElementById('notificationForm');
});

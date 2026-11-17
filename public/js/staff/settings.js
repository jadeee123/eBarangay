document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.settings-tab');
    const panels = document.querySelectorAll('.settings-panel');

    function showPanel(name) {
        tabs.forEach(function (tab) {
            const active = tab.dataset.panel === name;

            tab.classList.toggle('active', active);
            tab.setAttribute('aria-selected', String(active));
        });

        panels.forEach(function (panel) {
            const active = panel.id === 'panel-' + name;

            panel.hidden = !active;
            panel.classList.toggle('active', active);
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            showPanel(tab.dataset.panel);
        });
    });

    // Reopen the relevant section if Laravel returns validation errors.
    const errorList = document.querySelector('.settings-alert.error');

    if (errorList) {
        const errorText = errorList.textContent.toLowerCase();

        if (errorText.includes('password')) {
            showPanel('security');
        } else if (
            errorText.includes('notification') ||
            errorText.includes('new_requests') ||
            errorText.includes('claim_reminders')
        ) {
            showPanel('notifications');
        } else if (
            errorText.includes('barangay') ||
            errorText.includes('office_hours') ||
            errorText.includes('claim_instructions')
        ) {
            showPanel('barangay');
        }
    }
});

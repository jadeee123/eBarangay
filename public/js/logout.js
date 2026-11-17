
document.addEventListener('DOMContentLoaded', function () {
    const logoutForm = document.getElementById('logoutForm');
    const logoutTrigger = document.getElementById('logoutTrigger');
    const logoutModal = document.getElementById('logoutModal');
    const cancelLogout = document.getElementById('cancelLogout');
    const confirmLogout = document.getElementById('confirmLogout');

    if (!logoutForm || !logoutTrigger || !logoutModal) return;

    logoutTrigger.addEventListener('click', function () {
        logoutModal.hidden = false;
        cancelLogout.focus();
    });

    cancelLogout.addEventListener('click', function () {
        logoutModal.hidden = true;
        logoutTrigger.focus();
    });

    logoutModal.addEventListener('click', function (event) {
        if (event.target === logoutModal) {
            logoutModal.hidden = true;
            logoutTrigger.focus();
        }
    });

    confirmLogout.addEventListener('click', function () {
        logoutForm.submit();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !logoutModal.hidden) {
            logoutModal.hidden = true;
            logoutTrigger.focus();
        }
    });
});

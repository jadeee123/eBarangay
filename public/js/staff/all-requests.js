document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('requestSearch');
    const statusFilter = document.getElementById('requestStatusFilter');
    const showAllButton = document.getElementById('showAllBtn');
    const tableBody = document.getElementById('allRequestsTable');
    const emptyRow = document.getElementById('allRequestsEmpty');
    const noMatchesRow = document.getElementById('noMatchingRequests');

    if (!searchInput || !statusFilter || !tableBody) {
        return;
    }

    function filterRequests() {
        const searchText = searchInput.value.trim().toLowerCase();
        const selectedStatus = statusFilter.value.toLowerCase();
        const rows = tableBody.querySelectorAll('tr');

        let visibleCount = 0;

        rows.forEach(function (row) {
            if (
                row.id === 'allRequestsEmpty' ||
                row.id === 'noMatchingRequests'
            ) {
                return;
            }

            const rowText = row.textContent.toLowerCase();
            const statusElement = row.querySelector('.request-status');
            const rowStatus = statusElement
                ? statusElement.dataset.status.toLowerCase()
                : '';

            const matchesSearch = rowText.includes(searchText);
            const matchesStatus =
                selectedStatus === '' || rowStatus === selectedStatus;

            const showRow = matchesSearch && matchesStatus;

            row.hidden = !showRow;

            if (showRow) {
                visibleCount++;
            }
        });

        const hasRequests = tableBody.querySelector(
            'tr:not(#allRequestsEmpty):not(#noMatchingRequests)'
        );

        if (emptyRow) {
            emptyRow.hidden = Boolean(hasRequests);
        }

        if (noMatchesRow) {
            noMatchesRow.hidden =
                !hasRequests || visibleCount > 0;
        }
    }

    searchInput.addEventListener('input', filterRequests);
    statusFilter.addEventListener('change', filterRequests);

    showAllButton?.addEventListener('click', function () {
        searchInput.value = '';
        statusFilter.value = '';
        filterRequests();
    });

    filterRequests();
});

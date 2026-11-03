
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.request-tab');
    const searchInput = document.getElementById('requestSearch');
    const requestTable = document.getElementById('requestTable');
    const emptyState = document.getElementById('emptyState');

    const filterButton = document.getElementById('requestFilterBtn');
    const filterPanel = document.getElementById('requestFilterPanel');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const statusFilter = document.getElementById('statusFilter');
    const clearFilters = document.getElementById('clearFilters');

    if (!requestTable || !emptyState) return;

    let selectedTab = 'active';

    function updateRequests() {
        const rows = requestTable.querySelectorAll('tr');
        const searchValue = searchInput.value.toLowerCase().trim();
        const fromDate = dateFrom.value;
        const toDate = dateTo.value;
        const selectedStatus = statusFilter.value;

        let visibleCount = 0;

        rows.forEach(function (row) {
            const rowDate = row.dataset.date || '';
            const rowStatus = (row.dataset.status || '').toLowerCase();
            const rowText = row.textContent.toLowerCase();

            const matchesTab = selectedTab === 'completed'
                ? rowStatus === 'completed'
                : rowStatus !== 'completed';

            const matchesSearch = rowText.includes(searchValue);

            const matchesFromDate = !fromDate ||
                (rowDate && rowDate >= fromDate);

            const matchesToDate = !toDate ||
                (rowDate && rowDate <= toDate);

            const matchesStatus = selectedStatus === 'all' ||
                rowStatus === selectedStatus;

            const shouldShow =
                matchesTab &&
                matchesSearch &&
                matchesFromDate &&
                matchesToDate &&
                matchesStatus;

            row.hidden = !shouldShow;

            if (shouldShow) {
                visibleCount++;
            }
        });

        emptyState.hidden = visibleCount > 0;
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (item) {
                item.classList.remove('active');
            });

            tab.classList.add('active');
            selectedTab = tab.dataset.status;
            updateRequests();
        });
    });

    filterButton.addEventListener('click', function () {
        filterPanel.hidden = !filterPanel.hidden;
    });

    searchInput.addEventListener('input', updateRequests);
    dateFrom.addEventListener('change', updateRequests);
    dateTo.addEventListener('change', updateRequests);
    statusFilter.addEventListener('change', updateRequests);

    clearFilters.addEventListener('click', function () {
        dateFrom.value = '';
        dateTo.value = '';
        statusFilter.value = 'all';
        searchInput.value = '';
        updateRequests();
    });

    updateRequests();
});

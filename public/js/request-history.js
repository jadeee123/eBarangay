document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('historySearch');
    const historyTable = document.getElementById('historyTable');
    const emptyState = document.getElementById('historyEmptyState');
    const filterButton = document.getElementById('historyFilterBtn');
    const statusFilter = document.getElementById('historyStatusFilter');

    if (!historyTable || !emptyState) return;

    function updateHistory() {
        const rows = historyTable.querySelectorAll('tr');
        const searchValue = searchInput.value.toLowerCase().trim();
        const selectedStatus = statusFilter.value;
        let visibleCount = 0;

        rows.forEach(function (row) {
            const matchesSearch = row.textContent
                .toLowerCase()
                .includes(searchValue);

            const rowStatus = (row.dataset.status || '').toLowerCase();

            const matchesStatus =
                selectedStatus === 'all' || rowStatus === selectedStatus;

            const shouldShow = matchesSearch && matchesStatus;

            row.hidden = !shouldShow;

            if (shouldShow) visibleCount++;
        });

        emptyState.hidden = visibleCount > 0;
    }

    filterButton.addEventListener('click', function () {
        statusFilter.hidden = !statusFilter.hidden;
    });

    searchInput.addEventListener('input', updateHistory);
    statusFilter.addEventListener('change', updateHistory);

    updateHistory();
});

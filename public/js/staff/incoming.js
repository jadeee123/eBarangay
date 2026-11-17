document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('incomingSearch');
    const tableBody = document.getElementById('incomingRequestTable');
    const searchEmptyRow = document.getElementById('incomingSearchEmpty');
    const originalEmptyRow = document.getElementById('incomingEmptyRow');

    if (!searchInput || !tableBody) {
        return;
    }

    searchInput.addEventListener('input', function () {
        const searchText = searchInput.value.trim().toLowerCase();
        const rows = tableBody.querySelectorAll('tr');
        let visibleCount = 0;

        rows.forEach(function (row) {
            if (
                row.id === 'incomingSearchEmpty' ||
                row.id === 'incomingEmptyRow'
            ) {
                return;
            }

            const matches = row.textContent.toLowerCase().includes(searchText);

            row.hidden = !matches;

            if (matches) {
                visibleCount++;
            }
        });

        if (searchEmptyRow) {
            searchEmptyRow.hidden = searchText === '' || visibleCount > 0;
        }

        if (originalEmptyRow) {
            originalEmptyRow.hidden = searchText !== '';
        }
    });
});

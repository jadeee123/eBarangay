
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('residentSearch');
    const tableBody = document.getElementById('residentsTable');
    const emptyRow = document.getElementById('residentsEmptyRow');
    const searchEmpty = document.getElementById('residentsSearchEmpty');

    if (!searchInput || !tableBody) return;

    searchInput.addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase().trim();

        const rows = tableBody.querySelectorAll(
            'tr:not(#residentsEmptyRow):not(#residentsSearchEmpty)'
        );

        let visibleCount = 0;

        rows.forEach(function (row) {
            const matches = row.textContent
                .toLowerCase()
                .includes(searchTerm);

            row.hidden = !matches;

            if (matches) {
                visibleCount++;
            }
        });

        if (emptyRow) {
            emptyRow.hidden = rows.length !== 0;
        }

        if (searchEmpty) {
            searchEmpty.hidden =
                rows.length === 0 ||
                visibleCount > 0 ||
                searchTerm === '';
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // FILTER REQUESTS BY STATUS
    const filterCards = document.querySelectorAll('.dashboard-stat');
    const requestRows = document.querySelectorAll(
        '#staffRequestTable tr[data-status]'
    );
    const emptyMessage = document.getElementById('staffFilterEmpty');
    const emptyRow = document.querySelector('.dashboard-empty-row');

    filterCards.forEach(function (card) {
        card.addEventListener('click', function () {
            const selectedFilter = card.dataset.filter;

            filterCards.forEach(function (item) {
                item.classList.remove('active');
            });

            card.classList.add('active');

            let visibleRows = 0;

            requestRows.forEach(function (row) {
                const rowStatus = (row.dataset.status || '').toLowerCase();
                const matches =
                    selectedFilter === 'all' ||
                    rowStatus === selectedFilter;

                row.hidden = !matches;

                if (matches) {
                    visibleRows++;
                }
            });

            if (emptyRow) {
                emptyRow.hidden = selectedFilter !== 'all';
            }

            if (emptyMessage) {
                emptyMessage.hidden = visibleRows > 0 ||
                    (selectedFilter === 'all' && requestRows.length === 0);
            }
        });
    });

    
    // AGE CHART
    const chartCanvas = document.getElementById('staffAgeChart');

    if (chartCanvas && typeof Chart !== 'undefined') {
        const ageLabels = [
            '0–17 years',
            '18–30 years',
            '31–59 years',
            '60+ years'
        ];

        const ageValues = [
            @json($age0to17),
            @json($age18to30),
            @json($age31to59),
            @json($age60Plus)
        ];

        if (ageValues.reduce((total, value) => total + value, 0) > 0) {
            new Chart(chartCanvas, {
                type: 'doughnut',
                data: {
                    labels: ageLabels,
                    datasets: [{
                        data: ageValues,
                        backgroundColor: [
                            '#F4C542',
                            '#E0A800',
                            '#292929',
                            '#BDBDBD'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    }
});

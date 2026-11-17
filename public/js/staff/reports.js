
document.addEventListener('DOMContentLoaded', function () {
    const yellow = '#ffc629';
    const chartColors = [
        '#ffc629',
        '#f3b51b',
        '#292c2a',
        '#f2d45f',
        '#9eaa8b',
        '#e69b37',
        '#d8c48c'
    ];

    // ===== REQUEST TRENDS =====

    const trendCanvas = document.getElementById('requestTrendsChart');

    if (trendCanvas) {
        const period = Number(trendCanvas.dataset.period) || 30;
        const trends = JSON.parse(trendCanvas.dataset.trends || '[]');
        const trendMap = new Map(
            trends.map(item => [item.day, Number(item.total)])
        );

        const dates = [];
        const values = [];
        const today = new Date();

        for (let i = period - 1; i >= 0; i--) {
            const date = new Date(
                today.getFullYear(),
                today.getMonth(),
                today.getDate() - i
            );

            const key = [
                date.getFullYear(),
                String(date.getMonth() + 1).padStart(2, '0'),
                String(date.getDate()).padStart(2, '0')
            ].join('-');

            dates.push(date);
            values.push(trendMap.get(key) || 0);
        }

        function drawTrends() {
            const width = trendCanvas.clientWidth;
            if (!width) return;

            const height = trendCanvas.clientHeight || 245;
            const ratio = window.devicePixelRatio || 1;
            const ctx = trendCanvas.getContext('2d');

            trendCanvas.width = width * ratio;
            trendCanvas.height = height * ratio;
            ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
            ctx.clearRect(0, 0, width, height);

            const pad = { top: 22, right: 12, bottom: 32, left: 30 };
            const chartWidth = width - pad.left - pad.right;
            const chartHeight = height - pad.top - pad.bottom;

            const maxValue = Math.max(4, ...values);
            const scale = Math.ceil(maxValue / 4) * 4;

            // Horizontal grid lines and y-axis labels.
            ctx.font = '10px Arial';
            ctx.textAlign = 'right';
            ctx.textBaseline = 'middle';

            for (let i = 0; i <= 4; i++) {
                const value = scale * i / 4;
                const y = pad.top + chartHeight -
                    (value / scale) * chartHeight;

                ctx.beginPath();
                ctx.strokeStyle = '#f0eee7';
                ctx.lineWidth = 1;
                ctx.moveTo(pad.left, y);
                ctx.lineTo(width - pad.right, y);
                ctx.stroke();

                ctx.fillStyle = '#77766f';
                ctx.fillText(String(Math.round(value)), pad.left - 7, y);
            }

            const points = values.map((value, i) => ({
                x: pad.left + (values.length === 1 ? 0 :
                    i * chartWidth / (values.length - 1)),
                y: pad.top + chartHeight - (value / scale) * chartHeight
            }));

            // Yellow area beneath the line.
            if (points.length) {
                const gradient = ctx.createLinearGradient(
                    0, pad.top, 0, pad.top + chartHeight
                );

                gradient.addColorStop(0, 'rgba(255, 198, 41, 0.25)');
                gradient.addColorStop(1, 'rgba(255, 198, 41, 0.015)');

                ctx.beginPath();
                ctx.moveTo(points[0].x, pad.top + chartHeight);
                ctx.lineTo(points[0].x, points[0].y);

                for (let i = 1; i < points.length; i++) {
                    const midX = (points[i - 1].x + points[i].x) / 2;
                    ctx.quadraticCurveTo(
                        points[i - 1].x,
                        points[i - 1].y,
                        midX,
                        (points[i - 1].y + points[i].y) / 2
                    );
                }

                const last = points[points.length - 1];
                ctx.lineTo(last.x, last.y);
                ctx.lineTo(last.x, pad.top + chartHeight);
                ctx.closePath();
                ctx.fillStyle = gradient;
                ctx.fill();

                // Trend line.
                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);

                for (let i = 1; i < points.length; i++) {
                    const midX = (points[i - 1].x + points[i].x) / 2;
                    const midY = (points[i - 1].y + points[i].y) / 2;

                    ctx.quadraticCurveTo(
                        points[i - 1].x,
                        points[i - 1].y,
                        midX,
                        midY
                    );
                }

                ctx.lineTo(last.x, last.y);
                ctx.strokeStyle = yellow;
                ctx.lineWidth = 2;
                ctx.lineJoin = 'round';
                ctx.lineCap = 'round';
                ctx.stroke();

                // Show the final point.
                points.forEach(point => {
                    ctx.beginPath();
                    ctx.arc(point.x, point.y, 2.5, 0, Math.PI * 2);
                    ctx.fillStyle = yellow;
                    ctx.fill();
                });
            }

            // Date labels, spaced to avoid crowding.
            const labelCount = Math.min(5, dates.length);

            ctx.fillStyle = '#77766f';
            ctx.font = '10px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'top';

            for (let i = 0; i < labelCount; i++) {
                const index = labelCount === 1 ? 0 :
                    Math.round(i * (dates.length - 1) / (labelCount - 1));

                const date = dates[index];
                const label = date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric'
                });

                ctx.fillText(
                    label,
                    points[index].x,
                    pad.top + chartHeight + 10
                );
            }
        }

        drawTrends();
        if ('ResizeObserver' in window) {
            new ResizeObserver(drawTrends).observe(trendCanvas.parentElement);
        } else {
            window.addEventListener('resize', drawTrends);
        }
    }

    // ===== TOP SERVICES DONUT =====

    const donutCanvas = document.getElementById('topServicesChart');
    const legend = document.getElementById('serviceLegend');
    const noServicesMessage = document.getElementById('noServicesMessage');

    if (donutCanvas && legend) {
        const services = JSON.parse(donutCanvas.dataset.services || '[]');
        const total = services.reduce(
            (sum, service) => sum + Number(service.total), 0
        );

        function drawDonut() {
            const size = donutCanvas.clientWidth;
            if (!size) return;

            const ratio = window.devicePixelRatio || 1;
            const ctx = donutCanvas.getContext('2d');

            donutCanvas.width = size * ratio;
            donutCanvas.height = size * ratio;
            ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
            ctx.clearRect(0, 0, size, size);

            const center = size / 2;
            const radius = size * 0.36;
            const thickness = size * 0.18;
            
            if (!total) {
                ctx.beginPath();
                ctx.arc(center, center, radius, 0, Math.PI * 2);
                ctx.strokeStyle = '#eeece4';
                ctx.lineWidth = thickness;
                ctx.stroke();
            } else {
                let startAngle = -Math.PI / 2;

                services.forEach((service, index) => {
                    const value = Number(service.total);
                    const slice = value / total * Math.PI * 2;

                    ctx.beginPath();
                    ctx.arc(
                        center,
                        center,
                        radius,
                        startAngle,
                        startAngle + slice
                    );
                    ctx.strokeStyle = chartColors[index % chartColors.length];
                    ctx.lineWidth = thickness;
                    ctx.stroke();

                    startAngle += slice;
                });
            }

            ctx.fillStyle = '#292c2a';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = 'bold 22px Arial';
            ctx.fillText(String(total), center, center - 5);

            ctx.fillStyle = '#77766f';
            ctx.font = '10px Arial';
            ctx.fillText('Requests', center, center + 14);
        }

        legend.replaceChildren();

        services.forEach((service, index) => {
            const item = document.createElement('div');
            item.className = 'service-legend-item';

            const dot = document.createElement('span');
            dot.className = 'service-legend-dot';
            dot.style.backgroundColor =
                chartColors[index % chartColors.length];

            const name = document.createElement('span');
            name.className = 'service-legend-name';
            name.textContent = service.service_name
                .replace(/-/g, ' ')
                .replace(/\b\w/g, char => char.toUpperCase());

            const percent = document.createElement('span');
            percent.className = 'service-legend-percent';
            percent.textContent = total
                ? Math.round(Number(service.total) / total * 100) + '%'
                : '0%';

            item.append(dot, name, percent);
            legend.appendChild(item);
        });

        drawDonut();

        if ('ResizeObserver' in window) {
            new ResizeObserver(drawDonut).observe(
                donutCanvas.parentElement
            );
        } else {
            window.addEventListener('resize', drawDonut);
        }
    }
});

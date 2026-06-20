(function () {
    const el = document.querySelector('#sisFundingChart');

    if (!el || typeof ApexCharts === 'undefined') {
        return;
    }

    const colors = ['#7fc9e6', '#6ba8bc', '#4f7f8d', '#294652'];

    const categories = [
        'Penguatan Kapasitas & Operasional',
        'Dana Cadangan Tanggap Darurat Kebakaran',
        'Patroli & Perlindungan Hutan',
        'Pemberdayaan Ekonomi',
    ];

    new ApexCharts(el, {
        chart: {
            height: 360,
            type: 'bar',
            fontFamily: 'Montserrat, "Segoe UI", Arial, sans-serif',
            toolbar: { show: false },
            zoom: { enabled: false },
        },
        series: [{
            name: 'Distribusi',
            data: [77, 63, 52, 46],
        }],
        colors,
        plotOptions: {
            bar: {
                horizontal: true,
                distributed: true,
                barHeight: '58%',
                borderRadius: 1,
            },
        },
        dataLabels: { enabled: false },
        grid: {
            borderColor: '#e1e6e1',
            strokeDashArray: 4,
            xaxis: { lines: { show: true } },
            yaxis: { lines: { show: false } },
            padding: { left: 18, right: 8 },
        },
        xaxis: {
            min: 10,
            max: 100,
            tickAmount: 9,
            categories,
            labels: {
                formatter: (value) => `${Math.round(value)}%`,
                style: { colors: '#b2bbb3', fontSize: '11px', fontWeight: 800 },
            },
            axisBorder: { color: '#d8ddd7' },
            axisTicks: { show: false },
        },
        yaxis: {
            labels: {
                maxWidth: 170,
                style: { colors: '#aab3ab', fontSize: '11px', fontWeight: 800 },
            },
        },
        legend: { show: false },
        tooltip: {
            marker: { show: true },
            x: { show: false },
            y: {
                formatter: (value, opts) => {
                    const year = '2025';
                    const label = opts.w.globals.labels[opts.dataPointIndex];
                    return `${year} - ${label}: ${value}%`;
                },
            },
        },
    }).render();
})();

(function () {
    const db = window.dbChartData || {};
    const chartFont = 'Montserrat, "Segoe UI", Arial, sans-serif';
    const years = ['2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025'];
    const green = '#176f16';
    const brown = '#6d4c35';
    const blue = '#82c8e5';
    const darkBlue = '#2f4e5a';

    const baseGrid = {
        borderColor: '#e2e7e1',
        strokeDashArray: 4,
    };

    const common = {
        fontFamily: chartFont,
        toolbar: { show: false },
        zoom: { enabled: false },
    };

    const render = (selector, options) => {
        const el = document.querySelector(selector);

        if (!el || typeof ApexCharts === 'undefined') {
            return null;
        }

        const chart = new ApexCharts(el, options);
        chart.render();
        return chart;
    };

    render('#forestChart', {
        chart: { ...common, height: 360, type: 'line' },
        series: [
            { name: 'Emisi CO2', type: 'line', data: db.emisiGrk || db.emisiCo2 || [122, 131, 136, 146, 147, 182, 164, 166, 171, 176] },
            { name: 'Serapan Karbon Hutan', type: 'line', data: db.serapanKarbon || [-78, -72, -61, -52, -42, -28, -43, -45, -44, -42] },
            { name: 'Deforestasi', type: 'column', data: db.deforestasi || [390, 370, 382, 412, 380, 500, 382, 360, 335, 312] },
        ],
        colors: [green, brown, blue],
        stroke: { width: [3, 2, 0], curve: 'straight', dashArray: [0, 4, 0] },
        markers: { size: [4, 4, 0], strokeWidth: 0 },
        plotOptions: { bar: { columnWidth: '48%', borderRadius: 1 } },
        dataLabels: { enabled: false },
        grid: baseGrid,
        labels: years,
        legend: { show: false },
        xaxis: { labels: { style: { colors: '#9ba49b', fontWeight: 700 } }, axisBorder: { color: '#d8ddd7' } },
        yaxis: [
            {
                seriesName: 'Emisi CO2',
                min: -100,
                max: 220,
                tickAmount: 6,
                title: { text: 'Mt CO₂e', style: { color: '#a0a8a0', fontWeight: 700 } },
                labels: {
                    formatter: (value) => `${Math.round(value)} Mt`,
                    style: { colors: '#a0a8a0', fontWeight: 700 },
                },
            },
            {
                seriesName: 'Serapan Karbon Hutan',
                show: false,
                min: -100,
                max: 220,
            },
            {
                seriesName: 'Deforestasi',
                opposite: true,
                min: 0,
                max: 600,
                tickAmount: 6,
                title: { text: 'rb ha', style: { color: '#a0a8a0', fontWeight: 700 } },
                labels: {
                    formatter: (value) => `${Math.round(value)}k`,
                    style: { colors: '#a0a8a0', fontWeight: 700 },
                },
            },
        ],
        tooltip: { shared: true, intersect: false },
    });

    const peatChartInstance = render('#peatDonutChart', {
        chart: { ...common, height: 330, type: 'donut' },
        series: db.peatDonut || [25, 18, 15, 8, 34],
        labels: ['Gambut Sekunder', 'Degradasi Ringan', 'Degradasi Berat', 'Dalam Restorasi', 'Gambut Primer Baik'],
        colors: [darkBlue, '#56889a', '#70abc0', '#8fd0e9', '#d5f0f8'],
        dataLabels: { enabled: false },
        stroke: { width: 0 },
        legend: {
            position: 'left',
            fontSize: '12px',
            fontWeight: 700,
            labels: { colors: '#53605a' },
            formatter: (name, opts) => `${name} ${opts.w.globals.series[opts.seriesIndex]} %`,
        },
        plotOptions: {
            pie: {
                donut: { size: '0%' },
            },
        },
        tooltip: { y: { formatter: (value) => `${value} %` } },
    });

    const peatYearSelect = document.getElementById('peatYearSelect');
    if (peatYearSelect && peatChartInstance && db.peatDonutYears) {
        peatYearSelect.addEventListener('change', function () {
            const selectedYear = this.value;
            const newSeries = db.peatDonutYears[selectedYear];
            if (newSeries) {
                peatChartInstance.updateSeries(newSeries);
            }
        });
    }

    render('#peatTrendChart', {
        chart: { ...common, height: 390, type: 'line' },
        series: [
            { name: 'Dalam Restorasi', data: db.restorasiTrend || [438, 456, 466, 485, 517, 535, 548, 560, 568, 576] },
            { name: 'Terdegradasi', data: db.degradasiTrend || [45, 54, 73, 94, 112, 128, 151, 158, 166, 174] },
        ],
        colors: [green, blue],
        stroke: { width: [3, 2], curve: 'straight', dashArray: [0, 4] },
        markers: { size: 4, strokeWidth: 0 },
        grid: baseGrid,
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: { categories: years, labels: { style: { colors: '#9ba49b', fontWeight: 700 } } },
        yaxis: {
            min: 0,
            max: 600,
            tickAmount: 6,
            labels: {
                formatter: (value) => `${Math.round(value)}k`,
                style: { colors: '#a0a8a0', fontWeight: 700 },
            },
        },
        tooltip: { y: { formatter: (value) => `${value} rb ha` } },
    });

    render('#conservationChart', {
        chart: { ...common, height: 360, type: 'bar' },
        series: [{ name: 'Luas Kawasan', data: db.conservation || [1280, 990, 800, 680, 410] }],
        colors: [blue],
        plotOptions: {
            bar: {
                horizontal: true,
                distributed: true,
                barHeight: '62%',
            },
        },
        dataLabels: { enabled: false },
        grid: { ...baseGrid, xaxis: { lines: { show: true } }, yaxis: { lines: { show: false } } },
        xaxis: {
            min: 0,
            max: 1400,
            tickAmount: 7,
            labels: {
                formatter: (value) => `${Math.round(value)}k`,
                style: { colors: '#a0a8a0', fontWeight: 700 },
            },
        },
        yaxis: {
            categories: ['Hutan Lindung', 'Taman Nasional', 'Suaka Margasatwa', 'KPA/KSA Lainnya', 'Cagar Alam'],
            labels: { style: { colors: '#8e978e', fontWeight: 700 } },
        },
        legend: { show: false },
        tooltip: { y: { formatter: (value) => `${value} rb ha` } },
    });

    const karhutlaChartInstance = render('#karhutlaDeforestasiChart', {
        chart: { ...common, height: 360, type: 'bar' },
        series: [{ name: 'Deforestasi', data: db.karhutlaList || [1500, 1350, 300, 750, 2777.91, 1500, 1200, 1350] }],
        colors: [blue],
        plotOptions: {
            bar: {
                columnWidth: '40%',
                borderRadius: 1
            }
        },
        dataLabels: { enabled: false },
        grid: baseGrid,
        labels: db.karhutlaYears || ['2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026'],
        xaxis: {
            labels: { style: { colors: '#9ba49b', fontWeight: 700 } },
            axisBorder: { color: '#d8ddd7' }
        },
        yaxis: {
            min: 0,
            max: 3000,
            tickAmount: 5,
            labels: {
                formatter: (value) => value === 0 ? 'Ok' : Math.round(value).toLocaleString('id-ID'),
                style: { colors: '#a0a8a0', fontWeight: 700 }
            }
        },
        tooltip: {
            y: {
                formatter: (value) => `${value.toLocaleString('id-ID')} rb ha`
            }
        }
    });

    const regencySelect = document.getElementById('deforestasiRegencySelect');
    const startYearSelect = document.getElementById('deforestasiStartYear');
    const endYearSelect = document.getElementById('deforestasiEndYear');

    function updateKarhutlaChart() {
        if (!regencySelect || !startYearSelect || !endYearSelect || !karhutlaChartInstance || !db.ajaxRoute) {
            return;
        }

        const regencyId = regencySelect.value;
        const startYear = startYearSelect.value;
        const endYear = endYearSelect.value;

        if (parseInt(startYear) > parseInt(endYear)) {
            return;
        }

        fetch(`${db.ajaxRoute}?regency_id=${regencyId}&start_year=${startYear}&end_year=${endYear}`)
            .then(res => res.json())
            .then(data => {
                karhutlaChartInstance.updateOptions({
                    xaxis: {
                        categories: data.years
                    }
                });
                karhutlaChartInstance.updateSeries([{
                    name: 'Deforestasi',
                    data: data.values
                }]);
            })
            .catch(err => console.error('Error fetching Karhutla Deforestasi data:', err));
    }

    if (regencySelect && startYearSelect && endYearSelect) {
        regencySelect.addEventListener('change', updateKarhutlaChart);
        startYearSelect.addEventListener('change', updateKarhutlaChart);
        endYearSelect.addEventListener('change', updateKarhutlaChart);
    }
})();

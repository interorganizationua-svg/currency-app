<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>


<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Test</h1>

        <div class="bg-[#f8f8f8] border-[1px] border-[#e3e3e0] p-6 mb-6">
            <div class="flex flex-wrap gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                    <select id="currency" class="border rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->code }}">{{ $currency->code }} — {{ $currency->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <!-- Period choose input -->
                    <label class="block text-sm font-medium text-gray-700 mb-1">Period</label>
                    <select id="period" class="border w-[150px]   rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="3">3 days</option>
                        <option value="5">5 days</option>
                        <option value="7">7 days</option>
                        <option value="10">10 days</option>
                        <option value="all">All time</option>
                    </select>
                </div>
            </div>

            <!-- output chart -->
            <div id="chart"></div>
        </div>
    </div>

    <script>
        let chart = null;

        async function loadChart() {
            const currency = document.getElementById('currency').value;
            const period = document.getElementById('period').value;

            const response = await fetch(`/api/chart?currency=${currency}&days=${period}`);
            const data = await response.json();

            const seriesData = data.data.map(r => [new Date(r.date).getTime(), parseFloat(r.rate)]);

            
            let options = {
                    series: [
                    {
                        name: currency,
                        data: seriesData,
                    },
                    ],
                    chart: {
                    type: 'area',
                    height: 350,
                    connectNullData: true, 
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true,
                    },
                    toolbar: {
                        autoSelected: 'zoom',
                    },
                    },
                    dataLabels: {
                    enabled: false,
                    },
                    markers: {
                    size: 0,
                    },
                    title: {
                    text: `Currency --- ${currency}`,
                    align: 'left',
                    },
                    fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 90, 100],
                    },
                    },
                    yaxis: {
                    labels: {
                        formatter: function (val) {
                        return val.toFixed(4);
                        },
                    },
                    title: {
                        text: 'Price',
                    },
                    },
                    xaxis: {
                        type: 'datetime',
                    },
                    tooltip: {
                    shared: false,
                    y: {
                        formatter: function (val) {
                        return val.toFixed(4);
                        },
                    },
                    },
                }

            if (chart) {
                chart.destroy();
            }

            chart = new ApexCharts(document.getElementById('chart'), options);
            chart.render();
        }

        document.getElementById('currency').addEventListener('change', loadChart);
        document.getElementById('period').addEventListener('change', loadChart);

        loadChart();
    </script>
</body>
</html>
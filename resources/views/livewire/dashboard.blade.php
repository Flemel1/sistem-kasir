<div>
    @section('title', 'Dashboard')

    @section('vendor-style')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
    @endsection

    @section('vendor-script')
        <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    @endsection

    {{-- @section('page-script')
        <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    @endsection --}}

    <div class="row">
        <div class="col-12 order-1">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}" alt="Credit Card"
                                        class="rounded">
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Pendapatan Hari Ini</span>
                            <h3 class="card-title mb-2">{{ $revenueSummary['today_revenue'] }}</h3>
                            @if ($revenueSummary['percentage'] > 0)
                                <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i>
                                    +{{ $revenueSummary['percentage'] }}%</small>
                            @else
                                <small class="text-danger fw-semibold"><i class='bx bx-down-arrow-alt'></i>
                                    -{{ $revenueSummary['percentage'] }}%</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card"
                                        class="rounded">
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Transaksi Hari Ini</span>
                            <h3 class="card-title mb-2">{{ $transactionSummary['today_transaction'] }}</h3>
                            @if ($transactionSummary['percentage'] > 0)
                                <small class="text-success fw-semibold"><i class='bx bx-up-arrow-alt'></i>
                                    +{{ $transactionSummary['percentage'] }}%</small>
                            @else
                                <small class="text-danger fw-semibold"><i class='bx bx-down-arrow-alt'></i>
                                    -{{ $transactionSummary['percentage'] }}%</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Expense Overview -->
        <div class="col-12 mb-4">
            <div class="card h-100">
                <div x-data="{ timeFrame: $wire.$entangle('timeFrame') }" class="card-header">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link" :class="timeFrame == 'weekly' && 'active'"
                                x-on:click="$wire.timeFrame = 'weekly'" role="tab">Minggu Ini</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" x-on:click="$wire.timeFrame = 'monthly'" class="nav-link"
                                :class="timeFrame == 'monthly' && 'active'" role="tab">Bulan Ini</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" x-on:click="$wire.timeFrame = 'yearly'" class="nav-link"
                                :class="timeFrame == 'yearly' && 'active'" role="tab">Tahun Ini</button>
                        </li>
                    </ul>
                </div>
                <div wire:ignore class="card-body px-0">
                    <div id="incomeChart"></div>
                </div>
            </div>
        </div>
        <!--/ Expense Overview -->
    </div>

    <div class="row">
        <!-- Transactions -->
        <div class="col-md-6 col-lg-6 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Penjualan Per Menu</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body overflow-auto" style="height: 200px">
                    <ul class="p-0 m-0">
                        @foreach ($numberOfMenusSold as $menu)
                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $menu->product_name }}</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <h6 class="mb-0">{{ $menu->total }}</h6> <span class="text-muted">pcs</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
        <!-- Shifts -->
        <div class="col-md-6 col-lg-6 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Shift Karyawan</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body overflow-auto" style="height: 200px">
                    <ul class="p-0 m-0">
                        @foreach ($shifts as $shift)
                            <li class="d-flex mb-4 pb-1">

                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $shift->employee_name }}</h6>
                                    </div>
                                    <div class="user-progress">
                                        @foreach ($shift->shift as $item)
                                            <h6 class="mb-0 text-end">{{ $item }}</h6>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Shfits -->
    </div>

    @script
        <script>
            let cardColor, headingColor, axisColor, shadeColor, borderColor;

            cardColor = config.colors.cardColor;
            headingColor = config.colors.headingColor;
            axisColor = config.colors.axisColor;
            borderColor = config.colors.borderColor;

            const incomeChartEl = document.querySelector("#incomeChart"),
                incomeChartConfig = {
                    series: [{
                        data: [],
                    }, ],
                    chart: {
                        height: 300,
                        parentHeightOffset: 0,
                        parentWidthOffset: 0,
                        toolbar: {
                            show: false,
                        },
                        type: "area",
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        width: 2,
                        curve: "smooth",
                    },
                    legend: {
                        show: false,
                    },
                    markers: {
                        size: 6,
                        colors: "transparent",
                        strokeColors: "transparent",
                        strokeWidth: 4,
                        discrete: [{
                            fillColor: config.colors.white,
                            seriesIndex: 0,
                            strokeColor: config.colors.primary,
                            strokeWidth: 2,
                            size: 6,
                            radius: 8,
                        }, ],
                        hover: {
                            size: 7,
                        },
                    },
                    colors: [config.colors.primary],
                    fill: {
                        type: "gradient",
                        gradient: {
                            shade: shadeColor,
                            shadeIntensity: 0.6,
                            opacityFrom: 0.5,
                            opacityTo: 0.25,
                            stops: [0, 95, 100],
                        },
                    },
                    grid: {
                        borderColor: borderColor,
                        strokeDashArray: 3,
                        padding: {
                            bottom: -8,
                            right: 8,
                        },
                    },
                    xaxis: {
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                        },
                        labels: {
                            show: true,
                            style: {
                                fontSize: "13px",
                                colors: axisColor,
                            },
                        },
                    },
                    yaxis: {
                        labels: {
                            show: false,
                        },
                        min: 0,
                    },
                };
            if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
                $wire.dispatchSelf('get-revenue-by-timeframe')
            }

            $wire.$watch('timeFrame', (value, old) => {
                $wire.dispatchSelf('get-revenue-by-timeframe')
            })

            $wire.$on('get-revenue-by-timeframe-db', (event) => {
                const datas = event[0].datas
                const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
                console.log(datas)
                incomeChart.render();
                incomeChart.updateSeries([{
                    data: datas
                }])
            })
        </script>
    @endscript
</div>

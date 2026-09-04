<x-admin-layout>
    <div class="space-y-6">
        
        <!-- Top row: KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Card 1 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">Total Kajian</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalKajian ?? 0 }}</h3>
                    <div class="w-16 h-8">
                        <!-- Mini sparkline mockup -->
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,15 L10,10 L20,12 L30,5 L40,8 L50,2" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 mr-1"></i> +{{ $kajianBulanIni ?? 0 }} <span class="text-gray-400 font-normal ml-1">Bulan Ini</span>
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">Total Masjid</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalMosque ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Lokasi pelaksanaan kajian</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">Kajian Terdekat</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $kajian7Hari ?? 0 }}</h3>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-2">Dalam 7 Hari Kedepan</p>
            </div>

            <!-- Card 4 -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">User Aktif</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalUser ?? 0 }}</h3>
                    <div class="w-16 h-8">
                        <svg viewBox="0 0 50 20" class="w-full h-full stroke-emerald-500 fill-none" stroke-width="2">
                            <path d="M0,18 L10,12 L20,15 L30,8 L40,10 L50,4" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-emerald-500 font-medium flex items-center mt-2">
                    <i data-lucide="arrow-up" class="w-3 h-3 mr-1"></i> +{{ $userMingguIni ?? 0 }} <span class="text-gray-400 font-normal ml-1">Minggu Ini</span>
                </p>
            </div>

            <!-- Card 5: Total Organizer -->
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm col-span-1">
                <p class="text-sm text-gray-500 font-medium mb-1">Total Organizer</p>
                <div class="flex items-end justify-between mt-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $totalOrganizer ?? 0 }}</h3>
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                </div>
                <p class="text-xs text-indigo-500 font-medium mt-2">Terdaftar di sistem</p>
            </div>
        </div>

        <!-- Middle row: Chart and To-Do List -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Line Chart (Pertumbuhan) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6 relative">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-bold text-gray-900">Pertumbuhan Pendaftar Kajian</h3>
                    <form id="chartFilterForm" method="GET" action="{{ route('admin.dashboard') }}">
                        <select name="filter" onchange="document.getElementById('chartFilterForm').submit()" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-pointer hover:bg-gray-50 focus:ring-0 focus:border-gray-200 focus:outline-none bg-white">
                            <option value="hari" {{ $filter == 'hari' ? 'selected' : '' }}>Harian</option>
                            <option value="minggu" {{ $filter == 'minggu' ? 'selected' : '' }}>Mingguan</option>
                            <option value="bulan" {{ $filter == 'bulan' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                    </form>
                </div>

                <div class="flex items-center space-x-6 mb-6">
                    <button id="btnLineChart" class="text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-2 flex items-center" onclick="updateChartType('line')">
                        <i data-lucide="line-chart" class="w-4 h-4 mr-2"></i> Line Chart
                    </button>
                    <button id="btnBarChart" class="text-sm font-medium text-gray-400 pb-2 flex items-center hover:text-gray-600 border-b-2 border-transparent" onclick="updateChartType('bar')">
                        <i data-lucide="bar-chart" class="w-4 h-4 mr-2"></i> Bar Chart
                    </button>
                </div>

                <!-- Dynamic Chart Container -->
                <div class="w-full h-64 relative mt-4">
                    <canvas id="growthChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- To-Do & Alerts -->
            <div class="lg:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Tugas & Peringatan</h3>
                    <a href="{{ route('admin.kajian.index') }}" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-sm font-medium hover:bg-blue-100">View All</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-bold text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-medium">Tipe</th>
                                <th class="pb-3 font-medium">Judul</th>
                                <th class="pb-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($pendingKajians as $kajian)
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-orange-300 mr-2 border border-orange-400"></div> Menunggu
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Review Kajian {{ Str::limit($kajian->title, 15) }}</td>
                                <td class="py-4"><span class="text-xs font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-1.5"></div> Awaiting</span></td>
                            </tr>
                            @empty
                            @endforelse
                            
                            @foreach($recentOrganizers as $org)
                            <tr>
                                <td class="py-4 flex items-center text-gray-700 font-medium">
                                    <div class="w-2 h-2 rounded-full bg-blue-300 mr-2 border border-blue-400"></div> Organizer
                                </td>
                                <td class="py-4 text-gray-900 font-bold">Verifikasi {{ Str::limit($org->name, 15) }}</td>
                                <td class="py-4"><span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-md flex items-center w-max"><div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5"></div> New</span></td>
                            </tr>
                            @endforeach
                            
                            @if($pendingKajians->isEmpty() && $recentOrganizers->isEmpty())
                                <tr>
                                    <td colspan="3" class="py-4 text-center text-gray-500">Belum ada tugas baru.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('growthChart').getContext('2d');
            
            // Create gradient
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(239, 68, 68, 0.5)'); // Red-500
            gradient.addColorStop(1, 'rgba(239, 68, 68, 0)');

            const labels = {!! json_encode($chartLabels) !!};
            const data = {!! json_encode($chartData) !!};

            window.growthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendaftar Baru',
                        data: data,
                        borderColor: '#ef4444',
                        backgroundColor: gradient,
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#ffffff',
                            titleColor: '#6b7280',
                            bodyColor: '#111827',
                            borderColor: '#f3f4f6',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Pendaftar';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#9ca3af',
                                font: { size: 12 },
                                stepSize: 500
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#9ca3af',
                                font: { size: 12 }
                            }
                        }
                    }
                }
            });
        });

        function updateChartType(type) {
            const chart = window.growthChart;
            chart.config.type = type;
            
            if (type === 'bar') {
                chart.data.datasets[0].backgroundColor = '#ef4444';
                chart.data.datasets[0].borderWidth = 0;
            } else {
                let gradient = chart.ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(239, 68, 68, 0.5)');
                gradient.addColorStop(1, 'rgba(239, 68, 68, 0)');
                chart.data.datasets[0].backgroundColor = gradient;
                chart.data.datasets[0].borderWidth = 4;
            }
            chart.update();

            // Toggle active styling on buttons
            const btnLine = document.getElementById('btnLineChart');
            const btnBar = document.getElementById('btnBarChart');
            
            if (type === 'line') {
                btnLine.className = "text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-2 flex items-center";
                btnBar.className = "text-sm font-medium text-gray-400 pb-2 flex items-center hover:text-gray-600 border-b-2 border-transparent";
            } else {
                btnBar.className = "text-sm font-bold text-blue-600 border-b-2 border-blue-600 pb-2 flex items-center";
                btnLine.className = "text-sm font-medium text-gray-400 pb-2 flex items-center hover:text-gray-600 border-b-2 border-transparent";
            }
        }
    </script>
</x-admin-layout>

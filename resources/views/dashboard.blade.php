<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl m-4 md:m-0">

        {{-- KPI Cards --}}
        <div class="grid gap-4 grid-cols-2 md:grid-cols-4 lg:grid-cols-7">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Total Users</p>
                <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                    {{ $users->count() }}
                </p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-1">&#x25B2; {{$newUsers->count()}} this week</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Offices</p>
                <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                    {{$offices->count()}}
                </p>
                <p class="text-xs text-neutral-400 mt-1">Active offices</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Open Tickets</p>
                <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                    {{$tickets->count()}}
                </p>
                <p class="text-xs text-red-500 mt-1">&#x25B2; {{$newTickets->count()}} from yesterday</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Pending</p>
                <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                    {{$pendingTickets->count()}}
                </p>
                <p class="text-xs text-neutral-400 mt-1">Awaiting response</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Resolved Today</p>
                <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                    {{$resolvedToday}}
                </p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                    &#x25B2; {{$resolvedToday - $resolvedYesterday}} vs yesterday
                </p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Avg Resolution</p>
                <p class="text-2xl font-semibold text-neutral-900 dark:text-white">12 <span class="text-base font-normal">min</span></p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-1">&#x25BC; -3 min this week</p>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-4">
                <p class="text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wide mb-1">Bot Resolution</p>
                <p class="text-2xl font-semibold text-neutral-900 dark:text-white">76<span class="text-base font-normal">%</span></p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-1">&#x25B2; +2% this month</p>
            </div>
        </div>

        {{-- Ticket Trends Chart --}}
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
            <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Ticket Trends This Week</p>
            <div class="flex gap-4 mb-3">
                <span class="flex items-center gap-1.5 text-xs text-neutral-500">
                    <span class="inline-block w-3 h-0.5 bg-blue-500 rounded"></span> Created
                </span>
                <span class="flex items-center gap-1.5 text-xs text-neutral-500">
                    <span class="inline-block w-3 h-0.5 bg-emerald-500 rounded border-dashed"></span> Resolved
                </span>
            </div>
            <div class="relative w-full h-48">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- Office Performance + Pie Chart --}}
        <div class="grid gap-4 md:grid-cols-5">
            <div class="md:col-span-3 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
                <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">Office Performance</p>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-neutral-500 dark:text-neutral-400 border-b border-neutral-100 dark:border-neutral-800">
                            <th class="text-left pb-2 font-medium">Office</th>
                            <th class="text-left pb-2 font-medium">Open</th>
                            <th class="text-left pb-2 font-medium">Pending</th>
                            <th class="text-left pb-2 font-medium">Resolved</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @foreach ([
                            ['Registrar', 15, 8, 102],
                            ['Cashier', 7, 4, 78],
                            ['MIS', 20, 11, 56],
                            ['Guidance', 5, 2, 41],
                            ['Library', 10, 6, 33],
                            ['Admission', 30, 12, 89],
                        ] as [$office, $open, $pending, $resolved])
                        <tr>
                            <td class="py-2 text-neutral-800 dark:text-neutral-200 font-medium">{{ $office }}</td>
                            <td class="py-2"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400">{{ $open }}</span></td>
                            <td class="py-2"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">{{ $pending }}</span></td>
                            <td class="py-2"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">{{ $resolved }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="md:col-span-2 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
                <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">Ticket Status Distribution</p>
                <div class="flex items-center gap-4">
                    <div class="relative" style="width:120px;height:120px;flex-shrink:0">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="flex flex-col gap-2 text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-sm bg-red-500 inline-block"></span>
                            <span class="text-neutral-500">New</span>
                            <span class="ml-auto font-semibold text-neutral-800 dark:text-white">
                                {{ number_format($openTickets, 1) }}%
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-sm bg-amber-400 inline-block"></span>
                            <span class="text-neutral-500">Pending</span>
                            <span class="ml-auto font-semibold text-neutral-800 dark:text-white">
                                {{ number_format($pendingTicketsCount, 1) }}%
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-sm bg-emerald-500 inline-block"></span>
                            <span class="text-neutral-500">Resolved</span>
                            <span class="ml-auto font-semibold text-neutral-800 dark:text-white">
                                {{ number_format($resolvedTicketsCount, 1) }}%
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xs text-neutral-500 mb-1">SLA Compliance</p>
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">Within SLA — 92%</span>
                        <span class="text-red-500">Breaching — 8%</span>
                    </div>
                    <div class="w-full h-1.5 rounded-full bg-neutral-100 dark:bg-neutral-800 overflow-hidden">
                        <div class="h-full rounded-full bg-emerald-500" style="width: 92%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chatbot Analytics + User Statistics --}}
        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
                <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">Chatbot Analytics</p>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="rounded-lg bg-neutral-50 dark:bg-neutral-800 p-3">
                        <p class="text-xs text-neutral-500 mb-1">Total Conversations</p>
                        <p class="text-xl font-semibold text-neutral-900 dark:text-white">3,412</p>
                    </div>
                    <div class="rounded-lg bg-neutral-50 dark:bg-neutral-800 p-3">
                        <p class="text-xs text-neutral-500 mb-1">Auto-answered</p>
                        <p class="text-xl font-semibold text-neutral-900 dark:text-white">2,687</p>
                    </div>
                    <div class="rounded-lg bg-neutral-50 dark:bg-neutral-800 p-3">
                        <p class="text-xs text-neutral-500 mb-1">Escalated</p>
                        <p class="text-xl font-semibold text-amber-600 dark:text-amber-400">725</p>
                    </div>
                    <div class="rounded-lg bg-neutral-50 dark:bg-neutral-800 p-3">
                        <p class="text-xs text-neutral-500 mb-1">Success Rate</p>
                        <p class="text-xl font-semibold text-emerald-600 dark:text-emerald-400">78%</p>
                    </div>
                </div>
                <p class="text-xs font-semibold text-neutral-500 uppercase tracking-wide mb-2">Most Asked Questions</p>
                <div class="relative w-full" style="height: 140px;">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
                <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">User Statistics</p>
                <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
                    @foreach ([
                        ['Students', $students, 'bg-blue-100 dark:bg-blue-900/40', 'text-blue-600 dark:text-blue-400', '&#127891;'],
                        ['Alumni', $alumni, 'bg-emerald-100 dark:bg-emerald-900/40', 'text-emerald-600 dark:text-emerald-400', '&#9998;'],
                        ['Faculty', $faculty, 'bg-amber-100 dark:bg-amber-900/40', 'text-amber-600 dark:text-amber-400', '&#128188;'],
                        ['Admins', $admins, 'bg-purple-100 dark:bg-purple-900/40', 'text-purple-600 dark:text-purple-400', '&#128737;'],
                    ] as [$role, $count, $bg, $color, $icon])
                    <div class="flex items-center gap-3 py-2.5">
                        <div class="w-8 h-8 rounded-full {{ $bg }} flex items-center justify-center text-sm">
                            {!! $icon !!}
                        </div>
                        <span class="flex-1 text-sm text-neutral-600 dark:text-neutral-400">{{ $role }}</span>
                        <span class="text-sm font-semibold text-neutral-900 dark:text-white">{{ $count }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 rounded-lg bg-neutral-50 dark:bg-neutral-800 p-3">
                    <p class="text-xs text-neutral-500 mb-1">Tickets Created Today</p>
                    <p class="text-2xl font-semibold text-neutral-900 dark:text-white">
                        {{$ticketToday}}
                    </p>
                    <p class="text-xs text-neutral-400 mt-1">
                        vs {{$ticketYesterday}} yesterday
                    </p>
                </div>
            </div>
        </div>

        {{-- Urgent Tickets + Recent Activity --}}
        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
                <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3 flex items-center gap-2">
                    <span class="text-red-500">&#9888;</span> Urgent Tickets
                </p>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-neutral-500 border-b border-neutral-100 dark:border-neutral-800">
                            <th class="text-left pb-2 font-medium">Ticket</th>
                            <th class="text-left pb-2 font-medium">Office</th>
                            <th class="text-left pb-2 font-medium">Status</th>
                            <th class="text-left pb-2 font-medium">Age</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @forelse ($critials as $ticket)
                        <tr>
                            <td class="py-2 font-semibold text-blue-600 dark:text-blue-400">
                                {{ $ticket->ticket_code }}
                            </td>

                            <td class="py-2 text-neutral-700 dark:text-neutral-300">
                                {{ $ticket->office->name ?? 'Unassigned' }}
                            </td>

                            <td class="py-2">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $ticket->status === 'new'
                                        ? 'bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400'
                                        : 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>

                            <td class="py-2">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-neutral-500">
                                No critical tickets found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
                <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3">Recent Activity</p>
                <div class="divide-y divide-neutral-100 dark:divide-neutral-800">
                    @foreach ([
                        ['John submitted Ticket #2048', '2 minutes ago', 'bg-blue-500'],
                        ['Registrar resolved Ticket #2042', '14 minutes ago', 'bg-emerald-500'],
                        ['Admin added Office: Guidance', '1 hour ago', 'bg-purple-500'],
                        ['Chatbot escalated Ticket #2050', '1 hour ago', 'bg-amber-400'],
                        ['MIS resolved Ticket #2039', '2 hours ago', 'bg-emerald-500'],
                        ['Maria submitted Ticket #2046', '3 hours ago', 'bg-red-500'],
                    ] as [$text, $time, $dot])
                    <div class="flex items-start gap-3 py-2.5">
                        <span class="mt-1.5 w-2 h-2 rounded-full {{ $dot }} flex-shrink-0"></span>
                        <div>
                            <p class="text-xs text-neutral-800 dark:text-neutral-200 leading-snug">{{ $text }}</p>
                            <p class="text-xs text-neutral-400 mt-0.5">{{ $time }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- AI Insights --}}
        <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 p-5">
            <p class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-3 flex items-center gap-2">
                <span class="text-purple-500">&#10024;</span> AI Insights
            </p>
            <div class="grid gap-3 md:grid-cols-2">
                @foreach ([
                    ['&#x1F4C8;', 'Enrollment inquiries increased by 32% this week — consider adding FAQ entries or a dedicated chatbot flow for enrollment-related concerns.'],
                    ['&#x26A0;', 'Admission Office currently has the highest unresolved ticket volume (30 open). It may need additional staff or priority escalation.'],
                    ['&#x1F916;', 'Chatbot successfully resolved 81% of tuition-related concerns this week — the highest automated resolution rate across all categories.'],
                    ['&#x23F0;', 'Ticket volume peaks on Wednesdays. Pre-allocating staff mid-week could improve average response time by an estimated 15–20%.'],
                ] as [$icon, $text])
                <div class="flex items-start gap-3 rounded-lg bg-neutral-50 dark:bg-neutral-800 px-4 py-3">
                    <span class="text-base flex-shrink-0 mt-0.5">{!! $icon !!}</span>
                    <p class="text-xs text-neutral-700 dark:text-neutral-300 leading-relaxed">{!! $text !!}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.07)';
        const tickColor = isDark ? '#6b7280' : '#9ca3af';

        // Ticket Trends
        new Chart(document.getElementById('trendChart'), {
            type: 'line',
            data: {
                labels: @json($trendLabels),
                datasets: [
                    {
                        label: 'Created',
                        data: @json($trendCreated),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.07)',
                        fill: true, tension: 0.4, pointRadius: 4,
                        pointBackgroundColor: '#3b82f6',
                    },
                    {
                        label: 'Resolved',
                        data: @json($trendResolved),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,0.07)',
                        fill: true, tension: 0.4, pointRadius: 4,
                        pointBackgroundColor: '#10b981',
                        borderDash: [5, 3],
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: tickColor, font: { size: 11 } }, grid: { color: gridColor }, border: { display: false } },
                    y: { ticks: { color: tickColor, font: { size: 11 } }, grid: { color: gridColor }, border: { display: false }, beginAtZero: true }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: ['Open','Pending','Resolved'],
                datasets: [{ data: @json([$openTickets, $pendingTicketsCount, $resolvedTicketsCount]), backgroundColor: ['#ef4444','#f59e0b','#10b981'], borderWidth: 0 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, cutout: '65%' }
        });

        // Bar Chart
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['Enrollment','Tuition','Transcript','Schedule','Others'],
                datasets: [{
                    label: 'Questions',
                    data: [842, 631, 519, 389, 306],
                    backgroundColor: ['#6366f1','#3b82f6','#10b981','#f59e0b','#9ca3af'],
                    borderRadius: 4, borderWidth: 0
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: tickColor, font: { size: 10 } }, grid: { color: gridColor }, border: { display: false } },
                    y: { ticks: { color: tickColor, font: { size: 11 } }, grid: { display: false }, border: { display: false } }
                }
            }
        });
    </script>
</x-layouts.app>
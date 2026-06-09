<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all()->sortBy('name');
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->latest()->get();
        $offices = Office::all();
        $tickets = Ticket::whereIn('status', ['pending', 'new'])->get();
        $newTickets = Ticket::whereIn('status', ['pending', 'new'])
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->latest()
            ->get();
        $pendingTickets = Ticket::where('status', 'pending')->latest()->get();
        $resolvedToday = Ticket::where('status', 'resolved')
            ->whereDate('created_at', today())
            ->count();
        $resolvedYesterday = Ticket::where('status', 'resolved')
            ->whereDate('created_at', today()->subDay())
            ->count();

        // ticket trends
        $days = collect(range(6, 0))->map(fn($i) => Carbon::today()->subDays($i));
        $trendLabels = $days->map(fn($d) => $d->format('D'))->values();
        $from = Carbon::today()->subDays(6)->startOfDay();
        $created = Ticket::where('created_at', '>=', $from)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $resolved = Ticket::where('status', 'resolved')
            ->where('updated_at', '>=', $from)
            ->selectRaw('DATE(updated_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $trendCreated = $days->map(fn($d) => $created->get($d->toDateString(), 0))->values();
        $trendResolved = $days->map(fn($d) => $resolved->get($d->toDateString(), 0))->values();

        // ticket status distribution — guard against division by zero
        $totalTickets = Ticket::count() ?: 1;
        $openTickets = round(Ticket::where('status', 'new')->count() / $totalTickets * 100, 1);
        $pendingTicketsCount = round(Ticket::where('status', 'pending')->count() / $totalTickets * 100, 1);
        $resolvedTicketsCount = round(Ticket::where('status', 'resolved')->count() / $totalTickets * 100, 1);

        $students = User::where('role', 'student')->count();
        $alumni = User::where('role', 'alumni')->count();
        $faculty = User::whereIn('role', ['staff', 'head'])->count();
        $admins = User::where('role', 'admin')->count();

        // fixed: use whereDate for accurate today/yesterday counts
        $ticketToday = Ticket::whereDate('created_at', today())->count();
        $ticketYesterday = Ticket::whereDate('created_at', today()->subDay())->count();

        $critials = Ticket::where('level', 'critical')
            ->whereNotIn('status', ['resolved', 'closed'])
            ->latest()
            ->get();



        return view('dashboard', compact(
            'users',
            'newUsers',
            'offices',
            'tickets',
            'newTickets',
            'pendingTickets',
            'resolvedToday',
            'resolvedYesterday',

            'trendLabels',
            'trendCreated',
            'trendResolved',

            'openTickets',
            'pendingTicketsCount',
            'resolvedTicketsCount',

            'students',
            'alumni',
            'faculty',
            'admins',
            'ticketToday',
            'ticketYesterday',

            'critials',

        ));
    }
}

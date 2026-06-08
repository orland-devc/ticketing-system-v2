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
        // top bar
        $users = User::all()->sortBy('name');
        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest()
            ->get();
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

        // ticket status distribution
        $openTickets = Ticket::where('status', 'new')->count() / Ticket::count() * 100;
        $pendingTicketsCount = Ticket::where('status', 'pending')->count() / Ticket::count() * 100;
        $resolvedTicketsCount = Ticket::where('status', 'resolved')->count() / Ticket::count() * 100;

        // user statistics
        $students = User::where('role', 'student')->count();
        $alumni = User::where('role', 'alumni')->count();
        $faculty = User::whereIn('role', ['staff', 'head'])->count();
        $admins = User::where('role', 'admin')->count();

        $ticketToday = Ticket::where('created_at', '>=', Carbon::now())->latest()->count();
        $ticketYesterday = Ticket::where('created_at', '>=', Carbon::now()->subDay())->latest()->count();

        // urgent / critical tickets
        $critials = Ticket::where('level', 'critical')
            ->where('status', '!=', 'resolved')
            ->where('status', '!=', 'closed')
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

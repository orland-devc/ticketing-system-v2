<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()->sortByDesc('last_name');

        $admins = User::where('role', 'admin')->get()->sortByDesc('last_name');
        $heads = User::where('role', 'head')->get()->sortByDesc('last_name');
        $staffs = User::where('role', 'staff')->get()->sortByDesc('last_name');
        $students = User::where('role', 'student')->get()->sortByDesc('last_name');
        $alumni = User::where('role', 'alumni')->get()->sortByDesc('last_name');

        $offices = Office::all();

        return view('users.index', compact('users', 'offices', 'admins', 'heads', 'staffs', 'students', 'alumni'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

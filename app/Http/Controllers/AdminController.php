<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Logic for admin dashboard
        return Inertia::render('Admin/Dashboard');
    }
}

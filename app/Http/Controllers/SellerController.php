<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class SellerController extends Controller
{
    public function dashboard()
    {
        // Logic for seller dashboard
        return Inertia::render('Seller/Dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SellerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SellerApplicationController extends Controller
{
    public function create()
    {
        // Check if user already has a pending application
        $pendingApplication = SellerApplication::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        return Inertia::render('SellerApplication/Create', [
            'hasApplication' => $pendingApplication !== null,
            'application' => $pendingApplication
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'website' => 'nullable|url|max:255',
            'reason' => 'required|string|max:1000',
        ]);

        $application = SellerApplication::create([
            'user_id' => Auth::id(),
            'business_name' => $validated['business_name'],
            'description' => $validated['description'],
            'website' => $validated['website'],
            'reason' => $validated['reason'],
            'status' => 'pending'
        ]);

        return redirect()->route('dashboard')
            ->with('message', 'Your seller application has been submitted successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SellerApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SellerApplicationController extends Controller
{
    public function index()
    {
        $applications = SellerApplication::with('user')
            ->latest()
            ->paginate(10);


        return Inertia::render('Admin/SellerApplications/Index', [
            'applications' => $applications
        ]);
    }

    public function show(SellerApplication $application)
    {
        return Inertia::render('Admin/SellerApplications/Show', [
            'application' => $application->load('user')
        ]);
    }

    public function approve(Request $request, SellerApplication $application)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $application->approve($validated['admin_notes'] ?? null);

        return redirect()->back()->with('message', 'Application approved successfully');
    }

    public function reject(Request $request, SellerApplication $application)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $application->reject($validated['admin_notes'] ?? null);

        return redirect()->back()->with('message', 'Application rejected successfully');
    }
}

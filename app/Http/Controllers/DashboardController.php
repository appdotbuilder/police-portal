<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cases;
use App\Models\Personnel;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalCases = Cases::count();
        $openCases = Cases::where('status', 'open')->count();
        $highPriorityCases = Cases::whereIn('priority', ['high', 'critical'])->count();
        $totalPersonnel = Personnel::where('status', 'active')->count();
        
        $recentCases = Cases::with(['assignedOfficer', 'creator'])
            ->latest()
            ->limit(5)
            ->get();
            
        $casesByStatus = Cases::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        $casesByPriority = Cases::selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();
        
        return Inertia::render('dashboard', [
            'stats' => [
                'totalCases' => $totalCases,
                'openCases' => $openCases,
                'highPriorityCases' => $highPriorityCases,
                'totalPersonnel' => $totalPersonnel,
            ],
            'recentCases' => $recentCases,
            'casesByStatus' => $casesByStatus,
            'casesByPriority' => $casesByPriority,
        ]);
    }
}
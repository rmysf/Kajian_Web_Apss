<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalKajian = \App\Models\Kajian::count();
        $kajianBulanIni = \App\Models\Kajian::whereMonth('created_at', now()->month)->count();
        
        $kajian7Hari = \App\Models\Kajian::whereBetween('start_at', [now(), now()->addDays(7)])->count();
        
        $totalUser = \App\Models\User::where('role', 'user')->count();
        $userMingguIni = \App\Models\User::where('role', 'user')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        
        $totalOrganizer = \App\Models\User::where('role', 'organizer')->count();
        $totalMosque = \App\Models\Mosque::count();

        // Chart Data filter (hari, minggu, bulan)
        $filter = $request->get('filter', 'hari');
        $chartLabels = [];
        $chartData = [];
        $chartLabelText = "";

        if ($filter == 'bulan') {
            $chartLabelText = "12 Bulan Terakhir";
            $startDate = now()->subMonths(11)->startOfMonth();
            $attendees = \App\Models\KajianAttendee::where('created_at', '>=', $startDate)->get();
            for ($i = 11; $i >= 0; $i--) {
                $start = now()->subMonths($i)->startOfMonth();
                $end = now()->subMonths($i)->endOfMonth();
                $chartLabels[] = $start->translatedFormat('M Y');
                $chartData[] = $attendees->whereBetween('created_at', [$start, $end])->count();
            }
        } elseif ($filter == 'minggu') {
            $chartLabelText = "4 Minggu Terakhir";
            $startDate = now()->subWeeks(3)->startOfWeek();
            $attendees = \App\Models\KajianAttendee::where('created_at', '>=', $startDate)->get();
            for ($i = 3; $i >= 0; $i--) {
                $start = now()->subWeeks($i)->startOfWeek();
                $end = now()->subWeeks($i)->endOfWeek();
                $chartLabels[] = $start->format('d/m') . '-' . $end->format('d/m');
                $chartData[] = $attendees->whereBetween('created_at', [$start, $end])->count();
            }
        } else {
            $chartLabelText = "7 Hari Terakhir";
            $startDate = now()->subDays(6)->startOfDay();
            $attendees = \App\Models\KajianAttendee::where('created_at', '>=', $startDate)->get();
            for ($i = 6; $i >= 0; $i--) {
                $start = now()->subDays($i)->startOfDay();
                $end = now()->subDays($i)->endOfDay();
                $chartLabels[] = $start->format('d M');
                $chartData[] = $attendees->whereBetween('created_at', [$start, $end])->count();
            }
        }

        // Tugas & Peringatan: Pending Kajian & New Users
        $pendingKajians = \App\Models\Kajian::where('status', 'draft')->latest()->take(3)->get();
        $recentOrganizers = \App\Models\User::where('role', 'organizer')->latest()->take(2)->get();
        
        return view('admin.dashboard', compact(
            'totalKajian', 'kajianBulanIni', 
            'kajian7Hari', 
            'totalUser', 'userMingguIni', 
            'totalOrganizer', 'totalMosque',
            'chartLabels', 'chartData', 'chartLabelText', 'filter',
            'pendingKajians', 'recentOrganizers'
        ));
    }
}

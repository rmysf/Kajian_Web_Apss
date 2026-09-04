<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = auth()->user()->organizer->id ?? null;
        
        $kajianAktif = \App\Models\Kajian::where('organizer_id', $organizerId)->where('status', 'published')->count();
        $kajianBulanIni = \App\Models\Kajian::where('organizer_id', $organizerId)->whereMonth('start_at', now()->month)->count();
        
        $calonPeserta = \App\Models\KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })->where('status', 'registered')->count();

        $pesertaHadir = \App\Models\KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
            $query->where('organizer_id', $organizerId);
        })->where('status', 'attended')->count();

        // Chart Data filter (hari, minggu, bulan)
        $filter = $request->get('filter', 'hari');
        $chartLabels = [];
        $chartData = [];
        $chartLabelText = "";

        if ($filter == 'bulan') {
            $chartLabelText = "12 Bulan Terakhir";
            $startDate = now()->subMonths(11)->startOfMonth();
            $attendees = \App\Models\KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })->where('created_at', '>=', $startDate)->get();
            for ($i = 11; $i >= 0; $i--) {
                $start = now()->subMonths($i)->startOfMonth();
                $end = now()->subMonths($i)->endOfMonth();
                $chartLabels[] = $start->translatedFormat('M Y');
                $chartData[] = $attendees->whereBetween('created_at', [$start, $end])->count();
            }
        } elseif ($filter == 'minggu') {
            $chartLabelText = "4 Minggu Terakhir";
            $startDate = now()->subWeeks(3)->startOfWeek();
            $attendees = \App\Models\KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })->where('created_at', '>=', $startDate)->get();
            for ($i = 3; $i >= 0; $i--) {
                $start = now()->subWeeks($i)->startOfWeek();
                $end = now()->subWeeks($i)->endOfWeek();
                $chartLabels[] = $start->format('d/m') . '-' . $end->format('d/m');
                $chartData[] = $attendees->whereBetween('created_at', [$start, $end])->count();
            }
        } else {
            $chartLabelText = "7 Hari Terakhir";
            $startDate = now()->subDays(6)->startOfDay();
            $attendees = \App\Models\KajianAttendee::whereHas('kajian', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })->where('created_at', '>=', $startDate)->get();
            for ($i = 6; $i >= 0; $i--) {
                $start = now()->subDays($i)->startOfDay();
                $end = now()->subDays($i)->endOfDay();
                $chartLabels[] = $start->format('d M');
                $chartData[] = $attendees->whereBetween('created_at', [$start, $end])->count();
            }
        }

        return view('organizer.dashboard', compact(
            'kajianAktif', 'kajianBulanIni', 'calonPeserta', 'pesertaHadir',
            'chartLabels', 'chartData', 'chartLabelText', 'filter'
        ));
    }
}

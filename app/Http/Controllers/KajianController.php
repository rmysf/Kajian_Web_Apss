<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KajianController extends Controller
{
    public function index(Request $request)
    {
        $query = Kajian::query()->where('status', 'published')->with(['organizer', 'mosque', 'speaker', 'category']);

        // Pastikan hanya yang masih aktif/upcoming
        $query->where(function($q) {
            $q->where('start_at', '>=', now())
              ->orWhere(function($subQ) {
                  $subQ->where('start_at', '<=', now())
                       ->where('end_at', '>=', now());
              });
        });

        // Filter: Category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter: Date
        if ($request->filled('date')) {
            $date = $request->date;
            if ($date === 'today') {
                $query->whereBetween('start_at', [now()->startOfDay(), now()->endOfDay()]);
            } elseif ($date === 'besok') {
                $query->whereBetween('start_at', [now()->addDay()->startOfDay(), now()->addDay()->endOfDay()]);
            } elseif ($date === 'malam-ini') {
                $query->whereBetween('start_at', [now()->startOfDay()->addHours(18), now()->endOfDay()]);
            }
        }

        // Filter: Audience
        if ($request->filled('audience')) {
            $query->where('audience', $request->audience);
        }

        // Filter: Keyword (q)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQ) use ($q) {
                $subQ->where('title', 'like', "%{$q}%")
                     ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Filter & Sort: Nearby
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if ($request->query('nearby') == 1 && $lat && $lng) {
            // Reuse scopeNearby dari model Kajian (radius default 5KM atau diabaikan jika butuh lebih besar)
            // Karena kita hanya ingin sorting by distance, kita bisa lempar radius yang besar (misal 50km) 
            // atau biarkan default 5km sesuai scope.
            $query->nearby($lat, $lng, 50); 
        } else {
            $query->orderBy('start_at', 'ASC');
        }

        $kajians = $query->paginate(6)->appends($request->query());
        $categories = Category::orderBy('name')->get();

        return view('kajian.index', compact('kajians', 'categories'));
    }

    public function show(Request $request, $slug)
    {
        $kajian = Kajian::with(['organizer', 'speaker', 'mosque', 'category'])->where('slug', $slug)->firstOrFail();
        
        $isAttending = false;
        $isFavorited = false;

        if (auth()->check()) {
            $isAttending = \App\Models\KajianAttendee::where('user_id', auth()->id())
                ->where('kajian_id', $kajian->id)
                ->where('status', '!=', 'cancelled')
                ->exists();
                
            $isFavorited = \App\Models\Favorite::where('user_id', auth()->id())
                ->where('kajian_id', $kajian->id)
                ->exists();
        }

        $attendeesCount = \App\Models\KajianAttendee::where('kajian_id', $kajian->id)
                ->where('status', '!=', 'cancelled')
                ->count();
                
        $distance = null;
        if ($request->filled('lat') && $request->filled('lng')) {
            $lat = (float) $request->lat;
            $lng = (float) $request->lng;
            $kLat = (float) $kajian->latitude;
            $kLng = (float) $kajian->longitude;
            
            $earthRadius = 6371;
            $dLat = deg2rad($kLat - $lat);
            $dLng = deg2rad($kLng - $lng);
            $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat)) * cos(deg2rad($kLat)) * sin($dLng/2) * sin($dLng/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distance = $earthRadius * $c;
        }

        return view('kajian.show', compact('kajian', 'isAttending', 'isFavorited', 'attendeesCount', 'distance'));
    }
}

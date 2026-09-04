<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(\App\Models\Kajian $kajian)
    {
        // Ensure the kajian belongs to this organizer
        if ($kajian->organizer_id !== auth()->user()->organizer->id) {
            abort(403, 'Unauthorized action.');
        }

        // Get participants (attendees) for this kajian
        $participants = \App\Models\KajianAttendee::with('user')
            ->where('kajian_id', $kajian->id)
            ->latest()
            ->paginate(10);

        return view('organizer.participants', compact('kajian', 'participants'));
    }

    public function globalIndex(Request $request)
    {
        // Get all kajians for this organizer
        $organizerId = auth()->user()->organizer->id;
        $search = $request->input('search');
        
        $participants = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->whereHas('kajian', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kajian', function ($kajianQuery) use ($search) {
                        $kajianQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('organizer.participants_global', compact('participants', 'search'));
    }

    public function exportGlobal(Request $request)
    {
        $organizerId = auth()->user()->organizer->id;
        $search = $request->input('search');
        
        $participants = \App\Models\KajianAttendee::with(['user', 'kajian'])
            ->whereHas('kajian', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kajian', function ($kajianQuery) use ($search) {
                        $kajianQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->get();

        return response()->streamDownload(function () use ($participants) {
            echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
            echo '<head>';
            echo '<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
            echo '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Data Peserta</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
            echo '</head>';
            echo '<body>';
            echo '<table border="1" cellpadding="5" cellspacing="0">';
            echo '<tr><th colspan="5" style="font-size: 16px; font-weight: bold; text-align: center; height: 40px; vertical-align: middle;">Laporan Data Peserta Kajian</th></tr>';
            echo '<tr>';
            echo '<th style="background-color: #064e3b; color: #ffffff; font-weight: bold; width: 250px;">Nama Peserta</th>';
            echo '<th style="background-color: #064e3b; color: #ffffff; font-weight: bold; width: 250px;">Email</th>';
            echo '<th style="background-color: #064e3b; color: #ffffff; font-weight: bold; width: 300px;">Kajian</th>';
            echo '<th style="background-color: #064e3b; color: #ffffff; font-weight: bold; width: 150px;">Waktu Daftar</th>';
            echo '<th style="background-color: #064e3b; color: #ffffff; font-weight: bold; width: 120px;">Status</th>';
            echo '</tr>';
            
            foreach ($participants as $p) {
                $statusColor = $p->is_attended ? '#d1fae5' : '#fef3c7';
                echo '<tr>';
                echo '<td>' . htmlspecialchars($p->user->name ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($p->user->email ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($p->kajian->title ?? '-') . '</td>';
                echo '<td>' . $p->created_at->format('d M Y H:i') . '</td>';
                echo '<td style="background-color: ' . $statusColor . '; text-align: center;">' . ($p->is_attended ? 'Hadir' : 'Belum Hadir') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</body></html>';
        }, 'Data_Peserta_Kajian.xls');
    }
}

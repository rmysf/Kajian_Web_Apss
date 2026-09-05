<x-organizer-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('organizer.kajian.index') }}" class="mr-4 text-gray-400 hover:text-gray-600">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            Kelola Peserta Kajian
        </div>
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Daftar Hadirin & Calon Peserta</h2>
                <p class="text-sm text-brand-ink-soft">Melihat daftar jamaah yang sudah hadir maupun calon peserta yang baru mendaftar pada kajian ini.</p>
            </div>
            <div class="mt-4 sm:mt-0 flex space-x-2">
                <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-sm font-medium rounded-lg text-brand-ink hover:bg-gray-50 transition">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i> Unduh Data
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Peserta</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Waktu Daftar</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($participants as $attendee)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-brand-ink">{{ $attendee->user->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-brand-ink">{{ $attendee->user->email }}</div>
                                @if($attendee->user->phone)
                                    <div class="text-xs text-brand-ink-soft mt-1">{{ $attendee->user->phone }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-brand-ink">
                                {{ $attendee->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if($attendee->status === 'registered')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-gold-soft text-brand-gold-text">Belum Hadir</span>
                                @elseif($attendee->status === 'attended')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-950">Hadir</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Dibatalkan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-brand-ink-soft">
                                Belum ada peserta yang mendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($participants->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $participants->links() }}
            </div>
        @endif
    </div>
</x-organizer-layout>

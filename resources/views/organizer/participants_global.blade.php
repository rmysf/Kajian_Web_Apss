<x-organizer-layout>
    <x-slot name="header">
        Kelola Peserta Kajian
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
            <div class="min-w-[250px]">
                <h2 class="text-lg font-bold text-brand-ink">Daftar Hadirin & Calon Peserta</h2>
                <p class="text-sm text-brand-ink-soft">Melihat seluruh jamaah yang sudah hadir maupun calon peserta yang baru mendaftar pada kajian Anda.</p>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <form action="{{ route('organizer.peserta.global') }}" method="GET" class="relative flex-1 md:flex-none md:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peserta atau kajian..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand-emerald-500 focus:border-brand-emerald-500 block w-full pl-9 pr-8 py-2 shadow-sm transition outline-none">
                    @if(request('search'))
                        <a href="{{ route('organizer.peserta.global') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </a>
                    @endif
                </form>
                <a href="{{ route('organizer.peserta.export', ['search' => request('search')]) }}" class="shrink-0 inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-sm font-medium rounded-lg text-brand-ink hover:bg-gray-50 transition shadow-sm whitespace-nowrap">
                    <i data-lucide="download" class="w-4 h-4 sm:mr-2"></i> <span class="hidden sm:inline">Unduh Data</span><span class="sm:hidden">Unduh</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Peserta</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Kajian</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Waktu Daftar</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($participants as $attendee)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-brand-ink">{{ $attendee->user->name }}</div>
                                <div class="text-sm text-brand-ink-soft mt-1">{{ $attendee->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-brand-ink font-medium">{{ $attendee->kajian->title }}</div>
                                <div class="text-xs text-brand-ink-soft mt-1">{{ \Carbon\Carbon::parse($attendee->kajian->start_at)->format('d M Y') }}</div>
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

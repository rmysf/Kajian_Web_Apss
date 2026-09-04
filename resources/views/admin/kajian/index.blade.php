<x-admin-layout>
    <x-slot name="header">
        Moderasi Kajian
    </x-slot>

    <div>
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                <div class="min-w-[250px]">
                    <h2 class="text-lg font-bold text-brand-ink">Moderasi Kajian Masuk</h2>
                    <p class="text-sm text-brand-ink-soft">Tinjau dan verifikasi kajian baru yang dikirimkan oleh penyelenggara.</p>
                </div>
                <div class="flex items-center w-full md:w-auto">
                    <form action="{{ route('admin.kajian.index') }}" method="GET" class="relative flex-1 md:flex-none md:w-64">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kajian atau penyelenggara..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand-emerald-500 focus:border-brand-emerald-500 block w-full pl-9 pr-8 py-2 shadow-sm transition outline-none">
                        @if(request('search'))
                            <a href="{{ route('admin.kajian.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </form>
                </div>
            </div>



            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Judul & Penyelenggara</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status Verifikasi</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($kajians as $kajian)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-brand-ink">{{ $kajian->title }}</div>
                                <div class="text-sm text-brand-ink-soft mt-1">Oleh: {{ $kajian->organizer->name ?? 'Penyelenggara Tidak Diketahui' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-brand-ink">{{ $kajian->start_at ? $kajian->start_at->format('d M Y') : '-' }}</div>
                                <div class="text-xs text-brand-ink-soft mt-1">
                                    {{ $kajian->start_at ? $kajian->start_at->format('H:i') : '-' }} 
                                    - 
                                    {{ $kajian->end_at ? $kajian->end_at->format('H:i') : '-' }} WIB
                                </div>
                                <div class="mt-2 text-[11px] font-bold px-2 py-0.5 rounded w-max bg-gray-100 text-gray-700">
                                    {{ $kajian->status_label }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($kajian->is_verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-900">Disetujui</span>
                                @elseif($kajian->status === 'rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-gold-soft text-brand-gold-text">Menunggu</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.kajian.show', $kajian->slug) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Lihat Detail & Moderasi">
                                    <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Tinjau Detail</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-brand-ink-soft">
                                Tidak ada kajian yang perlu dimoderasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $kajians->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>

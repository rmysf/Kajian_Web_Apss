<x-admin-layout>
    <x-slot name="header">
        Moderasi Penyelenggara
    </x-slot>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
            <div class="min-w-[250px]">
                <h2 class="text-lg font-bold text-brand-ink">Daftar Akun Penyelenggara</h2>
                <p class="text-sm text-brand-ink-soft">Kelola status verifikasi akun organizer agar mereka bisa membuat kajian publik.</p>
            </div>
            <div class="flex items-center w-full md:w-auto">
                <form action="{{ route('admin.organizer.index') }}" method="GET" class="relative flex-1 md:flex-none md:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari organizer..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand-emerald-500 focus:border-brand-emerald-500 block w-full pl-9 pr-8 py-2 shadow-sm transition outline-none">
                    @if(request('search'))
                        <a href="{{ route('admin.organizer.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
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
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Organizer</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($organizers as $organizer)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-brand-ink">{{ $organizer->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $organizer->user->email ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($organizer->is_verified)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-950">Terverifikasi</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Belum Diverifikasi</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.organizer.show', $organizer->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5"></i>
                                    <span class="hidden sm:inline">Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-brand-ink-soft">Belum ada penyelenggara.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $organizers->links() }}
        </div>
    </div>
</x-admin-layout>

<x-organizer-layout>
    <x-slot name="header">
        Kelola Kajian
    </x-slot>

    <div x-data="{ deleteModalOpen: false, deleteFormAction: '' }" class="bg-white border border-gray-200 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="text-lg font-bold text-brand-ink">Daftar Kajian</h2>
                <p class="text-sm text-brand-ink-soft">Kelola semua jadwal kajian yang Anda selenggarakan.</p>
            </div>
            <a href="{{ route('organizer.kajian.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900">
                <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i> Tambah Kajian
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Judul Kajian</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($kajians as $kajian)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-medium text-brand-ink">{{ $kajian->title }}</div>
                                <div class="text-sm text-brand-ink-soft mt-1">{{ $kajian->category->name ?? '-' }} • {{ $kajian->speaker->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-brand-ink">{{ \Carbon\Carbon::parse($kajian->start_at)->format('d M Y') }}</div>
                                <div class="text-xs text-brand-ink-soft mt-1">{{ \Carbon\Carbon::parse($kajian->start_at)->format('H:i') }} - {{ \Carbon\Carbon::parse($kajian->end_at)->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($kajian->status === 'draft')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Draft</span>
                                @elseif($kajian->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-emerald-100 text-brand-emerald-950">Dipublikasikan</span>
                                @elseif($kajian->status === 'ongoing')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-badge-live text-white">Berlangsung</span>
                                @elseif($kajian->status === 'finished')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-800 text-gray-100">Selesai</span>
                                @elseif($kajian->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-brand-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('organizer.kajian.show', $kajian->slug) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5"></i>
                                    <span class="hidden sm:inline">Detail</span>
                                </a>
                                <a href="{{ route('organizer.kajian.edit', $kajian->slug) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4 sm:mr-1.5"></i>
                                    <span class="hidden sm:inline">Edit</span>
                                </a>
                                <button type="button" @click="deleteModalOpen = true; deleteFormAction = '{{ route('organizer.kajian.destroy', $kajian->slug) }}'" class="inline-flex items-center px-3 py-1.5 border border-brand-danger text-sm font-medium rounded-md text-white bg-brand-danger hover:bg-red-700 transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4 sm:mr-1.5"></i>
                                    <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-brand-ink-soft">
                                <div class="flex flex-col items-center justify-center">
                                    <i data-lucide="book-x" class="w-12 h-12 mb-3 text-gray-300"></i>
                                    <p>Belum ada kajian yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="deleteModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="deleteModalOpen = false"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="deleteModalOpen" x-transition.scale.origin.bottom.sm class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="alert-triangle" class="h-6 w-6 text-brand-danger"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Hapus Kajian</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus kajian ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form method="POST" :action="deleteFormAction">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-brand-danger text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Hapus Permanen
                            </button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-organizer-layout>

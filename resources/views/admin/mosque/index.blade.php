<x-admin-layout>
    <x-slot name="header">
        Master Data: Masjid
    </x-slot>

    <div x-data="{ deleteModalOpen: false, deleteFormAction: '' }" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Card Header -->
        <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 gap-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Daftar Masjid</h2>
                <p class="text-sm text-gray-500 mt-1">Kelola data masjid utama yang bisa dipilih oleh penyelenggara.</p>
            </div>
            <a href="{{ route('admin.mosque.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-brand-emerald-900 rounded-md hover:bg-brand-emerald-950 transition-colors shrink-0">
                <i data-lucide="plus" class="w-4 h-4 mr-2"></i> TAMBAH MASJID
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Nama Masjid</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Lokasi</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($mosques as $mosque)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5 font-medium text-gray-900">
                                {{ $mosque->name }}
                            </td>
                            <td class="px-6 py-5 text-gray-500">
                                {{ Str::limit($mosque->address, 60) }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.mosque.edit', $mosque->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                        <i data-lucide="edit-2" class="w-3.5 h-3.5 mr-1.5 text-gray-500"></i> Edit
                                    </a>
                                    
                                    <button type="button" @click="deleteModalOpen = true; deleteFormAction = '{{ route('admin.mosque.destroy', $mosque->id) }}'" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-white border border-red-200 rounded-md hover:bg-red-50 transition-colors">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5 mr-1.5"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i data-lucide="map-pin" class="w-8 h-8 text-gray-300 mb-2"></i>
                                    <p>Belum ada data masjid yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mosques->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $mosques->links() }}
            </div>
        @endif

        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay -->
            <div x-show="deleteModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="deleteModalOpen = false"></div>
            
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="deleteModalOpen" x-transition.scale.origin.center class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-md border border-gray-100">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Hapus Masjid</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data masjid ini? Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <form method="POST" :action="deleteFormAction">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition">
                                Ya, Hapus
                            </button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<x-admin-layout>
    <x-slot name="header">
        Master Data: Pemateri
    </x-slot>

    <!-- Alpine.js is assumed to be loaded via Layout -->
    <div x-data="{ deleteModalOpen: false, deleteFormAction: '', detailModalOpen: false, selectedSpeaker: null }">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm mb-6">
            <div class="p-6 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                <div class="min-w-[250px]">
                    <h2 class="text-lg font-bold text-brand-ink">Daftar Pemateri / Ustadz</h2>
                    <p class="text-sm text-brand-ink-soft">Kelola database profil asatidzah.</p>
                </div>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <form action="{{ route('admin.speaker.index') }}" method="GET" class="relative flex-1 md:flex-none md:w-64">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pemateri..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand-emerald-500 focus:border-brand-emerald-500 block w-full pl-9 pr-8 py-2 shadow-sm transition outline-none">
                        @if(request('search'))
                            <a href="{{ route('admin.speaker.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                                <i data-lucide="x" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </form>
                    <a href="{{ route('admin.speaker.create') }}" class="shrink-0 inline-flex justify-center items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition shadow-sm whitespace-nowrap">
                        <i data-lucide="plus-circle" class="w-4 h-4 sm:mr-2"></i> <span class="hidden sm:inline">Tambah Pemateri</span><span class="sm:hidden">Tambah</span>
                    </a>
                </div>
            </div>


            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Pemateri</th>
                            <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($speakers as $speaker)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-brand-ink">{{ $speaker->name }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @php
                                    $speakerData = [
                                        'name' => $speaker->name,
                                        'photo' => $speaker->photo ? Storage::url($speaker->photo) : null,
                                        'description' => $speaker->description,
                                        'created_at' => $speaker->created_at ? $speaker->created_at->format('d M Y') : '-',
                                        'edit_url' => route('admin.speaker.edit', $speaker->id)
                                    ];
                                @endphp
                                <button type="button" @click="detailModalOpen = true; selectedSpeaker = {{ json_encode($speakerData) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Detail">
                                    <i data-lucide="eye" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Detail</span>
                                </button>
                                <button type="button" @click="deleteModalOpen = true; deleteFormAction = '{{ route('admin.speaker.destroy', $speaker->id) }}'" class="inline-flex items-center px-3 py-1.5 border border-red-200 text-sm font-medium rounded-md text-red-600 bg-red-50 hover:bg-red-100 transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4 sm:mr-1.5"></i> <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-brand-ink-soft">
                                Belum ada data pemateri.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $speakers->onEachSide(1)->links() }}
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="deleteModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 transition-opacity bg-gray-500/75" aria-hidden="true" @click="deleteModalOpen = false"></div>
                
                <div x-show="deleteModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" 
                     role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-headline">
                                Hapus Pemateri
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus data pemateri ini? Semua data terkait mungkin akan terpengaruh. Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <form :action="deleteFormAction" method="POST" class="inline-block w-full sm:w-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 sm:ml-3 sm:w-auto sm:text-sm">
                                Ya, Hapus
                            </button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Modal -->
        <div x-show="detailModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <!-- Background overlay -->
                <div x-show="detailModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 transition-opacity bg-gray-500/75" aria-hidden="true" @click="detailModalOpen = false"></div>
                
                <!-- Modal panel -->
                <div x-show="detailModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle w-full max-w-3xl" 
                     role="dialog" aria-modal="true">
                    
                    <div class="flex flex-col md:flex-row w-full bg-white">
                        <!-- Bagian Kiri: Foto Full -->
                        <div class="w-full md:w-2/5 lg:w-1/3 h-64 md:h-auto relative bg-brand-emerald-50 shrink-0 border-b md:border-b-0 md:border-r border-gray-200">
                            <template x-if="selectedSpeaker?.photo">
                                <img :src="selectedSpeaker?.photo" :alt="selectedSpeaker?.name" class="absolute inset-0 w-full h-full object-cover">
                            </template>
                            <template x-if="!selectedSpeaker?.photo">
                                <div class="absolute inset-0 w-full h-full flex items-center justify-center">
                                    <svg class="w-24 h-24 text-brand-emerald-700 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            </template>
                        </div>

                        <!-- Bagian Kanan: Detail Text -->
                        <div class="relative w-full md:w-3/5 lg:w-2/3 p-6 md:p-8 bg-white flex flex-col">
                            <button type="button" @click="detailModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 rounded-full p-2 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <!-- Header Info -->
                            <div class="mb-6 pr-10">
                                <h2 class="text-2xl font-bold text-brand-ink mb-1" x-text="selectedSpeaker?.name"></h2>
                                <p class="text-sm text-brand-ink-soft">Ditambahkan pada: <span x-text="selectedSpeaker?.created_at"></span></p>
                            </div>

                            <h3 class="text-lg font-bold text-brand-ink mb-3 border-b border-gray-100 pb-2">Biografi / Deskripsi</h3>
                            
                            <div class="prose prose-sm max-w-none text-brand-ink-soft overflow-y-auto max-h-48 mb-6" style="white-space: pre-line;">
                                <template x-if="selectedSpeaker?.description">
                                    <span x-text="selectedSpeaker.description"></span>
                                </template>
                                <template x-if="!selectedSpeaker?.description">
                                    <p class="italic text-gray-400">Belum ada biografi atau deskripsi untuk pemateri ini.</p>
                                </template>
                            </div>

                            <!-- Footer Section (Stats & Action) -->
                            <div class="mt-auto pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div class="w-full sm:w-1/2">
                                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Statistik Terkait</h3>
                                    <div class="flex items-center">
                                        <div class="bg-brand-emerald-100 text-brand-emerald-700 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-brand-ink-soft">Total Kajian</p>
                                            <p class="text-base font-bold text-brand-ink">-</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="w-full sm:w-auto flex justify-end">
                                    <a :href="selectedSpeaker?.edit_url" class="inline-flex justify-center items-center px-4 py-2 border border-brand-emerald-900 text-sm font-medium rounded-lg text-brand-emerald-900 bg-white hover:bg-brand-emerald-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-emerald-900 transition shadow-sm w-full sm:w-auto">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

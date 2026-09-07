<x-admin-layout>
    <x-slot name="header">
        Master Data: Kategori
    </x-slot>

    <div x-data="{ 
        deleteModalOpen: false, 
        deleteFormAction: '',
        
        editModalOpen: false,
        activeCategory: null,
        formAction: '{{ route('admin.category.store') }}',
        isEdit: false,

        openCreateModal() {
            this.activeCategory = { name: '' };
            this.formAction = '{{ route('admin.category.store') }}';
            this.isEdit = false;
            this.editModalOpen = true;
        },
        openEditModal(category) {
            this.activeCategory = { name: category.name };
            this.formAction = category.update_url;
            this.isEdit = true;
            this.editModalOpen = true;
        },
        closeModal() {
            this.editModalOpen = false;
            this.deleteModalOpen = false;
            setTimeout(() => { this.activeCategory = null; }, 300);
        }
    }" class="bg-white border border-gray-200 rounded-xl shadow-sm">
        
        <div class="p-6 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
            <div class="min-w-[250px]">
                <h2 class="text-lg font-bold text-brand-ink">Daftar Kategori</h2>
                <p class="text-sm text-brand-ink-soft">Kelola referensi kategori untuk kajian.</p>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <form action="{{ route('admin.category.index') }}" method="GET" class="relative flex-1 md:flex-none md:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..." class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-brand-emerald-500 focus:border-brand-emerald-500 block w-full pl-9 pr-8 py-2 shadow-sm transition outline-none">
                    @if(request('search'))
                        <a href="{{ route('admin.category.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </a>
                    @endif
                </form>
                <button type="button" @click="openCreateModal()" class="shrink-0 inline-flex justify-center items-center px-4 py-2 bg-brand-emerald-900 text-white text-sm font-medium rounded-lg hover:bg-brand-emerald-950 transition shadow-sm whitespace-nowrap">
                    <i data-lucide="plus-circle" class="w-4 h-4 sm:mr-2"></i> <span class="hidden sm:inline">Tambah Kategori</span><span class="sm:hidden">Tambah</span>
                </button>
            </div>
        </div>


        @if(session('error'))
            <div class="bg-red-50 text-red-800 p-4 border-b border-red-200 text-sm">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 text-red-800 p-4 border-b border-red-200 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-xs font-semibold text-brand-ink-soft uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-brand-ink">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button type="button" @click="openEditModal({{ json_encode([
                                    'name' => $category->name,
                                    'update_url' => route('admin.category.update', $category->id)
                                ]) }})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-brand-ink bg-white hover:bg-gray-50 transition" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4 sm:mr-1.5"></i>
                                    <span class="hidden sm:inline">Edit</span>
                                </button>
                                <button type="button" @click="deleteModalOpen = true; deleteFormAction = '{{ route('admin.category.destroy', $category->id) }}'" class="inline-flex items-center px-3 py-1.5 border border-red-200 text-sm font-medium rounded-md text-red-600 bg-red-50 hover:bg-red-100 transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4 sm:mr-1.5"></i>
                                    <span class="hidden sm:inline">Hapus</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-brand-ink-soft">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $categories->onEachSide(1)->links() }}
        </div>

        <!-- Create/Edit Modal -->
        <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay -->
            <div x-show="editModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <!-- Modal panel -->
                <div x-show="editModalOpen" x-transition.scale.origin.center class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-md border border-gray-100">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-bold text-brand-ink" id="modal-title" x-text="isEdit ? 'Edit Kategori' : 'Tambah Kategori'"></h3>
                        <button type="button" @click="closeModal()" class="rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 transition">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <!-- Modal Body & Form -->
                    <template x-if="activeCategory">
                        <form :action="formAction" method="POST">
                            @csrf
                            <template x-if="isEdit">
                                @method('PUT')
                            </template>
                            
                            <div class="px-6 py-5 bg-gray-50/50">
                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                                    <input type="text" id="name" name="name" x-model="activeCategory.name" required placeholder="Contoh: Fiqih" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-emerald-500 focus:ring-brand-emerald-500 sm:text-sm">
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="bg-white px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                                <button type="button" @click="closeModal()" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 font-bold rounded-lg hover:bg-gray-50 transition text-sm">
                                    Batal
                                </button>
                                <button type="submit" class="px-4 py-2 bg-brand-emerald-900 text-white font-bold rounded-lg hover:bg-brand-emerald-950 shadow-sm transition text-sm flex items-center">
                                    <i data-lucide="save" class="w-4 h-4 mr-2"></i> <span x-text="isEdit ? 'Simpan Perubahan' : 'Tambah Kategori'"></span>
                                </button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay -->
            <div x-show="deleteModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="closeModal()"></div>
            
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="deleteModalOpen" x-transition.scale.origin.center class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 w-full max-w-md border border-gray-100">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Hapus Kategori</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.</p>
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
                        <button type="button" @click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

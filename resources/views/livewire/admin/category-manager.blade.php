<div class="h-screen text-slate-200 flex overflow-hidden relative z-10 text-left"
     x-data="{ confirmDelete: false, deleteId: null }"
     x-on:open-delete-modal.window="confirmDelete = true; deleteId = $event.detail.id">
    <x-sidebar active="categories" />
    <main class="flex-1 flex flex-col overflow-y-auto w-full custom-scrollbar">
        <x-header title="Kelola Kategori" subtitle="Manajemen Klasifikasi Data Geografis" />
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-500/10 flex items-center justify-center border border-blue-500/20 text-blue-400 shadow-lg shadow-blue-500/5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" /></svg>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 italic">Geser ikon untuk mengatur urutan tampil</p>
                </div>
                <button wire:click="openModal" class="w-full sm:w-fit btn-3d-blue px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400">+ Tambah Kategori</button>
            </div>
            <div class="glass-card rounded-[30px] sm:rounded-[40px] overflow-hidden border border-white/5 mb-20">
                <div class="overflow-x-auto w-full max-w-full custom-scrollbar">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5">
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 w-24">Urutan</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30">Informasi Kategori</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-categories" class="divide-y divide-white/5">
                            @forelse($categories as $cat)
                            <tr class="hover:bg-white/5 transition-colors group" data-id="{{ $cat->id }}">
                                <td class="px-8 py-6">
                                    <div class="handle cursor-grab active:cursor-grabbing w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-white/20 hover:text-blue-500 transition-all border border-white/5">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8h16M4 16h16" /></svg>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="font-black italic text-white tracking-tighter text-lg uppercase">{{ $cat->name }}</p>
                                </td>
                                <td class="px-8 py-6 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-3">
                                        <button wire:click="edit('{{ $cat->id }}')" class="btn-3d-slate p-3 rounded-xl text-blue-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </button>
                                        <button @click="$dispatch('open-delete-modal', { id: '{{ $cat->id }}' })" class="btn-3d-red p-3 rounded-xl text-red-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="p-20 text-center text-white/10 font-black uppercase tracking-[0.5em] italic text-xl">Data Belum Tersedia</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($isModalOpen)
        <div class="fixed inset-0 z-[2000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" wire:click="closeModal"></div>
            <div class="relative glass-card w-full max-w-lg rounded-[40px] p-8 sm:p-12 border border-white/10 shadow-2xl text-left">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/20 flex items-center justify-center text-blue-500 border border-blue-500/20 shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h2 class="text-2xl font-black italic uppercase tracking-tighter text-white">Formulir <span class="text-blue-500">Kategori</span></h2>
                </div>
                <form wire:submit.prevent="save" class="space-y-8">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-3 block">Nama Klasifikasi Kategori</label>
                        <input type="text" wire:model="name" class="bg-black/40 border border-white/5 w-full px-7 py-5 rounded-[20px] text-white focus:outline-none focus:border-blue-500/50 shadow-inner text-lg transition-all" placeholder="Masukkan nama kategori">
                        @error('name') <span class="text-red-500 text-[10px] ml-5 mt-2 block font-bold uppercase tracking-widest">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-4 flex flex-col sm:flex-row justify-end gap-4">
                        <button type="button" wire:click="closeModal" class="btn-3d-slate px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white/40 order-2 sm:order-1">Batalkan</button>
                        <button type="submit" class="btn-3d-blue px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400 order-1 sm:order-2">
                            <span wire:loading.remove>Simpan Data</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-[2000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-md" @click="confirmDelete = false"></div>
            <div class="relative glass-card w-full max-w-md rounded-[40px] p-10 border border-red-500/20 shadow-2xl text-center">
                <div class="w-20 h-20 bg-red-500/20 border border-red-500/40 rounded-full flex items-center justify-center mx-auto mb-8 text-red-500">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <h3 class="text-2xl font-black italic uppercase tracking-tighter text-white mb-3">Konfirmasi Hapus</h3>
                <p class="text-sm text-white/40 mb-10 leading-relaxed font-medium">Tindakan ini bersifat permanen. Seluruh data spasial yang terhubung dengan kategori ini akan ikut terhapus.</p>
                <div class="flex flex-col gap-4">
                    <button @click="$wire.delete(deleteId); confirmDelete = false" class="btn-3d-red w-full py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest text-red-500">Ya, Hapus Secara Permanen</button>
                    <button @click="confirmDelete = false" class="btn-3d-slate w-full py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest text-white/30">Batalkan Tindakan</button>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('livewire:navigated', () => {
            const el = document.getElementById('sortable-categories');
            if (el) {
                Sortable.create(el, {
                    handle: '.handle', animation: 250, ghostClass: 'sortable-ghost',
                    onEnd: function () {
                        const items = Array.from(el.querySelectorAll('tr')).map((tr, index) => {
                            return { value: tr.dataset.id, order: index + 1 };
                        });
                        @this.updateOrder(items);
                    }
                });
            }
        });
    </script>
</div>

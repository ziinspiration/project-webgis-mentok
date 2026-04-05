<div class="min-h-screen text-slate-200 flex overflow-hidden relative z-10 text-left" x-data="{ confirmDelete: false, deleteId: null }" x-on:open-delete-modal.window="confirmDelete = true; deleteId = $event.detail.id">
    <x-sidebar active="categories" />
    <main class="flex-1 flex flex-col overflow-y-auto w-full">
        <x-header title="Kelola Kategori" subtitle="Manajemen Klasifikasi Data" />
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                <p class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em] text-white/20 italic">Geser ikon <span class="text-blue-500">☰</span> untuk mengurutkan</p>
                <button wire:click="openModal" class="w-full sm:w-fit bg-blue-500/10 border border-white/10 px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400 shadow-lg active:scale-95 transition-all">+ Tambah Kategori</button>
            </div>
            <div class="glass-card rounded-[24px] sm:rounded-[40px] overflow-hidden border border-white/5 text-left">
                <div class="overflow-x-auto w-full custom-scrollbar">
                    <table class="w-full text-left border-collapse min-w-[500px]">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5">
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 w-16">Urut</th>
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30">Nama Kategori</th>
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-categories" class="divide-y divide-white/5">
                            @forelse($categories as $cat)
                            <tr class="hover:bg-white/5 transition-colors group" data-id="{{ $cat->id }}">
                                <td class="px-6 py-6">
                                    <div class="cursor-grab active:cursor-grabbing text-white/20 hover:text-blue-500 handle transition-colors">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" /></svg>
                                    </div>
                                </td>
                                <td class="px-6 py-6 font-black italic text-white tracking-tighter text-base sm:text-lg">
                                    {{ $cat->name }}
                                    <p class="text-[9px] font-mono text-white/20 tracking-normal normal-case italic">slug: {{ $cat->slug }}</p>
                                </td>
                                <td class="px-6 py-6 text-right space-x-2 whitespace-nowrap">
                                    <button wire:click="edit('{{ $cat->id }}')" class="text-blue-500/40 hover:text-blue-400 transition-colors inline-block"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></button>
                                    <button @click="$dispatch('open-delete-modal', { id: '{{ $cat->id }}' })" class="text-red-500/40 hover:text-red-400 transition-colors inline-block"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="p-12 text-center text-white/20 font-black uppercase tracking-widest italic text-center">Data Belum Tersedia</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($isModalOpen)
        <div class="fixed inset-0 z-[2000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="closeModal"></div>
            <div class="relative glass-card w-full max-w-lg rounded-[30px] sm:rounded-[40px] p-6 sm:p-10 border border-white/10 shadow-2xl text-left">
                <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter mb-8 text-white">Form <span class="text-blue-500">Kategori</span></h2>
                <form wire:submit.prevent="save" class="space-y-6">
                    <div>
                        <label class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block">Nama Kategori</label>
                        <input type="text" wire:model="name" class="bg-black/20 border border-white/5 w-full px-6 py-4 rounded-2xl text-white focus:outline-none focus:border-blue-500/50 shadow-inner" placeholder="Masukkan nama kategori">
                        @error('name') <span class="text-red-500 text-[10px] ml-4 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-4 flex flex-col sm:flex-row justify-end gap-3">
                        <button type="button" @click="closeModal" class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-white/20 hover:text-white transition-all order-2 sm:order-1">Batal</button>
                        <button type="submit" class="bg-blue-500/10 border border-white/10 px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400 order-1 sm:order-2">
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
            <div class="relative glass-card w-full max-w-md rounded-[30px] sm:rounded-[40px] p-8 sm:p-10 border border-red-500/20 shadow-2xl text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-500/20 border border-red-500/40 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500"><svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg></div>
                <h3 class="text-lg sm:text-xl font-black italic uppercase tracking-tighter text-white mb-2">Hapus Data?</h3>
                <div class="flex flex-col gap-3 mt-8">
                    <button @click="$wire.delete(deleteId); confirmDelete = false" class="bg-red-500/10 border border-red-500/40 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-red-500 hover:bg-red-500 hover:text-white transition-all">Ya, Hapus Permanen</button>
                    <button @click="confirmDelete = false" class="py-4 text-[10px] font-black uppercase tracking-widest text-white/20 hover:text-white transition-all">Batalkan</button>
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

<div class="min-h-screen text-slate-200 flex overflow-hidden relative z-10 text-left" x-data="{ confirmDelete: false, deleteId: null }" x-on:open-delete-modal.window="confirmDelete = true; deleteId = $event.detail.id">
    <x-sidebar active="users" />
    <main class="flex-1 flex flex-col overflow-y-auto w-full text-left">
        <x-header title="Kelola Pengguna" subtitle="Manajemen Hak Akses Sistem" />
        <div class="p-4 sm:p-6 lg:p-8 text-left">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8 text-left">
                <div class="relative group w-full sm:w-96 text-left">
                    <input type="text" wire:model.live="search" class="bg-white/5 border border-white/10 w-full pl-12 pr-6 py-4 rounded-2xl text-white focus:outline-none focus:border-blue-500/50 shadow-inner transition-all text-sm" placeholder="Cari nama atau NIP...">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue-500 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                </div>
                <button wire:click="openModal" class="w-full sm:w-fit bg-blue-500/10 border border-white/10 px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400 shadow-lg active:scale-95 transition-all">+ Tambah Pengguna</button>
            </div>

            <div class="glass-card rounded-[24px] sm:rounded-[40px] overflow-hidden border border-white/5 text-left">
                <div class="overflow-x-auto w-full custom-scrollbar text-left">
                    <table class="w-full text-left border-collapse min-w-[700px] text-left">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5 text-left">
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-left">Nama Lengkap</th>
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-left">NIP / Identitas</th>
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-left">Email</th>
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-right text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-left">
                            @forelse($users as $u)
                            <tr class="hover:bg-white/5 transition-colors group text-left">
                                <td class="px-6 py-6 text-left">
                                    <div class="flex items-center gap-3 text-left">
                                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 font-black text-xs uppercase">{{ substr($u->name, 0, 1) }}</div>
                                        <p class="font-black italic uppercase text-white tracking-tighter text-base text-left">{{ $u->name }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-left"><span class="bg-white/5 border border-white/10 px-3 py-1 rounded-lg text-white/50 font-mono text-[11px] text-left">{{ $u->nip }}</span></td>
                                <td class="px-6 py-6 text-left text-white/40 text-sm text-left">{{ $u->email }}</td>
                                <td class="px-6 py-6 text-right space-x-2 whitespace-nowrap text-left">
                                    <button wire:click="edit('{{ $u->id }}')" class="text-blue-500/40 hover:text-blue-400 transition-colors text-left"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></button>
                                    @if($u->id !== auth()->id())
                                    <button @click="$dispatch('open-delete-modal', { id: '{{ $u->id }}' })" class="text-red-500/40 hover:text-red-400 transition-colors text-left"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-12 text-center text-white/20 font-black uppercase tracking-widest italic text-center">Data Tidak Ditemukan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($isModalOpen)
        <div class="fixed inset-0 z-[2000] flex items-center justify-center p-3 sm:p-4 text-left">
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="closeModal"></div>
            <div class="relative glass-card w-full max-w-lg rounded-[30px] sm:rounded-[40px] p-6 sm:p-10 border border-white/10 shadow-2xl text-left text-left">
                <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter mb-8 text-white text-left">Data <span class="text-blue-500">Pengguna</span></h2>
                <form wire:submit.prevent="save" class="space-y-5 text-left">
                    <div class="text-left"><label class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block text-left">Nama Lengkap</label><input type="text" wire:model="name" class="bg-black/20 border border-white/5 w-full px-6 py-4 rounded-2xl text-white focus:outline-none shadow-inner" placeholder="Masukkan nama...">@error('name') <span class="text-red-500 text-[10px] ml-4 mt-1">{{ $message }}</span> @enderror</div>
                    <div class="text-left"><label class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block text-left">NIP / Nomor Induk</label><input type="text" wire:model="nip" class="bg-black/20 border border-white/5 w-full px-6 py-4 rounded-2xl text-white focus:outline-none shadow-inner" placeholder="Masukkan NIP...">@error('nip') <span class="text-red-500 text-[10px] ml-4 mt-1">{{ $message }}</span> @enderror</div>
                    <div class="text-left"><label class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block text-left">Alamat Email</label><input type="email" wire:model="email" class="bg-black/20 border border-white/5 w-full px-6 py-4 rounded-2xl text-white focus:outline-none shadow-inner" placeholder="Masukkan email...">@error('email') <span class="text-red-500 text-[10px] ml-4 mt-1">{{ $message }}</span> @enderror</div>

                    <div class="bg-blue-500/5 border border-blue-500/10 p-4 rounded-2xl mt-4 text-left text-left"><p class="text-[10px] text-blue-400/80 leading-relaxed italic text-left">* Pengguna baru akan menerima email untuk mengatur kata sandi mereka secara mandiri setelah data disimpan.</p></div>

                    <div class="pt-6 flex flex-col sm:flex-row justify-end gap-3 text-left"><button type="button" @click="closeModal" class="px-6 py-4 text-[10px] font-black uppercase text-white/20 hover:text-white transition-all order-2 sm:order-1 text-left">Batal</button><button type="submit" wire:loading.attr="disabled" class="bg-blue-500/10 border border-white/10 px-8 py-4 rounded-2xl text-[10px] font-black uppercase text-blue-400 order-1 sm:order-2 text-left text-left text-left"><span wire:loading.remove>Simpan & Kirim Email</span><span wire:loading>Memproses...</span></button></div>
                </form>
            </div>
        </div>
        @endif

        <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-[2000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-md" @click="confirmDelete = false"></div>
            <div class="relative glass-card w-full max-w-md rounded-[30px] p-8 sm:p-10 border border-red-500/20 shadow-2xl text-center text-center"><div class="w-16 h-16 sm:w-20 sm:h-20 bg-red-500/20 border border-red-500/40 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500"><svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg></div><h3 class="text-lg sm:text-xl font-black italic uppercase tracking-tighter text-white mb-2">Hapus Pengguna?</h3><div class="flex flex-col gap-3 mt-8 text-center"><button @click="$wire.delete(deleteId); confirmDelete = false" class="bg-red-500/10 border border-red-500/40 py-4 rounded-2xl text-[10px] font-black uppercase text-red-500 text-center">Ya, Hapus Permanen</button><button @click="confirmDelete = false" class="py-4 text-[10px] font-black uppercase text-white/20 text-center">Batalkan</button></div></div>
        </div>
    </main>
</div>

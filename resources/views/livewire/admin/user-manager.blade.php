<div class="h-screen flex overflow-hidden bg-slate-950">
    <x-sidebar active="users" />
    <main class="flex-1 flex flex-col overflow-y-auto bg-slate-950/50 text-left custom-scrollbar">
        <x-header title="Kelola Pengguna" subtitle="Manajemen Hak Akses & Keamanan Sistem" />
        <div class="p-6 lg:p-10 pb-20">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                <div class="relative group w-full max-w-lg">
                    <div class="absolute left-6 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" wire:model.live="search" class="bg-black/30 border border-white/5 w-full pl-16 pr-8 py-5 rounded-[25px] text-white focus:outline-none focus:border-blue-500/30 shadow-inner text-sm transition-all" placeholder="Cari NIP atau Nama...">
                </div>
                <button wire:click="openModal" class="btn-3d-blue w-full md:w-fit px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400">
                    + Daftarkan Admin Baru
                </button>
            </div>
            <div class="glass-card rounded-[40px] overflow-hidden border border-white/5">
           <div class="overflow-x-auto w-full max-w-full custom-scrollbar">
                    <table class="w-full border-collapse min-w-[1100px]">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5">
                                <th class="px-8 py-7 text-[10px] font-black uppercase tracking-widest text-white/30">Identitas Personal</th>
                                <th class="px-8 py-7 text-[10px] font-black uppercase tracking-widest text-white/30 text-center">Status</th>
                                <th class="px-8 py-7 text-[10px] font-black uppercase tracking-widest text-white/30 text-center">Otoritas</th>
                                <th class="px-8 py-7 text-[10px] font-black uppercase tracking-widest text-white/30 text-right">Kelola</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($users as $u)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-14 h-14 rounded-2xl bg-blue-600/10 flex items-center justify-center text-blue-400 font-black text-xl border border-blue-500/20 shadow-xl shrink-0 uppercase italic">{{ substr($u->name, 0, 1) }}</div>
                                        <div>
                                            <p class="font-black italic uppercase text-white tracking-tighter text-lg leading-none mb-1">{{ $u->name }}</p>
                                            <p class="text-[10px] text-white/20 font-mono tracking-widest">{{ $u->nip }} • {{ $u->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <span class="text-[9px] font-black px-4 py-1.5 rounded-full border {{ $u->is_active ? 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20' : 'bg-red-500/10 text-red-500 border-red-500/20' }} uppercase tracking-widest">
                                            {{ $u->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="text-[10px] font-black uppercase tracking-widest {{ $u->is_allaccess ? 'text-blue-500' : 'text-white/20' }}">
                                        {{ $u->is_allaccess ? 'Administrator' : 'Operator' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-end gap-3">
                                        @if($u->id !== auth()->id())
                                            <button wire:click="toggleAccess('{{ $u->id }}')" class="btn-3d-slate p-3 rounded-xl text-blue-400" title="Ubah Otoritas">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                            </button>
                                            <button wire:click="toggleStatus('{{ $u->id }}')" class="btn-3d-slate p-3 rounded-xl {{ $u->is_active ? 'text-red-500' : 'text-emerald-500' }}" title="Toggle Status">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                            <button wire:click="edit('{{ $u->id }}')" class="btn-3d-slate p-3 rounded-xl text-white/30" title="Edit Profil">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                        @else
                                            <span class="text-[9px] font-black uppercase text-white/10 tracking-[0.2em] px-4">Akun Anda</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($isModalOpen)
        <div class="fixed inset-0 z-[2000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md" wire:click="closeModal"></div>
            <div class="relative glass-card w-full max-w-lg rounded-[45px] p-10 lg:p-14 border border-white/10 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-14 h-14 rounded-2xl bg-blue-500/20 flex items-center justify-center text-blue-500 border border-blue-500/20 shadow-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h2 class="text-2xl font-black italic uppercase tracking-tighter text-white">Data <span class="text-blue-500">Pengguna</span></h2>
                </div>
                <form wire:submit.prevent="save" class="space-y-7">
                    <div class="text-left">
                        <label class="text-[10px] font-black uppercase tracking-widest text-white/30 ml-5 mb-3 block">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="bg-black/40 border border-white/5 w-full px-7 py-5 rounded-2xl text-white focus:outline-none focus:border-blue-500/30 shadow-inner font-bold" placeholder="Masukkan nama">
                        @error('name') <span class="text-red-500 text-[9px] ml-5 mt-2 block font-black tracking-widest uppercase">{{ $message }}</span> @enderror
                    </div>
                    <div class="text-left">
                        <label class="text-[10px] font-black uppercase tracking-widest text-white/30 ml-5 mb-3 block">NIP (Username)</label>
                        <input type="text" wire:model="nip" class="bg-black/40 border border-white/5 w-full px-7 py-5 rounded-2xl text-white focus:outline-none focus:border-blue-500/30 shadow-inner font-mono font-bold" placeholder="Masukkan NIP">
                        @error('nip') <span class="text-red-500 text-[9px] ml-5 mt-2 block font-black tracking-widest uppercase">{{ $message }}</span> @enderror
                    </div>
                    <div class="text-left">
                        <label class="text-[10px] font-black uppercase tracking-widest text-white/30 ml-5 mb-3 block">Email Aktif</label>
                        <input type="email" wire:model="email" class="bg-black/40 border border-white/5 w-full px-7 py-5 rounded-2xl text-white focus:outline-none focus:border-blue-500/30 shadow-inner font-bold" placeholder="nama@email.com">
                        @error('email') <span class="text-red-500 text-[9px] ml-5 mt-2 block font-black tracking-widest uppercase">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-6 flex flex-col sm:flex-row justify-end gap-4">
                        <button type="button" wire:click="closeModal" class="btn-3d-slate px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest text-white/30 order-2 sm:order-1">Batalkan</button>
                        <button type="submit" wire:loading.attr="disabled" class="btn-3d-blue px-10 py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400 order-1 sm:order-2">
                            <span wire:loading.remove>Simpan Data</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </main>
</div>

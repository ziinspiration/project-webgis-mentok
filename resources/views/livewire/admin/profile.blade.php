<div class="min-h-screen flex overflow-hidden">
    <x-sidebar active="profile" />
    <main class="flex-1 flex flex-col overflow-y-auto bg-slate-950/50">
        <x-header title="Kelola Akun" subtitle="Update Profil & Keamanan" />
        <div class="p-6 lg:p-10">
            <div class="max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div class="glass-card p-10 rounded-[45px] border border-white/5">
                    <h3 class="text-2xl font-black italic uppercase tracking-tighter mb-10 text-white">Data <span class="text-blue-500">Profil</span></h3>
                    <form wire:submit.prevent="updateProfile" class="space-y-7">
                        <div class="text-left">
                            <label class="text-[10px] font-black uppercase tracking-widest text-white/30 ml-5 mb-3 block">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="bg-black/30 border border-white/5 w-full px-7 py-5 rounded-2xl text-white focus:outline-none focus:border-blue-500/30 shadow-inner font-bold">
                        </div>
                        <div class="text-left">
                            <label class="text-[10px] font-black uppercase tracking-widest text-white/30 ml-5 mb-3 block">NIP / Identitas</label>
                            <input type="text" wire:model="nip" class="bg-black/30 border border-white/5 w-full px-7 py-5 rounded-2xl text-white focus:outline-none focus:border-blue-500/30 shadow-inner font-mono font-bold">
                        </div>
                        <div class="text-left">
                            <label class="text-[10px] font-black uppercase tracking-widest text-white/30 ml-5 mb-3 block">Email Aktif</label>
                            <input type="email" wire:model="email" class="bg-black/30 border border-white/5 w-full px-7 py-5 rounded-2xl text-white focus:outline-none focus:border-blue-500/30 shadow-inner font-bold">
                        </div>
                        <div class="bg-blue-500/5 border border-blue-500/10 p-5 rounded-2xl">
                            <p class="text-[9px] text-blue-400 italic font-black uppercase tracking-widest leading-loose">Informasi: Perubahan data email atau NIP akan mewajibkan verifikasi ulang akses.</p>
                        </div>
                        <button type="submit" class="btn-3d-blue w-full py-5 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400">Update Data Profil</button>
                    </form>
                </div>

                <div class="glass-card p-10 rounded-[45px] border border-white/5 flex flex-col">
                    <div class="flex-1">
                        <h3 class="text-2xl font-black italic uppercase tracking-tighter mb-6 text-white">Keamanan <span class="text-orange-500">Akun</span></h3>
                        <p class="text-[13px] text-white/30 leading-relaxed font-medium mb-10">Untuk menjaga integritas data, perubahan kata sandi dilakukan secara aman melalui tautan enkripsi yang dikirimkan ke email terdaftar anda.</p>

                        <div class="space-y-6">
                            <div class="p-8 border border-white/5 rounded-[35px] bg-white/5">
                                <p class="text-[10px] font-black uppercase text-white/20 mb-3 tracking-[0.3em]">Hak Akses Anda</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                    <p class="text-lg font-black text-white uppercase italic tracking-tight">{{ auth()->user()->is_allaccess ? 'Administrator (Penuh)' : 'Operator (Terbatas)' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button wire:click="requestPasswordChange" wire:loading.attr="disabled" class="btn-3d-slate w-full py-6 rounded-2xl text-[10px] font-black uppercase tracking-widest text-orange-500 mt-10">
                        <span wire:loading.remove>Kirim Link Ganti Kata Sandi</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>

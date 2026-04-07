<div class="min-h-screen flex items-center justify-center bg-slate-950 relative overflow-hidden" style="font-family: 'Montserrat', sans-serif;">
    <style>
        .btn-3d-raised {
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; position: relative; outline: none;
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            transform: translateY(-6px);
            transition: all 0.15s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: rgba(255, 255, 255, 0.03);
            border: 1.2px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.6), 0 12px 25px rgba(0, 0, 0, 0.5);
        }
        .btn-3d-raised:hover { transform: translateY(-3px); background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.4); box-shadow: 0 3px 0 rgba(0, 0, 0, 0.6), 0 8px 15px rgba(0, 0, 0, 0.3); }
        .btn-3d-raised:active { transform: translateY(0px); box-shadow: 0 0 0 transparent; }
        .input-3d-inset {
            background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.05); border-top-color: rgba(0, 0, 0, 0.5); border-left-color: rgba(0, 0, 0, 0.4);
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.5); transition: all 0.3s ease;
        }
        .input-3d-inset:focus { background: rgba(0, 0, 0, 0.4); border-color: rgba(59, 130, 246, 0.5); box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.7), 0 0 20px rgba(59, 130, 246, 0.1); }
    </style>

    <div class="absolute top-[-15%] left-[-10%] w-[80%] h-[80%] bg-blue-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-[-15%] right-[-10%] w-[80%] h-[80%] bg-purple-600/10 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="relative w-full h-full md:h-auto md:max-w-2xl p-8 md:p-14 lg:p-20 flex flex-col justify-center border-white/5 bg-white/[0.02] backdrop-blur-3xl shadow-2xl overflow-hidden md:border md:rounded-[60px]">

        <div class="text-center mb-10 md:mb-14 relative z-10">
            <h2 class="text-2xl md:text-3xl font-black italic tracking-tighter text-white uppercase w-fit px-6 border-x border-white/10 mb-4 mx-auto">
                ATUR <span class="text-blue-500">ULANG SANDI</span>
            </h2>
            <p class="text-[10px] md:text-[11px] font-bold text-white/30 uppercase tracking-[0.3em]">KONFIGURASI SANDI BARU</p>
        </div>

        <form wire:submit="submit" class="relative z-10 space-y-7 w-full max-w-lg mx-auto">
            <div class="space-y-6">
                <div class="group">
                    <label class="block text-[11px] font-black uppercase tracking-[0.25em] text-white/20 mb-3 ml-5">Kata Sandi Baru</label>
                    <div class="relative" x-data="{ show: false }">
                        <input :type="show ? 'text' : 'password'" wire:model="password" required
                            class="input-3d-inset w-full rounded-2xl px-8 py-5 text-white placeholder-white/5 focus:outline-none text-base"
                            placeholder="Minimal 8 karakter">
                        <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-white/10 hover:text-blue-400">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 ml-5 block tracking-widest">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-[0.25em] text-white/20 mb-3 ml-5">Konfirmasi Sandi</label>
                    <input type="password" wire:model="password_confirmation" required
                        class="input-3d-inset w-full rounded-2xl px-8 py-5 text-white placeholder-white/5 focus:outline-none text-base"
                        placeholder="Ulangi sandi baru">
                </div>
            </div>

            <div class="flex justify-center pt-6">
                <button type="submit" wire:loading.attr="disabled"
                    class="btn-3d-raised w-full h-[65px] rounded-2xl group">
                    <span wire:loading.remove wire:target="submit" class="text-white/40 font-black tracking-[0.2em] group-hover:text-white transition-colors uppercase">Perbarui</span>
                    <span wire:loading wire:target="submit" class="text-white/30 font-black tracking-[0.1em] uppercase text-xs italic">Memproses...</span>
                </button>
            </div>
        </form>

        <div class="mt-16 md:mt-24 text-center relative z-10 space-y-2">
            <p class="text-[10px] md:text-[11px] font-black text-white/10 uppercase tracking-[0.5em] italic">&copy; KECAMATAN MENTOK {{ date('Y') }}</p>
            <p class="text-[9px] md:text-[10px] font-black text-blue-500/20 uppercase tracking-[0.3em] italic">DIBUAT OLEH WZ STUDIO</p>
        </div>
    </div>
</div>

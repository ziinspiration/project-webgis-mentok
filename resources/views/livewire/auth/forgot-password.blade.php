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

        <div class="text-center mb-12 md:mb-16 relative z-10">
            <h2 class="text-2xl md:text-3xl font-black italic tracking-tighter text-white uppercase w-fit px-6 border-x border-white/10 mb-4 mx-auto">
                LUPA <span class="text-blue-500">KATA SANDI</span>
            </h2>
            <p class="text-[10px] md:text-[11px] font-bold text-white/30 uppercase tracking-[0.3em]">PEMULIHAN AKSES SISTEM</p>
        </div>

        @if (session('status'))
            <div class="mb-8 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-widest text-center italic">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="submit" class="relative z-10 space-y-8 w-full max-w-lg mx-auto">
            <div>
                <label class="block text-[11px] font-black uppercase tracking-[0.25em] text-white/20 mb-3 ml-5">Email Terdaftar</label>
                <div class="relative">
                    <input type="email" wire:model="email" required
                        class="input-3d-inset w-full rounded-2xl px-8 py-5 text-white placeholder-white/5 focus:outline-none text-base"
                        placeholder="nama@email.com">
                </div>
                @error('email') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 ml-5 block tracking-widest">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col items-center gap-8 pt-4">
                <button type="submit" wire:loading.attr="disabled"
                    class="btn-3d-raised w-full h-[65px] rounded-2xl group">
                    <span wire:loading.remove wire:target="submit" class="text-white/40 font-black tracking-[0.2em] group-hover:text-white transition-colors uppercase">Kirim Link</span>
                    <span wire:loading wire:target="submit" class="text-white/30 font-black tracking-[0.1em] uppercase text-xs italic">Memproses...</span>
                </button>

                <a href="{{ route('login') }}" wire:navigate class="text-[10px] font-black text-white/20 hover:text-blue-400 transition-all uppercase tracking-[0.2em] italic flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
                    Kembali ke halaman login
                </a>
            </div>
        </form>

        <div class="mt-16 md:mt-24 text-center relative z-10 space-y-2">
            <p class="text-[10px] md:text-[11px] font-black text-white/10 uppercase tracking-[0.5em] italic">&copy; KECAMATAN MENTOK {{ date('Y') }}</p>
            <p class="text-[9px] md:text-[10px] font-black text-blue-500/20 uppercase tracking-[0.3em] italic">DIBUAT OLEH WZ STUDIO</p>
        </div>
    </div>
</div>

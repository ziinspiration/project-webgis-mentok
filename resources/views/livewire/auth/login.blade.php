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
        .btn-3d-raised:hover {
            transform: translateY(-3px);
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 3px 0 rgba(0, 0, 0, 0.6), 0 8px 15px rgba(0, 0, 0, 0.3);
        }
        .btn-3d-raised:active { transform: translateY(0px); box-shadow: 0 0 0 transparent; }
        .btn-3d-raised:disabled { opacity: 0.5; cursor: not-allowed; transform: translateY(0); }

        .input-3d-inset {
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-top-color: rgba(0, 0, 0, 0.5);
            border-left-color: rgba(0, 0, 0, 0.4);
            box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease;
        }
        .input-3d-inset:focus {
            background: rgba(0, 0, 0, 0.4);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.7), 0 0 20px rgba(59, 130, 246, 0.1);
        }
        .alert-3d-glass {
            background: rgba(239, 68, 68, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(239, 68, 68, 0.3);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            border-radius: 20px;
        }
    </style>

    <div x-data="{ show: false, message: '' }"
         x-on:login-failed.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 5000)"
         class="fixed top-6 right-0 left-0 md:left-auto md:right-6 z-[2000] flex justify-center md:block px-4 pointer-events-none">
        <div x-show="show" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 md:translate-x-8"
             x-transition:enter-end="opacity-100 scale-100 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             class="relative p-5 alert-3d-glass pointer-events-auto w-full max-w-[350px]">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center border border-red-500/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div>
                    <h4 class="text-[11px] font-black uppercase tracking-widest text-red-400/60 mb-0.5">Kesalahan Akses</h4>
                    <p class="text-[13px] font-bold text-white leading-tight" x-text="message"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute top-[-15%] left-[-10%] w-[80%] h-[80%] bg-blue-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-[-15%] right-[-10%] w-[80%] h-[80%] bg-purple-600/10 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="relative w-full h-full md:h-auto md:max-w-4xl p-6 md:p-14 lg:p-20 flex flex-col justify-center border-white/5 bg-white/[0.02] backdrop-blur-3xl shadow-2xl overflow-hidden md:border md:rounded-[60px]">

        <div class="text-center mb-12 md:mb-16 relative z-10">
            <div class="inline-block py-2 px-6 border-x border-white/10 mb-4">
                <h2 class="text-2xl sm:text-3xl md:text-5xl font-black italic tracking-tighter text-white uppercase leading-none">
                    WEBGIS <span class="text-blue-500">MENTOK</span>
                </h2>
            </div>
            <p class="text-[10px] md:text-[12px] font-bold text-white/30 uppercase tracking-[0.4em] italic">Sistem Informasi Geografis Kecamatan</p>
        </div>

        @if (session('status'))
            <div class="mb-8 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-black uppercase tracking-widest text-center italic">
                {{ session('status') }}
            </div>
        @endif

        <form wire:submit="login" class="relative z-10 space-y-8 md:space-y-10 w-full max-w-xl mx-auto">
            <div class="space-y-6 md:space-y-8">
                <div class="group">
                    <label class="block text-[11px] md:text-[12px] font-black uppercase tracking-[0.3em] text-white/20 mb-3 ml-5 group-focus-within:text-blue-500/50 transition-colors">Nomor Induk Pegawai</label>
                    <div class="relative">
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-white/10 group-focus-within:text-blue-500/40 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <input type="text" wire:model="nip" required
                            class="input-3d-inset w-full rounded-2xl pl-16 pr-6 py-4 md:py-6 text-white placeholder-white/5 focus:outline-none text-base md:text-lg"
                            placeholder="Masukkan NIP">
                    </div>
                    @error('nip') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 ml-5 block tracking-widest">{{ $message }}</span> @enderror
                </div>

                <div class="group">
                    <label class="block text-[11px] md:text-[12px] font-black uppercase tracking-[0.3em] text-white/20 mb-3 ml-5 group-focus-within:text-blue-400/50 transition-colors">Kata Sandi</label>
                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-white/10 group-focus-within:text-blue-500/40 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" wire:model="password" required
                            class="input-3d-inset w-full rounded-2xl pl-16 pr-14 py-4 md:py-6 text-white placeholder-white/5 focus:outline-none text-base md:text-lg"
                            placeholder="Masukkan Kata Sandi">
                        <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-white/10 hover:text-blue-400 transition-colors">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-[10px] font-bold uppercase mt-2 ml-5 block tracking-widest">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex flex-col items-center gap-8 pt-4">
                <button type="submit" wire:loading.attr="disabled"
                    class="btn-3d-raised w-full md:w-2/3 h-[60px] md:h-[70px] rounded-2xl group">
                    <span wire:loading.remove wire:target="login" class="flex items-center gap-3">
                        <span class="text-white/40 font-black tracking-[0.3em] group-hover:text-white transition-colors uppercase">Masuk</span>
                    </span>
                    <span wire:loading wire:target="login" class="flex items-center gap-3">
                        <span class="text-white/40 font-black tracking-[0.2em] uppercase text-xs">Memvalidasi...</span>
                    </span>
                </button>

                <a href="{{ route('forgot-password') }}" wire:navigate class="text-[10px] font-black text-white/20 hover:text-blue-400 transition-all uppercase tracking-[0.2em] italic">Lupa akses kata sandi anda?</a>
            </div>
        </form>

        <div class="mt-16 md:mt-24 text-center relative z-10 space-y-2">
            <p class="text-[10px] md:text-[11px] font-black text-white/10 uppercase tracking-[0.5em] italic">&copy; KECAMATAN MENTOK {{ date('Y') }}</p>
            <p class="text-[9px] md:text-[10px] font-black text-blue-500/20 uppercase tracking-[0.3em] italic">DIBUAT OLEH WZ STUDIO</p>
        </div>
    </div>
</div>

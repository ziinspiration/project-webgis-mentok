<div class="min-h-screen flex items-center justify-center bg-slate-950 relative overflow-hidden" style="font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'SF Pro Text', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <style>
        .btn-3d-raised {
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; position: relative; outline: none;
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            transform: translateY(-6px);
            transition: transform 0.15s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.15s ease;
            background: rgba(0, 0, 0, 0.3);
            border: 1.2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.5), 0 12px 25px rgba(0, 0, 0, 0.4);
        }
        .btn-3d-raised:hover { transform: translateY(-3px); box-shadow: 0 3px 0 rgba(0, 0, 0, 0.5), 0 8px 15px rgba(0, 0, 0, 0.3); }
        .btn-3d-raised:active { transform: translateY(0px); box-shadow: 0 0 0 transparent; }
        .btn-3d-raised:disabled { opacity: 0.5; cursor: not-allowed; transform: translateY(0); }

        .input-3d-inset {
            background: rgba(0, 0, 0, 0.2);
            border-top: 1px solid rgba(0, 0, 0, 0.4);
            border-left: 1px solid rgba(0, 0, 0, 0.3);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        .input-3d-inset:focus {
            background: rgba(0, 0, 0, 0.3);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.6), 0 0 15px rgba(59, 130, 246, 0.1);
        }
        .alert-3d-glass {
            background: rgba(239, 68, 68, 0.25);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border-radius: 16px;
        }
    </style>

    <div x-data="{ show: false, message: '' }"
         x-on:login-failed.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 5000)"
         class="fixed top-6 right-6 z-[2000] w-full max-w-[320px] pointer-events-none px-4">
        <div x-show="show" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             class="relative p-4 alert-3d-glass pointer-events-auto">
            <div class="flex items-center gap-3 text-left">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-500/30 flex items-center justify-center border border-red-500/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <div class="flex-1 text-left">
                    <p class="text-[13px] font-bold text-white leading-tight" x-text="message"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute top-[-10%] left-[-10%] w-[70%] h-[70%] bg-blue-600/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[70%] h-[70%] bg-purple-600/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="relative w-full h-screen md:h-auto md:max-w-4xl p-6 md:p-14 lg:p-16 flex flex-col justify-center border-white/5 bg-white/5 backdrop-blur-3xl shadow-2xl overflow-hidden md:border md:rounded-[50px]">

        <div class="text-center mb-12 md:mb-16 relative z-10 flex justify-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black italic tracking-tighter text-white uppercase w-fit px-6 border-x border-white/10">
                WEBGIS KECAMATAN <span class="text-blue-500 ml-2">MENTOK</span>
            </h2>
        </div>

        <form wire:submit="login" class="relative z-10 space-y-7 md:space-y-9 w-full max-w-xl mx-auto px-4">
            <div class="flex flex-col space-y-7">
                <div>
                    <label class="block text-[11px] md:text-[12px] font-black uppercase tracking-[0.25em] text-white/30 mb-3 ml-4">Nomor Induk Pegawai</label>
                    <input type="text" wire:model="nip" required
                        class="input-3d-inset w-full rounded-xl md:rounded-2xl px-6 py-4 md:py-5 text-white placeholder-white/10 focus:outline-none text-base md:text-lg"
                        placeholder="Masukkan NIP anda">
                    @error('nip') <span class="text-red-500 text-xs mt-1 ml-4">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-[11px] md:text-[12px] font-black uppercase tracking-[0.25em] text-white/30 mb-3 ml-4">Kata Sandi</label>
                    <div class="relative group">
                        <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model="password" required
                            class="input-3d-inset w-full rounded-xl md:rounded-2xl px-6 py-4 md:py-5 text-white placeholder-white/10 focus:outline-none text-base md:text-lg"
                            placeholder="Masukkan kata sandi anda">
                        <button type="button" wire:click="togglePassword" class="absolute right-5 top-1/2 -translate-y-1/2 text-white/20 hover:text-blue-400 transition-all duration-300">
                            @if($showPassword)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                            @endif
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1 ml-4">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-center pt-5">
                <button type="submit" wire:loading.attr="disabled"
                    class="btn-3d-raised w-full sm:w-2/3 md:w-1/2 h-[58px] md:h-[64px] rounded-xl md:rounded-2xl group">

                    <span wire:loading.remove wire:target="login" class="flex items-center">
                        <span class="opacity-30 text-white md:text-lg group-hover:opacity-100 transition-opacity">MASUK</span>
                    </span>

                    <span wire:loading wire:target="login" class="flex items-center">
                        <span class="ml-3 text-white opacity-50 uppercase tracking-widest text-xs">Memproses...</span>
                    </span>
                </button>
            </div>
        </form>

        <div class="mt-16 md:mt-24 text-center relative z-10 space-y-1">
            <p class="text-[10px] md:text-[11px] font-black text-white/20 uppercase tracking-[0.4em] italic">&copy; KECAMATAN MENTOK {{ date('Y') }}</p>
            <p class="text-[9px] md:text-[10px] font-black text-blue-500/30 uppercase tracking-[0.3em] italic">DIBUAT OLEH WZ STUDIO</p>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>DASHBOARD | {{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .glass-card { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(25px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .blob { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.15; z-index: 0; pointer-events: none; }
        .notification-glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.5); }

        .btn-3d-blue {
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; position: relative; outline: none;
    transform: translateY(-4px);
    transition: all 0.1s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    background: rgba(59, 130, 246, 0.2);
    border: 1.2px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 0 rgba(0, 0, 0, 0.4);
}
.btn-3d-blue:hover { transform: translateY(-2px); box-shadow: 0 2px 0 rgba(0, 0, 0, 0.4); background: rgba(59, 130, 246, 0.3); }
.btn-3d-blue:active { transform: translateY(0px); box-shadow: none; }

.btn-3d-red {
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; position: relative; outline: none;
    transform: translateY(-4px);
    transition: all 0.1s;
    background: rgba(239, 68, 68, 0.2);
    border: 1.2px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 0 rgba(0, 0, 0, 0.4);
}
.btn-3d-red:hover { transform: translateY(-2px); box-shadow: 0 2px 0 rgba(0, 0, 0, 0.4); background: rgba(239, 68, 68, 0.3); }
.btn-3d-red:active { transform: translateY(0px); box-shadow: none; }

.btn-3d-slate {
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; position: relative; outline: none;
    transform: translateY(-4px);
    transition: all 0.1s;
    background: rgba(255, 255, 255, 0.05);
    border: 1.2px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 0 rgba(0, 0, 0, 0.4);
}
.btn-3d-slate:hover { transform: translateY(-2px); box-shadow: 0 2px 0 rgba(0, 0, 0, 0.4); background: rgba(255, 255, 255, 0.1); }
.btn-3d-slate:active { transform: translateY(0px); box-shadow: none; }

.custom-scrollbar::-webkit-scrollbar {
    height: 8px; /* Tinggi bar geser horizontal */
    width: 6px;  /* Lebar bar geser vertikal */
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.02);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(59, 130, 246, 0.3); /* Warna biru transparan */
    border-radius: 10px;
    border: 2px solid transparent;
    background-clip: content-box;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(59, 130, 246, 0.5); /* Biru lebih terang saat hover */
}
    </style>
</head>
<body class="bg-slate-950 antialiased overflow-hidden text-left"
    x-data="{
        sidebarOpen: localStorage.getItem('sidebarState') === null ? true : localStorage.getItem('sidebarState') === 'true',
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebarState', this.sidebarOpen);
        },
        showNotify: false, notifyMsg: '', notifyType: 'success'
    }"
    x-on:notify.window="showNotify = true; notifyMsg = $event.detail.message; notifyType = $event.detail.type || 'success'; setTimeout(() => showNotify = false, 4000)">

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob w-[600px] h-[600px] bg-blue-600 -top-20 -left-20"></div>
        <div class="blob w-[600px] h-[600px] bg-purple-600 -bottom-20 -right-20"></div>
    </div>

    {{ $slot }}

    <div class="fixed top-6 right-6 z-[3000] w-full max-w-[350px] pointer-events-none px-4">
        <div x-show="showNotify" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-12"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             class="notification-glass p-5 rounded-[24px] pointer-events-auto border-l-4"
             :class="notifyType === 'success' ? 'border-emerald-500' : 'border-red-500'">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center border"
                     :class="notifyType === 'success' ? 'bg-emerald-500/20 border-emerald-500/40 text-emerald-500' : 'bg-red-500/20 border-red-500/40 text-red-500'">
                    <template x-if="notifyType === 'success'">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                    </template>
                    <template x-if="notifyType === 'error'">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </template>
                </div>
                <div class="text-left">
                    <p class="text-[10px] font-black uppercase tracking-widest text-white/40 mb-0.5" x-text="notifyType === 'success' ? 'Berhasil' : 'Pemberitahuan'"></p>
                    <p class="text-xs font-bold text-white leading-tight" x-text="notifyMsg"></p>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>

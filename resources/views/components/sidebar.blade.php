@props(['active' => 'dashboard'])
<aside
    :class="sidebarOpen ? 'w-72 translate-x-0' : 'w-24 translate-x-0'"
    class="fixed lg:relative z-[1010] glass-card transition-all duration-500 flex flex-col h-screen border-r border-white/5 shadow-2xl overflow-hidden shrink-0">

    <div class="p-8 flex items-center" :class="sidebarOpen ? 'justify-between' : 'justify-center'">
        <div x-show="sidebarOpen" x-transition.opacity class="font-black italic tracking-tighter text-blue-500 text-xl uppercase whitespace-nowrap">
            WEBGIS <span class="text-white">MENTOK</span>
        </div>
        <button @click="toggleSidebar()" class="text-white/20 hover:text-blue-500 transition-colors outline-none scale-110">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 mt-4 space-y-3 px-4 overflow-y-auto custom-scrollbar">
        <x-sidebar-item route="dashboard" :active="$active" icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" label="Beranda Utama" />

        <x-sidebar-item route="categories" :active="$active" icon="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" label="Kelola Kategori" />

        <x-sidebar-item route="map-data" :active="$active" icon="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" label="Kelola Data Spasial" />

        @if(auth()->user()->is_allaccess)
            <x-sidebar-item route="users" :active="$active" icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" label="Kelola Pengguna" />
        @endif
    </nav>

    <div class="p-4 border-t border-white/5 space-y-2 mb-4">
        <x-sidebar-item route="profile" :active="$active" icon="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" label="Profil Saya" />

        <button wire:click="logout" class="w-full flex items-center p-4 rounded-xl transition-all text-red-500/40 hover:text-red-500 hover:bg-red-500/5 group">
            <svg class="h-6 w-6 shrink-0 transition-transform group-hover:rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span x-show="sidebarOpen" x-transition.opacity class="ml-4 font-black tracking-widest uppercase text-[10px]">Keluar Sistem</span>
        </button>
    </div>
</aside>

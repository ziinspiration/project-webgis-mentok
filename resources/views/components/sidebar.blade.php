@props(['active' => 'dashboard'])
<div x-show="sidebarOpen" @click="toggleSidebar()" x-cloak class="fixed inset-0 bg-black/60 backdrop-blur-md z-[1008] lg:hidden" x-transition:enter="transition opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
<aside :class="sidebarOpen ? 'translate-x-0 w-72' : '-translate-x-full lg:translate-x-0 lg:w-20'" class="fixed lg:relative z-[1010] glass-card transition-all duration-500 flex flex-col h-screen border-r border-white/5 shadow-2xl overflow-hidden text-left text-left">
    <div class="p-6 flex items-center justify-between">
        <div x-show="sidebarOpen" x-transition.opacity class="font-black italic tracking-tighter text-blue-500 text-xl uppercase whitespace-nowrap">WEBGIS <span class="text-white">MENTOK</span></div>
        <button @click="toggleSidebar()" class="text-white/50 hover:text-white outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
        </button>
    </div>
    <nav class="flex-1 mt-4 space-y-2 px-3">
        <a href="{{ route('dashboard') }}" wire:navigate class="{{ $active == 'dashboard' ? 'bg-blue-500/10 border-r-4 border-blue-500 text-blue-500' : 'text-white/40 hover:text-blue-400 hover:bg-white/5' }} flex items-center p-3 rounded-xl transition-all group">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            <span x-show="sidebarOpen" x-cloak class="ml-4 font-bold tracking-wide uppercase text-xs">Beranda</span>
        </a>
        <a href="{{ route('categories') }}" wire:navigate class="{{ $active == 'categories' ? 'bg-blue-500/10 border-r-4 border-blue-500 text-blue-500' : 'text-white/40 hover:text-blue-400 hover:bg-white/5' }} flex items-center p-3 rounded-xl transition-all group">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            <span x-show="sidebarOpen" x-cloak class="ml-4 font-bold tracking-wide uppercase text-xs whitespace-nowrap">Kelola Kategori</span>
        </a>
        <a href="{{ route('map-data') }}" wire:navigate class="{{ $active == 'map-data' ? 'bg-blue-500/10 border-r-4 border-blue-500 text-blue-500' : 'text-white/40 hover:text-blue-400 hover:bg-white/5' }} flex items-center p-3 rounded-xl transition-all group">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
            <span x-show="sidebarOpen" x-cloak class="ml-4 font-bold tracking-wide uppercase text-xs whitespace-nowrap">Data Spasial</span>
        </a>
        <a href="{{ route('users') }}" wire:navigate class="{{ $active == 'users' ? 'bg-blue-500/10 border-r-4 border-blue-500 text-blue-500' : 'text-white/40 hover:text-blue-400 hover:bg-white/5' }} flex items-center p-3 rounded-xl transition-all group">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            <span x-show="sidebarOpen" x-cloak class="ml-4 font-bold tracking-wide uppercase text-xs whitespace-nowrap">Kelola Pengguna</span>
        </a>
    </nav>
    <div class="p-4 border-t border-white/5 text-left">
        <div class="flex items-center space-x-3" x-show="sidebarOpen" x-cloak>
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center font-bold text-white shrink-0 uppercase">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="flex-1 overflow-hidden text-left">
                <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-white/30 uppercase tracking-widest truncate">{{ auth()->user()->nip }}</p>
            </div>
            <button wire:click="logout" class="text-red-500/50 hover:text-red-500 transition-colors shrink-0"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg></button>
        </div>
        <button x-show="!sidebarOpen" wire:click="logout" class="w-full flex justify-center text-red-500/50 hover:text-red-500 py-2"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg></button>
    </div>
</aside>

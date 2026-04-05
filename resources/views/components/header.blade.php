@props(['title' => 'Beranda', 'subtitle' => 'GIS'])
<header class="h-20 sm:h-24 flex items-center justify-between px-4 sm:px-8 border-b border-white/5 backdrop-blur-md sticky top-0 z-30 w-full">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="lg:hidden text-white/50 hover:text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button>
        <div class="text-left">
            <h1 class="text-lg sm:text-2xl font-black italic text-white uppercase tracking-tighter">@php $words = explode(' ', $title); @endphp {{ $words[0] }} <span class="text-blue-500">{{ implode(' ', array_slice($words, 1)) }}</span></h1>
            <p class="text-[8px] sm:text-[10px] text-white/30 uppercase tracking-[0.3em] font-bold truncate max-w-[200px] sm:max-w-none">{{ $subtitle }}</p>
        </div>
    </div>
    <div class="text-right hidden sm:block">
        <p class="text-[10px] font-bold text-white/50 uppercase tracking-widest">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        <p id="clock" class="text-xs font-black text-blue-500 italic uppercase"></p>
    </div>
</header>
<script>
    function updateClock() {
        const now = new Date();
        const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0') + ':' + now.getSeconds().toString().padStart(2, '0');
        const el = document.getElementById('clock'); if(el) el.textContent = time + ' WIB';
    }
    setInterval(updateClock, 1000); updateClock();
</script>

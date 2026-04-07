@props(['title' => 'Beranda', 'subtitle' => 'GIS'])

<header class="h-20 sm:h-24 w-full flex-shrink-0 sticky top-0 z-[100] backdrop-blur-md bg-white/[0.01] border-b border-white/5 flex items-center justify-between px-4 sm:px-8">
    <div class="flex items-center gap-4 overflow-hidden">
        <button @click="toggleSidebar()" class="lg:hidden text-white/50 hover:text-white shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="text-left overflow-hidden">
            @php
                $words = explode(' ', $title);
                $first = $words[0] ?? '';
                $rest = implode(' ', array_slice($words, 1));
            @endphp
            <h1 class="text-lg sm:text-2xl font-black italic text-white uppercase tracking-tighter truncate leading-none">
                {{ $first }} <span class="text-blue-500">{{ $rest }}</span>
            </h1>
            <p class="text-[8px] sm:text-[10px] text-white/30 uppercase tracking-[0.3em] font-bold truncate mt-1">
                {{ $subtitle }}
            </p>
        </div>
    </div>

    <div class="text-right hidden sm:flex flex-col shrink-0">
        <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest mb-0.5">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </p>
        <p id="header-clock" class="text-xs font-black text-blue-500 italic uppercase tracking-wider"></p>
    </div>
</header>

<script>
    if (typeof initHeaderClock === 'undefined') {
        function initHeaderClock() {
            const now = new Date();
            const time = now.getHours().toString().padStart(2, '0') + ':' +
                         now.getMinutes().toString().padStart(2, '0') + ':' +
                         now.getSeconds().toString().padStart(2, '0');
            const el = document.getElementById('header-clock');
            if (el) el.textContent = time + ' WIB';
        }
        setInterval(initHeaderClock, 1000);
        initHeaderClock();
    }
</script>

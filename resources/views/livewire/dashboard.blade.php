<div class="min-h-screen text-slate-200 flex overflow-hidden relative z-10">
    <x-sidebar active="dashboard" />
    <main class="flex-1 flex flex-col overflow-y-auto w-full">
        <x-header title="Ringkasan Utama" subtitle="Sistem Informasi Geografis Kecamatan Mentok" />
        <div class="p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($stats as $stat)
                <div class="glass-card p-5 sm:p-6 rounded-[24px] sm:rounded-[30px] hover:scale-[1.02] transition-transform duration-300 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-{{ $stat['color'] }}-600/10 rounded-full blur-2xl transition-all"></div>
                    <div class="flex items-center justify-between relative z-10 text-left">
                        <div>
                            <p class="text-[9px] font-black text-white/30 uppercase tracking-widest mb-1">{{ $stat['label'] }}</p>
                            <h3 class="text-xl sm:text-2xl font-black text-white italic tracking-tighter">{{ number_format($stat['value'], 0, ',', '.') }}</h3>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/5 flex items-center justify-center border border-white/10 text-{{ $stat['color'] }}-500">
                            @if($stat['icon'] == 'polygon') <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 18h16M4 6l4-4h8l4 4M4 18l4 4h8l4-4" /></svg>
                            @elseif($stat['icon'] == 'line') <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                            @elseif($stat['icon'] == 'point') <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            @else <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg> @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 pb-10">
                <div class="lg:col-span-2 glass-card rounded-[30px] sm:rounded-[40px] p-5 sm:p-8 h-[400px] sm:h-[500px] lg:h-[650px] flex flex-col border border-blue-500/10 text-left">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6 gap-4">
                        <h2 class="text-lg font-black text-white italic uppercase tracking-tighter">Visualisasi <span class="text-blue-500">Geospasial</span></h2>
                        <a href="{{ route('home') }}" wire:navigate class="w-full sm:w-fit bg-blue-500/10 border border-blue-500/20 px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest text-blue-400 hover:bg-blue-500 hover:text-white transition-all text-center">Eksplorasi Peta</a>
                    </div>
                    <div class="flex-1 w-full rounded-[20px] sm:rounded-[32px] border border-white/5 overflow-hidden z-0 mb-2 shadow-2xl relative">
                        <div id="map-preview" class="w-full h-full"></div>
                        <div class="absolute bottom-4 left-4 z-[500] bg-slate-950/50 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/10 hidden sm:block"><p class="text-[8px] font-bold text-white/50 uppercase tracking-widest italic">Basemap: Satellite Imagery</p></div>
                    </div>
                </div>
                <div class="glass-card rounded-[30px] sm:rounded-[40px] p-5 sm:p-8 h-[450px] lg:h-[650px] flex flex-col border border-purple-500/10 text-left">
                    <h2 class="text-lg font-black text-white italic uppercase tracking-tighter mb-6">Log <span class="text-purple-500">Aktivitas</span></h2>
                    <div wire:poll.10s class="flex-1 space-y-5 sm:space-y-6 overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($recentActivities as $log)
                        <div class="flex items-start space-x-3 sm:space-x-4 text-left group transition-all duration-300">
                            <div class="w-1 h-10 sm:h-12 shrink-0 rounded-full {{ $log->action == 'Menghapus' ? 'bg-red-500 shadow-[0_0_12px_rgba(239,68,68,0.4)]' : ($log->action == 'Menambah' ? 'bg-emerald-500 shadow-[0_0_12px_rgba(16,185,129,0.4)]' : 'bg-blue-500 shadow-[0_0_12px_rgba(59,130,246,0.4)]') }}"></div>
                            <div class="text-left flex-1 min-w-0">
                                <p class="text-[10px] sm:text-[12px] font-bold text-white uppercase tracking-tight leading-snug truncate">{{ $log->user_name }}</p>
                                <p class="text-[9px] sm:text-[10px] text-white/40 leading-tight">{{ strtolower($log->action) }} <span class="text-white/80 italic font-bold">"{{ $log->subject }}"</span></p>
                                <div class="flex items-center gap-2 mt-1.5"><span class="text-[7px] px-1.5 py-0.5 rounded bg-white/5 text-white/40 border border-white/5 uppercase font-black">{{ $log->type }}</span><span class="text-[8px] text-white/20 italic">{{ $log->created_at->diffForHumans() }}</span></div>
                            </div>
                        </div>
                        @empty
                        <div class="h-full flex flex-col items-center justify-center opacity-10 text-center"><svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg><p class="text-[10px] font-black uppercase tracking-widest">Kosong</p></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
    @script
    <script>
        let mapPreview;
        function initMapPreview() {
            const container = document.getElementById('map-preview');
            if (container) {
                if (mapPreview) { mapPreview.remove(); }
                mapPreview = L.map('map-preview', { zoomControl: false, attributionControl: false, scrollWheelZoom: false }).setView([-2.014258, 105.180382], 13);
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}').addTo(mapPreview);
                setTimeout(() => { mapPreview.invalidateSize(); }, 400);
            }
        }
        initMapPreview(); document.addEventListener('livewire:navigated', initMapPreview);
    </script>
    @endscript
</div>

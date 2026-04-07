<div class="h-screen flex overflow-hidden text-left bg-slate-950">
    <x-sidebar active="dashboard" />
    <main class="flex-1 flex flex-col overflow-y-auto bg-slate-950/50 custom-scrollbar">
        <x-header title="Dashboard Utama" subtitle="Sistem Informasi Geografis Kecamatan Mentok" />

        <div class="p-6 lg:p-10 space-y-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($stats as $stat)
                <div class="glass-card p-7 rounded-[35px] hover:scale-[1.03] transition-all duration-500 group relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-{{ $stat['color'] }}-500/10 rounded-full blur-2xl group-hover:bg-{{ $stat['color'] }}-500/20 transition-all"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div class="text-left">
                            <p class="text-[10px] font-black text-white/20 uppercase tracking-[0.2em] mb-2">{{ $stat['label'] }}</p>
                            <h3 class="text-3xl font-black text-white italic tracking-tighter">{{ number_format($stat['value'], 0, ',', '.') }}</h3>
                        </div>
                        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-{{ $stat['color'] }}-500 shadow-2xl">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($stat['icon'] == 'polygon') <path stroke-width="2" d="M4 6h16M4 18h16M4 6l4-4h8l4 4M4 18l4 4h8l4-4" />
                                @elseif($stat['icon'] == 'line') <path stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                @elseif($stat['icon'] == 'point') <path stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                @else <path stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197" /> @endif
                            </svg>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10 text-left">
                <div class="lg:col-span-2 glass-card rounded-[45px] p-8 h-[650px] flex flex-col border border-white/5" wire:ignore>
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-xl font-black text-white italic uppercase tracking-tighter">Simulasi <span class="text-blue-500">Peta Spasial</span></h2>
                        <a href="{{ route('home') }}" wire:navigate class="btn-3d-blue px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-blue-400">Peta Fullscreen</a>
                    </div>
                    <div class="flex-1 rounded-[30px] border border-white/10 overflow-hidden shadow-2xl relative bg-slate-900">
                        <div id="map-preview" class="w-full h-full z-0"></div>
                    </div>
                </div>

                <div class="glass-card rounded-[45px] p-8 h-[650px] flex flex-col border border-white/5 text-left">
                    <h2 class="text-xl font-black text-white italic uppercase tracking-tighter mb-8">Log <span class="text-purple-500">Aktivitas</span></h2>
                    <div wire:poll.10s class="flex-1 space-y-6 overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($recentActivities as $log)
                        <div class="flex items-start gap-4 group">
                            <div class="w-1.5 h-12 rounded-full shrink-0 {{ $log->action == 'Menghapus' ? 'bg-red-500' : ($log->action == 'Menambah' ? 'bg-emerald-500' : 'bg-blue-500') }}"></div>
                            <div class="flex-1 min-w-0 text-left">
                                <p class="text-[13px] font-black text-white uppercase tracking-tight mb-1 truncate">{{ $log->user_name }}</p>
                                <p class="text-[11px] text-white/40 leading-snug">{{ strtolower($log->action) }} <span class="text-white italic font-bold">"{{ $log->subject }}"</span></p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-[8px] px-2 py-0.5 rounded-lg bg-white/5 text-white/30 border border-white/5 uppercase font-black">{{ $log->type }}</span>
                                    <span class="text-[9px] text-white/20 italic">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="h-full flex flex-col items-center justify-center opacity-10"><p class="text-[11px] font-black uppercase tracking-[0.3em]">Aktivitas Kosong</p></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    @script
    <script>
        let map;
        function initMap() {
            const mapContainer = document.getElementById('map-preview');
            if (!mapContainer) return;
            if (map) { map.remove(); }
            map = L.map('map-preview', { zoomControl: false, attributionControl: false }).setView([-2.014258, 105.180382], 12);
            L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 18 }).addTo(map);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_only_labels/{z}/{y}/{x}.png').addTo(map);
            const mapData = @json($allMapData);
            mapData.forEach(item => {
                const url = `/storage/${item.geojson_path}`;
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        L.geoJSON(data, {
                            style: function(feature) {
                                const color = feature.properties._color || (item.type === 'Polygon' ? '#3b82f6' : '#f59e0b');
                                return { color: color, fillColor: color, weight: 2, fillOpacity: 0.4 };
                            },
                            pointToLayer: function(feature, latlng) {
                                if (item.type === 'Point' && item.icon_path) {
                                    const icon = L.icon({ iconUrl: `/storage/${item.icon_path}`, iconSize: [32, 32], iconAnchor: [16, 16] });
                                    return L.marker(latlng, { icon: icon });
                                }
                                const pointColor = feature.properties._color || '#10b981';
                                return L.circleMarker(latlng, { radius: 7, fillColor: pointColor, color: '#ffffff', weight: 2, fillOpacity: 0.8 });
                            },
                            onEachFeature: function(feature, layer) {
                                let popupContent = `<div class="p-2 font-sans"><p class="text-[10px] font-black uppercase text-blue-500 mb-1">${item.name}</p><p class="text-xs font-bold text-slate-800">${feature.properties.nama || 'Informasi Geografis'}</p></div>`;
                                layer.bindPopup(popupContent);
                            }
                        }).addTo(map);
                    })
                    .catch(e => {});
            });
            setTimeout(() => { map.invalidateSize(); }, 500);
        }
        initMap();
        document.addEventListener('livewire:navigated', initMap);
    </script>
    @endscript

    <style>
        .leaflet-popup-content-wrapper { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 15px; border: 1px solid rgba(255, 255, 255, 0.2); }
        .leaflet-popup-tip { background: rgba(255, 255, 255, 0.95); }
    </style>
</div>

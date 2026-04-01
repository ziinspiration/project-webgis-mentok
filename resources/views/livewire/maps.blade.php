<div class="relative w-screen h-screen overflow-hidden bg-slate-950 text-white" style="font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'SF Pro Text', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <style>
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(40px) saturate(210%) brightness(1.1);
            -webkit-backdrop-filter: blur(40px) saturate(210%) brightness(1.1);
            border-left: 1.5px solid rgba(255, 255, 255, 0.2);
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05), -15px 0 50px rgba(0, 0, 0, 0.4);
        }

        .btn-3d-unified {
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            outline: none;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            transform: translateY(-6px);
            transition: transform 0.15s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.15s ease;
            color: white;
            background: rgba(0, 0, 0, 0.22);
            border: 1.2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.35), 0 12px 25px rgba(0, 0, 0, 0.25);
        }
        .btn-3d-unified:hover {
            transform: translateY(-3px);
            box-shadow: 0 3px 0 rgba(0, 0, 0, 0.35), 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-3d-unified:active {
            transform: translateY(0px);
            box-shadow: 0 0 0 transparent;
        }

        .btn-toggle-size { width: 52px; height: 52px; border-radius: 16px; }
        @media (min-width: 768px) {
            .btn-toggle-size { width: 66px; height: 66px; border-radius: 20px; }
            .btn-toggle-size svg { width: 30px; height: 30px; }
        }

        .zoom-wrap {
            position: absolute;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 18px;
            left: 15px;
            bottom: 25px;
        }
        @media (min-width: 1024px) {
            .zoom-wrap {
                top: 25px;
                bottom: auto;
            }
        }

        .leaflet-control-zoom { display: none !important; }

        .toggle-well { width: 70px; height: 34px; border-radius: 50px; position: relative; cursor: pointer; transition: all 0.3s; backdrop-filter: blur(10px); }
        .toggle-on-sat { background: rgba(34, 197, 94, 0.35); border: 1px solid rgba(34, 197, 94, 0.5); }
        .toggle-off-sat { background: rgba(239, 68, 68, 0.35); border: 1px solid rgba(239, 68, 68, 0.5); }
        .toggle-on-other { background: rgba(34, 197, 94, 0.9); border: 1px solid rgba(255, 255, 255, 0.2); }
        .toggle-off-other { background: rgba(239, 68, 68, 0.9); border: 1px solid rgba(255, 255, 255, 0.2); }
        .toggle-knob { width: 28px; height: 28px; background: white; border-radius: 50%; position: absolute; top: 1.5px; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 2px 4px rgba(0,0,0,0.3); }

        .sidebar-container { position: fixed; top: 0; right: 0; height: 100%; z-index: 1010; width: 100%; transform: translateX(100%); transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        @media (min-width: 768px) { .sidebar-container { width: 520px; } .sidebar-inner { border-radius: 45px 0 0 45px; } }
        .sidebar-active { transform: translateX(0); }
        .overlay-ios { background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }

        .layer-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            background: rgba(0, 0, 0, 0.12);
            border-top: 1px solid rgba(0, 0, 0, 0.25);
            border-left: 1px solid rgba(0, 0, 0, 0.2);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(0, 0, 0, 0.15);
        }
        .layer-card-sat {
            background: rgba(0, 0, 0, 0.08);
            border-top: 1px solid rgba(0, 0, 0, 0.18);
            border-left: 1px solid rgba(0, 0, 0, 0.15);
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.15), inset 0 1px 0 rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="zoom-wrap">
        <button id="btn-zoom-in" class="btn-3d-unified btn-toggle-size">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
        </button>
        <button id="btn-zoom-out" class="btn-3d-unified btn-toggle-size">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16" />
            </svg>
        </button>
    </div>

    <div class="absolute top-8 right-6 md:top-10 md:right-10 z-[1000]">
        <button wire:click="toggleSidebar" class="btn-3d-unified btn-toggle-size">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <div class="sidebar-container {{ $showSidebar ? 'sidebar-active' : '' }}">
        <div class="sidebar-inner glass-sidebar w-full h-full relative flex flex-col overflow-hidden">
            <div class="flex items-center justify-between p-6 md:p-10 border-b border-white/10">
                <h2 class="text-xl font-black uppercase tracking-tight italic {{ $activeLayer == 'satellite' ? 'text-white/40' : 'text-white' }}">Map Settings</h2>
                <button wire:click="toggleSidebar" class="btn-3d-unified btn-toggle-size">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-10 space-y-4">
                <h3 class="font-bold uppercase tracking-widest text-[10px] mb-2 {{ $activeLayer == 'satellite' ? 'text-white/30' : 'text-white/70' }}">Base Layers</h3>
                <div class="grid grid-cols-1 gap-3">
                    @foreach(['satellite', 'terrain', 'base'] as $layer)
                    <div class="layer-card {{ $activeLayer == 'satellite' ? 'layer-card-sat' : '' }}">
                        <span class="text-sm font-bold uppercase tracking-tight {{ $activeLayer == 'satellite' ? 'text-white/40' : 'text-white' }}">{{ $layer }}</span>
                        <div wire:click="setLayer('{{ $layer }}')"
                            class="toggle-well {{ $activeLayer == 'satellite' ? ($activeLayer == $layer ? 'toggle-on-sat' : 'toggle-off-sat') : ($activeLayer == $layer ? 'toggle-on-other' : 'toggle-off-other') }}">
                            <div class="flex justify-between items-center h-full px-2 text-[8px] font-black">
                                <span class="{{ $activeLayer == $layer ? 'opacity-100' : 'opacity-0' }}">ON</span>
                                <span class="{{ $activeLayer != $layer ? 'opacity-100' : 'opacity-0' }}">OFF</span>
                            </div>
                            <div class="toggle-knob {{ $activeLayer == $layer ? 'left-[39px]' : 'left-[3px]' }}">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $activeLayer == $layer ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,1)]' : 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,1)]' }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if($showSidebar)
        <div wire:click="toggleSidebar" class="overlay-ios fixed inset-0 z-[1005]"></div>
    @endif

    <div id="map" class="w-full h-full z-0" wire:ignore></div>

    @script
    <script>
        let map;
        let currentTile;

        const tiles = {
            satellite: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            terrain: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
            base: 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png'
        };

        function switchLayer(layer) {
            if (currentTile) map.removeLayer(currentTile);
            currentTile = L.tileLayer(tiles[layer]).addTo(map);
        }

        function initMap() {
            if (map) { map.remove(); map = null; }
            const initialZoom = window.innerWidth < 768 ? 12 : 13;
            map = L.map('map', { zoomControl: false, attributionControl: false }).setView([-2.014258, 105.180382], initialZoom);
            switchLayer($wire.activeLayer);
            setTimeout(() => { map.invalidateSize(); }, 100);

            document.getElementById('btn-zoom-in').onclick = () => map.zoomIn();
            document.getElementById('btn-zoom-out').onclick = () => map.zoomOut();
        }

        $wire.on('layer-changed', ({ layer }) => { switchLayer(layer); });
        initMap();
        document.addEventListener('livewire:navigated', initMap);
    </script>
    @endscript
</div>

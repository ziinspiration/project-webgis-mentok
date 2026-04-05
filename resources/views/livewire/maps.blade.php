<div class="relative w-screen h-screen overflow-hidden bg-slate-950 text-white" style="font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'SF Pro Text', 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    <style>
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(40px) saturate(210%) brightness(1.1);
            -webkit-backdrop-filter: blur(40px) saturate(210%) brightness(1.1);
            border-left: 1.5px solid rgba(255, 255, 255, 0.2);
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.05), -15px 0 50px rgba(0, 0, 0, 0.4);
        }

        .btn-3d-unified {
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; position: relative; outline: none;
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            transform: translateY(-6px);
            transition: transform 0.15s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.15s ease;
            color: white; background: rgba(0, 0, 0, 0.22);
            border: 1.2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.35), 0 12px 25px rgba(0, 0, 0, 0.25);
        }
        .btn-3d-unified:hover { transform: translateY(-3px); box-shadow: 0 3px 0 rgba(0, 0, 0, 0.35), 0 8px 15px rgba(0, 0, 0, 0.2); }
        .btn-3d-unified:active { transform: translateY(0px); box-shadow: 0 0 0 transparent; }
        .btn-toggle-size { width: 52px; height: 52px; border-radius: 16px; }
        @media (min-width: 768px) { .btn-toggle-size { width: 66px; height: 66px; border-radius: 20px; } .btn-toggle-size svg { width: 30px; height: 30px; } }

        .zoom-wrap { position: absolute; z-index: 1000; display: flex; flex-direction: column; gap: 18px; left: 15px; bottom: 25px; }
        @media (min-width: 1024px) { .zoom-wrap { top: 25px; bottom: auto; } }

        .leaflet-control-zoom { display: none !important; }

        .toggle-well { width: 70px; height: 34px; border-radius: 50px; position: relative; cursor: pointer; transition: all 0.3s; backdrop-filter: blur(10px); }
        .toggle-on-sat { background: rgba(34, 197, 94, 0.35); border: 1px solid rgba(34, 197, 94, 0.5); }
        .toggle-off-sat { background: rgba(239, 68, 68, 0.35); border: 1px solid rgba(239, 68, 68, 0.5); }
        .toggle-on-other { background: rgba(34, 197, 94, 0.9); border: 1px solid rgba(255, 255, 255, 0.2); }
        .toggle-off-other { background: rgba(239, 68, 68, 0.9); border: 1px solid rgba(255, 255, 255, 0.2); }
        .toggle-knob { width: 28px; height: 28px; background: white; border-radius: 50%; position: absolute; top: 1.5px; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); box-shadow: 0 2px 4px rgba(0,0,0,0.3); }

        .sidebar-container { position: fixed; top: 0; right: 0; height: 100%; z-index: 1010; width: 100%; transform: translateX(100%); transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        @media (min-width: 768px) { .sidebar-container { width: 520px; } .sidebar-inner { border-radius: 40px 0 0 40px; } }
        .sidebar-active { transform: translateX(0); }
        .overlay-ios { background: rgba(0, 0, 0, 0.45); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }

        .layer-card {
            display: flex; align-items: center; justify-content: space-between; padding: 16px; border-radius: 16px;
            backdrop-filter: blur(10px); transition: all 0.3s ease; background: rgba(0, 0, 0, 0.12);
            border-top: 1px solid rgba(0, 0, 0, 0.25); border-left: 1px solid rgba(0, 0, 0, 0.2);
            border-right: 1px solid rgba(255, 255, 255, 0.05); border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(0, 0, 0, 0.15);
        }
        .layer-card-sat { background: rgba(0, 0, 0, 0.08); border-color: rgba(255, 255, 255, 0.05); }

        .leaflet-popup-content-wrapper { background: transparent !important; box-shadow: none !important; padding: 0 !important; }
        .leaflet-popup-tip-container { margin-top: -1px; }
        .leaflet-popup-tip { background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(40px) !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; box-shadow: none !important; }

        .leaflet-popup-close-button {
            top: 20px !important;
            right: 20px !important;
            width: 32px !important;
            height: 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: rgba(239, 68, 68, 0.15) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            border-radius: 50% !important;
            color: #ef4444 !important;
            font-size: 18px !important;
            font-weight: 900 !important;
            z-index: 1000 !important;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }

        .leaflet-popup-close-button:hover {
            background: #ef4444 !important;
            color: white !important;
            transform: scale(1.1) rotate(90deg) !important;
        }

        .custom-popup-wrap {
            width: 300px; padding: 28px; border-radius: 40px;
            backdrop-filter: blur(45px) saturate(210%) brightness(1.1); -webkit-backdrop-filter: blur(45px) saturate(210%) brightness(1.1);
            position: relative; overflow: hidden; border: 1.5px solid rgba(255, 255, 255, 0.2);
            box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.1), 0 30px 60px rgba(0, 0, 0, 0.5);
            transition: background 0.4s ease, border-color 0.4s ease;
        }

        .popup-satellite { background: rgba(15, 23, 42, 0.45) !important; color: white !important; }
        .popup-other { background: rgba(255, 255, 255, 0.55) !important; color: #0f172a !important; border-color: rgba(0, 0, 0, 0.1) !important; }

        .popup-header-3d {
            display: flex; align-items: center; gap: 10px; margin-bottom: 22px;
            padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .popup-header-3d span { font-size: 16px; font-weight: 950; font-style: italic; text-transform: uppercase; letter-spacing: -0.01em; }

        .popup-content-list { display: flex; flex-direction: column; gap: 10px; max-height: 260px; overflow-y: auto; padding-right: 8px; }
        .popup-content-list::-webkit-scrollbar { width: 3px; }
        .popup-content-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 10px; }
        .popup-other .popup-content-list::-webkit-scrollbar-thumb { background: rgba(15, 23, 42, 0.1); }

        .popup-item { padding: 14px 18px; border-radius: 22px; transition: all 0.3s; }
        .popup-satellite .popup-item { background: rgba(0, 0, 0, 0.25) !important; border-top: 1px solid rgba(255, 255, 255, 0.05); border-left: 1px solid rgba(255, 255, 255, 0.05); box-shadow: inset 0 2px 8px rgba(0,0,0,0.4); }
        .popup-other .popup-item { background: rgba(15, 23, 42, 0.05) !important; border: 1px solid rgba(0,0,0,0.05) !important; box-shadow: inset 0 2px 6px rgba(0,0,0,0.05) !important; }

        .popup-label-3d { font-size: 8px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.22em; margin-bottom: 3px; }
        .popup-satellite .popup-label-3d { color: rgba(255,255,255,0.3) !important; }
        .popup-other .popup-label-3d { color: rgba(15, 23, 42, 0.45) !important; }

        .popup-value-3d { font-size: 13px; font-weight: 800; line-height: 1.3; word-break: break-word; }
    </style>

    <div class="zoom-wrap">
        <button id="btn-zoom-in" class="btn-3d-unified btn-toggle-size"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path d="M12 4v16m8-8H4" /></svg></button>
        <button id="btn-zoom-out" class="btn-3d-unified btn-toggle-size"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path d="M4 12h16" /></svg></button>
    </div>

    <div class="absolute top-8 right-6 md:top-10 md:right-10 z-[1000]">
        <button wire:click="toggleSidebar" class="btn-3d-unified btn-toggle-size"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5"><path d="M4 6h16M4 12h16m-7 6h7" /></svg></button>
    </div>

    <div class="sidebar-container {{ $showSidebar ? 'sidebar-active' : '' }}">
        <div class="sidebar-inner glass-sidebar w-full h-full relative flex flex-col overflow-hidden text-left">
            <div class="flex items-center justify-between p-6 md:p-10 border-b border-white/10 text-left">
                <h2 class="text-xl font-black uppercase tracking-tight italic {{ $activeLayer == 'satellite' ? 'text-white/40' : 'text-white' }}">Map Settings</h2>
                <button wire:click="toggleSidebar" class="btn-3d-unified btn-toggle-size">✕</button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-10 space-y-10">
                <div>
                    <h3 class="font-bold uppercase tracking-widest text-[10px] mb-4 {{ $activeLayer == 'satellite' ? 'text-white/30' : 'text-white/70' }}">Base Layers</h3>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach(['satellite', 'terrain', 'base'] as $layer)
                        <div class="layer-card {{ $activeLayer == 'satellite' ? 'layer-card-sat' : '' }}">
                            <span class="text-sm font-bold uppercase tracking-tight {{ $activeLayer == 'satellite' ? 'text-white/40' : 'text-white' }}">{{ $layer }}</span>
                            <div wire:click="setLayer('{{ $layer }}')"
                                class="toggle-well {{ $activeLayer == 'satellite' ? ($activeLayer == $layer ? 'toggle-on-sat' : 'toggle-off-sat') : ($activeLayer == $layer ? 'toggle-on-other' : 'toggle-off-other') }}">
                                <div class="flex justify-between items-center h-full px-2 text-[8px] font-black"><span class="{{ $activeLayer == $layer ? 'opacity-100' : 'opacity-0' }}">ON</span><span class="{{ $activeLayer != $layer ? 'opacity-100' : 'opacity-0' }}">OFF</span></div>
                                <div class="toggle-knob {{ $activeLayer == $layer ? 'left-[39px]' : 'left-[3px]' }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @foreach($categories as $category)
                @if($category->mapData->count() > 0)
                <div class="text-left">
                    <h3 class="font-bold uppercase tracking-widest text-[10px] mb-4 {{ $activeLayer == 'satellite' ? 'text-white/30' : 'text-white/70' }}">{{ $category->name }}</h3>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($category->mapData as $data)
                        @php $isActive = in_array($data->id, $activeGeojsons); @endphp
                        <div class="layer-card {{ $activeLayer == 'satellite' ? 'layer-card-sat' : '' }}">
                            <div class="flex flex-col text-left">
                                <span class="text-sm font-bold uppercase tracking-tight {{ $activeLayer == 'satellite' ? 'text-white/40' : 'text-white' }}">{{ $data->name }}</span>
                                <span class="text-[9px] font-black {{ $data->type == 'Point' ? 'text-emerald-500' : ($data->type == 'Line' ? 'text-orange-500' : 'text-purple-500') }} uppercase tracking-widest">{{ $data->type }}</span>
                            </div>
                            <div wire:click="toggleGeojson('{{ $data->id }}')"
                                class="toggle-well {{ $activeLayer == 'satellite' ? ($isActive ? 'toggle-on-sat' : 'toggle-off-sat') : ($isActive ? 'toggle-on-other' : 'toggle-off-other') }}">
                                <div class="flex justify-between items-center h-full px-2 text-[8px] font-black text-left"><span class="{{ $isActive ? 'opacity-100' : 'opacity-0' }}">ON</span><span class="{{ !$isActive ? 'opacity-100' : 'opacity-0' }}">OFF</span></div>
                                <div class="toggle-knob {{ $isActive ? 'left-[39px]' : 'left-[3px]' }}"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    @if($showSidebar) <div wire:click="toggleSidebar" class="overlay-ios fixed inset-0 z-[1005]"></div> @endif

    <div id="map" class="w-full h-full z-0" wire:ignore></div>

    @script
    <script>
        let map;
        let currentTile;
        let geoJsonLayers = {};
        let isSatelliteMode = $wire.activeLayer === 'satellite';

        const tiles = {
            satellite: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
            terrain: 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
            base: 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png'
        };

        function updateAllVisiblePopups() {
            const isSat = isSatelliteMode;
            const wraps = document.querySelectorAll('.custom-popup-wrap');
            wraps.forEach(wrap => {
                const headerSpan = wrap.querySelector('.popup-header-3d span');
                const svgIcon = wrap.querySelector('.popup-header-3d svg');
                const tip = wrap.closest('.leaflet-popup').querySelector('.leaflet-popup-tip');
                if (isSat) {
                    wrap.className = 'custom-popup-wrap popup-satellite';
                    if (headerSpan) headerSpan.style.color = 'white';
                    if (svgIcon) svgIcon.setAttribute('stroke', '#ffffff');
                    if (tip) tip.style.background = 'rgba(15, 23, 42, 0.5)';
                } else {
                    wrap.className = 'custom-popup-wrap popup-other';
                    if (headerSpan) headerSpan.style.color = '#0f172a';
                    if (svgIcon) svgIcon.setAttribute('stroke', '#3b82f6');
                    if (tip) tip.style.background = 'rgba(255, 255, 255, 0.6)';
                }
            });
        }

        function switchLayer(layer) {
            if (currentTile) map.removeLayer(currentTile);
            currentTile = L.tileLayer(tiles[layer]).addTo(map);
            isSatelliteMode = (layer === 'satellite');
            updateAllVisiblePopups();
        }

        async function addGeoJsonLayer(id, path, type, iconUrl) {
            try {
                const response = await fetch(path);
                const data = await response.json();
                const layer = L.geoJSON(data, {
                    pointToLayer: function (feature, latlng) {
                        if (type === 'Point' && iconUrl) {
                            const customIcon = L.icon({ iconUrl: iconUrl, iconSize: [30, 30], iconAnchor: [15, 30], popupAnchor: [0, -30] });
                            return L.marker(latlng, { icon: customIcon });
                        }
                        return L.marker(latlng);
                    },
                    style: function(feature) {
                        let color = feature.properties._color || '#3b82f6';
                        return { color: color, weight: 2.5, fillOpacity: 0.45, fillColor: color };
                    },
                    onEachFeature: function (feature, layer) {
                        let props = feature.properties;
                        let html = `<div class="custom-popup-wrap">
                                        <div class="popup-header-3d">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                            <span>Informasi Detail</span>
                                        </div>
                                        <div class="popup-content-list">`;
                        Object.keys(props).forEach(key => {
                            if (!key.startsWith('_')) {
                                html += `<div class="popup-item">
                                            <div class="popup-label-3d">${key.replace(/_/g, ' ')}</div>
                                            <div class="popup-value-3d">${props[key]}</div>
                                         </div>`;
                            }
                        });
                        html += `</div></div>`;
                        layer.bindPopup(html, { maxWidth: 300, autoPan: true });
                    }
                }).addTo(map);
                geoJsonLayers[id] = layer;
                if (data.features && data.features.length > 0) {
                    map.flyToBounds(layer.getBounds(), { padding: [80, 80], duration: 1.2 });
                }
            } catch (e) { console.error(e); }
        }

        function removeGeoJsonLayer(id) {
            if (geoJsonLayers[id]) { map.removeLayer(geoJsonLayers[id]); delete geoJsonLayers[id]; }
        }

        function initMap() {
            if (map) return;
            map = L.map('map', { zoomControl: false, attributionControl: false, maxZoom: 19 }).setView([-2.014258, 105.180382], 13);
            switchLayer($wire.activeLayer);
            map.on('popupopen', function() { updateAllVisiblePopups(); });
            document.getElementById('btn-zoom-in').onclick = () => map.zoomIn();
            document.getElementById('btn-zoom-out').onclick = () => map.zoomOut();
        }

        $wire.on('layer-changed', ({ layer }) => switchLayer(layer));
        $wire.on('add-layer', ({ id, path, type, icon }) => addGeoJsonLayer(id, path, type, icon));
        $wire.on('remove-layer', ({ id }) => removeGeoJsonLayer(id));
        initMap();
        document.addEventListener('livewire:navigated', initMap);
    </script>
    @endscript
</div>

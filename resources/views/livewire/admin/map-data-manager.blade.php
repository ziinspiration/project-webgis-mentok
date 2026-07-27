<div class="h-screen flex overflow-hidden bg-slate-950"
     x-data="{ confirmDelete: false, deleteId: null }"
     x-on:open-delete-modal.window="confirmDelete = true; deleteId = $event.detail.id">
    <x-sidebar active="map-data" />
 <main class="flex-1 flex flex-col overflow-y-auto bg-slate-950/50 text-left custom-scrollbar">
        <x-header title="Kelola Data Spasial" subtitle="Manajemen Inventaris File Geospasial" />
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-12">
                <div class="lg:col-span-2 relative group">
                    <input type="text" wire:model.live="search" class="bg-black/30 border border-white/10 w-full pl-14 pr-7 py-5 rounded-[22px] text-white focus:outline-none focus:border-blue-500/50 shadow-inner text-sm transition-all" placeholder="Cari data spasial...">
                    <div class="absolute left-5 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue-500 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                </div>
                <div class="relative group">
                    <select wire:model.live="filterCategory" class="bg-black/30 border border-white/10 w-full pl-14 pr-10 py-5 rounded-[22px] text-white focus:outline-none focus:border-blue-500/50 appearance-none cursor-pointer shadow-inner text-sm transition-all font-bold">
                        <option value="" class="bg-slate-900">Semua Kategori</option>
                        @foreach($categories as $cat) <option value="{{ $cat->id }}" class="bg-slate-900">{{ $cat->name }}</option> @endforeach
                    </select>
                </div>
                <div class="relative group">
                    <select wire:model.live="filterType" class="bg-black/30 border border-white/10 w-full pl-14 pr-10 py-5 rounded-[22px] text-white focus:outline-none focus:border-blue-500/50 appearance-none cursor-pointer shadow-inner text-sm transition-all font-bold">
                        <option value="" class="bg-slate-900">Semua Tipe</option>
                        <option value="Polygon" class="bg-slate-900">Polygon</option>
                        <option value="Line" class="bg-slate-900">Line</option>
                        <option value="Point" class="bg-slate-900">Point</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end mb-10">
                <button wire:click="openModal" class="w-full sm:w-fit btn-3d-blue px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400">+ Buat Data Spasial</button>
            </div>

            <div class="space-y-10 pb-24">
                @foreach($groupedData as $category)
                @if($category->mapData->count() > 0 || (!$search && !$filterType))
                <div class="glass-card rounded-[35px] overflow-hidden border border-white/5">
                    <div class="bg-white/5 px-8 py-5 flex items-center justify-between border-b border-white/5">
                        <div class="flex items-center gap-4">
                            <div class="w-1.5 h-6 bg-blue-500 rounded-full shadow-[0_0_15px_rgba(59,130,246,0.5)]"></div>
                            <h3 class="font-black italic text-white uppercase tracking-wider text-sm">{{ $category->name }}</h3>
                        </div>
                        <span class="text-[9px] font-black bg-blue-500/10 text-blue-400 px-3 py-1 rounded-lg border border-blue-500/20 uppercase tracking-widest">{{ $category->mapData->count() }} Item</span>
                    </div>

                    <div class="overflow-x-auto w-full max-w-full custom-scrollbar">
                        <table class="w-full text-left border-collapse min-w-[1200px]">
                            <thead>
                                <tr class="bg-white/[0.02] text-white/30">
                                    <th class="px-8 py-4 text-[9px] font-black uppercase tracking-[0.3em] w-20">Urut</th>
                                    <th class="px-8 py-4 text-[9px] font-black uppercase tracking-[0.3em]">Detail Data</th>
                                    <th class="px-8 py-4 text-[9px] font-black uppercase tracking-[0.3em] text-center">Tipe</th>
                                    <th class="px-8 py-4 text-[9px] font-black uppercase tracking-[0.3em] text-right">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 sortable-list" data-category-id="{{ $category->id }}">
                                @forelse($category->mapData as $data)
                                <tr class="hover:bg-white/5 transition-colors group" data-id="{{ $data->id }}">
                                    <td class="px-8 py-5">
                                        <div class="handle cursor-grab active:cursor-grabbing text-white/10 hover:text-blue-500 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8h16M4 16h16" /></svg>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <p class="font-black italic uppercase text-white tracking-tighter text-base leading-tight">{{ $data->name }}</p>
                                        <p class="text-[9px] font-mono text-white/20 uppercase mt-1 tracking-widest">File: {{ basename($data->geojson_path) }}</p>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="text-[8px] font-black uppercase tracking-tighter {{ $data->type == 'Point' ? 'text-emerald-500' : ($data->type == 'Line' ? 'text-orange-500' : 'text-purple-500') }}">{{ $data->type }}</span>
                                            @if($data->icon_path)<img src="{{ asset('storage/'.$data->icon_path) }}" class="w-6 h-6 object-contain">@endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-3">
                                            <button wire:click="edit('{{ $data->id }}')" class="btn-3d-slate p-3 rounded-xl text-blue-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></button>
                                            <button @click="$dispatch('open-delete-modal', { id: '{{ $data->id }}' })" class="btn-3d-red p-3 rounded-xl text-red-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-8 py-10 text-center text-white/10 font-black uppercase tracking-[0.3em] italic text-xs">Kategori ini tidak memiliki data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>

        @if($isModalOpen)
        <div class="fixed inset-0 z-[2000] flex items-center justify-center p-3 sm:p-4 text-left">
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" wire:click="closeModal"></div>
            <div class="relative glass-card w-full max-w-2xl rounded-[40px] p-8 sm:p-14 border border-white/10 shadow-2xl text-left overflow-y-auto max-h-[95vh]">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/20 flex items-center justify-center text-blue-500 border border-blue-500/20 shadow-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg></div>
                    <h2 class="text-2xl font-black italic uppercase tracking-tighter text-white text-left">Data <span class="text-blue-500">Geospasial</span></h2>
                </div>
                <form wire:submit.prevent="save" class="space-y-7 text-left">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <div class="text-left"><label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-3 block">Nama Data</label><input type="text" wire:model="name" class="bg-black/40 border border-white/5 w-full px-6 py-5 rounded-[20px] text-white focus:outline-none shadow-inner font-bold" placeholder="Misal: Batas Administrasi">@error('name') <span class="text-red-500 text-[10px] ml-4 mt-2 block font-bold uppercase tracking-widest">{{ $message }}</span> @enderror</div>
                        <div class="text-left text-left"><label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-3 block">Kelompok Kategori</label><div class="relative group"><select wire:model="category_id" class="bg-black/40 border border-white/5 w-full pl-14 pr-10 py-5 rounded-[20px] text-white focus:outline-none appearance-none cursor-pointer shadow-inner font-bold"><option value="">Pilih Kategori</option>@foreach($categories as $cat) <option value="{{ $cat->id }}" class="bg-slate-900 font-bold uppercase">{{ $cat->name }}</option> @endforeach</select></div>@error('category_id') <span class="text-red-500 text-[10px] ml-4 mt-2 block font-bold uppercase tracking-widest">{{ $message }}</span> @enderror</div>
                    </div>
                    <div class="text-left text-left"><label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-3 block text-left">Jenis Struktur Geometri</label><div class="grid grid-cols-3 gap-4">@foreach(['Polygon', 'Line', 'Point'] as $t)<button type="button" wire:click="$set('type', '{{ $t }}')" class="py-5 rounded-[20px] border text-[10px] font-black uppercase tracking-[0.2em] transition-all {{ $type === $t ? 'bg-blue-600 border-blue-400 text-white shadow-xl shadow-blue-500/20 translate-y-[-2px]' : 'bg-white/5 border-white/5 text-white/30' }}">{{ $t }}</button>@endforeach</div></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-left text-left">
                        <div class="text-left text-left"><label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-3 block">Berkas GeoJSON</label><input type="file" wire:model="geojson_file" class="text-[10px] text-white/50 file:mr-5 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-blue-500/10 file:text-blue-400 hover:file:bg-blue-500/20 cursor-pointer">@error('geojson_file') <span class="text-red-500 text-[10px] ml-4 mt-2 block font-bold uppercase tracking-widest">{{ $message }}</span> @enderror</div>
                        @if($type === 'Point')<div class="text-left text-left"><label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-3 block">Ikon Penanda (Marker)</label><input type="file" wire:model="icon_file" class="text-[10px] text-white/50 file:mr-5 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-500/10 file:text-emerald-400 hover:file:bg-emerald-500/20 cursor-pointer">@error('icon_file') <span class="text-red-500 text-[10px] ml-4 mt-2 block font-bold uppercase tracking-widest">{{ $message }}</span> @enderror</div>@endif
                    </div>
                    <div class="pt-8 flex flex-col sm:flex-row justify-end gap-4 text-left"><button type="button" wire:click="closeModal" class="btn-3d-slate px-10 py-5 rounded-[22px] text-[10px] font-black uppercase tracking-widest text-white/30 order-2 sm:order-1">Batalkan</button><button type="submit" wire:loading.attr="disabled" class="btn-3d-blue px-12 py-5 rounded-[22px] text-[10px] font-black uppercase tracking-widest text-blue-400 order-1 sm:order-2"><span wire:loading.remove>Simpan & Unggah</span><span wire:loading>Memproses...</span></button></div>
                </form>
            </div>
        </div>
        @endif

        <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-[2000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-md" @click="confirmDelete = false"></div>
            <div class="relative glass-card w-full max-w-md rounded-[40px] p-12 border border-red-500/20 shadow-2xl text-center text-center">
                <div class="w-24 h-24 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mx-auto mb-8 text-red-500"><svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg></div>
                <h3 class="text-2xl font-black italic uppercase tracking-tighter text-white mb-4">Hapus Data Spasial?</h3>
                <p class="text-sm text-white/40 mb-10 leading-relaxed font-medium">Data geospasial dan berkas file terkait akan dihapus secara permanen.</p>
                <div class="flex flex-col gap-4 text-center">
                    <button @click="$wire.delete(deleteId); confirmDelete = false" class="btn-3d-red w-full py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest text-red-500">Ya, Hapus Permanen</button>
                    <button @click="confirmDelete = false" class="btn-3d-slate w-full py-5 rounded-2xl text-[11px] font-black uppercase tracking-widest text-white/20 text-center">Batalkan</button>
                </div>
            </div>
        </div>
    </main>

    @script
    <script>
        document.addEventListener('livewire:navigated', () => {
            document.querySelectorAll('.sortable-list').forEach(el => {
                Sortable.create(el, {
                    handle: '.handle', animation: 250, ghostClass: 'sortable-ghost',
                    onEnd: function () {
                        const items = Array.from(el.querySelectorAll('tr')).map((tr, index) => {
                            return { value: tr.dataset.id, order: index + 1 };
                        });
                        $wire.updateOrder(items);
                    }
                });
            });
        });
    </script>
    @endscript
</div>

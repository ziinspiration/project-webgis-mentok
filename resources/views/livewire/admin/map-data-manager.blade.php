<div class="min-h-screen text-slate-200 flex overflow-hidden relative z-10 text-left" x-data="{ confirmDelete: false, deleteId: null }" x-on:open-delete-modal.window="confirmDelete = true; deleteId = $event.detail.id">
    <x-sidebar active="map-data" />
    <main class="flex-1 flex flex-col overflow-y-auto w-full">
        <x-header title="Data Spasial" subtitle="Manajemen File Geospasial" />
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10 text-left">
                <div class="lg:col-span-2 relative group">
                    <input type="text" wire:model.live="search" class="bg-white/5 border border-white/10 w-full pl-12 pr-6 py-4 rounded-2xl text-white focus:outline-none focus:border-blue-500/50 shadow-inner transition-all text-sm" placeholder="Cari data spasial...">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue-500 transition-colors text-left"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg></div>
                </div>
                <div class="relative group">
                    <select wire:model.live="filterCategory" class="bg-white/5 border border-white/10 w-full pl-12 pr-10 py-4 rounded-2xl text-white focus:outline-none focus:border-blue-500/50 appearance-none cursor-pointer shadow-inner text-sm">
                        <option value="" class="bg-slate-900 text-white">Semua Kategori</option>
                        @foreach($categories as $cat) <option value="{{ $cat->id }}" class="bg-slate-900 text-white">{{ $cat->name }}</option> @endforeach
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue-500 pointer-events-none text-left"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg></div>
                </div>
                <div class="relative group text-left">
                    <select wire:model.live="filterType" class="bg-white/5 border border-white/10 w-full pl-12 pr-10 py-4 rounded-2xl text-white focus:outline-none focus:border-blue-500/50 appearance-none cursor-pointer shadow-inner text-sm text-left">
                        <option value="" class="bg-slate-900 text-white">Semua Tipe</option>
                        <option value="Polygon" class="bg-slate-900 text-white">Polygon</option>
                        <option value="Line" class="bg-slate-900 text-white">Line</option>
                        <option value="Point" class="bg-slate-900 text-white">Point</option>
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue-500 pointer-events-none text-left"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg></div>
                </div>
            </div>
            <div class="flex justify-end mb-8 text-left">
                <button wire:click="openModal" class="w-full sm:w-fit bg-blue-500/10 border border-white/10 px-8 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-blue-400 shadow-lg active:scale-95 transition-all text-left">+ Unggah Data</button>
            </div>
            <div class="glass-card rounded-[24px] sm:rounded-[40px] overflow-hidden border border-white/5 text-left">
                <div class="overflow-x-auto w-full custom-scrollbar text-left">
                    <table class="w-full text-left border-collapse min-w-[700px] text-left">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5 text-left">
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-left">Nama Data</th>
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-left">Kategori</th>
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-center text-left">Tipe</th>
                                <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.3em] text-white/30 text-right text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-left text-left">
                            @forelse($allData as $data)
                            <tr class="hover:bg-white/5 transition-colors group text-left">
                                <td class="px-6 py-6 text-left"><p class="font-black italic uppercase text-white tracking-tighter text-base">{{ $data->name }}</p><p class="text-[9px] font-mono text-white/20 italic">file: {{ basename($data->geojson_path) }}</p></td>
                                <td class="px-6 py-6 text-left"><span class="bg-blue-500/10 border border-blue-500/20 px-3 py-1 rounded-lg text-blue-400 font-bold text-[9px] uppercase tracking-widest text-left">{{ $data->category->name }}</span></td>
                                <td class="px-6 py-6 text-center text-left"><div class="flex flex-col items-center"><span class="text-[9px] font-black uppercase {{ $data->type == 'Point' ? 'text-emerald-500' : ($data->type == 'Line' ? 'text-orange-500' : 'text-purple-500') }}">{{ $data->type }}</span>@if($data->icon_path)<img src="{{ asset('storage/'.$data->icon_path) }}" class="w-5 h-5 mt-1 object-contain">@endif</div></td>
                                <td class="px-6 py-6 text-right space-x-2 whitespace-nowrap text-left">
                                    <button wire:click="edit('{{ $data->id }}')" class="text-blue-500/40 hover:text-blue-400 transition-colors text-left"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></button>
                                    <button @click="$dispatch('open-delete-modal', { id: '{{ $data->id }}' })" class="text-red-500/40 hover:text-red-400 transition-colors text-left"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-12 text-center text-white/20 font-black uppercase tracking-widest italic">Kosong</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($isModalOpen)
        <div class="fixed inset-0 z-[2000] flex items-center justify-center p-3 sm:p-4 text-left">
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="closeModal"></div>
            <div class="relative glass-card w-full max-w-2xl rounded-[30px] sm:rounded-[40px] p-6 sm:p-10 border border-white/10 shadow-2xl text-left overflow-y-auto max-h-[95vh] text-left">
                <h2 class="text-xl sm:text-2xl font-black italic uppercase tracking-tighter mb-8 text-white text-left">Form <span class="text-blue-500">Data Spasial</span></h2>
                <form wire:submit.prevent="save" class="space-y-6 text-left">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left text-left">
                        <div class="text-left text-left"><label class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block">Nama Data</label><input type="text" wire:model="name" class="bg-black/20 border border-white/5 w-full px-6 py-4 rounded-2xl text-white focus:outline-none shadow-inner" placeholder="Nama data...">@error('name') <span class="text-red-500 text-[10px] ml-4 mt-1">{{ $message }}</span> @enderror</div>
                        <div class="text-left text-left text-left"><label class="text-[9px] sm:text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block">Kategori</label><div class="relative group"><select wire:model="category_id" class="bg-black/20 border border-white/5 w-full pl-12 pr-10 py-4 rounded-2xl text-white focus:outline-none appearance-none cursor-pointer shadow-inner text-left"><option value="">Pilih Kategori</option>@foreach($categories as $cat) <option value="{{ $cat->id }}" class="bg-slate-900">{{ $cat->name }}</option> @endforeach</select><div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-blue-500 text-left"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg></div></div>@error('category_id') <span class="text-red-500 text-[10px] ml-4 mt-1">{{ $message }}</span> @enderror</div>
                    </div>
                    <div class="text-left text-left"><label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block text-left">Tipe Geometri</label><div class="grid grid-cols-3 gap-3">@foreach(['Polygon', 'Line', 'Point'] as $t)<button type="button" wire:click="$set('type', '{{ $t }}')" class="py-4 rounded-2xl border text-[10px] font-black uppercase transition-all {{ $type === $t ? 'bg-blue-500 border-blue-400 text-white shadow-lg' : 'bg-white/5 border-white/5 text-white/30' }}">{{ $t }}</button>@endforeach</div></div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left text-left">
                        <div class="text-left text-left"><label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block">File GeoJSON</label><input type="file" wire:model="geojson_file" class="text-[10px] text-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[9px] file:font-black file:bg-blue-500/20 file:text-blue-400">@error('geojson_file') <span class="text-red-500 text-[10px] ml-4 mt-1">{{ $message }}</span> @enderror</div>
                        @if($type === 'Point')<div class="text-left text-left"><label class="text-[10px] font-black uppercase tracking-[0.3em] text-white/30 ml-4 mb-2 block">Marker Icon</label><input type="file" wire:model="icon_file" class="text-[10px] text-white/50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[9px] file:font-black file:bg-emerald-500/20 file:text-emerald-400">@error('icon_file') <span class="text-red-500 text-[10px] ml-4 mt-1">{{ $message }}</span> @enderror</div>@endif
                    </div>
                    <div class="pt-4 flex flex-col sm:flex-row justify-end gap-3 text-left"><button type="button" @click="closeModal" class="px-6 py-4 text-[10px] font-black uppercase text-white/20 hover:text-white transition-all order-2 sm:order-1 text-left">Batal</button><button type="submit" wire:loading.attr="disabled" class="bg-blue-500/10 border border-white/10 px-8 py-4 rounded-2xl text-[10px] font-black uppercase text-blue-400 order-1 sm:order-2 text-left text-left"><span wire:loading.remove>Simpan Data</span><span wire:loading>Memproses...</span></button></div>
                </form>
            </div>
        </div>
        @endif
        <div x-show="confirmDelete" x-cloak class="fixed inset-0 z-[2000] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-md" @click="confirmDelete = false"></div>
            <div class="relative glass-card w-full max-w-md rounded-[30px] p-10 border border-red-500/20 shadow-2xl text-center"><div class="w-20 h-20 bg-red-500/20 border border-red-500/40 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500"><svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg></div><h3 class="text-xl font-black italic uppercase tracking-tighter text-white mb-2">Hapus Data?</h3><div class="flex flex-col gap-3 mt-8"><button @click="$wire.delete(deleteId); confirmDelete = false" class="bg-red-500/10 border border-red-500/40 py-4 rounded-2xl text-[10px] font-black uppercase text-red-500">Ya, Hapus Permanen</button><button @click="confirmDelete = false" class="py-4 text-[10px] font-black uppercase text-white/20">Batalkan</button></div></div>
        </div>
    </main>
</div>

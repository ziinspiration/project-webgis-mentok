@props(['route', 'active', 'icon', 'label'])

@php
    $isActive = $active === $route;
@endphp

<a href="{{ route($route) }}" wire:navigate
    class="{{ $isActive
        ? 'bg-blue-500/10 border-r-4 border-blue-500 text-blue-500 shadow-[inset_0_0_20px_rgba(59,130,246,0.1)]'
        : 'text-white/20 hover:text-blue-400 hover:bg-white/5' }}
    flex items-center p-4 rounded-xl transition-all duration-300 group">

    <svg class="h-6 w-6 shrink-0 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
    </svg>

    <span x-show="sidebarOpen" x-transition.opacity
        class="ml-4 font-black tracking-widest uppercase text-[10px] whitespace-nowrap">
        {{ $label }}
    </span>
</a>

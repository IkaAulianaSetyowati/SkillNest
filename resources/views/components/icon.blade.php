@props(['name', 'size' => 18])
@php
    $paths = [
        'home' => 'M3 10l9-7 9 7v10H3z',
        'cal' => 'M4 6h16v14H4zM4 10h16M8 3v4M16 3v4',
        'folder' => 'M3 6h7l2 2h9v11H3z',
        'users' => 'M9 11a4 4 0 100-8 4 4 0 000 8zM2 21v-2a5 5 0 015-5h4a5 5 0 015 5v2M17 3a4 4 0 010 8M22 21v-2a5 5 0 00-3-4.5',
        'card' => 'M3 6h18v12H3zM3 10h18',
        'chart' => 'M4 4h16v16H4zM8 16v-4M12 16V8M16 16v-6',
        'gear' => 'M12 8a4 4 0 100 8 4 4 0 000-8zM12 2v3M12 19v3M2 12h3M19 12h3M5 5l2 2M17 17l2 2M19 5l-2 2M7 17l-2 2',
        'log' => 'M3 12a9 9 0 109-9M3 4v5h5M12 7v5l3 2',
        'search' => 'M11 4a7 7 0 100 14 7 7 0 000-14zM21 21l-5-5',
        'bell' => 'M6 16v-5a6 6 0 0112 0v5l2 2H4zM10 21h4',
        'plus' => 'M12 5v14M5 12h14',
        'eye' => 'M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12zM12 9a3 3 0 100 6 3 3 0 000-6z',
        'edit' => 'M4 20h4L19 9l-4-4L4 16zM14 6l4 4',
        'trash' => 'M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13',
        'out' => 'M9 4H4v16h5M16 8l4 4-4 4M20 12H9',
        'dollar' => 'M12 3v18M16 7h-6a3 3 0 000 6h4a3 3 0 010 6H8',
        'target' => 'M12 3a9 9 0 100 18 9 9 0 000-18zM12 8a4 4 0 100 8 4 4 0 000-8z',
        'upload' => 'M12 16V4M7 9l5-5 5 5M4 20h16',
    ];
@endphp
<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $paths[$name] ?? '' }}"/></svg>
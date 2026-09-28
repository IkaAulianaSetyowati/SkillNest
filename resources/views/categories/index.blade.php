@extends('layouts.app')

@section('content')
<div class="px-[2cm] py-6 space-y-10">

    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 p-8 md:p-12 text-white shadow-xl">
        <div class="relative z-10 w-full space-y-3">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                {{ __('messages.explore_categories') }}
            </h1>
            <p class="text-indigo-100 text-sm md:text-base leading-relaxed w-full">
                {{ __('messages.explore_categories_desc') }}
            </p>
        </div>

        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-12 top-1/2 -translate-y-1/2 hidden md:flex items-center justify-center opacity-20 pointer-events-none">
            <i class="fas fa-shapes text-9xl"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $item)
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-start justify-between">
                        <div class="w-12 h-12 rounded-xl {{ $item->bg_color ?? 'bg-gray-50 text-gray-600' }} flex items-center justify-center text-xl">
                            <i class="{{ $item->icon }}"></i>
                        </div>
                        <span class="text-[11px] font-medium text-gray-500 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                            {{ $item->webinars_count }} {{ __('messages.webinar') }}
                        </span>
                    </div>

                    <div class="space-y-2">
                        <h3 class="text-base font-bold text-gray-900">{{ $item->translated_name }}</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $item->translated_description }}</p>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('categories.show', $item->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">
                        <span>{{ __('messages.view_webinars') }}</span>
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
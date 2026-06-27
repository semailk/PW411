@extends('layouts.main')

@section('title', $genre->name . ' - Кинопоиск')

@section('content')
    <div class="space-y-8">
        <!-- Хлебные крошки -->
        <nav class="flex items-center space-x-2 text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Главная</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('genres.index') }}" class="hover:text-white transition-colors">Жанры</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-yellow-400">{{ $genre->name }}</span>
        </nav>

        <!-- Заголовок жанра -->
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-yellow-500/20 to-orange-500/20 border border-yellow-500/20 p-8 md:p-12">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-500 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-orange-500 rounded-full blur-3xl"></div>
            </div>
            <div class="relative">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 rounded-2xl bg-yellow-500/20 flex items-center justify-center">
                            <i class="fas fa-tag text-3xl text-yellow-500"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl md:text-5xl font-extrabold text-white">
                                {{ $genre->name }}
                            </h1>
                            @if($genre->description)
                                <p class="text-gray-300 text-lg mt-2 max-w-2xl">{{ $genre->description }}</p>
                            @endif
                            <div class="flex items-center space-x-4 mt-3">
                            <span class="text-xs px-3 py-1 rounded-full {{ $genre->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ $genre->is_active ? 'Активен' : 'Неактивен' }}
                            </span>
                                <span class="text-xs text-gray-400">
                                <i class="far fa-calendar-alt mr-1"></i>
                                Создан: {{ $genre->created_at ? $genre->created_at->format('d.m.Y') : '-' }}
                            </span>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопки действий -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('genres.edit', $genre->slug) }}"
                           class="px-4 py-2 bg-yellow-500/20 text-yellow-400 rounded-xl hover:bg-yellow-500/30 transition-all duration-300 flex items-center space-x-2">
                            <i class="fas fa-edit"></i>
                            <span>Редактировать</span>
                        </a>
                        <a href="{{ route('genres.index') }}"
                           class="px-4 py-2 bg-gray-700/50 text-gray-300 rounded-xl hover:bg-gray-700 transition-all duration-300 flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Назад</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Фильмы жанра -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white flex items-center space-x-3">
                    <i class="fas fa-film text-yellow-500"></i>
                    <span>Фильмы в жанре <span class="text-yellow-400">«{{ $genre->name }}»</span></span>
                </h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
                @php
                    $films = collect([]); // Временно пустая коллекция
                @endphp

                @forelse($films as $film)
                    <div class="group relative overflow-hidden rounded-2xl bg-gray-800/70 border border-gray-700/50 hover:border-yellow-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-yellow-500/10">
                        <div class="aspect-[2/3] relative overflow-hidden bg-gray-700">
                            @if($film->poster)
                                <img src="{{ asset('storage/' . $film->poster) }}"
                                     alt="{{ $film->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                    <i class="fas fa-film text-4xl opacity-30"></i>
                                </div>
                            @endif

                            @if($film->rating)
                                <div class="absolute top-3 right-3 bg-black/70 backdrop-blur-sm px-2.5 py-1 rounded-lg flex items-center space-x-1">
                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                    <span class="text-white font-bold text-sm">{{ number_format($film->rating, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="text-white font-semibold text-sm group-hover:text-yellow-400 transition-colors line-clamp-1">
                                {{ $film->title }}
                            </h3>
                            @if($film->year)
                                <p class="text-gray-400 text-xs">{{ $film->year }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-400 py-20">
                        <i class="fas fa-film text-6xl mb-6 opacity-30"></i>
                        <p class="text-xl font-medium">В этом жанре пока нет фильмов</p>
                        <p class="text-sm mt-2">Скоро здесь появятся новые фильмы</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Рекомендуемые жанры -->
        <div class="pt-8 border-t border-gray-700/50">
            <h3 class="text-white font-semibold mb-4 flex items-center space-x-2">
                <i class="fas fa-lightbulb text-yellow-500"></i>
                <span>Вам также может понравиться</span>
            </h3>
            <div class="flex flex-wrap gap-3">
                @php
                    $recommended = \App\Models\Genre::where('is_active', true)
                        ->where('id', '!=', $genre->id)
                        ->inRandomOrder()
                        ->take(6)
                        ->get();
                @endphp
                @foreach($recommended as $rec)
                    <a href="{{ route('genres.show', $rec) }}"
                       class="px-4 py-2 bg-gray-800/50 border border-gray-700/50 rounded-xl text-gray-300 hover:text-white hover:border-yellow-500/50 hover:bg-yellow-500/10 transition-all duration-200 text-sm">
                        {{ $rec->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

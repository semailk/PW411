@extends('layouts.main')

@section('title', 'Все фильмы - Кинопоиск')

@section('content')
    <div class="space-y-8">
        <!-- Заголовок -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">Все фильмы</h2>
                <p class="text-gray-400 mt-1">Найдено {{ $movies->total() }} фильмов</p>
            </div>
            <div class="flex items-center space-x-3">
                <select class="bg-gray-700 text-white rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option>По популярности</option>
                    <option>По дате выхода</option>
                    <option>По рейтингу</option>
                </select>
                <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-filter mr-2"></i>Фильтры
                </button>
            </div>
        </div>

        <!-- Сетка фильмов -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($movies as $movie)
                <div class="movie-card bg-gray-800 rounded-xl overflow-hidden shadow-xl">
                    <!-- Картинка -->
                    <div class="relative">
                        @if($movie->cover)
                            <img src="{{ $movie->cover }}" width="358px" height="538px"
                                 alt="{{ $movie->title }}"
                                 class="movie-image w-full">
                        @else
                            <div class="movie-image w-full bg-gradient-to-br from-purple-900 to-blue-900 flex items-center justify-center">
                                <i class="fas fa-film text-6xl text-purple-400/50"></i>
                            </div>
                        @endif

                        <!-- Бейдж жанра -->
                        @if($movie->genre)
                            <div class="absolute top-3 left-3">
                    <span class="genre-badge text-white text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $movie->genre->name }}
                    </span>
                            </div>
                        @endif

                        <!-- Оверлей с информацией -->
                        <div class="absolute inset-0 card-overlay opacity-0 hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2 text-sm text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <span>7.8</span>
                                    <span class="text-gray-400 text-xs">(1.2k)</span>
                                </div>
                                @if($movie->issue)
                                    <div class="text-sm text-gray-300">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ \Carbon\Carbon::parse($movie->issue)->format('d.m.Y') }}
                                    </div>
                                @endif
                                @if($movie->time)
                                    <div class="text-sm text-gray-300">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $movie->time }} мин.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Информация о фильме -->
                    <div class="p-4 space-y-3">
                        <h3 class="font-semibold text-lg text-white truncate hover:text-purple-400 transition">
                            <a href="#">{{ $movie->title }}</a>
                        </h3>

                        @if($movie->description)
                            <p class="text-gray-400 text-sm line-clamp-2">
                                {{ Str::limit($movie->description, 80) }}
                            </p>
                        @endif

                        <!-- Актеры -->
                        @if($movie->actors->isNotEmpty())
                            <div class="flex flex-wrap gap-1">
                                @foreach($movie->actors->take(3) as $actor)
                                    <span class="text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded-full">
                            {{ $actor->first_name }} {{ $actor->last_name }}
                        </span>
                                @endforeach
                                @if($movie->actors->count() > 3)
                                    <span class="text-xs text-gray-500">+{{ $movie->actors->count() - 3 }}</span>
                                @endif
                            </div>
                        @endif

                        <!-- Кнопки действий -->
                        <div class="flex justify-between items-center pt-2 border-t border-gray-700">
                            <button class="text-sm text-purple-400 hover:text-purple-300 transition">
                                <i class="far fa-heart mr-1"></i>В избранное
                            </button>
                            <a href="#" class="text-sm bg-purple-600 hover:bg-purple-700 text-white px-4 py-1 rounded-full transition">
                                Подробнее
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-film text-6xl text-gray-600 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-400">Фильмы не найдены</h3>
                    <p class="text-gray-500">Попробуйте изменить параметры поиска</p>
                </div>
            @endforelse
        </div>

        <!-- Пагинация -->
        @if($movies->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="pagination flex items-center space-x-2">
                    {{-- Previous Page Link --}}
                    @if($movies->onFirstPage())
                        <span class="px-4 py-2 bg-gray-700 text-gray-500 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-left"></i>
                </span>
                    @else
                        <a href="{{ $movies->previousPageUrl() }}"
                           class="page-link px-4 py-2 bg-gray-700 hover:bg-purple-600 rounded-lg transition">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach($movies->links()->elements as $element)
                        @if(is_string($element))
                            <span class="px-4 py-2 text-gray-400">{{ $element }}</span>
                        @endif

                        @if(is_array($element))
                            @foreach($element as $page => $url)
                                @if($page == $movies->currentPage())
                                    <span class="px-4 py-2 bg-purple-600 text-white rounded-lg">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                       class="page-link px-4 py-2 bg-gray-700 hover:bg-purple-600 rounded-lg transition">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if($movies->hasMorePages())
                        <a href="{{ $movies->nextPageUrl() }}"
                           class="page-link px-4 py-2 bg-gray-700 hover:bg-purple-600 rounded-lg transition">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="px-4 py-2 bg-gray-700 text-gray-500 rounded-lg cursor-not-allowed">
                    <i class="fas fa-chevron-right"></i>
                </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection

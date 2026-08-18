@extends('layouts.main')

@section('title', $movie->title . ' - Кинопоиск')

@section('content')
    <div class="space-y-8">
        <!-- Хлебные крошки -->
        <nav class="flex items-center space-x-2 text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">
                <i class="fas fa-home mr-1"></i>Главная
            </a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-yellow-400">{{ $movie->title }}</span>
        </nav>

        <!-- Слайдер изображений -->
        @php $images = $movie->getMedia('images'); @endphp
        @if($images->isNotEmpty())
            <div class="relative rounded-3xl overflow-hidden bg-gray-800/70 border border-gray-700/50" id="movie-slider">
                <!-- Слайды -->
                <div class="relative h-[300px] sm:h-[400px] md:h-[500px] overflow-hidden">
                    @foreach($images as $index => $image)
                        <div class="slider-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                             data-index="{{ $index }}">
                            <img src="{{ $image->getUrl() }}"
                                 alt="{{ $movie->title }} — изображение {{ $index + 1 }}"
                                 class="w-full h-full object-cover">
                            <!-- Градиентный оверлей -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent"></div>
                        </div>
                    @endforeach

                    <!-- Навигационные стрелки -->
                    @if($images->count() > 1)
                        <button id="slider-prev"
                                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-black/50 hover:bg-black/70 backdrop-blur-sm text-white rounded-full flex items-center justify-center transition-all hover:scale-110">
                            <i class="fas fa-chevron-left text-lg"></i>
                        </button>
                        <button id="slider-next"
                                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-black/50 hover:bg-black/70 backdrop-blur-sm text-white rounded-full flex items-center justify-center transition-all hover:scale-110">
                            <i class="fas fa-chevron-right text-lg"></i>
                        </button>

                        <!-- Точки-индикаторы -->
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex space-x-2">
                            @foreach($images as $index => $image)
                                <button class="slider-dot w-3 h-3 rounded-full transition-all {{ $index === 0 ? 'bg-yellow-400 w-8' : 'bg-white/50 hover:bg-white/80' }}"
                                        data-index="{{ $index }}"></button>
                            @endforeach
                        </div>

                        <!-- Счётчик -->
                        <div class="absolute top-4 right-4 z-20 bg-black/50 backdrop-blur-sm px-3 py-1 rounded-full">
                            <span class="text-white text-sm">
                                <span id="slider-current">1</span> / {{ $images->count() }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Основной блок фильма -->
        <div class="relative rounded-3xl overflow-hidden bg-gray-800/70 border border-gray-700/50">
            <div class="flex flex-col lg:flex-row">
                <!-- Постер -->
                <div class="lg:w-1/3 flex-shrink-0">
                    <div class="aspect-[2/3] relative overflow-hidden">
                        @if($movie->cover)
                            <img src="{{ $movie->cover }}"
                                 alt="{{ $movie->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-purple-900 to-blue-900 flex items-center justify-center">
                                <i class="fas fa-film text-8xl text-purple-400/30"></i>
                            </div>
                        @endif

                        <!-- Бейдж рейтинга -->
                        <div class="absolute top-4 right-4 bg-black/70 backdrop-blur-sm px-3 py-2 rounded-xl flex items-center space-x-2">
                            <i class="fas fa-star text-yellow-400"></i>
                            <span class="text-white font-bold text-lg">8.5</span>
                        </div>

                        <!-- Бейдж возрастного ограничения -->
                        @if($movie->start_age)
                            <div class="absolute top-4 left-4 bg-red-600 px-3 py-1 rounded-lg">
                                <span class="text-white font-bold text-sm">{{ $movie->start_age }}+</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Информация о фильме -->
                <div class="flex-1 p-6 md:p-8 lg:p-10 space-y-6">
                    <!-- Заголовок и жанр -->
                    <div>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                                    {{ $movie->title }}
                                </h1>
                                @if($movie->genre)
                                    <a href="{{ route('genres.show', $movie->genre->slug) }}"
                                       class="inline-flex items-center space-x-2 mt-3 px-4 py-1.5 bg-yellow-500/20 text-yellow-400 rounded-full text-sm font-medium hover:bg-yellow-500/30 transition-all">
                                        <i class="fas fa-tag text-xs"></i>
                                        <span>{{ $movie->genre->name }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Мета-информация -->
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-300">
                        @if($movie->issue)
                            <div class="flex items-center space-x-2">
                                <i class="far fa-calendar-alt text-purple-400"></i>
                                <span>{{ $movie->issue }} год</span>
                            </div>
                        @endif

                        @if($movie->time)
                            <div class="flex items-center space-x-2">
                                <i class="far fa-clock text-purple-400"></i>
                                <span>{{ $movie->time }} мин.</span>
                            </div>
                        @endif

                        @if($movie->start_age)
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-user-shield text-purple-400"></i>
                                <span>{{ $movie->start_age }}+</span>
                            </div>
                        @endif
                    </div>

                    <!-- Описание -->
                    @if($movie->description)
                        <div class="space-y-3">
                            <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
                                <i class="fas fa-align-left text-purple-400"></i>
                                <span>Описание</span>
                            </h2>
                            <p class="text-gray-300 leading-relaxed text-base">
                                {{ $movie->description }}
                            </p>
                        </div>
                    @endif

                    <!-- Актеры -->
                    @if($movie->actors->isNotEmpty())
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-white flex items-center space-x-2">
                                <i class="fas fa-users text-purple-400"></i>
                                <span>Актёрский состав</span>
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($movie->actors as $actor)
                                    <div class="flex items-center space-x-3 bg-gray-700/50 rounded-xl p-3 hover:bg-gray-700 transition-all">
                                        <div class="w-12 h-12 rounded-full overflow-hidden bg-gray-600 flex-shrink-0">
                                            @if($actor->photo)
                                                <img src="{{ asset('storage/' . $actor->photo) }}"
                                                     alt="{{ $actor->first_name }} {{ $actor->last_name }}"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-white font-medium text-sm truncate">
                                                {{ $actor->first_name }} {{ $actor->last_name }}
                                            </p>
                                            @if($actor->surname)
                                                <p class="text-gray-400 text-xs truncate">{{ $actor->surname }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Кнопки действий -->
                    <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-700/50">
                        <button class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium transition-all flex items-center space-x-2">
                            <i class="far fa-heart"></i>
                            <span>В избранное</span>
                        </button>
                        <button class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-xl font-medium transition-all flex items-center space-x-2">
                            <i class="far fa-bookmark"></i>
                            <span>Смотреть позже</span>
                        </button>
                        <a href="{{ route('home') }}"
                           class="px-6 py-3 bg-gray-700/50 hover:bg-gray-700 text-gray-300 rounded-xl font-medium transition-all flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Назад к списку</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Похожие фильмы -->
        @if($relatedMovies->isNotEmpty())
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white flex items-center space-x-3">
                        <i class="fas fa-film text-purple-400"></i>
                        <span>Похожие фильмы</span>
                    </h2>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($relatedMovies as $related)
                        <a href="{{ route('movie.show', $related) }}"
                           class="group block bg-gray-800/70 rounded-xl overflow-hidden border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-purple-500/10">
                            <div class="aspect-[2/3] relative overflow-hidden">
                                @if($related->cover)
                                    <img src="{{ $related->cover }}"
                                         alt="{{ $related->title }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-purple-900 to-blue-900 flex items-center justify-center">
                                        <i class="fas fa-film text-3xl text-purple-400/30"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="text-white text-sm font-medium group-hover:text-purple-400 transition-colors line-clamp-1">
                                    {{ $related->title }}
                                </h3>
                                @if($related->issue)
                                    <p class="text-gray-400 text-xs mt-1">{{ $related->issue }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    @if($images->isNotEmpty() && $images->count() > 1)
    <script>
        (() => {
            const slides = document.querySelectorAll('.slider-slide');
            const dots = document.querySelectorAll('.slider-dot');
            const prevBtn = document.getElementById('slider-prev');
            const nextBtn = document.getElementById('slider-next');
            const currentSpan = document.getElementById('slider-current');
            let current = 0;
            let interval;

            function goTo(index) {
                slides[current].classList.replace('opacity-100', 'opacity-0');
                dots[current].classList.replace('bg-yellow-400', 'bg-white/50');
                dots[current].classList.replace('w-8', 'w-3');

                current = (index + slides.length) % slides.length;

                slides[current].classList.replace('opacity-0', 'opacity-100');
                dots[current].classList.replace('bg-white/50', 'bg-yellow-400');
                dots[current].classList.replace('w-3', 'w-8');

                if (currentSpan) currentSpan.textContent = current + 1;
            }

            function next() { goTo(current + 1); }
            function prev() { goTo(current - 1); }

            function startAuto() { interval = setInterval(next, 5000); }
            function stopAuto() { clearInterval(interval); }

            if (prevBtn) prevBtn.addEventListener('click', () => { stopAuto(); prev(); startAuto(); });
            if (nextBtn) nextBtn.addEventListener('click', () => { stopAuto(); next(); startAuto(); });

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    stopAuto();
                    goTo(parseInt(dot.dataset.index));
                    startAuto();
                });
            });

            startAuto();
        })();
    </script>
    @endif
    @endpush
@endsection

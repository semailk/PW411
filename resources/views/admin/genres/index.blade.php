@extends('layouts.main')

@section('title', 'Все жанры - Кинопоиск')

@section('content')
    <div class="space-y-8">
        <!-- Заголовок с кнопкой создания -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white flex items-center space-x-4">
                    <i class="fas fa-th-large text-yellow-500"></i>
                    <span>Все жанры</span>
                </h1>
                <p class="text-gray-400 mt-2 text-lg">
                    {{ $genres->count() }} жанров для вашего идеального киновечера
                </p>
            </div>
            <div class="flex items-center space-x-3">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('genres.create') }}"
                       class="px-6 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-semibold rounded-xl hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow-lg shadow-yellow-500/30 flex items-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Создать жанр</span>
                    </a>
                @endif
                <a href="{{ route('home') }}"
                   class="text-gray-400 hover:text-white transition-colors flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i>
                    <span class="hidden md:inline">На главную</span>
                </a>
            </div>
        </div>

        <!-- Сообщения об успехе -->
        @if(session('success'))
            <div
                class="bg-green-500/20 border border-green-500/50 rounded-xl p-4 text-green-400 flex items-center space-x-3 animate-fade-in-up">
                <i class="fas fa-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.style.display='none'"
                        class="ml-auto text-green-400 hover:text-green-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Статистика жанров -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-gray-800/50 border border-gray-700/50 rounded-2xl p-4 text-center">
                <div class="text-3xl font-bold text-yellow-400">{{ $genres->count() }}</div>
                <div class="text-gray-400 text-sm mt-1">Всего жанров</div>
            </div>
            <div class="bg-gray-800/50 border border-gray-700/50 rounded-2xl p-4 text-center">
                <div class="text-3xl font-bold text-blue-400">{{ $genres->where('is_active', true)->count() }}</div>
                <div class="text-gray-400 text-sm mt-1">Активных</div>
            </div>
            <div class="bg-gray-800/50 border border-gray-700/50 rounded-2xl p-4 text-center">
                <div class="text-3xl font-bold text-gray-400">{{ $genres->where('is_active', false)->count() }}</div>
                <div class="text-gray-400 text-sm mt-1">Неактивных</div>
            </div>
            <div class="bg-gray-800/50 border border-gray-700/50 rounded-2xl p-4 text-center">
                <div class="text-3xl font-bold text-green-400">12+</div>
                <div class="text-gray-400 text-sm mt-1">Тысяч фильмов</div>
            </div>
        </div>

        <!-- Поиск жанров -->
        <div class="mt-4 p-4 bg-gray-800/30 border border-gray-700/50 rounded-2xl">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3 w-full">
                    <i class="fas fa-search text-gray-400"></i>
                    <input type="text"
                           placeholder="Поиск жанра..."
                           id="genreSearch"
                           class="flex-1 bg-transparent text-white placeholder-gray-400 focus:outline-none">
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-500">
                    <span>Найдено:</span>
                    <span id="foundCount">{{ $genres->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Сетка жанров -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6" id="genresGrid">
            @forelse($genres as $genre)
                <div
                    class="genre-item group relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-800/70 to-gray-900/70 border border-gray-700/50 hover:border-yellow-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-yellow-500/10 min-h-[180px] flex flex-col">
                    <a href="{{ route('genres.show', $genre->slug) }}" class="flex-1 p-6">
                        <!-- Фоновый эффект -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-yellow-500/0 to-yellow-500/0 group-hover:from-yellow-500/10 group-hover:to-orange-500/10 transition-all duration-300"></div>

                        <div class="relative h-full flex flex-col">
                            <!-- Иконка -->
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 flex items-center justify-center mb-4 group-hover:from-yellow-500/20 group-hover:to-yellow-600/20 transition-all duration-300">
                                <i class="fas fa-tag text-2xl text-yellow-500"></i>
                            </div>

                            <!-- Название -->
                            <h3 class="text-white font-bold text-lg group-hover:text-yellow-400 transition-colors line-clamp-1">
                                {{ $genre->name }}
                            </h3>

                            <!-- Описание -->
                            @if($genre->description)
                                <p class="text-gray-400 text-sm mt-2 line-clamp-2 flex-1">{{ $genre->description }}</p>
                            @endif

                            <!-- Статус -->
                            <div class="mt-3">
                                <span
                                    class="text-xs px-2 py-1 rounded-full {{ $genre->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                    {{ $genre->is_active ? 'Активен' : 'Неактивен' }}
                                </span>
                            </div>

                            <!-- Количество фильмов -->
                            <div class="mt-3 pt-3 border-t border-gray-700/50 flex items-center justify-between">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-film mr-1"></i>
                                    {{-- {{ $genre->films_count ?? 0 }} фильмов --}}
                                    0 фильмов
                                </span>
                                <span
                                    class="text-yellow-400 group-hover:translate-x-1 transition-transform duration-300">
                                    <i class="fas fa-arrow-right text-sm"></i>
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Кнопки действий (только для администраторов) -->
                    @auth
                        @if(Auth::user()->is_admin ?? false)
                            <div
                                class="absolute top-3 right-3 flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('genres.edit', $genre) }}"
                                   class="p-1.5 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500/30 transition-colors text-xs"
                                   title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('genres.destroy', $genre) }}" method="POST"
                                      onsubmit="return confirm('Удалить жанр «{{ $genre->name }}»?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-1.5 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors text-xs"
                                            title="Удалить">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400 py-20">
                    <i class="fas fa-tags text-6xl mb-6 opacity-30"></i>
                    <p class="text-xl font-medium">Жанры не найдены</p>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <p class="text-sm mt-2">Создайте первый жанр!</p>
                        <a href="{{ route('genres.create') }}"
                           class="inline-block mt-4 px-6 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-semibold rounded-xl hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow-lg shadow-yellow-500/30">
                            <i class="fas fa-plus mr-2"></i>
                            Создать жанр
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Быстрое создание жанра (для администраторов) -->
        @auth
            @if(Auth::user()->is_admin ?? false)
                <div
                    class="mt-8 p-6 bg-gradient-to-r from-yellow-500/10 to-orange-500/10 border border-yellow-500/20 rounded-2xl">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <div>
                            <h3 class="text-white font-semibold flex items-center space-x-2">
                                <i class="fas fa-plus-circle text-yellow-500"></i>
                                <span>Быстрое создание жанра</span>
                            </h3>
                            <p class="text-gray-400 text-sm">Добавьте новый жанр в несколько кликов</p>
                        </div>
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('genres.create') }}"
                               class="px-6 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-semibold rounded-xl hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow-lg shadow-yellow-500/30 flex items-center space-x-2 whitespace-nowrap">
                                <i class="fas fa-plus"></i>
                                <span>Создать жанр</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        @endauth
    </div>

    <!-- JavaScript для поиска -->
    @push('scripts')
        <script>
            function searchGenre() {
                const input = document.getElementById('genreSearch');
                const filter = input.value.toLowerCase().trim();
                const items = document.querySelectorAll('.genre-item');
                let visibleCount = 0;

                items.forEach(item => {
                    const title = item.querySelector('h3')?.textContent?.toLowerCase() || '';
                    const description = item.querySelector('p')?.textContent?.toLowerCase() || '';

                    if (title.includes(filter) || description.includes(filter)) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Обновляем счетчик
                const foundCount = document.getElementById('foundCount');
                if (foundCount) {
                    foundCount.textContent = visibleCount;
                }

                // Показываем сообщение, если ничего не найдено
                const emptyMessage = document.getElementById('emptySearchMessage');
                if (visibleCount === 0 && filter !== '') {
                    if (!emptyMessage) {
                        const grid = document.getElementById('genresGrid');
                        const message = document.createElement('div');
                        message.id = 'emptySearchMessage';
                        message.className = 'col-span-full text-center text-gray-400 py-12';
                        message.innerHTML = `
                            <i class="fas fa-search text-4xl mb-4 opacity-30"></i>
                            <p class="text-lg font-medium">Ничего не найдено</p>
                            <p class="text-sm mt-1">Попробуйте изменить поисковый запрос</p>
                        `;
                        grid.appendChild(message);
                    }
                } else {
                    if (emptyMessage) {
                        emptyMessage.remove();
                    }
                }
            }

            // Поиск при вводе
            document.addEventListener('DOMContentLoaded', function () {
                const input = document.getElementById('genreSearch');
                if (input) {
                    input.addEventListener('input', searchGenre);

                    // Фокус на поиск по Ctrl+F или Cmd+F
                    document.addEventListener('keydown', function (e) {
                        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                            e.preventDefault();
                            input.focus();
                            input.select();
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection

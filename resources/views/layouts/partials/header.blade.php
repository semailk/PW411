<header class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur-md border-b border-gray-700/50 shadow-lg">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <!-- Логотип -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group flex-shrink-0">
                <div class="relative">
                    <div class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center shadow-lg shadow-yellow-500/30 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-film text-gray-900 text-xl"></i>
                    </div>
                    <div class="absolute -inset-1 bg-yellow-500/20 rounded-full blur-lg group-hover:blur-xl transition-all duration-300"></div>
                </div>
                <span class="text-2xl font-extrabold bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                    Кинопоиск
                </span>
            </a>

            <!-- Поиск -->
            <div class="flex-1 min-w-[200px] max-w-2xl">
                <div class="relative">
                    <input type="text"
                           placeholder="Поиск фильмов, сериалов, персон..."
                           class="w-full px-4 py-2.5 bg-gray-800/70 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300">
                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-yellow-400 transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Навигация -->
            <div class="flex items-center space-x-4 flex-shrink-0">
                <!-- Дропдаун жанров -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                            class="flex items-center space-x-2 px-4 py-2.5 bg-gray-800/70 border border-gray-600/50 rounded-xl text-gray-300 hover:text-white hover:border-yellow-500/50 transition-all duration-300 group">
                        <i class="fas fa-th-large text-yellow-500"></i>
                        <span>Жанры</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                    </button>

                    <!-- Выпадающий список жанров -->
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-3 w-72 bg-gray-800/95 backdrop-blur-lg border border-gray-700/50 rounded-2xl shadow-2xl shadow-black/50 overflow-hidden">
                        <div class="p-3 max-h-80 overflow-y-auto custom-scrollbar">
                            <div class="grid grid-cols-2 gap-2">
                                @php
                                    $genres = \App\Models\Genre::where('is_active', true)->get();
                                @endphp

                                @forelse($genres as $genre)
                                    <a href="{{ route('genres.show', $genre->slug) }}"
                                       class="flex items-center space-x-2 px-3 py-2.5 rounded-xl text-gray-300 hover:text-white hover:bg-yellow-500/10 transition-all duration-200 group">
                                        <i class="fas fa-tag text-yellow-500/60 text-xs"></i>
                                        <span class="text-sm font-medium">{{ $genre->name }}</span>
                                    </a>
                                @empty
                                    <div class="col-span-2 text-center text-gray-400 py-4">
                                        <i class="fas fa-film mb-2 text-2xl"></i>
                                        <p class="text-sm">Жанры не найдены</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Избранное (только для авторизованных) -->
                @auth
                    <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors relative">
                        <i class="fas fa-heart text-xl"></i>
                        <span class="absolute -top-1 -right-2 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">5</span>
                    </a>
                @endauth

                <!-- Правая часть (авторизация/регистрация) -->
                @guest
                    <!-- Гость -->
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}"
                           class="px-4 py-2.5 text-gray-300 hover:text-white hover:bg-gray-800/70 rounded-xl transition-all duration-300">
                            Войти
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-semibold rounded-xl hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow-lg shadow-yellow-500/30 hover:shadow-yellow-500/50">
                            Регистрация
                        </a>
                    </div>
                @else
                    <!-- Авторизованный пользователь -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open"
                                class="flex items-center space-x-3 px-3 py-2.5 bg-gray-800/70 border border-gray-600/50 rounded-xl hover:border-yellow-500/50 transition-all duration-300 group">
                            <!-- Аватар -->
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center text-gray-900 font-bold shadow-lg shadow-yellow-500/30">
                                <span class="text-sm">{{ strtoupper(substr(Auth::user()->name ?? 'А', 0, 1)) }}</span>
                            </div>
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">
                                {{ Auth::user()->name ?? 'Пользователь' }}
                            </span>
                            <i class="fas fa-chevron-down text-xs text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Выпадающее меню пользователя -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-3 w-56 bg-gray-800/95 backdrop-blur-lg border border-gray-700/50 rounded-2xl shadow-2xl shadow-black/50 overflow-hidden">
                            <div class="py-2">
                                <!-- Информация о пользователе -->
                                <div class="px-4 py-3 border-b border-gray-700/50">
                                    <p class="text-white font-medium text-sm">{{ Auth::user()->name }}</p>
                                    <p class="text-gray-400 text-xs">{{ Auth::user()->email }}</p>
                                </div>

                                <!-- Ссылки -->
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center space-x-3 px-4 py-2.5 text-gray-300 hover:text-white hover:bg-yellow-500/10 transition-colors">
                                    <i class="fas fa-user w-5 text-yellow-500/60"></i>
                                    <span>Мой профиль</span>
                                </a>
                                <a href="#"
                                   class="flex items-center space-x-3 px-4 py-2.5 text-gray-300 hover:text-white hover:bg-yellow-500/10 transition-colors">
                                    <i class="fas fa-heart w-5 text-yellow-500/60"></i>
                                    <span>Избранное</span>
                                    <span class="ml-auto text-xs bg-red-500/20 text-red-400 px-2 py-0.5 rounded-full">5</span>
                                </a>
                                <a href="#"
                                   class="flex items-center space-x-3 px-4 py-2.5 text-gray-300 hover:text-white hover:bg-yellow-500/10 transition-colors">
                                    <i class="fas fa-clock w-5 text-yellow-500/60"></i>
                                    <span>История просмотров</span>
                                </a>
                                <a href="#"
                                   class="flex items-center space-x-3 px-4 py-2.5 text-gray-300 hover:text-white hover:bg-yellow-500/10 transition-colors">
                                    <i class="fas fa-cog w-5 text-yellow-500/60"></i>
                                    <span>Настройки</span>
                                </a>
                                <hr class="border-gray-700/50 my-1">

                                <!-- Выход -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center space-x-3 w-full px-4 py-2.5 text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors">
                                        <i class="fas fa-sign-out-alt w-5"></i>
                                        <span>Выйти</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
</header>

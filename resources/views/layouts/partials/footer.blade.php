<footer class="bg-gray-900/95 backdrop-blur-md border-t border-gray-700/50 mt-auto">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- О проекте -->
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center">
                        <i class="fas fa-film text-gray-900 text-sm"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                        Кинопоиск
                    </span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Ваш гид в мире кино. Тысячи фильмов, сериалов и персон в одном месте.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                        <i class="fab fa-telegram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                        <i class="fab fa-vk text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Навигация -->
            <div>
                <h3 class="text-white font-semibold mb-4">Навигация</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">Фильмы</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">Сериалы</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">Персоны</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-yellow-400 transition-colors">Рейтинги</a></li>
                </ul>
            </div>

            <!-- Жанры -->
            <div>
                <h3 class="text-white font-semibold mb-4">Популярные жанры</h3>
                <ul class="space-y-2.5 text-sm">
                    @php
                        $popularGenres = \App\Models\Genre::where('is_active', true)->take(6)->get();
                    @endphp
                    @foreach($popularGenres as $genre)
                        <li>
                            <a href="{{ route('genres.show', $genre->slug) }}"
                               class="text-gray-400 hover:text-yellow-400 transition-colors flex items-center space-x-2">
                                <i class="fas fa-circle text-yellow-500/40 text-[6px]"></i>
                                <span>{{ $genre->name }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Контакты -->
            <div>
                <h3 class="text-white font-semibold mb-4">Контакты</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start space-x-3 text-gray-400">
                        <i class="fas fa-envelope text-yellow-500 mt-0.5"></i>
                        <span>info@kinopoisk.ru</span>
                    </li>
                    <li class="flex items-start space-x-3 text-gray-400">
                        <i class="fas fa-phone text-yellow-500 mt-0.5"></i>
                        <span>+7 (999) 123-45-67</span>
                    </li>
                    <li class="flex items-start space-x-3 text-gray-400">
                        <i class="fas fa-map-marker-alt text-yellow-500 mt-0.5"></i>
                        <span>Москва, ул. Кино, д. 1</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Нижняя часть -->
        <div class="border-t border-gray-700/50 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Кинопоиск. Все права защищены.</p>
            <div class="flex space-x-6 mt-2 md:mt-0">
                <a href="#" class="hover:text-gray-300 transition-colors">Политика конфиденциальности</a>
                <a href="#" class="hover:text-gray-300 transition-colors">Пользовательское соглашение</a>
            </div>
        </div>
    </div>
</footer>

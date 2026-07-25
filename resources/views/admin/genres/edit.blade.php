@extends('layouts.main')

@section('title', 'Редактирование жанра - Кинопоиск')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800/70 border border-gray-700/50 rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white flex items-center space-x-3">
                    <i class="fas fa-edit text-yellow-500"></i>
                    <span>Редактирование жанра</span>
                </h1>
                <a href="{{ route('genres.index') }}"
                   class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </a>
            </div>


            <form action="{{ route('genres.update', $genre->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Название -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Название жанра <span class="text-red-400">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $genre->name) }}"
                           placeholder="Например: Фантастика, Комедия..."
                           class="w-full px-4 py-2.5 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300 @error('name') border-red-500 @enderror">
                    @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="text-gray-500 text-xs">Slug:</span>
                        <span class="text-gray-400 text-xs">{{ $genre->slug }}</span>
                        <span class="text-gray-500 text-xs">(автоматически)</span>
                    </div>
                </div>

                <!-- Описание -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                        Описание
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              placeholder="Краткое описание жанра..."
                              class="w-full px-4 py-2.5 bg-gray-900/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500/50 focus:border-yellow-500/50 transition-all duration-300 @error('description') border-red-500 @enderror">{{ old('description', $genre->description) }}</textarea>
                    @error('description')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Активность -->
                <div>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $genre->is_active) ? 'checked' : '' }}
                               class="w-5 h-5 rounded-lg bg-gray-900/50 border-gray-600/50 text-yellow-500 focus:ring-yellow-500/50 focus:ring-2 transition-all duration-300">
                        <span class="text-gray-300">Активный жанр</span>
                    </label>
                    <p class="text-gray-500 text-xs mt-1">Неактивные жанры не отображаются на сайте</p>
                </div>

                <!-- Информация -->
                <div class="bg-gray-900/30 rounded-xl p-4 border border-gray-700/50">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Создан:</span>
                            <span class="text-gray-300 ml-2">{{ $genre->created_at ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Обновлен:</span>
                            <span class="text-gray-300 ml-2">{{ $genre->updated_at ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="flex items-center space-x-4 pt-4 border-t border-gray-700/50">
                    <button type="submit"
                            class="flex-1 px-6 py-2.5 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-semibold rounded-xl hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 shadow-lg shadow-yellow-500/30">
                        <i class="fas fa-save mr-2"></i>
                        Сохранить изменения
                    </button>
                    <a href="{{ route('genres.index') }}"
                       class="px-6 py-2.5 bg-gray-700 text-gray-300 font-semibold rounded-xl hover:bg-gray-600 transition-all duration-300">
                        Отмена
                    </a>
                </div>
            </form>

            <!-- Дополнительные действия -->
            <div class="mt-6 pt-6 border-t border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-300">Опасная зона</h3>
                        <p class="text-xs text-gray-500">Удаление жанра необратимо</p>
                    </div>
                    <form action="{{ route('genres.destroy', $genre->id) }}" method="POST"
                          onsubmit="return confirm('Вы уверены, что хотите удалить жанр «{{ $genre->name }}»? Это действие необратимо.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-500/20 text-red-400 rounded-xl hover:bg-red-500/30 transition-all duration-300 text-sm font-medium">
                            <i class="fas fa-trash mr-2"></i>
                            Удалить жанр
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.main')

@section('title', 'Добавить фильм')

@section('content')
    <div class="bg-gray-800 rounded-lg shadow-xl p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-white mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-white">Добавить фильм</h1>
        </div>

        <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Название -->
                <div>
                    <label for="title" class="block text-white mb-2">Название *</label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title') }}"
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Жанр -->
                <div>
                    <label for="genre_id" class="block text-white mb-2">Жанр *</label>
                    <select name="genre_id" id="genre_id"
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('genre_id') border-red-500 @enderror">
                        <option value="">Выберите жанр</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('genre_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Описание -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-white mb-2">Описание</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Возраст -->
                <div>
                    <label for="start_age" class="block text-white mb-2">Возрастное ограничение *</label>
                    <input type="number" name="start_age" id="start_age"
                           value="{{ old('start_age', 0) }}"
                           min="0" max="18"
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_age') border-red-500 @enderror">
                    @error('start_age')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Время -->
                <div>
                    <label for="time" class="block text-white mb-2">Длительность (минуты) *</label>
                    <input type="number" name="time" id="time"
                           value="{{ old('time') }}"
                           min="1"
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('time') border-red-500 @enderror">
                    @error('time')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Выпуск -->
                <div>
                    <label for="issue" class="block text-white mb-2">Год выпуска *</label>
                    <input type="number" name="issue" id="issue"
                           value="{{ old('issue') }}"
                           min="1900" max="{{ date('Y') }}"
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('issue') border-red-500 @enderror">
                    @error('issue')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Обложка -->
                <div>
                    <label for="cover" class="block text-white mb-2">Обложка</label>
                    <input type="file" name="cover" id="cover" accept="image/*"
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cover') border-red-500 @enderror">
                    @error('cover')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Актеры -->
                <div>
                    <label for="actors" class="block text-white mb-2">Актеры</label>
                    <select name="actors[]" id="actors" multiple
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($actors as $actor)
                            <option value="{{ $actor->id }}"
                                {{ in_array($actor->id, old('actors', [])) ? 'selected' : '' }}>
                                {{ $actor->first_name }} {{ $actor->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-gray-400 text-sm mt-1">Удерживайте Ctrl для выбора нескольких актеров</p>
                    @error('actors')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i>Сохранить
                </button>
                <a href="{{ route('admin.movies.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">
                    Отмена
                </a>
            </div>
        </form>
    </div>
@endsection

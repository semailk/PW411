@extends('layouts.main')

@section('title', 'Редактировать фильм')

@section('content')
    <div class="bg-gray-800 rounded-lg shadow-xl p-6">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-white mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-white">Редактировать фильм</h1>
        </div>

        <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Название -->
                <div>
                    <label for="title" class="block text-white mb-2">Название *</label>
                    <input type="text" name="title" id="title"
                           value="{{ old('title', $movie->title) }}"
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
                            <option value="{{ $genre->id }}"
                                {{ old('genre_id', $movie->genre_id) == $genre->id ? 'selected' : '' }}>
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
                              class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $movie->description) }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Возраст -->
                <div>
                    <label for="start_age" class="block text-white mb-2">Возрастное ограничение *</label>
                    <input type="number" name="start_age" id="start_age"
                           value="{{ old('start_age', $movie->start_age) }}"
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
                           value="{{ old('time', $movie->time) }}"
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
                           value="{{ old('issue', $movie->issue) }}"
                           min="1900" max="{{ date('Y') }}"
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('issue') border-red-500 @enderror">
                    @error('issue')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Текущая обложка -->
                <div>
                    <label class="block text-white mb-2">Текущая обложка</label>
                    <img src="{{ $movie->cover }}" alt="{{ $movie->title }}"
                         class="w-24 h-32 object-cover rounded">
                </div>

                <!-- Новая обложка -->
                <div>
                    <label for="cover" class="block text-white mb-2">Новая обложка</label>
                    <input type="file" name="cover" id="cover" accept="image/*"
                           class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cover') border-red-500 @enderror">
                    <p class="text-gray-400 text-sm mt-1">Оставьте пустым, чтобы сохранить текущую</p>
                    @error('cover')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Актеры -->
                <div class="md:col-span-2">
                    <label for="actors" class="block text-white mb-2">Актеры</label>
                    <select name="actors[]" id="actors"
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($actors as $actor)
                            <option value="{{ $actor->id }}"
                                {{ in_array($actor->id, old('actors', $movie->actors->pluck('id')->toArray())) ? 'selected' : '' }}>
                                {{ $actor->first_name }} {{ $actor->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-gray-400 text-sm mt-1">Удерживайте Ctrl для выбора нескольких актеров</p>
                    @error('actors')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Текущие изображения слайдера -->
                @php $existingImages = $movie->getMedia('images'); @endphp
                @if($existingImages->isNotEmpty())
                    <div class="md:col-span-2">
                        <label class="block text-white mb-2">
                            <i class="fas fa-images mr-2"></i>Текущие изображения слайдера
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                            @foreach($existingImages as $media)
                                <div class="relative group rounded-lg overflow-hidden bg-gray-700">
                                    <img src="{{ $media->getUrl() }}" alt="Image"
                                         class="w-full h-32 object-cover">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <a href="{{ route('admin.movies.destroy-image', ['movie' => $movie, 'media' => $media->id]) }}"
                                           onclick="return confirm('Удалить это изображение?')"
                                           class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 bg-black/70 px-2 py-1">
                                        <p class="text-white text-xs truncate">{{ $media->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Добавить новые изображения -->
                <div class="md:col-span-2">
                    <label class="block text-white mb-2">
                        <i class="fas fa-plus-circle mr-2"></i>Добавить изображения
                    </label>
                    <div id="drop-zone"
                         class="relative border-2 border-dashed border-gray-600 rounded-xl p-8 text-center hover:border-blue-500 transition-all cursor-pointer bg-gray-700/30">
                        <input type="file" name="images[]" id="images-input" multiple accept="image/*"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="space-y-2">
                            <i class="fas fa-cloud-upload-alt text-4xl text-blue-400"></i>
                            <p class="text-gray-300">Перетащите изображения сюда или <span class="text-blue-400 font-medium">нажмите для выбора</span></p>
                            <p class="text-gray-500 text-sm">JPG, PNG, BMP — макс. 4 МБ каждое. До 10 файлов.</p>
                        </div>
                    </div>
                    @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Превью выбранных изображений -->
                    <div id="images-preview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 mt-4"></div>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i>Обновить
                </button>
                <a href="{{ route('admin.movies.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">
                    Отмена
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        const dropZone = document.getElementById('drop-zone');
        const input = document.getElementById('images-input');
        const preview = document.getElementById('images-preview');

        ['dragenter', 'dragover'].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault();
                dropZone.classList.add('border-blue-500', 'bg-blue-500/10');
            });
        });

        ['dragleave', 'drop'].forEach(evt => {
            dropZone.addEventListener(evt, e => {
                e.preventDefault();
                dropZone.classList.remove('border-blue-500', 'bg-blue-500/10');
            });
        });

        dropZone.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            input.files = files;
            handleFiles(files);
        });

        input.addEventListener('change', () => {
            handleFiles(input.files);
        });

        function handleFiles(files) {
            preview.innerHTML = '';
            [...files].forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'relative group rounded-lg overflow-hidden bg-gray-700';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover" alt="Preview">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <i class="fas fa-check text-green-400 text-xl"></i>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 bg-black/70 px-2 py-1">
                            <p class="text-white text-xs truncate">${file.name}</p>
                        </div>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
    @endpush
@endsection

@extends('layouts.main')

@section('title', $movie->title)

@section('content')
    <div class="bg-gray-800 rounded-lg shadow-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-white mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-bold text-white">{{ $movie->title }}</h1>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.movies.edit', $movie) }}"
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition">
                    <i class="fas fa-edit mr-2"></i>Редактировать
                </a>
                <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Вы уверены?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-trash mr-2"></i>Удалить
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Обложка -->
            <div>
                <img src="{{ $movie->cover }}" alt="{{ $movie->title }}"
                     class="w-full rounded-lg shadow-lg">
            </div>

            <!-- Информация -->
            <div class="md:col-span-2 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-gray-400 text-sm">Название</h3>
                        <p class="text-white text-lg">{{ $movie->title }}</p>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-sm">Жанр</h3>
                        <p class="text-white text-lg">{{ $movie->genre->name ?? 'Не указан' }}</p>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-sm">Возрастное ограничение</h3>
                        <p class="text-white text-lg">{{ $movie->start_age }}+</p>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-sm">Длительность</h3>
                        <p class="text-white text-lg">{{ $movie->time }} минут</p>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-sm">Год выпуска</h3>
                        <p class="text-white text-lg">{{ $movie->issue }}</p>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-sm">Актеры</h3>
                        <p class="text-white text-lg">
                            @if($movie->actors->count())
                                {{ $movie->actors->pluck('first_name')->join(', ') }}
                            @else
                                Не указаны
                            @endif
                        </p>
                    </div>
                </div>

                @if($movie->description)
                    <div>
                        <h3 class="text-gray-400 text-sm">Описание</h3>
                        <p class="text-white">{{ $movie->description }}</p>
                    </div>
                @endif

                <div>
                    <h3 class="text-gray-400 text-sm">Создан</h3>
                    <p class="text-white">{{ $movie->created_at->format('d.m.Y H:i') }}</p>
                </div>
                @if($movie->updated_at)
                    <div>
                        <h3 class="text-gray-400 text-sm">Обновлен</h3>
                        <p class="text-white">{{ $movie->updated_at->format('d.m.Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Блок комментариев -->
    <div class="mt-8 border-t border-gray-700 pt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-white">
                <i class="fas fa-comments mr-2"></i>
                Комментарии ({{ $movie->comments->count() }})
            </h2>
        </div>

        <!-- Форма добавления комментария -->
        @auth
            <div class="bg-gray-700 rounded-lg p-4 mb-4">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="commentable_type" value="{{ get_class($movie) }}">
                    <input type="hidden" name="commentable_id" value="{{ $movie->id }}">

                    <div class="flex space-x-3">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name ?? 'Аноним', 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-grow">
                                <textarea name="comment" rows="2"
                                          class="w-full bg-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Напишите комментарий..."></textarea>
                            <button type="submit"
                                    class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                                <i class="fas fa-paper-plane mr-2"></i>Отправить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-gray-700 rounded-lg p-4 mb-4 text-center">
                <p class="text-gray-400">
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300">Авторизуйтесь</a>,
                    чтобы оставить комментарий
                </p>
            </div>
        @endauth

        @if($movie->comments->count() > 0)
            <div class="space-y-4">
                @foreach($movie->comments as $comment)
                    <div class="bg-gray-700 rounded-lg p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($comment->user->name ?? 'Аноним', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-white font-medium">
                                        {{ $comment->user->name ?? 'Анонимный пользователь' }}
                                        @if($comment->user && $comment->user->role === 'admin')
                                            <span class="ml-2 text-xs bg-red-600 text-white px-2 py-0.5 rounded-full">
                                                    <i class="fas fa-crown mr-1"></i>Admin
                                                </span>
                                        @endif
                                    </p>
                                    <p class="text-gray-400 text-sm">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $comment->created_at->format('d.m.Y H:i') }}
                                        @if($comment->created_at != $comment->updated_at)
                                            <span class="ml-2 text-gray-500">(изменен)</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @can('delete', $comment)
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Удалить комментарий?')"
                                            class="text-red-400 hover:text-red-300 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </div>
                        <p class="text-gray-300 mt-2 ml-12">{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Пагинация комментариев (если нужно) -->
            @if(method_exists($movie->comments, 'links'))
                <div class="mt-4">
                    {{ $movie->comments->links() }}
                </div>
            @endif
        @else
            <div class="bg-gray-700 rounded-lg p-8 text-center">
                <i class="fas fa-comment-slash text-4xl text-gray-500 mb-3"></i>
                <p class="text-gray-400">Комментариев пока нет</p>
                @auth
                    <p class="text-gray-500 text-sm mt-2">Будьте первым, кто оставит комментарий!</p>
                @endauth
            </div>
        @endif
    </div>
@endsection

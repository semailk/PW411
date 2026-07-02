@extends('layouts.main')

@section('title', 'Управление фильмами')

@section('content')
    <div class="bg-gray-800 rounded-lg shadow-xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-white">Фильмы</h1>
            <a href="{{ route('admin.movies.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-plus mr-2"></i>Добавить фильм
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-white">
                <thead>
                <tr class="border-b border-gray-700">
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Обложка</th>
                    <th class="px-4 py-3 text-left">Название</th>
                    <th class="px-4 py-3 text-left">Жанр</th>
                    <th class="px-4 py-3 text-left">Возраст</th>
                    <th class="px-4 py-3 text-left">Время</th>
                    <th class="px-4 py-3 text-left">Актеры</th>
                    <th class="px-4 py-3 text-left">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($movies as $movie)
                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">
                            <img src="{{ $movie->cover }}" alt="{{ $movie->title }}"
                                 class="w-12 h-16 object-cover rounded">
                        </td>
                        <td class="px-4 py-3">{{ $movie->title }}</td>
                        <td class="px-4 py-3">{{ $movie->genre->name ?? 'Без жанра' }}</td>
                        <td class="px-4 py-3">{{ $movie->start_age }}+</td>
                        <td class="px-4 py-3">{{ $movie->time }} мин.</td>
                        <td class="px-4 py-3">
                            <span class="text-sm">
                                {{ $movie->actors->pluck('first_name')->join(', ') }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.movies.show', $movie->id) }}"
                                   class="text-blue-400 hover:text-blue-300">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.movies.edit', $movie->id) }}"
                                   class="text-yellow-400 hover:text-yellow-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.movies.destroy', $movie->id) }}"
                                      method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Вы уверены?')"
                                            class="text-red-400 hover:text-red-300">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                            Фильмы не найдены
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $movies->links() }}
        </div>
    </div>
@endsection

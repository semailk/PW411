<?php

namespace Tests\Feature\API;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class GenreTest extends TestCase
{
    public function test_index(): void
    {
        $path = route('api.genres.index');
        $response = $this->get($path)->json();
        $genresCount = Genre::query()->where('is_active', true)->count();


        $meta = $response['meta'];
        $data = $response['data'];

        $this->assertEquals(10, $meta['per_page']);
        $this->assertEquals($genresCount, $meta['total']);
        $this->assertEquals($path, $meta['path']);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('slug', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('description', $data[0]);
        $this->assertArrayHasKey('movies', $data[0]);
    }

    public function test_show(): void
    {
        $genre = Genre::factory()->has(Movie::factory()->count(3), 'movies')->create();
        $path = route('api.genres.show', $genre->id);
        $response = $this->get($path)->json();

        $data = $response['data'];

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('slug', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('movies', $data);
        $this->assertCount(3, $data['movies']);
        $this->assertEquals($genre->id, $data['id']);
        $this->assertEquals($genre->name, $data['name']);
        $this->assertEquals($genre->description, $data['description']);
        $this->assertEquals($genre->is_active, $data['is_active']);
        $this->assertEquals($genre->slug, $data['slug']);
        $this->assertEquals($genre->created_at->format('d-m-Y H:m:s'), $data['created_at']);
        $this->assertEquals($genre->updated_at->format('d-m-Y H:m:s'), $data['updated_at']);
    }

    public function test_store(): void
    {
        $name = Str::random(10);
        $data = [
            'name' => $name,
            'is_active' => true,
            'slug' => Str::slug($name),
            'description' => Str::random(50),
        ];
        $path = route('api.genres.store');
        $response = $this->post($path, $data)->json();
        $data = $response['data'];
        $genre = Genre::query()->where('slug', $data['slug'])->first();
        $movie = Movie::query()->first();
        $movie->genre_id = $genre->id;
        $movie->save();

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('slug', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('movies', $data);
        $this->assertEquals(1, $genre->movies->count());
        $this->assertEquals($genre->id, $data['id']);
        $this->assertEquals($genre->name, $data['name']);
        $this->assertEquals($genre->description, $data['description']);
        $this->assertEquals($genre->is_active, $data['is_active']);
        $this->assertEquals($genre->slug, $data['slug']);
        $this->assertEquals($genre->created_at->format('d-m-Y H:m:s'), $data['created_at']);
        $this->assertEquals($genre->updated_at->format('d-m-Y H:m:s'), $data['updated_at']);
    }
}

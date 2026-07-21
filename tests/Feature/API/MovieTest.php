<?php

namespace Tests\Feature\API;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class MovieTest extends TestCase
{
    public function test_index(): void
    {
        $path = route('api.movies.index');

        $moviesCount = Movie::query()->count();

        $response = $this->get($path);
        $data = $response->json('data');
        $meta = $response->json('meta');

        $this->assertEquals($moviesCount, $meta['total']);
        $this->assertEquals(10, $meta['to']);
        $this->assertTrue((int)ceil($moviesCount / 10) == $meta['last_page']);
        $this->assertEquals($path, $meta['path']);
        $movie = $data[0];
        $this->assertArrayHasKey('id', $movie);
        $this->assertArrayHasKey('genre', $movie);
        $this->assertArrayHasKey('description', $movie);
        $this->assertArrayHasKey('start_age', $movie);
        $this->assertArrayHasKey('issue', $movie);
        $this->assertArrayHasKey('time', $movie);
        $this->assertArrayHasKey('cover', $movie);
    }

    public function test_show(): void
    {
        $movie = Movie::factory()->create();
        $path = route('api.movies.show', $movie->id);

        $response = $this->get($path);
        $data = $response->json('data');
        $response->assertStatus(200);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('genre', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('start_age', $data);
        $this->assertArrayHasKey('issue', $data);
        $this->assertArrayHasKey('time', $data);
        $this->assertArrayHasKey('cover', $data);

        $this->assertEquals($movie->id, $data['id']);
        $this->assertEquals($movie->description, $data['description']);
        $this->assertEquals($movie->start_age, $data['start_age']);
        $this->assertEquals($movie->issue, $data['issue']);
        $this->assertEquals($movie->time, $data['time']);
    }

    public function test_store(): void
    {
        $actorsIds = Actor::factory()->count(3)->create()->pluck('id')->toArray();

        $genreId = Genre::factory()->create()->id;
        $data = [
            'title' => Str::random(20),
            'genre_id' => $genreId,
            'description' => Str::random(20),
            'start_age' => rand(0, 18),
            'issue' => rand(1950, 2026),
            'time' => rand(60, 150),
            'actors' => $actorsIds
        ];

        $path = route('api.movies.store');
        $response = $this->post($path, $data);
        $response->assertStatus(201);
        $responseData = $response->json('data');

        $movie = Movie::query()->findOrFail($responseData['id']);

        $this->assertEquals($movie->id, $responseData['id']);
        $this->assertEquals($movie->description, $responseData['description']);
        $this->assertEquals($movie->description, $responseData['description']);
        $this->assertEquals($movie->start_age, $responseData['start_age']);
        $this->assertEquals($movie->issue, $responseData['issue']);
        $this->assertEquals($movie->time, $responseData['time']);
        $this->assertEquals($movie->genre_id, $genreId);
        $this->assertEquals(count($actorsIds), $movie->actors()->count());
        $this->assertEquals($actorsIds, $movie->actors->pluck('id')->toArray());
    }
}

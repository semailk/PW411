<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class GenreTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->get(route('genres.index'));

        $response->assertStatus(200);
    }

    public function test_create_not_auth(): void
    {
        $response = $this
            ->get(route('genres.create'));

        $response->assertStatus(403);
    }

    public function test_create_not_admin(): void
    {
        $user = User::query()->where('role', 'user')->first();

        $response = $this->actingAs($user)
            ->get(route('genres.create'));

        $response->assertStatus(403);
    }

    public function test_create_admin(): void
    {
        $user = User::query()->where('role', 'admin')->first();

        $response = $this->actingAs($user)
            ->get(route('genres.create'));

        $response->assertStatus(200);
    }

    public function test_store_not_auth(): void
    {
        $data = [
            'name' => 'test name',
            'description' => 'test description',
            'slug' => Str::slug('test name'),
            'is_active' => true,
        ];

        $response = $this
            ->post(route('genres.store'), $data);

        $response->assertStatus(403);
    }

    public function test_store_not_admin(): void
    {
        $data = [
            'name' => 'test name',
            'description' => 'test description',
            'slug' => Str::slug('test name'),
            'is_active' => true,
        ];

        $response = $this
            ->post(route('genres.store'), $data);

        $response->assertStatus(403);
    }

    public function test_store_admin(): void
    {
        $name = Str::random();
        $description = Str::random();
        $slug = Str::slug($name);
        $user = User::query()->where('role', 'admin')->first();

        $data = [
            'name' => $name,
            'description' => $description,
            'slug' => $slug,
            'is_active' => true,
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('genres.store'), $data);

        $response->assertStatus(302);
        $genre = Genre::query()->where('slug', $slug)->first();
        $this->assertNotNull($genre);
        $this->assertEquals($name, $genre->name);
        $this->assertEquals($description, $genre->description);
        $this->assertEquals($slug, $genre->slug);
        $this->assertEquals(1, $genre->is_active);
    }
}

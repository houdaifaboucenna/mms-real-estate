<?php

use App\Enums\RoleEnum;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('test_admin_can_list_posts', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $response = $this->get(route('posts.index'));

    $response->assertStatus(200);
});

test('test_admin_can_create_post', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    Storage::fake('public');
    $file = UploadedFile::fake()->image('image.jpg');

    $response = $this->post(route('posts.store'), [
        'title' => $title = fake()->title(),
        'content' => fake()->text(),
        'title_ar' => fake()->title(),
        'content_ar' => fake()->text(),
        'short' => fake()->text(),
        'short_ar' => fake()->text(),
        'keywords' => fake()->text(),
        'keywords_ar' => fake()->text(),
        'user_id' => $admin->id,
        'slug' => fake()->slug(),
        'image' => $file,
    ]);

    $response->assertRedirect(route('posts.index'));
    $this->assertDatabaseCount('posts', 1);
    $this->assertDatabaseHas('posts', [
        'title' => $title,
    ]);
});

test('test_admin_can_update_post', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $post = Post::factory()->create();
    $file = UploadedFile::fake()->image('image.jpg');

    $response = $this->put(route('posts.update', $post->id), [
        'title' => $title = fake()->title(),
        'content' => fake()->text(),
        'title_ar' => fake()->title(),
        'content_ar' => fake()->text(),
        'short' => fake()->text(),
        'short_ar' => fake()->text(),
        'keywords' => fake()->text(),
        'keywords_ar' => fake()->text(),
        'slug' => fake()->slug(),
        'image' => $file,
    ]);

    $response->assertRedirect(route('posts.index'));
    $this->assertDatabaseHas('posts', [
        'title' => $title,
    ]);
});

test('test_admin_can_delete_post', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $post = Post::factory()->create();

    $response = $this->delete(route('posts.destroy', $post->id));

    $response->assertRedirect(route('posts.index'));
    $this->assertDatabaseCount('posts', 0);
});

test('test_store_validates_required_fields', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $response = $this->post(route('posts.store'), [
        'title' => '',
        'content' => '',
        'title_ar' => '',
        'content_ar' => '',
        'user_id' => '',
        'slug' => '',
        'image' => '',
    ]);

    $response->assertStatus(302);
    $response->assertSessionHasErrors([
        'title',
        'content',
        'title_ar',
        'content_ar',
        'user_id',
        'slug',
        'image',
    ]);
});

test('test_guest_cannot_access_admin_posts', function () {
    $response = $this->get(route('posts.index'));

    $response->assertStatus(302);
});

test('test_non_admin_user_cannot_access_admin_posts', function () {
    $user = User::factory()->create()->assignRole(RoleEnum::USER);
    $this->actingAs($user);

    $response = $this->get(route('posts.index'));

    $response->assertStatus(403);
});

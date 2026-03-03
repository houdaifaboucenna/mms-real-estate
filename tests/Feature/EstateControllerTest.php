<?php

use App\Enums\EstateTypeEnum;
use App\Enums\RoleEnum;
use App\Models\CityTown;
use App\Models\Estate;
use App\Models\User;

test('test_admin_can_list_estates', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $response = $this->get(route('estates.index'));

    $response->assertStatus(200);
});

test('test_admin_can_create_estate', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $response = $this->post(route('estates.store'), [
        'title' => $title = fake()->title(),
        'content' => fake()->text(),
        'title_ar' => fake()->title(),
        'content_ar' => fake()->text(),
        'short' => fake()->text(),
        'short_ar' => fake()->text(),
        'keywords' => fake()->text(),
        'keywords_ar' => fake()->text(),
        'type' => EstateTypeEnum::APARTMENT->value,
        'min' => fake()->numberBetween(1, 100),
        'max' => fake()->numberBetween(1, 100),
        'town_id' => CityTown::factory()->create()->id,
        'slug' => fake()->slug(),
        'images' => [],
    ]);

    $response->assertRedirect(route('estates.index'));
    $this->assertDatabaseCount('estates', 1);
    $this->assertDatabaseHas('estates', [
        'title' => $title,
    ]);
});

test('test_admin_can_update_estate', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $estate = Estate::factory()->create();

    $response = $this->put(route('estates.update', $estate->id), [
        'title' => $title = fake()->title(),
        'content' => fake()->text(),
        'title_ar' => fake()->title(),
        'content_ar' => fake()->text(),
        'short' => fake()->text(),
        'short_ar' => fake()->text(),
        'keywords' => fake()->text(),
        'keywords_ar' => fake()->text(),
        'type' => EstateTypeEnum::APARTMENT->value,
        'min' => fake()->numberBetween(1, 100),
        'max' => fake()->numberBetween(1, 100),
        'town_id' => CityTown::factory()->create()->id,
        'slug' => fake()->slug(),
        'images' => [],
    ]);

    $response->assertRedirect(route('estates.index'));
    $this->assertDatabaseHas('estates', [
        'title' => $title,
    ]);
});

test('test_admin_can_delete_estate', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $estate = Estate::factory()->create();

    $response = $this->delete(route('estates.destroy', $estate->id));

    $response->assertRedirect(route('estates.index'));
    $this->assertDatabaseCount('estates', 0);
});

test('test_store_validates_required_fields', function () {
    $admin = User::factory()->create()->assignRole(RoleEnum::ADMIN);
    $this->actingAs($admin);

    $response = $this->post(route('estates.store'), [
        'title' => '',
        'content' => '',
        'title_ar' => '',
        'content_ar' => '',
        'town_id' => '',
        'type' => '',
        'slug' => '',
    ]);

    $response->assertStatus(302);
    $response->assertSessionHasErrors([
        'title',
        'content',
        'title_ar',
        'content_ar',
        'town_id',
        'type',
        'slug',
    ]);
});

test('test_guest_cannot_access_admin_estates', function () {
    $response = $this->get(route('estates.index'));

    $response->assertStatus(302);
});

test('test_non_admin_user_cannot_access_admin_estates', function () {
    $user = User::factory()->create()->assignRole(RoleEnum::USER);
    $this->actingAs($user);

    $response = $this->get(route('estates.index'));

    $response->assertStatus(403);
});

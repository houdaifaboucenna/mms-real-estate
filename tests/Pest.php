<?php

use Database\Seeders\RolePermissionSeeder;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->beforeEach(function () {
        $this->seed(RolePermissionSeeder::class);
    })
    ->in('Feature', 'Unit');


expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});


function something()
{
    // ..
}

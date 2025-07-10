<?php

namespace Tests\Feature\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
   
    public function test_if_can_return_categories(): void
    {
        // Arrange 
        $user = User::factory()->create();

        $categories = Category::select('name', 'title', 'description')->where('lang', config('app.locale'))->orderBy('name')->get()->toArray();

        // Act
        $response = $this->actingAs($user)->get('/api/categories');
        
        // Assert
        $response->assertStatus(200);
        $response->assertExactJson($categories);
    }
}

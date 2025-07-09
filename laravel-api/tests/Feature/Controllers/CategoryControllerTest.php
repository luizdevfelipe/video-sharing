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

        $categories = Category::select('name', 'description')->orderBy('name')->get()->toArray();

        if (config('app.locale') != 'en') {
            $translatedReturn = array_map(function ($category) {
                return [
                    'name' => __('categories.' . $category['name'] . '.name'),
                    'description' => __('categories.' . $category['name'] . '.description')
                ];
            }, $categories);
        } else {
            $translatedReturn = $categories;
        }
        
        // Act
        $response = $this->actingAs($user)->get('/api/categories');
        
        // Assert
        $response->assertStatus(200);
        $response->assertExactJson($translatedReturn);
    }
}

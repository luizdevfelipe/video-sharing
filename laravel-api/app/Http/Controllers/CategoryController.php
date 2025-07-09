<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function getCategories(): JsonResponse
    {
        $categories = Category::select('name', 'description')->orderBy('name')->get()->toArray();

        if (config('app.locale') !== 'en') {
            $translatedReturn = array_map(function ($category) {
                return ['name' => __('categories.' . $category['name'] . '.name'), 'description' => __('categories.' . $category['name'] . '.description')];
            }, $categories);

            return response()->json($translatedReturn);
        }

        return response()->json($categories);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function getCategories(): JsonResponse
    {
        $categories = Category::select('name', 'title', 'description')->where('lang', config('app.locale'))->orderBy('name')->get()->toArray();

        return response()->json($categories);
    }
}

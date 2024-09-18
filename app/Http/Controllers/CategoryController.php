<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Summary of getAll
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection<int, Category>[]
     */
    public function getAll(Request $request)
    {
        $categories = Category::all();
        return [
            'categories' => $categories
        ];
    }
}

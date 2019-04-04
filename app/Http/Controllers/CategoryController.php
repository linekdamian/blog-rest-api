<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all()->toJson(JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($category = Category::create(Input::all())) {
            return json_encode(['status' => 'success', 'result' => $category], JSON_PRETTY_PRINT);
        }
        return json_encode(['status' => 'error', 'description' => 'Unable to save request'], JSON_PRETTY_PRINT);
    }

    public function show($category)
    {
        if ($category = Category::find($category)) {
            return $category->toJson(JSON_PRETTY_PRINT);
        }

        return json_encode(['status' => 'error', 'description' => 'Unable to find resources'], JSON_PRETTY_PRINT);
    }

    public function update(Request $request, $category)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        if ($category = Category::find($category)) {
            if ($category->update(Input::all())) {
                return json_encode(['status' => 'success', 'result' => $category], JSON_PRETTY_PRINT);
            }
            return json_encode(['status' => 'error', 'description' => 'Unable to save request'], JSON_PRETTY_PRINT);
        }

        return json_encode(['status' => 'error', 'description' => 'Unable to find resources'], JSON_PRETTY_PRINT);
    }

    public function delete($category)
    {
        if ($category = Category::find($category)) {
            if ($category->delete()) {
                return json_encode(['status' => 'success', 'description' => 'Resource successfully deleted'], JSON_PRETTY_PRINT);
            }
            return json_encode(['status' => 'error', 'description' => 'Unable to delete resource'], JSON_PRETTY_PRINT);
        }

        return json_encode(['status' => 'error', 'description' => 'Unable to find resources'], JSON_PRETTY_PRINT);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
    public function index()
    {
        return jsonPrint('success', '', ['result' => Category::all()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name.en' => 'required|string',
        ]);

        foreach (Language::all() as $language) {
            $this->validate($request, [
                'name.' . $language->code => 'string|required_with:description',
                'description.' . $language->code => 'nullable|string',
            ]);
        }

        if ($category = Category::create(Input::all())) {
            return jsonPrint('success', 'saved', ['result' => $category]);
        }

        return jsonPrint('error', 'not.saved');
    }

    public function show($category)
    {
        if ($category = Category::find($category)) {
            return jsonPrint('success', '', ['result' => $category]);
        }

        return jsonPrint('error', 'not.found');
    }

    public function update(Request $request, $category)
    {
        $this->validate($request, [
            'name.en' => 'required|string',
        ]);

        foreach (Language::all() as $language) {
            $this->validate($request, [
                'name.' . $language->code => 'string|required_with:description',
                'description.' . $language->code => 'nullable|string',
            ]);
        }

        if ($category = Category::find($category)) {
            if ($category->update(Input::all())) {
                return jsonPrint('success', 'saved', ['result' => $category]);
            }

            return jsonPrint('error', 'not.saved');
        }

        return jsonPrint('error', 'not.found');
    }

    public function delete($category)
    {
        if ($category = Category::find($category)) {
            if ($category->delete()) {
                return jsonPrint('success', 'deleted');
            }

            return jsonPrint('error', 'not.deleted');
        }

        return jsonPrint('error', 'not.found');
    }
}

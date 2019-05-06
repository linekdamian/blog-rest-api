<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    public function index()
    {
        return jsonPrint('success', '', ['result' => Post::with('category', 'tags')->get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title.en' => 'required|string',
            'draft' => 'required|boolean',
            'category' => 'required|numeric',
        ]);

        foreach (Language::all() as $language) {
            $this->validate($request, [
                'title.' . $language->code => 'string|required_with:body',
                'body.' . $language->code => 'nullable|string',
            ]);
        }

        if (!$category = Category::find($request->category)) {
            return jsonPrint('error', 'incorrect');
        }

        if ($post = Post::create(Input::all())) {
            return jsonPrint('success', 'saved', ['result' => $post]);
        }

        // $post = new Post($request->all());
        // $post->setSlug();
        // $post->category_id = $category->id;

        // DB::beginTransaction();
        // if ($post->save() && $post->setTags($request->tags)) {
        //     $post->setTags($request->tags);

        //     DB::commit();
        //     return jsonPrint('success', 'saved', ['result' => $post]);
        // }

        // DB::rollBack();

        return jsonPrint('error', 'not.saved');
    }

    public function show($post)
    {
        if ($post = Post::with('category', 'tags')->find($post)) {
            return jsonPrint('success', '', ['result' => $post]);
        }

        return jsonPrint('error', 'not.found');
    }

    public function update(Request $request, $post)
    {
        $this->validate($request, [
            'title.en' => 'required|string',
            'draft' => 'required|boolean',
            'category' => 'required|numeric',
        ]);

        foreach (Language::all() as $language) {
            $this->validate($request, [
                'title.' . $language->code => 'string|required_with:body',
                'body.' . $language->code => 'nullable|string',
            ]);
        }

        if (!$category = Category::find($request->category)) {
            return jsonPrint('error', 'incorrect');
        }

        if (($post = Post::withoutGlobalScopes()->find($post)) && $post->update(Input::all())) {
            return jsonPrint('success', 'saved', ['result' => $post]);
        }

        return jsonPrint('error', 'not.found');
    }

    public function delete($post)
    {
        if ($post = Post::find($post)) {
            if ($post->delete()) {
                return jsonPrint('success', 'deleted');
            }

            return jsonPrint('error', 'not.deleted');
        }

        return jsonPrint('error', 'not.found');
    }
}

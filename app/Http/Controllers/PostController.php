<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    public function index()
    {
        return jsonPrint('success', null, ['result' => Post::with('category', 'tags')->get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'body' => 'required|string',
            'visible' => 'required|boolean',
            'category' => 'required|numeric',
        ]);

        if (!$category = Category::find($request->category)) {
            return jsonPrint('error', 'incorrect');
        }

        $post = new Post($request->all());
        $post->setSlug();
        $post->category_id = $category->id;

        DB::beginTransaction();
        if ($post->save() && $post->setTags($request->tags)) {
            $post->setTags($request->tags);

            DB::commit();
            return jsonPrint('success', 'saved', ['result' => $post]);
        }

        DB::rollBack();

        return jsonPrint('error', 'not.saved');
    }

    public function show($post)
    {
        if ($post = Post::with('category', 'tags')->find($post)) {
            return jsonPrint('success', null, ['result' => $post]);
        }

        return jsonPrint('error', 'not.found');
    }

    public function update(Request $request, $post)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'body' => 'required|string',
            'visible' => 'required|boolean',
            'category' => 'required|numeric',
        ]);

        if (!$category = Category::find($request->category)) {
            return jsonPrint('error', 'incorrect');
        }

        if ($post = Post::find($post)) {
            $post->category_id = $category->id;
            DB::beginTransaction();

            if ($post->update(Input::all()) && $post->setTags($request->tags)) {
                DB::commit();
                return jsonPrint('success', 'saved', ['result' => $post]);
            }

            DB::rollBack();
            return jsonPrint('error', 'not.saved');
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

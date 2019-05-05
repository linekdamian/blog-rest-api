<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Tag;
use App\Models\Language;

class TagController extends Controller
{
    public function index()
    {
        return jsonPrint('success', '', ['result' => Tag::all()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name.en' => 'required|string',
        ]);

        foreach (Language::all() as $language) {
            $this->validate($request, [
                'name.' . $language->code => 'string|nullable',
            ]);
        }

        if ($tag = Tag::create(Input::all())) {
            return jsonPrint('success', 'saved', ['result' => $tag]);
        }

        return jsonPrint('error', 'not.saved');
    }

    public function show($tag)
    {
        if ($tag = Tag::find($tag)) {
            return jsonPrint('success', '', ['result' => $tag]);
        }

        return jsonPrint('error', 'not.found');
    }

    public function update(Request $request, $tag)
    {
        $this->validate($request, [
            'name.en' => 'required|string',
        ]);

        foreach (Language::all() as $language) {
            $this->validate($request, [
                'name.' . $language->code => 'string|nullable',
            ]);
        }

        if ($tag = Tag::find($tag)) {
            if ($tag->update(Input::all())) {
                return jsonPrint('success', 'saved', ['result' => $tag]);
            }

            return jsonPrint('error', 'not.saved');
        }

        return jsonPrint('error', 'not.found');
    }

    public function delete($tag)
    {
        if ($tag = Tag::find($tag)) {
            if ($tag->delete()) {
                return jsonPrint('success', 'deleted');
            }

            return jsonPrint('error', 'not.deleted');
        }

        return jsonPrint('error', 'not.found');
    }
}

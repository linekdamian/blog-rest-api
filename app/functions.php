<?php

use Illuminate\Support\Arr;

function jsonPrint(string $status, string $description = '', array $additional = [])
{
    $response = [
        'status' => trans('statuses.' . $status)
    ];

    if ($description) {
        $response = Arr::add($response, 'description', trans('messages.' . $description));
    }

    if ($additional) {
        $response = array_merge($response, $additional);
    }

    return response()->json($response);
}

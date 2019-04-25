<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::findByEmail($request->email);

        if ($user && Hash::check($request->password, $user->password)) {
            return jsonPrint('success', null, ['token' => $user->jwt()]);
        }

        return jsonPrint('error', 'auth.failed');
    }
}

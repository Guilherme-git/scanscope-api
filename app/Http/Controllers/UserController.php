<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function auth(Request $request)
    {
        $user = User::where('email', '=', $request->email)
            ->where('password', '=', md5($request->password))
            ->get();

        if (count($user) == 0) {
            return response()->json(['message' => "Not register"]);
        } else {
            return $user->get(0);
        }
    }

    public function create(Request $request)
    {
        $users = new User();
        $users->email = $request->email;
        $users->password = md5($request->password);
        $users->save();

        return response()->json(['message' => "Save"]);
    }
}

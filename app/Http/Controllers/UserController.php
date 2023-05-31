<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{public function index()
    {
        if (auth('api')->check()) {
            $users = User::all();
            return response()->json($users);
        }
    
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // diğer özellikler

        $user->save();

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            
            return response()->json(['message' => 'Kullanıcı bulunamadı.'], 404);
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // diğer özellikler

        $user->save();

        return response()->json($user);
    }
}
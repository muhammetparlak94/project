<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        

        // Kullanıcıyı veritabanından alın
        $user = User::where('email', $email)->first();

      if (!$user) {
    // Kullanıcı bulunamadı
    return response()->json(['message' => 'Geçersiz e-posta veya şifre'], 401);
}


        // JWT oluştur
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            // İhtiyaç duyarsanız, diğer kullanıcı verilerini de payloadda ekleyebilirsiniz
        ];
        $jwt = JWT::encode($payload, 'sizin_jwt_anahtarınız');

        // Kullanıcı başarılı bir şekilde giriş yaptı, JWT ile birlikte yanıt dön
        return response()->json(['token' => $jwt, 'message' => 'Giriş başarılı'], 200);
    }



}
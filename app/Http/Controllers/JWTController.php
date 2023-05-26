<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class JWTController extends Controller
{
    public function generateToken(Request $request)
    {
        // Gelen API KEY ve Secret Keyler
        $apiKey = $request->input('api_key');
        $secretKey = $request->input('secret_key');

        // API key ve secret key'i kontrol etme
        $isValid = $this->checkCredentials($apiKey, $secretKey);

       if (!$isValid) {
            return response()->json(['message' => 'Geçersiz API key veya secret key'], 401);
        } 

        // JWT token create et
        $token = $this->generateJWTToken();

        // return token
        return response()->json(['token' => $token], 200);
    }

    private function checkCredentials($apiKey, $secretKey)
    {
        // API key ve secret key'i veritabanında kontrol etme

        $user = User::where('api_key', $apiKey)
                    ->where('secret_key', $secretKey)
                    ->first();

        if ($user) {
            return true;
        }

        return false;
    }

    private function generateJWTToken()
    {
        $algorithm = 'HS256';
        $payload = [
            //iss yayıncıdır giriş yapan uygulamanın adı ya da kimliği
            //aud jwt tokenin hangi sistem ya da hizmet tarafından kullanıldığını belirleme
            'iss' => 'your_iss',
            'aud' => 'your_aud',
            'iat' => time(),
            'exp' => time() + (60 * 60) // Token süresi 1 saat
        ];

        $jwtToken = JWT::encode($payload, 'your_secret_key', $algorithm);

        return $jwtToken;
    }
}

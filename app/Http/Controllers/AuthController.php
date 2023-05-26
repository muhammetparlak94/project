<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function getToken(Request $request)
    {
       /*  //Önce bu şekilde çalıştırmayı denedim. Elimde herhangi bir api_key ve secret_key olmadığı için çalışmadı.
        $apiKey = $request->input('api_key');
        $secretKey = $request->input('secret_key');

        // apiKey ve secretKey kontrolü yapılabilir

        $token = [
            'api_key' => $apiKey,
            'secret_key' => $secretKey,
            'exp' => time() + (60 * 60) // Token süresi: 1 saat
        ];

        $jwt = JWT::encode($token, 'jwt_secret_key');

        return response()->json(['token' => $jwt]); */
        
        
            $apiKey = 'temporary_api_key';
            $secretKey = 'temporary_secret_key';
            $algorithm = 'HS256';
        
            $token = [
                'api_key' => $apiKey,
                'secret_key' => $secretKey,
                'exp' => time() + (60 * 60) // Token süresi: 1 saat
            ];
            
            $jwtSecretKey = env('JWT_SECRET_KEY');
            $jwt = JWT::encode($token, $jwtSecretKey, $algorithm);
        
            return response()->json(['token' => $jwt]);
        }
}

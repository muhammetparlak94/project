<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\Key;

class EDJWTController extends Controller
{
    public function generateJwtToken(Request $request)
    {
        $payload = $request->only('user_id', 'username');

        $secret_key = 'mySecretKey123';
        $keyId = "keyId";
        $token = JWT::encode($payload, $secret_key, 'HS256', $keyId );

        return response()->json(['token' => $token]);
    }

    public function verifyJwtToken(Request $request)
    {
        $skey = new Key('mySecretKey123', 'HS256');
        $token = $request->input('token');

        try {
            
            
            $decoded_token = JWT::decode($token, $skey);

            return response()->json(['message' => 'Token doğrulandı.', 'decoded_token' => $decoded_token]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token doğrulanamadı.', 'error' => $e->getMessage()], 401);
        }
    }
}

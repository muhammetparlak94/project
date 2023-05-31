<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\Key;
use App\Models\User;
class EDJWTController extends Controller
{
    public function generateJwtToken(Request $request)
    {
        $payload = $request->only('user_id', 'username');
        $payload['permissions'] = ['user_list', 'user_create', 'user_update'];

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

            if (in_array('user_update', $decoded_token->permissions)) {
               
                $user = User::find($request->input('user_id'));
                if (!$user) {
                    return response()->json(['message' => 'Kullanıcı bulunamadı.'], 404);
                }
            
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                // diğer özellikler
            
                $user->save();
            
                return response()->json($user, 200);
            }

           

            if (in_array('user_list', $decoded_token->permissions)) {
                
                $users = User::all();
                return response()->json(['users' => $users]);
            }
            else {
                return response()->json(['message' => 'Yetkiniz yok.'], 403);
                 }
            
            if (in_array('user_create', $decoded_token->permissions)) {
               
                $user = new User();
                $user->name = $request->input('name1');
                $user->email = $request->input('email1');
                // diğer özellikler
        
                $user->save();
        
                return response()->json($user, 201);
            }

            else {
                return response()->json(['message' => 'Yetkiniz yok.'], 403);
            }
            
            if (in_array('user_update', $decoded_token->permissions)) {
               
                $user = User::find($request->input('user_id'));
                if (!$user) {
                    return response()->json(['message' => 'Kullanıcı bulunamadı.'], 404);
                }
            
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                // diğer özellikler
            
                $user->save();
            
                return response()->json($user, 200);
            }

            //return response()->json(['message' => 'Token doğrulandı.', 'decoded_token' => $decoded_token]);
        
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token doğrulanamadı.', 'error' => $e->getMessage()], 401);
        }
    }
}

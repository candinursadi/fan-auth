<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $user = User::query()
            ->where('email', request('email'))
            ->first();
        if(!$user) return response()->json(['error' => 'User not found'], 400);
        if(!Hash::check(request('password'), $user->password)){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = $this->generateJwt([
            'id' => $user->id,
            'nama' => $user->nama,
            'email' => $user->email,
            'npp' => $user->npp,
            'npp_supervisor' => $user->npp_supervisor,
            'exp'=> Carbon::now()->addHours(1)->timestamp
        ]);

        return $this->respondWithToken($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    function generateJwt($payload, $secret = 'secret') {
        $headers = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];

        $headers_encoded = $this->base64urlEncode(json_encode($headers));

        $payload_encoded = $this->base64urlEncode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
        $signature_encoded = $this->base64urlEncode($signature);

        $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";

        return $jwt;
    }

    function base64urlEncode($str) {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
    }
}

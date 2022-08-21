<?php

namespace MN\JwtAuth\Http\Controllers;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Auth\CreatesUserProviders;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use MN\JwtAuth\Http\Requests\GenerateTokenRequest;

class JwtAuthController extends Controller
{
    use CreatesUserProviders;
    public $app;
    public function __construct(){
        $this->app=app();
    }
    public function generateToken(GenerateTokenRequest $request){
        $provider=$this->createUserProvider('users');
        $user=$provider->retrieveByCredentials($request->validated());
        $payload=[
            'iat'=>Carbon::create()->timestamp,
            'auth_identifier'=>$user->getAuthIdentifier(),
            'exp'=>Carbon::create()->addDays(30)->timestamp
        ];
        $secret=$this->parseKey(config('jwt_auth.secret'));
        $token=JWT::encode($payload,$secret,'HS256');
        return response()->json([
            'token'=>$token
        ]);
    }
    private function parseKey($key){
        if (Str::startsWith($key, $prefix = 'base64:')) {
            $key = base64_decode(Str::after($key, $prefix));
        }
        return $key;
    }
}

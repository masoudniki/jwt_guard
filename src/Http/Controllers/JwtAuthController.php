<?php

namespace MN\JwtAuth\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Auth\CreatesUserProviders;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use MN\JwtAuth\Http\Requests\GenerateTokenRequest;
use ReallySimpleJWT\Token;

class JwtAuthController extends Controller
{
    use CreatesUserProviders;
    public function generateToken(GenerateTokenRequest $request){
        $provider=$this->createUserProvider('users');
        $user=$provider->retrieveByCredentials($request->validated());
        $payload=[
            'iat'=>Carbon::create()->timestamp,
            'auth_identifier'=>$user->getAuthIdentifier(),
            'exp'=>Carbon::create()->addDays(30)->timestamp
        ];
        $token=Token::customPayload($payload,config('jwt_auth.secret'));
        return response()->json([
            'token'=>$token
        ]);
    }
}
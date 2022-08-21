<?php

use Illuminate\Support\Facades\Route;

Route::group(["prefix"=>config('jwt_auth.route_prefix')],function (){
   Route::post("/generate-token",[
       "as"=>"jwt.generate.token",
       "uses"=>"JwtAuthController"
   ]);
});
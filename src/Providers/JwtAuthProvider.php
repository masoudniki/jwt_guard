<?php

use Illuminate\Support\ServiceProvider;

class JwtAuthProvider extends ServiceProvider
{
    public function boot(){
        \Illuminate\Support\Facades\Auth::extend("jwt_auth",function (){

        });
    }
}
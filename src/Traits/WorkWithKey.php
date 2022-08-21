<?php

namespace MN\JwtAuth\Traits;

use Illuminate\Support\Str;

trait WorkWithKey
{
    private function parseKey($key){
        if (Str::startsWith($key, $prefix = 'base64:')) {
            $key = base64_decode(Str::after($key, $prefix));
        }
        return $key;
    }
}
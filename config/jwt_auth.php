<?php


    return [

        /*
        | Route prefix
        |
        | we will use this key for setting a prefix for the routes of this package
        | to preventing conflict with your application routes
        */
        'route_prefix'=>env('JWT_AUTH_ROUTE_PREFIX',"jwt_authentication"),

        /*
        | secret
        |
        | the secret will be used for singing tokens or validation tokens
        | by default we use the same key that laravel use but if you want you can
        | change it
        */
        'secret'=>env("APP_KEY")




    ];




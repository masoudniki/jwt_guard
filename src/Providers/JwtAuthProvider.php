<?php
namespace MN\JwtAuth\Providers;
use Illuminate\Auth\CreatesUserProviders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MN\JwtAuth\Guard\JwtGuard;

class JwtAuthProvider extends ServiceProvider
{
    use CreatesUserProviders;
    public function boot(){
        $this->loadConfig();
        $this->registerJwtGuard();
        $this->registerRoutes();
    }

    /**
     * @return void
     */
    private function registerJwtGuard(): void
    {
        Auth::extend("jwt", function () {
            return new JwtGuard($this->createUserProvider('users'));
        });
    }
    private function registerRoutes()
    {
        Route::namespace('MN\JwtAuth\Http\Controllers')
            ->group(dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "/routes/routes.php");
    }
    private function loadConfig(){
        $this->mergeConfigFrom(dirname(__DIR__,2).DIRECTORY_SEPARATOR."config/jwt_auth.php","jwt_auth");
        $this->mergeConfigFrom(dirname(__DIR__,2) . DIRECTORY_SEPARATOR."config/jwt_auth.php",'jwt_auth');
    }
}
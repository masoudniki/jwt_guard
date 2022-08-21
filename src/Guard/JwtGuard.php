<?php
namespace MN\JwtAuth\Guard;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use ReallySimpleJWT\Token;

class JwtGuard implements \Illuminate\Contracts\Auth\Guard
{
    private Authenticatable $user;
    private UserProvider $provider;
    public function __construct(UserProvider $provider){
        $this->provider=$provider;
    }
    public function check()
    {
        $token=$this->getToken();
        return $token && Token::validate($token,config('jwt_auth.secret'));
    }

    public function guest()
    {
        return !isset($this->user);
    }

    public function user()
    {
        if(isset($this->user)){
            return $this->user;
        }
        $payload=Token::getPayload($this->getToken());
        $this->user=$this->provider->retrieveById($payload['auth_identifier']);
        return $this->user;
    }
    public function id()
    {
        if (isset($this->user)) {
            return $this->user->getAuthIdentifier();
        }
    }

    public function validate(array $credentials = [])
    {
        $user=$this->provider->retrieveByCredentials($credentials);
        if(isset($user)){
            return false;
        }
        if($this->provider->validateCredentials($user,$credentials)){
            $this->setUser($user);
            return true;
        }
        return false;
    }
    public function setUser(Authenticatable $user)
    {
        $this->user=$user;
    }
    public function getToken(){
        return request()->header(config('jwt_auth.header_name'));
    }
}
<?php

use Illuminate\Contracts\Auth\Authenticatable;

class JwtGuard implements \Illuminate\Contracts\Auth\Guard
{
    private $provider;
    private Authenticatable $user;

    public function check()
    {
        return isset($this->user);
    }

    public function guest()
    {
        return !isset($this->user);
    }

    public function user()
    {
        if($this->user){
            return $this->user;
        }


    }

    public function id()
    {
        if (isset($this->user)) {
            return $this->user->getAuthIdentifier();
        }
    }

    public function validate(array $credentials = [])
    {
        
    }

    public function setUser(Authenticatable $user)
    {
        $this->user=$user;
    }
}
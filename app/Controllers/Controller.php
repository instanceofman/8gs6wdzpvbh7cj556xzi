<?php


namespace App\Controllers;


use App\Exceptions\AuthorizedException;
use App\Exceptions\UnauthenticatedException;
use Intass\Http;
use Intass\Session;

class Controller
{
    protected $request;

    public function __construct(Http $request)
    {
        $this->request = $request;

        $this->initialize();
    }

    public function initialize()
    {
        if ($this->request->hasMiddleware('auth')
            && !Session::getInstance()->get('logged_in')
        ) {
            throw new UnauthenticatedException;
        }
    }
}

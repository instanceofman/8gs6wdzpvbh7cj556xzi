<?php


namespace App\Controllers;


use App\User;
use Intass\HttpResponse;
use Intass\Session;

class HelpController
{
    public function login()
    {
        Session::getInstance()->put('logged_in', true);
        Session::getInstance()->put('user', User::find(1)->toArray());

        return new HttpResponse("logged in");
    }

    public function logout()
    {
        Session::getInstance()->put('logged_in', false);
        Session::getInstance()->put('user', null);

        return new HttpResponse("logged out");
    }
}

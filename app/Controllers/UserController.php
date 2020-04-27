<?php

namespace App\Controllers;

use App\Exceptions\AuthorizedException;
use App\Transformers\UserTransformer;
use App\User;
use Intass\HttpResponse;
use Intass\Session;

class UserController extends Controller
{
    public function show()
    {
        $id = $this->request->segment(2);

        $user = User::find($id);

        if (Session::getInstance()->get('user')['id'] !== $user->id) {
            throw new AuthorizedException;
        }

        $data = (new UserTransformer())->transform($user);

        return HttpResponse::json($data);
    }

    public function update()
    {
        $id = $this->request->segment(2);

        $user = User::find($id);

        if (Session::getInstance()->get('user')['id'] !== $user->id) {
            throw new AuthorizedException;
        }

        $user->fill($this->request->getData())
             ->save();

        return HttpResponse::json($user);
    }
}

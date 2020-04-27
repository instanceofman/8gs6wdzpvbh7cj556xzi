<?php

namespace App;

use Intass\Model;

class User extends Model
{
    protected $readonly = ['id', 'email'];
}

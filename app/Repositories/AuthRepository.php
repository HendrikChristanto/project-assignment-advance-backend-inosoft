<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    public function create(array $data){
        $newUser = User::create($data);
        return $newUser;
    }
}
<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use MongoDB\Exception\InvalidArgumentException;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:5',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }
        
        $data['password'] = bcrypt($data['password']);

        return $this->authRepository->create($data);
    }

    public function authenticate(array $data)
    {
        $validator = Validator::make($data, [
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return Auth::attempt($data);
    }

    public function logout()
    {
        Auth::logout();
    }
}
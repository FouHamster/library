<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\UserEditRequest;
use App\Http\Requests\user\UserRegisterRequest;
use App\Models\Collection;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        $token = auth()->attempt($credentials);
        if (!$token) {
            return $this->response(['error' => 'Не правильный логин или пароль'], false, 401);
        }

        return $this->response(compact('token'));
    }

    public function register(UserRegisterRequest $request)
    {
        $userRole = Role::where(['title' => 'User'])->first();

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'role_id' => $userRole->id
        ]);

        $token = JWTAuth::fromUser($user);

        $collection = new Collection();
        $collection->user_id = $user->id;
        $collection->title = 'Избранное';
        $collection->save();

        return $this->response(compact('user', 'token'), code: 201);
    }

    public function logout()
    {
        auth()->logout();

        return $this->response(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        if (!auth()->user()) {
            return $this->response(['user not login'], false, 500);
        }
        return $this->response(auth()->user());
    }

    public function edit(UserEditRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        if ($data) {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $user->update($data);
        } else {
            return $this->response(['message' => 'Empty data for save!'], false, 500);
        }

        return $this->response(['message' => 'User saved!']);
    }



}

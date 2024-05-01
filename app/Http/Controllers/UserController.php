<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserValidation;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{
    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(UserValidation $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('12345678'),
        ])->roles()->attach(
            Role::where('name', 'admin')->first()->id
        ); 

        return redirect()->route('dashboard',[
            'type' => 'users'
        ]);
    }

    public function show(User $user)
    {
        return Inertia::render('User/Show',[
            'user' => (new UserResource($user))->resolve(),
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Edit',[
            'user' => (new UserResource($user))->resolve(),
        ]);
    }

    public function update(UserValidation $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('dashboard', [
            'type' => 'users'
        ]);
    }

    public function destroy(User $user)
    {
        $validator = Validator::make(['id' => $user->id], ['id' => 'exists:users,id']);

        $validator->after(function ($validator) use ($user) {
            if ($user->employees()->exists()) {
                $validator->errors()->add('error', "{$user->name} can't be deleted. First delete {$user->name}'s employees.");
            }
        });

        if ($validator->fails()) {
            return redirect()->route('dashboard', ['type' => 'users'])
                            ->withErrors($validator);
        }

        $user->roles()->detach();

        $user->delete();

        return redirect()->route('dashboard', ['type' => 'users']);
    }

}
<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt('12345678');
        $user = User::create($data);

        $user->roles()->attach(
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

    public function update(User $user, Request $request)
    {
        $user->update($request->all());

        return redirect()->route('dashboard', [
            'type' => 'users'
        ]);
    }

    public function destroy(User $user)
    {
        $user->roles()->detach();

        $user->delete();

        back(303);
    }
}

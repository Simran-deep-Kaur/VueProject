<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeValidation;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\UserResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->filter);
        if ($request->user()->hasRole('super-admin')){
            $query = Employee::query();
        }
        else{
            $query = $request->user()->employees();
         
        }
        $employees = Employee::filter($query, $request->filter)
                                ->paginate(10);

        return Inertia::render('Dashboard', [
            'employees' => EmployeeResource::collection($employees)->resolve(),
            'status' => 'Success',
            'type' => $request->type,
            'users' => UserResource::collection(User::whereNotIn('id',[auth()->id()])->get())->resolve(),
            'role' => $request->user()->roles->pluck('name')->toArray(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Employee/Create',[
            'status' => 'Success',
            'message' => 'Employee created successfully'
        ]);
    }

    public function store(EmployeeValidation $request)
    {
        $data = $request->all();

        if ($request['profile_image']) {
            $data['profile_image'] = $request['profile_image']->store('uploads');
        }

        $data['user_id'] = auth()->user()->id;
        Employee::create($data);
        return to_route('dashboard');
    }

    public function show(Employee $employee)
    {
        return Inertia::render('Employee/Show', [
            'employee' => (new EmployeeResource($employee))->resolve(),
            'status' => 'Success'
        ]);
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Employee/Edit', [
            'employee' => (new EmployeeResource($employee))->resolve(),
            'status' => 'Success'
        ]);
    }

    public function update(EmployeeValidation $request, Employee $employee)
    {
        $data = $request->all();

        if ($request['profile_image']) {
            if ($employee->profile_image) {
                $image_path = public_path('storage/') . $employee->profile_image;
                unlink($image_path);
            }

            $profileImageName = $request->file('profile_image')->store('uploads');
            $data['profile_image'] = $profileImageName;
        } else {
            unset($data['profile_image']);
        }

        $employee->update($data);

        return redirect()->route('dashboard',[
            'status' => 'Success',
            'message' => 'Employee updated successfully.'
        ]);
    }

    public function destroy(Employee $employee)
    {
        $image_path = public_path('storage/') . $employee->profile_image;

        if ($employee->profile_image) {
            unlink($image_path);
        }

        $employee->delete();

        back(303);
    }
}

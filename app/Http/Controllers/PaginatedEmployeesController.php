<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class PaginatedEmployeesController extends Controller
{
    public function paginatedEmployees(Request $request)
    {
        $employees = Employee::searchAndFilter($request->user()->employees(), $request->filter, $request->search)->paginate(10);        

        return response()->json([
            'employees' => EmployeeResource::collection($employees)->resolve(),
            'status' => 'Success'
        ]);
    }
}

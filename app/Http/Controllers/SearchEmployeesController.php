<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class SearchEmployeesController extends Controller
{
    public function search(Request $request)
    {
        if ($request->user()->hasRole('super-admin')){
            $query = Employee::query();
        }
        else{
            $query = $request->user()->employees();
         
        }
        $employees = Employee::searchAndFilter($query, $request->filter, $request->search)->paginate(10);

        return response()->json([
            'employees' => EmployeeResource::collection($employees)->resolve(),
            'status' => 'Success'
        ]);
    }
}

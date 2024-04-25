<?php

namespace App\Actions;

use App\Models\Employee;

class EmployeeAction
{


    public function searchAndFilter($employeeQuery, $filter, $search)
    {
        return Employee::filter($employeeQuery, $filter)->search($search);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidateEmailController extends Controller
{
    public function validateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                Rule::unique('employees')->ignore($request->Id, 'id'),
                Rule::unique('users')->ignore($request->Id, 'id')
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'success',
                'message' => $validator->errors()->first('email')
            ]);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Enums\Roles;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Employee;

class AuthController extends BaseController
{

    public function register(RegisterRequest $request) {
        $request->validated();

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role')
        ]);

        if($request->input('role') === Roles::Employee->value ){
            $employee = Employee::create([
                'user_id' => $user->id,
                'phone_number' => $request->input('phone_number'),
                'hire_date' => $request->input('hire_date'),
                'department' => $request->input('department'),
                'job_title' => $request->input('job_title'),
                'address_line_1' => $request->input('address_line_1'),
                'address_line_2' => $request->input('address_line_2'),
                'country' => $request->input('country'),
                'city' => $request->input('city'),
            ]);
        }

        $response = [
            'user' => $user,
        ];

        return $this->sendResponse($response, 'User has been added successfully');
    }

    /**
     * Handle account login request
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return $this->sendError(
                'Unauthorised', 
                ['error'=>'Unauthorised'], 
                401
            );
        }

        $token = $user->createToken('EmployeesBoard')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return $this->sendResponse($response, 'User login successfully');
    }

    /**
     * Handle account logout request
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
    */
    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return $this->sendResponse([], 'Logged out successfully');
    }
}

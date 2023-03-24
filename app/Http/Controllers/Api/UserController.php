<?php

namespace App\Http\Controllers\Api;

use App\Enums\Roles;
use App\Enums\Status;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query();
        $users->leftJoin('employees', 'users.id', '=', 'employees.user_id')
            ->select('users.*', 'employees.*');

        $users = $users->get();

        return $this->sendResponse($users, 'success');
    }

    /**
     * Display a listing of the resource by role.
     */
    public function indexByRole($role)
    {
        $users = User::query();

        if ($role === Roles::Employee->value) {
            $users->leftJoin('employees', 'users.id', '=', 'employees.user_id')
                ->select('users.*', 'employees.*')
                ->where('users.role', Roles::Employee->value);
        } else if ($role === Roles::Manager->value) {
            $users->select('*')
            ->where('users.role', Roles::Manager->value);
        }

        $users = $users->get();

        return $this->sendResponse($users, 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::query()
        ->leftJoin('employees', 'users.id', '=', 'employees.user_id')
        ->select(
            'users.*', 
            'employees.*', 
            'users.id AS user_id', 
            'employees.id AS employee_id'
        )
        ->where('users.id', $id)
        ->first();

        // Check if the user exists
        if (!$user) {
            return $this->sendError('User not found.', 404);
        }

        return $this->sendResponse($user, 'success');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmployeeContactInfo(Request $request, string $id)
    {
         // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return $this->sendError('User not found.', 404);
        }

        // Check if the user has an associated employee record
        $is_employee = $user->role === Roles::Employee ? true : false;

        if ($is_employee) {
            $employee = Employee::where('user_id', $user->id)->first();

            // Check if the employee exists
            if (!$employee) {
                return $this->sendError('Employee not found.', 404);
            }

            // Update the employee attributes
            $employee->phone_number = $request->phone_number;
            $employee->address_line_1 = $request->address_line_1;
            $employee->address_line_2 = $request->address_line_2;
            $employee->country = $request->country;
            $employee->city = $request->city;
            $employee->save();
        }

        // Return a success response
        return $this->sendResponse([$user], 'User updated successfully.');
    }

    /**
     * Deactivate a specified resource from storage.
     */
    public function deactivate($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return $this->sendError('User not found.', 404);
        }

        // Deactivate the user
        $user->status = Status::Deactivate;
        $user->save();

        return $this->sendResponse($user, 'User deactivated successfully');
    }
}

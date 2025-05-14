<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('user')->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'position' => 'required|string|max:255',
            'base_salary' => 'required|numeric|min:0',
            'absence_deduction' => 'required|numeric|min:0',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'join_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'employee',
            ]);

            Employee::create([
                'user_id' => $user->id,
                'position' => $request->position,
                'base_salary' => $request->base_salary,
                'absence_deduction' => $request->absence_deduction,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'join_date' => $request->join_date,
            ]);
        });

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load('user');
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $employee->load('user');
        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($employee->user_id),
            ],
            'position' => 'required|string|max:255',
            'base_salary' => 'required|numeric|min:0',
            'absence_deduction' => 'required|numeric|min:0',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'join_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $employee) {
            $employee->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($request->filled('password')) {
                $employee->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $employee->update([
                'position' => $request->position,
                'base_salary' => $request->base_salary,
                'absence_deduction' => $request->absence_deduction,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'join_date' => $request->join_date,
            ]);
        });

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        DB::transaction(function () use ($employee) {
            $employee->user->delete();
            // Employee will be deleted automatically due to cascade delete
        });

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\PayrollController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\AttendanceController as EmployeeAttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    
    // Attendance Management
    Route::get('/attendances/report', [AdminAttendanceController::class, 'report'])->name('attendances.report');
    Route::resource('attendances', AdminAttendanceController::class);
    
    // Payroll Management
    Route::get('/payrolls/{payroll}/payslip', [PayrollController::class, 'payslip'])->name('payrolls.payslip');
    Route::resource('payrolls', PayrollController::class);
});

// Employee Routes
Route::middleware(['auth', 'employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('dashboard');
    
    // Attendance
    Route::get('/attendances', [EmployeeAttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/clock-in', [EmployeeAttendanceController::class, 'clockIn'])->name('clock-in');
    Route::post('/clock-out', [EmployeeAttendanceController::class, 'clockOut'])->name('clock-out');
    
    // Payroll
    Route::get('/payrolls', [EmployeeAttendanceController::class, 'payrolls'])->name('payrolls');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

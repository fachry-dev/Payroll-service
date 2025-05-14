<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Count total employees
        $totalEmployees = Employee::count();
        
        // Count today's attendance
        $today = date('Y-m-d');
        $todayPresent = Attendance::where('date', $today)
                                 ->where('status', 'present')
                                 ->count();
        $todayAbsent = Attendance::where('date', $today)
                                ->where('status', 'absent')
                                ->count();
        
        // Get current month and year
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        // Calculate total salary for current month
        $totalSalary = Payroll::where('month', $currentMonth)
                             ->where('year', $currentYear)
                             ->sum('total_salary');
        
        // Get recent attendance records
        $recentAttendances = Attendance::with('employee.user')
                                      ->orderBy('date', 'desc')
                                      ->orderBy('created_at', 'desc')
                                      ->limit(5)
                                      ->get();
        
        return view('admin.dashboard', compact(
            'totalEmployees',
            'todayPresent',
            'todayAbsent',
            'totalSalary',
            'recentAttendances'
        ));
    }
}
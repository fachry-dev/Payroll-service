<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the employee dashboard.
     */
    public function index()
    {
        $employee = Auth::user()->employee;
        $today = date('Y-m-d');
        
        // Get today's attendance
        $todayAttendance = Attendance::where('employee_id', $employee->id)
                                    ->where('date', $today)
                                    ->first();
        
        // Get recent attendance records
        $recentAttendances = Attendance::where('employee_id', $employee->id)
                                      ->orderBy('date', 'desc')
                                      ->limit(5)
                                      ->get();
        
        // Get current month's attendance summary
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        $monthAttendances = Attendance::where('employee_id', $employee->id)
                                     ->whereMonth('date', $currentMonth)
                                     ->whereYear('date', $currentYear)
                                     ->get();
        
        $presentCount = $monthAttendances->where('status', 'present')->count();
        $absentCount = $monthAttendances->where('status', 'absent')->count();
        $lateCount = $monthAttendances->where('status', 'late')->count();
        
        // Get latest payroll
        $latestPayroll = Payroll::where('employee_id', $employee->id)
                               ->orderBy('year', 'desc')
                               ->orderBy('month', 'desc')
                               ->first();
        
        return view('employee.dashboard', compact(
            'employee',
            'todayAttendance',
            'recentAttendances',
            'presentCount',
            'absentCount',
            'lateCount',
            'latestPayroll'
        ));
    }

    /**
     * Display the employee's payroll history.
     */
    public function payrolls()
    {
        $employee = Auth::user()->employee;
        
        $payrolls = Payroll::where('employee_id', $employee->id)
                          ->orderBy('year', 'desc')
                          ->orderBy('month', 'desc')
                          ->paginate(10);
        
        return view('employee.payrolls', compact('payrolls'));
    }
}
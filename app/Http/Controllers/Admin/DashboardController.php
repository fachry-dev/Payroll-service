<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total employees
        $totalEmployees = Employee::count();
        
        // Get today's date
        $today = Carbon::today();
        
        // Get present and absent counts for today
        $todayPresent = Attendance::whereDate('date', $today)
            ->where(function($query) {
                $query->where('status', 'present')
                      ->orWhere('status', 'late');
            })
            ->count();
            
        $todayAbsent = Attendance::whereDate('date', $today)
            ->where('status', 'absent')
            ->count();
            
        // Get total salary for current month
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        
        $totalSalary = Payroll::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->sum('total_salary');
            
        // Get recent attendances
        $recentAttendances = Attendance::with('employee.user')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get recent employees
        $recentEmployees = Employee::with('user')
            ->orderBy('join_date', 'desc')
            ->take(5)
            ->get();
            
        // Check if payroll for current month is completed
        $payrollStatus = Payroll::where('month', $currentMonth)
            ->where('year', $currentYear)
            ->exists() ? 'completed' : 'pending';
            
        // Get recent activities (this would typically come from an Activity model)
        // For this example, we'll simulate some activities
        $recentActivities = collect([
            (object)[
                'description' => 'Admin menambahkan karyawan baru',
                'created_at' => Carbon::now()->subHours(2),
            ],
            (object)[
                'description' => 'Penggajian bulan ini telah diproses',
                'created_at' => Carbon::now()->subHours(5),
            ],
            (object)[
                'description' => 'Laporan absensi telah dihasilkan',
                'created_at' => Carbon::now()->subHours(8),
            ],
        ]);
        
        return view('admin.dashboard', compact(
            'totalEmployees',
            'todayPresent',
            'todayAbsent',
            'totalSalary',
            'recentAttendances',
            'recentEmployees',
            'payrollStatus',
            'recentActivities'
        ));
    }
}
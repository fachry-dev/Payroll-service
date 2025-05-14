<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employee = Auth::user()->employee;
        
        $query = Attendance::where('employee_id', $employee->id);
        
        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }
        
        $attendances = $query->orderBy('date', 'desc')->paginate(15);
        
        return view('employee.attendances.index', compact('attendances'));
    }

    /**
     * Clock in for today.
     */
    public function clockIn()
    {
        $employee = Auth::user()->employee;
        $today = date('Y-m-d');
        $now = date('H:i:s');
        
        // Check if attendance record exists for today
        $attendance = Attendance::where('employee_id', $employee->id)
                               ->where('date', $today)
                               ->first();
        
        if ($attendance) {
            // Update existing record if clock in is not set
            if (!$attendance->clock_in) {
                $attendance->update([
                    'clock_in' => $now,
                    'status' => 'present',
                ]);
                
                return redirect()->route('employee.dashboard')
                                 ->with('success', 'You have clocked in successfully.');
            }
            
            return redirect()->route('employee.dashboard')
                             ->with('error', 'You have already clocked in today.');
        }
        
        // Create new attendance record
        Attendance::create([
            'employee_id' => $employee->id,
            'date' => $today,
            'clock_in' => $now,
            'status' => 'present',
        ]);
        
        return redirect()->route('employee.dashboard')
                         ->with('success', 'You have clocked in successfully.');
    }

    /**
     * Clock out for today.
     */
    public function clockOut()
    {
        $employee = Auth::user()->employee;
        $today = date('Y-m-d');
        $now = date('H:i:s');
        
        // Check if attendance record exists for today
        $attendance = Attendance::where('employee_id', $employee->id)
                               ->where('date', $today)
                               ->first();
        
        if (!$attendance) {
            return redirect()->route('employee.dashboard')
                             ->with('error', 'You have not clocked in today.');
        }
        
        // Check if already clocked out
        if ($attendance->clock_out) {
            return redirect()->route('employee.dashboard')
                             ->with('error', 'You have already clocked out today.');
        }
        
        // Update attendance record
        $attendance->update([
            'clock_out' => $now,
        ]);
        
        return redirect()->route('employee.dashboard')
                         ->with('success', 'You have clocked out successfully.');
    }
}
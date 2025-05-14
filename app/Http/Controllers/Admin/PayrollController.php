<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payroll::with('employee.user');

        // Filter by month and year
        if ($request->filled('month') && $request->filled('year')) {
            $query->where('month', $request->month)
                  ->where('year', $request->year);
        }

        // Filter by employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $payrolls = $query->orderBy('year', 'desc')
                         ->orderBy('month', 'desc')
                         ->paginate(15);
        
        $employees = Employee::with('user')->get();

        return view('admin.payrolls.index', compact('payrolls', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::with('user')->get();
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear + 1);

        return view('admin.payrolls.create', compact('employees', 'months', 'years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string|size:2',
            'year' => 'required|integer',
        ]);

        // Check if payroll already exists for this employee and month/year
        $exists = Payroll::where('employee_id', $request->employee_id)
                         ->where('month', $request->month)
                         ->where('year', $request->year)
                         ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Payroll already exists for this employee in the selected month and year.');
        }

        $employee = Employee::findOrFail($request->employee_id);
        
        // Calculate absences for the month
        $absenceCount = Attendance::where('employee_id', $employee->id)
                                 ->whereMonth('date', $request->month)
                                 ->whereYear('date', $request->year)
                                 ->where('status', 'absent')
                                 ->count();
        
        // Calculate total deduction
        $absenceDeduction = $absenceCount * $employee->absence_deduction;
        
        // Calculate total salary
        $totalSalary = $employee->base_salary - $absenceDeduction;
        
        // Create payroll record
        Payroll::create([
            'employee_id' => $employee->id,
            'month' => $request->month,
            'year' => $request->year,
            'base_salary' => $employee->base_salary,
            'absence_count' => $absenceCount,
            'absence_deduction' => $absenceDeduction,
            'total_salary' => $totalSalary,
            'is_paid' => false,
        ]);

        return redirect()->route('admin.payrolls.index')
                         ->with('success', 'Payroll generated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        $payroll->load('employee.user');
        
        // Get attendance details for the month
        $attendances = Attendance::where('employee_id', $payroll->employee_id)
                                ->whereMonth('date', $payroll->month)
                                ->whereYear('date', $payroll->year)
                                ->get();
        
        return view('admin.payrolls.show', compact('payroll', 'attendances'));
    }

    /**
     * Mark payroll as paid.
     */
    public function markAsPaid(Payroll $payroll)
    {
        $payroll->update([
            'is_paid' => true,
            'payment_date' => now(),
        ]);

        return redirect()->route('admin.payrolls.show', $payroll)
                         ->with('success', 'Payroll marked as paid.');
    }

    /**
     * Generate payslip PDF.
     */
    public function generatePayslip(Payroll $payroll)
    {
        $payroll->load('employee.user');
        
        // Here you would generate a PDF using a library like DomPDF
        // For simplicity, we'll just return a view
        return view('admin.payrolls.payslip', compact('payroll'));
    }

    /**
     * Generate payrolls for all employees for a specific month.
     */
    public function generateBulk(Request $request)
    {
        $request->validate([
            'month' => 'required|string|size:2',
            'year' => 'required|integer',
        ]);

        $employees = Employee::all();
        $count = 0;

        foreach ($employees as $employee) {
            // Check if payroll already exists
            $exists = Payroll::where('employee_id', $employee->id)
                             ->where('month', $request->month)
                             ->where('year', $request->year)
                             ->exists();

            if (!$exists) {
                // Calculate absences for the month
                $absenceCount = Attendance::where('employee_id', $employee->id)
                                         ->whereMonth('date', $request->month)
                                         ->whereYear('date', $request->year)
                                         ->where('status', 'absent')
                                         ->count();
                
                // Calculate total deduction
                $absenceDeduction = $absenceCount * $employee->absence_deduction;
                
                // Calculate total salary
                $totalSalary = $employee->base_salary - $absenceDeduction;
                
                // Create payroll record
                Payroll::create([
                    'employee_id' => $employee->id,
                    'month' => $request->month,
                    'year' => $request->year,
                    'base_salary' => $employee->base_salary,
                    'absence_count' => $absenceCount,
                    'absence_deduction' => $absenceDeduction,
                    'total_salary' => $totalSalary,
                    'is_paid' => false,
                ]);

                $count++;
            }
        }

        return redirect()->route('admin.payrolls.index')
                         ->with('success', "Generated payrolls for $count employees.");
    }
}

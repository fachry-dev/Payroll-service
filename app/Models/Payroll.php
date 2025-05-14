<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'base_salary',
        'absence_count',
        'absence_deduction',
        'total_salary',
        'is_paid',
        'payment_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'base_salary' => 'decimal:2',
        'absence_deduction' => 'decimal:2',
        'total_salary' => 'decimal:2',
        'is_paid' => 'boolean',
        'payment_date' => 'date',
    ];

    /**
     * Get the employee that owns the payroll.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
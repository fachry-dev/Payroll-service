<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'position',
        'department',
        'join_date',
        'salary',
        'bank_account',
        'bank_name',
        'tax_id',
        'address',
        'phone',
        'emergency_contact',
        'emergency_phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'join_date' => 'date',
        'salary' => 'decimal:2',
    ];

    /**
     * Get the user that owns the employee.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attendances for the employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the payrolls for the employee.
     */
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}

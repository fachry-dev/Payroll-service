<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip - {{ $payroll->employee->user->name }} - {{ $payroll->month }}/{{ $payroll->year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .payslip {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-address {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .payslip-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .employee-info, .payroll-info {
            width: 48%;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            width: 40%;
            font-weight: bold;
        }
        .info-value {
            width: 60%;
        }
        .salary-section {
            margin-bottom: 20px;
        }
        .salary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .salary-table th, .salary-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .salary-table th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }
        .signature-box {
            width: 40%;
            text-align: center;
        }
        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        @media print {
            body {
                padding: 0;
            }
            .payslip {
                border: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()">Print Payslip</button>
        <button onclick="window.close()">Close</button>
    </div>
    
    <div class="payslip">
        <div class="header">
            <div class="company-name">PAYROLL SERVICE</div>
            <div class="company-address">123 Main Street, City, Country</div>
            <div class="payslip-title">EMPLOYEE PAYSLIP</div>
        </div>
        
        <div class="info-section">
            <div class="employee-info">
                <div class="section-title">Employee Information</div>
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value">{{ $payroll->employee->user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Position:</div>
                    <div class="info-value">{{ $payroll->employee->position }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $payroll->employee->user->email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Join Date:</div>
                    <div class="info-value">{{ $payroll->employee->join_date->format('d M Y') }}</div>
                </div>
            </div>
            
            <div class="payroll-info">
                <div class="section-title">Payroll Information</div>
                <div class="info-row">
                    <div class="info-label">Payroll ID:</div>
                    <div class="info-value">{{ $payroll->id }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Period:</div>
                    <div class="info-value">
                        @php
                            $monthNames = [
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
                                '12' => 'December'
                            ];
                        @endphp
                        {{ $monthNames[$payroll->month] }} {{ $payroll->year }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Payment Date:</div>
                    <div class="info-value">
                        {{ $payroll->payment_date ? $payroll->payment_date->format('d M Y') : 'Unpaid' }}
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Payment Status:</div>
                    <div class="info-value">
                        {{ $payroll->is_paid ? 'Paid' : 'Unpaid' }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="salary-section">
            <div class="section-title">Salary Details</div>
            <table class="salary-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Base Salary</td>
                        <td style="text-align: right;">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Absence Deduction ({{ $payroll->absence_count }} days)</td>
                        <td style="text-align: right;">- Rp {{ number_format($payroll->absence_deduction, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>Total Salary</td>
                        <td style="text-align: right;">Rp {{ number_format($payroll->total_salary, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">Employee Signature</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Authorized Signature</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This is a computer-generated document. No signature is required.</p>
            <p>For any queries regarding this payslip, please contact the HR department.</p>
        </div>
    </div>
</body>
</html>
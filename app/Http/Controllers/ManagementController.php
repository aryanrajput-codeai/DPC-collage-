<?php

namespace App\Http\Controllers;

use App\Models\AccreditationRecord;
use App\Models\Alumnus;
use App\Models\AuditLog;
use App\Models\Campus;
use App\Models\College;
use App\Models\Course;
use App\Models\DepartmentBudget;
use App\Models\Employee;
use App\Models\FeePayment;
use App\Models\FinancialVoucher;
use App\Models\Payroll;
use App\Models\PurchaseRequisition;
use App\Models\Student;
use App\Models\StudentFeeAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ManagementController extends Controller
{
    public function dashboard(): View
    {
        $college = College::first();
        $campus = Campus::first();

        // 1. Financial Solvency & Health
        $totalFeeExpected = (float) StudentFeeAccount::sum('total_amount');
        $totalFeeCollected = (float) StudentFeeAccount::sum('paid_amount');
        $totalOutstandingFee = (float) StudentFeeAccount::sum('balance_amount');
        $feeRecoveryRate = $totalFeeExpected > 0 ? round(($totalFeeCollected / $totalFeeExpected) * 100, 1) : 0;

        $totalIncome = (float) FeePayment::sum('amount');
        $totalExpense = (float) FinancialVoucher::sum('amount');
        $netSurplus = $totalIncome - $totalExpense;

        $monthlyPayrollCost = (float) Payroll::where('month', 10)->where('year', 2026)->sum('gross_salary');
        $departmentBudgets = DepartmentBudget::with('department')->get();

        // 2. Admissions, Seat Intake & Capacity Utilization
        $courses = Course::withCount('students')->with('department')->get();
        $totalIntake = (int) Course::sum('intake_capacity');
        $totalEnrolled = Student::where('status', 'Active')->count();
        $capacityUtilization = $totalIntake > 0 ? round(($totalEnrolled / $totalIntake) * 100, 1) : 0;

        // 3. Human Capital & SFR
        $facultyCount = Employee::where('employee_type', 'Faculty')->count();
        $staffCount = Employee::where('employee_type', 'Non-Teaching')->count();
        $sfr = $facultyCount > 0 ? round($totalEnrolled / $facultyCount, 1) : 0;

        // 4. Pending CapEx Requisitions
        $pendingRequisitions = PurchaseRequisition::with('department', 'requestedBy')
            ->where('status', 'Pending')
            ->latest()
            ->get();

        // 5. Academic Excellence & Reputation
        $accreditations = AccreditationRecord::all();
        $alumniHighlights = Alumnus::with('course')->latest()->take(5)->get();

        // 6. Strategic Expansion Projects (Upcoming B.Sc. Nursing & MBA)
        $strategicProjects = [
            [
                'title' => 'B.Sc. Nursing Program (100 Intake)',
                'regulatory_body' => 'Indian Nursing Council & MP State Allied Council',
                'status' => 'Inspection Scheduled',
                'progress_pct' => 75,
                'lead' => 'Dr. Amita Chaturvedi',
                'target_session' => 'Academic Year 2027-28',
                'notes' => 'Clinical training tie-up MOU signed with Seoni District Hospital. Skills lab equipment procured.',
            ],
            [
                'title' => 'MBA - Dual Specialization (60 Intake)',
                'regulatory_body' => 'AICTE & Raja Shankar Shah University',
                'status' => 'Application Under Review',
                'progress_pct' => 60,
                'lead' => 'Prof. S.K. Verma (Commerce & Management)',
                'target_session' => 'Academic Year 2027-28',
                'notes' => 'Dedicated computer lab & 1,500 management volumes earmarked in Central Library.',
            ],
            [
                'title' => 'Green Eco-Campus Solarization (15 kW)',
                'regulatory_body' => 'State Renewable Energy Dept',
                'status' => 'CapEx Approval Pending',
                'progress_pct' => 40,
                'lead' => 'Rameshwar Baghel (Campus Superintendent)',
                'target_session' => 'FY 2026-27',
                'notes' => 'Rooftop solar generation system to reduce campus grid electricity bills by 65%.',
            ],
        ];

        return view('portals.management', compact(
            'college',
            'campus',
            'totalFeeExpected',
            'totalFeeCollected',
            'totalOutstandingFee',
            'feeRecoveryRate',
            'totalIncome',
            'totalExpense',
            'netSurplus',
            'monthlyPayrollCost',
            'departmentBudgets',
            'courses',
            'totalIntake',
            'totalEnrolled',
            'capacityUtilization',
            'facultyCount',
            'staffCount',
            'sfr',
            'pendingRequisitions',
            'accreditations',
            'alumniHighlights',
            'strategicProjects'
        ));
    }

    public function approveRequisition(Request $request, PurchaseRequisition $requisition): RedirectResponse
    {
        $requisition->update([
            'status' => 'Approved',
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'CAPEX_APPROVED',
            'module' => 'Management Governance',
            'description' => 'Chairman approved CapEx Requisition #'.$requisition->req_no.' (₹'.number_format($requisition->estimated_cost).')',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('success', 'CapEx Requisition #'.$requisition->req_no.' has been approved by the Chairman & Governing Body.');
    }
}

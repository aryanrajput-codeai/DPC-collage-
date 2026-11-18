<?php

namespace Database\Seeders;

use App\Models\AcademicCalendar;
use App\Models\AcademicSession;
use App\Models\AcademicYear;
use App\Models\AccreditationRecord;
use App\Models\AdmissionApplication;
use App\Models\AdmissionEnquiry;
use App\Models\Alumnus;
use App\Models\Announcement;
use App\Models\AuditLog;
use App\Models\Campus;
use App\Models\CampusEvent;
use App\Models\Certificate;
use App\Models\ChartOfAccount;
use App\Models\ClassSection;
use App\Models\College;
use App\Models\Course;
use App\Models\Department;
use App\Models\DepartmentBudget;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeLeave;
use App\Models\Exam;
use App\Models\ExamMark;
use App\Models\ExamRegistration;
use App\Models\ExamSchedule;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\FinancialVoucher;
use App\Models\FinancialYear;
use App\Models\FixedAsset;
use App\Models\Grievance;
use App\Models\Hostel;
use App\Models\HostelActivity;
use App\Models\HostelAllocation;
use App\Models\HostelRoom;
use App\Models\InventoryItem;
use App\Models\LibraryBook;
use App\Models\LibraryIssue;
use App\Models\LmsAssignment;
use App\Models\LmsDiscussion;
use App\Models\LmsMaterial;
use App\Models\LmsSubmission;
use App\Models\NotificationLog;
use App\Models\Payroll;
use App\Models\Permission;
use App\Models\PlacementApplication;
use App\Models\PlacementCompany;
use App\Models\PlacementDrive;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequisition;
use App\Models\ResearchRecord;
use App\Models\Role;
use App\Models\SalaryStructure;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentFeeAccount;
use App\Models\StudentGuardian;
use App\Models\Subject;
use App\Models\SubjectAllocation;
use App\Models\SystemSetting;
use App\Models\TimetableSlot;
use App\Models\TransportAllocation;
use App\Models\TransportRoute;
use App\Models\TransportVehicle;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CollegeErpSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Campuses & Colleges
        $mainCampus = Campus::create([
            'code' => 'DPCC-MAIN',
            'name' => 'D.P. Chaturvedi College Eco-Campus (2 Acres)',
            'city' => 'Seoni',
            'state' => 'Madhya Pradesh',
            'address' => 'PWD Colony, Barapathar, Seoni, Madhya Pradesh - 480661',
            'phone' => '07692-226635',
            'email' => 'dpccollegeseoni@gmail.com',
        ]);

        $northCampus = Campus::create([
            'code' => 'DPCC-TEACH',
            'name' => 'DPCC Teacher Education & Sports Complex',
            'city' => 'Seoni',
            'state' => 'Madhya Pradesh',
            'address' => 'Barapathar Extension, Seoni, Madhya Pradesh - 480661',
            'phone' => '07692-226635',
            'email' => 'dpccollegeseoni@gmail.com',
        ]);

        $collegeTech = College::create([
            'campus_id' => $mainCampus->id,
            'code' => 'JS-499',
            'name' => 'D.P. Chaturvedi College (DPCC)',
            'university_affiliation' => 'Raja Shankar Shah University, Chhindwara (formerly RDVV)',
            'aishe_code' => 'JS-499',
            'naac_grade' => 'NAAC-Accredited',
            'principal_name' => 'Dr. Amita Chaturvedi (M.Sc., M.Ed., Ph.D.)',
        ]);

        $collegeArts = College::create([
            'campus_id' => $northCampus->id,
            'code' => 'NCTE-499',
            'name' => 'DPCC Institute of Teacher Education (NCTE)',
            'university_affiliation' => 'Raja Shankar Shah University & NCTE Recognized',
            'aishe_code' => 'JS-499-EDU',
            'naac_grade' => 'NAAC-Accredited',
            'principal_name' => 'Dr. K.K. Chaturvedi (Chairman & Founder)',
        ]);

        // 2. Academic & Financial Years
        $ay = AcademicYear::create([
            'name' => '2026-27',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_current' => true,
        ]);

        FinancialYear::create([
            'name' => 'FY 2026-27',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'is_current' => true,
        ]);

        $session = AcademicSession::create([
            'academic_year_id' => $ay->id,
            'name' => '2026-27 Odd Semester',
            'term' => 'Odd',
            'start_date' => '2026-07-15',
            'end_date' => '2026-12-20',
            'is_active' => true,
        ]);

        // 3. Roles & Permissions
        $roles = [];
        foreach ([
            ['super_admin', 'Super Administrator', 'Full ERP access across all campuses and modules'],
            ['faculty', 'Faculty / Professor', 'Teaching, attendance, marks entry, LMS and leave'],
            ['student', 'Student', 'Student portal, attendance, results, fees and LMS'],
            ['parent', 'Parent / Guardian', 'Parent portal for linked children tracking'],
            ['accountant', 'Finance & Accounts', 'Fees, vouchers, payroll and procurement'],
            ['librarian', 'Librarian', 'Library catalog, issue/return and stock verification'],
        ] as [$slug, $name, $desc]) {
            $roles[$slug] = Role::create(['slug' => $slug, 'name' => $name, 'description' => $desc]);
        }

        foreach (['admissions', 'students', 'academics', 'attendance', 'exams', 'library', 'fees', 'finance', 'hr', 'payroll', 'hostel', 'transport', 'lms', 'placement', 'compliance', 'settings'] as $mod) {
            $perm = Permission::create(['slug' => "manage.{$mod}", 'name' => 'Manage ' . ucfirst($mod), 'module' => ucfirst($mod)]);
            $roles['super_admin']->permissions()->attach($perm->id);
        }

        // 4. Demo Users
        $adminUser = User::create([
            'name' => 'Dr. Amita Chaturvedi (Principal)',
            'email' => 'admin@dpccollege.com',
            'password' => $password,
            'role_id' => $roles['super_admin']->id,
            'campus_id' => $mainCampus->id,
            'college_id' => $collegeTech->id,
            'phone' => '07692-226635',
        ]);

        $facultyUser = User::create([
            'name' => 'Prof. Rajesh Sharma (HOD Science)',
            'email' => 'faculty@dpccollege.com',
            'password' => $password,
            'role_id' => $roles['faculty']->id,
            'campus_id' => $mainCampus->id,
            'college_id' => $collegeTech->id,
            'phone' => '9425112233',
        ]);

        $studentUser = User::create([
            'name' => 'Aman Sahu (B.Sc. Maths - Rank Holder)',
            'email' => 'student@dpccollege.com',
            'password' => $password,
            'role_id' => $roles['student']->id,
            'campus_id' => $mainCampus->id,
            'college_id' => $collegeTech->id,
            'phone' => '9425998877',
        ]);

        $parentUser = User::create([
            'name' => 'Rameshwar Sahu',
            'email' => 'parent@dpccollege.com',
            'password' => $password,
            'role_id' => $roles['parent']->id,
            'campus_id' => $mainCampus->id,
            'college_id' => $collegeTech->id,
            'phone' => '9425887766',
        ]);

        // 5. Departments & Courses
        $deptCse = Department::create(['college_id' => $collegeTech->id, 'code' => 'SCI', 'name' => 'Department of Science & Mathematics', 'hod_name' => 'Prof. Rajesh Sharma']);
        $deptEce = Department::create(['college_id' => $collegeArts->id, 'code' => 'EDU', 'name' => 'Department of Teacher Education (NCTE)', 'hod_name' => 'Dr. K.K. Chaturvedi']);
        $deptCom = Department::create(['college_id' => $collegeTech->id, 'code' => 'COM', 'name' => 'Department of Commerce & Management', 'hod_name' => 'Prof. S.K. Verma']);
        $deptArts = Department::create(['college_id' => $collegeTech->id, 'code' => 'ARTS', 'name' => 'Department of Arts & Social Work', 'hod_name' => 'Dr. Sunita Baghel']);

        $courseBtech = Course::create([
            'department_id' => $deptCse->id,
            'code' => 'BSC-PCM',
            'name' => 'B.Sc. (Physics, Chemistry, Mathematics - NEP)',
            'level' => 'Undergraduate',
            'duration_years' => 3,
            'total_semesters' => 6,
            'total_credits' => 120,
            'intake_capacity' => 180,
            'cutoff_percentage' => 65.00,
        ]);

        $courseMtech = Course::create([
            'department_id' => $deptCse->id,
            'code' => 'MSC-PHY',
            'name' => 'M.Sc. Physics (Advanced Lab & Theory)',
            'level' => 'Postgraduate',
            'duration_years' => 2,
            'total_semesters' => 4,
            'total_credits' => 80,
            'intake_capacity' => 40,
            'cutoff_percentage' => 55.00,
        ]);

        $courseBcom = Course::create([
            'department_id' => $deptCom->id,
            'code' => 'BCOM-TAX',
            'name' => 'B.Com. (Computer Application & Taxation)',
            'level' => 'Undergraduate',
            'duration_years' => 3,
            'total_semesters' => 6,
            'total_credits' => 120,
            'intake_capacity' => 120,
            'cutoff_percentage' => 55.00,
        ]);

        $courseDiploma = Course::create([
            'department_id' => $deptEce->id,
            'code' => 'BED-NCTE',
            'name' => 'B.Ed. (Bachelor of Education - NCTE Recognized)',
            'level' => 'Undergraduate',
            'duration_years' => 2,
            'total_semesters' => 4,
            'total_credits' => 80,
            'intake_capacity' => 100,
            'cutoff_percentage' => 50.00,
        ]);

        Course::create([
            'department_id' => $deptEce->id,
            'code' => 'DED-NCTE',
            'name' => 'D.El.Ed. / D.Ed. (Diploma in Elementary Education)',
            'level' => 'Diploma',
            'duration_years' => 2,
            'total_semesters' => 4,
            'total_credits' => 80,
            'intake_capacity' => 50,
            'cutoff_percentage' => 50.00,
        ]);

        Course::create([
            'department_id' => $deptArts->id,
            'code' => 'MSW-SW',
            'name' => 'M.S.W. (Master of Social Work & Rural Development)',
            'level' => 'Postgraduate',
            'duration_years' => 2,
            'total_semesters' => 4,
            'total_credits' => 80,
            'intake_capacity' => 60,
            'cutoff_percentage' => 50.00,
        ]);

        // 6. Subjects & Academic Calendar
        $subDsa = Subject::create(['course_id' => $courseBtech->id, 'code' => 'PHY301', 'name' => 'Quantum Mechanics & Solid State Physics', 'semester' => 3, 'credits' => 4.0, 'subject_type' => 'Core', 'max_internal_marks' => 30, 'max_external_marks' => 70]);
        $subDbms = Subject::create(['course_id' => $courseBtech->id, 'code' => 'CHM302', 'name' => 'Physical & Inorganic Chemistry', 'semester' => 3, 'credits' => 4.0, 'subject_type' => 'Core', 'max_internal_marks' => 30, 'max_external_marks' => 70]);
        $subOs = Subject::create(['course_id' => $courseBtech->id, 'code' => 'MTH303', 'name' => 'Advanced Calculus & Differential Equations', 'semester' => 3, 'credits' => 3.0, 'subject_type' => 'Core', 'max_internal_marks' => 30, 'max_external_marks' => 70]);
        $subIks = Subject::create(['course_id' => $courseBtech->id, 'code' => 'NEP304', 'name' => 'Indian Knowledge Systems & Environmental Studies (NEP)', 'semester' => 3, 'credits' => 2.0, 'subject_type' => 'AECC', 'max_internal_marks' => 40, 'max_external_marks' => 60]);
        $subLab = Subject::create(['course_id' => $courseBtech->id, 'code' => 'SCI305L', 'name' => 'Advanced Science Laboratory Practical', 'semester' => 3, 'credits' => 2.0, 'subject_type' => 'Practical', 'max_internal_marks' => 50, 'max_external_marks' => 50]);

        AcademicCalendar::create(['academic_session_id' => $session->id, 'title' => 'Commencement of Odd Semester Classes', 'event_type' => 'Academic', 'start_date' => '2026-07-15']);
        AcademicCalendar::create(['academic_session_id' => $session->id, 'title' => 'Independence Day & Founder Day Celebrations', 'event_type' => 'Holiday', 'start_date' => '2026-08-15']);
        AcademicCalendar::create(['academic_session_id' => $session->id, 'title' => 'Continuous Comprehensive Evaluation (CCE) / Mid-Term', 'event_type' => 'Examination', 'start_date' => '2026-10-05', 'end_date' => '2026-10-12']);
        AcademicCalendar::create(['academic_session_id' => $session->id, 'title' => 'Raja Shankar Shah University End-Semester Theory Exams', 'event_type' => 'Examination', 'start_date' => '2026-11-25', 'end_date' => '2026-12-10']);

        // 7. Faculty & Staff + Salary & Payroll
        $fac1 = Employee::create([
            'user_id' => $facultyUser->id,
            'college_id' => $collegeTech->id,
            'department_id' => $deptCse->id,
            'staff_id' => 'DPCC-FAC-101',
            'full_name' => 'Prof. Rajesh Sharma',
            'email' => 'faculty@dpccollege.com',
            'phone' => '9425112233',
            'employee_type' => 'Faculty',
            'designation' => 'Associate Professor & HOD',
            'qualification' => 'M.Sc., Ph.D. (Physics)',
            'experience_years' => 14,
            'specialization' => 'Solid State Physics & Quantum Mechanics',
            'joining_date' => '2012-07-01',
            'basic_salary' => 68000,
            'bank_account_no' => '30124567890',
            'ifsc_code' => 'SBIN0000478',
            'pan_number' => 'ABCDE1234F',
            'uan_number' => '100987654321',
        ]);

        $fac2 = Employee::create([
            'college_id' => $collegeTech->id,
            'department_id' => $deptCse->id,
            'staff_id' => 'DPCC-FAC-102',
            'full_name' => 'Dr. Amita Chaturvedi',
            'email' => 'principal@dpccollege.com',
            'phone' => '07692-226635',
            'employee_type' => 'Faculty',
            'designation' => 'Principal & Senior Professor',
            'qualification' => 'M.Sc., M.Ed., Ph.D.',
            'experience_years' => 22,
            'specialization' => 'Science Pedagogy & Institutional Leadership',
            'joining_date' => '2000-08-01',
            'basic_salary' => 95000,
        ]);

        $fac3 = Employee::create([
            'college_id' => $collegeArts->id,
            'department_id' => $deptEce->id,
            'staff_id' => 'DPCC-FAC-103',
            'full_name' => 'Dr. Anita Tiwari',
            'email' => 'anita.tiwari@dpccollege.com',
            'phone' => '9425334455',
            'employee_type' => 'Faculty',
            'designation' => 'Professor (Teacher Education)',
            'qualification' => 'M.A., M.Ed., Ph.D. (NCTE Fellow)',
            'experience_years' => 16,
            'specialization' => 'Curriculum Design & Educational Psychology',
            'joining_date' => '2010-09-01',
            'basic_salary' => 85000,
        ]);

        $staff1 = Employee::create([
            'college_id' => $collegeTech->id,
            'department_id' => $deptCse->id,
            'staff_id' => 'DPCC-STF-201',
            'full_name' => 'Rameshwar Baghel',
            'email' => 'rameshwar.b@dpccollege.com',
            'phone' => '9425556677',
            'employee_type' => 'Non-Teaching',
            'designation' => 'Hostel Warden & Central Lab Superintendent',
            'qualification' => 'M.Sc. Chemistry',
            'experience_years' => 11,
            'joining_date' => '2015-02-15',
            'basic_salary' => 38000,
        ]);

        foreach ([$fac1, $fac2, $fac3, $staff1] as $emp) {
            $hra = round($emp->basic_salary * 0.20, 2);
            $da = round($emp->basic_salary * 0.15, 2);
            $ta = 3200;
            $gross = $emp->basic_salary + $hra + $da + $ta;
            $pf = round($emp->basic_salary * 0.12, 2);
            $pt = 200;
            $tds = $gross > 80000 ? 4500 : 1200;

            SalaryStructure::create([
                'employee_id' => $emp->id,
                'basic_salary' => $emp->basic_salary,
                'hra' => $hra,
                'da' => $da,
                'ta' => $ta,
                'special_allowance' => 0,
                'pf_enabled' => true,
                'esi_enabled' => $gross <= 21000,
                'pt_enabled' => true,
                'tds_monthly' => $tds,
            ]);

            Payroll::create([
                'employee_id' => $emp->id,
                'month' => 10,
                'year' => 2026,
                'working_days' => 26,
                'leave_deduction_days' => 0,
                'gross_salary' => $gross,
                'pf_amount' => $pf,
                'esi_amount' => 0,
                'professional_tax' => $pt,
                'tds_amount' => $tds,
                'net_salary' => $gross - $pf - $pt - $tds,
                'status' => 'Paid',
                'paid_at' => '2026-10-31',
                'bank_ref' => 'NEFT-OCT26-' . $emp->id . '99',
            ]);

            EmployeeAttendance::create([
                'employee_id' => $emp->id,
                'attendance_date' => now()->toDateString(),
                'check_in' => '09:05:00',
                'check_out' => '17:15:00',
                'status' => 'Present',
                'method' => 'Biometric',
            ]);
        }

        EmployeeLeave::create([
            'employee_id' => $fac1->id,
            'leave_type' => 'Casual',
            'from_date' => now()->addDays(5)->toDateString(),
            'to_date' => now()->addDays(6)->toDateString(),
            'days' => 2,
            'reason' => 'Attending IEEE Conference in Hyderabad',
            'status' => 'Pending',
        ]);

        // 8. Class Sections, Subject Allocations & Timetable
        $secA = ClassSection::create(['course_id' => $courseBtech->id, 'semester' => 3, 'section_name' => 'A', 'room_no' => 'CS-301', 'class_teacher_id' => $fac1->id]);
        $secB = ClassSection::create(['course_id' => $courseBcom->id, 'semester' => 1, 'section_name' => 'A', 'room_no' => 'CM-101', 'class_teacher_id' => $fac2->id]);

        SubjectAllocation::create(['academic_session_id' => $session->id, 'class_section_id' => $secA->id, 'subject_id' => $subDsa->id, 'faculty_id' => $fac2->id]);
        SubjectAllocation::create(['academic_session_id' => $session->id, 'class_section_id' => $secA->id, 'subject_id' => $subDbms->id, 'faculty_id' => $fac1->id]);
        SubjectAllocation::create(['academic_session_id' => $session->id, 'class_section_id' => $secA->id, 'subject_id' => $subLab->id, 'faculty_id' => $fac1->id]);

        TimetableSlot::create(['class_section_id' => $secA->id, 'subject_id' => $subDsa->id, 'faculty_id' => $fac2->id, 'day_of_week' => 'Monday', 'start_time' => '09:30:00', 'end_time' => '10:30:00', 'room_no' => 'CS-301', 'slot_type' => 'Lecture']);
        TimetableSlot::create(['class_section_id' => $secA->id, 'subject_id' => $subDbms->id, 'faculty_id' => $fac1->id, 'day_of_week' => 'Monday', 'start_time' => '10:45:00', 'end_time' => '11:45:00', 'room_no' => 'CS-301', 'slot_type' => 'Lecture']);
        TimetableSlot::create(['class_section_id' => $secA->id, 'subject_id' => $subLab->id, 'faculty_id' => $fac1->id, 'day_of_week' => 'Tuesday', 'start_time' => '14:00:00', 'end_time' => '16:00:00', 'room_no' => 'LAB-02', 'slot_type' => 'Lab']);
        TimetableSlot::create(['class_section_id' => $secA->id, 'subject_id' => $subOs->id, 'faculty_id' => $fac3->id, 'day_of_week' => 'Wednesday', 'start_time' => '09:30:00', 'end_time' => '10:30:00', 'room_no' => 'CS-301', 'slot_type' => 'Lecture']);

        // 9. Students & Guardians
        $studentsData = [
            ['Aman Sahu', 'student@dpccollege.com', '9425998877', 'Male', 'OBC', 'DPCC26BSC01', 'ADM-2026-001', 'RSSU24S001', $studentUser->id],
            ['Pooja Baghel', 'pooja.b@dpccollege.com', '9425998878', 'Female', 'General', 'DPCC26BSC02', 'ADM-2026-002', 'RSSU24S002', null],
            ['Rohit Verma', 'rohit.v@dpccollege.com', '9425998879', 'Male', 'SC', 'DPCC26BSC03', 'ADM-2026-003', 'RSSU24S003', null],
            ['Sneha Tiwari', 'sneha.t@dpccollege.com', '9425998880', 'Female', 'General', 'DPCC26BED01', 'ADM-2026-004', 'RSSU24E001', null],
            ['Karan Sanodiya', 'karan.s@dpccollege.com', '9425998881', 'Male', 'OBC', 'DPCC26COM01', 'ADM-2026-005', 'RSSU24C001', null],
            ['Anjali Uikey', 'anjali.u@dpccollege.com', '9425998882', 'Female', 'ST', 'DPCC26BSC04', 'ADM-2026-006', 'RSSU24S004', null],
        ];

        $students = [];
        foreach ($studentsData as $idx => $sd) {
            $stu = Student::create([
                'user_id' => $sd[8],
                'college_id' => $collegeTech->id,
                'department_id' => $deptCse->id,
                'course_id' => $courseBtech->id,
                'current_semester' => 3,
                'class_section_id' => $secA->id,
                'unique_student_id' => $sd[5],
                'admission_number' => $sd[6],
                'registration_number' => $sd[7],
                'roll_number' => 'CS-0' . ($idx + 1),
                'full_name' => $sd[0],
                'email' => $sd[1],
                'phone' => $sd[2],
                'dob' => '2006-05-1' . ($idx + 1),
                'gender' => $sd[3],
                'blood_group' => 'O+',
                'category' => $sd[4],
                'aadhaar_last4' => '432' . $idx,
                'permanent_address' => 'Bengaluru, Karnataka',
                'emergency_contact_name' => 'Suresh ' . explode(' ', $sd[0])[1] ?? 'Parent',
                'emergency_contact_phone' => '984509988' . $idx,
                'admission_date' => '2025-08-01',
                'status' => 'Active',
            ]);
            $students[] = $stu;

            StudentGuardian::create([
                'student_id' => $stu->id,
                'parent_user_id' => $idx === 0 ? $parentUser->id : null,
                'relation' => 'Father',
                'name' => $idx === 0 ? 'Suresh Kulkarni' : 'Mr. ' . $sd[0] . ' Sr.',
                'phone' => '984509988' . $idx,
                'email' => $idx === 0 ? 'parent@webotapp.edu.in' : null,
                'occupation' => 'Engineer',
                'annual_income' => 850000,
            ]);
        }

        // Student Attendance (make student[2] have low attendance < 75%)
        for ($d = 0; $d < 10; $d++) {
            $date = now()->subDays($d)->toDateString();
            foreach ($students as $idx => $stu) {
                $status = ($idx === 2 && $d < 5) ? 'Absent' : (($d === 0 && $idx === 1) ? 'Late' : 'Present');
                StudentAttendance::create([
                    'student_id' => $stu->id,
                    'subject_id' => $subDbms->id,
                    'class_section_id' => $secA->id,
                    'attendance_date' => $date,
                    'status' => $status,
                    'method' => $d % 2 === 0 ? 'QR' : 'Manual',
                    'marked_by' => $facultyUser->id,
                ]);
            }
        }

        // 10. Enquiries & Online Admission Applications
        AdmissionEnquiry::create([
            'enquiry_no' => 'ENQ-2026-001',
            'student_name' => 'Siddharth Malhotra',
            'phone' => '9811223344',
            'email' => 'siddharth@example.com',
            'source' => 'Online',
            'campaign_name' => 'JEE Mains 2026 Drive',
            'course_id' => $courseBtech->id,
            'counsellor_id' => $adminUser->id,
            'status' => 'Follow-up',
            'next_followup_date' => now()->addDays(2)->toDateString(),
            'notes' => 'Interested in CSE with hostel facility.',
        ]);

        AdmissionEnquiry::create([
            'enquiry_no' => 'ENQ-2026-002',
            'student_name' => 'Meera Krishnan',
            'phone' => '9811223355',
            'source' => 'Walk-in',
            'course_id' => $courseMtech->id,
            'counsellor_id' => $adminUser->id,
            'status' => 'Converted',
            'notes' => 'GATE qualified, applied online.',
        ]);

        AdmissionApplication::create([
            'application_no' => 'APP-2026-1001',
            'academic_session_id' => $session->id,
            'course_id' => $courseBtech->id,
            'full_name' => 'Ishaan Chatterjee',
            'email' => 'ishaan.c@example.com',
            'phone' => '9876543210',
            'dob' => '2008-03-14',
            'gender' => 'Male',
            'category' => 'General',
            'aadhaar_number' => '123456789012',
            'aadhaar_consent' => true,
            'father_name' => 'Subhash Chatterjee',
            'class_10_board' => 'CBSE',
            'class_10_percentage' => 94.20,
            'class_12_board' => 'CBSE',
            'class_12_percentage' => 91.50,
            'entrance_exam_name' => 'KCET / JEE',
            'entrance_score' => 89.40,
            'merit_score' => 90.45,
            'application_fee_status' => 'Paid',
            'payment_txn_id' => 'RZP_TXN_998877',
            'status' => 'Verified',
        ]);

        AdmissionApplication::create([
            'application_no' => 'APP-2026-1002',
            'academic_session_id' => $session->id,
            'course_id' => $courseBtech->id,
            'full_name' => 'Neha Gupta',
            'email' => 'neha.g@example.com',
            'phone' => '9876543211',
            'dob' => '2008-07-21',
            'gender' => 'Female',
            'category' => 'EWS',
            'class_10_board' => 'ICSE',
            'class_10_percentage' => 92.00,
            'class_12_board' => 'ISC',
            'class_12_percentage' => 88.60,
            'entrance_exam_name' => 'JEE Main',
            'entrance_score' => 85.00,
            'merit_score' => 86.80,
            'application_fee_status' => 'Paid',
            'payment_txn_id' => 'RZP_TXN_998878',
            'status' => 'Submitted',
        ]);

        // 11. Examinations & Marks
        $exam = Exam::create([
            'name' => 'Odd Semester End-Term Exam Nov 2026',
            'exam_type' => 'End-Semester',
            'academic_session_id' => $session->id,
            'course_id' => $courseBtech->id,
            'semester' => 3,
            'start_date' => '2026-11-25',
            'end_date' => '2026-12-05',
            'is_published' => true,
        ]);

        ExamSchedule::create(['exam_id' => $exam->id, 'subject_id' => $subDsa->id, 'exam_date' => '2026-11-25', 'start_time' => '10:00:00', 'end_time' => '13:00:00', 'room_no' => 'HALL-A', 'invigilator_id' => $fac2->id]);
        ExamSchedule::create(['exam_id' => $exam->id, 'subject_id' => $subDbms->id, 'exam_date' => '2026-11-27', 'start_time' => '10:00:00', 'end_time' => '13:00:00', 'room_no' => 'HALL-A', 'invigilator_id' => $fac1->id]);

        foreach ($students as $idx => $stu) {
            ExamRegistration::create([
                'exam_id' => $exam->id,
                'student_id' => $stu->id,
                'seat_no' => 'SEAT-30' . ($idx + 1),
                'admit_card_number' => 'ADM-NOV26-00' . ($idx + 1),
                'is_eligible' => $idx !== 2,
            ]);

            foreach ([$subDsa, $subDbms, $subIks] as $sIdx => $subj) {
                $int = 24 + (($idx + $sIdx) % 5);
                $ext = 52 + (($idx * 3 + $sIdx * 4) % 18);
                $tot = $int + $ext;
                $gp = $tot >= 90 ? 10 : ($tot >= 80 ? 9 : ($tot >= 70 ? 8 : 7));
                $grade = $tot >= 90 ? 'O' : ($tot >= 80 ? 'A+' : ($tot >= 70 ? 'A' : 'B+'));
                ExamMark::create([
                    'exam_id' => $exam->id,
                    'subject_id' => $subj->id,
                    'student_id' => $stu->id,
                    'internal_marks' => $int,
                    'external_marks' => $ext,
                    'total_marks' => $tot,
                    'grade' => $grade,
                    'grade_point' => $gp,
                    'credits' => $subj->credits,
                    'result_status' => 'Pass',
                    'is_verified' => true,
                ]);
            }
        }

        // 12. Library Books & Issues
        $book1 = LibraryBook::create(['isbn' => '978-0262046305', 'accession_no' => 'ACC-1001', 'barcode' => 'LIB1001', 'title' => 'Introduction to Algorithms (CLRS)', 'author' => 'Thomas H. Cormen', 'publisher' => 'MIT Press', 'subject_category' => 'Computer Science', 'rack_location' => 'R1-A2', 'total_copies' => 10, 'available_copies' => 8]);
        $book2 = LibraryBook::create(['isbn' => '978-0078022159', 'accession_no' => 'ACC-1002', 'barcode' => 'LIB1002', 'title' => 'Database System Concepts', 'author' => 'Silberschatz, Korth', 'publisher' => 'McGraw Hill', 'subject_category' => 'Database', 'rack_location' => 'R1-B4', 'total_copies' => 8, 'available_copies' => 7]);
        LibraryBook::create(['isbn' => '978-0134685991', 'accession_no' => 'ACC-1003', 'barcode' => 'LIB1003', 'title' => 'Effective Java', 'author' => 'Joshua Bloch', 'publisher' => 'Addison-Wesley', 'subject_category' => 'Programming', 'rack_location' => 'R2-C1', 'book_type' => 'E-Book', 'ebook_url' => 'https://library.webotapp.edu.in/ebooks/effective-java.pdf', 'total_copies' => 1, 'available_copies' => 1]);

        LibraryIssue::create([
            'library_book_id' => $book1->id,
            'user_id' => $studentUser->id,
            'member_type' => 'Student',
            'issue_date' => now()->subDays(20)->toDateString(),
            'due_date' => now()->subDays(6)->toDateString(),
            'status' => 'Overdue',
            'fine_amount' => 30.00,
        ]);

        // 13. Fees & Student Accounts + College Finance
        $feeStruct = FeeStructure::create([
            'course_id' => $courseBtech->id,
            'semester' => 3,
            'category' => 'All',
            'admission_fee' => 0,
            'tuition_fee' => 55000,
            'exam_fee' => 2500,
            'library_fee' => 1500,
            'lab_fee' => 4000,
            'misc_fee' => 2000,
            'total_fee' => 65000,
        ]);

        foreach ($students as $idx => $stu) {
            $paid = $idx < 3 ? 65000 : 35000;
            $acc = StudentFeeAccount::create([
                'student_id' => $stu->id,
                'fee_structure_id' => $feeStruct->id,
                'academic_session_id' => $session->id,
                'total_amount' => 65000,
                'concession_amount' => $stu->category === 'SC' ? 15000 : 0,
                'paid_amount' => $paid,
                'balance_amount' => max(0, 65000 - ($stu->category === 'SC' ? 15000 : 0) - $paid),
                'due_date' => '2026-11-30',
                'status' => $paid >= 65000 ? 'Paid' : 'Partial',
            ]);

            FeePayment::create([
                'student_fee_account_id' => $acc->id,
                'student_id' => $stu->id,
                'receipt_no' => 'RCPT-2026-00' . ($idx + 1),
                'amount' => $paid,
                'payment_mode' => $idx % 2 === 0 ? 'UPI' : 'NetBanking',
                'transaction_ref' => 'UPI' . rand(10000000, 99999999),
                'payment_date' => now()->subDays(15 - $idx)->toDateString(),
                'status' => 'Completed',
            ]);
        }

        $coaBank = ChartOfAccount::create(['code' => '1002', 'name' => 'SBI Main College Account', 'account_type' => 'Asset', 'balance' => 4850000]);
        $coaCash = ChartOfAccount::create(['code' => '1001', 'name' => 'Cash in Hand', 'account_type' => 'Asset', 'balance' => 125000]);
        $coaTuition = ChartOfAccount::create(['code' => '4001', 'name' => 'Tuition Fee Income', 'account_type' => 'Income', 'balance' => 3200000]);
        $coaSalary = ChartOfAccount::create(['code' => '5001', 'name' => 'Faculty & Staff Salaries', 'account_type' => 'Expense', 'balance' => 1850000]);
        $coaLabExp = ChartOfAccount::create(['code' => '5002', 'name' => 'Laboratory Consumables & Maintenance', 'account_type' => 'Expense', 'balance' => 240000]);

        FinancialVoucher::create([
            'voucher_no' => 'VCH-2026-001',
            'voucher_type' => 'Receipt',
            'voucher_date' => now()->subDays(5)->toDateString(),
            'debit_account_id' => $coaBank->id,
            'credit_account_id' => $coaTuition->id,
            'amount' => 320000,
            'department_id' => $deptCse->id,
            'narration' => 'B.Tech Sem 3 Tuition Fee Batch Settlement',
            'created_by' => $adminUser->id,
        ]);

        FinancialVoucher::create([
            'voucher_no' => 'VCH-2026-002',
            'voucher_type' => 'Payment',
            'voucher_date' => now()->subDays(2)->toDateString(),
            'debit_account_id' => $coaLabExp->id,
            'credit_account_id' => $coaBank->id,
            'amount' => 45000,
            'gst_amount' => 8100,
            'tds_amount' => 900,
            'department_id' => $deptCse->id,
            'narration' => 'Networking Switches & Lab Maintenance',
            'created_by' => $adminUser->id,
        ]);

        DepartmentBudget::create(['department_id' => $deptCse->id, 'financial_year' => 'FY 2026-27', 'allocated_amount' => 1500000, 'utilized_amount' => 485000]);
        DepartmentBudget::create(['department_id' => $deptEce->id, 'financial_year' => 'FY 2026-27', 'allocated_amount' => 1200000, 'utilized_amount' => 310000]);

        FixedAsset::create(['asset_code' => 'FA-CSE-01', 'name' => 'HP ProLiant Campus Server', 'category' => 'IT Infrastructure', 'department_id' => $deptCse->id, 'purchase_date' => '2025-04-10', 'purchase_cost' => 450000, 'depreciation_rate' => 15, 'current_value' => 382500]);

        $vendor = Vendor::create(['name' => 'TechBridge India Pvt Ltd', 'gstin' => '29AABCT1234F1Z5', 'pan' => 'AABCT1234F', 'contact_person' => 'Arun Kumar', 'phone' => '9880011223', 'email' => 'sales@techbridge.in', 'category' => 'IT & Lab Equipment']);
        $req = PurchaseRequisition::create(['req_no' => 'PR-2026-001', 'department_id' => $deptCse->id, 'requested_by' => $facultyUser->id, 'item_description' => '30x Dell OptiPlex Workstations for AI Lab', 'quantity' => 30, 'estimated_cost' => 1650000, 'status' => 'PO Created']);
        PurchaseOrder::create(['po_no' => 'PO-2026-001', 'vendor_id' => $vendor->id, 'purchase_requisition_id' => $req->id, 'order_date' => now()->subDays(7)->toDateString(), 'total_amount' => 1620000, 'status' => 'Ordered']);
        InventoryItem::create(['item_code' => 'INV-LAB-01', 'name' => 'Digital Oscilloscope 100MHz', 'category' => 'Lab Equipment', 'department_id' => $deptEce->id, 'quantity' => 18, 'unit' => 'Units', 'reorder_level' => 5]);

        // 14. Hostel & Transport
        $hostelBoys = Hostel::create(['name' => 'Vivekananda Boys Hostel (DPCC Campus)', 'type' => 'Boys', 'warden_id' => $staff1->id, 'total_rooms' => 60, 'capacity' => 180, 'monthly_fee' => 4500, 'mess_fee' => 3500]);
        Hostel::create(['name' => 'Sarojini Devi Girls Hostel (Barapathar)', 'type' => 'Girls', 'warden_id' => $fac1->id, 'total_rooms' => 50, 'capacity' => 150, 'monthly_fee' => 4500, 'mess_fee' => 3500]);

        $room101 = HostelRoom::create(['hostel_id' => $hostelBoys->id, 'floor' => '1st Floor', 'room_no' => 'B-101', 'capacity' => 3, 'occupied_beds' => 1, 'room_type' => 'Triple']);
        HostelAllocation::create(['hostel_id' => $hostelBoys->id, 'hostel_room_id' => $room101->id, 'student_id' => $students[0]->id, 'bed_no' => 'B1', 'check_in_date' => '2026-07-15']);
        HostelActivity::create(['hostel_id' => $hostelBoys->id, 'student_id' => $students[0]->id, 'activity_type' => 'Outing Request', 'title' => 'Weekend Home Visit to Lakhnadon', 'details' => 'Leaving Friday 5 PM, returning Sunday 8 PM.', 'status' => 'Approved']);

        $bus1 = TransportVehicle::create(['registration_no' => 'MP-28-E-1999', 'vehicle_type' => 'Bus', 'capacity' => 52, 'driver_name' => 'Rameshwar Yadav', 'driver_phone' => '9425114422', 'driver_license' => 'MP28-20150045678', 'gps_device_id' => 'GPS-DPCC-BUS-01', 'last_fuel_liters' => 120]);
        $route1 = TransportRoute::create(['route_name' => 'Route 1: Lakhnadon - Chhapara - Barapathar DPCC Campus', 'transport_vehicle_id' => $bus1->id, 'stops_json' => ['Lakhnadon Bus Stand', 'Ghansor Tiraha', 'Chhapara', 'Barapathar PWD Colony', 'DPCC Campus'], 'monthly_fee' => 1800]);
        TransportAllocation::create(['transport_route_id' => $route1->id, 'student_id' => $students[1]->id, 'pickup_stop' => 'Chhapara', 'start_date' => '2026-07-15']);

        // 15. LMS
        LmsMaterial::create(['subject_id' => $subDbms->id, 'faculty_id' => $fac1->id, 'title' => 'Unit 1: Quantum Mechanics & Wave Equations Notes', 'material_type' => 'PDF', 'file_url' => 'https://lms.dpccollege.com/physics-unit1.pdf', 'description' => 'Comprehensive lecture notes aligned with Raja Shankar Shah University curriculum.']);
        $assign = LmsAssignment::create(['subject_id' => $subDbms->id, 'faculty_id' => $fac1->id, 'title' => 'Assignment 1: Solve Schrödinger Wave Equations for 1D Box', 'description' => 'Submit derivations and boundary condition notes.', 'due_date' => now()->addDays(7)->toDateString(), 'max_marks' => 20]);
        LmsSubmission::create(['lms_assignment_id' => $assign->id, 'student_id' => $students[0]->id, 'submission_url' => 'https://lms.dpccollege.com/submissions/aman-phy.pdf', 'submission_notes' => 'Completed all 4 derivations.', 'submitted_at' => now(), 'marks_obtained' => 19, 'feedback' => 'Excellent mathematical derivation.']);
        LmsDiscussion::create(['subject_id' => $subDbms->id, 'user_id' => $studentUser->id, 'topic' => 'Applications of Solid State Physics in Modern Electronics', 'message' => 'Discussion on semiconductor lattice structures and energy band gaps.']);

        // 16. Placements & Career Cell
        $comp1 = PlacementCompany::create(['name' => 'TCS Smart Hiring / Wipro Campus', 'industry' => 'IT & Software', 'hr_name' => 'Divya Sharma', 'hr_email' => 'campus@tcs.com', 'hr_phone' => '022-67789999']);
        $comp2 = PlacementCompany::create(['name' => 'HDFC Bank & Regional Co-operatives', 'industry' => 'Banking & Finance', 'hr_name' => 'Karan Mehta', 'hr_email' => 'careers@hdfcbank.com', 'hr_phone' => '0755-4567890']);
        $drive1 = PlacementDrive::create(['placement_company_id' => $comp1->id, 'job_title' => 'Graduate Trainee / Junior Analyst', 'package_lpa' => 4.50, 'eligibility_cgpa' => 6.50, 'drive_date' => now()->addDays(15)->toDateString(), 'drive_type' => 'Full-Time', 'status' => 'Upcoming']);
        $drive2 = PlacementDrive::create(['placement_company_id' => $comp2->id, 'job_title' => 'Accounts Executive & Branch Assistant', 'package_lpa' => 3.80, 'eligibility_cgpa' => 6.00, 'drive_date' => now()->addDays(22)->toDateString(), 'drive_type' => 'Full-Time', 'status' => 'Upcoming']);
        PlacementApplication::create(['placement_drive_id' => $drive1->id, 'student_id' => $students[0]->id, 'aptitude_score' => 88, 'status' => 'Shortlisted']);
        PlacementApplication::create(['placement_drive_id' => $drive2->id, 'student_id' => $students[1]->id, 'aptitude_score' => 92, 'status' => 'Selected']);

        // 17. Scholarships, Certificates, Grievances, Events, Alumni
        $sch1 = Scholarship::create(['name' => 'MP Post-Matric SC/ST/OBC Scholarship Scheme', 'scheme_type' => 'Government', 'amount' => 22000, 'eligibility_criteria' => 'MP Domicile SC/ST/OBC category through MP e-Pravesh portal', 'academic_session_id' => $session->id]);
        $sch2 = Scholarship::create(['name' => 'Dr. K.K. Chaturvedi Merit Excellence Award', 'scheme_type' => 'Merit', 'amount' => 15000, 'eligibility_criteria' => 'University Rank Holder / Gold Medal Track (CGPA >= 8.5)', 'academic_session_id' => $session->id]);
        ScholarshipApplication::create(['scholarship_id' => $sch1->id, 'student_id' => $students[3]->id, 'status' => 'Approved', 'disbursed_amount' => 22000, 'disbursed_at' => now()->subDays(10)->toDateString()]);
        ScholarshipApplication::create(['scholarship_id' => $sch2->id, 'student_id' => $students[0]->id, 'status' => 'Verified']);

        Certificate::create([
            'certificate_no' => 'DPCC-BON-2026-001',
            'student_id' => $students[0]->id,
            'certificate_type' => 'Bonafide',
            'issue_date' => now()->toDateString(),
            'status' => 'Issued',
            'verification_token' => Str::random(32),
            'remarks' => 'Issued for Higher Education / Govt Exam Verification',
        ]);

        Grievance::create([
            'ticket_no' => 'GRV-DPCC-001',
            'student_id' => $students[0]->id,
            'category' => 'Academic',
            'is_confidential' => false,
            'subject' => 'Additional reference copies for M.Sc. Physics lab',
            'description' => 'Requesting extra copies of Quantum Mechanics reference volumes.',
            'assigned_to' => $adminUser->id,
            'status' => 'Under Review',
        ]);

        CampusEvent::create(['title' => 'DPCC Annual Science Exhibition & Gold Medalist Felicitation', 'category' => 'Annual Fest', 'event_date' => now()->addDays(12)->toDateString(), 'venue' => 'DPCC Main Auditorium, Barapathar', 'budget' => 75000, 'department_id' => $deptCse->id, 'status' => 'Planned']);
        Alumnus::create(['full_name' => 'Sunil Verma (Batch 2018 - University Gold Medalist)', 'email' => 'sunil.alumni@dpccollege.com', 'phone' => '9425094250', 'graduation_year' => 2018, 'course_id' => $courseBtech->id, 'current_company' => 'MP Higher Education Dept', 'designation' => 'Assistant Professor', 'city' => 'Jabalpur', 'is_mentor' => true, 'donation_total' => 25000]);

        // 18. Accreditation (NAAC/NIRF/AISHE) & Research
        AccreditationRecord::create(['framework' => 'NAAC', 'cycle_year' => '2026-27', 'criterion' => 'Criterion 1: Curricular Aspects & NEP 2020', 'metric_code' => '1.1.1', 'title' => 'Affiliation with Raja Shankar Shah University, Chhindwara', 'score_or_value' => 'NAAC-Accredited Status', 'department_id' => $deptCse->id, 'status' => 'Verified']);
        AccreditationRecord::create(['framework' => 'IQAC', 'cycle_year' => '2026', 'criterion' => 'Teacher Education & NCTE Compliance', 'metric_code' => 'NCTE-WRC-BED', 'title' => 'B.Ed. & D.El.Ed. Regulatory Recognition & Inspection', 'score_or_value' => 'NCTE Recognized (100 Intake)', 'status' => 'Approved']);
        AccreditationRecord::create(['framework' => 'AISHE', 'cycle_year' => '2025-26', 'criterion' => 'DCF-II Institutional Data', 'metric_code' => 'JS-499', 'title' => 'Annual AISHE Data Submission (Code: JS-499)', 'score_or_value' => 'Uploaded & Certified', 'status' => 'Approved']);

        ResearchRecord::create(['record_type' => 'Faculty Publication', 'title' => 'Pedagogical Interventions in Rural Higher Education: A Study of Seoni District', 'lead_name' => 'Dr. Amita Chaturvedi', 'department_id' => $deptCse->id, 'year' => 2025, 'status' => 'Published']);
        ResearchRecord::create(['record_type' => 'Research Grant', 'title' => 'Biodiversity Assessment of Pench Corridor (Seoni Region)', 'lead_name' => 'Prof. Rajesh Sharma', 'department_id' => $deptCse->id, 'funding_agency' => 'State Biodiversity Board, MP', 'grant_amount' => 350000, 'year' => 2026, 'status' => 'Ongoing']);

        // 19. Announcements, Notification Logs, Audit Logs & System Settings
        Announcement::create(['title' => 'Raja Shankar Shah University Exam Form Submission', 'message' => 'Students of B.Sc., B.Com., B.Ed., and M.Sc. are informed that Odd Semester University Exam forms are open on MP Online.', 'target_audience' => 'All', 'channel' => 'Portal', 'published_at' => now(), 'created_by' => $adminUser->id]);
        Announcement::create(['title' => 'Bus Pass Renewal for Lakhnadon, Keolari & Barghat Routes', 'message' => 'Students availing college transport are requested to renew their bus passes at the administrative office.', 'target_audience' => 'Students', 'channel' => 'WhatsApp', 'published_at' => now(), 'created_by' => $adminUser->id]);

        NotificationLog::create(['recipient_name' => 'Aman Sahu', 'recipient_contact' => '9425998877', 'channel' => 'WhatsApp', 'subject' => 'DPCC Admit Card Generated', 'message' => 'Your University Exam Admit Card is ready in DPCC Student Portal.', 'status' => 'Sent', 'sent_at' => now()]);
        AuditLog::create(['user_id' => $adminUser->id, 'action' => 'SEED_INITIALIZED', 'module' => 'System', 'description' => 'Configured ERP System for D.P. Chaturvedi College (DPCC), Seoni (Code: JS-499).', 'ip_address' => '127.0.0.1']);

        SystemSetting::create(['group_name' => 'general', 'key' => 'institution_name', 'value' => 'D.P. Chaturvedi College (DPCC), Seoni']);
        SystemSetting::create(['group_name' => 'grading', 'key' => 'grading_scale', 'value' => json_encode(['O' => 10, 'A+' => 9, 'A' => 8, 'B+' => 7, 'B' => 6, 'C' => 5, 'F' => 0])]);
        SystemSetting::create(['group_name' => 'integrations', 'key' => 'payment_gateway', 'value' => 'Razorpay & MP Online UPI']);
        SystemSetting::create(['group_name' => 'integrations', 'key' => 'whatsapp_provider', 'value' => 'Meta WhatsApp Business Cloud API']);
    }
}

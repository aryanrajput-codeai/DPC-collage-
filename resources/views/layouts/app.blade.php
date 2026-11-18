<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DPCC ERP') — D.P. Chaturvedi College, Seoni (MP)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
            .print-full { width: 100% !important; margin: 0 !important; padding: 0 !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="no-print w-64 bg-[#190528] text-slate-200 border-r border-[#3e0b57] flex-shrink-0 flex flex-col">
        <div class="px-5 py-4 border-b border-[#3e0b57] flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#fbbf24] via-[#f59e0b] to-[#d97706] flex items-center justify-center font-extrabold text-[#190528] text-sm shadow-md">DP</span>
                <div>
                    <div class="text-sm font-bold tracking-tight text-white leading-tight">DPCC <span class="text-xs font-semibold text-[#fbbf24]">ERP</span></div>
                    <div class="text-[10px] text-[#fef3c7]/75">D.P. Chaturvedi College &bull; JS-499</div>
                </div>
            </div>
        </div>

        @php($roleSlug = auth()->user()->role?->slug)
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-5 text-sm">
            @if($roleSlug === 'management')
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24] mb-1.5 flex items-center justify-between">
                    <span>Executive Board</span>
                    <span class="text-[9px] bg-amber-400 text-slate-900 px-1 py-0.2 rounded font-black">GOV</span>
                </div>
                <a href="{{ route('management.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg {{ request()->routeIs('management.dashboard') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Chairman Overview</a>
            </div>

            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24]/80 mb-1.5">Solvency & Fiscal Audit</div>
                <a href="{{ route('fees.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('fees.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Student Fee Collections</a>
                <a href="{{ route('finance.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('finance.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Accounts & Vouchers</a>
                <a href="{{ route('procurement.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('procurement.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">CapEx & Requisitions</a>
                <a href="{{ route('payroll.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('payroll.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Payroll & Remittances</a>
            </div>

            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24]/80 mb-1.5">Academic & Accreditations</div>
                <a href="{{ route('academics.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('academics.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Courses & Seat Matrix</a>
                <a href="{{ route('community.accreditation_research') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('community.accreditation_research') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">NAAC / NCTE & Grants</a>
                <a href="{{ route('community.events_alumni') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('community.events_alumni') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">8,500+ Alumni Network</a>
                <a href="{{ route('grievances.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('grievances.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Grievance & Legal Audit</a>
            </div>
            @endif

            @if($roleSlug === 'super_admin')
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24]/80 mb-1.5">Overview</div>
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Principal Dashboard</a>
                <a href="{{ route('management.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg {{ request()->routeIs('management.dashboard') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Chairman Hub</a>
            </div>

            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24]/80 mb-1.5">Admissions & SIS</div>
                <a href="{{ route('admissions.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('admissions.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Online Admissions</a>
                <a href="{{ route('enquiries.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('enquiries.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Enquiry & CRM</a>
                <a href="{{ route('students.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('students.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Student Info (SIS)</a>
            </div>
            @endif

            @if(in_array($roleSlug, ['super_admin', 'faculty'], true))
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24]/80 mb-1.5">Academics & Exams</div>
                @if($roleSlug === 'super_admin')
                <a href="{{ route('academics.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('academics.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Courses & NEP 2020</a>
                @endif
                <a href="{{ route('timetable.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('timetable.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Class & Timetable</a>
                <a href="{{ route('attendance.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('attendance.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Attendance</a>
                <a href="{{ route('exams.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('exams.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Examinations & CGPA</a>
            </div>
            @endif

            @if(in_array($roleSlug, ['super_admin', 'accountant', 'librarian', 'faculty'], true))
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24]/80 mb-1.5">Finance, HR & Assets</div>
                @if(in_array($roleSlug, ['super_admin', 'librarian', 'faculty'], true))
                <a href="{{ route('library.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('library.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Library</a>
                @endif
                @if(in_array($roleSlug, ['super_admin', 'accountant'], true))
                <a href="{{ route('fees.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('fees.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Student Fees</a>
                <a href="{{ route('finance.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('finance.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">College Finance</a>
                @endif
                @if($roleSlug === 'super_admin')
                <a href="{{ route('hr.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('hr.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Faculty & Staff HR</a>
                @endif
                @if(in_array($roleSlug, ['super_admin', 'accountant'], true))
                <a href="{{ route('payroll.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('payroll.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Payroll (PF/ESI/TDS)</a>
                <a href="{{ route('procurement.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('procurement.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Procurement & Stock</a>
                @endif
            </div>
            @endif

            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24]/80 mb-1.5">Campus & Portals</div>
                @if($roleSlug === 'super_admin')
                <a href="{{ route('hostel.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('hostel.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Hostel & Mess</a>
                <a href="{{ route('transport.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('transport.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Transport & GPS</a>
                @endif
                @if(in_array($roleSlug, ['super_admin', 'student'], true))
                <a href="{{ route('portal.student') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('portal.student') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Student Portal</a>
                @endif
                @if(in_array($roleSlug, ['super_admin', 'faculty'], true))
                <a href="{{ route('portal.faculty') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('portal.faculty') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Faculty Portal</a>
                @endif
                @if(in_array($roleSlug, ['super_admin', 'parent'], true))
                <a href="{{ route('portal.parent') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('portal.parent') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Parent Portal</a>
                @endif
                @if(in_array($roleSlug, ['super_admin', 'faculty'], true))
                <a href="{{ route('lms.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('lms.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">LMS & E-Learning</a>
                @endif
            </div>

            @if($roleSlug === 'super_admin')
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-[#fbbf24]/80 mb-1.5">Career, Compliance & Admin</div>
                <a href="{{ route('placements.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('placements.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Placement & Career</a>
                <a href="{{ route('scholarships.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('scholarships.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Scholarships</a>
                <a href="{{ route('certificates.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('certificates.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Certificates & QR</a>
                <a href="{{ route('grievances.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('grievances.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Grievances & Discipline</a>
                <a href="{{ route('community.events_alumni') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('community.events_alumni') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Events & Alumni</a>
                <a href="{{ route('community.accreditation_research') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('community.accreditation_research') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">NAAC/NIRF & Research</a>
                <a href="{{ route('community.communication') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('community.communication') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">Communication</a>
                <a href="{{ route('settings.index') }}" class="block px-3 py-1.5 rounded-lg {{ request()->routeIs('settings.*') ? 'bg-gradient-to-r from-[#701a75] to-[#4a044e] text-[#fbbf24] font-semibold border-l-3 border-[#fbbf24] shadow-sm' : 'text-slate-300 hover:bg-[#2e0847] hover:text-[#fbbf24]' }} transition-all">System & RBAC</a>
            </div>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Header -->
        <header class="no-print bg-white border-b border-[#701a75]/15 px-6 py-3 flex flex-wrap items-center justify-between gap-4 shadow-2xs">
            <div>
                <h1 class="text-lg font-bold text-[#190528]">@yield('header', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3 text-xs">
                @if($roleSlug === 'super_admin')
                <a href="{{ route('admission.public') }}" target="_blank" class="px-3 py-1.5 rounded-md bg-[#fef3c7] text-[#92400e] border border-[#d97706]/30 hover:bg-[#fde68a] font-semibold transition-all">Admission Form ↗</a>
                @endif
                <div class="text-right">
                    <div class="font-bold text-slate-800">{{ auth()->user()->name }}</div>
                    <div class="text-[11px] text-[#701a75] font-medium">{{ auth()->user()->role->name ?? 'User' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-md bg-gradient-to-r from-[#4a044e] to-[#701a75] hover:brightness-110 text-white font-medium shadow-xs transition-all cursor-pointer">Logout</button>
                </form>
            </div>
        </header>

        <main class="flex-1 p-6 print-full">
            @if (session('success'))
                <div class="no-print mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="no-print mb-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>


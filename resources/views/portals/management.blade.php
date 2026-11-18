@extends('layouts.app')
@section('title', 'Management Governance Suite')
@section('header', 'Office of the Chairman & Governing Body')

@section('content')
<!-- Executive Welcome Banner -->
<div class="mb-6 rounded-2xl bg-gradient-to-r from-[#190528] via-[#4a044e] to-[#701a75] p-6 text-white shadow-lg border border-[#701a75]/40 flex flex-wrap items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 mb-1.5">
            <span class="px-2.5 py-0.5 rounded-full bg-[#fbbf24] text-[#190528] text-[10px] font-extrabold uppercase tracking-wider">Governing Body Portal</span>
            <span class="text-xs text-[#fef3c7]/80">Institution Code: JS-499 &bull; NAAC-Accredited</span>
        </div>
        <h2 class="text-2xl font-bold tracking-tight">Executive Strategic Dashboard & Institutional Solvency</h2>
        <p class="text-xs text-slate-300 mt-1 max-w-2xl leading-relaxed">
            Direct institutional oversight for <strong>Dr. K.K. Chaturvedi (Founder & Chairman)</strong> and the College Management Committee across DPCC's 2-Acre Eco-Campus, affiliated to Raja Shankar Shah University, Chhindwara.
        </p>
    </div>
    <div class="text-right">
        <div class="text-[11px] text-slate-300">Principal on Duty</div>
        <div class="text-sm font-bold text-[#fbbf24]">{{ $college->principal_name ?? 'Dr. Amita Chaturvedi' }}</div>
        <div class="text-[10px] text-slate-400 mt-0.5">Helpline: 07692-226635</div>
    </div>
</div>

<!-- Financial Health & Institutional Solvency KPI Ribbon -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-xs">
        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Gross Fee Revenue</div>
        <div class="text-2xl font-bold text-[#701a75] mt-1">₹{{ number_format($totalIncome) }}</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1">Receipts Deposited</div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-xs">
        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Fee Recovery Rate</div>
        <div class="text-2xl font-bold text-[#d97706] mt-1">{{ $feeRecoveryRate }}%</div>
        <div class="text-[11px] text-slate-500 mt-1">₹{{ number_format($totalFeeCollected) }} of ₹{{ number_format($totalFeeExpected) }}</div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-xs">
        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Outstanding Fees</div>
        <div class="text-xl font-bold text-rose-600 mt-1">₹{{ number_format($totalOutstandingFee) }}</div>
        <div class="text-[11px] text-rose-500 font-medium mt-1">Dues to Recover</div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-xs">
        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Net Institutional Surplus</div>
        <div class="text-xl font-bold text-emerald-700 mt-1">₹{{ number_format($netSurplus) }}</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1">Revenue Less OpEx</div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-xs">
        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Seat Occupancy</div>
        <div class="text-2xl font-bold text-slate-900 mt-1">{{ $capacityUtilization }}%</div>
        <div class="text-[11px] text-slate-500 mt-1">{{ $totalEnrolled }} Enrolled / {{ $totalIntake }} Intake</div>
    </div>
    <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-xs">
        <div class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Student-Faculty Ratio</div>
        <div class="text-2xl font-bold text-indigo-700 mt-1">1 : {{ $sfr }}</div>
        <div class="text-[11px] text-slate-500 mt-1">{{ $facultyCount }} Full-time Faculty</div>
    </div>
</div>

<!-- Executive Operations Split: CapEx Approvals & Strategic Projects -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Pending CapEx Approvals -->
    <div class="lg:col-span-1 bg-white p-5 rounded-2xl border border-purple-100 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3 border-b border-slate-100 pb-2.5">
                <div>
                    <h3 class="text-sm font-bold text-[#190528] flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                        CapEx & Purchase Approvals
                    </h3>
                    <p class="text-[11px] text-slate-500">Expenditures requiring Chairman sanction</p>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
                    {{ $pendingRequisitions->count() }} Pending
                </span>
            </div>

            <div class="space-y-3">
                @forelse($pendingRequisitions as $req)
                <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50/60 hover:bg-slate-50 transition-all">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="text-xs font-bold text-slate-800">{{ $req->item_description }}</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">{{ $req->department->name ?? 'Campus Store' }} &bull; Qty: {{ $req->quantity }}</div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-xs font-extrabold text-[#701a75]">₹{{ number_format($req->estimated_cost) }}</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-between pt-2 border-t border-slate-200/80">
                        <span class="text-[10px] text-slate-500">Req: <code class="font-mono font-bold">{{ $req->req_no }}</code></span>
                        <form method="POST" action="{{ route('management.capex.approve', $req) }}">
                            @csrf
                            <button type="submit" class="px-3 py-1 rounded-md bg-gradient-to-r from-[#d97706] to-[#b45309] text-white text-[11px] font-bold hover:brightness-110 shadow-xs cursor-pointer">
                                Approve CapEx ✓
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-xs text-slate-400">
                    All capital requisitions have been approved. No pending sanctions.
                </div>
                @endforelse
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-400">
            Chairman sanction is permanently logged to the immutable audit registry.
        </div>
    </div>

    <!-- Strategic Expansion Roadmaps (B.Sc. Nursing & MBA) -->
    <div class="lg:col-span-2 bg-white p-5 rounded-2xl border border-purple-100 shadow-sm">
        <div class="flex items-center justify-between mb-4 border-b border-slate-100 pb-2.5">
            <div>
                <h3 class="text-sm font-bold text-[#190528] flex items-center gap-1.5">
                    <span class="text-[#d97706]">🚀</span>
                    Strategic Expansion & New Programs Roadmap
                </h3>
                <p class="text-[11px] text-slate-500">Key milestones for upcoming faculties and capital projects</p>
            </div>
            <span class="px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold border border-indigo-200">
                Next Launch: 2027-28
            </span>
        </div>

        <div class="space-y-4">
            @foreach($strategicProjects as $proj)
            <div class="p-4 rounded-xl border border-slate-200 hover:border-purple-200 transition-all">
                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                    <div>
                        <span class="text-xs font-bold text-slate-900">{{ $proj['title'] }}</span>
                        <span class="text-[11px] text-slate-500 ml-2">({{ $proj['regulatory_body'] }})</span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $proj['progress_pct'] >= 70 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                        {{ $proj['status'] }}
                    </span>
                </div>
                
                <div class="w-full bg-slate-100 rounded-full h-2 mb-2 overflow-hidden">
                    <div class="bg-gradient-to-r from-[#701a75] to-[#d97706] h-2 rounded-full" style="width: {{ $proj['progress_pct'] }}%"></div>
                </div>

                <div class="flex flex-wrap items-center justify-between text-[11px] text-slate-500 mt-2">
                    <span>{{ $proj['notes'] }}</span>
                    <span class="font-medium text-slate-700">Lead: {{ $proj['lead'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Academic Excellence & Program Intake Capacity Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Course Seat Intake vs Occupancy -->
    <div class="lg:col-span-2 bg-white p-5 rounded-2xl border border-purple-100 shadow-sm">
        <div class="flex items-center justify-between mb-3 border-b border-slate-100 pb-2.5">
            <div>
                <h3 class="text-sm font-bold text-[#190528]">Course Intake Capacity vs. Enrolled Scholars</h3>
                <p class="text-[11px] text-slate-500">Sanctioned seats under Raja Shankar Shah University & NCTE</p>
            </div>
            <a href="{{ route('academics.index') }}" class="text-xs text-[#701a75] font-semibold hover:underline">Full Curriculum →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase font-semibold text-[10px]">
                    <tr>
                        <th class="py-2.5 px-3">Program / Course</th>
                        <th class="py-2.5 px-3">Department</th>
                        <th class="py-2.5 px-3">Level</th>
                        <th class="py-2.5 px-3 text-center">Sanctioned Intake</th>
                        <th class="py-2.5 px-3 text-center">Enrolled</th>
                        <th class="py-2.5 px-3 text-right">Fill Rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($courses as $c)
                    <tr class="hover:bg-slate-50/60">
                        <td class="py-2.5 px-3 font-bold text-slate-800">{{ $c->name }}</td>
                        <td class="py-2.5 px-3 text-slate-500">{{ $c->department->code ?? 'N/A' }}</td>
                        <td class="py-2.5 px-3"><span class="px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px]">{{ $c->level }}</span></td>
                        <td class="py-2.5 px-3 text-center font-mono font-bold">{{ $c->intake_capacity }}</td>
                        <td class="py-2.5 px-3 text-center font-mono font-bold text-[#701a75]">{{ $c->students_count }}</td>
                        <td class="py-2.5 px-3 text-right">
                            @php($rate = $c->intake_capacity > 0 ? round(($c->students_count / $c->intake_capacity) * 100, 1) : 0)
                            <span class="font-bold {{ $rate >= 50 ? 'text-emerald-600' : 'text-amber-600' }}">{{ $rate }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Institutional Prestige & 320+ Gold Medalists Legacy -->
    <div class="bg-white p-5 rounded-2xl border border-purple-100 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-3 border-b border-slate-100 pb-2.5">
                <div>
                    <h3 class="text-sm font-bold text-[#190528]">Academic Prestige & Legacy</h3>
                    <p class="text-[11px] text-slate-500">Over 25 Years of Excellence (Est. 2000)</p>
                </div>
                <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-extrabold border border-amber-200">
                    320+ Rank Holders
                </span>
            </div>

            <div class="space-y-3 mb-4">
                <div class="p-3 bg-gradient-to-br from-[#fef3c7] to-white rounded-xl border border-[#d97706]/30">
                    <div class="text-[11px] font-bold text-[#92400e]">University Gold Medalists Record</div>
                    <div class="text-xs text-slate-700 mt-1 leading-snug">
                        D.P. Chaturvedi College has produced <strong>320+ University Gold Medalists</strong> across Science, Arts, and Commerce under Raja Shankar Shah University and RDVV.
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="text-[11px] font-bold text-slate-800">Alumni Association Network</div>
                    <div class="text-xs text-slate-600 mt-1">
                        Active directory of over <strong>8,500+ graduated alumni</strong> holding leadership positions in government, educational administration, and corporate industries.
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-3">
                <div class="text-[11px] font-bold text-slate-700 mb-2">Compliance & Regulatory Seal</div>
                <div class="space-y-1.5 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">NAAC Accreditation</span>
                        <span class="font-bold text-emerald-600">Accredited ✓</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">NCTE Recognition (B.Ed./D.Ed.)</span>
                        <span class="font-bold text-emerald-600">Approved ✓</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">AISHE Institutional Code</span>
                        <span class="font-mono font-bold text-indigo-700">JS-499</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 pt-3 border-t border-slate-100 text-center">
            <a href="https://www.dpccollege.com" target="_blank" class="text-xs text-[#701a75] font-bold hover:underline">
                Visit Official Web Portal (www.dpccollege.com) ↗
            </a>
        </div>
    </div>
</div>
@endsection

@extends('layouts.guest')
@section('title', 'Sign In')

@section('content')
<div class="max-w-md mx-auto mt-6 bg-white rounded-2xl shadow-xl shadow-purple-950/5 border border-purple-100 p-6 md:p-8">
    <div class="mb-5 text-center">
        <span class="inline-block px-3 py-1 text-[11px] font-bold text-[#92400e] bg-[#fef3c7] border border-[#d97706]/40 rounded-full mb-2 tracking-wide uppercase">Institution Code: JS-499</span>
        <h2 class="text-2xl font-extrabold text-[#190528] tracking-tight">Sign in to DPCC ERP</h2>
        <p class="text-xs text-slate-500 mt-1">D.P. Chaturvedi College &bull; Barapathar, Seoni (M.P.)</p>
    </div>

    <!-- Quick Demo Accounts Default Fill -->
    <div class="mb-6 rounded-xl border border-[#701a75]/20 bg-gradient-to-br from-[#fdf4ff] via-white to-[#fef3c7]/30 p-3.5 shadow-xs">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold text-[#4a044e] flex items-center gap-1.5">
                <svg class="w-4 h-4 text-[#d97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Quick Demo Fill
            </span>
            <span class="text-[11px] font-semibold text-[#92400e] bg-[#fef3c7] px-2 py-0.5 rounded border border-[#d97706]/30 shadow-2xs">
                Pass: <code class="font-mono font-bold">password</code>
            </span>
        </div>
        <p class="text-[11px] text-slate-600 mb-2.5">Click any role to auto-fill credentials:</p>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="fillLogin('admin@dpccollege.com', 'password')" class="text-left px-3 py-2 bg-white rounded-lg border border-purple-100 hover:border-[#701a75] hover:bg-[#fdf4ff] transition-all cursor-pointer group shadow-2xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#701a75]"></span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#701a75]">Principal / Admin</span>
                </div>
                <div class="text-[10px] text-slate-500 truncate mt-0.5">admin@dpccollege.com</div>
            </button>
            <button type="button" onclick="fillLogin('faculty@dpccollege.com', 'password')" class="text-left px-3 py-2 bg-white rounded-lg border border-purple-100 hover:border-[#701a75] hover:bg-[#fdf4ff] transition-all cursor-pointer group shadow-2xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#d97706]"></span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#701a75]">Faculty</span>
                </div>
                <div class="text-[10px] text-slate-500 truncate mt-0.5">faculty@dpccollege.com</div>
            </button>
            <button type="button" onclick="fillLogin('student@dpccollege.com', 'password')" class="text-left px-3 py-2 bg-white rounded-lg border border-purple-100 hover:border-[#701a75] hover:bg-[#fdf4ff] transition-all cursor-pointer group shadow-2xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#701a75]">Student</span>
                </div>
                <div class="text-[10px] text-slate-500 truncate mt-0.5">student@dpccollege.com</div>
            </button>
            <button type="button" onclick="fillLogin('parent@dpccollege.com', 'password')" class="text-left px-3 py-2 bg-white rounded-lg border border-purple-100 hover:border-[#701a75] hover:bg-[#fdf4ff] transition-all cursor-pointer group shadow-2xs">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-[#701a75]">Parent</span>
                </div>
                <div class="text-[10px] text-slate-500 truncate mt-0.5">parent@dpccollege.com</div>
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('login.post') }}" class="space-y-4" id="loginForm">
        @csrf
        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="you@dpccollege.com" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#701a75] focus:border-[#701a75] transition-all">
        </div>
        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#701a75] focus:border-[#701a75] transition-all">
        </div>
        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-[#701a75] focus:ring-[#701a75]">
                Keep me signed in
            </label>
        </div>
        <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-[#2e0847] via-[#701a75] to-[#9d177d] text-white py-2.5 text-sm font-bold hover:brightness-110 transition-all shadow-md shadow-[#701a75]/25 cursor-pointer">
            Sign In to DPCC ERP
        </button>
    </form>
</div>

<script>
function fillLogin(email, password) {
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    if (emailField && passwordField) {
        emailField.value = email;
        passwordField.value = password;
        
        emailField.focus();
        emailField.classList.add('ring-2', 'ring-[#701a75]', 'border-[#701a75]');
        passwordField.classList.add('ring-2', 'ring-[#701a75]', 'border-[#701a75]');
        setTimeout(() => {
            emailField.classList.remove('ring-2', 'ring-[#701a75]', 'border-[#701a75]');
            passwordField.classList.remove('ring-2', 'ring-[#701a75]', 'border-[#701a75]');
        }, 600);
    }
}
</script>
@endsection

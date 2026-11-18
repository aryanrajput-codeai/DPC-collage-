<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DPCC ERP') — D.P. Chaturvedi College, Seoni (MP)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-deep: #190528;
            --primary: #4a044e;
            --primary-medium: #701a75;
            --primary-light: #9d177d;
            --gold-deep: #92400e;
            --gold: #d97706;
            --gold-bright: #fbbf24;
            --gold-subtle: #fef3c7;
        }
    </style>
</head>
<body class="bg-[#fbf9fc] text-slate-800 antialiased min-h-screen flex flex-col">
<header class="bg-[#190528] border-b border-[#701a75]/50 text-white px-6 py-3.5 flex flex-wrap items-center justify-between gap-4 shadow-sm">
    <a href="{{ route('home') }}" class="flex items-center gap-3">
        <span class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#fbbf24] via-[#f59e0b] to-[#d97706] flex items-center justify-center font-extrabold text-[#190528] text-sm shadow-md">DP</span>
        <div>
            <div class="text-base font-bold tracking-tight text-white leading-tight">D.P. Chaturvedi College <span class="text-xs font-semibold text-[#fbbf24]">(DPCC)</span></div>
            <div class="text-[11px] text-[#fef3c7]/80">Affiliated to Raja Shankar Shah University, Chhindwara &bull; Code: <span class="text-[#fbbf24] font-mono font-semibold bg-[#701a75]/50 px-1.5 py-0.5 rounded">JS-499</span></div>
        </div>
    </a>
    <nav class="flex items-center gap-4 text-sm">
        <a href="https://www.dpccollege.com" target="_blank" class="text-xs text-slate-300 hover:text-[#fbbf24] transition-colors hidden sm:inline flex items-center gap-1">
            Official Website ↗
        </a>
        <a href="tel:07692226635" class="text-xs text-[#fbbf24] hidden md:flex items-center gap-1 font-mono">
            <span>📞 07692-226635</span>
        </a>
        <a href="{{ route('login') }}" class="px-3.5 py-1.5 rounded-md bg-gradient-to-r from-[#d97706] to-[#b45309] text-white hover:brightness-110 font-semibold text-xs shadow-sm transition-all">ERP Portal</a>
    </nav>
</header>

<main class="flex-1 container mx-auto px-4 py-8">
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</main>

<footer class="bg-white border-t border-[#701a75]/20 py-4 text-center text-xs text-slate-600 space-y-1">
    <div><strong class="text-[#4a044e]">D.P. Chaturvedi College (DPCC)</strong> &bull; PWD Colony, Barapathar, Seoni (M.P.) – 480661 &bull; Helpline: <a href="tel:07692226635" class="text-[#92400e] font-semibold hover:underline">07692-226635</a></div>
    <div class="text-[11px] text-slate-400">NAAC-Accredited &bull; NCTE-Recognized &bull; Over 25 Years of Academic Legacy (Est. 2000) &bull; 320+ University Gold Medalists &bull; <a href="https://www.dpccollege.com" target="_blank" class="text-[#701a75] hover:underline">www.dpccollege.com</a></div>
</footer>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline — DPCC ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#190528] text-white min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-[#2e0847] border border-[#701a75] rounded-2xl p-8 text-center shadow-2xl">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-[#fbbf24] to-[#d97706] text-[#190528] font-black text-2xl flex items-center justify-center shadow-lg">
            DP
        </div>
        <h1 class="text-xl font-bold text-[#fbbf24] mb-2">You're Offline</h1>
        <p class="text-sm text-purple-200 mb-6">
            D.P. Chaturvedi College ERP is currently operating in offline mode. Your cached timetable, recent notices, and student details remain available.
        </p>
        <div class="space-y-3">
            <button onclick="window.location.reload()" class="w-full py-2.5 px-4 bg-gradient-to-r from-[#701a75] to-[#9d177d] hover:brightness-110 text-white font-semibold rounded-lg text-sm transition-all shadow-md">
                Try Reconnecting
            </button>
            <a href="/portal/student" class="block w-full py-2.5 px-4 bg-white/10 hover:bg-white/20 text-[#fef3c7] font-medium rounded-lg text-sm transition-all">
                Open Cached Student Portal
            </a>
        </div>
        <div class="mt-6 text-[11px] text-purple-300/70">
            D.P. Chaturvedi College, Seoni (MP) · JS-499
        </div>
    </div>
</body>
</html>

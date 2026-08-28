<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSUD IT Helpdesk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-100 to-slate-200 min-h-full flex items-center justify-center p-3 sm:p-4 md:p-6 overflow-x-hidden">
    <div class="w-full max-w-7xl mx-auto min-w-0">
        @yield('content')
    </div>
</body>
</html>
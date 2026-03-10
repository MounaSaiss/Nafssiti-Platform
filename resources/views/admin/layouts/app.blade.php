<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Console Administration | NAFSSITI PRO')</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'rubik': ['Rubik', 'sans-serif'],
                    },
                    colors: {
                        'admin-dark': '#0f172a',
                        'nafssiti-primary': '#4dbfbf',
                        'nafssiti-secondary': '#96d14b',
                        'nafssiti-red': '#ef4444',
                        'status-active': '#22c55e',
                        'status-banned': '#64748b'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Rubik', sans-serif;
        }

        .sidebar-item-active {
            background: rgba(255, 255, 255, 0.05);
            border-right: 4px solid #4dbfbf;
        }
    </style>
</head>

<body class="bg-[#f1f5f9] text-slate-800 antialiased font-rubik">

    <div class="flex min-h-screen">
        @include('admin.partials.sidebar')

        <main class="flex-1 ml-64">
            <header
                class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="text-slate-400 text-sm">Pages</span>
                    <span class="text-slate-400 text-xs">/</span>
                    <span class="font-bold text-slate-800 uppercase tracking-tight text-sm">@yield('page_title', 'Tableau de bord')</span>
                </div>
                @yield('header_actions')
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>

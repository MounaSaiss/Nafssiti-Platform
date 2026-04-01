<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NAFSSITI')</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'rubik': ['Rubik', 'sans-serif']
                    },
                    colors: {
                        'nafssiti-primary': '#4dbfbf',
                        'nafssiti-secondary': '#96d14b',
                        'nafssiti-dark': '#0f172a'
                    }
                }
            }
        }
    </script>
    <style>
        .nav-item-active {
            background: rgba(77, 191, 191, 0.1);
            color: #4dbfbf;
            border-left: 4px solid #4dbfbf;
        }

        /* Custom scrollbar for lists if needed */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4dbfbf;
            border-radius: 10px;
        }
    </style>
    @yield('styles')
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased font-rubik">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-slate-200 fixed h-full z-50">
            <div class="p-6 border-b border-slate-100">
                <span class="text-xl font-bold text-nafssiti-primary tracking-tighter uppercase">Nafssiti <span
                        class="text-slate-900 font-light">Client</span></span>
            </div>

            <nav class="mt-6 space-y-1">
                <a href="{{ route('patient.dashboard') }}"
                    class="flex items-center gap-3 px-6 py-4 text-sm font-medium transition {{ Route::is('patient.dashboard') ? 'nav-item-active font-bold uppercase tracking-tight' : 'text-slate-500 hover:bg-slate-50' }}">
                    <i class="fas fa-th-large w-5"></i> Dashboard
                </a>
                <a href="{{ route('psychologue.allPsychologues') }}"
                    class="flex items-center gap-3 px-6 py-4 text-sm font-medium transition {{ Route::is('psychologue.allPsychologues') ? 'nav-item-active font-bold uppercase tracking-tight' : 'text-slate-500 hover:bg-slate-50 hover:text-nafssiti-primary' }}">
                    <i class="fas fa-user-md w-5"></i> Psychologues
                </a>
                <a href="{{ route('patient.reservation') }}"
                    class="flex items-center gap-3 px-6 py-4 text-sm font-medium transition {{ Route::is('patient.reservation') ? 'nav-item-active font-bold uppercase tracking-tight' : 'text-slate-500 hover:bg-slate-50' }}">
                    <i class="fas fa-calendar-plus w-5"></i> Réservation
                </a>
                <a href="{{ route('patient.rendezVous') }}"
                    class="flex items-center gap-3 px-6 py-4 text-sm font-medium transition {{ Route::is('patient.rendezVous') ? 'nav-item-active font-bold uppercase tracking-tight' : 'text-slate-500 hover:bg-slate-50 hover:text-nafssiti-primary' }}">
                    <i class="fas fa-calendar-check w-5"></i> Mes Rendez-vous
                </a>
                <a href="{{ route('patient.bilan_seance') }}"
                    class="flex items-center gap-3 px-6 py-4 text-sm font-medium transition {{ Route::is('patient.bilan_seance') ? 'nav-item-active font-bold uppercase tracking-tight' : 'text-slate-500 hover:bg-slate-50 hover:text-nafssiti-primary' }}">
                    <i class="fas fa-clipboard-check w-5"></i> Bilan Séance
                </a>
                <a href="{{ route('patient.profil') }}"
                    class="flex items-center gap-3 px-6 py-4 text-sm font-medium transition {{ Route::is('patient.profil') ? 'nav-item-active font-bold uppercase tracking-tight' : 'text-slate-500 hover:bg-slate-50 hover:text-nafssiti-primary' }}">
                    <i class="fas fa-cog w-5"></i> Paramètres
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-6 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 text-red-500 font-bold text-xs uppercase tracking-widest hover:opacity-70 transition">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-64">
            <header
                class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40">
                <div>
                    <h2 class="font-bold text-slate-800 uppercase text-xs tracking-widest">@yield('header_title', 'Tableau de bord')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium uppercase">Patient</p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'U') }}&background=f1f5f9&color=4dbfbf"
                        class="w-9 h-9 rounded-full border border-slate-200">
                </div>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

    @yield('scripts')
</body>

</html>

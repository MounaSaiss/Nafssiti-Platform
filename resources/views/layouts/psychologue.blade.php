<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Psychologue | NAFSSITI Pro')</title>
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
                        'nafssiti-dark': '#1e293b',
                        'nafssiti-accent': '#f43f5e'
                    }
                }
            }
        }
    </script>
    @vite(['resources/css/app.css'])
    @yield('styles')
</head>

<body class="bg-[#f1f5f9] text-slate-800 antialiased font-rubik">

    <div class="flex min-h-screen">
        <aside class="w-72 bg-nafssiti-dark text-white fixed h-full z-50">
            <div class="p-8 border-b border-slate-700/50">
                <span class="text-xl font-bold text-nafssiti-primary tracking-tighter uppercase">Nafssiti <span
                        class="text-white font-light text-sm italic">Pro</span></span>
            </div>
            <nav class="mt-8 space-y-1">
                <a href="{{ route('psychologue.dashboard') }}"
                    class="flex items-center gap-3 px-8 py-4 text-xs font-bold uppercase tracking-widest transition {{ Route::is('psychologue.dashboard') ? 'nav-item-active' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i
                        class="fas fa-chart-line w-5 {{ Route::is('psychologue.dashboard') ? 'text-nafssiti-primary' : '' }}"></i>
                    Dashboard
                </a>
                <a href="{{ route('psychologue.disponabilite') }}"
                    class="flex items-center gap-3 px-8 py-4 text-xs font-medium transition {{ Route::is('psychologue.disponabilite') ? 'nav-item-active font-bold uppercase tracking-widest' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i
                        class="fas fa-clock w-5 {{ Route::is('psychologue.disponabilite') ? 'text-nafssiti-primary' : '' }}"></i>
                    Gestion Disponibilités
                </a>
                <a href="{{ route('psychologue.rendezVous') }}"
                    class="flex items-center gap-3 px-8 py-4 text-xs font-medium transition {{ Route::is('psychologue.rendezVous') ? 'nav-item-active font-bold uppercase tracking-widest' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i
                        class="fas fa-calendar-alt w-5 {{ Route::is('psychologue.rendezVous') ? 'text-nafssiti-primary' : '' }}"></i>
                    Page Rendez-vous
                </a>
                <a href="{{ route('psychologue.historique') }}"
                    class="flex items-center gap-3 px-8 py-4 text-xs font-medium transition {{ Route::is('psychologue.historique') ? 'nav-item-active font-bold uppercase tracking-widest' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i
                        class="fas fa-history w-5 {{ Route::is('psychologue.historique') ? 'text-nafssiti-primary' : '' }}"></i>
                    Historique des séances
                </a>
                <a href="{{ route('psychologue.follow_requests.index') }}"
                    class="flex items-center gap-3 px-8 py-4 text-[11px] font-medium transition {{ Route::is('psychologue.follow_requests.*') ? 'nav-item-active font-bold uppercase tracking-widest' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i
                        class="fas fa-user-plus w-5 {{ Route::is('psychologue.follow_requests.*') ? 'text-nafssiti-primary' : '' }}"></i>
                    Demandes de suivi
                </a>
                <a href="{{ route('psychologue.profil') }}"
                    class="flex items-center gap-3 px-8 py-4 text-xs font-medium transition {{ Route::is('psychologue.profil') ? 'nav-item-active font-bold uppercase tracking-widest' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i
                        class="fas fa-user-circle w-5 {{ Route::is('psychologue.profil') ? 'text-nafssiti-primary' : '' }}"></i>
                    Page Profil
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-8 border-t border-slate-700/50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 text-nafssiti-accent font-bold text-[10px] uppercase tracking-widest hover:opacity-70 transition">
                        <i class="fas fa-power-off"></i> Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 ml-72">
            <header
                class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-10 sticky top-0 z-40">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">@yield('header_title', 'Bonjour, Dr. ' . (Auth::user()->name ?? 'Utilisateur'))</h2>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right hidden md:block">
                        <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                        <p class="text-[10px] text-slate-400 font-medium uppercase">Psychologue</p>
                    </div>
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'U') . '&background=4dbfbf&color=fff' }}"
                        class="w-10 h-10 rounded-full shadow-sm">
                </div>
            </header>

            <div class="p-10">
                {{-- Session Messages --}}
                @if (session('success'))
                    <div
                        class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] font-bold rounded-sm flex items-center gap-4 animate-fade-in shadow-sm">
                        <i class="fas fa-check-circle text-sm"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-600 text-[10px] font-bold rounded-sm flex items-center gap-4 animate-fade-in shadow-sm">
                        <i class="fas fa-exclamation-triangle text-sm text-rose-500"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @yield('scripts')
    @stack('scripts')
</body>

</html>

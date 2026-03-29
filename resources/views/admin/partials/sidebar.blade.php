<aside class="w-64 bg-admin-dark flex flex-col fixed h-full z-50">
    <div class="p-6 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-7 h-7 bg-nafssiti-primary rounded flex items-center justify-center">
                <i class="fas fa-shield-alt text-white text-xs"></i>
            </div>
            <span class="text-white font-bold uppercase tracking-widest text-lg">NAFSSITI</span>
        </div>
    </div>

    <nav class="flex-1 py-4">
        <div class="px-6 py-3 text-[11px] font-bold uppercase tracking-widest text-slate-500">Navigation</div>

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-6 py-3 transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
            <i class="fas fa-chart-line w-6"></i> <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="flex items-center px-6 py-3 transition-all {{ request()->routeIs('admin.users.*') ? 'sidebar-item-active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
            <i class="fas fa-users w-6"></i> <span>Utilisateurs</span>
        </a>

        <a href="{{ route('admin.appointments.index') }}"
            class="flex items-center px-6 py-3 transition-all {{ request()->routeIs('admin.appointments.*') ? 'sidebar-item-active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
            <i class="fas fa-calendar-alt w-6"></i> <span>Rendez-vous</span>
        </a>

        <a href="{{ route('admin.speciality.index') }}"
            class="flex items-center px-6 py-3 transition-all {{ request()->routeIs('admin.speciality.index') ? 'sidebar-item-active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
            <i class="fas fa-tags w-6"></i> <span>Spécialités</span>
        </a>
    </nav>

    <div class="p-4 bg-slate-950/50">
        <form method="POST" action="{{ route('logout') }}" id="logout-form"
            class="flex items-center gap-3 px-2 cursor-pointer group"
            onclick="document.getElementById('logout-form').submit();">
            @csrf
            <div
                class="w-8 h-8 rounded bg-slate-700 flex items-center justify-center text-white text-xs font-bold group-hover:bg-nafssiti-primary transition-colors">
                AD</div>
            <div class="flex flex-col">
                <span class="text-xs text-white font-bold">Admin Console</span>
                <button type="submit"
                    class="text-[10px] text-slate-500 hover:text-nafssiti-red text-left">Déconnexion</button>
            </div>
        </form>
    </div>
</aside>

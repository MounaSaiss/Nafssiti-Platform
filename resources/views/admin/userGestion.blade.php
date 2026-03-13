@extends('admin.layouts.app')

@section('title', 'Gestion Utilisateurs | NAFSSITI PRO')

@section('page_title', 'Annuaire Utilisateurs')

@section('header_actions')
<div class="flex items-center gap-4">
    <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold uppercase tracking-widest">Total
        : {{ $users->count() }}</span>
</div>
@endsection

@section('content')
@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-sm text-sm font-medium flex items-center gap-3">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-sm text-sm font-medium flex items-center gap-3">
    <i class="fas fa-exclamation-circle"></i>
    {{ session('error') }}
</div>
@endif


<form action="{{ route('admin.userGestion') }}" method="GET" class="flex flex-col md:flex-row gap-4 mb-6">
    <div class="relative flex-1">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom, email, ville..."
            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded shadow-sm text-sm focus:ring-1 focus:ring-nafssiti-primary outline-none transition">
    </div>
    <select name="role" onchange="this.form.submit()"
        class="bg-white border border-slate-200 px-4 py-2.5 rounded text-xs font-bold uppercase tracking-tight text-slate-600 outline-none cursor-pointer">
        <option value="all" {{ request('role') == 'all' || !request('role') ? 'selected' : '' }}>Tous les rôles</option>
        <option value="patient" {{ request('role') == 'patient' ? 'selected' : '' }}>Patients</option>
        <option value="psychologue" {{ request('role') == 'psychologue' ? 'selected' : '' }}>Psychologues</option>
    </select>
</form>

<div class="bg-white border border-slate-200 shadow-sm rounded-sm overflow-hidden">
    <table class="w-full text-left text-xs border-collapse">
        <thead>
            <tr class="bg-slate-50 text-slate-500 uppercase tracking-widest border-b border-slate-200">
                <th class="px-6 py-4 font-bold">Utilisateur</th>
                <th class="px-6 py-4 font-bold">Rôle</th>
                <th class="px-6 py-4 font-bold">Ville</th>
                <th class="px-6 py-4 font-bold text-center">Statut</th>
                <th class="px-6 py-4 font-bold text-right">Actions de Contrôle</th>
            </tr>
        </thead>
        @foreach ($users as $user)
        @if($user->role_id != 3)
        <tbody class="divide-y divide-slate-100">
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=4dbfbf&color=fff"
                            class="w-8 h-8 rounded-full shadow-sm">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 uppercase tracking-tight">{{ $user->name }}</span>
                            <span class="text-slate-400 text-[10px]">{{ $user->email }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span
                        class="text-[10px] font-bold text-slate-500 border border-slate-200 px-2 py-0.5 rounded uppercase">{{ $user->role->status }}</span>
                </td>
                <td class="px-6 py-4 font-medium text-slate-700">
                    @if($user->psychologist)
                    {{ $user->psychologist->city }}
                    @else
                    -
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    @if($user->status == 'actif')
                    <span class="inline-flex items-center gap-1.5 text-green-600 font-bold uppercase text-[9px] bg-green-50 px-2 py-1 rounded border border-green-100">
                        {{ $user->status }}
                    </span>
                    @elseif($user->status == 'banni')
                    <span class="inline-flex items-center gap-1.5 text-red-600 font-bold uppercase text-[9px] bg-red-50 px-2 py-1 rounded border border-red-100">
                        {{ $user->status }}
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 text-amber-600 font-bold uppercase text-[9px] bg-amber-50 px-2 py-1 rounded border border-amber-100">
                        {{ $user->status }}
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-end gap-2 items-center">
                        @if($user->isAdmin())
                        <button disabled
                            class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-50 text-slate-400 rounded-sm font-bold uppercase text-[10px] border border-slate-200 cursor-not-allowed">
                            <i class="fas fa-shield-alt"></i> Protégé
                        </button>
                        @else
                        <button
                            onclick="openProfileModal(this)"
                            data-name="{{ $user->name }}"
                            data-email="{{ $user->email }}"
                            data-role="{{ $user->role->status }}"
                            data-status="{{ $user->status }}"
                            data-city="{{ $user->psychologist->city ?? 'Pas de ville' }}"
                            data-phone="{{ $user->phone ?? 'Pas de numéro' }}"
                            data-joined="{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}"
                            class="flex items-center justify-center gap-2 px-3 py-2 bg-slate-100 text-slate-700 rounded-sm font-bold uppercase text-[10px] hover:bg-slate-200 transition-all border border-slate-200 shadow-sm">
                            <i class="fas fa-eye"></i> Consulter
                        </button>
                        @if($user->status != 'actif')
                        <form action="{{ route('admin.unbanUser', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-28 flex items-center justify-center gap-2 px-3 py-2 bg-white text-nafssiti-primary border border-nafssiti-primary rounded-sm font-bold uppercase text-[10px] hover:bg-nafssiti-primary hover:text-white transition-all shadow-sm">
                                <i class="fas fa-check"></i> Activer
                            </button>
                        </form>
                        @endif
                        @if($user->status != 'banni')
                        <form action="{{ route('admin.banUser', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-28 flex items-center justify-center gap-2 px-3 py-2 bg-white text-nafssiti-red border border-nafssiti-red rounded-sm font-bold uppercase text-[10px] hover:bg-nafssiti-red hover:text-white transition-all shadow-sm">
                                <i class="fas fa-ban"></i> Bannir
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </td>
            </tr>
        </tbody>
        @endif
        @endforeach
    </table>
</div>

<!-- Modal Profil Utilisateur -->
<div id="profileModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeProfileModal()">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center gap-4">
                        <div id="modalAvatar" class="w-16 h-16 rounded-full bg-nafssiti-primary flex items-center justify-center text-white text-2xl font-bold shadow-md">
                            <!-- Initials here -->
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 uppercase tracking-tight" id="modalName"></h3>
                            <span class="text-[10px] font-bold text-slate-500 border border-slate-200 px-2 py-0.5 rounded uppercase tracking-widest" id="modalRole"></span>
                        </div>
                    </div>
                    <button onclick="closeProfileModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email</label>
                        <p class="text-sm font-medium text-slate-700" id="modalEmail"></p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Téléphone</label>
                        <p class="text-sm font-medium text-slate-700" id="modalPhone"></p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ville</label>
                        <p class="text-sm font-medium text-slate-700" id="modalCity"></p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date d'inscription</label>
                        <p class="text-sm font-medium text-slate-700" id="modalJoined"></p>
                    </div>
                    <div class="col-span-full space-y-2 mt-2 pt-4 border-t border-slate-100">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Statut du Compte</label>
                        <div id="modalStatusBadge"></div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeProfileModal()" class="w-full inline-flex justify-center rounded-sm border border-slate-300 shadow-sm px-4 py-2 bg-white text-xs font-bold text-slate-700 uppercase tracking-widest hover:bg-slate-50 focus:outline-none transition-all sm:ml-3 sm:w-auto">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openProfileModal(button) {
        const name = button.getAttribute('data-name');
        const email = button.getAttribute('data-email');
        const role = button.getAttribute('data-role');
        const status = button.getAttribute('data-status');
        const city = button.getAttribute('data-city');
        const phone = button.getAttribute('data-phone');
        const joined = button.getAttribute('data-joined');

        document.getElementById('modalName').textContent = name;
        document.getElementById('modalEmail').textContent = email;
        document.getElementById('modalRole').textContent = role;
        document.getElementById('modalPhone').textContent = phone;
        document.getElementById('modalCity').textContent = city;
        document.getElementById('modalJoined').textContent = joined;

        // Set initials in avatar
        const initials = name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        document.getElementById('modalAvatar').textContent = initials;

        // Handle Status Badge
        const statusBadge = document.getElementById('modalStatusBadge');
        let badgeClass = "";
        let statusText = status;

        if (status === 'actif') {
            badgeClass = "text-green-600 bg-green-50 border-green-100";
        } else if (status === 'banni') {
            badgeClass = "text-red-600 bg-red-50 border-red-100";
        } else {
            badgeClass = "text-amber-600 bg-amber-50 border-amber-100";
        }

        statusBadge.innerHTML = `<span class="inline-flex items-center gap-1.5 font-bold uppercase text-[10px] px-3 py-1.5 rounded border ${badgeClass}">${statusText}</span>`;

        document.getElementById('profileModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeProfileModal() {
        document.getElementById('profileModal').classList.add('hidden');
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Close on ESC key
    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProfileModal();
        }
    });
</script>
@endsection
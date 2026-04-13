@extends('admin.layouts.app')

@section('title', 'Console Administration | NAFSSITI')

@section('page_title', 'Tableau de bord')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Utilisateurs actifs</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $activeUsersCount }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-primary">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Psychologues</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $totalPsychologistsCount }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-secondary">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rendez-vous</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ $appointments->count() }}</h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-slate-800">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Revenu Global</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">{{ number_format($globalRevenue, 2) }} <span
                            class="text-sm font-normal">DH</span>
                    </h3>
                </div>
                <div class="p-2 bg-slate-50 rounded border border-slate-100 text-nafssiti-primary">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 uppercase tracking-widest text-sm italic">Validation des nouveaux praticiens</h3>
                <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-tighter">Une fois validé, le psychologue apparaît dans la liste suivante et peut être géré via la page <a href="{{ route('admin.users.index') }}" class="text-nafssiti-primary hover:underline">Utilisateurs</a>.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-tight">
                        <th class="px-6 py-4 font-bold border-b border-slate-200">ID</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200">Praticien</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200">Spécialité</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-center">Ville</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-center">Certificats</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($psychologists as $psychologist)
                        <tr>
                            <td class="px-6 py-4 font-mono text-slate-400">{{ $psychologist->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $psychologist->user->avatar ? asset('storage/' . $psychologist->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($psychologist->user->name ?? 'P') . '&background=4dbfbf&color=fff' }}" 
                                         class="w-8 h-8 rounded-full border border-slate-200 object-cover shadow-sm">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 uppercase leading-none">{{ $psychologist->user->name ?? 'Praticien inconnu' }}</span>
                                        <span class="text-slate-400 font-light tracking-tight text-[10px] mt-1">{{ $psychologist->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $psychologist->specialization }}</td>
                            <td class="px-6 py-4">{{ $psychologist->city }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-wrap justify-center gap-1">
                                    @forelse($psychologist->certificates as $cert)
                                        @if($cert->type === 'file')
                                            <button type="button" onclick="openCertModal('{{ asset('storage/' . $cert->path_or_url) }}', 'Fichier')" title="Voir Fichier" class="px-2 py-1 bg-blue-50 text-blue-500 rounded text-[10px] hover:bg-blue-100 transition"><i class="fas fa-file-pdf"></i></button>
                                        @else
                                            <button type="button" onclick="openCertModal('{{ $cert->path_or_url }}', 'Lien')" title="Ouvrir Lien" class="px-2 py-1 bg-purple-50 text-purple-500 rounded text-[10px] hover:bg-purple-100 transition"><i class="fas fa-link"></i></button>
                                        @endif
                                    @empty
                                        <span class="text-[9px] text-red-400">Aucun</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.users.approve', $psychologist->user) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-1.5 bg-green-50 text-green-600 border border-green-100 rounded-sm text-[9px] font-bold uppercase tracking-wider hover:bg-green-600 hover:text-white hover:border-green-600 transition-all shadow-sm">
                                            Valide
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.reject', $psychologist->user) }}" method="POST" onsubmit="return confirm('Refuser ce praticien ?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-1.5 bg-red-50 text-red-500 border border-red-100 rounded-sm text-[9px] font-bold uppercase tracking-wider hover:bg-red-600 hover:text-white hover:border-red-600 transition-all shadow-sm">
                                            Invalide
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">
                                Aucun nouveau praticien en attente de validation.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Certificate Modal -->
    <div id="certModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl h-[80vh] flex flex-col overflow-hidden animate-fade-in-up">
            <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 id="certModalTitle" class="font-bold text-gray-800 uppercase tracking-wider text-sm"><i class="fas fa-file-contract mr-2"></i> Document</h3>
            </div>
            <div class="flex-grow p-0 bg-gray-100 relative">
                <iframe id="certModalIframe" class="w-full h-full border-0" src=""></iframe>
                <div id="certModalLoading" class="absolute inset-0 flex items-center justify-center text-gray-400 font-bold text-sm tracking-widest uppercase pointer-events-none">
                    Chargement...
                </div>
            </div>
            <div class="p-3 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button onclick="closeCertModal()" class="px-4 py-1.5 bg-gray-200 text-gray-700 rounded text-xs font-bold hover:bg-gray-300 transition-colors">Fermer</button>
            </div>
        </div>
    </div>

    <script>
        function openCertModal(url, type) {
            document.getElementById('certModal').classList.remove('hidden');
            document.getElementById('certModalTitle').innerHTML = '<i class="' + (type === 'Fichier' ? 'fas fa-file-pdf' : 'fas fa-link') + ' mr-2 text-nafssiti-primary"></i> ' + type + ' du Praticien';
            
            const iframe = document.getElementById('certModalIframe');
            const loading = document.getElementById('certModalLoading');
            
            loading.style.display = 'flex';
            iframe.onload = function() {
                loading.style.display = 'none';
            };
            
            iframe.src = url;
        }

        function closeCertModal() {
            document.getElementById('certModal').classList.add('hidden');
            document.getElementById('certModalIframe').src = '';
        }
    </script>
    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection

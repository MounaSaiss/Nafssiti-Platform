@extends('layouts.patient')

@section('title', 'Psychologues | NAFSSITI')
@section('header_title', 'Liste des Psychologues')

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    <aside class="w-full lg:w-1/4">
        <div class="bg-white p-5 rounded-sm border border-slate-200 shadow-sm sticky top-24">
            <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-5">Filtrer par</h3>
            <div class="space-y-5">
                <form action="{{ route('psychologue.allPsychologues') }}" method="GET" class="space-y-5">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-2 uppercase">Spécialité</label>
                        <select name="specialty" class="w-full bg-slate-50 border border-slate-100 rounded-sm py-2 px-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            <option value="">Toutes les spécialités</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty }}" {{ request('specialty') == $specialty ? 'selected' : '' }}>
                                    {{ $specialty }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-2 uppercase">Ville</label>
                        <select name="city" class="w-full bg-slate-50 border border-slate-100 rounded-sm py-2 px-3 text-xs outline-none focus:border-nafssiti-primary transition">
                            <option value="">Toutes les villes</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-3 bg-nafssiti-dark text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition shadow-md">
                        Rechercher
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <section class="w-full lg:w-3/4">
        <div class="grid md:grid-cols-2 gap-5">
            @forelse($psychologues as $psychologue)
            <div class="bg-white rounded-sm p-5 border border-slate-200 shadow-sm hover:border-nafssiti-primary/30 transition-all duration-300">
                <div class="flex items-start gap-4">
                    <div class="relative flex-shrink-0">
                        <img src="{{ $psychologue->photo ? asset('storage/' . $psychologue->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($psychologue->user->name) . '&background=4dbfbf&color=fff' }}"
                            class="w-16 h-16 rounded-sm object-cover"
                            alt="{{ $psychologue->user->name }}">
                        @if($psychologue->validationStatus === 'approved')
                        <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-nafssiti-secondary border-2 border-white rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-[7px] text-white"></i>
                        </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-slate-800 tracking-tight">{{ $psychologue->user->name }}</h3>
                        <p class="text-nafssiti-primary text-[10px] font-medium uppercase mt-0.5">{{ $psychologue->specialization }}</p>

                        <div class="mt-2 flex items-center gap-3 text-slate-400">
                            <span class="text-[10px] min-w-0 flex items-center gap-1">
                                <i class="fas fa-map-marker-alt text-[9px]"></i> {{ $psychologue->city }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-50 flex items-center justify-between">
                    <div>
                        <p class="text-[9px] text-slate-400 uppercase font-bold tracking-tighter">Tarif séance</p>
                        <p class="text-sm font-bold text-slate-700">{{ $psychologue->pricePerSession }} DH</p>
                    </div>
                    <button 
                        onclick="showProfileModal({
                            name: '{{ $psychologue->user->name }}',
                            specialty: '{{ $psychologue->specialization }}',
                            city: '{{ $psychologue->city }}',
                            experience: '{{ $psychologue->experienceYears }}',
                            price: '{{ $psychologue->pricePerSession }}',
                            type: '{{ $psychologue->consultationType }}',
                            photo: '{{ $psychologue->photo ? asset('storage/' . $psychologue->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($psychologue->user->name) . '&background=4dbfbf&color=fff' }}'
                        })"
                        class="px-4 py-2 bg-slate-50 text-slate-700 border border-slate-200 rounded-sm text-[9px] font-bold uppercase tracking-widest hover:bg-nafssiti-primary hover:text-white hover:border-nafssiti-primary transition-all">
                        Voir Profil
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-2 py-20 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="fas fa-user-md text-2xl"></i>
                </div>
                <p class="text-slate-500 font-medium">Aucun psychologue trouvé.</p>
                <p class="text-slate-400 text-xs mt-1">Réessayez avec d'autres filtres.</p>
            </div>
            @endforelse
        </div>
    </section>
</div>

<!-- Modal Profil Premium -->
<div id="profileModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/10 backdrop-blur-sm transition-all duration-300">
    <div class="bg-white w-full max-w-lg rounded-sm shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 relative" id="modalContent">
        <button onclick="closeProfileModal()" class="absolute top-5 right-5 z-20 w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:text-nafssiti-primary transition flex items-center justify-center border border-slate-100">
            <i class="fas fa-times text-sm"></i>
        </button>

        <!-- Content -->
        <div class="px-10 py-12 relative">
            <div class="flex flex-col items-center">
                <!-- Profile Image -->
                <div class="relative">
                    <img id="modalPhoto" src="" alt="Photo" class="w-28 h-28 rounded-sm border-2 border-slate-100 shadow-md object-cover bg-white">
                    <div class="absolute bottom-1 right-1 w-5 h-5 bg-nafssiti-secondary border-2 border-white rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-[7px] text-white"></i>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="mt-5 text-center">
                    <h2 id="modalName" class="text-2xl font-bold text-slate-900 tracking-tight"></h2>
                    <div class="mt-2 inline-flex items-center px-3 py-1 bg-teal-50 text-nafssiti-primary rounded-full border border-teal-100">
                        <i class="fas fa-certificate text-[9px] mr-2"></i>
                        <span id="modalSpecialty" class="text-[10px] font-bold uppercase tracking-wider"></span>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="mt-8 w-full">
                    <h4 class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-4 px-1">Informations clés</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50/50 p-4 rounded-sm border border-slate-100 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-sm bg-white border border-slate-100 flex items-center justify-center text-nafssiti-primary shadow-sm shrink-0">
                                <i class="fas fa-map-marker-alt text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Localisation</p>
                                <p id="modalCity" class="text-[11px] font-bold text-slate-700"></p>
                            </div>
                        </div>
                        <div class="bg-slate-50/50 p-4 rounded-sm border border-slate-100 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-sm bg-white border border-slate-100 flex items-center justify-center text-nafssiti-primary shadow-sm shrink-0">
                                <i class="fas fa-briefcase text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Expérience</p>
                                <p id="modalExperience" class="text-[11px] font-bold text-slate-700"></p>
                            </div>
                        </div>
                        <div class="bg-slate-50/50 p-4 rounded-sm border border-slate-100 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-sm bg-white border border-slate-100 flex items-center justify-center text-nafssiti-primary shadow-sm shrink-0">
                                <i class="fas fa-tag text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Tarif séance</p>
                                <p id="modalPrice" class="text-[11px] font-bold text-slate-700"></p>
                            </div>
                        </div>
                        <div class="bg-slate-50/50 p-4 rounded-sm border border-slate-100 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-sm bg-white border border-slate-100 flex items-center justify-center text-nafssiti-primary shadow-sm shrink-0">
                                <i class="fas fa-video text-xs"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Modalité</p>
                                <p id="modalType" class="text-[11px] font-bold text-slate-700 capitalize"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer CTA -->
                <div class="mt-10 w-full flex items-center gap-4">
                    <a href="{{ route('patient.reservation') }}" class="flex-1 py-4 bg-nafssiti-secondary hover:bg-green-600 text-white rounded-sm text-[11px] font-bold uppercase tracking-widest transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <i class="fas fa-calendar-check"></i>
                        Prendre rendez-vous
                    </a>
                </div>
                
                <p class="mt-5 text-[10px] text-slate-400 italic">Plateforme sécurisée par NAFSSITI</p>
            </div>
        </div>
    </div>
</div>

<script>
    function showProfileModal(data) {
        const modal = document.getElementById('profileModal');
        const content = document.getElementById('modalContent');
        
        document.getElementById('modalName').textContent = data.name;
        document.getElementById('modalSpecialty').textContent = data.specialty;
        document.getElementById('modalCity').textContent = data.city;
        document.getElementById('modalExperience').textContent = data.experience + ' ans';
        document.getElementById('modalPrice').textContent = data.price + ' DH / séance';
        document.getElementById('modalType').textContent = data.type;
        document.getElementById('modalPhoto').src = data.photo;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger animation
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeProfileModal() {
        const modal = document.getElementById('profileModal');
        const content = document.getElementById('modalContent');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    // Close on backdrop click
    document.getElementById('profileModal').addEventListener('click', function(e) {
        if (e.target === this) closeProfileModal();
    });
</script>
@endsection
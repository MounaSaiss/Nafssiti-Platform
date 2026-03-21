@extends('layouts.psychologue')

@section('title', 'Profil Professionnel | NAFSSITI')
@section('header_title', 'Configuration du Profil Professionnel')

@section('content')
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-600 text-xs font-bold rounded-sm flex items-center gap-3">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('psychologue.updateProfil') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="bg-white rounded-sm border border-slate-200 p-8 mb-8 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-nafssiti-primary"></div>
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="relative group">
                        <img id="preview" src="{{ Auth::user()->psychologist->photo ? asset('storage/' . Auth::user()->psychologist->photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=4dbfbf&color=fff&size=128' }}"
                            class="w-32 h-32 rounded-sm object-cover border-4 border-slate-50 shadow-sm">
                        <label class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition cursor-pointer text-white text-xs font-bold uppercase tracking-tighter">
                            <i class="fas fa-camera mr-2"></i> Changer
                            <input type="file" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>
                    <div class="flex-1 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nom complet</label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                    class="w-full bg-slate-50 border @error('name') border-red-300 @else border-slate-100 @enderror rounded-sm px-4 py-2 text-sm focus:border-nafssiti-primary outline-none transition">
                                @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Spécialité principale</label>
                                <input type="text" name="specialization" value="{{ old('specialization', Auth::user()->psychologist->specialization) }}"
                                    class="w-full bg-slate-50 border @error('specialization') border-red-300 @else border-slate-100 @enderror rounded-sm px-4 py-2 text-sm focus:border-nafssiti-primary outline-none transition">
                                @error('specialization') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ville d'exercice</label>
                                <select name="city" class="w-full bg-slate-50 border @error('city') border-red-300 @else border-slate-100 @enderror rounded-sm px-4 py-2 text-sm focus:border-nafssiti-primary outline-none transition">
                                    <option value="Casablanca" {{ old('city', Auth::user()->psychologist->city) == 'Casablanca' ? 'selected' : '' }}>Casablanca</option>
                                    <option value="Rabat" {{ old('city', Auth::user()->psychologist->city) == 'Rabat' ? 'selected' : '' }}>Rabat</option>
                                    <option value="Marrakech" {{ old('city', Auth::user()->psychologist->city) == 'Marrakech' ? 'selected' : '' }}>Marrakech</option>
                                    <option value="Tanger" {{ old('city', Auth::user()->psychologist->city) == 'Tanger' ? 'selected' : '' }}>Tanger</option>
                                    <option value="Agadir" {{ old('city', Auth::user()->psychologist->city) == 'Agadir' ? 'selected' : '' }}>Agadir</option>
                                </select>
                                @error('city') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Années d'expérience</label>
                                <input type="number" name="experienceYears" value="{{ old('experienceYears', Auth::user()->psychologist->experienceYears) }}"
                                    class="w-full bg-slate-50 border @error('experienceYears') border-red-300 @else border-slate-100 @enderror rounded-sm px-4 py-2 text-sm focus:border-nafssiti-primary outline-none transition">
                                @error('experienceYears') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-sm border border-slate-200 p-8 shadow-sm space-y-8">
                <div>
                    <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 mb-4 flex items-center gap-2">
                        <i class="fas fa-quote-left text-nafssiti-primary"></i> Description professionnelle
                    </h3>
                    <textarea name="description" rows="6"
                        class="w-full bg-slate-50 border @error('description') border-red-300 @else border-slate-100 @enderror rounded-sm px-4 py-3 text-xs leading-relaxed focus:border-nafssiti-primary outline-none transition resize-none"
                        placeholder="Décrivez votre approche thérapeutique...">{{ old('description', Auth::user()->psychologist->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <hr class="border-slate-50">

                <div>
                    <h3 class="text-[11px] font-bold uppercase tracking-widest text-slate-600 mb-4 flex items-center gap-2">
                        <i class="fas fa-graduation-cap text-nafssiti-primary"></i> Parcours & Expérience détaillée
                    </h3>
                    <textarea name="education" rows="4"
                        class="w-full bg-slate-50 border @error('education') border-red-300 @else border-slate-100 @enderror rounded-sm px-4 py-3 text-xs leading-relaxed focus:border-nafssiti-primary outline-none transition resize-none"
                        placeholder="Diplômes, formations, anciens postes...">{{ old('education', Auth::user()->psychologist->education) }}</textarea>
                    @error('education') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-4">
                    <button type="button" class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-slate-600 transition">Annuler</button>
                    <button type="submit" class="px-10 py-4 bg-nafssiti-dark text-white rounded-sm text-[10px] font-bold uppercase tracking-widest hover:bg-nafssiti-primary transition shadow-md">Sauvegarder le profil</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

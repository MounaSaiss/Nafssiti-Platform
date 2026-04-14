<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nafssiti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<div class="min-h-screen flex flex-col justify-center py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto w-full">

        <div class="text-center mb-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Nafssiti" class="mx-auto h-16 w-auto">
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                    Créer un compte Spécialiste
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Déjà inscrit ?
                    <a href="/login" class="font-medium text-nafssiti-blue hover:text-opacity-80">
                        Connectez-vous ici
                    </a>
                </p>
            </div>

            @if ($errors->any())
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong>Erreurs de validation:</strong>
                    <ul class="list-disc pl-5 mt-2 text-xs font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form action="{{ route('register.psychologue') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 border border-gray-100 dark:border-gray-700">
            @csrf

            <div class="absolute top-4 left-4 sm:top-8 sm:left-8">
                <a href="/"
                    class="flex items-center text-gray-500 hover:text-nafssiti-blue dark:text-gray-400 dark:hover:text-white transition-colors group">
                    <div
                        class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-sm border border-gray-100 dark:border-gray-700 mr-3 group-hover:shadow-md transition-all">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest hidden sm:inline">Accueil</span>
                </a>
            </div>

            <!-- Informations du compte -->
            <div class="flex items-center mb-5 text-nafssiti-blue border-b border-gray-50 dark:border-gray-700 pb-3">
                <i class="fas fa-id-card mr-2"></i>
                <h3 class="font-bold uppercase text-xs tracking-wider">Informations du compte</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Nom
                        Complet</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    @error('name')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    @error('email')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label
                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Téléphone</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    @error('phone')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Mot de
                        passe</label>
                    <input type="password" name="password" required
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    @error('password')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label
                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Confirmation</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                </div>
            </div>

            <!-- Détails Professionnels -->
            <div
                class="flex items-center mb-5 mt-8 text-nafssiti-green border-b border-gray-50 dark:border-gray-700 pb-3">
                <i class="fas fa-user-md mr-2"></i>
                <h3 class="font-bold uppercase text-xs tracking-wider">Détails Professionnels</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Spécialité</label>
                    <select name="specialization" required
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                        <option value="" disabled selected>Choisir une spécialité</option>
                        @foreach ($specialities as $speciality)
                            <option value="{{ $speciality->name }}"
                                {{ old('specialization') == $speciality->name ? 'selected' : '' }}>
                                {{ $speciality->name }}</option>
                        @endforeach
                    </select>
                    @error('specialization')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Ville</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                    @error('city')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Expérience
                        (Ans)</label>
                    <input type="number" name="experienceYears" value="{{ old('experienceYears') }}"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                    @error('experienceYears')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label
                        class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Consultation</label>
                    <select name="consultationType"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                        <option value="online" {{ old('consultationType') == 'online' ? 'selected' : '' }}>En ligne
                        </option>
                        <option value="onsite" {{ old('consultationType') == 'onsite' ? 'selected' : '' }}>Cabinet
                        </option>
                        <option value="both" {{ old('consultationType') == 'both' ? 'selected' : '' }}>Les deux
                        </option>
                    </select>
                    @error('consultationType')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Prix par
                        session</label>
                    <input type="number" name="pricePerSession" value="{{ old('pricePerSession') }}"
                        class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                    @error('pricePerSession')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Photo de
                        profil</label>
                    <input type="file" name="avatar" required accept="image/*"
                        class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-nafssiti-blue/10 file:text-nafssiti-blue hover:file:bg-nafssiti-blue/20 cursor-pointer">
                    @error('avatar')
                        <span class="text-xs text-red-500 font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-2">
                        Certificats (Au moins un fichier ou un lien est requis)
                    </label>

                    @if ($errors->has('certificates'))
                        <p class="text-red-500 text-xs mb-2">{{ $errors->first('certificates') }}</p>
                    @endif

                    <div class="space-y-4">
                        <div
                            class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                            <span class="block text-[10px] font-bold text-nafssiti-blue mb-2 uppercase"><i
                                    class="fas fa-file-upload mr-1"></i> Envoyer vos fichiers (Multiple
                                possible)</span>
                            <input type="file" name="certificate_files[]" multiple
                                class="w-full text-xs text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-nafssiti-blue/10 file:text-nafssiti-blue hover:file:bg-nafssiti-blue/20 cursor-pointer" />
                        </div>

                        <div
                            class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-100 dark:border-gray-600">
                            <span class="block text-[10px] font-bold text-nafssiti-blue mb-2 uppercase"><i
                                    class="fas fa-link mr-1"></i> Liens additionnels (Formations, Profil
                                Linkedin...)</span>
                            <div class="space-y-2">
                                <input type="url" name="certificate_links[]" placeholder="https://lien-1.com"
                                    class="w-full px-3 py-1.5 text-xs bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg outline-none dark:text-white" />
                                <input type="url" name="certificate_links[]"
                                    placeholder="https://lien-2.com (Optionnel)"
                                    class="w-full px-3 py-1.5 text-xs bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg outline-none dark:text-white" />
                                <input type="url" name="certificate_links[]"
                                    placeholder="https://lien-3.com (Optionnel)"
                                    class="w-full px-3 py-1.5 text-xs bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg outline-none dark:text-white" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-4 flex justify-end border-t border-gray-50 dark:border-gray-700">
                <button type="submit"
                    class="bg-nafssiti-green hover:bg-[#85bc41] text-white px-8 py-3 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> Confirmer l'inscription
                </button>
            </div>
        </form>

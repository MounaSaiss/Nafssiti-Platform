<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nafssiti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .text-nafssiti-blue {
            color: #4dbfbf;
        }

        .bg-nafssiti-blue {
            background-color: #4dbfbf;
        }

        .text-nafssiti-green {
            color: #96d14b;
        }

        .bg-nafssiti-green {
            background-color: #96d14b;
        }
    </style>
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

            <div class="mt-6 relative w-48 mx-auto">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                </div>
                <div class="relative flex justify-between">
                    <div id="step-1-indicator"
                        class="bg-nafssiti-blue text-white w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold shadow-sm">
                        1</div>
                    <div id="step-2-indicator"
                        class="bg-gray-200 dark:bg-gray-700 text-gray-500 w-8 h-8 flex items-center justify-center rounded-full text-sm font-bold">
                        2</div>
                </div>
            </div>
        </div>

        <form action="{{ route('register.psychologue') }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            <div id="form-part-1"
                class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 border border-gray-100 dark:border-gray-700 animate-fade-in">
                <div
                    class="flex items-center mb-5 text-nafssiti-blue border-b border-gray-50 dark:border-gray-700 pb-3">
                    <i class="fas fa-id-card mr-2"></i>
                    <h3 class="font-bold uppercase text-xs tracking-wider">Informations du compte</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Nom
                            Complet</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Téléphone</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Mot de
                            passe</label>
                        <input type="password" name="password" required
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Confirmation</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-nafssiti-blue/20 focus:border-nafssiti-blue outline-none dark:text-white transition">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="goToStep(2)"
                        class="bg-nafssiti-blue hover:bg-[#3da3a3] text-white px-8 py-2 rounded-lg font-bold text-sm shadow-sm transition-all flex items-center">
                        Suivant <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                    </button>
                </div>
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
            </div>
            <div id="form-part-2"
                class="hidden bg-white dark:bg-gray-800 shadow-md rounded-xl p-6 border border-gray-100 dark:border-gray-700 animate-fade-in">
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
                <div
                    class="flex items-center mb-5 text-nafssiti-green border-b border-gray-50 dark:border-gray-700 pb-3">
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
                            @foreach($specialities as $speciality)
                                <option value="{{ $speciality->name }}">{{ $speciality->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Ville</label>
                        <input type="text" name="city"
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Expérience
                            (Ans)</label>
                        <input type="number" name="experienceYears"
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Consultation</label>
                        <select name="consultationType"
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                            <option value="online">En ligne</option>
                            <option value="onsite">Cabinet</option>
                            <option value="both">Les deux</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">
                            Prix par session
                        </label>

                        <input type="number" name="pricePerSession"
                            class="w-full px-3 py-2 text-sm bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg dark:text-white outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">
                            Photo de profil
                        </label>

                        <input type="file" name="avatar" required accept="image/*"
                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-nafssiti-blue/10 file:text-nafssiti-blue hover:file:bg-nafssiti-blue/20 cursor-pointer">
                    </div>
                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase mb-1">Certificat
                            (PDF/Image)</label>
                        <input type="file" name="certificate"
                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-nafssiti-blue/10 file:text-nafssiti-blue hover:file:bg-nafssiti-blue/20 cursor-pointer" />
                    </div>
                </div>

                <div class="mt-6 flex justify-between items-center border-t border-gray-50 dark:border-gray-700 pt-4">
                    <button type="button" onclick="goToStep(1)"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs font-bold flex items-center transition">
                        <i class="fas fa-chevron-left mr-1"></i> Retour
                    </button>
                    <button type="submit"
                        class="bg-nafssiti-green hover:bg-[#85bc41] text-white px-8 py-2 rounded-lg font-bold text-sm shadow-sm transition-all">
                        Confirmer l'inscription
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function goToStep(step) {
        const part1 = document.getElementById('form-part-1');
        const part2 = document.getElementById('form-part-2');
        const indicator1 = document.getElementById('step-1-indicator');
        const indicator2 = document.getElementById('step-2-indicator');

        if (step === 2) {
            // Animation vers l'étape 2
            part1.classList.add('hidden');
            part2.classList.remove('hidden');

            // Mise à jour visuelle progression
            indicator2.classList.replace('bg-gray-200', 'bg-green-600');
            indicator2.classList.replace('text-gray-600', 'text-white');
            indicator1.classList.replace('bg-nafssiti-blue', 'bg-gray-400');
        } else {
            // Retour vers l'étape 1
            part2.classList.add('hidden');
            part1.classList.remove('hidden');

            // Mise à jour visuelle progression
            indicator2.classList.replace('bg-green-600', 'bg-gray-200');
            indicator2.classList.replace('text-white', 'text-gray-600');
            indicator1.classList.replace('bg-gray-400', 'bg-nafssiti-blue');
        }
    }
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

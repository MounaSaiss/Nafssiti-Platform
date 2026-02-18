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
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 transition-colors duration-300">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Nafssiti" class="mx-auto h-16 w-auto">

        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
            Créer un compte Patient
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
            Déjà inscrit ?
            <a href="/login" class="font-medium text-nafssiti-blue hover:text-opacity-80">
                Connectez-vous ici
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="absolute top-4 left-4 sm:top-8 sm:left-8">
            <a href="/" class="flex items-center text-gray-500 hover:text-nafssiti-blue dark:text-gray-400 dark:hover:text-white transition-colors group">
                <div class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-sm border border-gray-100 dark:border-gray-700 mr-3 group-hover:shadow-md transition-all">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                <span class="text-xs font-bold uppercase tracking-widest hidden sm:inline">Accueil</span>
            </a>
        </div>
        <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl sm:px-10">
            <form class="space-y-5" action="#" method="POST">

                <input type="hidden" name="role" value="user">

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Nom complet
                    </label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400 text-sm"></i>
                        </div>
                        <input id="name" name="name" type="text" placeholder="Nom complet" required
                            class="appearance-none block w-full pl-10 px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-nafssiti-blue focus:border-nafssiti-blue dark:bg-gray-700 dark:text-white sm:text-sm transition">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Adresse e-mail
                    </label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input id="email" name="email" type="email" placeholder="email@mail.com" required
                            class="appearance-none block w-full pl-10 px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-nafssiti-blue focus:border-nafssiti-blue dark:bg-gray-700 dark:text-white sm:text-sm transition">
                    </div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Numéro de téléphone
                    </label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400 text-sm"></i>
                        </div>
                        <input id="phone" name="phone" type="tel" placeholder="06XXXXXXXX" required
                            class="appearance-none block w-full pl-10 px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-nafssiti-blue focus:border-nafssiti-blue dark:bg-gray-700 dark:text-white sm:text-sm transition">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Mot de passe
                    </label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input id="password" name="password" type="password" required placeholder="**********"
                            class="appearance-none block w-full pl-10 px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-nafssiti-blue focus:border-nafssiti-blue dark:bg-gray-700 dark:text-white sm:text-sm transition">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères.</p>
                </div>

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                        class="h-4 w-4 text-nafssiti-blue focus:ring-nafssiti-blue border-gray-300 rounded cursor-pointer">
                    <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                        J'accepte les <a href="#" class="text-nafssiti-blue underline">Conditions Générales</a> d'Utilisation.
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-nafssiti-blue hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-nafssiti-blue transition-all transform hover:scale-[1.01]">
                        S'inscrire en tant que Patient
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Vous êtes un Spécialiste ?
                    <a href="/register/psychologue" class="text-green-600 font-bold hover:underline">Inscrivez-vous ici</a>
                </p>
            </div>
        </div>
    </div>
</div>
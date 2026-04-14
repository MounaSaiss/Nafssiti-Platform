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
<div
    class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8 transition-colors duration-300">
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
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Nafssiti" class="mx-auto h-16 w-auto">

        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
            Connexion à votre espace
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
            Ou
            <a href="/register/user" class="font-medium text-nafssiti-blue hover:text-opacity-80">
                créez un compte gratuitement
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div
            class="bg-white dark:bg-gray-800 py-8 px-4 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl sm:px-10">
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Adresse e-mail
                    </label>
                    <div class="mt-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
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
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full pl-10 px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-nafssiti-blue focus:border-nafssiti-blue dark:bg-gray-700 dark:text-white sm:text-sm transition">
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-md text-sm font-bold text-white bg-nafssiti-blue hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-nafssiti-blue transition-all transform hover:scale-[1.02]">
                        Se connecter
                    </button>
                </div>
                {{-- Valide les errors --}}
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="my-2 text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>
        </div>
    </div>
</div>

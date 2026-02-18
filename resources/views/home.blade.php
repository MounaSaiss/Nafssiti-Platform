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

<body class="bg-gray-50 font-sans">

    <nav class="bg-white dark:bg-gray-900 shadow-md sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Nafssiti" class="h-12 w-auto">
                </div>

                <div class="hidden lg:flex items-center space-x-6 text-sm font-semibold text-gray-700 dark:text-gray-200">
                    <a href="/" class="hover:text-nafssiti-blue transition border-b-2 border-transparent hover:border-nafssiti-blue py-1">Accueil</a>
                    <a href="/psychologues" class="hover:text-nafssiti-blue transition border-b-2 border-transparent hover:border-nafssiti-blue py-1">Psychologues</a>
                    <a href="/a-propos" class="hover:text-nafssiti-blue transition border-b-2 border-transparent hover:border-nafssiti-blue py-1">À propos</a>
                    <a href="/comment-ca-marche" class="hover:text-nafssiti-blue transition border-b-2 border-transparent hover:border-nafssiti-blue py-1">Comment ça marche ?</a>
                    <a href="/contact" class="hover:text-nafssiti-blue transition border-b-2 border-transparent hover:border-nafssiti-blue py-1">Contact</a>
                </div>

                <div class="flex items-center space-x-4">

                    <div class="relative group">
                        <button class="flex items-center text-gray-600 dark:text-gray-300 hover:text-nafssiti-blue transition focus:outline-none">
                            <i class="fas fa-globe mr-1"></i>
                            <span class="text-xs font-bold uppercase">FR</span>
                            <i class="fas fa-chevron-down ml-1 text-[10px]"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-24 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg shadow-lg hidden group-hover:block transition-all">
                            <a href="?lang=fr" class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Français</a>
                            <a href="?lang=ar" class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 text-right">العربية</a>
                            <a href="?lang=en" class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">English</a>
                        </div>
                    </div>

                    <div class="hidden md:block h-6 border-l border-gray-200 dark:border-gray-700 mx-2"></div>

                    <div class="hidden md:flex items-center space-x-3">
                        <a  href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-nafssiti-blue font-bold px-3 py-2 transition">
                            Connexion
                        </a>

                        <div class="relative group">
                            <button class="bg-nafssiti-blue text-white px-5 py-2.5 rounded-full font-bold shadow-md hover:bg-opacity-90 flex items-center transition">
                                Inscription
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>

                            <div class="absolute right-0 w-48 mt-2 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden group-hover:block animate-fade-in">
                                <a href="{{ route('register.user') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-circle mr-2 text-nafssiti-blue"></i> Je suis un Patient
                                </a>
                                <div class="border-t border-gray-100 dark:border-gray-700"></div>
                                <a href="{{ route('register.psychologue') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-md mr-2 text-green-500"></i> Je suis Spécialiste
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="lg:hidden flex items-center">
                        <button class="text-nafssiti-blue focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <header class="relative bg-white overflow-hidden py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">

            <div class="md:w-1/2 space-y-6">
                <span class="inline-block px-4 py-1.5 bg-nafssiti-blue/10 text-nafssiti-blue rounded-full text-sm font-bold tracking-wide uppercase">
                    Bienvenue sur Nafssiti
                </span>

                <h1 class="text-5xl font-extrabold text-gray-900 leading-tight">
                    Votre bien-être mental <br><span class="text-nafssiti-blue">commence ici.</span>
                </h1>

                <p class="text-lg text-gray-600 max-w-lg">
                    Nafssiti est votre plateforme dédiée au soutien psychologique. Nous connectons l'esprit et la technologie pour vous offrir un accompagnement personnalisé et bienveillant.
                </p>

                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="/psychologues" class="bg-nafssiti-blue text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:bg-opacity-90 hover:-translate-y-1 transition-all flex items-center group">
                        <i class="fas fa-search mr-2 group-hover:scale-110 transition"></i>
                        Trouver un psychologue
                    </a>

                    <a href="/register/psychologue" class="bg-white text-nafssiti-green border-2 border-nafssiti-green px-8 py-4 rounded-xl font-bold hover:bg-nafssiti-green hover:-translate-y-1 transition-all flex items-center group">
                        <i class="fas fa-user-md mr-2 group-hover:scale-110 transition"></i>
                        Devenir psychologue
                    </a>
                </div>

                <div class="flex space-x-5 pt-8 items-center">
                    <span class="text-gray-400 text-sm font-medium uppercase tracking-widest">Suivez-nous :</span>
                    <a href="#" class="text-xl text-nafssiti-blue hover:text-nafssiti-green transition-colors"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-xl text-nafssiti-blue hover:text-nafssiti-green transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-xl text-nafssiti-blue hover:text-nafssiti-green transition-colors"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center relative">
                <div class="absolute inset-0 bg-nafssiti-blue/5 rounded-full blur-3xl scale-75"></div>
                <img src="{{ asset('images/logo.png') }}" alt="Nafssiti Logo" class="relative w-full max-w-md animate-pulse-slow">
            </div>
        </div>
    </header>

    <section id="why-nafssiti" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-14">
                Pourquoi choisir <span class="text-nafssiti-blue">Nafssiti</span> ?
            </h2>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-nafssiti-blue transform hover:scale-105 transition-all duration-300 group">
                    <div class="text-6xl mb-6 text-nafssiti-blue group-hover:text-nafssiti-green transition-colors">
                        <i class="fas fa-universal-access"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Accès Facile</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Trouvez et contactez un psychologue où que vous soyez, quand vous en avez besoin. Votre bien-être est à portée de clic, sans contrainte géographique ni horaire.
                    </p>
                </div>

                <div class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-nafssiti-green transform hover:scale-105 transition-all duration-300 group">
                    <div class="text-6xl mb-6 text-nafssiti-green group-hover:text-nafssiti-blue transition-colors">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Psychologues Certifiés</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Notre plateforme ne référence que des professionnels diplômés et vérifiés, vous garantissant un accompagnement de qualité et en toute confiance.
                    </p>
                </div>

                <div class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-nafssiti-blue transform hover:scale-105 transition-all duration-300 group">
                    <div class="text-6xl mb-6 text-nafssiti-blue group-hover:text-nafssiti-green transition-colors">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Réservation Rapide</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Prenez rendez-vous en quelques minutes grâce à notre système intuitif. Choisissez votre créneau et commencez votre parcours de mieux-être sans attendre.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-12 lg:py-16 bg-white min-h-[90vh] flex flex-col justify-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-14">
                    Comment ça <span class="text-nafssiti-blue">marche ?</span>
                </h2>
            </div>

            <div class="relative">
                <div class="grid lg:grid-cols-2 gap-6 lg:gap-10 items-stretch">

                    <div class="bg-gray-50/80 backdrop-blur-sm p-6 lg:p-8 rounded-[2.5rem] border border-gray-100 shadow-lg hover:shadow-2xl transition-all duration-500">
                        <div class="inline-flex items-center px-4 py-1 rounded-full bg-nafssiti-blue text-white text-[10px] font-black uppercase tracking-[0.2em] mb-6">
                            Pour vous
                        </div>

                        <div class="space-y-6 border-l-2 border-nafssiti-blue/30 pl-6">
                            <div class="relative">
                                <span class="absolute -left-[33px] top-1 w-4 h-4 rounded-full bg-white border-4 border-nafssiti-blue shadow-sm"></span>
                                <h4 class="text-lg font-bold text-gray-900 leading-tight">Créez votre espace</h4>
                                <p class="text-gray-500 mt-1 text-sm font-light">Compte privé et sécurisé en quelques secondes.</p>
                            </div>
                            <div class="relative">
                                <span class="absolute -left-[33px] top-1 w-4 h-4 rounded-full bg-white border-4 border-nafssiti-blue shadow-sm"></span>
                                <h4 class="text-lg font-bold text-gray-900 leading-tight">Choisissez votre équilibre</h4>
                                <p class="text-gray-500 mt-1 text-sm font-light">Trouvez l'expert qui vous correspond vraiment.</p>
                            </div>
                            <div class="relative">
                                <span class="absolute -left-[33px] top-1 w-4 h-4 rounded-full bg-white border-4 border-nafssiti-blue shadow-sm"></span>
                                <h4 class="text-lg font-bold text-gray-900 leading-tight">Commencez à parler</h4>
                                <p class="text-gray-500 mt-1 text-sm font-light">Débutez votre accompagnement vidéo immédiatement.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50/80 backdrop-blur-sm p-6 lg:p-8 rounded-[2.5rem] border border-gray-100 shadow-lg hover:shadow-2xl transition-all duration-500">
                        <div class="inline-flex items-center px-4 py-1 rounded-full bg-nafssiti-green text-white text-[10px] font-black uppercase tracking-[0.2em] mb-6">
                            Pour les praticiens
                        </div>

                        <div class="space-y-6 border-l-2 border-nafssiti-green/30 pl-6">
                            <div class="relative">
                                <span class="absolute -left-[33px] top-1 w-4 h-4 rounded-full bg-white border-4 border-nafssiti-green shadow-sm"></span>
                                <h4 class="text-lg font-bold text-gray-900 leading-tight">Rejoignez le réseau</h4>
                                <p class="text-gray-500 mt-1 text-sm font-light">Validation stricte de vos diplômes pour l'excellence.</p>
                            </div>
                            <div class="relative">
                                <span class="absolute -left-[33px] top-1 w-4 h-4 rounded-full bg-white border-4 border-nafssiti-green shadow-sm"></span>
                                <h4 class="text-lg font-bold text-gray-900 leading-tight">Gérez votre cabinet</h4>
                                <p class="text-gray-500 mt-1 text-sm font-light">Outils complets de prise de RDV et suivi patient.</p>
                            </div>
                            <div class="relative">
                                <span class="absolute -left-[33px] top-1 w-4 h-4 rounded-full bg-white border-4 border-nafssiti-green shadow-sm"></span>
                                <h4 class="text-lg font-bold text-gray-900 leading-tight">Développez votre impact</h4>
                                <p class="text-gray-500 mt-1 text-sm font-light">Accompagnez vos patients en visioconférence.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="/register" class="inline-flex items-center px-3 py-2 rounded-full font-bold text-white transition-all duration-300 bg-[#d62828] shadow-lg  transform hover:-translate-y-1">
                    <span class="flex items-center tracking-wide">
                        Commencer L'aventure
                        <i class="fas fa-arrow-right ml-3"></i>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <section id="popular-psychologists" class="min-h-screen flex flex-col justify-center py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="text-center mb-10">
                <h2 class="text-4xl font-extrabold text-gray-900 mb-14">
                    Psychologues <span class="text-nafssiti-blue">populaires</span>
                </h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                <div class="bg-white rounded-[2rem] p-5 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img src="{{ asset('images/doctor1.jpg') }}"
                            alt="Nom"
                            class="w-full h-full object-cover rounded-2xl shadow-md">
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-black text-gray-900 leading-tight">Dr. Sarah Mansouri</h3>
                        <p class="text-nafssiti-blue text-xs font-bold uppercase tracking-wider mb-3">Psychologie Clinique</p>
                        <div class="flex flex-wrap justify-center gap-2 mb-4">
                            <span class="text-[10px] bg-gray-100 px-2 py-1 rounded-md text-gray-600">
                                <i class="fas fa-map-marker-alt mr-1"></i> Casablanca
                            </span>
                            <span class="text-[10px] bg-gray-100 px-2 py-1 rounded-md text-gray-600">
                                <i class="fas fa-history mr-1"></i> 12 ans exp.
                            </span>
                            <span class="text-[10px] bg-nafssiti-green/10 text-nafssiti-green px-2 py-1 rounded-md font-bold">
                                <i class="fas fa-video mr-1"></i> Hybride
                            </span>
                        </div>
                        <a href="#" class="inline-block w-full py-3 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-nafssiti-blue transition-colors">
                            Profil complet
                        </a>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] p-5 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img src="{{ asset('images/doctor2.webp') }}" alt="Nom" class="w-full h-full object-cover rounded-2xl shadow-md">
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-black text-gray-900 leading-tight">Dr. Karim Alami</h3>
                        <p class="text-nafssiti-blue text-xs font-bold uppercase tracking-wider mb-3">Thérapie TCC</p>
                        <div class="flex flex-wrap justify-center gap-2 mb-4">
                            <span class="text-[10px] bg-gray-100 px-2 py-1 rounded-md text-gray-600"><i class="fas fa-map-marker-alt mr-1"></i> Rabat</span>
                            <span class="text-[10px] bg-gray-100 px-2 py-1 rounded-md text-gray-600"><i class="fas fa-history mr-1"></i> 8 ans exp.</span>
                            <span class="text-[10px] bg-nafssiti-green/10 text-nafssiti-green px-2 py-1 rounded-md font-bold"><i class="fas fa-laptop mr-1"></i> Online</span>
                        </div>
                        <a href="#" class="inline-block w-full py-3 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-nafssiti-blue transition-colors">Profil complet</a>
                    </div>
                </div>
                <div class="bg-white rounded-[2rem] p-5 shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative w-24 h-24 mx-auto mb-4">
                        <img src="{{ asset('images/doctor3.jpg') }}" alt="Nom" class="w-full h-full object-cover rounded-2xl shadow-md">
                    </div>
                    <div class="text-center">
                        <h3 class="text-lg font-black text-gray-900 leading-tight">Dr. Leila Toumi</h3>
                        <p class="text-nafssiti-blue text-xs font-bold uppercase tracking-wider mb-3">Pédopsychologue</p>
                        <div class="flex flex-wrap justify-center gap-2 mb-4">
                            <span class="text-[10px] bg-gray-100 px-2 py-1 rounded-md text-gray-600"><i class="fas fa-map-marker-alt mr-1"></i> Tanger</span>
                            <span class="text-[10px] bg-gray-100 px-2 py-1 rounded-md text-gray-600"><i class="fas fa-history mr-1"></i> 15 ans exp.</span>
                            <span class="text-[10px] bg-nafssiti-green/10 text-nafssiti-green px-2 py-1 rounded-md font-bold"><i class="fas fa-laptop mr-1"></i> Online</span>
                        </div>
                        <a href="#" class="inline-block w-full py-3 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-nafssiti-blue transition-colors">Profil complet</a>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <a href="/psychologues" class="group relative inline-flex items-center px-10 py-4 bg-[#96d14b] text-black font-black tracking-widest uppercase text-xs rounded-full shadow-[0_10px_20px_rgba(150,209,75,0.3)] hover:shadow-[0_15px_30px_rgba(150,209,75,0.5)] transition-all duration-300 transform hover:-translate-y-1">
                    <span class="relative flex items-center">
                        Explorer plus de psychologues
                        <div class="ml-3 relative">
                            <i class="fas fa-search text-[14px]"></i>
                            <i class="fas fa-plus absolute -top-1 -right-1 text-[8px] group-hover:scale-125 transition-transform"></i>
                        </div>
                    </span>
                    <span class="absolute inset-0 rounded-full bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                </a>
            </div>
        </div>
    </section>
    <section id="final-cta" class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-4 text-center">

            <div class="inline-flex items-center justify-center space-x-4 mb-8">
                <span class="w-12 h-px bg-nafssiti-blue/30"></span>
                <span class="text-nafssiti-blue font-bold text-xs uppercase tracking-[0.3em]">Faites le premier pas</span>
                <span class="w-12 h-px bg-nafssiti-blue/30"></span>
            </div>

            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-8 leading-tight">
                Prenez soin de votre santé <br>
                <span class="text-nafssiti-green">mentale dès aujourd’hui.</span>
            </h2>

            <p class="text-gray-500 text-lg mb-12 font-light max-w-2xl mx-auto">
                Accédez à un accompagnement professionnel, sécurisé et bienveillant en quelques clics seulement.
            </p>

            <div class="flex flex-col items-center gap-6">
                <a href="/register" class="group inline-flex items-center px-12 py-5 rounded-full font-black text-white transition-all duration-300 bg-[#e63946] hover:bg-[#d62828] shadow-xl shadow-red-100 transform hover:-translate-y-1">
                    <span class="tracking-widest uppercase text-sm">
                        S’inscrire maintenant
                    </span>
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                </a>

                <div class="flex flex-wrap justify-center items-center gap-4 mt-10">
                    <div class="flex items-center bg-white border border-gray-100 px-4 py-2 rounded-2xl shadow-sm group ">
                        <div class="w-8 h-8 rounded-full bg-nafssiti-green/10 flex items-center justify-center mr-3 group-hover:bg-nafssiti-green group-hover:text-white transition-colors">
                            <i class="fas fa-unlock-alt text-[12px] text-nafssiti-green"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-500">Sans engagement</span>
                    </div>

                    <div class="flex items-center bg-white border border-gray-100 px-4 py-2 rounded-2xl shadow-sm group">
                        <div class="w-8 h-8 rounded-full bg-nafssiti-blue/10 flex items-center justify-center mr-3 group-hover:bg-nafssiti-blue group-hover:text-white transition-colors">
                            <i class="fas fa-user-secret text-[12px] text-nafssiti-blue "></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-500">100% Anonyme</span>
                    </div>

                    <div class="flex items-center bg-white border border-gray-100 px-4 py-2 rounded-2xl shadow-sm group ">
                        <div class="w-8 h-8 rounded-full bg-nafssiti-green/10 flex items-center justify-center mr-3 group-hover:bg-nafssiti-green group-hover:text-white transition-colors">
                            <i class="fas fa-shield-alt text-[12px] text-nafssiti-green"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-500">Paiement sécurisé</span>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <footer id="contact" class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-3 gap-12">
            <div>
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Nafssiti" class="h-12 w-auto">
                </div>
                <br>
                <p class="text-gray-400">Prendre soin de votre santé mentale n'a jamais été aussi accessible.</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Liens rapides</h4>
                <ul class="text-gray-400 space-y-2">
                    <li><a href="#" class="hover:text-nafssiti-green">Accueil</a></li>
                    <li><a href="#" class="hover:text-nafssiti-green">Psychologues</a></li>
                    <li><a href="#" class="hover:text-nafssiti-green">À propos</a></li>
                    <li><a href="#" class="hover:text-nafssiti-green">Comment ça marche ?</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Contact</h4>
                <p class="text-gray-400">contact@nafssiti.com</p>
                <p class="text-gray-400">+212 600 000 000</p>
            </div>
        </div>
        <div class="text-center mt-12 pt-8 border-t border-gray-800 text-gray-500">
            &copy; 2026 Nafssiti. Tous droits réservés.
        </div>
    </footer>

</body>

</html>
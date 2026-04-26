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
<body class="bg-gray-50 font-sans">

    <nav class="bg-white dark:bg-gray-900 shadow-md sticky top-0 z-50 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">

                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Nafssiti" class="h-12 w-auto">
                </div>

                <div
                    class="hidden lg:flex items-center space-x-6 text-sm font-semibold text-gray-700 dark:text-gray-200">
                    <a href="/"
                        class="hover:text-nafssiti-blue transition border-b-2 border-transparent hover:border-nafssiti-blue py-1">Accueil</a>
                    <a href="{{ route('psychologue.allPsychologues') }}"
                        class="hover:text-nafssiti-blue transition border-b-2 border-transparent hover:border-nafssiti-blue py-1">Psychologues</a>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="relative group">
                        <button
                            class="flex items-center text-gray-600 dark:text-gray-300 hover:text-nafssiti-blue transition focus:outline-none">
                            <i class="fas fa-globe mr-1"></i>
                            <span class="text-xs font-bold uppercase">FR</span>
                            <i class="fas fa-chevron-down ml-1 text-[10px]"></i>
                        </button>
                        <div
                            class="absolute right-0 mt-2 w-24 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg shadow-lg hidden group-hover:block transition-all">
                            <a href="?lang=fr"
                                class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Français</a>
                            <a href="?lang=ar"
                                class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 text-right">العربية</a>
                            <a href="?lang=en"
                                class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">English</a>
                        </div>
                    </div>

                    <div class="hidden md:block h-6 border-l border-gray-200 dark:border-gray-700 mx-2"></div>

                    <div class="hidden md:flex items-center space-x-3">
                        <a href="{{ route('login') }}"
                            class="text-gray-600 dark:text-gray-300 hover:text-nafssiti-blue font-bold px-3 py-2 transition">
                            Connexion
                        </a>

                        <div class="relative group">
                            <button
                                class="bg-nafssiti-blue text-white px-5 py-2.5 rounded-full font-bold shadow-md hover:bg-opacity-90 flex items-center transition">
                                Inscription
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>

                            <div
                                class="absolute right-0 w-48 mt-2 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 hidden group-hover:block animate-fade-in">
                                <a href="{{ route('show.register.patient') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-circle mr-2 text-nafssiti-blue"></i> Je suis un Patient
                                </a>
                                <div class="border-t border-gray-100 dark:border-gray-700"></div>
                                <a href="{{ route('register.psychologue') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user-md mr-2 text-green-500"></i> Je suis Spécialiste
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="lg:hidden flex items-center">
                        <button id="mobile-menu-button" class="text-nafssiti-blue focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile menu overlay -->
    <div id="mobile-menu" class="fixed inset-0 z-[60] bg-white transform translate-x-full transition-transform duration-300 lg:hidden overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-10">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Nafssiti" class="h-12 w-auto">
                <button id="close-menu-button" class="text-nafssiti-blue focus:outline-none hover:rotate-90 transition-transform duration-300">
                    <i class="fas fa-times text-3xl"></i>
                </button>
            </div>
            
            <div class="flex flex-col space-y-8">
                <div class="flex flex-col space-y-6 text-xl font-bold text-gray-800">
                    <a href="/" class="flex items-center space-x-4 hover:text-nafssiti-blue transition">
                        <i class="fas fa-home w-8 text-nafssiti-blue text-center"></i>
                        <span>Accueil</span>
                    </a>
                    <a href="{{ route('psychologue.allPsychologues') }}" class="flex items-center space-x-4 hover:text-nafssiti-blue transition">
                        <i class="fas fa-user-md w-8 text-nafssiti-blue text-center"></i>
                        <span>Psychologues</span>
                    </a>
                </div>

                <div class="pt-8 border-t border-gray-100">
                    <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-6">Compte</h3>
                    <div class="flex flex-col space-y-6">
                        <a href="{{ route('login') }}" class="flex items-center space-x-4 text-lg font-bold text-gray-700 hover:text-nafssiti-blue transition">
                            <i class="fas fa-sign-in-alt w-8 text-center"></i>
                            <span>Connexion</span>
                        </a>
                        <a href="{{ route('show.register.patient') }}" class="flex items-center space-x-4 p-4 bg-nafssiti-blue/5 rounded-2xl text-nafssiti-blue font-bold hover:bg-nafssiti-blue hover:text-white transition-all group">
                            <div class="w-10 h-10 rounded-xl bg-nafssiti-blue/10 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                <i class="fas fa-user-circle text-lg"></i>
                            </div>
                            <span>Je suis un Patient</span>
                        </a>
                        <a href="{{ route('register.psychologue') }}" class="flex items-center space-x-4 p-4 bg-green-50 rounded-2xl text-green-600 font-bold hover:bg-green-600 hover:text-white transition-all group">
                            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                <i class="fas fa-certificate text-lg"></i>
                            </div>
                            <span>Je suis Spécialiste</span>
                        </a>
                    </div>
                </div>

                <div class="pt-8 flex justify-center space-x-6 text-gray-400">
                    <a href="#" class="text-2xl hover:text-nafssiti-blue transition-colors"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-2xl hover:text-nafssiti-blue transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-2xl hover:text-nafssiti-blue transition-colors"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>

    <header class="relative bg-white overflow-hidden py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">

            <div class="md:w-1/2 space-y-6">
                <span
                    class="inline-block px-4 py-1.5 bg-nafssiti-blue/10 text-nafssiti-blue rounded-full text-sm font-bold tracking-wide uppercase">
                    Bienvenue sur Nafssiti
                </span>

                <h1 class="text-5xl font-extrabold text-gray-900 leading-tight">
                    Votre bien-être mental <br><span class="text-nafssiti-blue">commence ici.</span>
                </h1>

                <p class="text-lg text-gray-600 max-w-lg">
                    Nafssiti est votre plateforme dédiée au soutien psychologique. Nous connectons l'esprit et la
                    technologie pour vous offrir un accompagnement personnalisé et bienveillant.
                </p>

                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="{{ route('psychologue.allPsychologues') }}"
                        class="bg-nafssiti-blue text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:bg-opacity-90 hover:-translate-y-1 transition-all flex items-center group">
                        <i class="fas fa-search mr-2 group-hover:scale-110 transition"></i>
                        Trouver un psychologue
                    </a>

                    <a href="{{ route('register.psychologue') }}"
                        class="bg-white text-nafssiti-green border-2 border-nafssiti-green px-8 py-4 rounded-xl font-bold hover:bg-nafssiti-green hover:-translate-y-1 transition-all flex items-center group">
                        <i class="fas fa-user-md mr-2 group-hover:scale-110 transition"></i>
                        Devenir psychologue
                    </a>
                </div>

                <div class="flex space-x-5 pt-8 items-center">
                    <span class="text-gray-400 text-sm font-medium uppercase tracking-widest">Suivez-nous :</span>
                    <a href="#" class="text-xl text-nafssiti-blue hover:text-nafssiti-green transition-colors"><i
                            class="fab fa-facebook"></i></a>
                    <a href="#" class="text-xl text-nafssiti-blue hover:text-nafssiti-green transition-colors"><i
                            class="fab fa-instagram"></i></a>
                    <a href="#" class="text-xl text-nafssiti-blue hover:text-nafssiti-green transition-colors"><i
                            class="fab fa-linkedin"></i></a>
                </div>
            </div>

            <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center relative">
                <div class="absolute inset-0 bg-nafssiti-blue/5 rounded-full blur-3xl scale-75"></div>
                <img src="{{ asset('images/logo.png') }}" alt="Nafssiti Logo"
                    class="relative w-full max-w-md animate-pulse-slow">
            </div>
        </div>
    </header>

    <section id="why-nafssiti" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-14">
                Pourquoi choisir <span class="text-nafssiti-blue">Nafssiti</span> ?
            </h2>

            <div class="grid md:grid-cols-3 gap-10">
                <div
                    class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-nafssiti-blue transform hover:scale-105 transition-all duration-300 group">
                    <div class="text-6xl mb-6 text-nafssiti-blue group-hover:text-nafssiti-green transition-colors">
                        <i class="fas fa-universal-access"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Accès Facile</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Trouvez et contactez un psychologue où que vous soyez, quand vous en avez besoin. Votre
                        bien-être est à portée de clic, sans contrainte géographique ni horaire.
                    </p>
                </div>

                <div
                    class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-nafssiti-green transform hover:scale-105 transition-all duration-300 group">
                    <div class="text-6xl mb-6 text-nafssiti-green group-hover:text-nafssiti-blue transition-colors">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Psychologues Certifiés</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Notre plateforme ne référence que des professionnels diplômés et vérifiés, vous garantissant un
                        accompagnement de qualité et en toute confiance.
                    </p>
                </div>

                <div
                    class="p-8 bg-white rounded-2xl shadow-lg border-b-4 border-nafssiti-blue transform hover:scale-105 transition-all duration-300 group">
                    <div class="text-6xl mb-6 text-nafssiti-blue group-hover:text-nafssiti-green transition-colors">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Réservation Rapide</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Prenez rendez-vous en quelques minutes grâce à notre système intuitif. Choisissez votre créneau
                        et commencez votre parcours de mieux-être sans attendre.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section id="final-cta" class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-4 text-center">

            <div class="inline-flex items-center justify-center space-x-4 mb-8">
                <span class="w-12 h-px bg-nafssiti-blue/30"></span>
                <span class="text-nafssiti-blue font-bold text-xs uppercase tracking-[0.3em]">Faites le premier
                    pas</span>
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
                <a href="{{ route('show.register.patient') }}"
                    class="group inline-flex items-center px-12 py-5 rounded-full font-black text-white transition-all duration-300 bg-[#e63946] hover:bg-[#d62828] shadow-xl shadow-red-100 transform hover:-translate-y-1">
                    <span class="tracking-widest uppercase text-sm">
                        S’inscrire maintenant
                    </span>
                    <i class="fas fa-arrow-right ml-3 group-hover:translate-x-2 transition-transform"></i>
                </a>

                <div class="flex flex-wrap justify-center items-center gap-4 mt-10">
                    <div
                        class="flex items-center bg-white border border-gray-100 px-4 py-2 rounded-2xl shadow-sm group ">
                        <div
                            class="w-8 h-8 rounded-full bg-nafssiti-green/10 flex items-center justify-center mr-3 group-hover:bg-nafssiti-green group-hover:text-white transition-colors">
                            <i class="fas fa-unlock-alt text-[12px] text-nafssiti-green"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-500">Sans
                            engagement</span>
                    </div>

                    <div
                        class="flex items-center bg-white border border-gray-100 px-4 py-2 rounded-2xl shadow-sm group">
                        <div
                            class="w-8 h-8 rounded-full bg-nafssiti-blue/10 flex items-center justify-center mr-3 group-hover:bg-nafssiti-blue group-hover:text-white transition-colors">
                            <i class="fas fa-user-secret text-[12px] text-nafssiti-blue "></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-500">100% Anonyme</span>
                    </div>

                    <div
                        class="flex items-center bg-white border border-gray-100 px-4 py-2 rounded-2xl shadow-sm group ">
                        <div
                            class="w-8 h-8 rounded-full bg-nafssiti-green/10 flex items-center justify-center mr-3 group-hover:bg-nafssiti-green group-hover:text-white transition-colors">
                            <i class="fas fa-shield-alt text-[12px] text-nafssiti-green"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-gray-500">Paiement
                            sécurisé</span>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMenuButton = document.getElementById('close-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            function toggleMenu() {
                mobileMenu.classList.toggle('translate-x-full');
                document.body.classList.toggle('overflow-hidden');
            }

            if (mobileMenuButton && mobileMenu && closeMenuButton) {
                mobileMenuButton.addEventListener('click', toggleMenu);
                closeMenuButton.addEventListener('click', toggleMenu);

                // Close menu when clicking on a link
                const menuLinks = mobileMenu.querySelectorAll('a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        // Only close if it's not a dummy link (#)
                        if (link.getAttribute('href') !== '#') {
                            toggleMenu();
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>
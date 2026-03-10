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
<section>
    <div class="bg-[#fafafa] min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-12">
                <h1 class="text-4xl font-[900] text-gray-900 leading-tight">
                    Nos <span class="text-nafssiti-blue">experts</span> en santé mentale
                </h1>
                <p class="text-gray-500 mt-4 max-w-2xl font-medium">
                    Trouvez le professionnel qui vous correspond parmi nos praticiens certifiés et vérifiés par nos
                    soins.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">

                <aside class="w-full lg:w-1/4 space-y-6">
                    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-6">Filtrer par</h3>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-900 mb-4">Spécialité</label>
                            <select
                                class="w-full bg-gray-50 border-none rounded-xl py-3 px-4 text-sm text-gray-600 focus:ring-2 focus:ring-nafssiti-blue/20">
                                <option>Toutes les spécialités</option>
                                <option>Anxiété & Stress</option>
                                <option>Dépression</option>
                                <option>Thérapie de couple</option>
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-900 mb-4">Disponibilité</label>
                            <div class="space-y-3">
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox"
                                        class="w-5 h-5 rounded border-gray-300 text-nafssiti-blue focus:ring-nafssiti-blue transition">
                                    <span
                                        class="ml-3 text-sm text-gray-500 group-hover:text-gray-900 transition">Disponible
                                        aujourd'hui</span>
                                </label>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="checkbox"
                                        class="w-5 h-5 rounded border-gray-300 text-nafssiti-blue focus:ring-nafssiti-blue transition">
                                    <span
                                        class="ml-3 text-sm text-gray-500 group-hover:text-gray-900 transition">Téléconsultation</span>
                                </label>
                            </div>
                        </div>

                        <button
                            class="w-full py-3 bg-gray-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-nafssiti-blue transition-all">
                            Appliquer
                        </button>
                    </div>
                </aside>

                <main class="w-full lg:w-3/4">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div
                            class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                            <div class="flex items-start gap-5">
                                <div class="relative">
                                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-gray-100">
                                        <img src="{{ asset('images/psychologue.jpg') }}" alt="Mouna"
                                            class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-nafssiti-green border-4 border-white rounded-full flex items-center justify-center shadow-sm"
                                        title="Vérifié">
                                        <i class="fas fa-check text-[10px] text-white"></i>
                                    </div>
                                </div>

                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-black text-gray-900">Mouna</h3>
                                            <p
                                                class="text-nafssiti-blue text-[10px] font-black uppercase tracking-widest mt-1">
                                                Psychologue clinicienne</p>
                                        </div>
                                        <div class="flex items-center bg-gray-50 px-2 py-1 rounded-lg">
                                            <i class="fas fa-star text-[#ffb800] text-[10px] mr-1"></i>
                                            <span class="text-[10px] font-bold text-gray-600">4.9</span>
                                        </div>
                                    </div>

                                    <p class="text-gray-500 text-xs mt-4 line-clamp-2 leading-relaxed">
                                        Psychologue clinicienne spécialisée dans l'accompagnement des adolescents et
                                        des jeunes adultes. Je propose des thérapies cognitivo-comportementales (TCC)
                                        et des approches humanistes pour vous aider à surmonter le stress, l'anxiété
                                        et les défis relationnels.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-50 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Prochaine
                                        dispo</p>
                                    <p class="text-xs font-bold text-gray-700">Demain, 10:00</p>
                                </div>
                                <a href="#"
                                    class="inline-flex items-center px-6 py-3 bg-gray-50 text-gray-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-nafssiti-green hover:text-white transition-all">
                                    Voir Profil
                                </a>
                            </div>
                        </div>


                    </div>

                    <div class="mt-12 flex justify-center">
                        <nav class="inline-flex space-x-2">
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 text-gray-400 hover:text-nafssiti-blue transition shadow-sm"><i
                                    class="fas fa-chevron-left text-xs"></i></a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-nafssiti-blue text-white font-bold shadow-lg shadow-cyan-100">1</a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 text-gray-400 hover:text-nafssiti-blue transition shadow-sm font-bold">2</a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-100 text-gray-400 hover:text-nafssiti-blue transition shadow-sm"><i
                                    class="fas fa-chevron-right text-xs"></i></a>
                        </nav>
                    </div>
                </main>

            </div>
        </div>
    </div>
</section>

</html>

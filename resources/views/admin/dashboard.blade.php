@extends('admin.layouts.app')

@section('title', 'Console Administration | NAFSSITI')

@section('page_title', 'Tableau de bord')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 border border-slate-200 shadow-sm rounded-sm">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Utilisateurs actifs</p>
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">12,842</h3>
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
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">156</h3>
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
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">4,209</h3>
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
                    <h3 class="text-2xl font-bold mt-1 tracking-tight">84,500 <span class="text-sm font-normal">DH</span>
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
            <h3 class="font-bold text-slate-800 uppercase tracking-widest text-sm italic">Validation des nouveaux praticiens
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 uppercase tracking-tight">
                        <th class="px-6 py-4 font-bold border-b border-slate-200">ID</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200">Praticien</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200">Spécialité</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-center">Fiche Profil</th>
                        <th class="px-6 py-4 font-bold border-b border-slate-200 text-right">Décision Rapide</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="px-6 py-4 font-mono text-slate-400">#PSY-0024</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-800 uppercase">Dr. Amine Bennani</span>
                                <span
                                    class="text-slate-400 font-light tracking-tight text-[11px]">amine.b@nafssiti.ma</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">Psychothérapie TCC</td>
                        <td class="px-6 py-4 text-center">
                            <button
                                class="text-nafssiti-primary hover:text-slate-800 transition-colors font-bold uppercase text-[10px]">
                                <i class="fas fa-external-link-alt mr-1"></i> Voir Profil
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button
                                    class="bg-nafssiti-secondary text-white px-4 py-1.5 rounded-sm font-bold hover:bg-green-600 shadow-sm transition uppercase text-[10px]">Approuver</button>
                                <button
                                    class="bg-nafssiti-red text-white px-4 py-1.5 rounded-sm font-bold hover:bg-red-600 shadow-sm transition uppercase text-[10px]">Refuser</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 font-mono text-slate-400">#PSY-0025</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-800 uppercase">Dr. Laila Joudi</span>
                                <span class="text-slate-400 font-light tracking-tight text-[11px]">laila.j@gmail.com</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">Pédopsychiatrie</td>
                        <td class="px-6 py-4 text-center">
                            <button
                                class="text-nafssiti-primary hover:text-slate-800 transition-colors font-bold uppercase text-[10px]">
                                <i class="fas fa-external-link-alt mr-1"></i> Voir Profil
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <button
                                    class="bg-nafssiti-secondary text-white px-4 py-1.5 rounded-sm font-bold hover:bg-green-600 shadow-sm transition uppercase text-[10px]">Approuver</button>
                                <button
                                    class="bg-nafssiti-red text-white px-4 py-1.5 rounded-sm font-bold hover:bg-red-600 shadow-sm transition uppercase text-[10px]">Refuser</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

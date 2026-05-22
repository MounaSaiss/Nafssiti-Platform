<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation en ligne | NAFSSITI</title>
    <script src="https://meet.jit.si/external_api.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }
        #jitsi-container {
            height: calc(100vh - 64px);
            width: 100%;
        }
        .nafssiti-gradient {
            background: linear-gradient(135deg, #4dbfbf 0%, #3a9191 100%);
        }
    </style>
</head>
<body>
    <!-- Navbar simplified -->
    <nav class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 shadow-sm relative z-10">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 nafssiti-gradient rounded-lg flex items-center justify-center text-white shadow-md">
                <i class="fas fa-video"></i>
            </div>
            <div>
                <h1 class="text-sm font-bold text-slate-800 tracking-tight">Consultation en direct</h1>
                <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest">
                    {{ $appointment->patient->user->name }} & {{ $appointment->psychologist->user->name }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden md:flex flex-col items-end px-4 border-r border-slate-100">
                <span class="text-[10px] font-bold text-nafssiti-secondary uppercase">Session Sécurisée</span>
                <span class="text-[9px] text-slate-400">Chiffrement de bout en bout</span>
            </div>
            <a href="javascript:history.back()" class="flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-red-50 text-slate-600 hover:text-red-500 rounded-lg text-xs font-bold transition-all border border-slate-100">
                <i class="fas fa-sign-out-alt"></i>
                <span class="hidden sm:inline">Quitter</span>
            </a>
        </div>
    </nav>

    <!-- Jitsi Container -->
    <div id="jitsi-container"></div>

    <script>
        window.onload = () => {
            const domain = "meet.jit.si"; //Domain Name for the jitsi server
            const options = {
                roomName: "{{ $appointment->jitsi_room_id }}",
                width: "100%",
                height: "100%",
                parentNode: document.querySelector('#jitsi-container'),
                userInfo: {
                    displayName: "{{ auth()->user()->name }}"
                },
                configOverwrite: {
                    startWithAudioMuted: false,
                    startWithVideoMuted: false,
                    prejoinPageEnabled: false,
                    disableDeepLinking: true,
                },
                interfaceConfigOverwrite: {
                    TOOLBAR_BUTTONS: [
                        'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                        'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                        'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                        'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                        'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone',
                        'security'
                    ],
                    SETTINGS_SECTIONS: ['devices', 'language', 'moderator', 'profile', 'calendar'],
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_WATERMARK_FOR_GUESTS: false,
                }
            };
            const api = new JitsiMeetExternalAPI(domain, options);

            // Handle hangup
            api.addEventListener('videoConferenceLeft', () => {
                window.location.href = "{{ auth()->user()->isPatient() ? route('patient.rendezVous') : route('psychologue.historique') }}";
            });
        };
    </script>
</body>
</html>

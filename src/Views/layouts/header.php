<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Consultor OS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gmr: { navy: '#1A2B42', gold: '#D4AF37', gold_light: '#F3E5AB', gray: '#F5F7FA' }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Playfair Display', 'serif'] }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Scrollbar fina e elegante para o menu */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.4); }
        
        /* Transição suave para ocultar texto */
        .fade-text { transition: opacity 0.2s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800" 
      x-data="{ 
          sidebarOpen: false, 
          sidebarCompact: localStorage.getItem('sidebarCompact') === 'true',
          toggleCompact() {
              this.sidebarCompact = !this.sidebarCompact;
              localStorage.setItem('sidebarCompact', this.sidebarCompact);
          }
      }">

<div class="flex h-screen overflow-hidden">
    
    <aside class="absolute inset-y-0 left-0 z-50 bg-gmr-navy text-white transition-all duration-300 transform lg:static lg:translate-x-0 flex flex-col border-r border-white/5"
           :class="[
               sidebarOpen ? 'translate-x-0' : '-translate-x-full',
               sidebarCompact ? 'lg:w-20' : 'lg:w-64',
               'w-64' /* Largura padrão mobile */
           ]">
        
        <div class="flex items-center justify-center h-20 border-b border-white/10 shrink-0 transition-all duration-300 overflow-hidden">
             <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gmr-gold rounded flex items-center justify-center text-gmr-navy font-bold font-serif shrink-0">OS</div>
                
                <span x-show="!sidebarCompact" 
                      x-transition:enter="transition ease-out duration-200"
                      x-transition:enter-start="opacity-0 -translate-x-2"
                      x-transition:enter-end="opacity-100 translate-x-0"
                      class="font-serif text-xl tracking-wide whitespace-nowrap">
                    Consultor<span class="text-gmr-gold">OS</span>
                </span>
            </div>
        </div>

        <nav class="flex-1 px-3 space-y-2 overflow-y-auto sidebar-scroll pb-4 mt-4">

            <?php 
            function renderMenuItem($url, $icon, $label, $activeKey, $compactMode = 'sidebarCompact') {
                $isActive = strpos($_SERVER['REQUEST_URI'], $activeKey) !== false;
                $baseClass = "flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 group relative";
                $activeClass = $isActive ? "bg-white/10 text-gmr-gold border-l-4 border-gmr-gold" : "text-gray-400 border-l-4 border-transparent hover:text-white hover:bg-white/5";
                
                echo '<a href="'.\App\Config\Config::BASE_URL.$url.'" class="'.$baseClass.' '.$activeClass.'" title="'.$label.'">';
                echo '<i class="'.$icon.' w-6 text-center text-lg shrink-0"></i>';
                echo '<span x-show="!'.$compactMode.'" class="font-medium whitespace-nowrap overflow-hidden transition-opacity duration-200">'.$label.'</span>';
                
                // Tooltip "Hover" quando estiver colapsado (opcional, para UX)
                echo '<div x-show="'.$compactMode.'" class="absolute left-14 bg-gmr-navy text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none border border-white/10 shadow-lg z-50 whitespace-nowrap">'.$label.'</div>';
                
                echo '</a>';
            }

            function renderSectionTitle($label, $compactMode = 'sidebarCompact') {
                echo '<div class="pt-4 pb-2" x-show="!'.$compactMode.'">';
                echo '<p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap overflow-hidden">'.$label.'</p>';
                echo '</div>';
                // Separador simples quando colapsado
                echo '<div class="my-4 border-t border-white/5 mx-2" x-show="'.$compactMode.'"></div>';
            }
            ?>

            <?php renderSectionTitle('Ferramentas Principais'); ?>
            <?php renderMenuItem('/dashboard', 'fas fa-chart-pie', 'Visão Geral', 'dashboard'); ?>
            <?php renderMenuItem('/leads', 'fas fa-users', 'Meus Leads', 'leads'); ?>
            <?php renderMenuItem('/simulador', 'fas fa-calculator', 'Simulador Pro', 'simulador'); ?>

            <?php renderSectionTitle('Ferramentas Auxiliares'); ?>
            <?php renderMenuItem('/ferramentas/lances', 'fas fa-search-dollar', 'Analista de Lances', 'lances'); ?>
            <?php renderMenuItem('/ferramentas/investidor', 'fas fa-chart-line', 'Investidor Pro', 'investidor'); ?>

            <?php renderSectionTitle('Controle'); ?>
            <?php renderMenuItem('/relatorios', 'fas fa-trophy', 'Minha Performance', 'relatorios'); ?>

            <?php renderSectionTitle('Sistema'); ?>
            <?php renderMenuItem('/manual', 'fas fa-book-open', 'Manual do Sistema', 'manual'); ?>
            <?php renderMenuItem('/configuracoes', 'fas fa-cog', 'Configurações', 'configuracoes'); ?>
            
            <div class="pt-4">
                <a href="<?= \App\Config\Config::BASE_URL ?>/logout" class="flex items-center gap-3 px-3 py-3 text-red-400 hover:text-red-300 hover:bg-white/5 rounded-lg transition-colors group relative" title="Sair">
                    <i class="fas fa-sign-out-alt w-6 text-center text-lg shrink-0"></i>
                    <span x-show="!sidebarCompact" class="font-medium whitespace-nowrap">Sair</span>
                </a>
            </div>

        </nav>

        <div class="hidden lg:flex items-center justify-center h-12 border-t border-white/10 shrink-0 cursor-pointer hover:bg-white/5 transition-colors"
             @click="toggleCompact()">
            <i class="fas text-gray-400 transition-transform duration-300" 
               :class="sidebarCompact ? 'fa-angle-double-right' : 'fa-angle-double-left'"></i>
        </div>

    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 z-40 relative">
    
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-gmr-navy hidden sm:block">Painel de Controle</h2>
            </div>

            <div class="flex items-center gap-6">
                
                <div x-data="{ 
                    notifOpen: false,
                    notifications: [],
                    init() { this.fetchNotifs(); setInterval(() => this.fetchNotifs(), 300000); },
                    fetchNotifs() {
                        fetch('<?= \App\Config\Config::BASE_URL ?>/api/notifications').then(r=>r.json()).then(d=>{this.notifications=d;});
                    },
                    clearAll() {
                        fetch('<?= \App\Config\Config::BASE_URL ?>/api/notifications/read', { method: 'POST' });
                        this.notifications = []; this.notifOpen = false;
                    }
                }" x-init="init()" class="relative">
                    
                    <button @click="notifOpen = !notifOpen; if(notifOpen) fetchNotifs()" @click.away="notifOpen = false" class="relative p-2 text-gray-400 hover:text-gmr-navy transition-colors focus:outline-none">
                        <i class="fas fa-bell text-xl"></i>
                        <span x-show="notifications.length > 0" x-transition.scale class="absolute top-1 right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                        </span>
                    </button>

                    <div x-show="notifOpen" style="display: none;" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                        <div class="bg-gmr-navy px-4 py-3 border-b border-white/10 flex justify-between items-center">
                            <p class="text-sm font-bold text-white">Notificações</p>
                            <span x-show="notifications.length > 0" class="text-xs bg-gmr-gold text-gmr-navy px-1.5 py-0.5 rounded font-bold" x-text="notifications.length"></span>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            <template x-for="note in notifications">
                                <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 transition">
                                    <p class="text-sm text-gmr-navy font-semibold" x-text="note.title"></p>
                                    <p class="text-xs text-gray-500 truncate" x-text="note.desc"></p>
                                    <p class="text-[10px] text-gray-400 mt-1" x-text="note.time"></p>
                                </a>
                            </template>
                            <div x-show="notifications.length === 0" class="px-4 py-8 text-center text-gray-400">
                                <i class="far fa-bell-slash text-2xl mb-2 opacity-50"></i>
                                <p class="text-xs">Tudo limpo por aqui!</p>
                            </div>
                        </div>
                        <div x-show="notifications.length > 0" class="bg-gray-50 px-4 py-2 text-center border-t border-gray-100">
                            <button @click="clearAll()" class="text-xs font-bold text-gmr-gold hover:text-yellow-600 hover:underline cursor-pointer focus:outline-none">Marcar todas como lidas</button>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 border-l pl-6 border-gray-200">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-gmr-navy"><?= isset($user) ? $user->name : 'Consultor' ?></p>
                        <p class="text-xs text-gray-500">Especialista GMR</p>
                    </div>
                    <div class="relative">
                        <?php 
                            $avatarPath = isset($user) && $user->avatar && $user->avatar != 'default.png' 
                                ? \App\Config\Config::BASE_URL . '/assets/img/' . $user->avatar 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Consultor') . '&background=1A2B42&color=D4AF37';
                        ?>
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-gmr-gold shadow-sm cursor-pointer hover:scale-105 transition-transform" src="<?= $avatarPath ?>" alt="Avatar">
                        <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-white bg-green-400"></span>
                    </div>
                </div>

            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
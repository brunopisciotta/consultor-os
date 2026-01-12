<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Consultor OS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gmr: {
                            navy: '#1A2B42',  
                            gold: '#D4AF37',  
                            gold_light: '#F3E5AB',
                            gray: '#F5F7FA',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        .bg-auth-pattern {
            background-color: #1A2B42;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23D4AF37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="h-screen w-full bg-gray-50 overflow-hidden font-sans text-gray-800">

    <div class="flex h-full w-full">
        
        <div class="hidden lg:flex w-1/2 bg-auth-pattern flex-col justify-between p-12 relative">
            <div class="z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gmr-gold rounded flex items-center justify-center text-gmr-navy font-bold text-xl font-serif">OS</div>
                    <span class="text-white font-serif text-2xl tracking-wide">Consultor<span class="text-gmr-gold">OS</span></span>
                </div>
            </div>

            <div class="z-10 mb-20">
                <h1 class="text-4xl font-serif text-white mb-4 leading-tight">
                    Inteligência para <br>
                    <span class="text-gmr-gold">Consórcios de Elite</span>
                </h1>
                <p class="text-gray-300 text-lg max-w-md leading-relaxed">
                    Copiloto de vendas, simulador avançado e gestão de leads. 
                    Transforme simulações em patrimônio.
                </p>
                
                <div class="mt-8 inline-flex items-center gap-3 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-sm text-white font-medium">Sistema Operacional v1.0</span>
                </div>
            </div>

            <div class="z-10 text-xs text-gray-500 uppercase tracking-widest">
                <a target="_blank" href="https://bpso.com.br">Desenvolvido por BPSO.</a>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md" x-data="{ showPass: false, loading: false }">
                
                <div class="lg:hidden mb-8 text-center">
                    <h2 class="text-3xl font-serif text-gmr-navy">Consultor<span class="text-gmr-gold">OS</span></h2>
                </div>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gmr-navy mb-2">Bem-vindo de volta</h2>
                    <p class="text-gray-500">Acesse seu painel de inteligência comercial.</p>
                </div>

                <?php if(isset($_GET['error'])): ?>
                    <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-lg flex items-center gap-3 text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        E-mail ou senha incorretos.
                    </div>
                <?php endif; ?>

                <form action="<?= \App\Config\Config::BASE_URL ?>/login" method="POST" @submit="loading = true">
                    
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail Corporativo</label>
                        <div class="relative">
                            <input type="email" 
                                   name="email"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-gmr-navy focus:ring-1 focus:ring-gmr-navy transition-all"
                                   placeholder="seu.nome@email.com" 
                                   required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-medium text-gray-700">Senha</label>
                            <a href="#" class="text-xs text-gmr-navy hover:underline font-semibold">Esqueceu a senha?</a>
                        </div>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" 
                                   name="password"
                                   class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-lg focus:outline-none focus:border-gmr-navy focus:ring-1 focus:ring-gmr-navy transition-all"
                                   placeholder="••••••••" 
                                   required>
                            
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>

                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gmr-navy cursor-pointer">
                                <svg x-show="!showPass" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPass" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.42m3.712-2.228a9.955 9.955 0 013.831-.772c4.478 0 8.268 2.943 9.542 7a10.054 10.054 0 01-2.072 3.65m-2.923 2.923A9.956 9.956 0 0112 19c-1.313 0-2.553-.25-3.687-.704M9 9l6 6m0-6l-6 6" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gmr-navy text-white font-bold py-3 px-4 rounded-lg hover:bg-opacity-90 transition-all transform active:scale-95 flex items-center justify-center gap-2 shadow-lg shadow-gmr-navy/30">
                        <span x-show="!loading">Acessar Sistema</span>
                        <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Autenticando...
                        </span>
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-100 text-center text-sm text-gray-400">
                    &copy; <?= date('Y') ?> Consultor OS. Todos os direitos reservados.
                </div>
            </div>
        </div>
    </div>

</body>
</html>
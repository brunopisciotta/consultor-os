<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultoria Especializada GMR | Alavancagem Patrimonial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gmr: { navy: '#1A2B42', gold: '#D4AF37', gold_light: '#F3E5AB' }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Playfair Display', 'serif'] }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans text-gray-800 antialiased">

    <nav class="w-full bg-gmr-navy border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <div class="flex items-center gap-2">
                    <div class="w-12 h-8 bg-gmr-gold rounded flex items-center justify-center text-gmr-navy font-bold font-serif">GMR</div>
                    <span class="font-serif text-xl text-white tracking-wide">Consultor<span class="text-gmr-gold">OS</span></span>
                </div>

                <div class="flex items-center gap-6">
                
                     <!--
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#inicio" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Início</a>
                        <a href="#como-funciona" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Como Funciona</a>
                    </div>
                    -->
                    <a href="login" 
                    class="bg-gmr-gold text-gmr-navy w-10 h-10 rounded-lg font-bold flex items-center justify-center hover:bg-yellow-500 transition-all shadow-lg shadow-gmr-gold/10" 
                    title="Área do Cliente">
                        <i class="fas fa-lock"></i>
                    </a>

                </div>
            </div>
        </div>
    </nav>

    <?= $content ?? '' ?>

    <footer class="bg-gmr-navy text-white pt-12 pb-8 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm">Especialista em Consórcios e Alavancagem Patrimonial.</p>
            <p class="text-gray-500 text-xs mt-2">&copy; <?= date('Y') ?> Representante Autorizado GMR Consórcios.</p>
        </div>
    </footer>
</body>
</html>
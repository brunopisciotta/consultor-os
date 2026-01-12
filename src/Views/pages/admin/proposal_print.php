<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Proposta Comercial - <?= $lead->name ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600;700&display=swap');
        
        body { font-family: 'Inter', sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .serif { font-family: 'Playfair Display', serif; }
        
        /* Configuração A4 */
        @page { size: A4; margin: 0; }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 0 auto;
            background: white;
            position: relative;
        }
        
        @media print {
            body { background: white; }
            .no-print { display: none !important; }
            .page { box-shadow: none; margin: 0; width: 100%; }
        }
    </style>
</head>
<body class="bg-gray-100 py-10">

    <div class="fixed top-6 right-6 flex gap-4 no-print z-50">
        <button onclick="window.print()" class="bg-gmr-navy text-white px-6 py-3 rounded-full shadow-lg font-bold hover:scale-105 transition flex items-center gap-2">
            <i class="fas fa-print"></i> Salvar PDF / Imprimir
        </button>
        <button onclick="window.close()" class="bg-white text-gray-700 px-6 py-3 rounded-full shadow-lg font-bold hover:bg-gray-50 transition">
            Fechar
        </button>
    </div>

    <div class="page shadow-2xl mx-auto flex flex-col justify-between">
        
        <header class="flex justify-between items-start border-b-2 border-gmr-gold pb-6">
            <div>
                <div class="bg-gmr-navy text-white text-xs font-bold px-3 py-1 inline-block rounded mb-2 uppercase tracking-widest">Estudo de Viabilidade Financeira</div>
                <h1 class="text-4xl serif font-bold text-gmr-navy">Proposta de Crédito</h1>
                <p class="text-gray-500 mt-1">Preparado exclusivamente para <strong class="text-gmr-navy"><?= $lead->name ?></strong></p>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-bold text-gmr-navy tracking-tighter">Consultor<span class="text-gmr-gold">OS</span></h2>
                <p class="text-xs text-gray-400 mt-1"><?= date('d/m/Y') ?></p>
            </div>
        </header>

        <div class="flex-1 py-8 space-y-8">

            <div class="grid grid-cols-2 gap-8">
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <p class="text-xs font-bold text-gray-500 uppercase mb-2">Crédito Desejado</p>
                    <p class="text-3xl font-bold text-gmr-navy">R$ <?= number_format($simulation->credit_value, 2, ',', '.') ?></p>
                    <p class="text-sm text-gray-500 mt-1"><?= $simulation->term_months ?> meses para pagar</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-xl border border-gray-100">
                    <p class="text-xs font-bold text-gray-500 uppercase mb-2">Parcela Mensal (Média)</p>
                    <p class="text-3xl font-bold text-gmr-gold">R$ <?= number_format($simulation->consortium_parcel, 2, ',', '.') ?></p>
                    <?php if($simulation->bid_suggestion > 0): ?>
                        <p class="text-xs text-green-600 font-bold mt-1 bg-green-100 inline-block px-2 py-0.5 rounded">
                            Considerando Lance de R$ <?= number_format($simulation->bid_suggestion, 2, ',', '.') ?>
                        </p>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 mt-1">Sem oferta de lance inicial</p>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <h3 class="serif font-bold text-xl text-gmr-navy mb-6 flex items-center gap-2">
                    <i class="fas fa-chart-pie text-gmr-gold"></i> Por que Consórcio?
                </h3>
                
                <?php 
                    // Cálculos para o gráfico (Regra de 3 para largura das barras)
                    $totalConsorcio = $simulation->consortium_total;
                    $totalFinanciamento = $simulation->financing_total;
                    $max = max($totalConsorcio, $totalFinanciamento);
                    
                    $widthConsorcio = ($totalConsorcio / $max) * 100;
                    $widthFinanciamento = ($totalFinanciamento / $max) * 100;
                    
                    $economia = $totalFinanciamento - $totalConsorcio;
                ?>

                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-bold text-gray-500">Financiamento Bancário (Estimado)</span>
                            <span class="font-bold text-gray-500">R$ <?= number_format($totalFinanciamento, 2, ',', '.') ?></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-8 overflow-hidden relative">
                            <div class="bg-gray-400 h-full flex items-center justify-end px-3 text-white text-xs font-bold" style="width: <?= $widthFinanciamento ?>%">
                                JUROS ABUSIVOS
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-bold text-gmr-navy">Estratégia GMR</span>
                            <span class="font-bold text-gmr-navy">R$ <?= number_format($totalConsorcio, 2, ',', '.') ?></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-8 overflow-hidden shadow-inner">
                            <div class="bg-gmr-navy h-full flex items-center justify-end px-3 text-white text-xs font-bold transition-all" style="width: <?= $widthConsorcio ?>%">
                                ECONOMIA REAL
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-green-50 border border-green-100 p-4 rounded-lg flex items-center gap-4">
                    <div class="bg-green-100 text-green-600 w-12 h-12 rounded-full flex items-center justify-center text-xl">
                        <i class="fas fa-piggy-bank"></i>
                    </div>
                    <div>
                        <p class="text-sm text-green-800">Economia gerada no seu patrimônio:</p>
                        <p class="text-2xl font-bold text-green-700">R$ <?= number_format($economia, 2, ',', '.') ?></p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-8">
                <h3 class="serif font-bold text-xl text-gmr-navy mb-4">Detalhamento da Operação</h3>
                <table class="w-full text-sm text-left">
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-500">Taxa Administrativa Total</td>
                        <td class="py-2 font-bold text-right text-gmr-navy"><?= $simulation->consortium_rate ?>% (todo o período)</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-500">Fundo de Reserva</td>
                        <td class="py-2 font-bold text-right text-gmr-navy">Incluso</td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-500">Seguro de Vida</td>
                        <td class="py-2 font-bold text-right text-gmr-navy">Opcional (Não incluso)</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-gray-500">Reajuste Anual</td>
                        <td class="py-2 font-bold text-right text-gmr-navy">INCC (Imóvel) ou IPCA (Auto)</td>
                    </tr>
                </table>
            </div>

        </div>

        <footer class="bg-gmr-navy text-white p-6 rounded-xl flex items-center gap-6 mt-auto">
            <?php 
                $avatar = $user->avatar ? \App\Config\Config::BASE_URL . '/assets/img/' . $user->avatar : 'https://ui-avatars.com/api/?name='.urlencode($user->name);
            ?>
            <img src="<?= $avatar ?>" class="w-16 h-16 rounded-full border-2 border-gmr-gold object-cover">
            
            <div class="flex-1">
                <p class="text-gmr-gold text-xs font-bold uppercase tracking-widest mb-1">Seu Especialista</p>
                <h3 class="text-xl font-serif font-bold"><?= $user->name ?></h3>
                <div class="flex gap-4 mt-2 text-sm opacity-80">
                    <span><i class="fab fa-whatsapp mr-1"></i> <?= $user->phone ?></span>
                    <span><i class="fas fa-envelope mr-1"></i> <?= $user->email ?></span>
                </div>
            </div>
            
            <div class="text-right opacity-50 text-[10px] max-w-[150px]">
                <p>Valores sujeitos a alteração sem aviso prévio. Simulação não garante contemplação imediata.</p>
            </div>
        </footer>

    </div>

</body>
</html>
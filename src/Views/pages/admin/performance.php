<?php include __DIR__ . '/../../layouts/header.php'; ?>

<style>
    @media print {
        body { background: white; -webkit-print-color-adjust: exact; }
        .no-print { display: none !important; }
        .print-break { page-break-inside: avoid; }
        /* Esconde menu lateral, header e botões de navegação */
        aside, header, .nav-controls, .print-hidden { display: none !important; }
        main { margin: 0; padding: 20px; width: 100%; }
        /* Garante que cores de fundo apareçam */
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>

<div x-data="performance()" class="max-w-7xl mx-auto space-y-8">

    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gmr-navy">Minha Performance</h2>
            <p class="text-gray-500">Gestão de atividades e comissões.</p>
        </div>
        <div class="flex items-center gap-2 bg-white p-2 rounded-lg shadow-sm border border-gray-200 nav-controls">
            <button @click="changeMonth(-1)" class="p-2 hover:bg-gray-100 rounded text-gray-500"><i class="fas fa-chevron-left"></i></button>
            <span class="font-bold text-gmr-navy w-32 text-center" x-text="dateLabel"></span>
            <button @click="changeMonth(1)" class="p-2 hover:bg-gray-100 rounded text-gray-500"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-gmr-navy to-[#2A4B6E] text-white p-6 rounded-xl shadow-lg">
            <p class="text-blue-200 text-xs font-bold uppercase tracking-wider mb-1">Volume Vendido (VGP)</p>
            <h3 class="text-3xl font-bold">R$ <?= number_format($real['sales_volume'], 2, ',', '.') ?></h3>
            <p class="text-xs mt-2 opacity-80"><?= $real['sales_count'] ?> contratos fechados</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Comissão Estimada</p>
            <h3 class="text-3xl font-bold text-green-600">R$ <?= number_format($commission, 2, ',', '.') ?></h3>
            <p class="text-xs mt-2 text-gray-400">Baseado em <?= $user->commission_rate ?>% de comissão</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-center items-center text-center print-hidden">
            <a href="<?= \App\Config\Config::BASE_URL ?>/relatorios/export?m=<?= $month ?>&y=<?= $year ?>" class="w-full bg-green-50 text-green-700 py-3 rounded-lg font-bold hover:bg-green-100 transition flex items-center justify-center gap-2 mb-2">
                <i class="fas fa-file-excel"></i> Baixar Relatório (Excel)
            </a>
            
            <a href="<?= \App\Config\Config::BASE_URL ?>/relatorios/pdf?m=<?= $month ?>&y=<?= $year ?>" target="_blank" class="w-full bg-gmr-navy text-white py-3 rounded-lg font-bold hover:bg-opacity-90 transition flex items-center justify-center gap-2 mt-2">
                <i class="fas fa-file-pdf"></i> Baixar Relatório Gerencial (PDF)
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 print-break">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center relative overflow-hidden">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 absolute top-6 left-6">Progresso da Meta</h3>
            
            <?php 
                $goal = $user->sales_goal ?? 100000; // Valor padrão se não definido
                $current = $real['sales_volume'];
                $percent = $goal > 0 ? min(($current / $goal) * 100, 100) : 0;
                $color = $percent >= 100 ? 'text-green-500' : ($percent >= 50 ? 'text-yellow-500' : 'text-red-500');
            ?>

            <div class="relative w-40 h-40 mt-6">
                <svg class="w-full h-full transform -rotate-90">
                    <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="15" fill="transparent" class="text-gray-100" />
                    <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="15" fill="transparent" 
                            stroke-dasharray="440" 
                            stroke-dashoffset="<?= 440 - (440 * $percent) / 100 ?>" 
                            class="<?= $color ?> transition-all duration-1000 ease-out" />
                </svg>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                    <span class="text-3xl font-bold text-gmr-navy"><?= round($percent) ?>%</span>
                    <p class="text-[10px] text-gray-400">da Meta</p>
                </div>
            </div>
            
            <p class="text-xs text-gray-500 mt-2">
                Faltam <strong class="text-gmr-navy">R$ <?= number_format(max(0, $goal - $current), 2, ',', '.') ?></strong>
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 md:col-span-2">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Evolução de Vendas (6 Meses)</h3>
            
            <div class="h-40 flex items-end justify-between gap-2 px-2 relative">
                <div class="absolute inset-0 border-b border-l border-gray-100 pointer-events-none"></div>
                
                <?php 
                    // Verifica se trendData existe, senão cria array vazio para evitar erro
                    $trendData = $trendData ?? []; 
                    
                    $maxVal = 0;
                    foreach($trendData as $d) if($d['value'] > $maxVal) $maxVal = $d['value'];
                    $maxVal = $maxVal > 0 ? $maxVal : 1;
                ?>

                <?php if(empty($trendData)): ?>
                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-sm">
                        Sem dados históricos ainda.
                    </div>
                <?php else: ?>
                    <?php foreach($trendData as $data): ?>
                        <div class="flex flex-col items-center gap-2 group w-full">
                            <div class="w-full bg-blue-50 hover:bg-blue-100 rounded-t-lg transition-all relative group-hover:scale-y-105 origin-bottom duration-500" 
                                style="height: <?= ($data['value'] / $maxVal) * 100 ?>%">
                                
                                <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-gmr-navy text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10 shadow-lg">
                                    R$ <?= number_format($data['value'], 0, ',', '.') ?>
                                </div>
                            </div>
                            <span class="text-[10px] text-gray-400 font-bold"><?= $data['label'] ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 print-break">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                <h3 class="font-bold text-gmr-navy"><i class="fas fa-edit mr-2"></i>Registo de Atividades</h3>
                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Preenchimento Manual</span>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">📞 Ligações Feitas</label>
                    <input type="number" x-model="metrics.calls" @change="save()" class="w-full p-3 border rounded-lg text-lg font-bold text-gmr-navy outline-none focus:border-gmr-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">💬 WhatsApps Enviados</label>
                    <input type="number" x-model="metrics.whats" @change="save()" class="w-full p-3 border rounded-lg text-lg font-bold text-gmr-navy outline-none focus:border-gmr-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">📹 Vídeo Chamadas</label>
                    <input type="number" x-model="metrics.video" @change="save()" class="w-full p-3 border rounded-lg text-lg font-bold text-gmr-navy outline-none focus:border-gmr-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">🤝 Visitas Presenciais</label>
                    <input type="number" x-model="metrics.visits" @change="save()" class="w-full p-3 border rounded-lg text-lg font-bold text-gmr-navy outline-none focus:border-gmr-gold">
                </div>
            </div>
            
            <div class="mt-6 bg-gray-50 p-4 rounded-lg print-hidden">
                <p class="text-xs text-gray-500 text-center">
                    <i class="fas fa-info-circle"></i> O sistema salva automaticamente ao alterar os valores.
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gmr-navy mb-6">Funil de Vendas do Mês</h3>
            
            <div class="flex flex-col items-center space-y-1">
                
                <?php 
                    // Mapeamento dos dados reais para o visual do funil
                    $funnelData = [
                        'new' => [
                            'label' => 'Novos Leads', 
                            'count' => $real['status_breakdown']['new'] ?? 0,
                            'color' => 'bg-red-500', 
                            'width' => 'w-full'
                        ],
                        'analysis' => [ 
                            'label' => 'Em Análise', 
                            'count' => $real['status_breakdown']['analysis'] ?? 0,
                            'color' => 'bg-orange-400', 
                            'width' => 'w-11/12'
                        ],
                        'proposal' => [ 
                            'label' => 'Proposta', 
                            'count' => $real['status_breakdown']['proposal'] ?? 0,
                            'color' => 'bg-yellow-400', 
                            'width' => 'w-10/12'
                        ],
                        'negotiation' => [ 
                            'label' => 'Em Negociação', 
                            'count' => $real['status_breakdown']['negotiation'] ?? 0,
                            'color' => 'bg-green-500', 
                            'width' => 'w-9/12'
                        ],
                        'closed' => [ 
                            'label' => 'Venda Realizada', 
                            'count' => $real['status_breakdown']['closed'] ?? 0,
                            'color' => 'bg-gmr-navy', 
                            'width' => 'w-8/12' 
                        ]
                    ];
                ?>

                <?php foreach($funnelData as $stage): ?>
                    <div class="<?= $stage['width'] ?> relative group transition-all hover:scale-[1.02] cursor-default">
                        <div class="<?= $stage['color'] ?> text-white p-3 rounded-lg shadow-sm flex justify-between items-center relative z-10">
                            <span class="font-bold text-xs uppercase tracking-wide opacity-95 text-shadow-sm">
                                <?= $stage['label'] ?>
                            </span>
                            <span class="font-bold text-lg bg-white/20 px-2 py-0.5 rounded shadow-inner">
                                <?= $stage['count'] ?>
                            </span>
                        </div>
                        
                        <div class="absolute inset-x-4 -bottom-1 h-2 bg-black/5 rounded-b-lg mx-2 z-0"></div>
                    </div>
                <?php endforeach; ?>

                <div class="mt-8 w-full border-t border-dashed border-gray-300 pt-4 flex justify-between text-gray-500 text-xs">
                    <span class="text-red-400"><i class="fas fa-trash mr-1"></i> Leads Perdidos: <strong><?= $real['status_breakdown']['lost'] ?? 0 ?></strong></span>
                    <span class="text-gmr-navy">Taxa de Conversão: <strong>
                        <?php 
                            $total = array_sum($real['status_breakdown']);
                            // Evita divisão por zero
                            echo $total > 0 ? number_format((($real['status_breakdown']['closed']??0)/$total)*100, 1) : 0; 
                        ?>%
                    </strong></span>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function performance() {
    return {
        metrics: {
            calls: <?= $manual->calls_made ?>,
            whats: <?= $manual->whatsapp_sent ?>,
            video: <?= $manual->video_calls ?>,
            visits: <?= $manual->visits_made ?>
        },
        currentMonth: <?= $month ?>,
        currentYear: <?= $year ?>,
        dateLabel: '<?= date('F Y', mktime(0, 0, 0, $month, 10, $year)) ?>', 

        changeMonth(step) {
            let newMonth = this.currentMonth + step;
            let newYear = this.currentYear;
            
            if (newMonth > 12) { newMonth = 1; newYear++; }
            if (newMonth < 1) { newMonth = 12; newYear--; }
            
            // Recarrega a página com novos parametros
            window.location.href = `?m=${newMonth}&y=${newYear}`;
        },

        save() {
            fetch('<?= \App\Config\Config::BASE_URL ?>/relatorios/save', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    month_year: `${this.currentYear}-${String(this.currentMonth).padStart(2, '0')}`,
                    ...this.metrics
                })
            })
            .then(r => r.json())
            .then(data => {
                if(data.status !== 'success') {
                    console.error('Erro ao salvar métricas');
                }
            });
        }
    }
}
</script>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div x-data="{ quickModal: false, quickValue: 100000, quickTerm: 200 }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h3 class="text-2xl font-serif text-gmr-navy font-bold">Olá, Consultor</h3>
            <p class="text-gray-500 mt-1">Aqui está o resumo da sua operação hoje.</p>
        </div>
        <a href="<?= \App\Config\Config::BASE_URL ?>/simulador" class="hidden md:flex items-center gap-2 bg-gmr-navy text-white px-5 py-2.5 rounded-lg hover:bg-opacity-90 transition shadow-lg shadow-gmr-navy/20">
            <i class="fas fa-plus"></i> Nova Simulação
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 text-gmr-navy rounded-lg">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <h4 class="text-3xl font-bold text-gmr-navy"><?= $stats['total_leads'] ?? 0 ?></h4>
            <p class="text-sm text-gray-500">Leads Ativos</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
            </div>
            <h4 class="text-3xl font-bold text-gmr-navy"><?= $stats['simulations_today'] ?? 0 ?></h4>
            <p class="text-sm text-gray-500">Simulações Hoje</p>
        </div>

       <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg">
                    <i class="fas fa-coins text-xl"></i>
                </div>
            </div>
            <h4 class="text-2xl font-bold text-gmr-navy">
                R$ <?= number_format(($stats['total_volume'] ?? 0) / 1000000, 1, ',', '.') ?>M
            </h4>
            <p class="text-sm text-gray-500">Em Negociação (Pipeline)</p>
        </div>

        <div @click="quickModal = true" class="bg-gradient-to-br from-gmr-navy to-[#2A4B6E] rounded-xl p-6 shadow-lg text-white relative overflow-hidden group cursor-pointer">
            <div class="absolute right-0 top-0 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-calculator text-9xl"></i>
            </div>
            <h4 class="text-lg font-serif font-bold mb-2">Simulador Rápido</h4>
            <p class="text-blue-100 text-sm mb-4">Cálculo de padaria instantâneo.</p>
            <button class="text-xs font-bold bg-gmr-gold text-gmr-navy px-3 py-2 rounded shadow hover:bg-white transition-colors">
                CALCULAR AGORA
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="p-4 border-b border-gray-50">
                    <h4 class="font-serif font-bold text-gmr-navy">Leads Recentes</h4>
                </div>
                <div class="divide-y divide-gray-50">
                    <?php if(empty($recent_leads)): ?>
                        <div class="p-6 text-center text-gray-400 text-sm">Nenhum lead novo.</div>
                    <?php else: ?>
                        <?php foreach($recent_leads as $lead): ?>
                            <div class="p-4 flex items-center justify-between hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gmr-navy font-bold text-xs">
                                        <?= substr($lead->name, 0, 2) ?>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gmr-navy"><?= $lead->name ?></p>
                                        <p class="text-[10px] text-gray-400"><?= date('d/m H:i', strtotime($lead->created_at)) ?></p>
                                    </div>
                                </div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 font-bold uppercase">
                                    <?= $lead->status ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                    <h4 class="font-serif font-bold text-gmr-navy">Últimas Simulações</h4>
                    <a href="<?= \App\Config\Config::BASE_URL ?>/leads" class="text-xs text-blue-600 hover:underline">Ver todas</a>
                </div>
                
                <div class="divide-y divide-gray-100">
                    <?php if(empty($recentSimulations)): ?>
                        <div class="p-8 text-center text-gray-400">
                            <p>Nenhuma simulação recente.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($recentSimulations as $sim): ?>
                            <div class="p-4 hover:bg-gray-50 transition flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-gmr-navy text-sm">
                                        <?php if($sim->type == 'auto'): ?>
                                            <i class="fas fa-car"></i>
                                        <?php elseif($sim->type == 'servico'): ?>
                                            <i class="fas fa-tools"></i>
                                        <?php else: ?>
                                            <i class="fas fa-home"></i>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div>
                                        <p class="font-bold text-gmr-navy text-sm">
                                            R$ <?= number_format($sim->credit_value, 2, ',', '.') ?>
                                        </p>
                                        <div class="flex items-center gap-2 text-xs text-gray-400">
                                            <span><?= $sim->term_months ?>x de R$ <?= number_format($sim->consortium_parcel, 2, ',', '.') ?></span>
                                            
                                            <?php if(isset($sim->has_insurance) && $sim->has_insurance == 1): ?>
                                                <span class="text-green-600" title="Com Seguro">
                                                    <i class="fas fa-shield-alt text-[10px]"></i>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <span class="text-[10px] text-gray-400 block mb-1">
                                        <?= date('d/m H:i', strtotime($sim->created_at)) ?>
                                    </span>
                                    
                                    <?php if($sim->lead_id): ?>
                                        <a href="<?= \App\Config\Config::BASE_URL ?>/leads/details?id=<?= $sim->lead_id ?>" class="text-[10px] font-bold text-blue-600 hover:underline flex items-center justify-end gap-1">
                                            Ver Lead <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-[10px] text-red-300 italic">Lead Removido</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div x-show="quickModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-60" @click="quickModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden">
                <div class="bg-gmr-navy p-4 flex justify-between items-center text-white">
                    <h3 class="font-serif font-bold"><i class="fas fa-bolt text-gmr-gold mr-2"></i>Cálculo Rápido</h3>
                    <button @click="quickModal = false"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Crédito</label>
                        <input type="number" x-model="quickValue" class="w-full p-2 border border-gray-200 rounded-lg outline-none focus:border-gmr-gold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Meses</label>
                        <input type="number" x-model="quickTerm" class="w-full p-2 border border-gray-200 rounded-lg outline-none focus:border-gmr-gold">
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <p class="text-xs text-blue-600 mb-1">Parcela Estimada</p>
                        <p class="text-2xl font-bold text-gmr-navy">
                            R$ <span x-text="new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2}).format((quickValue * 1.22) / (quickTerm || 1))"></span>
                        </p>
                    </div>
                    <a :href="'<?= \App\Config\Config::BASE_URL ?>/simulador?credit=' + quickValue + '&term=' + quickTerm" class="block w-full bg-gmr-gold text-gmr-navy text-center font-bold py-3 rounded-lg hover:bg-opacity-90">
                        IR PARA SIMULADOR COMPLETO
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
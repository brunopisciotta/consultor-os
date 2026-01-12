<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div x-data="leadProfile(<?= htmlspecialchars(json_encode($lead)) ?>)" class="max-w-7xl mx-auto">

    <a href="../leads" class="inline-flex items-center text-gray-500 hover:text-gmr-navy mb-6 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Voltar para Lista
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <aside class="lg:col-span-1 lg:sticky lg:top-6 h-fit space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="h-24 bg-gmr-navy relative">
                    <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2">
                        <div class="w-20 h-20 rounded-full bg-white p-1 shadow-lg">
                            <div class="w-full h-full rounded-full bg-gmr-gold flex items-center justify-center text-gmr-navy text-2xl font-serif font-bold">
                                <?= strtoupper(substr($lead->name, 0, 2)) ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="pt-12 pb-6 px-6 text-center">
                    <h2 class="text-xl font-bold text-gmr-navy"><?= $lead->name ?></h2>
                    <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-medium">
                        <?= ucfirst($lead->objective) ?>
                    </span>

                    <div class="mt-2">
                        <?php
                            $statusMap = [
                                'new' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'label' => 'Novo Lead'],
                                'analysis' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'label' => 'Em Análise'],
                                'proposal' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'label' => 'Proposta'],
                                'negotiation' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'label' => 'Negociação'],
                                'closed' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'label' => 'Venda Feita'],
                                'lost' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'label' => 'Perdido']
                            ];
                            $s = $statusMap[$lead->status] ?? $statusMap['new'];
                        ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full border <?= $s['bg'] ?> <?= $s['text'] ?>">
                            <?= $s['label'] ?>
                        </span>
                    </div>

                    <div class="mt-6 text-left space-y-4 border-t border-gray-100 pt-6">
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-phone"></i></div>
                            <span class="text-gray-600"><?= $lead->phone ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-envelope"></i></div>
                            <span class="text-gray-600 truncate"><?= $lead->email ?></span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-8 h-8 rounded bg-blue-50 text-blue-600 flex items-center justify-center"><i class="fas fa-calendar"></i></div>
                            <span class="text-gray-600">Desde <?= date('d/m/Y', strtotime($lead->created_at)) ?></span>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <a href="https://wa.me/55<?= preg_replace('/\D/', '', $lead->phone) ?>" target="_blank" class="flex-1 bg-green-500 text-white py-2 rounded-lg text-sm font-bold hover:bg-green-600 transition flex items-center justify-center gap-2">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                        <button @click="editModal = true" class="flex-1 border border-gray-300 text-gray-600 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition">
                            Editar
                        </button>
                    </div>
                </div>
            </div>

            <?php if(!empty($lead->message)): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-yellow-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-quote-left"></i> Objetivo do Cliente
                    </h3>
                    <p class="text-sm text-yellow-900 italic leading-relaxed">
                        "<?= nl2br(htmlspecialchars($lead->message)) ?>"
                    </p>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="whatsappScripts()">
                <h3 class="font-bold text-gmr-navy mb-4 flex items-center gap-2">
                    <i class="fab fa-whatsapp text-green-500"></i> Scripts Rápidos
                </h3>
                
                <div class="space-y-2">
                    <button @click="send('ola')" class="w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-green-50 hover:text-green-700 transition text-sm flex justify-between items-center group">
                        <span>👋 Boas Vindas</span>
                        <i class="fas fa-paper-plane opacity-0 group-hover:opacity-100"></i>
                    </button>

                    <button @click="send('simulacao')" class="w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-green-50 hover:text-green-700 transition text-sm flex justify-between items-center group">
                        <span>📊 Simulação Pronta</span>
                        <i class="fas fa-paper-plane opacity-0 group-hover:opacity-100"></i>
                    </button>

                    <button @click="send('followup')" class="w-full text-left px-4 py-3 rounded-lg bg-gray-50 hover:bg-green-50 hover:text-green-700 transition text-sm flex justify-between items-center group">
                        <span>🤔 Cobrar Retorno</span>
                        <i class="fas fa-paper-plane opacity-0 group-hover:opacity-100"></i>
                    </button>
                </div>
            </div>
        </aside>

        <div class="lg:col-span-2 space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-gmr-navy">Simulações Salvas</h3>
                <a href="../simulador?lead_id=<?= $lead->id ?>" class="text-sm text-gmr-gold hover:underline font-medium">+ Nova Simulação</a>
            </div>

            <?php if(empty($simulations)): ?>
                <div class="bg-white p-8 rounded-xl border border-gray-100 text-center">
                    <p class="text-gray-400">Nenhuma simulação registrada para este cliente.</p>
                </div>
            <?php else: ?>
                <div class="grid gap-4">
                    <?php foreach($simulations as $sim): ?>
                        <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="bg-gmr-navy text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                                        <?= strtoupper($sim->type) ?>
                                    </span>
                                    <span class="text-xs text-gray-400 ml-2">
                                        <?= date('d/m/Y H:i', strtotime($sim->created_at)) ?>
                                    </span>
                                </div>
                                
                                <?php if($sim->bid_suggestion > 0): ?>
                                    <div class="text-right">
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">Sugestão de Lance</p>
                                        <p class="text-green-600 font-bold">R$ <?= number_format($sim->bid_suggestion, 2, ',', '.') ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                    
                            <div class="mb-4">
                                <p class="text-3xl font-bold text-gmr-navy">
                                    R$ <?= number_format($sim->credit_value, 2, ',', '.') ?>
                                </p>
                                <p class="text-gray-500 text-sm mt-1">
                                    <?= $sim->term_months ?>x de 
                                    <strong class="text-gmr-navy">R$ <?= number_format($sim->consortium_parcel, 2, ',', '.') ?></strong>
                                </p>
                                
                                <?php if(isset($sim->has_insurance) && $sim->has_insurance == 1): ?>
                                    <p class="text-[10px] text-green-600 mt-1 flex items-center gap-1">
                                        <i class="fas fa-shield-alt"></i> Seguro Incluso
                                    </p>
                                <?php endif; ?>
                            </div>
                    
                            <div class="flex gap-4 border-t border-gray-100 pt-4 text-sm font-medium text-gray-500">
                                
                                <a href="<?= \App\Config\Config::BASE_URL ?>/simulador?lead_id=<?= $lead->id ?>&credit=<?= $sim->credit_value ?>&term=<?= $sim->term_months ?>&bid=<?= $sim->bid_suggestion ?>" 
                                   class="flex items-center gap-1 hover:text-gmr-navy transition">
                                    <i class="fas fa-edit"></i> Recalcular
                                </a>
                    
                                <a href="<?= \App\Config\Config::BASE_URL ?>/proposal/pdf?sim_id=<?= $sim->id ?>" 
                                   target="_blank" 
                                   class="flex items-center gap-1 hover:text-gmr-gold transition text-gmr-gold">
                                    <i class="fas fa-file-pdf"></i> Gerar Proposta
                                </a>
                    
                                <button @click="deleteSimulation(<?= $sim->id ?>)" class="flex items-center gap-1 hover:text-red-500 transition text-red-300 ml-auto">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div x-show="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="editModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                <h3 class="text-lg font-bold text-gmr-navy mb-4">Editar Dados do Cliente</h3>
                
                <form action="../leads/update" method="POST">
                    <input type="hidden" name="id" x-model="form.id">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nome</label>
                            <input type="text" name="name" x-model="form.name" class="w-full border rounded-lg p-2.5 focus:border-gmr-navy outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Telefone</label>
                                <input type="text" name="phone" x-model="form.phone" class="w-full border rounded-lg p-2.5 focus:border-gmr-navy outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">E-mail</label>
                                <input type="email" name="email" x-model="form.email" class="w-full border rounded-lg p-2.5 focus:border-gmr-navy outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Interesse Principal</label>
                                <select name="objective" x-model="form.objective" class="w-full border rounded-lg p-2.5 focus:border-gmr-navy outline-none bg-white">
                                    <option value="imovel">Imóvel</option>
                                    <option value="auto">Veículo</option>
                                    <option value="investimento">Investimento</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status do Funil</label>
                                <select name="status" x-model="form.status" class="w-full border rounded-lg p-2.5 focus:border-gmr-navy outline-none bg-white font-bold" 
                                        :class="{
                                            'text-green-600': form.status === 'closed',
                                            'text-red-500': form.status === 'lost',
                                            'text-blue-600': form.status === 'new'
                                        }">
                                    <option value="new">Novo Lead</option>
                                    <option value="analysis">Em Análise (Simulação)</option>
                                    <option value="proposal">Proposta Enviada</option>
                                    <option value="negotiation">Em Negociação</option>
                                    <option value="closed">✅ Venda Realizada</option>
                                    <option value="lost">❌ Perdido</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">História / Objetivo</label>
                            <textarea name="message" x-model="form.message" rows="3" class="w-full border rounded-lg p-2.5 focus:border-gmr-navy outline-none text-sm"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <button type="button" @click="editModal = false" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-lg">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-gmr-navy text-white rounded-lg hover:bg-opacity-90">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function leadProfile(leadData) {
        return {
            editModal: false,
            form: { 
                id: leadData.id, 
                name: leadData.name, 
                phone: leadData.phone, 
                email: leadData.email, 
                objective: leadData.objective,
                status: leadData.status, // Agora puxa o status corretamente
                message: leadData.message // Agora puxa a mensagem
            },
            deleteSimulation(simId) {
                if(!confirm('Deseja realmente apagar esta simulação?')) return;
                fetch('../simulador/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: simId })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') window.location.reload();
                    else alert('Erro ao excluir a simulação.');
                });
            }
        }
    }

    function whatsappScripts() {
        return {
            leadName: '<?= addslashes($lead->name) ?>',
            leadPhone: '55<?= preg_replace('/\D/', '', $lead->phone) ?>',
            
            send(type) {
                let msg = '';
                const firstName = this.leadName.split(' ')[0];

                if(type === 'ola') {
                    msg = `Olá ${firstName}, tudo bem? Aqui é o Lucas da GMR. Recebi sua solicitação de análise sobre consórcio. Qual o melhor horário para falarmos rapidinho?`;
                } else if (type === 'simulacao') {
                    msg = `Fala ${firstName}! Já montei o estudo de viabilidade para seu objetivo. Ficou excelente! Posso te mandar o PDF por aqui?`;
                } else if (type === 'followup') {
                    msg = `Oi ${firstName}, conseguiu dar uma olhada na proposta? Apareceu uma oportunidade no grupo que lembrei de você.`;
                }

                const url = `https://wa.me/${this.leadPhone}?text=${encodeURIComponent(msg)}`;
                window.open(url, '_blank');
            }
        }
    }
</script>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
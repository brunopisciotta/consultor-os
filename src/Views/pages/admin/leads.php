<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="max-w-7xl mx-auto" x-data="{ 
    openModal: false, 
    editModal: false, 
    currentLead: {
        id: '', name: '', phone: '', email: '', objective: 'imovel', status: 'new', message: ''
    },
    deleteLead(id) {
        if(confirm('Tem certeza que deseja excluir este cliente?')) {
            window.location.href = `leads/delete?id=${id}`;
        }
    }
}">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gmr-navy">Carteira de Clientes</h2>
            <p class="text-sm text-gray-500">Gerencie seus contatos e oportunidades.</p>
        </div>
        <button @click="openModal = true" class="bg-gmr-navy text-white px-5 py-2.5 rounded-lg hover:bg-opacity-90 transition shadow-lg flex items-center gap-2">
            <i class="fas fa-user-plus"></i> Novo Cliente
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <?php if(empty($leads)): ?>
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Nenhum cliente ainda</h3>
                <p class="text-gray-500 mb-6">Comece adicionando seu primeiro contato para simular.</p>
                <button @click="openModal = true" class="text-gmr-navy font-bold hover:underline">Cadastrar agora</button>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="p-4 font-semibold">Cliente</th>
                            <th class="p-4 font-semibold">Objetivo</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold">Contato</th>
                            <th class="p-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($leads as $lead): ?>
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gmr-navy text-gmr-gold flex items-center justify-center font-bold text-sm">
                                        <?= substr($lead->name, 0, 2) ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gmr-navy text-sm"><?= $lead->name ?></p>
                                        <p class="text-xs text-gray-400">Cadastrado em <?= date('d/m', strtotime($lead->created_at)) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <?php 
                                    $icons = ['imovel' => 'fa-home', 'auto' => 'fa-car', 'investimento' => 'fa-chart-line', 'outro' => 'fa-tag'];
                                    $labels = ['imovel' => 'Imóvel', 'auto' => 'Veículo', 'investimento' => 'Investimento', 'outro' => 'Outro'];
                                ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                    <i class="fas <?= $icons[$lead->objective] ?? 'fa-tag' ?>"></i>
                                    <?= $labels[$lead->objective] ?? 'Geral' ?>
                                </span>
                            </td>
                            
                            <td class="p-4">
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
                                <span class="px-2.5 py-1 text-[10px] uppercase font-bold rounded-full <?= $s['bg'] ?> <?= $s['text'] ?>">
                                    <?= $s['label'] ?>
                                </span>
                            </td>

                            <td class="p-4 text-sm text-gray-500">
                                <div class="flex flex-col gap-1">
                                    <span class="flex items-center gap-2"><i class="fab fa-whatsapp text-green-500"></i> <?= $lead->phone ?></span>
                                    <span class="text-xs"><?= $lead->email ?></span>
                                </div>
                            </td>
                            <td class="p-4 text-right">
                                <a href="leads/details?id=<?= $lead->id ?>" class="text-gray-400 hover:text-gmr-navy p-2 transition-colors inline-block" title="Ver Perfil">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <button 
                                    @click="editModal = true; currentLead = { 
                                        id: '<?= $lead->id ?>', 
                                        name: '<?= addslashes($lead->name) ?>', 
                                        phone: '<?= $lead->phone ?>', 
                                        email: '<?= $lead->email ?>', 
                                        objective: '<?= $lead->objective ?>', 
                                        status: '<?= $lead->status ?>',
                                        message: `<?= addslashes(str_replace(array("\r", "\n"), ' ', $lead->message ?? '')) ?>`
                                    }" 
                                    class="text-gray-400 hover:text-blue-600 p-2 transition-colors" 
                                    title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button 
                                    @click="deleteLead(<?= $lead->id ?>)"
                                    class="text-gray-400 hover:text-red-600 p-2 transition-colors" 
                                    title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="openModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg">
                <form action="leads" method="POST">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="text-xl font-bold text-gmr-navy mb-4">Novo Cliente</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                                <input type="text" name="name" required class="w-full rounded-lg border-gray-300 border p-2 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                                    <input type="text" name="phone" placeholder="(00) 00000-0000" class="w-full rounded-lg border-gray-300 border p-2 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                                    <input type="email" name="email" class="w-full rounded-lg border-gray-300 border p-2 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Interesse Principal</label>
                                <select name="objective" class="w-full rounded-lg border-gray-300 border p-2 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                                    <option value="imovel">Imóvel (Compra/Construção)</option>
                                    <option value="auto">Automóvel</option>
                                    <option value="investimento">Investimento / Alavancagem</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">História / Objetivo Detalhado</label>
                                <textarea name="message" rows="3" class="w-full p-2.5 border border-gray-300 rounded-lg focus:border-gmr-navy outline-none text-sm" placeholder="Cole aqui o relato do cliente ou o sonho dele..."></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-gmr-navy px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 sm:ml-3 sm:w-auto">Salvar Cliente</button>
                        <button type="button" @click="openModal = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="editModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition x-cloak>
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="editModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg">
                <form action="leads/update" method="POST">
                    <input type="hidden" name="id" :value="currentLead.id">
                    
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="text-xl font-bold text-gmr-navy mb-4">Editar Cliente</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                                <input type="text" name="name" x-model="currentLead.name" required class="w-full rounded-lg border-gray-300 border p-2 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                                    <input type="text" name="phone" x-model="currentLead.phone" class="w-full rounded-lg border-gray-300 border p-2 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                                    <input type="email" name="email" x-model="currentLead.email" class="w-full rounded-lg border-gray-300 border p-2 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Interesse</label>
                                    <select name="objective" x-model="currentLead.objective" class="w-full rounded-lg border-gray-300 border p-2 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                                        <option value="imovel">Imóvel</option>
                                        <option value="auto">Automóvel</option>
                                        <option value="investimento">Investimento</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status do Funil</label>
                                    <select name="status" x-model="currentLead.status" class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:border-gmr-navy outline-none bg-gray-50 font-bold"
                                            :class="{'text-green-600': currentLead.status === 'closed', 'text-red-600': currentLead.status === 'lost'}">
                                        <option value="new">Novo Lead</option>
                                        <option value="analysis">Em Análise</option>
                                        <option value="proposal">Proposta Enviada</option>
                                        <option value="negotiation">Em Negociação</option>
                                        <option value="closed">✅ Venda Realizada</option>
                                        <option value="lost">❌ Perdido</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">História / Objetivo</label>
                                <textarea name="message" x-model="currentLead.message" rows="3" class="w-full border rounded-lg p-2.5 focus:border-gmr-navy outline-none text-sm"></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">Atualizar Dados</button>
                        <button type="button" @click="editModal = false" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
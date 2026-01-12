<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="max-w-4xl mx-auto">
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gmr-navy">Configurações</h2>
            <p class="text-gray-500">Gerencie seus dados e parâmetros do sistema.</p>
        </div>
        
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2">
                <i class="fas fa-check-circle"></i> Dados atualizados!
            </div>
        <?php endif; ?>
    </div>

    <form action="configuracoes/update" method="POST" enctype="multipart/form-data" class="grid md:grid-cols-3 gap-8">
        
        <?php 
            // Preparação da variável de avatar para o Alpine.js
            $avatar = $user->avatar ? \App\Config\Config::BASE_URL . '/assets/img/' . $user->avatar : 'https://ui-avatars.com/api/?name='.urlencode($user->name);
        ?>

        <div class="md:col-span-1" x-data="{ 
            photoPreview: '<?= $avatar ?>', 
            triggerUpload() { document.getElementById('avatarInput').click(); },
            updatePreview(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => { this.photoPreview = e.target.result; };
                    reader.readAsDataURL(file);
                }
            }
        }">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">

                <div class="relative inline-block mb-4 group cursor-pointer" @click="triggerUpload()">
                    <img :src="photoPreview" class="w-32 h-32 rounded-full border-4 border-gmr-gold object-cover mx-auto transition-opacity hover:opacity-80">

                    <div class="absolute inset-0 bg-black bg-opacity-40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <i class="fas fa-camera text-white text-2xl"></i>
                    </div>
                </div>

                <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*" @change="updatePreview($event)">

                <h3 class="font-bold text-gmr-navy"><?= $user->name ?></h3>
                <p class="text-xs text-gray-400 uppercase tracking-wide">Consultor Elite</p>
            </div>
            
            <div class="mt-6 bg-blue-50 p-4 rounded-xl border border-blue-100">
                <h4 class="text-sm font-bold text-blue-800 mb-2"><i class="fas fa-info-circle"></i> Dica</h4>
                <p class="text-xs text-blue-600 leading-relaxed">
                    Esses dados (Nome e Telefone) são usados automaticamente no rodapé das propostas em PDF geradas pelo sistema.
                </p>
            </div>
        </div>

        <div class="md:col-span-2 space-y-6">
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gmr-navy mb-4 border-b pb-2">Meus Dados</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nome Completo</label>
                        <input type="text" name="name" value="<?= $user->name ?>" class="w-full p-2.5 border rounded-lg focus:border-gmr-navy outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">E-mail</label>
                        <input type="email" name="email" value="<?= $user->email ?>" class="w-full p-2.5 border rounded-lg focus:border-gmr-navy outline-none bg-gray-50" readonly title="Fale com o admin para alterar">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">WhatsApp Profissional</label>
                        <input type="text" name="phone" value="<?= $user->phone ?>" class="w-full p-2.5 border rounded-lg focus:border-gmr-navy outline-none">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gmr-navy mb-4 border-b pb-2 flex items-center justify-between">
                    <span>Parâmetros Globais</span>
                    <span class="text-[10px] bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Padrões do Simulador</span>
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gmr-navy uppercase mb-1">Taxa Adm. Padrão</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="adm_rate" value="<?= $user->default_consortium_rate ?? 22 ?>" class="w-full p-2.5 border rounded-lg focus:border-gmr-navy outline-none font-bold text-gmr-navy">
                            <span class="absolute right-4 top-2.5 text-gray-400 font-bold">%</span>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Soma de toda a taxa do período.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Taxa Mercado (Financ.)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="fin_rate" value="<?= $user->default_financing_rate ?>" class="w-full p-2.5 border rounded-lg focus:border-gmr-navy outline-none font-bold text-gmr-navy">
                            <span class="absolute right-4 top-2.5 text-gray-400 font-bold">% a.a</span>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Para comparação com bancos.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-green-600 uppercase mb-1">Minha Comissão</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="comm_rate" value="<?= $user->commission_rate ?? 1.00 ?>" class="w-full p-2.5 border border-green-200 rounded-lg focus:border-green-500 outline-none font-bold text-green-600 bg-green-50">
                            <span class="absolute right-4 top-2.5 text-green-400 font-bold">%</span>
                        </div>
                        <p class="text-[10px] text-green-600 mt-1">Usado no cálculo de performance.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gmr-gold uppercase mb-1">Meta de Vendas Mensal</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gmr-gold font-bold">R$</span>
                            <input type="number" step="1000" name="sales_goal" value="<?= $user->sales_goal ?? 100000 ?>" class="w-full pl-10 p-2.5 border border-yellow-200 rounded-lg focus:border-gmr-gold outline-none font-bold text-gmr-navy">
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Define o alvo do gráfico de progresso.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-gmr-navy text-white px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 shadow-lg shadow-gmr-navy/20 transition-transform hover:-translate-y-1 flex items-center gap-2">
                    <i class="fas fa-save"></i> Salvar Alterações
                </button>
            </div>

        </div>
    </form>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
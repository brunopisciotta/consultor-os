<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="max-w-5xl mx-auto pb-12">
    
    <div class="text-center mb-12">
        <h2 class="text-3xl font-serif font-bold text-gmr-navy">Manual do <span class="text-gmr-gold">ConsultorOS</span></h2>
        <p class="text-gray-500 mt-2">Central de conhecimento e estratégias de venda.</p>
    </div>

    <div class="space-y-12">

        <section class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gmr-navy text-white p-6 flex justify-between items-center">
                <h3 class="text-xl font-bold flex items-center gap-2">
                    <i class="fas fa-calculator text-gmr-gold"></i> Entendendo a Matemática GMR
                </h3>
                <span class="text-xs bg-white/10 px-3 py-1 rounded text-gmr-gold uppercase font-bold">Transparência Total</span>
            </div>
            
            <div class="p-8">
                <p class="text-gray-600 mb-6">
                    O sistema utiliza o cálculo de <strong>Custo Efetivo Total Simples</strong>. Diferente da Tabela Price (bancos) que cobra juros sobre juros, nós trabalhamos com taxa fixa sobre o crédito. Veja o racional lógico para explicar ao cliente:
                </p>

                <div class="grid md:grid-cols-2 gap-8 items-start">
                    
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <h4 class="font-bold text-gmr-navy mb-4 border-b pb-2">1. Como chegamos na Parcela?</h4>
                        <ul class="space-y-4 text-sm text-gray-600">
                            <li class="flex gap-3">
                                <span class="font-bold text-gmr-navy">Passo A:</span>
                                <div>
                                    Pegamos o Crédito e aplicamos a Taxa Adm. Total.<br>
                                    <span class="font-mono text-xs bg-gray-200 px-1 rounded">Ex: 200k + 22% = 244k (Custo Total)</span>
                                </div>
                            </li>
                            <li class="flex gap-3">
                                <span class="font-bold text-gmr-navy">Passo B:</span>
                                <div>
                                    Dividimos o Custo Total pelo Prazo em meses.<br>
                                    <span class="font-mono text-xs bg-gray-200 px-1 rounded">Ex: 244.000 / 200 = R$ 1.220,00</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                        <h4 class="font-bold text-blue-900 mb-4 border-b border-blue-200 pb-2">2. E quando tem Lance?</h4>
                        <p class="text-sm text-blue-800 mb-3">
                            O Lance funciona como um <strong>amortizador poderoso</strong>. Ele não abate do crédito, ele abate do <strong>Saldo Devedor Total</strong>.
                        </p>
                        <ul class="space-y-4 text-sm text-blue-800">
                            <li class="flex gap-3">
                                <span class="font-bold">A Lógica:</span>
                                <div>
                                    Subtraímos o lance do Custo Total e recalculamos a divisão pelo mesmo prazo.
                                </div>
                            </li>
                            <li class="bg-white p-3 rounded border border-blue-100 shadow-sm">
                                <span class="font-bold block text-xs uppercase text-gray-400 mb-1">Exemplo Matemático</span>
                                <span class="font-mono text-blue-600 font-bold block">244.000 (Saldo) - 50.000 (Lance) = 194.000</span>
                                <span class="font-mono text-gray-500 text-xs block mt-1">194.000 / 200 meses = <strong class="text-green-600">R$ 970,00</strong> (Parcela Reduzida)</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>

        <section>
            <h3 class="flex items-center gap-2 text-xl font-bold text-gmr-navy mb-6 border-b pb-2">
                <i class="fas fa-sliders-h text-gmr-gold"></i> 2. Templates de Perfil (Presets)
            </h3>
            <p class="text-gray-500 mb-6">
                Para agilizar seu atendimento, criamos botões inteligentes no topo do Simulador. Eles preenchem todos os campos automaticamente baseado no perfil do cliente:
            </p>
            
            <div class="grid md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:border-blue-300 transition">
                    <i class="fas fa-seedling text-blue-500 text-2xl mb-2"></i>
                    <h4 class="font-bold text-gmr-navy text-sm">Patrimônio</h4>
                    <p class="text-xs text-gray-500 mt-1">Foca no longo prazo (240x) e parcela mínima. Ideal para jovens sem pressa.</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:border-yellow-300 transition">
                    <i class="fas fa-tachometer-alt text-yellow-500 text-2xl mb-2"></i>
                    <h4 class="font-bold text-gmr-navy text-sm">Acelerado</h4>
                    <p class="text-xs text-gray-500 mt-1">Prazo menor (180x) e já insere um Lance de 30% automático. Para quem tem pressa.</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:border-green-300 transition">
                    <i class="fas fa-chart-line text-green-500 text-2xl mb-2"></i>
                    <h4 class="font-bold text-gmr-navy text-sm">Investidor</h4>
                    <p class="text-xs text-gray-500 mt-1">Simula carta alta (500k) com lance agressivo (40%) para contemplar e revender.</p>
                </div>
                <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:border-purple-300 transition">
                    <i class="fas fa-home text-purple-500 text-2xl mb-2"></i>
                    <h4 class="font-bold text-gmr-navy text-sm">Família</h4>
                    <p class="text-xs text-gray-500 mt-1">Crédito médio (350k) com lance de 20% (simulando um FGTS).</p>
                </div>
            </div>
        </section>

        <section>
            <h3 class="flex items-center gap-2 text-xl font-bold text-gmr-navy mb-6 border-b pb-2">
                <i class="fas fa-toolbox text-gmr-gold"></i> 3. Ferramentas de Fechamento
            </h3>
            <div class="grid md:grid-cols-3 gap-6">
                
                <div class="bg-white p-6 rounded-xl border-l-4 border-gmr-gold shadow-sm">
                    <h4 class="font-bold text-gmr-navy flex items-center gap-2"><i class="fas fa-search-dollar"></i> Analista de Lances</h4>
                    <p class="text-sm text-gray-500 mt-2">
                        Cruza a média histórica do grupo com o dinheiro do cliente para dar a <strong>Probabilidade de Contemplação</strong> (Alta/Média/Baixa).
                    </p>
                    <a href="<?= \App\Config\Config::BASE_URL ?>/ferramentas/lances" class="text-xs font-bold text-gmr-gold mt-3 block hover:underline">Acessar Ferramenta &rarr;</a>
                </div>

                <div class="bg-white p-6 rounded-xl border-l-4 border-green-500 shadow-sm">
                    <h4 class="font-bold text-gmr-navy flex items-center gap-2"><i class="fas fa-chart-line"></i> Investidor Pro (ROI)</h4>
                    <p class="text-sm text-gray-500 mt-2">
                        Calcula o lucro líquido da venda da carta (Ágio) e compara se o retorno supera a Renda Fixa (CDI) no mesmo período.
                    </p>
                    <a href="<?= \App\Config\Config::BASE_URL ?>/ferramentas/investidor" class="text-xs font-bold text-green-600 mt-3 block hover:underline">Acessar Ferramenta &rarr;</a>
                </div>

                <div class="bg-white p-6 rounded-xl border-l-4 border-purple-500 shadow-sm">
                    <h4 class="font-bold text-gmr-navy flex items-center gap-2"><i class="fas fa-file-pdf"></i> Gerador de PDF</h4>
                    <p class="text-sm text-gray-500 mt-2">
                        Agora todas as ferramentas (Simulador, Lances e Investidor) possuem botão de exportar relatório em PDF profissional.
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-gray-900 text-white rounded-2xl shadow-lg p-8">
            <div class="flex items-center gap-3 mb-6 border-b border-gray-700 pb-4">
                <i class="fas fa-trophy text-gmr-gold text-2xl"></i>
                <h3 class="text-xl font-bold">4. Painel de Performance</h3>
                <span class="ml-auto text-xs bg-gmr-gold text-gmr-navy px-2 py-1 rounded font-bold">NOVIDADE</span>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <p class="text-gray-400 mb-4 text-sm">
                        O novo dashboard "Minha Performance" centraliza seus resultados mensais e ajuda a prestar contas para a diretoria.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-400 mt-1"></i>
                            <span><strong>Cálculo Automático de Comissão:</strong> Baseado na % definida nas suas configurações.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-400 mt-1"></i>
                            <span><strong>Funil Visual:</strong> Acompanhe onde seus leads estão travando (Novos > Proposta > Fechamento).</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-400 mt-1"></i>
                            <span><strong>Registro de Atividades:</strong> Anote manualmente quantas ligações e visitas você fez no mês.</span>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                    <h4 class="font-bold text-gmr-gold mb-3 text-sm uppercase">Como Exportar Relatório?</h4>
                    <p class="text-xs text-gray-300 mb-3">
                        Na tela de Performance, você encontrará dois botões de exportação:
                    </p>
                    <div class="space-y-2">
                        <div class="bg-green-900/50 p-2 rounded flex items-center gap-2 border border-green-500/30">
                            <i class="fas fa-file-excel text-green-400"></i>
                            <span class="text-xs">Excel (CSV): Para controle pessoal e planilhas.</span>
                        </div>
                        <div class="bg-blue-900/50 p-2 rounded flex items-center gap-2 border border-blue-500/30">
                            <i class="fas fa-file-pdf text-blue-400"></i>
                            <span class="text-xs">PDF Gerencial: Layout oficial para enviar ao gestor.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h3 class="flex items-center gap-2 text-xl font-bold text-gmr-navy mb-6 border-b pb-2">
                <i class="fas fa-cog text-gmr-gold"></i> 5. Configurações Globais
            </h3>
            <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200 space-y-4">
                <p class="text-sm text-yellow-800 mb-4">
                    Acesse o menu <strong>Configurações</strong> para personalizar o sistema ao seu modo de trabalho:
                </p>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="flex gap-3">
                        <i class="fas fa-check-circle text-yellow-600 mt-1"></i>
                        <div>
                            <strong>Taxas de Mercado:</strong> Defina a Taxa Adm (ex: 22%) e a Taxa de Financiamento (ex: 10.5%) usada no comparativo.
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <i class="fas fa-check-circle text-yellow-600 mt-1"></i>
                        <div>
                            <strong>Sua Comissão:</strong> Defina sua % de ganho (ex: 1.2%) para o cálculo automático de performance.
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <i class="fas fa-check-circle text-yellow-600 mt-1"></i>
                        <div>
                            <strong>Meta Mensal:</strong> Estabeleça seu alvo de vendas (ex: R$ 200k) para acompanhar o gráfico de progresso.
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
<?php include __DIR__ . '/../../../layouts/header.php'; ?>

<div x-data="bidAnalyst()" class="max-w-4xl mx-auto">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
           <h2 class="text-2xl font-serif font-bold text-gmr-navy">Calculadora <span class="text-yellow-600">Investidor Pro</span></h2>
            <p class="text-gray-500">Calcule a viabilidade do lance com base na média do grupo.</p>
        </div>
        <button @click="generatePDF()" class="bg-gmr-navy text-white px-6 py-3 rounded-lg shadow-lg hover:bg-opacity-90 flex items-center gap-2 transition-transform hover:-translate-y-1 w-full md:w-auto justify-center">
            <i class="fas fa-file-pdf"></i> Gerar Relatório PDF
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gmr-navy mb-4 border-b pb-2">1. Dados do Consórcio</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Valor do Crédito</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">R$</span>
                            <input type="number" x-model="creditValue" @input="recalcAll('credit')" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg outline-none focus:border-gmr-gold font-bold text-lg">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Média de Lance do Grupo (%)</label>
                        <div class="relative">
                            <input type="number" x-model="groupAvgPercent" @input="analyze()" class="w-full pl-4 pr-10 py-2 border border-gray-200 rounded-lg outline-none focus:border-gmr-navy font-bold">
                            <span class="absolute right-3 top-2 text-gray-400 font-bold">%</span>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">Consulte a média atual do grupo na administradora.</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                <h3 class="font-bold text-gmr-navy mb-4 border-b border-blue-200 pb-2">2. Recurso do Cliente (Bidirecional)</h3>
                <p class="text-xs text-blue-800 mb-4">Preencha <strong>qualquer um</strong> dos campos abaixo, o outro será calculado automaticamente.</p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-blue-800 uppercase mb-1">Dinheiro Disponível (Lance Livre)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-blue-400">R$</span>
                            <input type="number" x-model="clientCash" @input="recalcAll('cash')" class="w-full pl-10 pr-4 py-2 border border-blue-200 rounded-lg outline-none focus:border-gmr-navy font-bold text-xl text-gmr-navy">
                        </div>
                    </div>

                    <div class="flex items-center justify-center text-blue-400">
                        <i class="fas fa-exchange-alt transform rotate-90"></i>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-blue-800 uppercase mb-1">Equivalente em Porcentagem</label>
                        <div class="relative">
                            <input type="number" x-model="clientPercent" @input="recalcAll('percent')" class="w-full pl-4 pr-10 py-2 border border-blue-200 rounded-lg outline-none focus:border-gmr-navy font-bold text-xl text-gmr-navy">
                            <span class="absolute right-3 top-2.5 text-blue-400 font-bold">%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 h-full relative overflow-hidden flex flex-col justify-between">
                <div>
                    <h3 class="font-bold text-gmr-navy mb-6 text-center">Resultado da Análise</h3>

                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                            <span class="text-gray-500 text-sm">Média do Grupo</span>
                            <span class="font-bold text-gray-700" x-text="groupAvgPercent + '%'"></span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                            <span class="text-gmr-navy font-bold text-sm">Lance do Cliente</span>
                            <span class="font-bold text-gmr-navy" x-text="clientPercent + '%'"></span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-sm text-gray-500">Diferença</span>
                            <span class="font-bold" :class="diff > 0 ? 'text-green-500' : 'text-red-500'" x-text="(diff > 0 ? '+' : '') + diff.toFixed(2) + '%'"></span>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full border-4 mb-4 shadow-inner text-3xl transition-colors duration-500"
                             :class="{
                                'border-green-500 bg-green-50 text-green-600': status === 'ALTA',
                                'border-yellow-500 bg-yellow-50 text-yellow-600': status === 'MÉDIA',
                                'border-red-500 bg-red-50 text-red-600': status === 'BAIXA'
                             }">
                            <i class="fas" :class="{
                                'fa-thumbs-up': status === 'ALTA',
                                'fa-minus': status === 'MÉDIA',
                                'fa-thumbs-down': status === 'BAIXA'
                            }"></i>
                        </div>
                        
                        <h4 class="text-xl font-bold mb-1" 
                            :class="{
                                'text-green-600': status === 'ALTA',
                                'text-yellow-600': status === 'MÉDIA',
                                'text-red-600': status === 'BAIXA'
                            }" x-text="status + ' PROBABILIDADE'"></h4>
                        
                        <p class="text-sm text-gray-500 px-4" x-text="message"></p>
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r"
                     :class="{
                        'from-green-400 to-green-600': status === 'ALTA',
                        'from-yellow-400 to-yellow-600': status === 'MÉDIA',
                        'from-red-400 to-red-600': status === 'BAIXA'
                     }"></div>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gmr-navy border-b pb-2 mb-4">Análise do Especialista</h3>
        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Comentários para o Cliente</label>
        <textarea x-model="consultantNotes" rows="3" class="w-full p-3 border border-gray-300 rounded-lg text-sm focus:border-gmr-navy outline-none" placeholder="Ex: A média histórica deste grupo é estável, o que aumenta a segurança da sua oferta..."></textarea>
        <p class="text-[10px] text-gray-400 mt-2 text-right">Estas anotações aparecerão no relatório PDF.</p>
    </div>

</div>

<script>
function bidAnalyst() {
    return {
        creditValue: 200000,
        groupAvgPercent: 30, 
        clientCash: 0,
        clientPercent: 0,
        consultantNotes: '', // Novo campo para o PDF
        
        status: 'BAIXA',
        message: 'Aguardando dados...',
        diff: 0,

        init() {
            this.recalcAll('percent'); 
        },

        // A Mágica Bidirecional
        recalcAll(source) {
            const credit = parseFloat(this.creditValue) || 0;
            if (credit === 0) return;

            if (source === 'cash') {
                let cash = parseFloat(this.clientCash);
                this.clientPercent = ((cash / credit) * 100).toFixed(2);
            } 
            else if (source === 'percent') {
                let pct = parseFloat(this.clientPercent);
                this.clientCash = ((pct / 100) * credit).toFixed(2);
            }
            else if (source === 'credit') {
                let pct = parseFloat(this.clientPercent);
                this.clientCash = ((pct / 100) * credit).toFixed(2);
            }
            this.analyze();
        },

        analyze() {
            const myBid = parseFloat(this.clientPercent);
            const avg = parseFloat(this.groupAvgPercent);
            
            if (!myBid || !avg) {
                this.status = '...';
                this.message = 'Preencha os valores.';
                return;
            }

            this.diff = myBid - avg;

            // Lógica de Probabilidade
            if (myBid >= (avg + 5)) { 
                this.status = 'ALTA';
                this.message = 'Seu lance está confortavelmente acima da média do grupo. Excelentes chances!';
            } else if (myBid >= avg) {
                this.status = 'MÉDIA';
                this.message = 'Você está na briga! Seu lance empata ou supera levemente a média. Depende do desempate.';
            } else {
                this.status = 'BAIXA';
                this.message = 'Seu lance está abaixo da média histórica do grupo. Risco alto de não contemplação.';
            }
        },

        // Função Gerar PDF
        generatePDF() {
            const params = new URLSearchParams({
                credit: this.creditValue,
                avg: this.groupAvgPercent,
                bid_val: this.clientCash,
                bid_pct: this.clientPercent,
                status: this.status,
                diff: this.diff.toFixed(2),
                notes: this.consultantNotes
            });

            const url = '<?= \App\Config\Config::BASE_URL ?>/ferramentas/lances/pdf?' + params.toString();
            window.open(url, '_blank');
        }
    }
}
</script>

<?php include __DIR__ . '/../../../layouts/footer.php'; ?>
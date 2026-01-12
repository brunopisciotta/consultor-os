<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div x-data="simulator()" class="max-w-7xl mx-auto relative">

    <div x-show="feedback" x-transition 
         class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 font-bold flex items-center gap-2"
         style="display: none;">
        <i class="fas fa-check-circle"></i> <span x-text="feedback"></span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gmr-navy">Simulador de Estratégia</h2>
            <p class="text-sm text-gray-500">Compare cenários e prove a economia para seu cliente.</p>
        </div>
        <div class="flex gap-2">
            <button @click="saveModal = true" class="px-4 py-2 bg-gmr-navy text-white rounded-lg hover:bg-opacity-90 text-sm font-medium shadow-lg shadow-gmr-navy/20 flex items-center gap-2">
                <i class="fas fa-save"></i> Salvar no Lead
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                
                <h3 class="font-bold text-gmr-navy mb-4 flex items-center gap-2">
                    <i class="fas fa-sliders-h"></i> Parâmetros do Crédito
                </h3>

                <div class="mb-6 pb-6 border-b border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase mb-2">Carregar Estratégia (Presets)</p>
                    <div class="grid grid-cols-2 gap-2">
                        <button @click="applyPreset('patrimonio')" class="px-3 py-2 rounded-lg text-xs font-bold border transition hover:bg-blue-50 text-left group" :class="currentPreset === 'patrimonio' ? 'bg-blue-100 border-blue-200 text-blue-700' : 'bg-white border-gray-200 text-gray-500'">
                            <i class="fas fa-seedling mb-1 block text-lg" :class="currentPreset === 'patrimonio' ? 'text-blue-600' : 'text-gray-300 group-hover:text-blue-400'"></i> Patrimônio
                        </button>
                        
                        <button @click="applyPreset('acelerado')" class="px-3 py-2 rounded-lg text-xs font-bold border transition hover:bg-yellow-50 text-left group" :class="currentPreset === 'acelerado' ? 'bg-yellow-100 border-yellow-200 text-yellow-700' : 'bg-white border-gray-200 text-gray-500'">
                            <i class="fas fa-tachometer-alt mb-1 block text-lg" :class="currentPreset === 'acelerado' ? 'text-yellow-600' : 'text-gray-300 group-hover:text-yellow-400'"></i> Acelerador
                        </button>

                        <button @click="applyPreset('investidor')" class="px-3 py-2 rounded-lg text-xs font-bold border transition hover:bg-green-50 text-left group" :class="currentPreset === 'investidor' ? 'bg-green-100 border-green-200 text-green-700' : 'bg-white border-gray-200 text-gray-500'">
                            <i class="fas fa-chart-line mb-1 block text-lg" :class="currentPreset === 'investidor' ? 'text-green-600' : 'text-gray-300 group-hover:text-green-400'"></i> Investidor
                        </button>

                        <button @click="applyPreset('familia')" class="px-3 py-2 rounded-lg text-xs font-bold border transition hover:bg-indigo-50 text-left group" :class="currentPreset === 'familia' ? 'bg-indigo-100 border-indigo-200 text-indigo-700' : 'bg-white border-gray-200 text-gray-500'">
                            <i class="fas fa-home mb-1 block text-lg" :class="currentPreset === 'familia' ? 'text-indigo-600' : 'text-gray-300 group-hover:text-indigo-400'"></i> Família
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gmr-navy mb-1">Valor do Crédito (Carta)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-400">R$</span>
                        <input type="number" x-model="creditValue" @input="calculate()" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:border-gmr-gold focus:ring-1 focus:ring-gmr-gold outline-none font-bold text-gmr-navy">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gmr-navy mb-1">Prazo (Meses)</label>
                    <input type="number" x-model="months" @input="calculate()" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-gmr-gold outline-none">
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-gray-500 uppercase block">Seguro de Vida (0,038%)</span>
                        <span class="text-[10px] text-gray-400">Proteção prestamista</span>
                    </div>
                    <button @click="hasInsurance = !hasInsurance; calculate()" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none" :class="hasInsurance ? 'bg-green-500' : 'bg-gray-200'">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform shadow-sm" :class="hasInsurance ? 'translate-x-6' : 'translate-x-1'"></span>
                    </button>
                </div>

                <div class="mt-6 border-t border-gray-100 pt-4">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm font-medium text-gmr-navy">Possui Lance?</label>
                        <button @click="hasBid = !hasBid; if(!hasBid) bidValue = 0; calculate()" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none" :class="hasBid ? 'bg-gmr-navy' : 'bg-gray-200'">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform" :class="hasBid ? 'translate-x-6' : 'translate-x-1'"></span>
                        </button>
                    </div>
                    <div x-show="hasBid" x-transition>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gmr-gold font-bold">R$</span>
                            <input type="number" x-model="bidValue" @input="calculate()" placeholder="0,00" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:border-gmr-navy focus:ring-1 focus:ring-gmr-navy outline-none font-bold text-gray-700">
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl mt-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Parâmetros do Banco (Concorrente)</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="text-[10px] text-gray-500 block mb-1 font-bold">Prazo do Financiamento (Meses)</label>
                            <input type="number" x-model="financingMonths" @input="calculate()" class="w-full p-2 text-sm border rounded focus:border-red-400 outline-none">
                            <p class="text-[9px] text-gray-400 mt-1 text-right">Geralmente 360 ou 420 meses</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] text-gray-500 block mb-1">Taxa Adm Consórcio (%)</label>
                                <input type="number" x-model="consortiumRate" @input="calculate()" class="w-full p-2 text-sm border rounded">
                            </div>
                            <div>
                                <label class="text-[10px] text-gray-500 block mb-1">Juros Financiamento (a.a)</label>
                                <input type="number" x-model="financingRateYear" @input="calculate()" class="w-full p-2 text-sm border rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gmr-navy text-white p-6 rounded-xl relative overflow-hidden shadow-xl">
                    <h3 class="text-gmr-gold font-serif font-bold text-lg mb-1">Cenário GMR (Consórcio)</h3>
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between items-end border-b border-white/10 pb-2">
                            <span class="text-sm text-gray-300">Parcela Mensal</span>
                            <span class="text-2xl font-bold" x-text="formatMoney(consortiumParcel)"></span>
                        </div>
                        <div class="flex justify-between text-sm pt-1">
                            <span class="text-gray-400">Custo Total Final</span>
                            <span class="text-gmr-gold font-bold" x-text="formatMoney(consortiumTotal)"></span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h3 class="text-gray-800 font-serif font-bold text-lg mb-1">Banco (Financiamento)</h3>
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between items-end border-gray-100 pb-2 border-b">
                            <span class="text-sm text-gray-500">Parcela Estimada</span>
                            <span class="text-2xl font-bold text-gray-700" x-text="formatMoney(financingParcel)"></span>
                        </div>
                        <div class="flex justify-between text-sm pt-1">
                            <span class="text-gray-500">Custo Total Final</span>
                            <span class="text-red-500 font-bold" x-text="formatMoney(financingTotal)"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gmr-navy mb-6">Para onde vai o dinheiro?</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-bold text-gmr-navy">Consórcio</span>
                            <span class="text-gray-500">Custo Efetivo: <span x-text="formatMoney(consortiumTotal - creditValue)"></span></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-8 flex overflow-hidden">
                            <div class="bg-gmr-navy h-full flex items-center justify-center text-xs text-white" :style="`width: ${getPercent(creditValue, financingTotal)}%`">Crédito</div>
                            <div class="bg-gmr-gold h-full flex items-center justify-center text-xs text-gmr-navy font-bold" :style="`width: ${getPercent(consortiumTotal - creditValue, financingTotal)}%`">Taxas</div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-bold text-gray-700">Financiamento</span>
                            <span class="text-red-500 font-bold">Juros Pagos: <span x-text="formatMoney(financingTotal - creditValue)"></span></span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-8 flex overflow-hidden relative">
                            <div class="bg-gray-400 h-full flex items-center justify-center text-xs text-white" :style="`width: ${getPercent(creditValue, financingTotal)}%`">Bem</div>
                            <div class="bg-red-500 h-full flex items-center justify-center text-xs text-white font-bold" :style="`width: ${getPercent(financingTotal - creditValue, financingTotal)}%`">JUROS</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-4">
                    <div class="bg-green-100 p-2 rounded-full text-green-600"><i class="fas fa-piggy-bank text-2xl"></i></div>
                    <div>
                        <p class="text-sm text-green-800 font-bold">Economia Gerada para o Cliente:</p>
                        <p class="text-2xl font-bold text-green-600" x-text="formatMoney(financingTotal - consortiumTotal)"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="saveModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="saveModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                <h3 class="text-lg font-bold text-gmr-navy mb-4">Salvar Simulação</h3>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                    <select x-model="selectedLead" class="w-full rounded-lg border-gray-300 border p-2.5 text-sm focus:border-gmr-navy focus:ring-gmr-navy">
                        <option value="" disabled>Selecione um cliente...</option>
                        <?php foreach($leads as $lead): ?>
                            <option value="<?= $lead->id ?>"><?= $lead->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <button @click="saveModal = false" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Cancelar</button>
                    <button @click="saveToDatabase()" class="px-4 py-2 bg-gmr-navy text-white rounded-lg hover:bg-opacity-90">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function simulator() {
    return {
        // Estado Inicial
        creditValue: 200000,
        months: 200,
        financingMonths: 360, // Padrão banco 30 anos
        consortiumRate: <?= $user->default_consortium_rate ?? 22 ?>, 
        financingRateYear: <?= $user->default_financing_rate ?? 10.5 ?>,
        
        hasInsurance: false, 
        
        hasBid: false,
        bidValue: 0,
        
        currentPreset: '', 
        saveModal: false, 
        selectedLead: '', 
        feedback: '',

        consortiumParcel: 0,
        consortiumTotal: 0,
        financingParcel: 0,
        financingTotal: 0,

        init() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('credit')) this.creditValue = parseFloat(params.get('credit'));
            if (params.get('term')) this.months = parseInt(params.get('term'));
            if (params.get('fin_term')) this.financingMonths = parseInt(params.get('fin_term'));
            if (params.get('bid')) {
                this.bidValue = parseFloat(params.get('bid'));
                this.hasBid = (this.bidValue > 0);
            }
            if (params.get('lead_id')) this.selectedLead = params.get('lead_id');
            this.calculate();
        },

        calculate() {
            let taxaAdmTotal = (this.consortiumRate / 100);
            
            let custoSeguro = 0;
            if (this.hasInsurance) {
                let taxaSeguroMes = 0.00038; 
                custoSeguro = (parseFloat(this.creditValue) * taxaSeguroMes) * parseFloat(this.months);
            }

            let valorTotalConsorcio = (parseFloat(this.creditValue) * (1 + taxaAdmTotal)) + custoSeguro;
            
            if (this.hasBid && this.bidValue > 0) {
                let saldoRestante = valorTotalConsorcio - this.bidValue;
                this.consortiumParcel = saldoRestante > 0 ? saldoRestante / this.months : 0; 
            } else {
                this.consortiumParcel = valorTotalConsorcio / this.months;
            }
            this.consortiumTotal = valorTotalConsorcio; 

            // Financiamento com prazo flexível
            let taxaMensal = (Math.pow((1 + (this.financingRateYear / 100)), 1/12) - 1);
            let n = this.financingMonths; // Usa o prazo do banco
            let pv = parseFloat(this.creditValue); 
            let pmt = pv * ( (taxaMensal * Math.pow(1+taxaMensal, n)) / (Math.pow(1+taxaMensal, n) - 1) );
            
            this.financingParcel = pmt;
            this.financingTotal = pmt * n;
        },

        saveToDatabase() {
            if(!this.selectedLead) {
                alert('Selecione um cliente!');
                return;
            }

            const payload = {
                lead_id: this.selectedLead,
                credit_value: this.creditValue,
                term_months: this.months,
                financing_term_months: this.financingMonths, // Novo
                consortium_rate: this.consortiumRate,
                consortium_parcel: this.consortiumParcel,
                consortium_total: this.consortiumTotal,
                financing_total: this.financingTotal,
                bid_suggestion: this.hasBid ? this.bidValue : 0,
                has_insurance: this.hasInsurance
            };

            const url = '<?= \App\Config\Config::BASE_URL ?>/simulador/save';

            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(async response => {
                if (!response.ok) {
                    const text = await response.text();
                    console.error('Erro Servidor:', text); 
                    throw new Error('Erro no servidor: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if(data.status === 'success') {
                    this.saveModal = false;
                    this.feedback = 'Simulação salva com sucesso!';
                    setTimeout(() => this.feedback = '', 3000);
                } else {
                    alert('Erro ao salvar: ' + (data.message || 'Erro desconhecido'));
                }
            })
            .catch(error => {
                console.error('Detalhes do erro:', error);
                alert('Falha na comunicação. Verifique o console (F12) para detalhes.\n' + error.message);
            });
        },

        formatMoney(value) {
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
        },
        getPercent(part, total) {
            if(total === 0) return 0;
            return (part / total) * 100;
        },
        applyPreset(type) {
            this.currentPreset = type;
            
            if (type === 'patrimonio') {
                this.creditValue = 200000; // Padrão
                this.months = 240; 
                this.financingMonths = 420; // 35 anos
                this.hasBid = false; 
                this.bidValue = 0;

            } else if (type === 'acelerado') {
                this.creditValue = 200000;
                this.months = 180; 
                this.financingMonths = 360; 
                this.hasBid = true; 
                this.bidValue = (this.creditValue * 0.30).toFixed(0); // 30% Lance
            
            } else if (type === 'investidor') {
                this.creditValue = 500000; // Carta Alta
                this.months = 180; 
                this.financingMonths = 360;
                this.hasBid = true;
                this.bidValue = (this.creditValue * 0.40).toFixed(0); // 40% Lance (Agressivo)

            } else if (type === 'familia') {
                this.creditValue = 350000; // Crédito Médio
                this.months = 200; 
                this.financingMonths = 420; // 35 anos (Longo)
                this.hasBid = true;
                this.bidValue = (this.creditValue * 0.20).toFixed(0); // 20% Lance (FGTS)
            }
            
            this.calculate();
        }
    }
}
</script>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
<?php include __DIR__ . '/../../../layouts/header.php'; ?>

<div x-data="investorCalc()" class="max-w-4xl mx-auto">
    
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gmr-navy">Calculadora <span class="text-green-600">Investidor Pro</span></h2>
            <p class="text-gray-500">Simule o lucro líquido na revenda de uma carta contemplada.</p>
        </div>
        <button @click="generatePDF()" class="bg-gmr-navy text-white px-6 py-3 rounded-lg shadow-lg hover:bg-opacity-90 flex items-center gap-2 transition-transform hover:-translate-y-1">
            <i class="fas fa-file-pdf"></i> Gerar Relatório PDF
        </button>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-5">
                <h3 class="font-bold text-gmr-navy border-b pb-2 mb-4">1. Dados da Carta</h3>
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Valor da Carta (Crédito)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-400">R$</span>
                        <input type="number" x-model="credit" @input="calc()" class="w-full pl-8 p-2 border rounded font-bold text-gmr-navy">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Parcela Mensal</label>
                        <input type="number" x-model="parcel" @input="calc()" class="w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Meses Pagos</label>
                        <input type="number" x-model="monthsPaid" @input="calc()" class="w-full p-2 border rounded">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Entrada / Lance Pago</label>
                    <input type="number" x-model="downPayment" @input="calc()" class="w-full p-2 border rounded">
                    <p class="text-xs text-gray-400 mt-1">Total investido do bolso até a venda.</p>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <label class="block text-xs font-bold text-green-600 uppercase mb-1">Valor de Venda (Ágio + Repasse)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-green-600 font-bold">R$</span>
                        <input type="number" x-model="salePrice" @input="calc()" class="w-full pl-8 p-2 border-2 border-green-100 rounded font-bold text-green-700 bg-green-50">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Valor de mercado para venda do ágio.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-gmr-navy border-b pb-2 mb-4">3. Análise do Consultor</h3>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Mensagem para o Investidor</label>
                <textarea x-model="consultantNotes" rows="4" class="w-full p-3 border border-gray-300 rounded-lg text-sm focus:border-gmr-navy outline-none" placeholder="Ex: Este cenário considera uma valorização de mercado baseada na média dos últimos 3 meses..."></textarea>
            </div>
        </div>

        <div class="space-y-4">
            
            <div class="bg-gmr-navy text-white p-8 rounded-xl shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <i class="fas fa-chart-line text-9xl text-white"></i>
                </div>
                
                <p class="text-sm opacity-70 mb-1">Lucro Líquido Estimado</p>
                <h2 class="text-4xl font-bold text-gmr-gold">R$ <span x-text="formatMoney(profit)"></span></h2>
                
                <div class="mt-6 flex gap-4 relative z-10">
                    <div>
                        <p class="text-xs opacity-60">Total Investido</p>
                        <p class="font-bold">R$ <span x-text="formatMoney(totalInvested)"></span></p>
                    </div>
                    <div class="pl-4 border-l border-white/20">
                        <p class="text-xs opacity-60">Retorno (ROI)</p>
                        <p class="font-bold text-green-400 text-xl"><span x-text="roi.toFixed(2)"></span>%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-bold text-gray-700">Comparativo de Mercado</h4>
                    <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Benchmark</span>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-bold text-gmr-navy">Consórcio GMR</span>
                            <span class="font-bold text-green-600" x-text="roi.toFixed(2) + '%'"></span>
                        </div>
                        <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full rounded-full transition-all duration-1000" :style="'width: ' + Math.min(roi, 100) + '%'"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-500">Renda Fixa (CDI ~11.25% a.a)</span>
                            <span class="font-bold text-gray-400">11.25%</span>
                        </div>
                        <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                            <div class="bg-gray-400 h-full rounded-full" :style="'width: ' + Math.min(11.25, 100) + '%'"></div>
                        </div>
                    </div>
                </div>

                <div x-show="roi > 11.25" class="mt-6 p-3 bg-green-50 text-green-800 text-sm rounded-lg flex items-center gap-2 border border-green-100">
                    <i class="fas fa-trophy text-lg"></i>
                    <span class="font-medium">Oportunidade: Retorno superior ao mercado financeiro tradicional.</span>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function investorCalc() {
        return {
            credit: 300000,
            parcel: 1500,
            monthsPaid: 12,
            downPayment: 10000, 
            salePrice: 50000, 
            consultantNotes: '', // Novo campo de texto

            // Outputs
            totalInvested: 0,
            profit: 0,
            roi: 0,

            formatMoney(val) { return new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2}).format(val); },

            init() { this.calc(); },

            calc() {
                this.totalInvested = (parseFloat(this.parcel) * parseFloat(this.monthsPaid)) + parseFloat(this.downPayment);
                this.profit = parseFloat(this.salePrice) - this.totalInvested;

                if(this.totalInvested > 0) {
                    this.roi = (this.profit / this.totalInvested) * 100;
                } else {
                    this.roi = 0;
                }
            },

            generatePDF() {
                // Monta a URL com todos os parâmetros via GET
                const params = new URLSearchParams({
                    credit: this.credit,
                    parcel: this.parcel,
                    months: this.monthsPaid,
                    down: this.downPayment,
                    sale: this.salePrice,
                    roi: this.roi.toFixed(2),
                    profit: this.profit.toFixed(2),
                    invested: this.totalInvested.toFixed(2),
                    notes: this.consultantNotes
                });

                const url = '<?= \App\Config\Config::BASE_URL ?>/ferramentas/investidor/pdf?' + params.toString();
                window.open(url, '_blank');
            }
        }
    }
</script>

<?php include __DIR__ . '/../../../layouts/footer.php'; ?>
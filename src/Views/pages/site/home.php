<?php 
// 1. Preparação dos Dados Dinâmicos do Consultor
$nomeConsultor = isset($user) ? $user->name : 'Consultor GMR';
$emailConsultor = isset($user) ? $user->email : 'contato@gmr.com.br';

// Lógica da Foto: Prioriza o banco, senão usa fallback
if (isset($user) && $user->avatar) {
    $fotoConsultor = 'assets/img/' . $user->avatar;
} else {
    $fotoConsultor = 'https://ui-avatars.com/api/?name=' . urlencode($nomeConsultor) . '&background=D4AF37&color=1A2B42';
}

ob_start(); 
?>

<section id="inicio" class="relative bg-gmr-navy pt-28 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
    
    <div class="absolute top-0 right-0 w-full h-full opacity-10 pointer-events-none">
        <div class="absolute right-10 top-20 w-64 h-64 border border-gmr-gold rounded-full opacity-20 animate-pulse"></div>
        <div class="absolute right-20 top-40 w-96 h-96 border border-white rounded-full opacity-10"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 text-white space-y-8">
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                    <img class="w-8 h-8 rounded-full border border-gmr-gold object-cover" src="<?= $fotoConsultor ?>" alt="Foto Consultor">
                    <span class="text-sm font-medium text-gray-200"><?= $nomeConsultor ?> <span class="text-gmr-gold mx-1">•</span> Especialista em Alavancagem</span>
                </div>

                <h1 class="text-4xl lg:text-6xl font-serif font-bold leading-tight">
                    Não venda seu futuro.<br>
                    <span class="text-gmr-gold">Planeje sua riqueza.</span>
                </h1>
                
                <p class="text-lg text-gray-300 max-w-xl leading-relaxed border-l-4 border-gmr-gold pl-6">
                    "A maioria dos gerentes de banco quer te vender dívida. Meu trabalho é diferente: eu uso a matemática dos consórcios para construir seu patrimônio sem juros abusivos."
                </p>

                <div class="pt-4 opacity-80">
                    <p class="font-serif italic text-2xl text-gmr-gold"><?= $nomeConsultor ?></p>
                    <p class="text-xs text-gray-400 uppercase tracking-widest">Consultor Autorizado GMR</p>
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                <div class="absolute -inset-1 bg-gradient-to-r from-gmr-gold to-white opacity-20 blur-lg rounded-2xl"></div>
                
                <div class="relative bg-white rounded-2xl shadow-2xl p-8 border-t-4 border-gmr-gold" x-data="leadQuiz()">
                    
                    <div class="text-center mb-6">
                        <span class="text-xs font-bold text-gmr-navy bg-gray-100 px-2 py-1 rounded uppercase tracking-wider">Análise de Perfil Gratuita</span>
                        <h3 class="text-xl font-serif font-bold text-gmr-navy mt-2">Descubra sua estratégia ideal</h3>
                    </div>

                    <div class="mb-6 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gmr-navy transition-all duration-500" :style="'width: ' + (step/3)*100 + '%'"></div>
                    </div>

                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4">
                        <p class="text-sm text-gray-500 mb-4 text-center">O que você deseja conquistar?</p>
                        <div class="space-y-3">
                            <button @click="setGoal('imovel')" class="w-full flex items-center p-3 border border-gray-200 rounded-lg hover:border-gmr-navy hover:bg-gray-50 transition group text-left">
                                <span class="w-8 h-8 rounded bg-gray-100 text-gray-500 flex items-center justify-center group-hover:bg-gmr-navy group-hover:text-white transition"><i class="fas fa-home"></i></span>
                                <span class="ml-3 font-medium text-gray-700">Imóvel (Compra/Construção)</span>
                            </button>
                            <button @click="setGoal('auto')" class="w-full flex items-center p-3 border border-gray-200 rounded-lg hover:border-gmr-navy hover:bg-gray-50 transition group text-left">
                                <span class="w-8 h-8 rounded bg-gray-100 text-gray-500 flex items-center justify-center group-hover:bg-gmr-navy group-hover:text-white transition"><i class="fas fa-car"></i></span>
                                <span class="ml-3 font-medium text-gray-700">Veículo Premium/Pesado</span>
                            </button>
                            <button @click="setGoal('investimento')" class="w-full flex items-center p-3 border border-gray-200 rounded-lg hover:border-gmr-navy hover:bg-gray-50 transition group text-left">
                                <span class="w-8 h-8 rounded bg-gray-100 text-gray-500 flex items-center justify-center group-hover:bg-gmr-navy group-hover:text-white transition"><i class="fas fa-chart-line"></i></span>
                                <span class="ml-3 font-medium text-gray-700">Investimento / Revenda</span>
                            </button>
                        </div>
                    </div>

                    <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4">
                        <p class="text-sm text-gray-500 mb-4 text-center">Qual o valor estimado do crédito?</p>
                        <div class="text-center mb-8">
                            <span class="text-3xl font-bold text-gmr-navy border-b-2 border-gmr-gold pb-1">R$ <span x-text="formatMoney(value)"></span></span>
                        </div>
                        <input type="range" min="50000" max="1000000" step="10000" x-model="value" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-gmr-navy">
                        <div class="flex gap-3 mt-8">
                            <button @click="step--" class="px-4 py-2 text-gray-400 hover:text-gmr-navy">Voltar</button>
                            <button @click="step++" class="flex-1 bg-gmr-navy text-white py-2 rounded-lg font-bold hover:opacity-90">Avançar</button>
                        </div>
                    </div>

                    <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4">
                        <p class="text-sm text-gray-500 mb-4 text-center">Tudo pronto. Onde envio sua análise?</p>
                        <form @submit.prevent="submitLead" class="space-y-4">
                            <input type="text" x-model="form.name" required class="w-full p-3 border border-gray-200 rounded-lg focus:border-gmr-navy outline-none" placeholder="Seu Nome">
                            <input type="email" x-model="form.email" class="w-full p-3 border border-gray-200 rounded-lg focus:border-gmr-navy outline-none" placeholder="Seu E-mail (Opcional)">
                            <input type="tel" x-model="form.phone" required class="w-full p-3 border border-gray-200 rounded-lg focus:border-gmr-navy outline-none" placeholder="Seu WhatsApp">
                            
                            <div class="mt-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Conta pra gente: Qual o seu objetivo hoje? <span class="text-gray-400 font-normal">(Opcional)</span>
                                </label>
                                <textarea 
                                    x-model="form.message" 
                                    name="message" 
                                    rows="3" 
                                    class="w-full p-3 border border-gray-300 rounded-lg focus:border-gmr-navy outline-none text-sm"
                                    placeholder="Ex: Moro de aluguel e quero minha casa própria em 6 meses, mas não tenho muito para dar de entrada..."
                                ></textarea>
                                <p class="text-[10px] text-gray-500 mt-1">
                                    <i class="fas fa-lock"></i> Quanto mais detalhes você der, melhor conseguimos desenhar sua estratégia.
                                </p>
                            </div>
                            
                            <button type="submit" :disabled="loading" class="w-full py-3 bg-gmr-gold text-gmr-navy font-bold rounded-lg hover:bg-yellow-500 transition relative overflow-hidden disabled:opacity-50">
                                <span x-show="!loading">Receber Estudo Personalizado</span>
                                <span x-show="loading" class="flex items-center justify-center gap-2">
                                    <i class="fas fa-circle-notch fa-spin"></i> Processando...
                                </span>
                            </button>
                        </form>
                    </div>

                    <div x-show="step === 4" style="display: none;" class="text-center py-6">
                        <i class="fas fa-check-circle text-5xl text-green-500 mb-4"></i>
                        <h4 class="text-xl font-bold text-gmr-navy">Solicitação Recebida!</h4>
                        <p class="text-sm text-gray-500 mt-2 mb-6">Já comecei a analisar seu perfil e gerei uma simulação inicial. Em breve te chamo no WhatsApp.</p>
                        <?php 
                            $phoneClean = isset($user) ? preg_replace('/\D/', '', $user->phone) : '';
                            $waLink = "https://wa.me/55{$phoneClean}?text=" . urlencode("Olá {$nomeConsultor}. Fiz a analise de perfil no seu site e gostaria de ver os detalhes da minha simulação!");
                        ?>
                        <a target="_blank" href="<?= $waLink ?>" class="text-gmr-navy font-bold hover:underline">Falar comigo agora &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2 relative">
                <div class="absolute inset-0 bg-gmr-gold transform translate-x-4 translate-y-4 rounded-xl"></div>
                <img class="relative w-full rounded-xl shadow-lg grayscale hover:grayscale-0 transition duration-500 object-cover aspect-[4/5]" src="<?= $fotoConsultor ?>" alt="Consultor <?= $nomeConsultor ?>">
                
                <div class="absolute bottom-6 left-6 bg-white p-4 rounded-lg shadow-xl border-l-4 border-gmr-navy">
                    <p class="text-3xl font-bold text-gmr-navy">+20k</p>
                    <p class="text-xs text-gray-500 uppercase">Clientes GMR Satisfeitos</p>
                </div> 
            </div>

            <div class="w-full md:w-1/2 space-y-6">
                <h2 class="text-3xl font-serif font-bold text-gmr-navy">Mais que um vendedor,<br>seu parceiro de negócios.</h2>
                <p class="text-gray-600 leading-relaxed">
                    Meu nome é <strong><?= $nomeConsultor ?></strong>. Atuo no mercado financeiro focado em uma falha grave: as pessoas pagam juros abusivos por falta de planejamento.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Como consultor Elite da GMR, eu desenho estratégias. Uso o sistema <strong>ConsultorOS</strong> para encontrar as melhores oportunidades matemáticas para o seu patrimônio.
                </p>
                
                <div class="grid grid-cols-2 gap-6 pt-4">
                    <div>
                        <i class="fas fa-certificate text-gmr-gold text-2xl mb-2"></i>
                        <h4 class="font-bold text-gmr-navy">Certificado</h4>
                        <p class="text-xs text-gray-500">Profissional Habilitado</p>
                    </div>
                    <div>
                        <i class="fas fa-laptop-code text-gmr-gold text-2xl mb-2"></i>
                        <h4 class="font-bold text-gmr-navy">Análise Digital</h4>
                        <p class="text-xs text-gray-500">Baseado em Dados</p>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="#inicio" class="inline-block border-b-2 border-gmr-navy pb-1 text-gmr-navy font-bold hover:text-gmr-gold hover:border-gmr-gold transition">
                        Solicitar minha análise pessoal
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-serif font-bold text-gmr-navy mb-12">Por que fazer sua consultoria comigo?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition border-t-4 border-transparent hover:border-gmr-gold group">
                <div class="w-14 h-14 bg-blue-50 text-gmr-navy rounded-full flex items-center justify-center text-2xl mx-auto mb-6 group-hover:bg-gmr-navy group-hover:text-white transition">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3 class="font-bold text-lg mb-3">Matemática Real</h3>
                <p class="text-sm text-gray-500">Apresento cenários reais, estatísticas de lance e probabilidade matemática para seu projeto.</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition border-t-4 border-transparent hover:border-gmr-gold group">
                <div class="w-14 h-14 bg-blue-50 text-gmr-navy rounded-full flex items-center justify-center text-2xl mx-auto mb-6 group-hover:bg-gmr-navy group-hover:text-white transition">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3 class="font-bold text-lg mb-3">Foco em Alavancagem</h3>
                <p class="text-sm text-gray-500">Especialista em usar a carta de crédito para aumentar seu patrimônio, não apenas para consumo.</p>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition border-t-4 border-transparent hover:border-gmr-gold group">
                <div class="w-14 h-14 bg-blue-50 text-gmr-navy rounded-full flex items-center justify-center text-2xl mx-auto mb-6 group-hover:bg-gmr-navy group-hover:text-white transition">
                    <i class="fas fa-robot"></i>
                </div>
                <h3 class="font-bold text-lg mb-3">Tecnologia Exclusiva</h3>
                <p class="text-sm text-gray-500">Utilizo o software ConsultorOS para encontrar as melhores taxas e grupos do mercado.</p>
            </div>
        </div>
    </div>
</section>

<footer class="bg-gmr-navy text-white py-12 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-3">
            <div class="w-14 h-10 bg-gmr-gold rounded flex items-center justify-center text-gmr-navy font-bold font-serif">GMR</div>
            <div>
                <p class="font-serif font-bold text-lg leading-none"><?= $nomeConsultor ?></p>
                <p class="text-xs text-gray-400 uppercase tracking-widest">Consultoria Financeira</p>
            </div>
        </div>
        <div class="text-sm text-gray-400 text-center md:text-right">
            <p><a href="https://bpso.com.br/">Desenvolvido por BPSO.</a></p>
            <p class="text-xs mt-1 opacity-50">&copy; <?= date('Y') ?> Todos os Direitos Reservados</p>
        </div>
    </div>
</footer>

<script>
    function leadQuiz() {
        return {
            step: 1,
            value: 200000, // Valor padrão inicial do slider
            term: 200,    // Prazo padrão fixo para a Landing Page
            loading: false,
            // ATUALIZADO: Adicionado campo message
            form: { goal: '', name: '', email: '', phone: '', message: '' }, 
            
            setGoal(goal) {
                this.form.goal = goal;
                this.step = 2;
            },

            formatMoney(val) {
                return new Intl.NumberFormat('pt-BR').format(val);
            },

            async submitLead() {
                this.loading = true;
                
                // Prepara o payload para a nova rota SiteController::registerLead
                const payload = {
                    name: this.form.name,
                    phone: this.form.phone,
                    email: this.form.email || 'sem_email@cliente.com',
                    objective: this.form.goal,
                    message: this.form.message, // ATUALIZADO: Envia a mensagem
                    credit: this.value,
                    term: this.term,
                    type: this.form.goal === 'auto' ? 'auto' : 'imovel'
                };

                try {
                    const response = await fetch('<?= \App\Config\Config::BASE_URL ?>/api/lead/register', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();

                    if (data.status === 'success') {
                        this.step = 4;
                    } else {
                        alert('Erro: ' + data.message);
                    }
                } catch (error) {
                    console.error('Erro na requisição:', error);
                    alert('Problema de conexão. Tente novamente em instantes.');
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>

<?php 
$content = ob_get_clean(); 
include __DIR__ . '/../../layouts/site.php'; 
?>
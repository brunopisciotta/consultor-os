<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Performance</title>
    <style>
        /* CSS OTIMIZADO PARA DOMPDF (SEM FLEXBOX) */
        body { font-family: sans-serif; color: #333; margin: 0; padding: 20px; font-size: 12px; }
        
        /* Layout Geral via Tabela */
        table { width: 100%; border-collapse: collapse; border: 0; }
        td { vertical-align: top; }

        /* Header */
        .header { margin-bottom: 30px; border-bottom: 2px solid #1A2B42; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #1A2B42; }
        .logo span { color: #D4AF37; }
        .meta-data { text-align: right; color: #666; font-size: 10px; line-height: 1.4; }
        .report-name { font-size: 16px; font-weight: bold; text-transform: uppercase; color: #1A2B42; }

        /* Cards Superiores */
        .cards-table { margin-bottom: 20px; }
        .cards-table td { padding: 5px; width: 50%; }
        .card { padding: 15px; border-radius: 6px; color: white; height: 80px; }
        .card-blue { background-color: #1A2B42; }
        .card-green { background-color: #27ae60; }
        .card label { font-size: 9px; text-transform: uppercase; opacity: 0.8; display: block; margin-bottom: 5px; }
        .card h2 { font-size: 22px; margin: 0; }
        .card p { font-size: 10px; margin: 5px 0 0; opacity: 0.9; }

        /* Título de Seção */
        .section-header { font-size: 12px; font-weight: bold; text-transform: uppercase; color: #D4AF37; border-bottom: 1px solid #eee; margin: 20px 0 10px 0; padding-bottom: 5px; }

        /* Métricas */
        .metrics-table td { padding: 5px; width: 25%; text-align: center; }
        .metric-box { background: #f8f9fa; border: 1px solid #eee; padding: 10px; border-radius: 5px; }
        .metric-val { font-size: 16px; font-weight: bold; color: #1A2B42; }
        .metric-label { font-size: 9px; text-transform: uppercase; color: #666; margin-top: 5px; display: block; }

        /* Colunas Funil e Histórico */
        .cols-table { margin-top: 10px; }
        .cols-table td { width: 48%; }
        .spacer { width: 4%; }

        /* Funil */
        .funnel-row { margin-bottom: 6px; }
        .funnel-label { font-size: 10px; font-weight: bold; margin-bottom: 2px; color: #333; }
        .funnel-track { background: #eee; height: 10px; border-radius: 5px; width: 100%; }
        .funnel-bar { height: 100%; border-radius: 5px; text-align: right; color: white; font-size: 8px; line-height: 10px; padding-right: 4px; }

        /* Tabela Histórico */
        .hist-table th { text-align: left; border-bottom: 1px solid #ccc; padding: 4px; color: #1A2B42; font-size: 10px; }
        .hist-table td { border-bottom: 1px solid #f0f0f0; padding: 6px 4px; font-size: 10px; }
        .bar-container { background: #eee; height: 6px; width: 100%; border-radius: 3px; }
        .bar-fill { background: #1A2B42; height: 100%; border-radius: 3px; }

        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 9px; color: #aaa; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <table class="header">
        <tr>
            <td width="50%">
                <div class="logo">Consultor<span>OS</span></div>
            </td>
            <td width="50%" class="meta-data">
                <div class="report-name">Relatório de Performance</div>
                Consultor: <strong><?= $user->name ?></strong><br>
                Mês Referência: <?= $month ?>/<?= $year ?><br>
                Gerado em: <?= date('d/m/Y H:i') ?>
            </td>
        </tr>
    </table>

    <table class="cards-table">
        <tr>
            <td>
                <div class="card card-blue">
                    <label>Volume Vendido (VGP)</label>
                    <h2>R$ <?= number_format($real['sales_volume'], 2, ',', '.') ?></h2>
                    <p><?= $real['sales_count'] ?> contratos fechados</p>
                </div>
            </td>
            <td>
                <div class="card card-green">
                    <label>Comissão Estimada (<?= $user->commission_rate ?>%)</label>
                    <h2>R$ <?= number_format($commission, 2, ',', '.') ?></h2>
                    <p>Cálculo sobre VGP realizado</p>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-header">Registro de Atividades</div>
    <table class="metrics-table">
        <tr>
            <td>
                <div class="metric-box">
                    <span class="metric-val"><?= $manual->calls_made ?? 0 ?></span>
                    <span class="metric-label">Ligações</span>
                </div>
            </td>
            <td>
                <div class="metric-box">
                    <span class="metric-val"><?= $manual->whatsapp_sent ?? 0 ?></span>
                    <span class="metric-label">WhatsApp</span>
                </div>
            </td>
            <td>
                <div class="metric-box">
                    <span class="metric-val"><?= $manual->video_calls ?? 0 ?></span>
                    <span class="metric-label">Vídeo</span>
                </div>
            </td>
            <td>
                <div class="metric-box">
                    <span class="metric-val"><?= $manual->visits_made ?? 0 ?></span>
                    <span class="metric-label">Visitas</span>
                </div>
            </td>
        </tr>
    </table>

    <table class="cols-table">
        <tr>
            <td>
                <div class="section-header">Funil de Vendas</div>
                <?php 
                    $totalFunnel = array_sum($real['status_breakdown']);
                    $maxFunnel = $totalFunnel > 0 ? $totalFunnel : 1;
                    $funnelOrder = [
                        'new' => ['label' => 'Novos Leads', 'color' => '#e74c3c'],
                        'analysis' => ['label' => 'Em Análise', 'color' => '#f39c12'],
                        'proposal' => ['label' => 'Proposta', 'color' => '#3498db'],
                        'negotiation' => ['label' => 'Negociação', 'color' => '#2980b9'],
                        'closed' => ['label' => 'Venda Feita', 'color' => '#27ae60']
                    ];
                ?>
                <?php foreach($funnelOrder as $key => $cfg): ?>
                    <?php 
                        $count = $real['status_breakdown'][$key] ?? 0;
                        $pct = ($count / $maxFunnel) * 100;
                        $width = $count > 0 ? max(10, $pct) : 0;
                    ?>
                    <div class="funnel-row">
                        <div class="funnel-label">
                            <?= $cfg['label'] ?>: <?= $count ?>
                        </div>
                        <div class="funnel-track">
                            <div class="funnel-bar" style="width: <?= $width ?>%; background-color: <?= $cfg['color'] ?>;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div style="margin-top: 15px; font-size: 10px; color: #777;">
                    Taxa de Conversão: <strong><?= $totalFunnel > 0 ? number_format((($real['status_breakdown']['closed']??0)/$totalFunnel)*100, 1) : 0 ?>%</strong>
                    <br>Perdidos: <?= $real['status_breakdown']['lost'] ?? 0 ?>
                </div>
            </td>

            <td class="spacer"></td>

            <td>
                <div class="section-header">Histórico (6 Meses)</div>
                <?php 
                    $maxTrend = 0;
                    foreach($trendData as $d) if($d['value'] > $maxTrend) $maxTrend = $d['value'];
                    $maxTrend = $maxTrend > 0 ? $maxTrend : 1;
                ?>
                <table class="hist-table">
                    <thead>
                        <tr>
                            <th width="30%">Mês</th>
                            <th width="40%">VGP</th>
                            <th width="30%">Tendência</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(array_reverse($trendData) as $data): ?>
                        <tr>
                            <td><strong><?= $data['label'] ?></strong></td>
                            <td>R$ <?= number_format($data['value'], 0, ',', '.') ?></td>
                            <td>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: <?= ($data['value'] / $maxTrend) * 100 ?>%"></div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer">
        Documento confidencial gerado pelo sistema Consultor OS. GMR Consórcios.
    </div>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #1A2B42; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #1A2B42; }
        .logo span { color: #D4AF37; }
        
        .title-box { background: #1A2B42; color: white; padding: 15px; border-radius: 8px; margin-bottom: 30px; }
        .title-box h1 { margin: 0; font-size: 22px; }

        .card { background: #f8f9fa; border: 1px solid #eee; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .label { font-size: 10px; text-transform: uppercase; color: #777; font-weight: bold; margin-bottom: 5px; display: block; }
        .value { font-size: 18px; font-weight: bold; color: #1A2B42; }
        
        .status-box { padding: 30px; text-align: center; border-radius: 12px; margin-top: 20px; border: 2px solid; }
        .status-ALTA { background: #e8f5e9; border-color: #27ae60; color: #27ae60; }
        .status-MEDIA { background: #fffde7; border-color: #f1c40f; color: #f39c12; }
        .status-BAIXA { background: #ffebee; border-color: #e74c3c; color: #c0392b; }
        
        .status-title { font-size: 28px; font-weight: bold; margin-bottom: 10px; }
        .status-desc { font-size: 14px; opacity: 0.8; }

        .notes-box { background: #fff; border-left: 4px solid #1A2B42; padding: 15px; margin-top: 30px; font-style: italic; font-size: 13px; line-height: 1.6; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">Consultor<span>OS</span></div>
        <div style="font-size: 12px; margin-top: 5px;">GMR Consórcios & Investimentos</div>
    </div>

    <div class="title-box">
        <h1>Análise de Viabilidade de Lance</h1>
        <p>Estudo estatístico baseado na média do grupo.</p>
    </div>

    <table width="100%">
        <tr>
            <td width="50%" style="padding-right: 10px;">
                <div class="card">
                    <span class="label">Crédito Desejado</span>
                    <div class="value">R$ <?= number_format($credit, 2, ',', '.') ?></div>
                </div>
            </td>
            <td width="50%" style="padding-left: 10px;">
                <div class="card">
                    <span class="label">Média Histórica do Grupo</span>
                    <div class="value"><?= $avg ?>%</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="card" style="background: #eef2f7; border-color: #1A2B42;">
        <span class="label" style="color: #1A2B42;">Sua Oferta de Lance</span>
        <div class="value" style="font-size: 24px;">R$ <?= number_format($bid_val, 2, ',', '.') ?> (<?= $bid_pct ?>%)</div>
    </div>

    <?php
        $statusClass = 'status-' . ($status == 'MÉDIA' ? 'MEDIA' : $status);
        $statusText = '';
        if($status == 'ALTA') $statusText = "Excelente! Seu lance supera a média do grupo com folga.";
        elseif($status == 'MÉDIA' || $status == 'MEDIA') $statusText = "Competitivo. Estamos na média, dependemos do desempate.";
        else $statusText = "Atenção. Lance abaixo da média histórica. Recomendamos aumentar a oferta.";
    ?>

    <div class="status-box <?= $statusClass ?>">
        <div class="status-title"><?= $status ?> PROBABILIDADE</div>
        <div class="status-desc"><?= $statusText ?></div>
        <div style="margin-top: 15px; font-size: 12px; font-weight: bold;">
            Diferença da Média: <?= ($diff > 0 ? '+' : '') . $diff ?>%
        </div>
    </div>

    <?php if(!empty($notes)): ?>
    <div class="notes-box">
        <strong>Nota do Especialista:</strong><br>
        <?= nl2br(htmlspecialchars($notes)) ?>
    </div>
    <?php endif; ?>

    <div class="footer">
        Relatório gerado em <?= date('d/m/Y') ?> por <strong><?= $consultant->name ?></strong><br>
        <?= $consultant->email ?> | <?= $consultant->phone ?>
    </div>

</body>
</html>
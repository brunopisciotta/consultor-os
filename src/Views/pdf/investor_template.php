<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #D4AF37; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #1A2B42; }
        .logo span { color: #D4AF37; }
        
        .title-box { background: #1A2B42; color: white; padding: 15px; border-radius: 8px; margin-bottom: 30px; }
        .title-box h1 { margin: 0; font-size: 22px; }
        .title-box p { margin: 5px 0 0; opacity: 0.8; font-size: 12px; }

        .grid { width: 100%; margin-bottom: 30px; }
        .grid td { vertical-align: top; padding: 10px; width: 50%; }

        .card { background: #f8f9fa; border: 1px solid #eee; padding: 15px; border-radius: 8px; }
        .label { font-size: 10px; text-transform: uppercase; color: #777; font-weight: bold; margin-bottom: 5px; display: block; }
        .value { font-size: 16px; font-weight: bold; color: #1A2B42; }
        
        .result-box { background: #fff; border: 2px solid #D4AF37; padding: 20px; text-align: center; border-radius: 8px; margin-top: 10px; }
        .roi-big { font-size: 36px; color: #27ae60; font-weight: bold; }
        
        .notes-box { background: #fffde7; border-left: 4px solid #D4AF37; padding: 15px; margin: 30px 0; font-style: italic; font-size: 13px; line-height: 1.6; }
        
        .cases-box { margin-top: 40px; border-top: 1px solid #eee; pt: 20px; }
        .cases-box h3 { color: #1A2B42; font-size: 16px; }
        .case-item { font-size: 12px; color: #555; margin-bottom: 10px; }
        .case-item a { color: #D4AF37; text-decoration: none; font-weight: bold; }

        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">Consultor<span>OS</span></div>
        <div style="font-size: 12px; margin-top: 5px;">GMR Consórcios & Investimentos</div>
    </div>

    <div class="title-box">
        <h1>Estudo de Viabilidade: Estratégia Investidor</h1>
        <p>Análise de alavancagem patrimonial e revenda de cartas contempladas.</p>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="card">
                    <span class="label">Crédito (Valor do Bem)</span>
                    <div class="value">R$ <?= number_format($credit, 2, ',', '.') ?></div>
                </div>
                <br>
                <div class="card">
                    <span class="label">Total Investido (Entrada + Parcelas)</span>
                    <div class="value">R$ <?= number_format($invested, 2, ',', '.') ?></div>
                </div>
            </td>
            <td>
                <div class="card">
                    <span class="label">Valor de Venda (Mercado)</span>
                    <div class="value" style="color: #27ae60;">R$ <?= number_format($sale, 2, ',', '.') ?></div>
                </div>
                <br>
                <div class="result-box">
                    <span class="label">Lucro Líquido</span>
                    <div class="value" style="font-size: 20px;">R$ <?= number_format($profit, 2, ',', '.') ?></div>
                    <br>
                    <span class="label">Retorno Sobre Investimento (ROI)</span>
                    <div class="roi-big"><?= $roi ?>%</div>
                </div>
            </td>
        </tr>
    </table>

    <?php if(!empty($notes)): ?>
    <div class="notes-box">
        <strong>Análise do Especialista:</strong><br>
        <?= nl2br(htmlspecialchars($notes)) ?>
    </div>
    <?php endif; ?>

    <div class="cases-box">
        <h3>Histórico de Sucesso GMR</h3>
        <p style="font-size: 12px; color: #777;">Confira exemplos reais de operações similares realizadas pelo nosso grupo:</p>
        
        <div class="case-item">
            <strong>CASE #01:</strong> Crédito de R$ 500k. Cliente investiu R$ 80k e revendeu por R$ 130k em 4 meses. 
            <br>Lucro: R$ 50.000 (ROI 62%).
        </div>
        
        <div class="case-item">
            <strong>CASE #02:</strong> Estratégia de Meia-Parcela para Imóvel. Contemplação no 2º mês.
            <br>Lucro na venda do ágio: R$ 35.000.
        </div>
        
        <p style="font-size: 10px; margin-top: 10px; color: #999;">* Resultados passados não garantem rentabilidade futura. O consórcio é um investimento de renda variável baseado em contemplação.</p>
    </div>

    <div class="footer">
        Gerado em <?= date('d/m/Y') ?> por <strong><?= $consultant->name ?></strong><br>
        <?= $consultant->email ?> | <?= $consultant->phone ?>
    </div>

</body>
</html>
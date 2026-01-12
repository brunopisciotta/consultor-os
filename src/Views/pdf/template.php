<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Proposta Comercial</title>
    <style>
        /* Estilos Base para Impressão */
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 0; }
        
        /* Cores GMR */
        .bg-navy { background-color: #1A2B42; color: #fff; }
        .text-navy { color: #1A2B42; }
        .text-gold { color: #D4AF37; }
        .bg-gold { background-color: #D4AF37; color: #1A2B42; }
        
        /* Layout */
        .header { padding: 40px; text-align: center; border-bottom: 4px solid #D4AF37; }
        .content { padding: 40px; }
        
        /* Tabelas */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { text-align: left; padding: 10px; border-bottom: 2px solid #eee; color: #999; font-size: 10px; text-transform: uppercase; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        
        /* Destaques */
        .big-number { font-size: 24px; font-weight: bold; }
        .box { background-color: #f8f9fa; border: 1px solid #eee; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; height: 50px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>

    <div class="header bg-navy">
        <h1 style="margin:0; font-size: 30px;">GMR <span class="text-gold">CONSÓRCIOS</span></h1>
        <p style="margin:5px 0 0 0; opacity: 0.8; font-size: 12px;">Planejamento Financeiro & Estratégia</p>
    </div>

    <div class="content">
        
        <h2 class="text-navy">Estudo Personalizado</h2>
        <p>Olá, <strong><?= $lead->name ?></strong>.</p>
        <p style="color: #666; font-size: 14px; line-height: 1.5;">
            Com base em nossa conversa, preparei este estudo de viabilidade para a aquisição do seu bem.
            Aqui demonstramos matematicamente a vantagem da estratégia de consórcio.
        </p>

        <br>

        <div class="box">
            <h3 class="text-navy" style="margin-top:0; font-size: 16px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Resumo da Estratégia</h3>
            <table style="border:none; margin-bottom: 0;">
                <tr>
                    <td width="50%" style="border:none;">
                        <span style="display:block; font-size:10px; color:#999;">CRÉDITO DESEJADO</span>
                        <span class="text-navy big-number">R$ <?= number_format($sim->credit_value, 2, ',', '.') ?></span>
                    </td>
                    <td width="50%" style="border:none;">
                        <span style="display:block; font-size:10px; color:#999;">PRAZO TOTAL</span>
                        <span class="text-navy big-number"><?= $sim->term_months ?> meses</span>
                    </td>
                </tr>
            </table>

            <table style="margin-top: 15px; border-top: 1px dotted #ccc;">
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #eee; font-size: 12px; color: #666;">Taxa Administrativa Total</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right; font-weight: bold; font-size: 12px;">
                        <?= number_format($sim->consortium_rate, 2, ',', '.') ?>% (Total do Período)
                    </td>
                </tr>
                
                <tr>
                    <td style="padding: 8px 0; border-bottom: none; font-size: 12px; color: #666;">Seguro de Vida (0,038% a.m)</td>
                    <td style="padding: 8px 0; border-bottom: none; text-align: right; font-weight: bold; font-size: 12px;">
                        <?= ($sim->has_insurance == 1) ? '<span style="color: #2c7a7b;">Incluso</span>' : 'Não contratado' ?>
                    </td>
                </tr>
            </table>
        </div>

        <table style="margin-top: 30px;">
            <thead>
                <tr>
                    <th style="font-size: 14px; color: #1A2B42; border-bottom: 2px solid #1A2B42; width: 50%;">Cenário GMR (Consórcio)</th>
                    <th style="font-size: 14px; color: #999; width: 50%;">Financiamento Bancário</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="background-color: #f0f4f8; vertical-align: top;">
                         <span style="font-size: 11px; color: #666;">Entrada / Aporte Inicial</span><br>
                         <strong class="text-navy" style="font-size: 16px;">Não exigida</strong><br>
                         <span style="font-size: 10px; color: #2c7a7b;">(100% do crédito parcelado)</span>
                    </td>
                    <td style="vertical-align: top;">
                        <?php 
                            // Entrada de 30%
                            $entradaBanco = $sim->credit_value * 0.30; 
                        ?>
                        <span style="font-size: 11px; color: #cc0000; font-weight: bold;">Entrada Necessária (30%)</span><br>
                        <strong style="color: #cc0000; font-size: 16px;">
                            R$ <?= number_format($entradaBanco, 2, ',', '.') ?>
                        </strong><br>
                        <span style="font-size: 10px; font-weight: normal; color: #666;">(Descapitalização Imediata)</span>
                    </td>
                </tr>

                <tr>
                    <td style="background-color: #f0f4f8;">
                        <span style="font-size: 11px; color: #666;">Parcela Mensal Média</span><br>
                        <strong class="text-navy" style="font-size: 18px;">R$ <?= number_format($sim->consortium_parcel, 2, ',', '.') ?></strong>
                    </td>
                    <td>
                        <?php 
                            // Define o prazo do banco (Se não tiver salvo, usa o mesmo do consórcio)
                            $prazoBanco = (isset($sim->financing_term_months) && $sim->financing_term_months > 0) 
                                          ? $sim->financing_term_months 
                                          : $sim->term_months;

                            // Cálculo PRICE com o prazo correto do banco
                            $taxa = 10.5 / 100; 
                            $mensal = pow(1 + $taxa, 1/12) - 1;
                            $pmt = $sim->credit_value * ($mensal * pow(1+$mensal, $prazoBanco)) / (pow(1+$mensal, $prazoBanco) - 1);
                        ?>

                        <span style="font-size: 11px; color: #999;">Parcela Estimada</span> 
                        <small style="color: #999; font-size: 10px;">(<?= $prazoBanco ?> meses)</small><br>
                        
                        <strong style="color: #999; font-size: 18px;">
                            <?= 'R$ ' . number_format($pmt, 2, ',', '.') ?>
                        </strong>
                    </td>
                </tr>

                <tr>
                    <td style="background-color: #f0f4f8;">
                        <span style="font-size: 11px; color: #666;">Custo Final Planejado</span><br>
                        <strong class="text-gold" style="font-size: 18px;">
                            <?php 
                                $totalConsorcio = $sim->consortium_total ?? ($sim->consortium_parcel * $sim->term_months);
                                echo 'R$ ' . number_format($totalConsorcio, 2, ',', '.');
                            ?>
                        </strong>
                    </td>
                    <td>
                        <span style="font-size: 11px; color: #999;">Custo Total Bancário</span><br>
                        <strong style="color: #cc0000; font-size: 18px;">
                             <?php 
                                // Total = Parcela x Prazo do Banco
                                $totalFinanc = $pmt * $prazoBanco;
                                echo 'R$ ' . number_format($totalFinanc, 2, ',', '.');
                            ?>
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <div style="background-color: #e6fffa; border: 1px solid #b2f5ea; padding: 20px; border-radius: 5px; text-align: center; margin-top: 20px;">
            <span style="color: #2c7a7b; font-weight: bold; font-size: 12px; text-transform: uppercase;">Economia Líquida Gerada</span><br>
            <span style="color: #234e52; font-size: 28px; font-weight: bold;">
                R$ <?= number_format($totalFinanc - $totalConsorcio, 2, ',', '.') ?>
            </span>
            <p style="margin: 5px 0 0 0; font-size: 12px; color: #2c7a7b;">Este valor representa o capital preservado através desta estratégia.</p>
        </div>
        
        <?php if($sim->bid_suggestion > 0): ?>
        <div style="border-left: 4px solid #D4AF37; padding-left: 15px; margin-top: 30px;">
            <h4 class="text-navy" style="margin: 0;">Estratégia de Aceleração (Lance)</h4>
            <p style="font-size: 14px; margin: 5px 0; color: #444;">
                Para antecipar a posse do seu bem, trabalharemos com uma sugestão de lance de <strong>R$ <?= number_format($sim->bid_suggestion, 2, ',', '.') ?></strong>. 
                Esta modalidade permite quitar parcelas futuras e reduzir o custo total.
            </p>
        </div>
        <?php endif; ?>

    </div>

    <div class="footer">
        Gerado pelo sistema <strong>Consultor OS</strong> em <?= date('d/m/Y') ?>.
        <br>Este documento é uma simulação estratégica. Os valores podem sofrer variações conforme reajustes anuais do crédito.
    </div>

</body>
</html>
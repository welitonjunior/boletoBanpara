<?php
// +----------------------------------------------------------------------+
// | BoletoBanpara                                                        |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Originado do Projeto BoletoPhp                                       |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Weliton Vieira Júnior <welitonjunior@inbox.com | @tonjunior>         |
// +----------------------------------------------------------------------+
?>

<!DOCTYPE HTML PUBLIC '-//W3C//Dtd HTML 4.0 Transitional//EN'>
<HTML>
    <HEAD>
        <title><?php echo $dadosboleto["identificacao"]; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Language" content="pt-br"/>
        <link href="css/styles.css" rel="stylesheet"/>

        <style type=text/css>
            <!--
            .cp {  font: bold 10px Arial; color: black}
            .ti {  font: 9px Arial, Helvetica, sans-serif}
            .ld { font: bold 15px Arial; color: #000000}
            .ct { FONT: 9px "Arial Narrow"; COLOR: #000033}
            .cn { FONT: 9px Arial; COLOR: black }
            .bc { font: bold 20px Arial; color: #000000 }
            .ld2 { font: bold 12px Arial; color: #000000 }

            .linha-digitavel { font: bold 14px Arial; text-align: right; width: 406px; }
        </style>

    </head>

    <body text=#000000 bgColor=#ffffff topMargin=0 rightMargin=0>
        <div class="noprint info" style="width: 666px">
            <h2>Instruções de Impressão</h2>
            <ul>
                <li>
                    Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).
                </li>
                <li>
                    Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à direita do formulário.
                </li>
                <li>
                    Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.
                </li>
                <li>
                    Caso não apareça o código de barras no final, pressione F5 para atualizar esta tela.
                </li>
                <li>
                    Caso tenha problemas ao imprimir, copie a sequencia numérica abaixo e pague no caixa eletrônico ou no internet banking:
                </li>
            </ul>
            <span class="header">Linha Digitável: <?php echo $dadosboleto["linha_digitavel"] ?></span>
            <span class="header">Valor: R$ <?php echo $dadosboleto["valor_boleto"] ?></span><br>
            <div class="linha-pontilhada" style="margin-bottom: 20px;">Recibo do sacado</div>
        </div>
        <div class="info-empresa">
            <div style="display: inline-block;">
                <img src="imagens/logo_empresa.png" />
            </div>
            <div style="display: inline-block; vertical-align: super; margin-left: 10px;">
                <div style="font: 14px Arial;"><strong><?php echo $dadosboleto["identificacao"]; ?></strong></div>
                <div><?php echo $dadosboleto["endereco"]; ?></div>
                <div><?php echo $dadosboleto["cidade_uf"]; ?></div>
            </div>
        </div><br />

        <table class="table-boleto" cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <td valign="bottom" colspan="8" class="noborder nopadding">
                        <div class="logocontainer">
                            <div class="logobanco">
                                <img src="imagens/logobanpara.jpg" width="150" height="40" border=0>
                            </div>
                            <div class="codbanco"><?php echo $dadosboleto["codigo_banco_com_dv"] ?></div>
                        </div>
                        <div class="linha-digitavel"><?php echo $dadosboleto["linha_digitavel"] ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" width="250">
                        <div class="titulo">Cedente</div>
                        <div class="conteudo"><?php echo $dadosboleto["cedente"]; ?></div>
                    </td>
                    <td>
                        <div class="titulo">CPF/CNPJ</div>
                        <div class="conteudo"><?php echo $dadosboleto["cpf_cnpj"] ?></div>
                    </td>
                    <td width="120">
                        <div class="titulo">Agência/Código do Cedente</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["agencia_codigo"] ?></div>
                    </td>
                    <td width="110">
                        <div class="titulo">Vencimento</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["data_vencimento"] ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="titulo">Sacado</div>
                        <div class="conteudo"><?php echo $dadosboleto["sacado"] ?></div>
                    </td>
                    <td>
                        <div class="titulo">Nº documento</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["numero_documento"] ?></div>
                    </td>
                    <td>
                        <div class="titulo">Nosso número</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["nosso_numero"] ?></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="titulo">Espécie</div>
                        <div class="conteudo"><span class="campo"><?php echo $dadosboleto["especie"] ?></div>
                    </td>
                    <td>
                        <div class="titulo">Quantidade</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["quantidade"] ?></div>
                    </td>
                    <td>
                        <div class="titulo">Valor</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["valor_unitario"] ?></div>
                    </td>
                    <td>
                        <div class="titulo">(-) Descontos / Abatimentos</div>
                        <div class="conteudo rtl"><!-- < ?php echo $desconto_abatimento ?> --></div>
                    </td>
                    <td>
                        <div class="titulo">(=) Valor Documento</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["valor_boleto"] ?> <!-- valor_documento --></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="conteudo"></div>
                        <div class="titulo">Demonstrativo</div>
                    </td>
                    <td>
                        <div class="titulo">(-) Outras deduções</div>
                        <div class="conteudo"><!-- < ?php echo $outras_deducoes ?>--></div>
                    </td>
                    <td>
                        <div class="titulo">(+) Outros acréscimos</div>
                        <div class="conteudo rtl"><!-- < ?php echo $outros_acrescimos ?>--></div>
                    </td>
                    <td>
                        <div class="titulo">(=) Valor cobrado</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["valor_boleto"] ?> <!-- $valor_cobrado ?>--></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><div style="margin-top: 10px" class="conteudo"><?php echo $dadosboleto["demonstrativo1"] ?></div></td>
                    <td class="noleftborder"><div class="titulo">Autenticação mecânica</div></td>
                </tr>
                <tr>
                    <td colspan="5" class="notopborder"><div class="conteudo"><?php echo $dadosboleto["demonstrativo2"] ?></div></td>
                </tr>
                <tr>
                    <td colspan="5" class="notopborder"><div class="conteudo"><?php echo $dadosboleto["demonstrativo3"] ?></div></td>
                </tr>
                <tr>
                    <td colspan="5" class="notopborder bottomborder"><div style="margin-bottom: 10px;" class="conteudo"><?php echo $dadosboleto["demonstrativo4"]; ?></div></td>
                </tr>
                <tr>
                    <td colspan="5" class="noborder"></td>
                </tr>
            </tbody>
        </table>
        
        <br>
        <div style="width: 666px" class="linha-pontilhada">Corte na linha pontilhada</div>
        <br>

        <table class="table-boleto" cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <td valign="bottom" colspan="8" class="noborder nopadding">
                        <div class="logocontainer">
                            <div class="logobanco">
                                <img src="imagens/logobanpara.jpg" width="150" height="40" border=0>
                            </div>
                            <div class="codbanco"><?php echo $dadosboleto["codigo_banco_com_dv"] ?></div>
                        </div>
                        <div class="linha-digitavel"><?php echo $dadosboleto["linha_digitavel"] ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div class="titulo">Local de pagamento</div>
                        <div class="conteudo">Pagável em qualquer Banco até o vencimento</div>
                    </td>
                    <td width="180">
                        <div class="titulo">Vencimento</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["data_vencimento"]; ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div class="titulo">Cedente</div>
                        <div class="conteudo"><?php echo $dadosboleto["cedente"]; ?></div>
                    </td>
                    <td>
                        <div class="titulo">Agência/Código cedente</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["agencia_codigo"]; ?></div>
                    </td>
                </tr>
                <tr>
                    <td width="110" colspan="2">
                        <div class="titulo">Data do documento</div>
                        <div class="conteudo"><?php echo $dadosboleto["data_documento"]; ?></div>
                    </td>
                    <td width="120" colspan="2">
                        <div class="titulo">Nº documento</div>
                        <div class="conteudo"><?php echo $dadosboleto["numero_documento"]; ?></div>
                    </td>
                    <td width="60">
                        <div class="titulo">Espécie doc.</div>
                        <div class="conteudo"><?php echo $dadosboleto["especie_doc"]; ?></div>
                    </td>
                    <td>
                        <div class="titulo">Aceite</div>
                        <div class="conteudo"><?php echo $dadosboleto["aceite"]; ?></div>
                    </td>
                    <td width="110">
                        <div class="titulo">Data processamento</div>
                        <div class="conteudo"><?php echo $dadosboleto["data_processamento"] ?></div>
                    </td>
                    <td>
                        <div class="titulo">Nosso número</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["nosso_numero"] ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="titulo">Uso do banco</div>
                        <div class="conteudo"></div>
                    </td>
                    <td>
                        <div class="titulo">Carteira</div>
                        <div class="conteudo"><?php echo $dadosboleto["carteira"]; ?></div>
                    </td>
                    <td width="35">
                        <div class="titulo">Espécie</div>
                        <div class="conteudo"><?php echo $dadosboleto["especie"]; ?></div>
                    </td>
                    <td colspan="2">
                        <div class="titulo">Quantidade</div>
                        <div class="conteudo"><?php echo $dadosboleto["quantidade"]; ?></div>
                    </td>
                    <td width="110">
                        <div class="titulo">Valor</div>
                        <div class="conteudo"></div>
                    </td>
                    <td>
                        <div class="titulo">(=) Valor do Documento</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["valor_boleto"]; /* $valor_documento */ ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div class="titulo">Instruções</div>
                    </td>
                    <td>
                        <div class="titulo">(-) Descontos / Abatimentos</div>
                        <div class="conteudo rtl"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="notopborder">
                        <div class="conteudo"><?php echo $dadosboleto["instrucoes1"]; ?></div>
                        <div class="conteudo"><?php echo $dadosboleto["instrucoes2"]; ?></div>
                    </td>
                    <td>
                        <div class="titulo">(-) Outras deduções</div>
                        <div class="conteudo rtl"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="notopborder">
                        <div class="conteudo"><?php echo $dadosboleto["instrucoes3"]; ?></div>
                        <div class="conteudo"><?php echo $dadosboleto["instrucoes4"]; ?></div>
                    </td>
                    <td>
                        <div class="titulo">(+) Mora / Multa</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["mora_juros"] ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="notopborder">
                        <div class="conteudo"><?php echo $dadosboleto["instrucoes5"]; ?></div>
                        <div class="conteudo"><?php echo $dadosboleto["instrucoes6"]; ?></div>
                    </td>
                    <td>
                        <div class="titulo">(+) Outros acréscimos</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["acrescimos"] ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="notopborder">
                        <div class="conteudo"><?php echo $dadosboleto["instrucoes7"]; ?></div>
                        <div class="conteudo"><?php echo $dadosboleto["instrucoes8"]; ?></div>
                    </td>
                    <td>
                        <div class="titulo">(=) Valor cobrado</div>
                        <div class="conteudo rtl"><?php echo $dadosboleto["valor_boleto"]; /* valor_cobrado */ ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div class="titulo">Sacado: <span class="conteudo" style="color: #000"><?php echo $dadosboleto["sacado"]; ?></span></div>
                    </td>
                    <td class="noleftborder">
                        <div class="titulo" style="margin: 5px 0">Cód. Baixa</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="noleftborder">
                        <div class="titulo">Sacador/Avalista <div class="conteudo sacador"><?php echo $dadosboleto["avalista"]; ?></div></div>
                    </td>
                    <td colspan="2" class="norightborder noleftborder">
                        <div class="conteudo noborder rtl">Autenticação mecânica - Ficha de Compensação</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="8" class="noborder">
                        <?php echo fbarcode($dadosboleto["codigo_barras"]); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="width: 666px" class="linha-pontilhada">Corte na linha pontilhada</div>
    </body>
</HTML>

<?php
// +-------------------------------------------------------------------------+
// | BoletoBanpara                                                           |
// +-------------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web      |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License              |
// | Você deve ter recebido uma cópia da GNU Public License junto com        |
// | esse pacote; se não, escreva para:                                      |
// |                                                                         |
// | Free Software Foundation, Inc.                                          |
// | 59 Temple Place - Suite 330                                             |
// | Boston, MA 02111-1307, USA.                                             |
// +-------------------------------------------------------------------------+
// +-------------------------------------------------------------------------+
// | Projeto baseado no BoletoPhp <https://github.com/BielSystems/boletophp> |
// +-------------------------------------------------------------------------+
// +-------------------------------------------------------------------------+
// | Weliton Vieira Júnior <welitonjunior@inbox.com | @tonjunior>            |
// +-------------------------------------------------------------------------+

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 8;
$taxa_boleto = 1.50;
$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias  OU  informe data: "13/04/2006"  OU  informe "" se Contra Apresentacao;
$valor_cobrado = "9,99"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".", $valor_cobrado);
$valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

$dadosboleto["data_vencimento"] = $data_venc;       // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y");     // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto;       // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
$dadosboleto["mora_juros"] = "";
$dadosboleto["acrescimos"] = "";
$dadosboleto["avalista"] = "";

$dadosboleto["nosso_numero"] = "14" . rand(10000, 99999);  // Nosso numero sem o DV - REGRA: 7 caracteres!
$dadosboleto["numero_documento"] = "2014" . rand(1000000, 9999999);  // Número do documento - REGRA: 11 caracteres!
$dadosboleto["sacado"] = "Nome do seu Cliente";

/**/

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "<strong>Avisos / Mensagens</strong>";
$dadosboleto["demonstrativo2"] = " - Efetua o pagamento deste boleto em qualquer banco até o vencimento";
$dadosboleto["demonstrativo3"] = " - Se preferir pagar em caixa eletrônico, deverá ser utilizada a opção \"Pagamento de Título\"";
$dadosboleto["demonstrativo4"] = " - Taxa bancária: R$ " . number_format($taxa_boleto, 2, ',', '');

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = " - Sr. Caixa, não receber em hipótese nenhuma este boletos após o vencimento.";
$dadosboleto["instrucoes2"] = " - Sr. Caixa, só receber o pagamento deste boleto no valor integral.";
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "Em caso de dúvidas entre em contato pelos canais:";
$dadosboleto["instrucoes5"] = "  - Telefone: (11) 2222-3333 / 4444-5555";
$dadosboleto["instrucoes6"] = "  - E-mail: e-mail@e-mail.com";
$dadosboleto["instrucoes7"] = "";
$dadosboleto["instrucoes8"] = "Emitido pelo xXxXxXxXxXxXx";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";
$dadosboleto["especie"] = "REAL";
$dadosboleto["especie_doc"] = "";

// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

// DADOS DA CONTA - BANPARA
$dadosboleto["agencia"] = "0011";  // Num da agencia, sem digito   || CCCC -> 4 Posiçoes
$dadosboleto["conta"] = "181675";  // Num da conta, sem digito
$dadosboleto["conta_dv"] = "6";    // Digito do Num da conta
$dadosboleto["carteira"] = "9999"; // Código da Carteira (Confirmar com gerente qual usar)

// CABEÇALHO - SEUS DADOS
$dadosboleto["identificacao"] = "BoletoPhp - Código Aberto de Sistema de Boletos ";
$dadosboleto["cpf_cnpj"] = "Coloque aqui o CPF ou CNPJ";
$dadosboleto["endereco"] = "Coloque o endereço da sua empresa aqui";
$dadosboleto["cidade_uf"] = "Cidade / Estado";

$dadosboleto["cedente"] = "Coloque a Razão Social da sua empresa aqui";

// NÃO ALTERAR!
include("include/funcoes_banpara.php");
include("include/layout_banpara.php");
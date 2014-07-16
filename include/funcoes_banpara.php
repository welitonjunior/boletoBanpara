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

$codigobanco = "037";
$codigo_banco_com_dv = geraCodigoBanco($codigobanco);
$nummoeda = "9";
$fator_vencimento = fator_vencimento($dadosboleto["data_vencimento"]);
$valor = formata_numero($dadosboleto["valor_boleto"], 10, 0, "valor"); //valor = 10 digitos, sem virgula

$agencia = formata_numero($dadosboleto["agencia"], 4, 0); //agencia = digitos
$conta = $dadosboleto["conta"]; //conta = digitos
$conta_dv = formata_numero($dadosboleto["conta_dv"], 1, 0); //dv da conta
$carteira = $dadosboleto["carteira"]; //carteira = 4 caracteres
$nossonumero = formata_numero($dadosboleto["nosso_numero"], 8, 0); //nosso número (sem dv) = 8 digitos
$agencia_codigo = $agencia . " / " . $conta . "-" . $conta_dv; // Agência e Conta

/* Calculados */
$linhaDig = MontalinhaDigitavel($codigobanco, $nummoeda, $agencia, $carteira, $nossonumero, $conta, $conta_dv, $fator_vencimento, $valor);
$CodBarras = MontaCodigoBarras($codigobanco, $nummoeda, $fator_vencimento, $valor, $agencia, $carteira, $nossonumero, $conta, $conta_dv, $linhaDig[1]);
/* /Calculados */

$dadosboleto["codigo_barras"] = $CodBarras;
$dadosboleto["linha_digitavel"] = $linhaDig[0];
$dadosboleto["agencia_codigo"] = $agencia_codigo;
$dadosboleto["nosso_numero"] = $nossonumero;
$dadosboleto["codigo_banco_com_dv"] = $codigo_banco_com_dv;

/* Funções */

// <editor-fold defaultstate="collapsed" desc="Funções">

function formata_numero($numero, $loop, $insert, $tipo = "geral") {
    if ($tipo == "geral") {
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == "valor") {
        /*
          retira as virgulas
          formata o numero
          preenche com zeros
         */
        $numero = str_replace(",", "", $numero);
        while (strlen($numero) < $loop) {
            $numero = $insert . $numero;
        }
    }
    if ($tipo == "convenio") {
        while (strlen($numero) < $loop) {
            $numero = $numero . $insert;
        }
    }
    return $numero;
}

function esquerda($string, $num) {
    return substr($string, 0, $num);
}

function direita($string, $num) {
    return substr($string, strlen($string) - $num, $num);
}

function fator_vencimento($data) {
    if ($data != "") {
        $data = explode("/", $data);
        $ano = $data[2];
        $mes = $data[1];
        $dia = $data[0];
        return(abs((_dateToDays("1997", "10", "07")) - (_dateToDays($ano, $mes, $dia))));
    } else {
        return "0000";
    }
}

function _dateToDays($year, $month, $day) {
    $century = substr($year, 0, 2);
    $year = substr($year, 2, 2);
    if ($month > 2) {
        $month -= 3;
    } else {
        $month += 9;
        if ($year) {
            $year--;
        } else {
            $year = 99;
            $century--;
        }
    }
    return ( floor(( 146097 * $century) / 4) +
            floor(( 1461 * $year) / 4) +
            floor(( 153 * $month + 2) / 5) +
            $day + 1721119);
}

function modulo_10($num) {
    $numtotal10 = 0;
    $fator = 2;

    // Separacao dos numeros
    for ($i = strlen($num); $i > 0; $i--) {
        // pega cada numero isoladamente
        $numeros[$i] = substr($num, $i - 1, 1);
        // Efetua multiplicacao do numero pelo (falor 10)
        $temp = $numeros[$i] * $fator;
        $temp0 = 0;
        foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
            $temp0+=$v;
        }
        $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
        // monta sequencia para soma dos digitos no (modulo 10)
        $numtotal10 += $parcial10[$i];
        if ($fator == 2) {
            $fator = 1;
        } else {
            $fator = 2; // intercala fator de multiplicacao (modulo 10)
        }
    }

    // várias linhas removidas, vide função original
    // Calculo do modulo 10
    $resto = $numtotal10 % 10;
    $digito = 10 - $resto;
    if ($resto == 0) {
        $digito = 0;
    }

    return $digito;
}

function modulo11($num, $base = 9) {
    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--) {
        $numeros[$i] = substr($num, $i - 1, 1); // pega cada numero isoladamente
        $parcial[$i] = $numeros[$i] * $fator; // Efetua multiplicacao do numero pelo falor
        $soma += $parcial[$i]; // Soma dos digitos

        if ($fator == $base) {
            $fator = 1; // restaura fator de multiplicacao para 2
        }

        $fator++;
    }

    $resto = 11 - (($soma * 10) % 11);

    if (($resto > 9) || ($resto == 0))
        return 1;

    return $resto;
}

function geraCodigoBanco($numero) {
    $parte1 = substr($numero, 0, 3);
    $parte2 = modulo11($parte1);
    return $parte1 . "-" . $parte2;
}

function fbarcode($valor) {
    $codigo = $valor;
    $barcodes = array('00110', '10001', '01001', '11000', '00101', '10100', '01100', '00011', '10010', '01010');
    $barraStart = '<div class="barcode"><div class="black thin"></div><div class="white thin"></div><div class="black thin"></div><div class="white thin"></div>';
    $barraStop = '<div class="black large"></div><div class="white thin"></div><div class="black thin"></div></div>';
    $retorno = "";

    for ($a = 9; $a >= 0; $a--) {
        for ($b = 9; $b >= 0; $b--) {
            $ind = ($a * 10) + $b;
            $texto = "";

            for ($c = 1; $c < 6; $c++) {
                $texto .= substr($barcodes[$a], ($c - 1), 1) . substr($barcodes[$b], ($c - 1), 1);
            }
            $barcodes[$ind] = $texto;
        }
    }

    while (strlen($codigo) > 0) {
        $codEsq = (int) round(esquerda($codigo, 2));
        $codigo = direita($codigo, strlen($codigo) - 2);
        $binario = $barcodes[$codEsq];

        for ($i = 1; $i < 11; $i += 2) {
            $retorno .= "<div class='black " . (substr($binario, ($i - 1), 1) == "0" ? "thin" : "large") . "'></div>";
            $retorno .= "<div class='white " . (substr($binario, $i, 1) == "0" ? "thin" : "large") . "'></div>";
        }
    }

    return $barraStart . $retorno . $barraStop;
}

function MontalinhaDigitavel($codigoBanco, $codigoMoeda, $codigoAgencia, $codigoCarteira, $nossoNumero, $contaCorrente, $digitoVerificador, $fatorVencimento, $valorTitulo) {
    /*
     * Campo 1 (AAABC.CCDDX)
     *    $p1 = AAA = Código do Banco na Câmara de Compensação (BANPARÁ = 037)
     *    $p2 = B = Código da moeda = "9" (*)
     *    $p3 = C = Primeiro dígito do número da agência do cedente
     *    $p4 = CCC = Três últimos números da agência do cedente
     *    $p5 = D = Primeiro dígito do Código da Carteira
     *    $p6 = X = DAC que amarra o campo 1
     */
    $p1 = formata_numero($codigoBanco, 3, 0);
    $p2 = $codigoMoeda;
    $p3 = substr($codigoAgencia, 0, 1);
    $p4 = substr($codigoAgencia, 1);
    $p5 = substr($codigoCarteira, 0, 1);
    $p6 = modulo_10($p1 . $p2 . $p3 . $p4 . $p5);

    $campo1 = $p1 . $p2 . $p3 . '.' . $p4 . $p5 . $p6;

    /*
     * Campo 2 (DDDEE.EEEEEY)
     *    $p7 = DDD = Restante dos dígitos do Código da Carteira
     *    $p8, $p9 = EE EEEEE = Nosso Número
     *    $p10 = Y = DAC que amarra o campo 2
     */
    $p7 = substr($codigoCarteira, 1);
    $p8 = substr($nossoNumero, 0, 2);
    $p9 = substr($nossoNumero, 2, 5);
    $p10 = modulo_10($p7 . $p8 . $p9);

    $campo2 = $p7 . $p8 . '.' . $p9 . $p10;

    /*
     * Campo 3 (EFGGGG.GGGGZ)
     *    $p11 = E = Restante do Nosso Número
     *    $p12 = F = DAC [Agência /Conta (sem digito verificador) /Carteira/Nosso Número]
     *    $p13, $p14 = GGGG GGGG = Número da conta corrente com Dígito Verificador
     *    $p15 = Z = DAC que amarra o campo 3
     */
    $conta_dv = formata_numero($contaCorrente . $digitoVerificador, 8, 0);
    $p11 = substr($nossoNumero, 7);
    $p12 = modulo11($codigoAgencia . $contaCorrente . $codigoCarteira . $nossoNumero);
    $p13 = substr($conta_dv, 0, 3);
    $p14 = substr($conta_dv, 3);
    $p15 = modulo_10($p11 . $p12 . $p13 . $p14);

    $campo3 = $p11 . $p12 . $p13 . '.' . $p14 . $p15;

    /*
     * Campo 5 (UUUUVVVVVVVVVV)
     *    $p16 = UUUU = Fator de vencimento
     *    $p17 = VVVVVVVVVV = Valor do Título (*)
     */
    $p16 = $fatorVencimento;
    $p17 = $valorTitulo;

    $campo5 = $p16 . $p17;

    /*
     * Campo 4 (K)
     *    $p18 = K = DAC do Código de Barras (Mód. 11)
     */
    $todos = $campo1 . $campo2 . $campo3 . $campo5;
    $p18 = str_replace('.', '', $todos);
    $p18 = substr($p18, 0, 4) . substr($p18, 32, 15) . substr($p18, 4, 5) . substr($p18, 10, 10) . substr($p18, 21, 10);

    $campo4 = calcModulo11($p18);
    //printvardie($linha);
    return array("$campo1 $campo2 $campo3 $campo4 $campo5", $campo4);
}

function MontaCodigoBarras($banco, $moeda, $vencimento, $valorTitulo, $agencia, $carteira, $nossoNumero, $contaC, $contaDv, $DvLinha) {
    /**
     * Composição do Código de Barras:
     *
     *     AAABCDDDDDDDDDDDDDDEEEEEEEEEEEEEEEEEEEEEEEEE - 44 Posições
     *
     * A - Código do banco (3 Posições)
     * B - Código da moeda (1 Posição)
     * C - Digito Verificador do CB - Módulo 11 (1 Posição)
     * D - É dividido em duas partes (14 Posições):
     *        - Os 4 primeiros dígitos se refere ao fator de vencimento;
     *        - Nos 10 dígitos seguintes, deve ser informado o valor nominal do título.
     * E - Campo livre, preenchido da seguinte forma (25 Posições):
     *        - Os 4 primeiros digitos se refere ao Código da Agência (sem digito verificador);
     *        - Nos 4 dígitos seguintes, deve ser informado o Código da Carteira;
     *        - Nos 8 dígitos seguintes, deve ser informado o Nosso Número;
     *        - No dígito seguinte, DAC módulo 11 de [Agência /Conta (sem digito verificador) /Carteira/Nosso Número], igual ao da linha digitável;
     *        - Nos 8 dígitos seguintes, deve ser informado a conta do cedente.
     */
    $dac = modulo11($agencia . $contaC . $carteira . $nossoNumero);
    $conta = formata_numero($contaC . $contaDv, 8, 0);

    $linha = $banco . $moeda . $DvLinha . $vencimento .
            $valorTitulo . $agencia . $carteira .
            $nossoNumero . $dac . $conta;
    //printvardie($linha);
    return $linha;
}

function calcModulo11($valor) {
    $soma = 0;
    $mult = 2;

    $temp = "";

    for ($i = strlen($valor); $i > 0; $i--) {
        $soma += (substr($valor, $i - 1, 1) * $mult);

        $temp .= 'Valor: ' . substr($valor, $i - 1, 1) . ' * ' . $mult . ' = ' . (substr($valor, $i - 1, 1) * $mult) . ' - Soma: ' . $soma . '<br>';

        if ($mult < 9)
            $mult++;
        else
            $mult = 2;
    }

    $dv = 11 - ($soma % 11);

    if (($dv > 9) || ($dv == 0))
        $dv = 1;

    return $dv;
}

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Função para DEBUG">

function printvardie($args) {
    $args = func_get_args();
    $dbt = debug_backtrace();
    $linha = $dbt[0]['line'];
    $arquivo = $dbt[0]['file'];
    echo "<fieldset style='border:1px solid; border-color:#F00;background-color:#FFF000;legend'><b>Arquivo:</b>$arquivo<b><br>Linha:</b><legend><b>Debug On : printvar()</b></legend> $linha</fieldset>";

    foreach ($args as $key => $arg) {
        echo "<fieldset style='background-color:#CBA; border:1px solid; border-color:#00F;'><legend><b>ARG[$key]</b><legend>";
        echo "<pre style='background-color:#CBA; width:100%; heigth:100%;'>";
        print_r($arg);
        echo "</pre>";
        echo "</fieldset><br />";
    }

    exit();
}

// </editor-fold>

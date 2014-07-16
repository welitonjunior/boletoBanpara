<?php
// +----------------------------------------------------------------------+
// | Validador de Código de Barras                                        |
// +----------------------------------------------------------------------+
// | Extraído do site:                                                    |
// |        http://boletobancario-codigodebarras.blogspot.com.br/         |
// +----------------------------------------------------------------------+
?>

<html>
    <head>
        <meta charset='UTF-8'>

        <script LANGUAGE="javascript">
            function f_barra() {
                var antes = form.barra.value;
                var depois = calcula_barra(form.linha.value);
                form.barra.value = depois;
                antes = antes.replace(/[^0-9]/g, '')
                if ((antes != depois) && antes != '')
                    alert('Código de Barras digitado não conferem:\n' + antes + '\n' + depois);
                f_venc();
                return(false);
            }

            function f_linha() {
                var antes = form.linha.value.replace(/[^0-9]/g, '');
                var depois = calcula_linha(form.barra.value);
                form.linha.value = depois;
                depois = depois.replace(/[^0-9]/g, '')
                if ((antes != depois) && antes != '')
                    alert('Código de Barras digitado não conferem:\n' + antes + '\n' + depois);
                f_venc();
                return(false);
            }

            function f_venc() {
                if (form.barra.value.substr(5, 4) == 0)
                    form.venc.value = 'Boleto pode ser pago em qualquer data';
                else
                    form.venc.value = fator_vencimento(form.barra.value.substr(5, 4));
                form.valor.value = (form.barra.value.substr(9, 8) * 1) + ',' + form.barra.value.substr(17, 2);
                return(false);
            }

            function recalcula_barra(linha)
            {
                if (document.form.barra.value.length == 0)
                {
                    f_barra();
                    linha = document.form.barra.value;
                }
                //
                var currentDate, t, d, mes;
                t = new Date();
                currentDate = new Date();
                currentDate.setFullYear(1997, 9, 7);
                d = (t.getTime() - currentDate.getTime()) / 1000 / 60 / 60 / 24;
                //
                linha = linha.replace(/[^0-9]/g, '');
                linha = linha.substr(0, 4) + modulo11_banco(linha.substr(0, 4) + d + linha.substr(9, 35)) + d + linha.substr(9, 35);
                document.getElementById('barras').innerHTML = 'O <b>código da barra</b> para vencimento hoje: <input size=50 value="' + linha + '">';
            }

            function calcula_barra(linha)
            {
                barra = linha.replace(/[^0-9]/g, '');

                // CÁLCULO DO DÍGITO DE AUTOCONFERÊNCIA (DAC)   -   5ª POSIÇÃO
                if (modulo11_banco('34191000000000000001753980229122525005423000') != 1)
                    alert('Função "modulo11_banco" está com erro!');
                //
                //if (barra.length == 36) barra = barra + '00000000000';
                if (barra.length < 47)
                    barra = barra + '00000000000'.substr(0, 47 - barra.length);
                if (barra.length != 47)
                    alert('A linha do Código de Barras está incompleta!' + barra.length);
                //
                barra = barra.substr(0, 4)
                        + barra.substr(32, 15)
                        + barra.substr(4, 5)
                        + barra.substr(10, 10)
                        + barra.substr(21, 10);

                if (modulo11_banco(barra.substr(0, 4) + barra.substr(5, 39)) != barra.substr(4, 1)) {
                    alert('Digito verificador ' + barra.substr(4, 1) + ', o correto é ' + modulo11_banco(barra.substr(0, 4) + barra.substr(5, 39)) + '\nO sistema não altera automaticamente o dígito correto na quinta casa!');
                }

                return(barra);
            }

            function calcula_linha(barra) {
                linha = barra.replace(/[^0-9]/g, '');
                //
                if (modulo10('399903512') != 8)
                    alert('Função "modulo10" está com erro!');
                if (linha.length != 44)
                    alert('A linha do Código de Barras está incompleta!');
                //
                var campo1 = linha.substr(0, 4) + linha.substr(19, 1) + '.' + linha.substr(20, 4);
                var campo2 = linha.substr(24, 5) + '.' + linha.substr(24 + 5, 5);
                var campo3 = linha.substr(34, 5) + '.' + linha.substr(34 + 5, 5);
                var campo4 = linha.substr(4, 1);	// Digito verificador
                var campo5 = linha.substr(5, 14);	// Vencimento + Valor
                //
                if (modulo11_banco(linha.substr(0, 4) + linha.substr(5, 99)) != campo4) {
                    alert('Digito verificador ' + campo4 + ', o correto é ' + modulo11_banco(linha.substr(0, 4) + linha.substr(5, 99)) + '\nO sistema não altera automaticamente o dígito correto na quinta casa!');
                }
                //
                if (campo5 == 0)
                    campo5 = '000';
                //
                linha = campo1 + modulo10(campo1) + ' ' + campo2 + modulo10(campo2) + ' ' + campo3 + modulo10(campo3) + ' ' + campo4 + ' ' + campo5;

                return(linha);
            }

            function fator_vencimento(dias) {
                //Fator contado a partir da data base 07/10/1997
                //*** Ex: 04/07/2000 fator igual a = 1001
                var currentDate, t, d, mes;
                t = new Date();
                currentDate = new Date();
                currentDate.setFullYear(1997, 9, 7);
                t.setTime(currentDate.getTime() + (1000 * 60 * 60 * 24 * dias));
                mes = (currentDate.getMonth() + 1);
                if (mes < 10)
                    mes = "0" + mes;
                dia = (currentDate.getDate() + 1);
                if (dia < 10)
                    dia = "0" + dia;

                return(t.toLocaleString());
            }

            function modulo10(numero)
            {
                numero = numero.replace(/[^0-9]/g, '');
                var soma = 0;
                var peso = 2;
                var contador = numero.length - 1;

                while (contador >= 0) {
                    multiplicacao = (numero.substr(contador, 1) * peso);
                    if (multiplicacao >= 10) {
                        multiplicacao = 1 + (multiplicacao - 10);
                    }
                    soma = soma + multiplicacao;
                    if (peso == 2) {
                        peso = 1;
                    } else {
                        peso = 2;
                    }
                    contador = contador - 1;
                }
                var digito = 10 - (soma % 10);

                if (digito == 10)
                    digito = 0;
                return digito;
            }

            function debug(txt)
            {
                form.t.value = form.t.value + txt + '\n';
            }

            function modulo11_banco(numero)
            {
                numero = numero.replace(/[^0-9]/g, '');

                var soma = 0;
                var peso = 2;
                var base = 9;
                var resto = 0;
                var contador = numero.length - 1;

                for (var i = contador; i >= 0; i--) {
                    //alert( peso );
                    soma = soma + (numero.substring(i, i + 1) * peso);

                    if (peso < base) {
                        peso++;
                    } else {
                        peso = 2;
                    }
                }

                var digito = 11 - (soma % 11);

                if (digito > 9)
                    digito = 0;

                if (digito == 0)
                    digito = 1;
                return digito;
            }
        </script>
    </head>
    <body>
        <form name="form">
            <center>
                <table>
                    <tbody>
                        <tr>
                            <td align="right" valign="MIDDLE">
                                Linha Digitável:
                            </td>
                            <td align="CENTER" valign="MIDDLE">
                                <input type="text" value="" size="57" maxlength="154" name="linha"></td>
                            <td align="right" valign="MIDDLE">
                                <input type="BUTTON" value="Calcular Barra" onclick="f_barra();">
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="MIDDLE">
                                Código&nbsp;da&nbsp;Barra:
                            </td>
                            <td align="CENTER" valign="MIDDLE">
                                <input type="text" value="" size="57" maxlength="144" name="barra">
                            </td>
                            <td align="right" valign="MIDDLE">
                                <input type="BUTTON" value="Calcular Linha" onclick="f_linha();">
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="MIDDLE">
                                Vencimento da Barra:
                            </td>
                            <td align="CENTER" valign="MIDDLE">
                                <input type="text" size="57" maxlength="100" name="venc" readonly="">
                            </td>
                            <td align="right" valign="MIDDLE">
                                <input type="BUTTON" value="Vencimento" onclick="f_venc();">
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="MIDDLE">
                                Valor:
                            </td>
                            <td align="CENTER" valign="MIDDLE">
                                <input type="text" size="57" maxlength="100" name="valor" readonly="">
                            </td>
                            <td align="right" valign="MIDDLE">
                                <input type="reset" value="Limpar">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
        </form>
    </body>
</html>
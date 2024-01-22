<?php
include "../Layout.php";
include "../Conectar/Conectar.php";
?>
<div class="conteudo_consulta">
    <?php
    @$Tipo_Tit = $_POST["Tipo_Cert"];
    @$Protocolo = $_POST["Protocolo_Cert"];

    if ($Tipo_Tit == "" && $Protocolo != "Protocolo ou Senha") {
        echo "<center><img src='../Imagens/btnXPB.png'></center>";
        echo "<h1 id='msg'>Selecione o Tipo de Documento que Deseja Localizar !</h1>";
    } elseif (
        ($Tipo_Tit != "" && $Protocolo == "Protocolo ou Senha") ||
        $Protocolo == ""
    ) {
        echo "<center><img src='../Imagens/btnXPB.png'></center>";
        echo "<h1 id='msg'> Digite o Número do Protocolo ou Senha ! </h1>";
    } else {
        $sql = "SELECT * FROM certidao_ri WHERE num_proto_ri = '$Protocolo' or cod_senha = '$Protocolo'";
        $query = mysql_query($sql);
        $busca = mysql_num_rows($query);

        // RI
        if ($Tipo_Tit == "RI") {
            $TIPO_DOCUMENTO = "Registro de Imóveis";
            $sql = "SELECT * FROM certidao_ri WHERE num_proto = '$Protocolo' or num_senha = '$Protocolo'";
            $limite = mysql_query("$sql");
            $busca = mysql_num_rows($limite);

            if ($busca == "0") {
                echo "<center><img src='../Imagens/btnXPB.png'></center>";
                echo "<h1 id='msg'> Protocolo ou Senha Inválida ! </h1>";
            } else {
                while ($sql = mysql_fetch_array($limite)) {
                    $COD_PROTO_RI = $sql["cod_cert_ri"];
                    $DATA_ATUALIZACAO = $sql["data_atualizacao"];
                    $COD_SENHA = $sql["num_senha"];
                    $NUM_PROTO_RI = $sql["num_proto"];
                    $DAT_PROTO_RI = $sql["dat_proto"];
                    $NOM_APRESENT = $sql["nom_busca"];
                    $COD_NATUREZA = $sql["cod_nat_cert"];
                    $STATUS = $sql["sit_status"];
                    $VAL_DEPOSITO = $sql["val_deposito"];
                    $VAL_TOT_CUSTAS = $sql["val_tot_cus"];
                    $DAT_BAIXA = $sql["dat_baixa"];
                }

                if ($DAT_BAIXA != "") {
                    $DAT_BAIXA = $DAT_BAIXA;
                    $SETA_BAIXA =
                        "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                    $IMG_BAIXA =
                        "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                } else {
                    $DAT_BAIXA = "Aguardando";
                    $SETA_BAIXA =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_BAIXA =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                }

                // remover start
                $sql_ = "SELECT * FROM `natureza_cer` WHERE `cod_nat_cert` = $COD_NATUREZA";
                $limite = mysql_query("$sql_");
                while ($sql_ = mysql_fetch_array($limite)) {
                    $NOM_NATUREZA = $sql_["nom_nat_cert"];
                }
                // remover end

                $sql_select = "SELECT * FROM `remes_cert` WHERE `cod_cert_ri1` = '$COD_PROTO_RI'";
                $sql_query = mysql_query($sql_select);
                while ($array = mysql_fetch_array($sql_query)) {
                    $COD_SETOR_D = $array["cod_setor_d"];
                    $DATA_REMESSA = $array["dat_remessa"];

                    if ($COD_SETOR_D == "51" || $COD_SETOR_D == "57") {
                        $SETA_MONT =
                            "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                        $IMG_MONT =
                            "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                        $DATA_REMESSA_MONT = $DATA_REMESSA;
                    } elseif ($COD_SETOR_D == "49") {
                        $SETA_DISP =
                            "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                        $IMG_DISP =
                            "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                        $DATA_REMESSA_DISP = $DATA_REMESSA;
                    }
                }

                if (@$IMG_MONT == "") {
                    $SETA_MONT =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_MONT =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                    $DATA_REMESSA_MONT = "Aguardando";
                }
                if (@$IMG_DISP == "") {
                    $SETA_DISP =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_DISP =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                    $DATA_REMESSA_DISP = "Aguardando";
                }

                if ($STATUS == "E") {
                    $STATUS = " <strong>Status:</strong> EXAME";
                } elseif ($STATUS == "I") {
                    @$A = "Exigência";
                    $LINK = "<a href='../Exigencias/$COD_SENHA.pdf' target='new'/>Visualizar Exigência</a>";
                    $STATUS =
                        "O título apresentado em " .
                        $DAT_PROTO_RI .
                        " por " .
                        $NOM_APRESENT .
                        " de protocolo n° " .
                        $NUM_PROTO_RI .
                        " foi qualificado negativamente em " .
                        $DAT_BAIXA .
                        " e <strong>estará disponível no Caixa de Devolução no dia " .
                        $DisponivelEmDois .
                        "</strong>, a partir das 09:00h, para cumprimento de exigências, ficando retido do valor do depósito prévio, o valor correspondente a prenotação.<br/><br/>$LINK";
                } elseif ($STATUS == "R") {
                    @$A = "Registro";
                    $TOTAL = $VAL_TOT_CUSTAS - $VAL_DEPOSITO;
                    if ($TOTAL > 0) {
                        $complemento =
                            ", na retirada o interessado deve&aacute; realizar uma complementa&ccedil;&atilde;o no valor de R$" .
                            number_format($TOTAL, 2, ",", " ");
                    } elseif ($TOTAL < 0) {
                        $complemento =
                            ", na retirada o interessado receber&aacute; restitui&ccedil;&atilde;o de R$" .
                            number_format($TOTAL, 2, ",", " ");
                    } else {
                        $complemento = ".";
                    }
                    $STATUS =
                        "O titulo apresentado em " .
                        $DAT_PROTO_RI .
                        " por " .
                        $NOM_APRESENT .
                        " de protocolo n&deg; " .
                        $NUM_PROTO_RI .
                        " foi registrado em " .
                        $DAT_BAIXA .
                        " e estar&aacute; dispon&iacute;vel no dia " .
                        @$DisponivelEmDois .
                        "</strong>" .
                        $complemento;
                } elseif ($STATUS == "A") {
                    $STATUS = "<strong>Status:</strong> AGUARDANDO";
                } else {
                    $STATUS = "<strong>Status:</strong> EM PROCESSO";
                }
            }
        }

        // TD
        if ($Tipo_Tit == "TD") {
            $TIPO_DOCUMENTO = "Títulos e Documentos";
            $sql = "SELECT * FROM `cert_ri_tdx` WHERE `num_proto_ri` = '$Protocolo' or `num_senha` = '$Protocolo'";
            $limite = mysql_query("$sql");
            $busca = mysql_num_rows($limite);

            if ($busca == "0") {
                echo "<center><img src='../Imagens/btnXPB.png'></center>";
                echo "<h1 id='msg'> Protocolo ou Senha Inválida ! </h1>";
            } else {
                while ($sql = mysql_fetch_array($limite)) {
                    $COD_PROTO_RI = $sql["cod_proto_ri"];
                    $DATA_ATUALIZACAO = $sql["data_atualizacao"];
                    $COD_SENHA = $sql["num_senha"];
                    $NUM_PROTO_RI = $sql["num_proto_ri"];
                    $DAT_PROTO_RI = $sql["dat_proto_ri"];
                    $NOM_APRESENT = $sql["nom_apresent"];
                    $COD_NATUREZA = $sql["cod_natureza"];
                    $STATUS = $sql["sit_status"];
                    $VAL_DEPOSITO = $sql["val_deposito"];
                    $VAL_TOT_CUSTAS = $sql["val_tot_custas"];
                    $DAT_BAIXA = $sql["dat_baixa"];
                }
                // remover start
                if ($DAT_BAIXA != "") {
                    $dataMysql = $DAT_BAIXA;
                    $data = explode("/", $dataMysql);
                    $dia = $data[2];
                    $mes = $data[1];
                    $ano = $data[0];
                    $DAT_CONF1 = "20" . $dia . "-" . $mes . "-" . $ano;
                    $diadasemana2 = date("w", strtotime($DAT_CONF1));
                    if ($diadasemana2 == "1") {
                        $dois = "2";
                    }
                    if ($diadasemana2 == "2") {
                        $dois = "2";
                    }
                    if ($diadasemana2 == "3") {
                        $dois = "2";
                    }
                    if ($diadasemana2 == "4") {
                        $dois = "4";
                    }
                    if ($diadasemana2 == "5") {
                        $dois = "4";
                    }

                    $data_br = $DAT_BAIXA;
                    list($dia, $mes, $ano) = explode("/", $data_br);
                    $time = mktime(0, 0, 0, $mes, $dia + $dois, $ano);
                    strftime("%d/%m/%Y", $time);
                    $data_en = sprintf("%d/%d/%d", $mes, $dia, $ano);
                    $time = strtotime($data_en . " +" . $dois . " day");
                    $DisponivelEmDois = strftime("%d/%m/%Y", $time);
                }
                // remover end

                if ($DAT_BAIXA != "") {
                    $DAT_BAIXA = $DAT_BAIXA;
                    $SETA_BAIXA =
                        "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                    $IMG_BAIXA =
                        "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                } else {
                    $DAT_BAIXA = "Aguardando";
                    $SETA_BAIXA =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_BAIXA =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                }

                // remover start
                $sql_ = "SELECT * FROM `nat_cert_td` WHERE `cod_nat_td` = $COD_NATUREZA";
                $limite = mysql_query("$sql_");
                while ($sql_ = mysql_fetch_array($limite)) {
                    $NOM_NATUREZA = $sql_["nom_nat_td"];
                }
                // remover end

                $sql_select = "SELECT * FROM remes_cert WHERE cod_cert_ri1 = '$COD_PROTO_RI'";
                $sql_query = mysql_query($sql_select);
                while ($array = mysql_fetch_array($sql_query)) {
                    $COD_SETOR_D = $array["cod_setor_d"];
                    $DATA_REMESSA = $array["dat_remessa"];

                    if ($COD_SETOR_D == "94") {
                        $SETA_MONT =
                            "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                        $IMG_MONT =
                            "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                        $DATA_REMESSA_MONT = $DATA_REMESSA;
                    } elseif ($COD_SETOR_D == "91") {
                        $SETA_DISP =
                            "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                        $IMG_DISP =
                            "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                        $DATA_REMESSA_DISP = $DATA_REMESSA;
                    }
                }

                if (@$IMG_MONT == "") {
                    $SETA_MONT =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_MONT =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                    $DATA_REMESSA_MONT = "Aguardando";
                }
                if (@$IMG_DISP == "") {
                    $SETA_DISP =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_DISP =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                    $DATA_REMESSA_DISP = "Aguardando";
                }
            }
        }

        // PJ
        if ($Tipo_Tit == "PJ") {
            $TIPO_DOCUMENTO = "Pessoas Jurídicas";
            $sql = "SELECT * FROM `cert_ri_pjx` WHERE `num_proto_ri` = '$Protocolo' or `num_senha` = '$Protocolo'";
            $limite = mysql_query("$sql");
            $busca = mysql_num_rows($limite);

            if ($busca == "0") {
                echo "<center><img src='../Imagens/btnXPB.png'></center>";
                echo "<h1 id='msg'> Protocolo ou Senha Inválida ! </h1>";
            } else {
                while ($sql = mysql_fetch_array($limite)) {
                    $COD_PROTO_RI = $sql["cod_proto_ri"];
                    $DATA_ATUALIZACAO = $sql["data_atualizacao"];
                    $COD_SENHA = $sql["num_senha"];
                    $NUM_PROTO_RI = $sql["num_proto_ri"];
                    $DAT_PROTO_RI = $sql["dat_proto_ri"];
                    $NOM_APRESENT = $sql["nom_apresent"];
                    $COD_NATUREZA = $sql["cod_natureza"];
                    $STATUS = $sql["sit_status"];
                    $VAL_DEPOSITO = $sql["val_deposito"];
                    $VAL_TOT_CUSTAS = $sql["val_tot_custas"];
                    $DAT_BAIXA = $sql["dat_baixa"];
                }
                // remover start
                if ($DAT_BAIXA != "") {
                    $dataMysql = $DAT_BAIXA;
                    $data = explode("/", $dataMysql);
                    $dia = $data[2];
                    $mes = $data[1];
                    $ano = $data[0];
                    $DAT_CONF1 = "20" . $dia . "-" . $mes . "-" . $ano;
                    $diadasemana2 = date("w", strtotime($DAT_CONF1));
                    if ($diadasemana2 == "1") {
                        $dois = "2";
                    }
                    if ($diadasemana2 == "2") {
                        $dois = "2";
                    }
                    if ($diadasemana2 == "3") {
                        $dois = "2";
                    }
                    if ($diadasemana2 == "4") {
                        $dois = "4";
                    }
                    if ($diadasemana2 == "5") {
                        $dois = "4";
                    }

                    $data_br = $DAT_BAIXA;
                    list($dia, $mes, $ano) = explode("/", $data_br);
                    $time = mktime(0, 0, 0, $mes, $dia + $dois, $ano);
                    strftime("%d/%m/%Y", $time);
                    $data_en = sprintf("%d/%d/%d", $mes, $dia, $ano);
                    $time = strtotime($data_en . " +" . $dois . " day");
                    $DisponivelEmDois = strftime("%d/%m/%Y", $time);
                }
                // remover end

                if ($DAT_BAIXA != "") {
                    $DAT_BAIXA = $DAT_BAIXA;
                    $SETA_BAIXA =
                        "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                    $IMG_BAIXA =
                        "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                } else {
                    $DAT_BAIXA = "Aguardando";
                    $SETA_BAIXA =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_BAIXA =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                }

                // remover start
                $sql_ = "SELECT * FROM `nat_cert_pj` WHERE `cod_nat_pj` = $COD_NATUREZA";
                $limite = mysql_query("$sql_");
                while ($sql_ = mysql_fetch_array($limite)) {
                    $NOM_NATUREZA = $sql_["nom_nat_pj"];
                }
                //remover end

                $sql_select = "SELECT * FROM `remes_cert` WHERE `cod_cert_ri1` = '$COD_PROTO_RI'";
                $sql_query = mysql_query($sql_select);
                while ($array = mysql_fetch_array($sql_query)) {
                    $COD_SETOR_D = $array["cod_setor_d"];
                    $DATA_REMESSA = $array["dat_remessa"];

                    if ($COD_SETOR_D == "94") {
                        $SETA_MONT =
                            "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                        $IMG_MONT =
                            "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                        $DATA_REMESSA_MONT = $DATA_REMESSA;
                    } elseif ($COD_SETOR_D == "92") {
                        $SETA_DISP =
                            "<img src='../Imagens/Seta.png' width='20' height='21'/>";
                        $IMG_DISP =
                            "<img src='../Imagens/btnCheck.png' width='75' height='71' />";
                        $DATA_REMESSA_DISP = $DATA_REMESSA;
                    }
                }

                if (@$IMG_MONT == "") {
                    $SETA_MONT =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_MONT =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                    $DATA_REMESSA_MONT = "Aguardando";
                }
                if (@$IMG_DISP == "") {
                    $SETA_DISP =
                        "<img src='../Imagens/SetaPB.png' width='20' height='21'/>";
                    $IMG_DISP =
                        "<img src='../Imagens/btnCheckPB.png' alt='' width='46' height='43' />";
                    $DATA_REMESSA_DISP = "Aguardando";
                }
            }
        }

        if ($busca == "0") {
            "";
        } else {
            echo "<table width='90%' border='0' cellspacing='0' cellpadding='0' align='center'>
    <tr>
      <td height='40' align='center' valign='middle' id='borda_arredondada' style='background-color:#151c46'>
      <strong style='font-size: 20px;'>Acompanhamento de Título de " .
                $TIPO_DOCUMENTO .
                "</strong>
      </td>
    </tr>
    <tr>
      <td align='right' id='borda_c' style='background-color:#151c46'>
      <strong style='font-size:10px'>última atualização realizada em " .
                $DATA_ATUALIZACAO .
                "&nbsp;</strong>
      </td>
    </tr>
    <tr><td height='5' align='right' id='borda_c' style='background-color:#151c46'></td></tr>
    <tr><td height='15' id='borda_c1'></td></tr>
    <tr>
     <td height='15' align='center' valign='middle' id='borda_c1'>
     <center><strong style='font-size: 18px; color: #666;'>Dados do Protocolo</strong></center>
     </td>
    </tr>
    <tr><td height='20px' id='borda_c1'></td></tr>
    <tr>
     <td id='borda_c1'>
      <table width='90%' border='0' align='center' cellpadding='0' cellspacing='0'>
       <tr><td><strong>Senha:</strong> " .
                $COD_SENHA .
                "</td></tr>
       <tr><td><strong>Protocolo:</strong> " .
                $NUM_PROTO_RI .
                "</td></tr>
	   <tr><td><strong>Data de Entrada:</strong> " .
                $DAT_PROTO_RI .
                "</td></tr>
       " .
                @$REAPR .
                "
       <tr><td><strong>Nome do Apresentante:</strong> " .
                $NOM_APRESENT .
                "</td></tr>
       <tr><td><strong>Natureza do Título:</strong> " .
                @$NOM_NATUREZA .
                "</td></tr>
       <tr><td><strong>Valor do Déposito:</strong> R$ " .
                number_format(@$VAL_DEPOSITO, 2, ",", ".") .
                "</td></tr>
       
      </table>
     </td>
    </tr>
    <tr><td id='borda_c1'>&nbsp;</td></tr>
    <tr><td id='borda_c1'>&nbsp;</td></tr>
    <tr>
     <td id='borda_c' align='center' style='background-color:#151c46'>
      <strong style='font-size: 16px'>Andamento</strong>
     </td>
    </tr>
    <tr><td id='borda_c1'>&nbsp;</td></tr>
    <tr>
     <td id='borda_c1'>
      <center>
       <table width='30%' border='0' cellpadding='0' cellspacing='0' style='line-height:1.5'>
        <tr>
         <td width='7%' align='center'>
          <img src='../Imagens/btnCheck.png' width='75' height='71' />
         </td>
         <td width='3%'>" .
                @$SETA_MONT .
                "</td>
         <td width='7%' align='center'>" .
                @$IMG_MONT .
                "</td>
           <td width='3%'>" .
                $SETA_DISP .
                "</td>
           <td width='5%' align='center'>" .
                $IMG_DISP .
                "</td>
        </tr>
        <tr><td colspan='11' align='center' height='5px'></td></tr>
        <tr style='font-size:12px'>
         <td align='center'>Entrada</td><td>&nbsp;</td>
         <td align='center'>Busca em Processo</td><td>&nbsp;</td>
         <td align='center'>Disponivel</td><td>&nbsp;</td>
        </tr>
        <tr style='font-size:10px'>
         <td align='center'>" .
                $DAT_PROTO_RI .
                "</td><td>&nbsp;</td>
         <td align='center'>" .
                $DATA_REMESSA_MONT .
                "</td><td>&nbsp;</td>
         <td align='center'>" .
                $DATA_REMESSA_DISP .
                "</td><td>&nbsp;</td>
        </tr>
       </table>
      </center>
     </td>
    </tr>
   <tr><td id='borda_c1'  height='40px;'></td></tr>
	<tr><td id='borda_c1'  height='40px;'>"; ?><center><a href="#" onClick="window.open('formAcomCertImpressao.php?Tipo_Cert=<?php echo $Tipo_Tit; ?>&Protocolo=<?php echo $Protocolo; ?>&Titulo=<?php echo $TIPO_DOCUMENTO; ?>', '', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=90, LEFT=150, WIDTH=702, HEIGHT=468'); " style="text-decoration:none"><img src='../Imagens/btnImprimir.png' width='21' height='18' />&nbsp;Imprimir</a></center><?php echo "</td></tr>
	<tr><td id='borda_c1' style='border-bottom:1px solid #999;'>&nbsp;</td></tr>
  </table>";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ?>

</div>
<br /><br />
<div class="rodape">&nbsp;
    <div id="box-1" class="box"><img src="../Imagens/Logo_Cinza.png" width="285" height="117" /></div>
    <div id="box-4" class="box"> © Todos Direitos Reservados - 2016</div>
    <div id="box-3" class="box"><strong>Links Utéis</strong> <br />
        <a href="http://www.inrpublicacoes.com.br" target="new">INR - www.inrpublicacoes.com.br</a> <br />
        <a href="http://www.arisp.com.br" target="new">ARISP - www.arisp.com.br</a> <br />
        <a href="http://www.incra.gov.br" target="new">INCRA - www.incra.gov.br</a> <br />
        <a href="http://idg.receita.fazenda.gov.br" target="new">Receita Federal - idg.receita.fazenda.gov.br</a> <br />
        <a href="http://www.itu.sp.gov.br" target="new">Municipalidade Local - www.itu.sp.gov.br</a> <br />
        <a href="https://www.registradores.org.br" target="new">Central Registradores de Imóveis</a>
    </div>
</div>
<?php
/*
 * Creado el 09/11/2018 12:35:40
 * Autor: gus
 * Archivo: adm_opg_fpg_act.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cht.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea = $glo->getGETPOST("tarea");
$idop=$glo->getGETPOST("idop");
$id = $glo->getGETPOST("id");
if ($tarea == "A") {
    $carteltarea = "Agrega Detalle de Pago";
    $botoncap = "Agregar!";
    $detalle = "Efectivo";
    $importe = "";
    $tipo=1;
    $idche=0;
} else {
    $carteltarea = "Modifica Caja";
    require_once 'clases/adm_opg2.php';
    $botoncap = "Modificar!";
    $adm = new adm_opg2_1($id);
    $detalle = $adm->getDetalle();
    $importe= $adm->getImporte();
    $tipo = $adm->getTipopago();
    $idche = $adm->getIdcht();
    $tipo='x|'.$tipo;
}
$condicioncht="";

$ssql="select * from adm_cht where entregado='' order by fechapago";
//echo $ssql;
$cht=new adm_cht_2($ssql);
$t_fec=$cht->getFechapago();
$t_ban=$cht->getBancodes();
$t_id=$cht->getId();
$t_imp=$cht->getImporte();
$t_nro=$cht->getNrocheque();
$chtbanco=array();
$cht_id=array();
array_push($chtbanco, "Efectivo");
array_push($chtbanco,"Retención Ganancia");
array_push($chtbanco,"Retención IIBB");
array_push($cht_id,"x|1");
array_push($cht_id,"x|2");
array_push($cht_id,"x|3");
for($i=0;$i<count($t_id);$i++) {
    array_push($chtbanco,"T: ".$dsup->getFechaNormalCorta($t_fec[$i])." ".$t_ban[$i]." ".$t_nro[$i]." $".number_format($t_imp[$i])." [".$t_id[$i]."]");
    array_push($cht_id,"t|".$t_id[$i]);
}
print_r($cht_id);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?= $cfg->getTitulo() ?></title>
        <style type="text/css">
            <!--
            #barblue {
                position:absolute;
                left:0px;
                top:0px;
                width:100%;
                height:51px;
                z-index:1;
                background-color:<?= $cfg->getColor1() ?>;
            }
            #barcentral {
                position:absolute;
                left:50%;
                top:<?= $cfg->getAlturamarco() ?>px;
                width:960px;
                height:75px;
                z-index:1;
                margin-left: -480px;
            }

            -->
        </style>
        <link href="css.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="planb.js?1.0.0"></script>
        <script src="js/jquery-1.3.2.js" type="text/javascript"></script>
        <script src="js/vanadium.js" type="text/javascript"></script>
        <script language="javascript">
            var VanadiumRules = {
                nombre: ['required', 'only_on_submit']
            }
        </script>
        <? require_once 'estilos.php'; ?>

    </head>

    <body>
        <div class="style1" id="barblue">
            <blockquote>
                <p class="titulo1"><?= $cfg->getCabecera() ?></p>
            </blockquote>
        </div>
        <div id="barcentral">
            <form name="form1" id="form1" action="adm_opg_fpg_act_save.php" method="post">
                <tr>
                    <? include("adm_menu.php") ?>
                    <input name="id" type="hidden" id="id" value="<?= $id ?>" />
                    <input name="tarea" type="hidden" id="tarea" value="<?= $tarea ?>" />
                    <input name="idop" type="hidden" id="idop" value="<?= $idop ?>" />
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                            <? require_once('displayusuario.php'); ?>
                            <tr>
                                <td>
                                    <div class="panel960 letra6">
                                        <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                            <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea ?></h3>                
                                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr>
                                                    <td colspan="2"><a href="javascript: document.form1.action='adm_opg_det.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                                </tr>                  
                                                <tr>
                                                    <td align="right" width="35%">Detalle&nbsp;</td>
                                                    <td  width="65%"><input name="detalle" type="text" class="letra6" id="detalle" maxlength="100" size="50" value="<?= $detalle ?>" /></td>
                                                </tr>                  
                                                <tr>
                                                    <td align="right">Forma de Pago&nbsp;</td>
                                                    <td>
                                                        <select name="tipo" id="tipo" onchange="PagaConChequeT(this.value, -1)">
                                                        <? $sup->cargaComboArrayValor($chtbanco, $cht_id, $tipo) ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right">Importe&nbsp;</td>
                                                    <td><input name="importe" id="importe" type="text" value="<?= $importe?>" size="10" maxlength="10" onkeypress="return validar_punto_menos(event)" style="text-align: center" /></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr></hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" align="center">
                                                        <input type="submit" name="Submit" value="<?= $botoncap ?>" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </form>
        </div>
    </body>
</html>

<?php
/*
 * creado el 24/11/2017 09:56:41
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_cta_sel
 */

require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
require_once 'clases/adm_cta.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();
$url=$_SERVER["HTTP_REFERER"];

//$usuario=new usuarios_1($id);
$ssql="select * from adm_cta where centro=$centrosel and tipo=1 order by nombre";
$adm=new adm_cta_2($ssql);
$t_id=$adm->getId();
$t_nom=$adm->getNombre();
$t_cod=$adm->getCodigo();
//print_r($t_id);
$t_act=array();
for($i=0;$i<count($t_id);$i++) {
    $aguja="|".$t_id[$i]."|";
    //echo $aguja." -- ".strpos($cajascrec,$aguja)."<br>";
    if(strpos($idctamay,$aguja)!==false) {
        //echo "1<br>";
        array_push($t_act,1);
    } else {
        //echo "0<br>";
        array_push($t_act,0);
    }
            
}
$cantidadcuenta=count($t_id);
$carteltarea="Selección de Cuentas";
$botoncap="Seleccionar!";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $cfg->getTitulo()?></title>
<style type="text/css">
<!--
#barblue {
	position:absolute;
	left:0px;
	top:0px;
	width:100%;
	height:51px;
	z-index:1;
	background-color:<?= $cfg->getColor1()?>;
        /*visibility:hidden;*/
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:960px;
	height:75px;
	z-index:1;
	margin-left: -480px;
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<?require_once 'estilos.php';?>
<script language="javascript">
    function setseleccion(can) {
        cad="";
        for(i=0;i<can;i++) {
            chkcuenta="chkcuenta" + i;
            if(document.getElementById(chkcuenta).checked==true)
                cad+="|" + document.getElementById(chkcuenta).value;
        }
        if(cad!="")
            cad+="|";
        document.getElementById("idctamay").value=cad;
        
    }
</script>
</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
    <form name="form1" id="form1" action="register_may.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="cuentasmay" id="cuentasmay" type="hidden" value="<?= $cuentasmay?>" />
        <input name="idctamay" id="idctamay" type="hidden" value="<?= $idctamay?>" />
        <input name="fechainimay" id="fechainimay" type="hidden" value="<?= $fechainimay?>" />
        <input name="fechafinmay" id="fechafinmay" type="hidden" value="<?= $fechafinmay?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" cellpadding="2" cellspacing="0">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra6">
                                    <tr>
                                        <td>
                                            <a href="javascript: document.form1.action='adm_inf_mayor.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <table width="100%">
                                                <tr>
                                                    <td class="letra6bold">Cuentas</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="javascript: marcar_desmarcar('chkcuenta',<?= $cantidadcuenta?>)">Selecciona Todas las Cuentas</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: setseleccion(<?= count($t_id)?>); document.form1.action='register_may.php'; document.form1.submit()" />
                                                        <table width="50%" border="0">
                                                            <? for($i=0;$i<count($t_id);$i++) { ?>
                                                            <tr>
                                                                <td><input name="chkcuenta<?= $i?>" id="chkcuenta<?= $i?>" value="<?= $t_id[$i]?>" type="checkbox" <? if($t_act[$i]==1) echo "checked='checked'";?> onclick="javascript: setseleccion(<?= count($t_id)?>)" /> <?= $t_nom[$i]." (".$t_cod[$i].")"?></td>
                                                            </tr>
                                                                <? } ?>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <hr></hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" onclick="javascript: setseleccion(<?= count($t_id)?>); document.form1.action='register_may.php'; document.form1.submit()" />
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
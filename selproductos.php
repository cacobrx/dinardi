<?php
/*
 * creado el 16 ago. 2023 15:13:01
 * Usuario: gus
 * Archivo: selproductos
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_art.php';
$aud = new registra_auditoria();
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$cfg = new planb_config_1($centrosel);
$urlvolver=$glo->getGETPOST("urlvolver");
if($urlvolver=="") $urlvolver="adm_rem_det_main.php";
$ssql="select * from adm_art order by descripcion";
$adm=new adm_art_2($ssql);
$p_id=$adm->getId();
$p_des=$adm->getDescripcion();
//print_r($t_tip);
//print_r($t_des);
$p_act=array();
for($i=0;$i<count($p_id);$i++) {
    $aguja="|".$p_id[$i]."|";
    //echo $aguja." -- ".strpos($cajascrec,$aguja)."<br>";
    if(strpos($articulosselinf,$aguja)!==false) {
        array_push($p_act,1);
    } else {
        array_push($p_act,0);
    }
}
$cantidadcentro=count($p_id);
$carteltarea="Selección de Productos de Compra";
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
            chkcaj="chkcaj" + i;
            if(document.getElementById(chkcaj).checked==true)
                cad+="|" + document.getElementById(chkcaj).value;
        }
        if(cad!="")
            cad+="|";
        document.getElementById("articulosselinf").value=cad;
        //alert(cad);
        
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
<form name="form1" id="form1" action="register_articulossel.php" method="post">
    <tr>
    <? include("adm_menu.php") ?>
    <input name="articulosselinf" id="articulosselinf" type="hidden" value="<?= $articulosselinf?>" />
    <input name="urlvolver" id="urlvolver" type="hidden" value="<?= $urlvolver?>" />
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            <a href="javascript: document.form1.action='<?= $urlvolver?>'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <hr></hr>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <a href="javascript: marcar_desmarcar('chkcaj',<?= $cantidadcentro?>)">Selecciona Todas los Centros</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" align="center">
                                                <? for($i=0;$i<count($p_id);$i++) { ?>
                                                <tr>
                                                    <td width="20%">&nbsp;</td>
                                                    <td><input name="chkcaj<?= $i?>" id="chkcaj<?= $i?>" value="<?= $p_id[$i]?>" type="checkbox" <? if($p_act[$i]==1) echo "checked='checked'";?> onclick="javascript: setseleccion(<?= count($p_id)?>)" /> <?= $p_des[$i]?></td>
                                                </tr>
                                                <? } ?>
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
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" />
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

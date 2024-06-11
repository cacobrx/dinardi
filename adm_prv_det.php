<?
/*
 * Creado el 18/01/2019 17:16:07
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prv_det.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$carteltarea="Detalle Proveedor #$id";
require_once 'clases/adm_prv.php';
$botoncap="Modificar!";
$adm=new adm_prv_1($id);
$id=$adm->getId();
$apellido=$adm->getApellido();
$nombre=$adm->getNombre();
$ciudad=$adm->getCiudad();
$direccion=$adm->getDireccion();
$telefono=$adm->getTelefono();
$condiva=$adm->getCondivades();
$cuit=$adm->getCuit();
$email=$adm->getEmail();
$retencioniibb=$adm->getRetencioniibb();
$cuenta=$adm->getCuentades();
$observaciones=$adm->getObservaciones();
$establecimiento1=$adm->getEstablecimiento1();
$establecimiento2=$adm->getEstablecimiento2();
$establecimiento3=$adm->getEstablecimiento3();
$pais_nom=$adm->getPais_nom();

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
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<? require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once('displayusuario.php');?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.action='adm_prv_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Código&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getCodigodinardi()?></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">ID&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $id?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Razon Social&nbsp;</td>
                                        <td class="letra6bold"><?= $apellido?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Nombre Fantasia&nbsp;</td>
                                        <td class="letra6bold"><?= $nombre?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Ciudad&nbsp;</td>
                                        <td class="letra6bold"><?= $ciudad?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Direccion&nbsp;</td>
                                        <td class="letra6bold"><?= $direccion?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Telefono&nbsp;</td>
                                        <td class="letra6bold"><?= $telefono?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Condicion Iva&nbsp;</td>
                                        <td class="letra6bold"><?= $condiva?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Cuit&nbsp;</td>
                                        <td class="letra6bold"><?= $cuit?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Establecimiento 1&nbsp;</td>
                                        <td class="letra6bold"><?= $establecimiento1?></td>
                                    </tr>
                                    <? if($establecimiento2>0) { ?>
                                        <tr>
                                            <td align="right">Establecimiento 2&nbsp;</td>
                                            <td class="letra6bold"><?= $establecimiento2?></td>
                                        </tr>
                                    <? }  
                                    if($establecimiento3>0) { ?>
                                        <tr>
                                            <td align="right">Establecimiento 3&nbsp;</td>
                                            <td class="letra6bold"><?= $establecimiento3?></td>
                                        </tr>
                                    <? }  ?>
                                    <tr>
                                        <td align="right">Cuenta&nbsp;</td>
                                        <td class="letra6bold"><?= $cuenta?></td>
                                    </tr> 
                                    
                                    <tr>
                                        <td align="right">RetencionIIBB&nbsp;</td>
                                        <td class="letra6bold"><?= $retencioniibb?></td>
                                    </tr>                                     
                  
                                    <tr>
                                        <td align="right">Email&nbsp;</td>
                                        <td class="letra6bold"><?= $email?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo&nbsp;</td>
                                        <td class="letra6bold"><?= $adm->getTipodes()?></td>
                                    </tr>
                  
                                    <tr>
                                        <td align="right">Observaciones</td>
                                        <td colspan="2" class="letra6bold"><?= $observaciones?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Países&nbsp;</td>
                                        <td class="letra6bold">
                                            <? for($p=0;$p<count($pais_nom);$p++) { 
                                                echo $pais_nom[$p]." / ";
                                            }?>
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
</form>
</div>
</body>
</html>

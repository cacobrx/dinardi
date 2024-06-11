<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_rem_exp_act.php
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
$cantidaddet=$glo->getGETPOST("cantidaddet");
if($cantidaddet=="")
    $cantidaddet=0;
    $carteltarea="Detalle Remito de Expotación";
    require_once 'clases/adm_rem_exp.php';
    $botoncap="Modificar!";
    $adm=new adm_rem_exp_1($id);
    $id=$adm->getId();
    $ptovta=$adm->getPtovta();
    $numero=$adm->getNumero();
    $fecha=$adm->getFecha();
    $exportador=$adm->getExportador();
    $buque=$adm->getBuque();
    $destino=$adm->getDestino();
    $remitente=$adm->getRemitente();
    $nro=$adm->getNro();
    $precinto=$adm->getPrecinto();
    $procedencia=$adm->getProcedencia();
    $giro=$adm->getGiro();
    $contenedor=$adm->getContenedor();
    $agenciapre=$adm->getAgenciapre();
    $transportista=$adm->getTransportista();
    $balanza=$adm->getBalanza();
    $cuit=$adm->getCuit();
    $certificado=$adm->getCertificado();
    $serie=$adm->getSerie();
    $fiscal=$adm->getFiscal();
    $nro2=$adm->getNro2();
    $patenteca=$adm->getPatenteca();
    $ssql="select * from adm_rem_exp_det where idrem=$id order by id";
    $det=new adm_rem_exp_det_2($ssql);   
    $d_can=$det->getCantidad();
    $d_des=$det->getDescripcion();
    $d_kgsb=$det->getKgsbrutos();
    $d_kgsn=$det->getKgsnetos();
    $cantidaddet=count($d_can); 

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
<script type="text/javascript" src="planb.js?1.1.19"></script>
<? require_once 'estilos.php';?>

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_rem_exp_act_save.php" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="<?= $id?>" />
        <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
        <input name="cantidaddet" type="hidden" id="cantidaddet" value="<?= $cantidaddet?>" />
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
                                        <td colspan="10"><a href="javascript: document.form1.action='adm_rem_exp_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>   
                                    <tr>
                                        <td align="left">Fecha&nbsp;</td>
                                        <td class="letra6bold"><?= $fecha?></td>
                                        <td>Pto.Venta / Número&nbsp;</td>
                                        <td class="letra6bold"><?= $ptovta?> / <?= $numero?></td>
                                   </tr>
                                    <tr>
                                        <td width="10%" align="left">Exportador&nbsp;</td>
                                        <td class="letra6bold" width="40%"><?= $exportador?></td>                                                                       
                                        <td align="left">Empresa Transportista&nbsp;</td>
                                        <td class="letra6bold"><?= $transportista?></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Buque&nbsp;</td>
                                        <td class="letra6bold"><?= $buque?></td>                                    
                                        <td align="left">Cuit&nbsp;</td>
                                        <td class="letra6bold"><?= $cuit?></td>                                  
                                    </tr>
                                    <tr>
                                        <td align="left">Destino&nbsp;</td>
                                        <td class="letra6bold"><?= $destino?></td>                                        
                                        <td align="left">Balanza&nbsp;</td>
                                        <td class="letra6bold"><?= $balanza?></td>                                                                       
                                    </tr>
                                    <tr>
                                        <td align="left">Remitente&nbsp;</td>
                                        <td class="letra6bold"><?= $remitente?></td>                                        
                                        <td align="left">Certificado&nbsp;</td>
                                        <td class="letra6bold"><?= $certificado?></td>                                                              
                                    </tr>
                                    <tr>
                                        <td align="left">P.E Nro&nbsp;</td>
                                        <td class="letra6bold"><?= $nro?></td>
                                        <td align="left">Serie&nbsp;</td>
                                        <td class="letra6bold"><?= $serie?></td>                                                                                       
                                    </tr>
                                    <tr>
                                        <td align="left">Precinto Nro&nbsp;</td>
                                        <td class="letra6bold"><?= $precinto?></td>                                      
                                        <td align="left">Nro°&nbsp;</td>
                                        <td class="letra6bold"><?= $nro2?></td>                                                                                                       
                                    </tr>
                                    <tr>
                                        <td align="left">Procedencia&nbsp;</td>
                                        <td class="letra6bold"><?= $procedencia?></td>                               
                                        <td align="left">Fiscal&nbsp;</td>
                                        <td class="letra6bold"><?= $fiscal?></td>                                                               
                                    </tr>
                                    <tr>
                                        <td align="left">Giro&nbsp;</td>
                                        <td class="letra6bold"><?= $giro?></td>                                        
                                        <td align="left">Patente Camion&nbsp;</td>
                                        <td class="letra6bold"><?= $patenteca?></td>                                   
                                    </tr>                                    
                                    <tr>
                                        <td align="left">Contenedor Nro&nbsp;</td>
                                        <td class="letra6bold"><?= $contenedor?></td>
                                        <td align="left">Precinto Agencia Nro&nbsp;</td>
                                        <td class="letra6bold"><?= $agenciapre?></td>
                                    </tr>                                                                                                     
                                    <tr>
                                        <td colspan="10"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">
                                            <div class="panelmax710 letra6">
                                                <div id="effect-panelmax710" class="ui-widget-content ui-corner-all">
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6" id="item_table">
                                                        <tr >                                                           
                                                            <td width="8%">Cantidad</td>
                                                            <td align="left">Descripción</td>
                                                            <td width="10%">Kgs Brutos</td>
                                                            <td width="10%">Kgs Netos</td>
                                                        </tr>
                                                        <? for($i=0;$i<count($d_can);$i++) { ?>
                                                        <tr class="letra6bold">                                                                
                                                            <td><?= $d_can[$i]?></td>
                                                            <td><?= $d_des[$i]?></td>
                                                            <td><?= $d_kgsb[$i]?></td>
                                                            <td><?= $d_kgsn[$i]?></td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10"><hr></hr></td>
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


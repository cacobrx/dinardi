<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
require_once 'clases/adm_opg1.php';
require_once 'clases/adm_opg2.php';
$cfg=new planb_config_1($centrosel);

$dsup=new datesupport();
$sup=new support();

$glo=new globalson();
$tarea=$glo->getGETPOST("tarea");
$idop=$glo->getGETPOST("idop");
$canti=$glo->getGETPOST("canti");
$primero=$glo->getGETPOST("primero");
$totaltotal="";
if($canti=="")
    $canti=2;
if($canti<2)
    $canti=2;
$carteltarea="Detalle Orden de Pago";
$botoncap="Modificar!";
$op1=new adm_opg1_1($idop);
$proveedor=$op1->getProveedor();
$direccion=$op1->getDireccion();
$concepto=$op1->getConcepto();
$fecha=$dsup->getFechaNormalCorta($op1->getFecha());
$d_fec=$op1->getD_fecha();
$d_com=$op1->getD_comprobante();
$d_imp=$op1->getD_importetotal();
$d_can=$op1->getD_importecancelado();
$a_det=$op1->getE_detalle();
$a_imp=$op1->getE_importe();
$a_id=$op1->getE_id();
$a_cht=$op1->getE_chequet();
$a_che=$op1->getE_chequep();
$totaltotal=array_sum($a_imp);
$canti=count($a_imp);
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
        /*visibility: hidden;*/
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:960px;
	height:75px;
	z-index:1;
	margin-left: -480px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<?require_once 'estilos.php'; ?>

</head>

<body onload="totalizar(<?= $canti?>)">
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="" method="post">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="tarea" id="tarea" type="hidden" />
        <input name="id" id="id" type="hidden" />
        <input name="idop" id="idop" type="hidden" value="<?= $idop?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php'; ?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td colspan="2"><a href="javascript: document.form1.target='_self'; document.form1.action='adm_opg_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a></td>
                                    </tr>
                                    <tr>
                                      <td align="right">ID&nbsp;</td>
                                      <td class="letra6bold"><?= $op1->getId()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Fecha&nbsp;</td>
                                        <td class="letra6bold"><?= $dsup->getFechaNormalCorta($op1->getFecha())?></td>
                                    </tr>
                                    <tr>
                                        <td width="35%" align="right">Proveedor&nbsp;</td>
                                        <td width="65%" class="letra6bold"><?= $op1->getProveedor()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Dirección&nbsp;</td>
                                        <td class="letra6bold"><?= $op1->getDireccion()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Concepto&nbsp;</td>
                                        <td class="letra6bold"><?= $op1->getConcepto()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Tipo&nbsp;</td>
                                        <td class="letra6bold"><?= $op1->getTipodes()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Caja&nbsp;</td>
                                        <td class="letra6bold"><?= $op1->getCajades()?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Total Importe&nbsp;</td>
                                        <td class="letra6bold">$<?= number_format($op1->getImporte(),2)?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Retención IIBB&nbsp;</td>
                                        <td class="letra6bold">$<?= number_format($op1->getRetencioniibb(),2)?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">Retención Ganancia&nbsp;</td>
                                        <td class="letra6bold">$<?= number_format($op1->getRetencionganancia(),2)?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Detalle de los Pagos</h3>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                                        <tr class="letra6bold">
                                                            <td width="10%"><a href="javascript: document.form1.target='_self'; document.form1.tarea.value='A'; document.form1.action='adm_opg_fpg_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" title="Agregar Detalle de Pago" alt="Agregar Detalle de Pago"></i></a></td>
                                                            <td width="50%">Detalle de Pagos</td>
                                                            <td width="10%" align="right">Importe</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        $totche=0;
                                                        $totcht=0;
                                                        for($i=0;$i<$canti;$i++) { 
                                                            if($a_che[$i]>0) $totche+=$a_imp[$i];
                                                            if($a_cht[$i]>0) $totcht+=$a_imp[$i];
                                                            ?>
                                                        <tr>
                                                            <td width="10%">
                                                                <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_opg_fpg_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" title="Agregar Detalle de Pago" alt="Agregar Detalle de Pago"></i></a>
                                                            </td>
                                                            <td><?= $a_det[$i]?></td>
                                                            <td align="right">$<?= number_format($a_imp[$i],2)?></td>
                                                            <td><a href="javascript: document.form1.target='_self'; bajareg(<?= $a_id[$i]?>,'Elimina Detalle de Pago?','adm_opg_fpg_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" title="Eliminar Detalle de Pago" alt="Eliminar Detalle de Pago"></i></a></td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="panel910 letra6">
                                                <div id="effect-panel910" class="ui-widget-content ui-corner-all">
                                                    <h3 class="ui-widget-header ui-corner-all">Aplicación de Documentos</h3>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                                        <tr class="letra6bold">
                                                            <td width="10%" align="center">Fecha</td>
                                                            <td width="30%">Comprobante</td>
                                                            <td width="10%" align="right">Importe</td>
                                                            <!--<td width="10%" align="right">Pagado</td>-->
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <? for($i=0;$i<count($d_can);$i++) { ?>
                                                        <tr>
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($d_fec[$i])?></td>
                                                            <td><?= $d_com[$i]?></td>
                                                            <td align="right">$<?= number_format($d_imp[$i],2)?></td>
                                                            <!--<td align="right">$<?= number_format($d_can[$i],2)?></td>-->
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Total Cheques Terceros: <strong><?= number_format($totcht,2)?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Total Cheques Propios: <strong><?= number_format($totche,2)?></strong>
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

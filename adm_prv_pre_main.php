<?php
/*
 * Creado el 21/01/2019 08:54:13
 * Autor: gus
 * Archivo: adm_prv_pre_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_prv.php';
$dsup = new datesupport();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$botoncap="Modificar";
$adm=new adm_prv_1($id);
$carteltarea="Precios del Proveedor ".strtoupper($adm->getApellido());
$pre_idart=$adm->getPre_idart();
$pre_codigo=$adm->getPre_codigo();
$pre_articulo=$adm->getPre_articulo();
$pre_importe=$adm->getPre_importe();
$pre_preciominimo=$adm->getPre_preciominimo();
$pre_preciomaximo=$adm->getPre_preciomaximo();
$pre_alicuota=$adm->getPre_alicuota();
$pre_preciofinal=$adm->getPre_preciofinal();
$pre_rubro=$adm->getPre_rubro();
$pre_seleccionado=$adm->getPre_seleccionados();
$cantidadtotal=count($pre_idart);
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
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js?1.0.0"></script>
<? include("estilos.php");?>
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
                <input name="idp" type="hidden" id="idp" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($pre_idart)?>" />    
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all"><?= $carteltarea?></h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    <a href="javascript: document.form1.action='adm_prv_main.php'; document.form1.submit()"><i class="fas fa-arrow-left fa-lg" title="Volver" alt="Volver"></i></a> 
                                                    Arts. Seleccionados <input name="soloprecioprvp" id="soloprecioprvp" type="checkbox" value="1" <? if($soloprecioprvp==1) echo "checked='checked'"?> onclick="javascript: document.form1.target='_self'; document.form1.action='register_prvp.php'; document.form1.submit()" /> |  
                                                    Orden <select name="ordenprvp" id="ordenprvp" onchange="javascript: document.form1.target='_self'; document.form1.action='register_prvp.php'; document.form1.submit()">
                                                        <?
                                                        $array=array("Codigo", "Descripción");
                                                        $avalor=array("codigodinardi","descripcion");
                                                        $sup->cargaComboArrayValor($array, $avalor, $ordenprvp);
                                                        ?>
                                                    </select> | 
                                                    Rubro <select name="rubroprvp" id="rubroprvp" onchange="javascript: document.form1.target='_self'; document.form1.action='register_prvp.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select valor as id, descripcion as campo from tablas where codtab='RUB' order by descripcion";
                                                        $sup->cargaCombo3($ssql, $rubroprvp, "Todos");
                                                        ?>
                                                    </select> | 
                                                    <input name="chkprn" id="chkprv" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_prv_pre_prn.php'; document.form1.submit()" /> 
                                                    <input name="chkexp" id="chkok" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_prv_pre_exp.php'; document.form1.submit()" /> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="10%">
                                                                &nbsp;
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td align="left">Producto</td>
                                                            <td width="20%" align="left">Rubro</td>
                                                            <td width="10%" align="right">Precio</td>
                                                            <td width="6%" align="right">Iva</td>
                                                            <td width="8%" align="right">Precio Final</td>
                                                            <td width="8%" align="right">Precio Min.</td>
                                                            <td width="8%" align="right">Precio Max.</td>
                                                            <td width="6%" align="center">Sel</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($pre_idart);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <?if($usr->getNivel()<=1) { ?>
                                                                <a href="javascript: document.form1.idp.value=<?= $pre_idart[$i]?>; document.form1.target='_self'; document.form1.action='adm_prv_pre_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Precio Proveedor" title="Modifica Precio Proveedor"></i></a> 
                                                                <? } ?>
                                                            </td>
                                                            <td align="center"><?= $pre_codigo[$i]?></td>
                                                            <td align="left"><?= $pre_articulo[$i]?></td>
                                                            <td align="left"><?= $pre_rubro[$i]?></td>
                                                            <td align="right"><?= number_format($pre_importe[$i],5)?></td>
                                                            <td align="right"><?= number_format($pre_alicuota[$i],2)?></td>
                                                            <td align="right"><?= number_format($pre_preciofinal[$i],5)?></td>
                                                            <td align="right"><?= number_format($pre_preciominimo[$i],2)?></td>
                                                            <td align="right"><?= number_format($pre_preciomaximo[$i],2)?></td>
                                                            <td align="center">
                                                                <? if($pre_seleccionado[$i]==1) { ?>
                                                                <i class="far fa-check-circle fa-lg"></i>
                                                                    <? } ?>
                                                            </td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Proveedores?','adm_prv_pre_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Proveedores" title="Elimina Proveedores"></i></a></td>
                                                        </tr>
                                                        <? } ?>
                                                    </table>
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
                <td>&nbsp;</tr>
            </tr>
        </form>
    </div>
</body>
</html>

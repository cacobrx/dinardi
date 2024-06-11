<?
/*
 * Creado el 01/02/2019 13:27:59
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prd_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prd.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_prd";
$condicion="";
if($textoprd!="") $condicion.=" instr(upper(descripcion), '".strtoupper($textoprd)."')>0 and ";
if($rubroprd>0)
    $condicion.="rubro=$rubroprd and ";

if($condicion!="") $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
$ssql.="$condicion order by $ordenprd limit $limprd,".$cfg->getLimmax();
$adm=new adm_prd_2($ssql);
    
$a_id=$adm->getId();
$a_des=$adm->getDescripcion();
$a_rub=$adm->getRubrodes();
$a_kil=$adm->getKilosxanimal();
$a_pre=$adm->getPrecioventa();
$a_cod=$adm->getCodigoproducto();
$a_ubix=$adm->getPosicionx();
$a_ubiy=$adm->getPosiciony();
$a_ubiz=$adm->getPosicionz();
$a_col=$adm->getColorcamara();
$colorletra=$adm->getColorletra();

$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limprd)
    $cadenapaginas.=" <a href='javascript: document.form1.limprd.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_prd.php\"; document.form1.submit()' class='letra6'>$j</a>";
  else
    $cadenapaginas.=" <span class='letra6bold'>$j</span></a>";
}
$cadenapaginas=substr($cadenapaginas,1,strlen($cadenapaginas)-1);
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
                <input name="id" type="hidden" id="id" value="0" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="limprd" type="hidden" id="limprd" value="<?= $limprd?>" />
                <input name="marcar" type="hidden" id="marcar" value="0" />
                <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
            </tr>
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="0">
                        <? require("displayusuario.php");?>
                        <tr>
                            <td>
                                <div class="panel960 letra6">
                                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                        <h3 class="ui-widget-header ui-corner-all">ARTICULOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Texto <input name="textoprd" id="textoart" type="text" size="10" value="<?= $textoprd?>" /> | 
                                                    Orden <select name="ordenprd" id="ordenprd" onchange="javascript: document.form1.target='_self'; document.form1.action='register_prd.php'; document.form1.submit()">
                                                        <?
                                                        $array=array("Descripción", "Código");
                                                        $avalor=array("descripcion", "codigoproducto");
                                                        $sup->cargaComboArrayValor($array, $avalor, $ordenprd);
                                                        ?>
                                                    </select> | 
                                                    Rubro <select name="rubroprd" id="rubroprd" onchange="javascript: document.form1.target='_self'; document.form1.limprd.value=0; document.form1.action='register_prd.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select valor as id, descripcion as campo from tablas where codtab='RUB' order by descripcion";
                                                        $sup->cargaCombo3($ssql, $rubroart, "Todos");
                                                        ?>
                                                    </select> | 
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limprd.value=0; document.form1.action='register_prd.php'; document.form1.submit()" /> 
                                                    <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_prd_prn.php'; document.form1.submit()" /> 
                                                    <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_prd_exp.php'; document.form1.submit()" /> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="5%">
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_prd_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Articulos de Venta" title="Agregar Articulos de Venta"></i></a> 
                                                            </td>
                                                            <td width="5%" align="center">Cód</td>
                                                            <td align="left">Descripcion</td>      
                                                            <td width="7%">Color</td>
                                                            <td width="20%" align="left">Rubro</td>                                                                                                                    
                                                            <td width="10%" align="center">Precio</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_prd_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Articulos de Venta" title="Modifica Articulos de Venta"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_prd_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Articulos de Venta" title="Detalle Articulos de Venta"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_cod[$i]?></td>
                                                            <td align="left"><?= $a_des[$i]?></td>                                                                                                                       
                                                            <td style="background-color: <?= $a_col[$i]?>; color: <?= $colorletra[$i]?> ">Letra Color</td>                                                                                                                       
                                                            <td align="left"><?= $a_rub[$i]?></td>
                                                            <td align="center"><?= $a_pre[$i]?></td>
                                                            
                                                            <td align="right"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Articulos de Venta?','adm_prd_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Articulos de Venta" title="Elimina Articulos de Venta"></i></a></td>
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



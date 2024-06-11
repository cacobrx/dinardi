<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_art_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_art.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$ssql="select * from adm_art";
$condicion="";
if($textoart!="")
    $condicion.="instr(upper(descripcion), '".strtoupper($textoart)."')>0 and ";
if($rubroart>0)
    $condicion.="rubro=$rubroart and ";
if($condicion!="") $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
$ssql.="$condicion order by $ordenart limit $limart,".$cfg->getLimmax();
$adm=new adm_art_2($ssql);
//echo $ssql;    
$a_id=$adm->getId();
$a_des=$adm->getDescripcion();
$a_pre=$adm->getPrecio();
$a_rub=$adm->getRubrodes();
$a_cod=$adm->getCodigodinardi();
$a_tip=$adm->getTipoenvalajedes();
$a_env=$adm->getEnvasado();
$a_ela=$adm->getElaborado();
$a_can=$adm->getCantidad();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limart)
    $cadenapaginas.=" <a href='javascript: document.form1.limart.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_art.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="id" type="hidden" id="id" value="0" />
                <input name="tarea" type="hidden" id="tarea" value="A" />
                <input name="limart" type="hidden" id="limart" value="<?= $limart?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">PRODUCTOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Texto <input name="textoart" id="textoart" type="text" size="10" value="<?= $textoart?>" /> | 
                                                    Orden <select name="ordenart" id="ordenart" onchange="javascrit: document.form1.target='_self'; document.form1.action='register_art.php'; document.form1.submit()">
                                                        <?
                                                        $array=array('Codigo', "Descripción");
                                                        $avalor=array('codigodinardi', 'descripcion');
                                                        $sup->cargaComboArrayValor($array, $avalor, $ordenart);
                                                        ?>
                                                    </select> | 
                                                    Rubro <select name="rubroart" id="rubroart" onchange="javascrit: document.form1.target='_self'; document.form1.action='register_art.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select valor as id, descripcion as campo from tablas where codtab='RUB' order by descripcion";
                                                        $sup->cargaCombo3($ssql, $rubroart, "Todos");
                                                        ?>
                                                    </select> | 
                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limart.value=0; document.form1.action='register_art.php'; document.form1.submit()" /> 
                                                    <input name="cmdprn" id="cmdprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_art_prn.php'; document.form1.submit()" /> 
                                                    <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_art_exp.php'; document.form1.submit()" /> 
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
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_art_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Productos" title="Agregar Productos"></i></a> 
                                                            </td>
                                                            <td width="8%" align="center">ID</td>
                                                            <td width="30%" align="left">Descripcion</td>
                                                            <td width="15%" align="left">Rubro</td>
                                                            <td width="10%" align="left">Tipo Envalaje</td>
                                                            <td width="10%" align="right">Cantidad</td>
                                                            <td width="10%" align="center">Envasado</td>
                                                            <td width="10%" align="center">Elaborado</td>
                                                            <td width="10%" align="right">Precio</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_art_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Productos" title="Modifica Productos"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_cod[$i]?></td>
                                                            <td align="left"><?= $a_des[$i]?></td>
                                                            <td align="left"><?= $a_rub[$i]?></td>
                                                            <td align="left"><?= $a_tip[$i]?></td>
                                                            <td align="right"><?= number_format($a_can[$i],2)?></td>
                                                            <? if($a_env[$i]==1) { ?>
                                                            <td align="center"><i class="fas fa-check-circle fa-lg" style="color: green"></i></td>
                                                            <? } else { ?>
                                                                <td align="left"></td>
                                                            <? } ?>
                                                            <? if($a_ela[$i]==1) { ?>
                                                            <td align="center"><i class="fas fa-check-circle fa-lg" style="color: green"></i></td>
                                                            <? } else { ?>
                                                                <td align="left"></td>
                                                            <? } ?>
                                                            <td align="right"><?= number_format($a_pre[$i],2)?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Productos?','adm_art_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Productos" title="Elimina Productos"></i></a></td>
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



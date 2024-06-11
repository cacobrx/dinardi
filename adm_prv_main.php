<?
/*
 * Creado el 18/01/2019 17:16:07
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_prv_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_prv.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_prv";
$condicion="";

if($textoprv!="") $condicion.="(instr(upper(apellido),'".strtoupper ($textoprv)."')>0 or instr(upper(nombre),'".strtoupper ($textoprv)."')>0 or instr(cuit,'$textoprv')>0) and ";
if($tipoprv>0) $condicion.="tipo=$tipoprv and ";
if($condicion!="") $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
$ssql.="$condicion order by";
if($ordenprv==1)
    $ssql.=" apellido, nombre";
else
    $ssql.=" codigodinardi";
//echo $ssql;
$ssql.=" limit $limprv,".$cfg->getLimmax();
$adm=new adm_prv_2($ssql);
    
$a_id=$adm->getId();
$a_cod=$adm->getCodigodinardi();
$a_ape=$adm->getApellido();
$a_nom=$adm->getNombre();
$a_tel=$adm->getTelefono();
$a_cui=$adm->getCuit();
$a_ema=$adm->getEmail();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limprv)
    $cadenapaginas.=" <a href='javascript: document.form1.limprv.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_prv.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limprv" type="hidden" id="limprv" value="<?= $limprv?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">PROVEEDORES</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Texto <input name="textoprv" id="textoprv" type="text" size="10" value="<?= $textoprv?>" /> | 
                                                    Tipo <select name="tipoprv" id="tipoprv" onchange="javascript: document.form1.target='_self'; document.form1.limprv.value=0; document.form1.action='register_prv.php'; document.form1.submit()">
                                                        <? 
                                                        $array=array("Proveedores", "Proveedores Varios");
                                                        $avalor=array(1,2);
                                                        $sup->cargaComboArrayValor($array, $avalor, $tipoprv, "Todos");
                                                        ?>
                                                    </select> | 
                                                    Orden <select name="ordenprv" id="ordenprv" onchange="javascript: document.form1.target='_self'; document.form1.limprv.value=0; document.form1.action='register_prv.php'; document.form1.submit()">
                                                        <? 
                                                        $array=array("Razón Social", "Código");
                                                        $avalor=array(1,2);
                                                        $sup->cargaComboArrayValor($array, $avalor, $ordenprv);
                                                        ?>
                                                    </select> | 

                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limprv.value=0; document.form1.action='register_prv.php'; document.form1.submit()" /> 
                                                    <input name="chkprn" id="chkprv" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_prv_prn.php'; document.form1.submit()" /> 
                                                    <input name="chkexp" id="chkok" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_prv_exp.php'; document.form1.submit()" /> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                                        <tr class="letra6bold">
                                                            <td width="10%">
                                                                <?if($usr->getNivel()<=1) { ?>
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_prv_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Proveedores" title="Agregar Proveedores"></i></a> 
                                                                <? } ?>
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td align="left">Razon Social</td>
                                                            <td width="15%" align="left">Nombre Fantasia</td>
                                                            <td width="15%" align="left">Telefono</td>
                                                            <td width="15%" align="left">Cuit</td>
                                                            <td width="15%" align="left">Email</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <?if($usr->getNivel()<=1) { ?>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_prv_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Proveedores" title="Modifica Proveedores"></i></a> 
                                                                <? } ?>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_prv_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Proveedores" title="Detalle Proveedores"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_prv_pre_main.php'; document.form1.submit()"><i class="fas fas fa-dollar-sign fa-lg" alt="Precios Proveedores" title="Precios Proveedores"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_cod[$i]?></td>
                                                            <td align="left"><?= $a_ape[$i]?></td>
                                                            <td align="left"><?= $a_nom[$i]?></td>
                                                            <td align="left"><?= $a_tel[$i]?></td>
                                                            <td align="left"><?= $a_cui[$i]?></td>
                                                            <td align="left"><?= $a_ema[$i]?></td>
                                                            <td align="center">
                                                                <?if($usr->getNivel()<=1) { ?>
                                                                <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Proveedores?','adm_prv_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Proveedores" title="Elimina Proveedores"></i></a>
                                                                <? } ?>
                                                            </td>
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



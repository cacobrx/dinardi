<?
/*
 * Creado el 12/03/2013 21:16:19
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cli_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_cli.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
switch ($ordencli) {
    case 0:
        $orden="adm_cli.id";
        break;
    case 1:
        $orden="adm_cli.apellido, adm_cli.nombre";
        break;
}
$ssql="select * from adm_cli";
$condicion="";
$ntex=strlen($textocli);
if($textocli!="") $condicion.="(instr(upper(adm_cli.apellido),upper('$textocli'))>0 or instr(upper(adm_cli.nombre),upper('$textocli'))>0 or adm_cli.id='$textocli' or instr(adm_cli.cuit,'$textocli')>0) and ";
if($condicion!="") {
    $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
}


$ssql.=$condicion;

$ssql.=" order by $orden limit $limcli,".$cfg->getLimmax();
//echo $ssql."<br>";

//$ssql="select * from adm_cli where centro=$centrosel order by apellido, nombre limit $lim,".$cfg->getLimmax();
$adm=new adm_cli_2($ssql);
    
$a_id=$adm->getId();
$a_ape=$adm->getApellido();
$a_nom=$adm->getNombre();
$a_tel=$adm->getTelefono();
$a_cel=$adm->getCelular();
$a_doc=$adm->getCuit();
$a_ciu=$adm->getCiudaddes();
$a_dir=$adm->getDireccion();
$a_iva=$adm->getCondicionivaabr();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limcli)
    $cadenapaginas.="- <a href='javascript: document.form1.limcli.value=$ini; document.form1.action=\"register_cliente.php\"; document.form1.submit()' class='can'>$j</a>";
  else
    $cadenapaginas.="- <span class='letra2'>$j</span></a>";
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
<script type="text/javascript" src="planb.js"></script>
<?require_once 'estilos.php';?>
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
        <input name="limcli" type="hidden" id="limcli" value="<?= $limcli?>" />
        <input name="marcar" type="hidden" id="marcar" value="0" />
        <input name="idcli" type="hidden" id="idcli" />
        <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />      
    </tr>
    <tr>
        <td>
        <? require_once 'displayusuario.php'?>        
        <tr>
            <td>
                <div class="panel960 letra6">
                    <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                        <h3 class="ui-widget-header ui-corner-all">CLIENTES</h3>
                        <table width="100%" border="0" cellspacing="0" cellpadding="2">                                            
                            <tr>
                                <td>
                                    Campo 
                                    <select name="campocli" id="campocli">
                                        <?
                                        $array=array("Nombre", "ID", "CUIT");
                                        $avalor=array("N", "I", "C");
                                        $sup->cargaComboArrayValor($array, $avalor, $campocli);
                                        ?>
                                    </select>
                                    Texto <input name="textocli" id="textocli" type="input" value="<?= $textocli?>" /> | 
                                    <input name="cmdok" type="submit" value="Buscar" onclick="javascript: document.form1.target='_self'; document.form1.limcli.value=0; document.form1.action='register_cliente.php'; document.form1.submit()" />
                                    <input type="submit" name="cmdprn" id="cmdprn" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_cli_prn.php'; document.form1.submit()" />
                                
                                </td>
                            </tr>
                            <tr>
                                <td class="ui-widget-header ui-corner-all">
                                    <span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                        <tr class="letra6bold">
                                            <td width="5%">
                                                <? if($usr->getNivel()<2) { ?>
                                                <a href="javascript: document.form1.target='_self'; document.form1.tarea.value='A'; document.form1.action='adm_cli_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Cliente" title="Agregar Cliente"></i></a> 
                                                <? } ?>
                                            </td>
                                            <td width="5%" align="center">Id</td>
                                            <td width="23%" align="left">Cliente</td>
                                            <td width="20%" align="left">Direccion</td>
                                            <td width="20%" align="left">Telefono</td>
                                            <td width="8%" align="left">CUIT</td>
                                            <td width="3%" align="center">IVA</td>
                                            <td width="2%" align="left">&nbsp;</td>
                                        </tr>
                                        <? for($i=0;$i<count($a_id);$i++) { ?>
                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                            <td>
                                                <? if($usr->getNivel()<2) { ?>
                                                <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_cli_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Cliente" title="Modifica Cliente"></i></a> 
                                                <? } ?>
                                                <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.action='adm_cli_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Cliente" title="Detalle Cliente"></i></a>                                         
                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_cli_pre_main.php'; document.form1.submit()"><i class="fas fas fa-dollar-sign fa-lg" alt="Precios Cliente" title="Precios Cliente"></i></a> 
                                            </td>
                                            <td align="center"><?= $a_id[$i]?></td>
                                            <td align="left"><?= $a_ape[$i]." ".$a_nom[$i]?></td>
                                            <td align="left"><?= $a_dir[$i]." ".$a_ciu[$i]?></td>
                                            <td align="left"><?= $a_tel[$i]." / ".$a_cel[$i]?></td>
                                            <td align="left"><?= $a_doc[$i]?></td>                                            
                                            <td align="center"><?= $a_iva[$i]?></td>                                            
                                            <td align="center">
                                                <? if($usr->getNivel()==0) { ?>
                                                <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Cliente?','adm_cli_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Cliente" title="Elimina Cliente"></i></a>
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
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>
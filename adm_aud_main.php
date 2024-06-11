<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_aud_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_aud.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();
$condicion="";
if($centroaud>0) 
    $condicion.=" and centro=$centroaud";
if($usuarioaud>0)
    $condicion.=" and usuario=$usuarioaud";
if($textoaud!="")
    $condicion.=" and (instr(modulo, '$textoaud') or instr(descripcion, '$textoaud'))";
$ssql="select * from auditoria where fecha>='$fechainiaud 00:00:00' and fecha<='$fechafinaud 23:59:59' $condicion order by fecha desc limit $limaud,".$cfg->getLimmax();
$adm=new adm_aud_2($ssql);
//echo $ssql."<br>";    
$a_id=$adm->getId();
$a_fec=$adm->getFecha();
$a_usu=$adm->getUsuarionom();
$a_mod=$adm->getModulo();
$a_cli=$adm->getCentronom();
$a_des=$adm->getDescripcion();
$a_cen=$adm->getCentronom();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limaud)
    $cadenapaginas.="- <a href='javascript: document.form1.target=\"_self\"; document.form1.limaud.value=$ini; document.form1.action=\"register_aud.php\"; document.form1.submit()' class='can'>$j</a>";
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
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="planb.js"></script>
<? require_once 'estilos.php'?>        

</head>
<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="adm_aud_main.php" method="post">
    <tr>
    <? include("adm_menu.php") ?>
        <input name="id" type="hidden" id="id" value="0" />
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="limaud" type="hidden" id="limaud" value="<?= $limaud?>" />
        <input name="marcar" type="hidden" id="marcar" value="0" />
        <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php'?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">AUDITORIA</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td>
                                            Fecha desde <input name="fechainiaud" type="date" class="letra6" id="fechainiaud" value="<?= $fechainiaud?>" /> 
                                            hasta <input name="fechafinaud" type="date" class="letra6" id="fechafinaud" value="<?= $fechafinaud?>" /> | 
                                            Usuario: 
                                            <select name="usuarioaud" id="usuarioaud"  onchange="javascript: document.form1.target='_self'; document.form1.limaud.value=0; document.form1.action='register_aud.php'; document.form1.submit()">
                                                <?
                                                $ssql="select id as id, concat_ws(' ', apellido, nombre, '[', centro, ']') as campo from usuarios order by apellido, nombre"; 
                                                $sup->cargaCombo3($ssql, $usuarioaud, "Todos");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                          Texto <input name="textoaud" id="textoaud" type="text" size="20" value="<?= $textoaud?>" /> | 
                                          <input name="cmdok" id="cmdok" value="Filtrar" type="submit" onclick="javascrit: document.form1.target='_self'; document.form1.limaud.value=0; document.form1.action='register_aud.php'; document.form1.submit()" />                          
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> - Pag:</span><?= $cadenapaginas?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                <tr class="letra6bold">
                                                    <td width="5%" align="center">Id</td>
                                                    <td width="15%" align="center">Fecha</td>
                                                    <td width="15%" align="left">Usuario</td>
                                                    <td width="15%" align="left">Modulo</td>
                                                    <td width="50%" align="left">Descripción</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td align="center"><?= $a_id[$i]?></td>
                                                    <td align="center"><?= $dsup->getFechaHoraNormal($a_fec[$i])?></td>
                                                    <td align="left"><?= $a_usu[$i]?></td>
                                                    <td align="left"><?= $a_mod[$i]?></td>
                                                    <td align="left"><?= $a_des[$i]?></td>
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
        <td>&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>



<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/usuarios.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();
$ssql="select * from usuarios";
$condicion="";
if($condicion!="")
    $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
$ssql.="$condicion order by apellido, nombre limit $limusu,".$cfg->getLimmax();
//echo $ssql;
$adm=new usuarios_2($ssql);
$a_id=$adm->getId();
$a_ape=$adm->getApellido();
$a_nom=$adm->getNombre();
$a_ema=$adm->getEmail();
$a_niv=$adm->getNivel();
$a_cen=$adm->getCentronom();
$a_srv=$adm->getServidorafip();
$cantidadtotal=$adm->getMaxRegistros();

$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limusu)
    $cadenapaginas.="- <a href='javascript: document.form1.target=\"_self\"; document.form1.limusu.value=$ini; document.form1.action=\"tbt_jug.php\"; document.form1.submit()' class='can'>$j</a>";
  else
    $cadenapaginas.="- <span class='letra6bold'>$j</span></a>";
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
	z-index:2;
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
        <input name="idm" type="hidden" id="idm" value="0" />
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="limusu" type="hidden" id="limusu" value="<?= $limusu?>" />
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">USUARIOS</h3>                
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> - Pag: </span><?= $cadenapaginas?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr>
                                                    <td width="10%"><a href="javascript: document.form1.target='_self'; document.form1.tarea.value='A'; document.form1.action='planb_usr_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Usuario" title="Agregar Usuario"></i></a></td>
                                                    <td width="30%">Nombre</td>
                                                    <td width="30%">Email</td>
                                                    <td width="20%">Centro</td>
                                                    <td width="5%" align="center">Nivel</td>
                                                    <td width="5%" align="center">Srv</td>
                                                    <td width="2%">&nbsp;</td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.action='planb_usr_pwd.php'; document.form1.submit()"><i class="fas fa-key fa-lg" alt="Modifica Clave" title="Modifica Clave"></i></a> 
                                                        <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='planb_usr_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Usuario" title="Modifica Usuario"></i></a> 
                                                    </td>
                                                    <td><?= $a_ape[$i].", ".$a_nom[$i]?></td>
                                                    <td><?= $a_ema[$i]?></td>
                                                    <td><?= $a_cen[$i]?></td>
                                                    <td align="center"><?= $a_niv[$i]?></td>
                                                    <td align="center"><?= $a_srv[$i]?></td>
                                                    <td align="center">
                                                    <? if($usr->getId()!=$a_id[$i]) { ?>
                                                        <a href="javascript: document.form1.target='_self'; bajareg(<?= $a_id[$i]?>,'Elimina Usuario?','planb_usr_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Usuario" title="Elimina Usuario"></i></a>
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
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>

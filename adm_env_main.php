<?
/*
 * Creado el 07/07/2020 12:59:43
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_env_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/adm_env.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();

$ssql="select * from adm_env where fechaing>='$fechainienv' and fechaing<='$fechafinenv'"; 
if($proveedorenv>0)
    $ssql.=" and (idprv=$proveedorenv or idprv1=$proveedorenv or idprv2=$proveedorenv)";
if($articuloenv>0)
    $ssql.=" and idart=$articuloenv";
if($tunelenv!="") $ssql.=" and tunel=$tunelenv";

$tt=new total_env($ssql);

$ssql.=" order by fechaing, id limit $limenv,".$cfg->getLimmax();
//echo $ssql;
$adm=new adm_env_2($ssql);
    
$a_id=$adm->getId();
$a_ida=$adm->getArticulo();
$a_t1=$adm->getTenvasado1();
$a_t2=$adm->getTenvasado2();
$a_t3=$adm->getTenvasado3();
$a_fec=$adm->getFechaing();
$a_idp=$adm->getProveedor();
$a_idp1=$adm->getProveedor1();
$a_idp2=$adm->getProveedor2();
$a_kgd=$adm->getKgdescarte();
$a_lot=$adm->getLote();
$a_can=$adm->getCantidad();
$a_kil=$adm->getKilos();
$a_tun=$adm->getTunel();
$cantidadtotal=$adm->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limenv)
    $cadenapaginas.=" <a href='javascript: document.form1.limenv.value=$ini; document.form1.target=\"_self\"; document.form1.action=\"register_env.php\"; document.form1.submit()' class='letra6'>$j</a>";
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
                <input name="limenv" type="hidden" id="limenv" value="<?= $limenv?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">ENVASADO</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                    Proveedor <select name="proveedorenv" id="proveedorenv" onchange="javascript: document.form1.target='_self'; document.form1.limenv.value=0; document.form1.action='register_env.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, concat_ws(' ', apellido, nombre) as campo from adm_prv where tipo=1 order by apellido, nombre";
                                                        $sup->cargaCombo3($ssql, $proveedorenv, "Todos");
                                                        ?>
                                                    </select> | 
                                                    Artículo <select name="articuloenv" id="articuloenv" onchange="javascript: document.form1.target='_self'; document.form1.limenv.value=0; document.form1.action='register_env.php'; document.form1.submit()">
                                                        <?
                                                        $ssql="select id as id, descripcion as campo from adm_art where envasado=1 order by descripcion";
                                                        $sup->cargaCombo3($ssql, $articuloenv, "Todos");
                                                        ?>
                                                    </select> | 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Fecha desde <input name="fechainienv" id="fechainienv" type="date" value="<?= $fechainienv?>" class="letra6" /> 
                                                    hasta <input name="fechafinenv" id="fechafinenv" type="date" value="<?= $fechafinenv?>" class="letra6" /> | 
                                                    Túnel <input name="tunelenv" id="tunelenv" value="<?= $tunelenv?>" type="text" size="2" maxlength="2" onkeypress="return validar(event)" style="text-align: center" /> | 

                                                    <input name="chkok" id="chkok" type="submit" value="Filtrar" onclick="javascript: document.form1.target='_self'; document.form1.limenv.value=0; document.form1.action='register_env.php'; document.form1.submit()" /> 
                                                    <input name="chkprn" id="chkprn" type="submit" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_env_lst.php'; document.form1.submit()" /> 
                                                    <input name="chkexp" id="chkok" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_env_exp.php'; document.form1.submit()" /> | 
                                                    Kilos: <strong><?= number_format($tt->getKilos(),2)?></strong> | Cajas: <strong><?= number_format($tt->getCantidad(),0)?></strong>
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
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_env_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Envasado" title="Agregar Envasado"></i></a> 
                                                                <a href="javascript: document.form1.tarea.value='A'; document.form1.target='_self'; document.form1.action='adm_env_act_varios.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" style="color: green" alt="Agregar Varios" title="Agregar Varios"></i></a> 
                                                            </td>
                                                            <td width="5%" align="center">ID</td>
                                                            <td width="8%" align="center">Fecha Ing</td>
                                                            <td align="left">Proveedor</td>
                                                            <td align="left">Articulo</td>
                                                            <td width="3%" align="center">T°1</td>
                                                            <td width="3%" align="center">T°2</td>
                                                            <td width="3%" align="center">T°3</td>
                                                            <td width="7%" align="center">Kg Des.</td>
                                                            <td width="10%" align="center">Lote</td>
                                                            <td width="8%" align="center">Cajas o Pencas</td>
                                                            <td width="8%" align="center">Kilos</td>
                                                            <td width="2%" align="center">Tn</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                        <? 
                                                        for($i=0;$i<count($a_id);$i++) { ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                            <td>
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.tarea.value='M'; document.form1.action='adm_env_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Envasado" title="Modifica Envasado"></i></a> 
                                                                <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_env_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" alt="Detalle Envasado" title="Detalle Envasado"></i></a> 
                                                            </td>
                                                            <td align="center"><?= $a_id[$i]?></td>                                                            
                                                            <td align="center"><?= $dsup->getFechaNormalCorta($a_fec[$i])?></td>                                                            
                                                            <td align="left">
                                                                <?
                                                                echo $a_idp[$i];
                                                                if(trim($a_idp1[$i])!="") echo "<br>".$a_idp1[$i];
                                                                if(trim($a_idp2[$i])!="") echo "<br>".$a_idp2[$i];
                                                                ?>
                                                            </td>
                                                            <td align="left"><?= $a_ida[$i]?></td>
                                                            <td align="center"><?= $a_t1[$i]?></td>
                                                            <td align="center"><?= $a_t2[$i]?></td>
                                                            <td align="center"><?= $a_t3[$i]?></td>
                                                            <td align="center"><?= $a_kgd[$i]?></td>
                                                            <td align="center"><?= $a_lot[$i]?></td>
                                                            <td align="center"><?= $a_can[$i]?></td>
                                                            <td align="center"><?= $a_kil[$i]?></td>
                                                            <td align="center"><?= $a_tun[$i]?></td>
                                                            <td align="center"><a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Envasado?','adm_env_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Envasado" title="Elimina Envasado"></i></a></td>
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



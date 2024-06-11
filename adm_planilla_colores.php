<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_col_main.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/support.php';
$sup=new support();
$conx=new conexion();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$conn=$conx->conectarBase();
$columnas=6;
$filas=48;
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
                <input name="limcol" type="hidden" id="limcol" value="<?= $limcol?>" />
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
                                        <h3 class="ui-widget-header ui-corner-all">UBICACIÓN DE PRODUCTOS</h3>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                            <tr>
                                                <td>
                                                  &nbsp;
                                                </td>
                                            </tr>
                                            <tr>
                                                <!--<td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>-->
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" class="letra6">                                    
                                                        <? 
                                                        $ctr=-1;
                                                        for($i=0;$i<$filas;$i++) { 
                                                            $ctr++;
                                                            if($ctr==4) { 
                                                                $ctr=0;                                                            
                                                            ?>
                                                        <tr>
                                                            <td colspan="<?= $columnas?>" style="background-color: grey">&nbsp;</td>
                                                        </tr>
                                                        <? } ?>
                                                        <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                        <? for($d=0;$d<$columnas;$d++) { 
                                                            $ff=intval($i/4);
                                                            $fff=$ff+1;
                                                            $dd=$d+1;
                                                            $cc=4-$ctr;
                                                            $colorcamara="";
                                                            $colorletra="";
                                                            $descripcion="$fff.$dd.$cc";
                                                            $ssql="select adm_prd.* from adm_prd inner join adm_ubi on adm_prd.id=adm_ubi.idart where adm_ubi.posicionx=$fff and adm_ubi.posiciony=$dd and adm_ubi.posicionz=$cc";
//                                                            echo $ssql."<br>";
                                                            if($conx->getCantidadRegA($ssql, $conn)>0) {
                                                                $ra=$conx->consultaBase($ssql, $conn);
                                                                $raa=mysqli_fetch_object($ra);
                                                                $colorcamara=$raa->colorcamara;
                                                                $colorletra=$raa->colorletra;
                                                                $descripcion="$fff.$dd.$cc: ".$raa->descripcion;                                                                
                                                                //if($raa->colorcamara!="#000000") $colorletra=$sup->generar_color($raa->colorcamara);
//                                                                echo $colorletra."<br>";
                                                            }
                                                            ?>                                                        
                                                            <td style="background-color: <?= $colorcamara?>; color: <?= $colorletra?>" width="10%" align="center">
                                                                <?= utf8_decode($descripcion);
                                                                
                                                                //echo $fff." $dd $cc";?>
                                                            </td>                                                        
                                                        <? } ?>
                                                        </tr>
                                                        <?}?>
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



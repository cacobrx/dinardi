<?php
/*
 * Creado el 25/10/2018 12:23:39
 * Autor: gus
 * Archivo: adm_carga_arba.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cli.php';
require_once 'clases/adm_prv.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$id=$glo->getGETPOST("id");
$botoncap="Importar!";
$fecha=date("Y-m-d");
$dir="arba";
$seperador=";";
$rep=opendir($dir);
$aaa=array();
while($arc=readdir($rep)) {
    if($arc!=".." and $arc!="." and $arc!="") 
        array_push($aaa,$arc);
}
closedir($rep);
clearstatcache();

$archivo=$glo->getGETPOST("archivo");
$tipo=$glo->getGETPOST("tipo");
$primero=$glo->getGETPOST("primero");
$archivofin="arba/$archivo";
$cnt=0;
$x_id=array();
//echo $destino."<br>";
//echo "existe: $archivo ".file_exists($archivo)."<br>";
if($primero==1) {
    if (file_exists($archivofin)) { 
        $lines=file($archivofin);
//        echo "ccc: ".count($lines);
        $a_cuit=array();
        $a_importe=array();
        foreach ($lines as $line_num => $line) {
            $datos=explode(";", $line);
            array_push($a_cuit,$datos[4]);
            array_push($a_importe,$datos[8]);
        }
//        print_r($a_importe);

        if($tipo==1) {
            $ssql="select * from adm_cli order by apellido, nombre";
            $cli=new adm_cli_2($ssql);
            $x_id=$cli->getId();
            $x_ape=$cli->getApellido();
            $x_nom=$cli->getNombre();
            $x_cuit=$cli->getCuit();

        } else {
            $ssql="select * from adm_prv order by apellido, nombre";
            $prv=new adm_prv_2($ssql);
            $x_id=$prv->getId();
            $x_ape=$prv->getApellido();
            $x_nom=$prv->getNombre();
            $x_cuit=$prv->getCuit();
        }
        $x_imp=array();
        for($i=0;$i<count($x_id);$i++) {
            $search= array_search($x_cuit[$i], $a_cuit);
            if($search!==false)
                array_push($x_imp,$a_importe[$search]);
            else
                array_push($x_imp,"");
        }
    }
}


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
<script src="js/jquery-1.3.2.js" type="text/javascript"></script>
<script src="js/vanadium.js" type="text/javascript"></script>
<script language="javascript">
var VanadiumRules = {
	archivo: ['required', 'only_on_submit']
}
</script>


</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form action="adm_carga_arba_save.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <tr>
        <? include("adm_menu.php") ?>
        <input name="primero" id="primero" value="1" type="hidden" />
    </tr> 
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">        
                <? require_once "displayusuario.php";?>        
                <tr>
                    <td>
                        <div class="panel960 letra6">
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">IMPORTAR ARCHIVOS ARBA</h3>                      
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td width="35%"><div align="right">Tipo&nbsp;</div></td>
                                        <td width="65%">
                                            <select name="tipo" id="tipo">
                                                <?
                                                $array=array("Percepciones", "Retenciones");
                                                $avalor=array(1,2);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipo);
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">Archivo&nbsp;</td>
                                        <td>
                                            <select name="archivo" id="archivo">
                                                <? 
                                                $sup->cargaComboArrayValor($aaa, $aaa, $archivo, "Sel") ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>                                        
                                    <tr>
                                        <td colspan="2" align="center">
                                            <input type="submit" name="Submit" value="<?= $botoncap?>" /> 
                                            <input type="submit" name="cmdver" id="cmdver" value="Verificar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_carga_arba.php'; document.form1.submit()" />
                                        </td>
                                    </tr>
                                    <? if($primero==1) { ?>
                                    <tr>
                                        <td colspan="2"><hr></hr></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0">
                                                <tr class="letra6Bold">
                                                    <td width="5%" align="center">ID</td>
                                                    <td width="50%">
                                                        <? if($tipo==1) echo "Cliente"; else echo "Proveedor";?>
                                                    </td>
                                                    <td width="10%" align="right">
                                                        <? if($tipo==1) echo "Percepción"; else echo "Retención";?>
                                                    </td>
                                                    <td width="35%">&nbsp;</td>
                                                </tr>
                                                <? for($i=0;$i<count($x_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra3">
                                                    <td align="center"><?= $x_id[$i]?></td>
                                                    <td><?= $x_ape[$i]." ".$x_nom[$i]?></td>
                                                    <td align="right"><?= $x_imp[$i]?></td>
                                                </tr>
                                                <? } ?>
                                            </table>
                                        </td>
                                    </tr>
                                    <? } ?>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>                                  
            </table>
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
    </tr>
</form>
</div>
</body>
</html>
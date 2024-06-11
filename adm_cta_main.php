<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/adm_cta.php");
require_once 'clases/datesupport.php';
require_once 'clases/support.php';
$sup=new support();
$dsup=new datesupport();
$glo=new globalson();
$cfg=new planb_config_1($centrosel);
$ssql="select * from adm_cta where centro=$centrosel";
if($textocta!="") 
    $ssql.=" and (instr(upper(nombre),'".strtoupper($textocta)."')>0 or instr(codigo,'$textocta')>0)";
$ssql.=" order by codigo limit $limcta,".$cfg->getLimmax();
//echo $ssql."<br>";
$cta=new adm_cta_2($ssql);
$a_id=$cta->getId();
$a_nom=$cta->getNombre();
$a_tip=$cta->getTipodes();
$a_cod=$cta->getCodigo();
$a_del=$cta->getOkborrar();
$cantidadtotal=$cta->getMaxRegistros();
$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
    $ini=($i)*$cfg->getLimmax();
    $j=$i+1;
    if($ini!=$limcta)
        $cadenapaginas.="- <a href='javascript: document.form1.target=\"_self\"; document.form1.limcta.value=$ini; document.form1.action=\"register_cta.php\"; document.form1.submit()' class='can'>$j</a>";
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
	/*visibility:hidden;*/
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:960px;
	height:75px;
	z-index:2;
	margin-left: -480px;
	/*visibility:hidden;*/
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
        <input name="tarea" type="hidden" id="tarea" />
        <input name="limcta" type="hidden" id="limcta" value="<?= $limcta?>" />
        <input name="marcar" type="hidden" id="marcar" value="0" />
        <input name="cantidadtotal" type="hidden" id="cantidadtotal" value="<?= count($a_id)?>" />    
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require("displayusuario.php");?>   
                <tr>
                    <td>
                        <div class="panel960 letra6">                                
                            <div id="effect-panel960" class="ui-widget-content ui-corner-all">                                    
                                <h3 class="ui-widget-header ui-corner-all">PLAN DE CUENTAS</h3>
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="letra6">
                                    <tr>
                                        <td>
                                            Texto <input name="textocta" id="textocta" type="text" class="letra6" value="<?= $textocta?>" /> | 
                                            <input name="cmdok" id="cmdok" type="submit" value="Filtrar" onclick="document.form1.target='_self'; document.form1.limcta.value=0; document.form1.action='register_cta.php'; document.form1.submit()" /> 
                                            <input name="cmdprint" id="cmdprint" type="submit" value="Imprimir" onclick="document.form1.target='_blank'; document.form1.action='adm_cta_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexp" id="cmdexp" type="submit" value="Exportar" onclick="document.form1.target='_self'; document.form1.action='adm_cta_exp.php'; document.form1.submit()" /> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: </span><?= $cantidadtotal?><span class="letra6"> | Pag: </span><?= $cadenapaginas?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="5%">
                                                        <a href="javascript: document.form1.tarea.value='A'; document.form1.action='adm_cta_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Cuenta" title="Agregar Cuenta"></i></a> 
                                                    </td>
                                                    <td width="20%">Código</td>
                                                    <td>Nombre</td>
                                                    <td width="10%">Tipo</td>
                                                    <td width="5%"></td>
                                                </tr>
                                                <? for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')">
                                                    <td>
                                                        <a href="javascript: document.form1.target='_self'; document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_cta_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" alt="Modifica Cuenta" title="Modifica Cuenta"></i></a> 
                                                    </td>
                                                    <td><?= $a_cod[$i]?></td>
                                                    <td><?= $a_nom[$i]?></td>
                                                    <td><?= $a_tip[$i]?></td>
                                                    <td align="right">
                                                        <? if($a_del[$i]==1) { ?>
                                                        <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Cuenta?','adm_cta_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Cuenta" title="Elimina Cuenta"></i></a>                  
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
        <td>&nbsp;</td>
    </tr>
</form>
</div>
</body>
</html>

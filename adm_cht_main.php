<?
//session_start();
//print_r($_POST);
require("user.php");
//print_r($_SESSION);
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/centro.php';
require_once 'clases/support.php';
require_once 'clases/util.php';
require_once 'clases/adm_cht.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_cht.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$limmax=$cfg->getLimmax();
if($limcht=="")
    $limcht=0;
if($chkfechacht=="" and $primerocht=="") {
    $chkfechacht=1;
    $primerocht=1;
}
$hoy=date("Y-m-d");
if($fechainicht=="")
    $fechainicht=date("Y-m-")."01";
if($fechafincht=="")
    $fechafincht=date("Y-m-d", strtotime("$hoy + 30 days"));
if($camposelcht=="")
    $camposelcht="id";
if($tipofechacht=="")
    $tipofechacht=1;
if($tipofechacht==1)
    $campofechacht="fechapago";
else
    $campofechacht="fechaorigen";


//$campofecha="id";
$campoorden="id";
//$ntex=strlen($campo);
$stot="select sum(importe) as totalimporte from adm_cht";
$ssql="select * from adm_cht";
$condicion="centro=$centrosel and ";
if($tipocht==1)
    $condicion.="tipo=1 and ";
if($tipocht==2)
    $condicion.="tipo=2 and ";
switch($filtrocht) {
    case 0: // en cartera
        $condicion.="(entregado='' or entregado is null) and fechaacr is null and ";
        break;
    case 1: // acreditados
        $condicion.="($campofechacht >='$fechainicht' and $campofechacht<='$fechafincht' and fechaacr is not null) and ";
        break;
    case 2: // entregados
        $condicion.="($campofechacht >='$fechainicht' and $campofechacht<='$fechafincht' and entregado!='') and ";
        break;
    case 3: // todos
        $condicion.="($campofechacht >='$fechainicht' and $campofechacht<='$fechafincht') and ";
        break;
}
if($campocht!="") {
    if($camposelcht=='id')
        $condicion.="$camposelcht=$campocht and ";
    else
        $condicion.="instr($camposelcht,'".$campocht."')>0 and ";
}
if($bancocht>0) $condicion.="idbanco=$bancocht and ";
if($condicion!="") {
    $condicion=substr($condicion,0,strlen($condicion)-5);
    $ssql.=" where $condicion";
    $stot.=" where $condicion";
}
$ssql.=" order by $campoorden limit $limcht,$limmax";
$rs=$conx->getConsulta($stot);
//echo $stot."<br>";
$rre=mysqli_fetch_object($rs);
$total=$rre->totalimporte;
//echo $ssql."<br>";
$cht=new adm_cht_2($ssql);
$a_id=$cht->getId();
$a_fori=$cht->getFechaorigen();
$a_fven=$cht->getFechapago();
$a_ban=$cht->getBancodes();
$a_nro=$cht->getNrocheque();
$a_nom=$cht->getNombre();
$a_acr=$cht->getAcreditado();
$a_imp=$cht->getImporte();
$a_cli=$cht->getCliente();
$a_ent=$cht->getEntregado();
$a_col=$cht->getColor();
$a_bac=$cht->getBackcolor();
$a_dias=$cht->getDias();
$a_fea=$cht->getFechaacr();
$cantidadtotal=$cht->getMaxRegistros();

$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limcht)
    $cadenapaginas.="- <a href='javascript: document.form1.limcht.value=$ini; document.form1.action=\"register_cht.php\"; document.form1.submit()' class='can'>$j</a>";
  else
    $cadenapaginas.="- <span class='letra2'>$j</span></a>";
}
$cadenapaginas=substr($cadenapaginas,1,strlen($cadenapaginas)-1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
	width:<?= $_SESSION['anchopantalla']+10?>px;
	height:75px;
	z-index:1;
	margin-left: -<?= $_SESSION['anchopantalla']/2?>px;
        /*visibility: hidden;*/
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
        <input name="limcht" type="hidden" id="limcht" value="<?= $limcht?>" />
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="idche" type="hidden" id="idche" value="0" />
        <input name="filtrocht" id="filtrocht" type="hidden" value="<?= $filtrocht?>" />
        <input name="id" type="hidden" id="id" value="0" />
        <input name="cantidadact" id="cantidadact" type="hidden" value="<?= count($a_id)?>" />        
        <input name="primerocht" type="hidden" id="primerocht" value="<?= $primerocht?>" />
    </tr> 
    
<tr>
    <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <? require_once 'displayusuario.php'?> 
                <tr>
                    <td>
                        <div class="panelmax letra6">
                            <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">CHEQUES DE TERCEROS</h3>              
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td>                                  
                                            <select name="tipofechacht" id="tipofechacht">
                                                <?
                                                $array=array("Vencimiento", "Origen");
                                                $avalor=array(1,2);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipofechacht);
                                                ?>
                                            </select> 
                                            desde <input name="fechainicht" type="date" class="letra6" id="fechainicht" value="<?= $fechainicht?>" /> 
                                            hasta <input name="fechafincht" type="date" class="letra6" id="fechafincht" value="<?= $fechafincht?>" /> | 
                                            <select name="camposelcht" id="camposelcht">
                                                <?
                                                $array=array("ID", "Nro Cheque");
                                                $avalor=array("id", 'nrocheque');
                                                $sup->cargaComboArrayValor($array, $avalor, $camposelcht);
                                                ?>
                                            </select> 
                                            <input name="campocht" type="text" id="campocht" size="10" value="<?= $campocht?>"> | 
                                            <input type="checkbox" name="chkfechacht" id="chkfechacht" value="1" onClick= "document.form1.action='register_cht.php'; document.form1.target='_self'; document.form1.limcht.value=0; document.form1.submit()" <? if($chkfechacht==1) echo "checked='checked'";?> /> 
                                            Busca x Fecha | 
                                            Banco <select name="bancocht" id="bancocht" onchange="javascript: document.form1.target='_self'; document.form1.limcht.value=0; document.form1.action='register_cht.php'; document.form1.submit()">
                                                <?
                                                $ssql="select valor as id, descripcion as campo from tablas where codtab='BAN' order by descripcion";
                                                $sup->cargaCombo3($ssql, $bancocht, "Todos");
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="javascript: document.form1.filtrocht.value=0; document.form1.limcht.value=0; document.form1.action='register_cht.php'; document.form1.submit()"><? if($filtrocht==0) echo "<span style=\"background-color: ".$cfg->getColor1()."; color: white; font-weight: bold\">";?>en Cartera<? if($filtrocht==0) echo "</span>";?></a> | 
                                            <a href="javascript: document.form1.filtrocht.value=1; document.form1.limcht.value=0; document.form1.action='register_cht.php'; document.form1.submit()"><? if($filtrocht==1) echo "<span style=\"background-color: ".$cfg->getColor1()."; color: white; font-weight: bold\">";?>Acreditados<? if($filtrocht==1) echo "</span>";?></a> | 
                                            <a href="javascript: document.form1.filtrocht.value=2; document.form1.limcht.value=0; document.form1.action='register_cht.php'; document.form1.submit()"><? if($filtrocht==2) echo "<span style=\"background-color: ".$cfg->getColor1()."; color: white; font-weight: bold\">";?>Entregados<? if($filtrocht==2) echo "</span>";?></a> | 
                                            <a href="javascript: document.form1.filtrocht.value=3; document.form1.limcht.value=0; document.form1.action='register_cht.php'; document.form1.submit()"><? if($filtrocht==3) echo "<span style=\"background-color: ".$cfg->getColor1()."; color: white; font-weight: bold\">";?>Todos los Cheques<? if($filtrocht==3) echo "</span>";?></a>
                                             |  Total $<strong> <?= number_format($total,2)?></strong> | 
                                            <input type="submit" name="Submit" value="Filtrar"  onClick= "document.form1.target='_self'; document.form1.limcht.value=0; document.form1.action='register_cht.php'; document.form1.submit()" /> 
                                            <input type="submit" name="cmdprn" id="cmdprn" value="Imprimir" onclick="javascript: document.form1.target='_blank'; document.form1.action='adm_cht_prn.php'; document.form1.submit()" /> 
                                            <input name="cmdexc" id="cmdexc" type="submit" value="Exportar" onclick="javascript: document.form1.target='_self'; document.form1.action='adm_cht_exp.php'; document.form1.submit()" /> | 
                                            <input type="submit" name="Submit" value="Entregado" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_cht_entregados.php'; document.form1.submit()" />
                                            <input type="submit" name="Submit" value="Acreditado" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_cht_acreditados.php'; document.form1.submit()" />
                                        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="letra6bold">
                                        </td>
                                    </tr>                                    
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: <?= $cantidadtotal?> - Pag:</span> <span class="lnk"><?= $cadenapaginas?></span></td>                      
                                    </tr>            
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">                      
                                                    <td width="4%">
                                                        <a href="javascript: document.form1.tarea.value='A'; document.form1.action='adm_cht_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Cheque" title="Agregar Cheque"></i></a>                          
                                                        <a href="#" onclick="javascript: marcar_desmarcar('chek', <?= count($a_id)?>)"><i class="far fa-check-circle fa-lg"></i></a>
                                                    </td>
                                                    <td width="4%" align="center">Id</td>
                                                    <td width="6%" align="center">F.Origen</td>
                                                    <td width="6%" align="center">F.Vencim</td>
                                                    <td width="6%" align="center">F.Acreditado</td>
                                                    <td width="3%" align="center">D</td>
                                                    <td width="15%">Banco</td>
                                                    <td width="10%">Nro.Cheque</td>
                                                    <td width="16%">Nombre</td>
                                                    <td width="20%">Cliente</td>
                                                    <td width="13%" align="left">Entregado</td>                                          
                                                    <td width="8%" align="right">Importe</td>
                                                    <td width="2%">&nbsp;</td>
                                                </tr>
                                                <?for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" style="color: <?= $a_col[$i]?>; background-color: <?= $a_bac[$i]?>">
                                                    <td>
                                                        <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: document.form1.idche.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_cht_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg" <? // if($a_bac[$i]=="#000000") echo "style=\"color: white\"";?> alt="Modifica Cheque" title="Modifica Cheque"></i></a>                            
                                                        <input name="chek<?= $i?>" id="chek<?= $i?>" type="checkbox" value="<?= $a_id[$i]?>" /> 
                                                        
                                                        
                                                            <? } ?>
                                                        <!--<a href="javascript: document.form1.idche.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_cht_det.php'; document.form1.submit()"><i class="fas fa-file-alt fa-lg" <? // if($a_bac[$i]=="#000000") echo "style=\"color: white\"";?> alt="Detalle Cheque" title="Detalle Cheque"></i></a>--> 
                                                        <!--<a href="javascript: document.form1.idche.value=<?= $a_id[$i]?>; document.form1.target='_self'; document.form1.action='adm_cht_img.php'; document.form1.submit()"><i class="fas fa-images fa-lg" <? // if($a_bac[$i]=="#000000") echo "style=\"color: white\"";?> title="Imagen del Cheque" alt="Imagen del Cheque"></i></a>-->                                                                                                                
                                                        <td><div align="center"><?= $a_id[$i]?></div></td>
                                                        <td><div align="center"><?= $dsup->getFechaNormalCorta($a_fori[$i])?></div></td>
                                                        <td><div align="center"><?= $dsup->getFechaNormalCorta($a_fven[$i])?></div></td>
                                                        <td><div align="center"><?= $dsup->getFechaNormalCorta($a_fea[$i])?></div></td>
                                                        <td align="center"><?= $a_dias[$i]?></td>
                                                        <td><?= $a_ban[$i]?></td>
                                                        <td><?= $a_nro[$i]?></td>
                                                        <td><?= $a_nom[$i]?></td>
                                                        <td align="left"><?= $a_cli[$i]?></td>
                                                        <td align="left"><?= $a_ent[$i]?></td>                                                     
                                                        <td><div align="right">$<?= number_format($a_imp[$i],2)?></div></td>
                                                        <td align="right">
                                                             <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Cheque?','adm_cht_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Cheque" title="Elimina Cheque" width="12" height="12"  border="0"></i></a>
                                                    </td>
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
                <tr>
                  <td>&nbsp;</td>
               </tr>
            </table>
        </td>
    </tr>   
</form>
</div>
</body>
</html>

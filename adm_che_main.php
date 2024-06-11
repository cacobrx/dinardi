<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/datesupport.php");
require_once 'clases/centro.php';
require_once 'clases/support.php';
require_once 'clases/util.php';
require_once 'clases/adm_che.php';
require_once 'clases/conexion.php';
$conx=new conexion();
$utl=new util();
$sup=new support();
$dsup=new datesupport();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$limmax=$cfg->getLimmax();
$hoy=date("Y-m-d");
if($tipofechache==1)
    $campofecha="fechapago";
else
    $campofecha="fechaorigen";

$condicion="";
switch($filtroche) {
case 1:
    $condicion.="$campofecha>='$fechainiche' and $campofecha<='$fechafinche' and fechadeb is not null and ";
    break;
case 2:
    $condicion.="$campofecha>='$fechainiche' and $campofecha<='$fechafinche' and ";
    break;
default:
    $condicion.="fechadeb is null and ";
    break;
}
if($campoche!="")
    $condicion.="(instr(nrocheque,'$campoche')>0 or instr(upper(destinatario), '".strtoupper($campoche)."')>0 or instr(upper(referencia), '".strtoupper($campoche)."')>0) and ";
if($tipoche>0)
    $condicion.="tipo=$tipoche and ";
if($condicion!="") $condicion=" where ".substr($condicion,0,strlen($condicion)-5);
$stot="select sum(importe) as totalimporte from adm_che $condicion";
$ssql="select * from adm_che $condicion limit $limche, $limmax";

$rs=$conx->getConsulta($stot);
$rre=mysqli_fetch_object($rs);
$total=$rre->totalimporte;
//echo $ssql."<br>";
$che=new adm_che_2($ssql);
$a_id=$che->getId();
$a_fori=$che->getFechaorigen();
$a_fven=$che->getFechapago();
$a_ban=$che->getBancodes();
$a_nro=$che->getNrocheque();
$a_des=$che->getDestinatario();
$a_acr=$che->getAcreditado();
$a_imp=$che->getImporte();
$a_ref=$che->getReferencia();
$a_fed=$che->getFechadeb();
$a_ent=$che->getEntregado();

$cantidadtotal=$che->getMaxRegistros();

$paginas=(int)($cantidadtotal / $cfg->getLimmax());    
if ($paginas==$cantidadtotal/$cfg->getLimmax()) {
  $paginas=$paginas-1;
}
$cadenapaginas="";
for ($i=0;$i<=$paginas;$i++) {
  $ini=($i)*$cfg->getLimmax();
  $j=$i+1;
  if($ini!=$limche)
    $cadenapaginas.="- <a href='javascript: document.form1.target=\"_self\"; document.form1.limche.value=$ini; document.form1.action=\"register_che.php\"; document.form1.submit()' class='can'>$j</a>";
  else
    $cadenapaginas.="- <span class='letrabold'>$j</span></a>";
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
        <input name="limche" type="hidden" id="limche" value="<?= $limche?>" />
        <input name="tarea" type="hidden" id="tarea" value="A" />
        <input name="id" type="hidden" id="id" value="0" />
        <input name="filtroche" id="filtroche" type="hidden" value="<?= $filtroche?>" />
        <input name="cantidadact" id="cantidadact" type="hidden" value="<?= count($a_id)?>" />
        
        <? if($filtroche==1 or $filtroche==2) { ?>
        <input name="fechainiche" id="fechainiche" type="hidden" value="<?= $fechainiche?>" />
        <input name="fechafinche" id="fechafinche" type="hidden" value="<?= $fechafinche?>" />
        <? } ?>
    </tr>
    
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <? require_once 'displayusuario.php';?>
                <tr>
                    <td>
                        <div class="panelmax letra6">
                            <div id="effect-panelmax" class="ui-widget-content ui-corner-all">
                                <h3 class="ui-widget-header ui-corner-all">CHEQUES PROPIOS</h3>              
                                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td>
                                            <? if($filtroche==1 or $filtroche==2) { ?>
                                            <select name="tipofechache" id="tipofechache">
                                                <?
                                                $array=array("Vencimiento", "Origen");
                                                $avalor=array(1,2);
                                                $sup->cargaComboArrayValor($array, $avalor, $tipofechache);
                                                ?>
                                            </select>
                                            desde <input name="fechainiche" type="date" class="letra6" id="fechainiche" value="<?= $fechainiche?>" /> hasta <input name="fechafinche" type="date" class="letra6" id="fechafinche" value="<?= $fechafinche?>" /> 
                                            <? } else { ?>
                                                <input name="fechainiche" id="fechainiche" type="hidden" value="<?= $fechainiche?>" />
                                                <input name="fechafinche" id="fechafinche" type="hidden" value="<?= $fechafinche?>" />
                                            <? } ?>

                                            Texto <input name="campoche" type="text" id="campoche" size="10" value="<?= $campoche?>" /> 
                                             | 
                                            <input type="submit" name="Submit" value="Filtrar" onClick="javascript: document.form1.target='_self'; document.form1.limche.value=0; document.form1.action='register_che.php'; document.form1.submit()" />
                                            <input type="submit" name="Submit" value="Imprimir" onClick="javascript: document.form1.target='_blank'; document.form1.action='adm_che_prn.php'; document.form1.submit()" />
                                            <input type="submit" name="Submit" value="Exportar" onClick="javascript: document.form1.target='_self'; document.form1.action='adm_che_exp.php'; document.form1.submit()" /> | 
                                            <input type="submit" name="Submit" value="Fecha Deb." onClick="javascript: document.form1.target='_self'; document.form1.action='adm_che_debito.php'; document.form1.submit()" /> | 
                                            <a href="javascript: document.form1.target='_self'; document.form1.limche.value=0; document.form1.filtroche.value=0; document.form1.action='register_che.php'; document.form1.submit()"><? if($filtroche==0) echo "<span style=\"background-color: ".$cfg->getColor1()."; color: white; font-weight: bold\">";?>No Debitados<? if($filtroche==0) echo "</span>";?></a> | 
                                            <a href="javascript: document.form1.target='_self'; document.form1.limche.value=0; document.form1.filtroche.value=1; document.form1.action='register_che.php'; document.form1.submit()"><? if($filtroche==1) echo "<span style=\"background-color: ".$cfg->getColor1()."; color: white; font-weight: bold\">";?>Debitados<? if($filtroche==1) echo "</span>";?></a> | 
                                            <a href="javascript: document.form1.target='_self'; document.form1.limche.value=0; document.form1.filtroche.value=2; document.form1.action='register_che.php'; document.form1.submit()"><? if($filtroche==2) echo "<span style=\"background-color: ".$cfg->getColor1()."; color: white; font-weight: bold\">";?>Todos<? if($filtroche==2) echo "</span>";?></a> |                                            
                                            Total $ <span class="letra6bold"><?= number_format($total,2)?></span>                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ui-widget-header ui-corner-all"><span class="letra6">Cantidad: <?= $cantidadtotal?> - Pag:</span> <span class="lnk"><?= $cadenapaginas?></span></td>                      
                                    </tr>            
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellpadding="2" cellspacing="0" class="letra6">
                                                <tr class="letra6bold">
                                                    <td width="5%">
                                                        <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: document.form1.tarea.value='A'; document.form1.action='adm_che_act.php'; document.form1.submit()"><i class="fas fa-plus-circle fa-lg" alt="Agregar Cheque" title="Agregar Cheque"></i></a> 
                                                        <? } ?>
                                                        <a href="#" onclick="javascript: marcar_desmarcar('chek', <?= count($a_id)?>)"><i class="far fa-check-circle fa-lg"></i></a>
                                                    </td>
                                                    <td width="5%" align="center">Id</td>
                                                    <td width="6%" align="center">F.Origen</td>
                                                    <td width="6%" align="center">F.Vencim</td>
                                                    <td width="6%" align="center">F.Deb</td>
                                                    <td width="14%">Banco</td>
                                                    <td width="8%">Nro.Cheque</td>
                                                    <td>Destinatario</td>
                                                    <td width="2%" align="center">Ent</td>
                                                    <td width="15%">Referencia</td>                                                   
                                                    <td width="10%" align="right">Importe</td>
                                                    <td width="2%">&nbsp;</td>
                                                </tr>
                                                <? 
                                                for($i=0;$i<count($a_id);$i++) { ?>
                                                <tr onMouseOver="overTR(this,'<?= $cfg->getColorbarra()?>')" onMouseOut="overTR(this,'#ffffff')" class="letra3">
                                                    <td>
                                                    <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: document.form1.id.value=<?= $a_id[$i]?>; document.form1.tarea.value='M'; document.form1.action='adm_che_act.php'; document.form1.submit()"><i class="fas fa-edit fa-lg"  alt="Modifica Cheque" title="Modifica Cheque"></i></a>
                                                        <input name="chek<?= $i?>" id="chek<?= $i?>" type="checkbox" value="<?= $a_id[$i]?>" /> 
                                                    <? } 
                                                    if($a_acr[$i]==1) { ?>
                                                        <strong>A</strong>
                                                    <? } ?>
                                                    </td>
                                                    <td align="center"><?= $a_id[$i]?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fori[$i])?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fven[$i])?></td>
                                                    <td align="center"><?= $dsup->getFechaNormalCorta($a_fed[$i])?></td>
                                                    <td><?= $a_ban[$i]?></td>
                                                    <td><?= $a_nro[$i]?></td>
                                                    <td><?= $a_des[$i]?></td>
                                                    <td align="center">
                                                        <? if($a_ent[$i]==1) { ?>
                                                        <i class="far fa-check-circle fa-lg"></i>
                                                        <? } ?>
                                                    </td>
                                                    <td><?= $a_ref[$i]?></td>                                                  
                                                    <td align="right">$<?= number_format($a_imp[$i],2)?></td>
                                                    <td align="center">
                                                        <? if($usr->getNivel()<2) { ?>
                                                        <a href="javascript: bajareg(<?= $a_id[$i]?>,'Elimina Cheque?','adm_che_del.php')"><i class="fas fa-trash-alt fa-lg" style="color: #BB0000" alt="Elimina Cheque" title="Elimina Cheque" width="12" height="12"  border="0"></i></a>
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

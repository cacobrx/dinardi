<?
require("user.php");
require_once("clases/globalson.php");
require_once("clases/planb_config.php");
require_once("clases/support.php");
require_once 'clases/datesupport.php';
require_once 'clases/adm_cht.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);

$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$tarea=$glo->getGETPOST("tarea");
$idche=$glo->getGETPOST("idche");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$tipofecha=$glo->getGETPOST("tipofecha");
$criterio=$glo->getGETPOST("criterio");
$campo=$glo->getGETPOST("campo");
$filtro=$glo->getGETPOST("filtro");
if($lim=="")
  $lim=0;
$carteltarea="Detalle Cheque Terceros";
$botoncap="Modificar!";
$cht=new adm_cht_1($idche);
$fechaorigen=$dsup->getFechaNormalCorta($cht->getFechaorigen());
$bancodes=$cht->getBancodes();
$nrocheque=$cht->getNrocheque();
$fechapago=$dsup->getFechaNormalCorta($cht->getFechapago());
$cliente=$cht->getCliente();
$nombre=$cht->getNombre();
$importe=$cht->getImporte();
//$entregado=$cht->getEntregadoo();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
	width:700px;
	height:75px;
	z-index:1;
	margin-left: -500px;
        /*visibility: hidden;*/
}

-->
</style>
<link href="css.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="style1" id="barblue">
  <blockquote>
    <p class="titulo1"><?= $cfg->getCabecera()?></p>
  </blockquote>
</div>
<div id="barcentral">
<form name="form1" id="form1" action="hpa_cht_act_save.php" method="post">
  <table>
    <tr>
    <? include("adm_menu.php") ?>
      </tr>
    
    <tr>
      <td colspan="2"><table width="1000" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td width="498"><div align="left"><span class="letra2">Usuario</span> <span class="letraverde">
            <?= $usr->getNombre()." ".$usr->getApellido()?>
            </span>
          </div></td>
          <td width="496"><div align="right"><span class="letra2">Centro </span><span class="letraverde">
            <?= $cen->getNombre()?>
          </span></div></td>
        </tr>
        
        <tr>
          <td colspan="2"><table width="50%" border="0" align="center" cellpadding="0" cellspacing="2" class="letra2">
            <tr>
              <td bgcolor="<?= $cfg->getColor2()?>"><div align="center" class="titulo1"><?= $carteltarea?>
                <input name="idche" type="hidden" id="idche" value="<?= $idche?>" />
                <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
                <input name="lim" type="hidden" id="lim" value="<?= $lim?>" />
                <input name="fechaini" type="hidden" id="fechaini" value="<?= $fechaini?>" />
                <input name="fechafin" type="hidden" id="fechafin" value="<?= $fechafin?>" />
                <input name="tipofecha" id="tipofecha" type="hidden" value="<?= $tipofecha?>" />
                <input name="campo" id="campo" type="hidden" value="<?= $campo?>" />
                <input name="filtro" id="filtro" type="hidden" value="<?= $filtro?>" />
                <input name="criterio" id="criterio" type="hidden" value="<?= $criterio?>" />
              </div></td>
              </tr>
            
            <tr>
              <td><table width="100%" border="1" cellpadding="0" cellspacing="0" class="letra3" rules="none" bordercolor="<?= $cfg->getColor2()?>">
                
                <tr>
                  <td><table width="100%" border="0" cellpadding="0" cellspacing="1" class="letra3">
                      
                    <tr>
                        <td width="35%"><div align="right">Fecha Origen&nbsp;</div></td>
                        <td width="65%" class="letra6bold"><?= $fechaorigen?></td>
                    </tr>
                    <tr>
                      <td><div align="right">Fecha Vencimiento&nbsp;</div></td>
                      <td class="letra6bold"><?= $fechapago?></td>
                    </tr>
                    <tr>
                      <td><div align="right">Banco&nbsp;</div></td>
                      <td class="letra6bold"><?= $bancodes?></td>
                    </tr>
                    <tr>
                      <td><div align="right">Nro Cheque&nbsp;</div></td>
                      <td class="letra6bold"><?= $nrocheque?></td>
                    </tr>
                    <tr>
                      <td><div align="right">Nombre&nbsp;</div></td>
                      <td class="letra6bold"><?= $nombre?></td>
                    </tr>
                    <tr>
                        <td><div align="right">Cliente&nbsp;</div></td>
                        <td class="letra6bold"><?= $cliente?></td>
                    </tr>
                    <tr>
                        <td><div align="right">Importe&nbsp;</div></td>
                        <td class="letra6bold"><?= $importe?></td>
                    </tr>
                      <tr>
                        <td class="lnk"><div align="right">Entregado&nbsp;</div></td>
                        <td class="letra6bold"><?= $entregado?></td>
                      </tr>
                      <tr>
                      <td class="lnk"><a href="javascript: document.form1.action='hpa_che_main.php'; document.form1.submit()"><img src="images/back.png" width="12" height="12" title="Volver" alt="Volver" /></a></td>
                        <td>&nbsp;</td>
                      </tr>
                  </table></td>
                  </tr>
                
              </table></td>
              </tr>
          </table></td>
          </tr>
        <tr>
          <td colspan="2"><div align="center"></div></td>
          </tr>
      </table></td>
      </tr>
    
    <tr>
      <td colspan="2"><label>
        <div align="center"></div>
      </label></td>
      </tr>
  </table>
</form>
</div>
</body>
</html>

<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_det.php
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$sup=new support();
$cfg=new planb_config_1($centrosel);
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
if($lim=="")
  $lim=0;
$carteltarea="Detalle Compras";
require_once 'clases/adm_com.php';
$botoncap="Modificar!";
$adm=new adm_com_1($id);
$id=$adm->getId();
  $fecha=$adm->getFecha();
  $letra=$adm->getLetra();
  $ptovta=$adm->getPtovta();
  $cainro=$adm->getCainro();
  $numero=$adm->getNumero();
  $idprv=$adm->getIdprv();
  $neto21=$adm->getNeto21();
  $neto10=$adm->getNeto10();
  $neto27=$adm->getNeto27();
  $iva21=$adm->getIva21();
  $iva10=$adm->getIva10();
  $iva27=$adm->getIva27();
  $exento=$adm->getExento();
  $nogravado=$adm->getNogravado();
  $impinternos=$adm->getImpinternos();
  $periva=$adm->getPeriva();
  $retiva=$adm->getRetiva();
  $perretiibb=$adm->getPerretiibb();
  $fechaven=$adm->getFechaven();
  $proveedor=$adm->getProveedor();

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
        //visibility: hidden;
}
#barcentral {
	position:absolute;
	left:50%;
        top:<?= $cfg->getAlturamarco()?>px;
	width:960px;
	height:75px;
	z-index:1;
	margin-left: -480px;
        //visibility: hidden;
}

-->
</style>
<link href="css.css?2.0.1" rel="stylesheet" type="text/css" />
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
  <table>
    <tr>
    <? include("adm_menu.php") ?>
      </tr>
    
    <tr>
      <td colspan="2"><table width="100%" border="0" cellspacing="2" cellpadding="0">
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
          <td colspan="2"><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="letra2">
            <tr>
              <td>
                <div align="center" class="titulo1"><?= $carteltarea?>
                <input name="id" type="hidden" id="id" value="<?= $id?>" />
                <input name="tarea" type="hidden" id="tarea" value="<?= $tarea?>" />
                <input name="lim" type="hidden" id="lim" value="<?= $lim?>" />
                <input name="fechaini" type="hidden" id="fechaini" value="<?= $fechaini?>" />
                <input name="fechafin" type="hidden" id="fechafin" value="<?= $fechafin?>" />
                
              </div></td>
              </tr>
            
            <tr>
              <td><table width="100%" border="1" cellpadding="0" cellspacing="0" class="letra3" rules="none">

                <tr>
                  <td><table width="100%" border="0" cellpadding="0" cellspacing="1" class="letra3">

                  <tr>
                    <td width="35%"><div align="right">Fecha&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($fecha)?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">Letra&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $letra?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">P.Venta&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $ptovta?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">N�mero&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $numero?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">Proveedor&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $proveedor?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">C.A.I. Nro.&nbsp;</div></td>
                        <td width="65%" class="letra6bold"><?= $cainro?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">Gravado&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><span class="letra6">21%&nbsp;</span><?= $neto21?>  <span class="letra6">10.5%&nbsp;</span><?= $neto10?> <span class="letra6">27%&nbsp;</span><?= $neto27?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">Iva&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><span class="letra6">21%&nbsp;</span><?= $iva21?> <span class="letra6">10.5%&nbsp;</span><?= $iva10?> <span class="letra6">27%&nbsp</span><?= $iva27?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">Exento&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $exento?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">No Gravado&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $nogravado?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">Imp. Internos&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $impinternos?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">Percepci�n/Retenci�n&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><span class="letra6">Percepci�n IVA&nbsp;</span><?= $periva?> <span class="letra6">Retenci�n IVA&nbsp;</span><?= $retiva?> <span class="letra6">Per / Ret IIBB&nbsp;</span><?= $perretiibb?></td>
                  </tr>
                  <tr>
                    <td width="35%"><div align="right">Vencimiento&nbsp;</div></td>
                    <td width="65%" class="letra6bold"><?= $dsup->getFechaNormalCorta($fechaven)?></td>
                  </tr>
                    <tr>
                      <td class="lnk"><a href="javascript: document.form1.action='adm_com_main.php'; document.form1.submit()"><img src="images/back.png" width="12" height="12" title="Volver" alt="Volver" /></a></td>
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

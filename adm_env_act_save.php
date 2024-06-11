<?
/*
 * Creado el 07/07/2020 12:59:43
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_env_act_save.php
 */
    
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
$dsup=new datesupport();
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$id=$glo->getGETPOST("id");
$idart=$glo->getGETPOST("idart");
$tenvasado1=$glo->getGETPOST("tenvasado1");
$tenvasado2=$glo->getGETPOST("tenvasado2");
$tenvasado3=$glo->getGETPOST("tenvasado3");
$fechaing=$glo->getGETPOST("fechaing");
$idprv=$glo->getGETPOST("idprv");
$idprv1=$glo->getGETPOST("idprv1");
$idprv2=$glo->getGETPOST("idprv2");
$kgdescarte=$glo->getGETPOST("kgdescarte");
$lote=$glo->getGETPOST("lote");
$cantidad=$glo->getGETPOST("cantidad");
$kilos=$glo->getGETPOST("kilos");
$tarea=$glo->getGETPOST("tarea");
$tunel=$glo->getGETPOST("tunel");
if($tunel=="") $tunel=0;
if($tenvasado1=="") $tenvasado1=0;
if($tenvasado2=="") $tenvasado2=0;
if($tenvasado3=="") $tenvasado3=0;
if($kilos=="") $kilos=0;
if($cantidad=="") $cantidad=0;
if($kgdescarte=="") $kgdescarte=0;
if($idprv=="") $idprv=0;
if($idprv1=="") $idprv1=0;
if($idprv2=="") $idprv2=0;
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Envasado",$usr->getId(),"Ingresa Envasado: $idart | $cantidad | $kilos",$centrosel);
    $ssql="insert into adm_env (idart, tenvasado1, tenvasado2, tenvasado3, fechaing, idprv, kgdescarte, lote, cantidad, kilos, idprv1, idprv2, tunel) values ($idart, $tenvasado1, $tenvasado2, $tenvasado3, '$fechaing', $idprv, $kgdescarte, '$lote', $cantidad, $kilos, $idprv1, $idprv2, $tunel)";
} else {
    $aud->regAud("Envasado",$usr->getId(),"Modifica Envasado: $idart | $cantidad | $kilos",$centrosel);
    $ssql="update adm_env set idart=$idart, tenvasado1=$tenvasado1, tenvasado2=$tenvasado2, tenvasado3=$tenvasado3, fechaing='$fechaing', idprv=$idprv, kgdescarte=$kgdescarte, lote='$lote', cantidad=$cantidad, kilos=$kilos, idprv1=$idprv1, idprv2=$idprv2, tunel=$tunel where id=$id";
}
//echo $ssql;
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_env_main.php" method="post">
        </form>
        <script languaje="javascript">
          document.form1.submit()
        </script>
    </body>
</html>

<?php
/*
 * Creado el 21/01/2019 20:36:06
 * Autor: gus
 * Archivo: adm_rem_act_save.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
$dsup = new datesupport();
$conx=new conexion();
$aud=new registra_auditoria();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$id=$glo->getGETPOST("id");
$fecha=$glo->getGETPOST("fecha");
$idprv=$glo->getGETPOST("idprv");
$totaltotal=$glo->getGETPOST("totaltotal");
$observaciones=$glo->getGETPOST("observaciones");
$patente=$glo->getGETPOST("patente");
$ptovta=$glo->getGETPOST("ptovta");
$numero=$glo->getGETPOST("numero");
$idcom=$glo->getGETPOST("idcom");
$certificado1=$glo->getGETPOST("certificado1");
$certificado2=$glo->getGETPOST("certificado2");
$certificado3=$glo->getGETPOST("certificado3");
$certificado1=$sup->AddZeros($certificado1, 4);
$certificado3=$sup->AddZeros($certificado3, 8);
if($certificado2=="")$certificado2=" ";
$certificado=$certificado1."".$certificado2."".$certificado3;
if($idcom=="") $idcom=0;
if($numero=="") $numero=0;
if($ptovta=="") $ptovta=0;
$conn=$conx->conectarBase();
$ssql="update adm_rem set fecha='$fecha', idprv=$idprv, observaciones='$observaciones', patente='$patente', ptovta=$ptovta, numero=$numero, idcom=$idcom, certificado='$certificado' where id=$id";
$conx->consultaBase($ssql, $conn);
//echo $ssql."<br>";
$ssql="delete from adm_rem_det where idrem=$id";
//echo $ssql;
$conx->consultaBase($ssql, $conn);
$cantidad=$glo->getGETPOST("cantidaddet");
for($i=0;$i<$cantidad;$i++) {
    $item_cantidad="item_cantidad$i";
    $item_producto="item_producto$i";
    $item_precio="item_precio$i";
    $item_animales="item_animales$i";
    $item_kilos="item_kilos$i";
    $item_descripcion="item_descripcion$i";
    $item_unidad="item_unidad$i";
    $item_iva="item_iva$i";
    $idremdet="idremdet$i";
    $$idremdet=$glo->getGETPOST($idremdet);
    $$item_producto=$glo->getGETPOST($item_producto);
    $$item_descripcion=$glo->getGETPOST($item_descripcion);
    $$item_animales=$glo->getGETPOST($item_animales);
    $$item_kilos=$glo->getGETPOST($item_kilos);
    $$item_precio=$glo->getGETPOST($item_precio);
    $$item_cantidad=$glo->getGETPOST($item_cantidad);
    $$item_unidad=$glo->getGETPOST($item_unidad);
    $$item_iva=$glo->getGETPOST($item_iva);
    if($$item_iva=="") $$item_iva=0;
    if($$item_producto=="") $$item_producto=0;
    if($$item_animales=="") $$item_animales=0;
    if($$item_kilos=="") $$item_kilos=0;
    if($$item_precio=="") $$item_precio=0;
    if($$item_cantidad=="") $$item_cantidad=0;
//    echo "idremdet: $idremdet | ".$$idremdet."<br>";
    if($$idremdet=="") $$idremdet=0;
    if($$idremdet==0) {
        $ssql="insert into adm_rem_det (idrem, idart, descripcion, cantidad, precio, animales, kilos, unidad, alicuota) values (";
        $ssql.="$id, ".$$item_producto.", '".$$item_descripcion."', ".$$item_cantidad.", ".$$item_precio.", ".$$item_animales.", ".$$item_kilos.", ".$$item_unidad.", ".$$item_iva.")";
    } else {
        $ssql="insert into adm_rem_det (id, idrem, idart, descripcion, cantidad, precio, animales, kilos, unidad, alicuota) values (";
        $ssql.=$$idremdet.", $id, ".$$item_producto.", '".$$item_descripcion."', ".$$item_cantidad.", ".$$item_precio.", ".$$item_animales.", ".$$item_kilos.", ".$$item_unidad.", ".$$item_iva.")";
    }
//    echo $ssql."<br>";
    $conx->consultaBase($ssql, $conn);
    $faena=0;
//    echo "item_producto: ".$$item_producto."<br>";
    if($$item_producto==0) $faena=1;
}
$ssql="update adm_rem set faena=$faena where id=$id";
//echo $ssql."<br>";
$conx->consultaBase($ssql, $conn);
$ssql="update adm_crm set fecha='$fecha' where idrem=$id";
$conx->consultaBase($ssql, $conn);
$aud->regAudC("REMITOS", $usr->getId(), "Modifica remito #$id | $fecha | $totaltotal", $centrosel, $conn, $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_rem_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>

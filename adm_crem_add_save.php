<?php
/*
 * Creado el 13/03/2019 15:03:56
 * Autor: gus
 * Archivo: adm_crem_add_save.php
 * planbsistemas.com.ar
 */

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
$fecha=$glo->getGETPOST("fecha");
$fechaentrega=$glo->getGETPOST("fechaentrega");
$idcli=$glo->getGETPOST("idcli");
$totaltotal=$glo->getGETPOST("totaltotal");
$observaciones=$glo->getGETPOST("observaciones");
$patente=$glo->getGETPOST("patente");
$clave=$glo->getGETPOST("clave");
$conn=$conx->conectarBase();
$ssql="select * from adm_crem where clave='$clave' and fecha='$fecha' and idcli='$idcli'";
//echo $ssql."<br>";
//echo "can: ".$conx->getCantidadRegA($ssql, $conn)."<br>";
if($conx->getCantidadRegA($ssql, $conn)==0) {
    $ssql="insert into adm_crem (fecha, idcli, observaciones, patente, clave) values ('$fecha', $idcli, '$observaciones', '$patente', '$clave')";
    $conx->consultaBase($ssql, $conn);
    //echo $ssql."<br>";
    $id=$conx->getLastId("adm_crem", $conn);
    if($fechaentrega!="") {
        $ssql="update adm_crem set fechaentrega='$fechaentrega' where id=$id";
        $conx->consultaBase($ssql, $conn);
    }
    $ssql="delete from adm_crem_det where idped=$id";
    $conx->consultaBase($ssql, $conn);
    $cantidad=100;
    for($i=0;$i<=$cantidad;$i++) {
        $item_cantidad="item_cantidad$i";
        $item_recipiente="item_recipiente$i";
        $item_producto="item_producto$i";
        $item_precio="item_precio$i";
        $$item_producto=$glo->getGETPOST($item_producto);
        $$item_precio=$glo->getGETPOST($item_precio);
        $$item_cantidad=$glo->getGETPOST($item_cantidad);
        $$item_recipiente=$glo->getGETPOST($item_recipiente);
        if($$item_recipiente=="") $$item_recipiente=0;
        if($$item_precio=="") $$item_precio=0;
        if($$item_cantidad=="") $$item_cantidad=0;
        if($$item_producto>0) {
            if($$item_precio=="") $$item_precio=0;
            $ssql="insert into adm_crem_det (idrem, idpro, cantidad, recipiente, precio) values (";
            $ssql.="$id, ".$$item_producto.", ".$$item_cantidad.", ".$$item_recipiente.", ".$$item_precio.")";
            $conx->consultaBase($ssql, $conn);
    //        echo $ssql."<br>";
        }
    }
    $aud->regAudC("REMITO", $usr->getId(), "Agrega nuevo remito #$id | $fecha | $idcli | $totaltotal", $centrosel, $conn);
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crem_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>


<?php
/*
 * Creado el 11/07/2019 21:10:33
 * Autor: gus
 * Archivo: adm_mov_add_save.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_cta.php';
$aud=new registra_auditoria();
$dsup=new datesupport();
$sup=new support();
$glo=new globalson();
$conx=new conexion();
$fecha=$glo->getGETPOST("fecha");
$detalle=$glo->getGETPOST("detalle");
$asiento=$glo->getGETPOST("asiento");
if($asiento=="") $asiento=0;
$canti=$glo->getGETPOST("cantidaddet");
$ssql="insert into adm_mov1 (fecha, detalle, centro, asiento) values ('$fecha', '$detalle', $centrosel, $asiento)";
$detalleaud="Se agrega movimiento contable: $fecha | $detalle";
$conx->getConsulta($ssql);
echo $ssql."<br>";
$asiento=0;
$id=$conx->getLastId("adm_mov1");
$ssql="select * from adm_mov1 order by asiento desc limit 1";
if($conx->getCantidadReg($ssql)>0) {
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $asiento=$reg->asiento;
}
$asiento++;
$ssql="update adm_mov1 set asiento=$asiento where id=$id";
$conx->getConsulta($ssql);
//echo "clave: $clave<br>";
for($i=0;$i<$canti;$i++) {
    $det_idcta="det_idcta$i";
    $det_detalle="det_detalle$i";
    $det_entrada="det_entrada$i";
    $det_salida="det_salida$i";
    $$det_idcta=$glo->getGETPOST($det_idcta);
    $$det_detalle=$glo->getGETPOST($det_detalle);
    $$det_entrada=$glo->getGETPOST($det_entrada);
    $$det_salida=$glo->getGETPOST($det_salida);
    if($$det_entrada=="")
        $$det_entrada=0;
    if($$det_salida=="")
        $$det_salida=0;
    if($$det_salida>0) {
        $importe=$$det_salida;
        $tipo=2;
    }
    if($$det_entrada>0) {
        $importe=$$det_entrada;
        $tipo=1;
    }
    if($importe=="")
        $importe=0;
    $cta=new adm_cta_1($$det_idcta);
    $ssql="insert into adm_mov2 (centro, idmov, detalle, tipo, importe, idcta, codigo) values ($centrosel, $id, '".$$det_detalle."', $tipo, $importe, ".$$det_idcta.", '".$cta->getCodigo()."')";
    $conx->getConsulta($ssql);
    echo $ssql."<br>";
}
$aud->regAud("Contabilidad", $idusr, $detalleaud, $centrosel);
    //}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_mov_main.php" method="post">
        </form>
        <script language="javascript">
//            document.form1.submit()
        </script>
    </body>
</html>

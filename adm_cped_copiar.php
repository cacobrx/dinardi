<?php
/*
 * Creado el 01/09/2018 16:08:32
 * Autor: gus
 * Archivo: adm_cped_copiar.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_cped.php';
require_once 'clases/adm_cped_det.php';
require_once 'clases/auditoria.php';
$dsup = new datesupport();
$aud=new registra_auditoria();
$sup = new support();
$conx=new conexion();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$conn=$conx->conectarBase();
$limmax=$cfg->getLimmax();
for($i=0;$i<$limmax;$i++) {
    $chkcop="chkcop$i";
    $$chkcop=$glo->getGETPOST($chkcop);
    if($$chkcop>0) {
        $cped=new adm_cped_1($$chkcop, $conn);
        $ff=$cped->getFecha();
        $fecha=date("Y-m-d", strtotime("$ff + 1 month"));
        $ssql="insert into adm_cped (centro, fecha, idcli, importe, fechaven, referencias, observaciones, total, usuario) values (";
        $ssql.="$centrosel, '$fecha', ".$cped->getIdcli().", ".$cped->getImporte().", '".$cped->getFechaven()."', '".$cped->getReferencias()."', '".$cped->getObservaciones()."', ".$cped->getTotal().", ".$usr->getId().")";
        $conx->consultaBase($ssql, $conn);
        $idped=$conx->getLastId("adm_cped", $conn);
        $ssql="select * from adm_cped_det where idped=".$$chkcop;
        $det=new adm_cped_det_2($ssql,$conn);
        $d_can=$det->getCantidad();
        $d_pre=$det->getPrecio();
        $d_des=$det->getDescripcion();
        for($d=0;$d<count($d_can);$d++) {
            $ssql="insert into adm_cped_det (centro, idped, cantidad, descripcion, precio) value (";
            $ssql.="$centrosel, $idped, ".$d_can[$d].", '".$d_des[$d]."', ".$d_pre[$d].")";
            $conx->consultaBase($ssql, $conn);
        }
        $aud->regAudC("PEDIDOS", $usr->getId(), "Agrega pedido $idped del $fecha", $centrosel, $conn);
        
    }
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_cped_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>


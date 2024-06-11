<?php
/*
 * Creado el 13/03/2019 14:21:34
 * Autor: gus
 * Archivo: adm_cped_main.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cped.php';
require_once 'clases/conexion.php';
$dsup = new datesupport();
$sup = new support();
$conx=new conexion();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$id=$glo->getGETPOST("id");
$fecha=date("Y-m-d");
$cped= new adm_cped_1($id);
$idcli=$cped->getIdcli();
$conn=$conx->conectarBase();
$ssql="insert into adm_crem (fecha, idcli) values ('$fecha', $idcli)";
$conx->consultaBase($ssql, $conn);

$idrem=$conx->getLastId("adm_crem", $conn);
$d_cantidad=$cped->getDet_cantidad();
$d_idpro=$cped->getDet_idpro();
$d_recipiente=$cped->getDet_recipiente();
$d_precio=$cped=$cped->getDet_precio();
 
for($i=0;$i<count($d_cantidad);$i++) {
    $ssql="insert into adm_crem_det (idrem, cantidad, idpro, recipiente, precio) values ($idrem, ".$d_cantidad[$i].", ".$d_idpro[$i].", ".$d_recipiente[$i].", ".$d_precio[$i].")";
    $conx->consultaBase($ssql, $conn);    
}
$ssql="update adm_cped set idrem=$idrem where id=$id";
$conx->consultaBase($ssql, $conn);
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
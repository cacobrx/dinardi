<?php
/*
 * Creado el 28/01/2019 15:24:30
 * Autor: gus
 * Archivo: adm_fae_main_save.php
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
$fecha=$glo->getGETPOST("fecha");
$idcrm=$glo->getGETPOST("idcrm");
$cantidaddet=$glo->getGETPOST("cantidaddet");
$conn=$conx->conectarBase();
$ssql="delete from adm_fae_det where idcrm=$idcrm";
$conx->consultaBase($ssql, $conn);
for($i=0;$i<$cantidaddet;$i++) {
    $det_idart="det_idart$i";
    $det_peso="det_peso$i";
    $det_precio="det_precio$i";
    $det_total="det_total$i";
    $$det_idart=$glo->getGETPOST($det_idart);
    $$det_peso=$glo->getGETPOST($det_peso);
    $$det_precio=$glo->getGETPOST($det_precio);
    $$det_total=$glo->getGETPOST($det_total);
    $ssql="insert into adm_fae_det (idcrm, idart, peso, precio) values (";
    $ssql.="$idcrm, ".$$det_idart.", ".$$det_peso.", ".$$det_precio.")";
    $conx->consultaBase($ssql, $conn);
//        echo $ssql."<br>";
}
$aud->regAudC("RESUMEN DE FAENA", $usr->getId(), "Actualiza control de faena #$idcrm", $centrosel, $conn, $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crm_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>


<?php
/*
 * creado el 4 nov. 2023 09:37:07
 * Usuario: gus
 * Archivo: fix_retper
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/auditoria.php';
$aud = new registra_auditoria();
$glo = new globalson();
$conx = new conexion();
$sup = new support();
$dsup = new datesupport();
$cfg = new planb_config_1($centrosel);
$conn=$conx->conectarBase();
$ssql="select * from adm_prv  order by id";
$rs=$conx->consultaBase($ssql, $conn);
while($reg=mysqli_fetch_object($rs)) {
    
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="" method="post">

        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>

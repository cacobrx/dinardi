<?php
/*
 * Creado el 04/08/2020 15:44:17
 * Autor: gus
 * Archivo: adm_com_activar.php
 * planbsistemas.com.ar
 */

require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/datesupport.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
require_once 'clases/adm_com.php';
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$conn=$conx->conectarBase();
$cantidadtotal=$glo->getGETPOST("cantidadtotal");
for($i=0;$i<$cantidadtotal;$i++) {
    $chkpag="chkpag$i";
    $$chkpag=$glo->getGETPOST($chkpag);
    if($$chkpag>0) {
        $ccc=new adm_com_1($$chkpag, $conn);
        $ssql="update adm_com set importepag=0 where id=".$$chkpag;
//        echo $ssql."<br>";
        $conx->consultaBase($ssql, $conn);
        $aud->regAudC("COMPRAS", $usr->getId(),"Activa importe #".$$chkpag." | Compra: ".$ccc->getComprobantetodo()." | Proveedor: ".$ccc->getProveedor(),$centrosel,$conn);
    }
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_com_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>


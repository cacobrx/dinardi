<?php
/*
 * Creado el 07/03/2019 20:45:10
 * Autor: gus
 * Archivo: adm_fis_factura_fin.php
 * planbsistemas.com.ar
 */

//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/planb_config.php';
require_once 'clases/support.php';
require_once 'clases/conexion.php';
require_once 'clases/auditoria.php';
$aud = new registra_auditoria();
$conx = new conexion();
$sup = new support();
$cfg = new planb_config_1($centrosel);
$glo = new globalson();
$f_numero=$glo->getGETPOST("f_numero");
$f_numerocae=$glo->getGETPOST("f_numerocae");
$f_fechacae=$glo->getGETPOST("f_fechacae");
$f_error=$glo->getGETPOST("f_error");
$f_idfis=$glo->getGETPOST("f_idfis");
$error= str_replace("'", "", $f_error);
if($f_numero!="" and $f_numerocae!="" and $f_fechacae!="") {
    $descri="Se agrega comprobante fiscal $f_idfis | $f_numero | $f_numerocae | $f_fechacae | $f_error";
    $ssql="update adm_fis set numero=$f_numero, numerocae=$f_numerocae, fechacae='$f_fechacae', error='$error' where id=$f_idfis";
} else {
    $descri="Error en facturacion $f_idfis | $f_error";
    $ssql="update adm_fis set error='$error' where id=$f_idfis";
}
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$aud->regAud("FACTURACION", $usr->getId(), $descri, $centrosel);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_fis_main.php" method="post">
        </form>
        <script language="javascript">
            document.form1.submit();
        </script>
    </body>
</html>


<?
/*
 * Creado el 18/01/2019 17:00:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_pro_act_save.php
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
$centro=$glo->getGETPOST("centro");
$descripcion=$glo->getGETPOST("descripcion");
$precio=$glo->getGETPOST("precio");
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Productos",$usr->getId(),"Ingresa Productos: \[$id]",$centrosel);
    $ssql="insert into adm_pro (centro, descripcion, precio) values ($centrosel, '$descripcion', '$precio')";
} else {
    $aud->regAud("Productos",$usr->getId(),"Modifica Productos: [$id]",$centrosel);
    $ssql="update adm_pro set descripcion='$descripcion', precio='$precio' where id=$id";
}
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_pro_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>

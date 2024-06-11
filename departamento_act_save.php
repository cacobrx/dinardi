<?
/*
 * Creado el 29/05/2017 13:46:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_adelantos_act_save.php
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
$descripcion=$glo->getGETPOST("descripcion");
$hora1=$glo->getGETPOST("hora1");
$hora2=$glo->getGETPOST("hora2");
$hora3=$glo->getGETPOST("hora3");
$hora4=$glo->getGETPOST("hora4");
$tarea=$glo->getGETPOST("tarea");
if($tarea=="A") {
    $aud->regAud("Descripcion",$usr->getId(),"Ingresa Descripcion: $descripcion",$centrosel);
    $ssql="insert into departamento (descripcion, hora1, hora2, hora3, hora4) values ('$descripcion', '$hora1', '$hora2', '$hora3', '$hora4')";
} else {
    $aud->regAud("Descripcion",$usr->getId(),"Modifica Descripcion: $descripcion",$centrosel);
    $ssql="update departamento set descripcion='$descripcion', hora1='$hora1', hora2='$hora2', hora3='$hora3', hora4='$hora4' where id=$id";
}
//echo $ssql;
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="departamento_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>

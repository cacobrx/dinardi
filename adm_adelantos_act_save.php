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
$centro=$glo->getGETPOST("centro");
$idper=$glo->getGETPOST("idper");
$fecha=$glo->getGETPOST("fecha");
$importe=$glo->getGETPOST("importe");
$tarea=$glo->getGETPOST("tarea");
$id=$glo->getGETPOST("id");
if($tarea=="A") {
    $aud->regAud("Adelantos",$usr->getId(),"Ingresa Adelantos: $importe | $idper",$centrosel);
    $ssql="insert into adm_adelantos (centro, idper, fecha, importe) values ($centrosel, $idper, '".$fecha."', $importe)";
} else {
    $aud->regAud("Adelantos",$usr->getId(),"Modifica Adelantos: $importe | $idper",$centrosel);
    $ssql="update adm_adelantos set idper=$idper, fecha='".$fecha."', importe=$importe where id=$id";
}
$conx->getConsulta($ssql);
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_adelantos_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>

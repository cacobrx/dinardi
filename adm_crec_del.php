<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($_POST);
require_once 'user.php';
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_crec.php';
//require_once 'clases/adm_rec2.php';
require_once 'clases/auditoria.php';
//require_once 'clases/adm_rec_pag.php';
$aud=new registra_auditoria();
$conx=new conexion();
$glo=new globalson();
$idrec=$glo->getGETPOST("id");
$rec1=new adm_crec1_1($idrec);
$p_imp=$rec1->getR2_importe();
$p_idfis=$rec1->getR2_idfis();

$ssql="delete from adm_crec1 where id=$idrec";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$ssql="delete from adm_crec2 where idcrec=$idrec";
$conx->getConsulta($ssql);
//echo $ssql."<br>";
$ssql="delete from adm_crec3 where idcrec=$idrec";
$conx->getConsulta($ssql);
//$ssql="delete from adm_mov1 where id=".$rec1->getIdmov();
////echo $ssql."<br>";
//$conx->getConsulta($ssql);
//$ssql="delete from adm_mov2 where idmov1=".$rec1->getIdmov();
////echo $ssql."<br>";
//$conx->getConsulta($ssql);
for($i=0;$i<count($p_imp);$i++) {
    $ssql="update adm_fis set importepago=importepago - ".$p_imp[$i]." where id=".$p_idfis[$i];
    $conx->getConsulta($ssql);
}

$aud->regAud("Recibos", $usr->getId(), "Elimina Recibo $idrec | Fecha ".$rec1->getFecha()." | Importe ".$rec1->getImporte(), $centrosel)
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_crec_main.php" method="post">
        </form>
        <script language="javascript">
        document.form1.submit()
        </script>
    </body>
</html>


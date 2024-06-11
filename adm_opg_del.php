<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($_POST);
require_once 'clases/globalson.php';
require_once 'clases/conexion.php';
require_once 'clases/adm_opg1.php';
require_once 'clases/adm_opg2.php';
$conx=new conexion();
$glo=new globalson();
$lim=$glo->getGETPOST("lim");
$idop=$glo->getGETPOST("id");
$fechaini=$glo->getGETPOST("fechaini");
$fechafin=$glo->getGETPOST("fechafin");
$opg1=new adm_opg1_1($idop);
$ssql="select * from adm_opg2 where idop=$idop";
$op2=new adm_opg2_2($ssql);
$o2_idcht=$op2->getIdcht();
$o2_idche=$op2->getIdche();
$ssql="delete from adm_opg1 where id=$idop";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$ssql="delete from adm_opg2 where idop=$idop";
//echo $ssql."<br>";
$conx->getConsulta($ssql);
$ssql="update adm_com set idopg=0, importepag=0 where idopg=$idop";
$conx->getConsulta($ssql);
$ssql="update adm_cht set entregado='', idopg=0 where idopg=$idop";
$conx->getConsulta($ssql);
$ssql="update adm_che set destinatario='', idopg=0 where idopg=$idop";
$conx->getConsulta($ssql);
//print_r($o2_idcht);
//echo "<br>";
//for($i=0;$i<count($o2_idcht);$i++) {
//    if($o2_idcht[$i]>0) {
//        $ssql="update adm_cht set entregado='' where id=".$o2_idcht[$i];
//        //echo $ssql."<br>";
//        $conx->getConsulta($ssql);
//    }
//    if($o2_idche[$i]>0) {
//        $ssql="update adm_che set destinatario='' where id=".$o2_idche[$i];
//        $conx->getConsulta($ssql);
//    }
//}


?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_opg_main.php" method="post">
        </form>
        <script language="javascript">
        document.form1.submit()
        </script>
    </body>
</html>


<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/horarios.php';
$conx=new conexion();
$glo=new globalson();
$aud=new registra_auditoria();

$contenido=$glo->getGETPOST("contenido");
$adm=new horarios($contenido);
$a_idp=$adm->getIddep();
$idemp=$adm->getIdemp();
$a_fec=$adm->getFecha();

//print_r($a_tpp);
//print_r($a_cur);
//print_r($a_leg);
$conn=$conx->conectarBase();
for($i=0;$i<count($a_idp);$i++) {
    if($a_idp[$i]>0) {
        $ssql="select * from horarios where idemp=$idemp and iddep=".$a_idp[$i]." and fecha='".$a_fec[$i]."'";
//        echo $ssql."<br>";
        if($conx->getCantidadRegA($ssql, $conn)==0) {
            $ssql="insert into horarios (iddep, fecha,  idemp) values (".$a_idp[$i].", '".$a_fec[$i]."',  $idemp[$i])";
//            echo $ssql."<br>";
            $conx->consultaBase($ssql, $conn);                        
        }                    
    }
}
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_horarios_main.php" method="post">
        </form>
        <script language="javascript">
            alert("Se registraron los horarios!");            
            document.form1.submit();
        </script>
    </body>
</html>

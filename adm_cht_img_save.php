<?php
/*
 * Creado el 22/11/2018 11:46:39
 * Autor: gus
 * Archivo: adm_cht_img_save.php
 * planbsistemas.com.ar
 */

//print_r($_FILES);
require_once 'user.php';
require_once 'clases/conexion.php';
require_once 'clases/globalson.php';
require_once 'clases/auditoria.php';
require_once 'clases/datesupport.php';
require_once 'clases/adm_cht.php';
require_once 'clases/support.php';
$sup=new support();
$dsup = new datesupport();
$aud = new registra_auditoria();
$conx = new conexion();
$glo = new globalson();
$usuario = $usr->getId();
$idche = $glo->getGETPOST("idche");
$adm=new adm_cht_1($idche);
$aud->regAud("CHEQUES", $usr->getId(), "Actualiza fotos del cheque ".$adm->getBancodes()." #".$adm->getNrocheque(), $centrosel);

$extension=array(".jpg",".JPG", ".png", ".PNG");
if($_FILES['file1']['name']!="") {
    //echo $_FILES[$file]['name']."<br>";
    $ext=strrchr($_FILES['file1']['name'],'.');
    if(in_array($ext,$extension)) {
        $destino="fotos/cht1_".$idche.$ext;
//        echo "destino: $destino<br>";
        if(file_exists($destino))
            unlink($destino);    
        $temp_path = rand(1,99999).$destino;
        //echo "temp: $temp_path<br>";
        //$copiado=move_uploaded_file($file1,$destino);
        if(strtolower($ext)==".jpg")
            $image_object =   imagecreatefromjpeg($_FILES['file1']['tmp_name']);
        else
            $image_object = imagecreatefrompng($_FILES['file1']['tmp_name']);
        $image_150 = $sup->Resize($image_object,1024);
        imagejpeg( $image_150,$destino);
        chmod($destino,0777);
    }
}

$extension=array(".jpg",".JPG", ".png", ".PNG");
if($_FILES['file2']['name']!="") {
    //echo $_FILES[$file]['name']."<br>";
    $ext=strrchr($_FILES['file2']['name'],'.');
    if(in_array($ext,$extension)) {
        $destino="fotos/cht2_".$idche.$ext;
//        echo "destino: $destino<br>";
        if(file_exists($destino))
            unlink($destino);    
        $temp_path = rand(1,99999).$destino;
        //echo "temp: $temp_path<br>";
        //$copiado=move_uploaded_file($file1,$destino);
        if(strtolower($ext)==".jpg")
            $image_object =   imagecreatefromjpeg($_FILES['file2']['tmp_name']);
        else
            $image_object = imagecreatefrompng($_FILES['file2']['tmp_name']);
        $image_150 = $sup->Resize($image_object,1024);
        imagejpeg( $image_150,$destino);
        chmod($destino,0777);
    }
}

$ssql="update adm_cht set versionfoto=versionfoto+1 where id=$idche";
$conx->getConsulta($ssql);


//echo $ssql;
?>
<html>
    <body>
        <form name="form1" id="form1" action="adm_cht_main.php" method="post">
        </form>
        <script languaje="javascript">
            document.form1.submit()
        </script>
    </body>
</html>

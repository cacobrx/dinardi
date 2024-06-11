<?php
/*
 * creado el 27/07/2016 20:23:17
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_mov_caja_cfg
 */

class adm_mov_caja_cfg_1 {
    var $id='';
    var $centro=0;
    var $cajamov='';
    var $cajamovdes="";
    var $descriptor1=0;
    var $descriptor2=0;
    var $descriptor3=0;
    var $descriptor4=0;
    var $segmento1=0;
    var $segmento2=0;
    var $segmento3=0;
    var $segmento4=0;
    var $oficina=0;
    var $descriptor1des="";
    var $descriptor2des="";
    var $descriptor3des="";
    var $descriptor4des="";
    var $segmento1des="";
    var $segmento2des="";
    var $segmento3des="";
    var $segmento4des="";
    var $oficinades="";
    var $seccion=0;
    var $secciondes="";

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_clasif.php';
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_mov_caja_cfg where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->cajamov=$reg->cajamov;
        $this->cajamovdes=$conx->getTextoValor($reg->cajamov, "CAJA",$conn);
        $this->descriptor1=$reg->descriptor1;
        $this->descriptor2=$reg->descriptor2;
        $this->descriptor3=$reg->descriptor3;
        $this->descriptor4=$reg->descriptor4;
        $this->segmento1=$reg->segmento1;
        $this->segmento2=$reg->segmento2;
        $this->segmento3=$reg->segmento3;
        $this->segmento4=$reg->segmento4;
        $this->oficina=$reg->oficina;
        $cla=new adm_clasif_1($reg->descriptor1, $conn);
        $this->descriptor1des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->descriptor2, $conn);
        $this->descriptor2des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->descriptor3, $conn);
        $this->descriptor3des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->descriptor4, $conn);
        $this->descriptor4des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->segmento1, $conn);
        $this->segmento1des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->segmento2, $conn);
        $this->segmento2des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->segmento3, $conn);
        $this->segmento3des=$cla->getTexto();
        $cla=new adm_clasif_1($reg->segmento4, $conn);
        $this->segmento4des=$cla->getTexto();
        $this->oficinades=$conx->getTextoValor($reg->oficina, "OFIN1", $conn);
        $this->seccion=$reg->seccion;
        switch ($reg->seccion) {
            case 1:
                $this->secciondes="Recibo";
                break;
            case 2:
                $this->secciondes="Rendicion";
                break;
            case 3:
                $this->secciondes="O/Pago";
                break;
        }
        
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getCajamov() {
        return $this->cajamov;
    }

    function getCajamovdes() {
        return $this->cajamovdes;
    }

    function getDescriptor1() {
        return $this->descriptor1;
    }

    function getDescriptor2() {
        return $this->descriptor2;
    }

    function getDescriptor3() {
        return $this->descriptor3;
    }

    function getDescriptor4() {
        return $this->descriptor4;
    }
    
    function getSegmento1() {
        return $this->segmento1;
    }

    function getSegmento2() {
        return $this->segmento2;
    }

    function getSegmento3() {
        return $this->segmento3;
    }

    function getSegmento4() {
        return $this->segmento4;
    }

    function getOficina() {
        return $this->oficina;
    }
    
    function getDescriptor1des() {
        return $this->descriptor1des;
    }

    function getDescriptor2des() {
        return $this->descriptor2des;
    }
    
    function getDescriptor3des() {
        return $this->descriptor3des;
    }
    
    function getDescriptor4des() {
        return $this->descriptor4des;
    }
    
    function getSegmento1des() {
        return $this->segmento1des;
    }
    
    function getSegmento2des() {
        return $this->segmento2des;
    }
    
    function getSegmento3des() {
        return $this->segmento3des;
    }
    
    function getSegmento4des() {
        return $this->segmento4des;
    }
    
    function getOficinades() {
        return $this->oficinades;
    }
    
    function getSeccion() {
        return $this->seccion;
    }
    
    function getSecciondes() {
        return $this->secciondes;
    }
    

}

class adm_mov_caja_cfg_2 {
    var $id=array();
    var $centro=array();
    var $seccion=array();
    var $secciondes=array();
    var $cajamov=array();
    var $cajamovdes=array();
    var $maxregistros=0;
    var $descriptor1=array();
    var $descriptor2=array();
    var $descriptor3=array();
    var $descriptor4=array();
    var $segmento1=array();
    var $segmento2=array();
    var $segmento3=array();
    var $segmento4=array();
    var $oficina=array();
    var $descriptor1des=array();
    var $descriptor2des=array();
    var $descriptor3des=array();
    var $descriptor4des=array();
    var $segmento1des=array();
    var $segmento2des=array();
    var $segmento3des=array();
    var $segmento4des=array();
    var $oficinades=array();

    function __construct($ssql, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_clasif.php';
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
              $ssqltot=$ssql;
            else
              $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->seccion,$reg->seccion);
                switch ($reg->seccion) {
                    case 1:
                        array_push($this->secciondes,"Recibo");
                        break;
                    case 2:
                        array_push($this->secciondes,"Rendicion");
                        break;
                    case 3:
                        array_push($this->secciondes,"O/Pago");
                        break;
                    case 4:
                        array_push($this->secciondes,"Punitorios");
                        break;
                    default:
                        array_push($this->secciondes,"");
                        break;
                }
                array_push($this->cajamov,$reg->cajamov);
                array_push($this->cajamovdes,$conx->getTextoValor($reg->cajamov,"CAJA",$conn));
                array_push($this->descriptor1,$reg->descriptor1);
                array_push($this->descriptor2,$reg->descriptor2);
                array_push($this->descriptor3,$reg->descriptor3);
                array_push($this->descriptor4,$reg->descriptor4);
                array_push($this->segmento1,$reg->segmento1);
                array_push($this->segmento2,$reg->segmento2);
                array_push($this->segmento3,$reg->segmento3);
                array_push($this->segmento4,$reg->segmento4);
                array_push($this->oficina,$reg->oficina);
                $cla=new adm_clasif_1($reg->descriptor1, $conn);
                array_push($this->descriptor1des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor2, $conn);
                array_push($this->descriptor2des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor3, $conn);
                array_push($this->descriptor3des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor4, $conn);
                array_push($this->descriptor4des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->segmento1, $conn);
                array_push($this->segmento1des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->segmento2, $conn);
                array_push($this->segmento2des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->segmento3, $conn);
                array_push($this->segmento3des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->segmento4, $conn);
                array_push($this->segmento4des,$cla->getTexto());
                array_push($this->oficinades,$conx->getTextoValor($reg->oficina,"OFIN1",$conn));
            }    
        }
    }

    function getId() {
      return $this->id;
    }

    function getCentro() {
      return $this->centro;
    }

    function getFecha() {
      return $this->fecha;
    }

    function getDetalle() {
      return $this->detalle;
    }

    function getImporte() {
      return $this->importe;
    }

    function getCajamov() {
      return $this->cajamov;
    }

    function getCajamovdes() {
      return $this->cajamovdes;
    }

    function getMaxRegistros() {
      return $this->maxregistros;
    }
  
    function getDescriptor1() {
        return $this->descriptor1;
    }

    function getDescriptor2() {
        return $this->descriptor2;
    }

    function getDescriptor3() {
        return $this->descriptor3;
    }

    function getDescriptor4() {
        return $this->descriptor4;
    }
    
    function getSegmento1() {
        return $this->segmento1;
    }

    function getSegmento2() {
        return $this->segmento2;
    }

    function getSegmento3() {
        return $this->segmento3;
    }

    function getSegmento4() {
        return $this->segmento4;
    }

    function getOficina() {
        return $this->oficina;
    }

    function getDescriptor1des() {
        return $this->descriptor1des;
    }

    function getDescriptor2des() {
        return $this->descriptor2des;
    }

    function getDescriptor3des() {
        return $this->descriptor3des;
    }

    function getDescriptor4des() {
        return $this->descriptor4des;
    }
    
    function getSegmento1des() {
        return $this->segmento1des;
    }

    function getSegmento2des() {
        return $this->segmento2des;
    }

    function getSegmento3des() {
        return $this->segmento3des;
    }

    function getSegmento4des() {
        return $this->segmento4des;
    }

    function getOficinades() {
        return $this->oficinades;
    }
    
    function getSeccion() {
        return $this->seccion;
    }
    
    function getSecciondes() {
        return $this->secciondes;
    }
  
}

?>

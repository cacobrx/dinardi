<?
/*
 *Created on 22/10/12 - 12:42:36
 *Author: Gustavo
 *File: ram_caj.php
 */

class adm_com_det_1 {
    var $id=0;
    var $idcom=0;
    var $descriptor1=0;
    var $descriptor2=0;
    var $descriptor3=0;
    var $descriptor4=0;
    var $detalle="";
    var $importe=0;


    function __construct($id, $conn="0") { 
        require_once('clases/conexion.php');
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql='select * from adm_com_det where id='.$id;
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->idcom=$reg->idcom;
            $this->descriptor1=$reg->descriptor1;
            $this->descriptor2=$reg->descriptor2;
            $this->descriptor3=$reg->descriptor3;
            $this->descriptor4=$reg->descriptor4;
            $this->detalle=$reg->detalle;
            $this->importe=$reg->importe;
        }
    }

    function getId() {
        return $this->id;
    }

    function getIdcom() {
        return $this->idcom;
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

    function getDetalle() {
        return $this->detalle;
    }

    function getImporte() { return $this->importe; }


}

class adm_com_det_2 {
    var $id=array();
    var $idcom=array();
    var $descriptor1=array();
    var $descriptor2=array();
    var $descriptor3=array();
    var $descriptor4=array();
    var $descriptor1des=array();
    var $descriptor2des=array();
    var $descriptor3des=array();
    var $descriptor4des=array();
    var $detalle=array();
    var $importe=array();
    var $maxregistros=0;

    function __construct($ssql, $conn="0") { 
        require_once('conexion.php');
        require_once 'clases/adm_clasif.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
              $ssqltot=$ssql;
            else
              $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot, $conn);
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->idcom,$reg->idcom);
                array_push($this->descriptor1,$reg->descriptor1);
                array_push($this->descriptor2,$reg->descriptor2);
                array_push($this->descriptor3,$reg->descriptor3);
                array_push($this->descriptor4,$reg->descriptor4);
                $cla=new adm_clasif_1($reg->descriptor1,$conn);
                array_push($this->descriptor1des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor2,$conn);
                array_push($this->descriptor2des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor3,$conn);
                array_push($this->descriptor3des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor4,$conn);
                array_push($this->descriptor4des,$cla->getTexto()); 
                array_push($this->detalle,$reg->detalle);        
                array_push($this->importe,$reg->importe);
            }
        }
    }

    function getMaxRegistros() {
        return $this->maxregistros;
    }

    function getId() {
        return $this->id;
    }

    function getIdcom() {
        return $this->idcom;
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

    function getDetalle() {
        return $this->detalle;
    }

    function getImporte() { return $this->importe; }

}

class adm_com_det_2_com {
    var $id=array();
    var $idcom=array();
    var $descriptor1=array();
    var $descriptor2=array();
    var $descriptor3=array();
    var $descriptor4=array();
    var $descriptor1des=array();
    var $descriptor2des=array();
    var $descriptor3des=array();
    var $descriptor4des=array();
    var $detalle=array();
    var $importe=array();
    var $fecha=array();
    var $comprobante=array();
    var $maxregistros=0;

    function __construct($ssql, $conn="0") { 
        require_once('conexion.php');
        require_once 'clases/adm_clasif.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
              $ssqltot=$ssql;
            else
              $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot, $conn);
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->idcom,$reg->idcom);
                array_push($this->descriptor1,$reg->descriptor1);
                array_push($this->descriptor2,$reg->descriptor2);
                array_push($this->descriptor3,$reg->descriptor3);
                array_push($this->descriptor4,$reg->descriptor4);
                $cla=new adm_clasif_1($reg->descriptor1,$conn);
                array_push($this->descriptor1des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor2,$conn);
                array_push($this->descriptor2des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor3,$conn);
                array_push($this->descriptor3des,$cla->getTexto());
                $cla=new adm_clasif_1($reg->descriptor4,$conn);
                array_push($this->descriptor4des,$cla->getTexto()); 
                array_push($this->detalle,$reg->detalle);        
                array_push($this->importe,$reg->importe);
                array_push($this->fecha,$reg->fecha);
                array_push($this->comprobante,$reg->ptovta."-".$reg->numero);
            }
        }
    }

    function getMaxRegistros() {
        return $this->maxregistros;
    }

    function getId() {
        return $this->id;
    }

    function getIdcom() {
        return $this->idcom;
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

    function getDetalle() {
        return $this->detalle;
    }

    function getImporte() { return $this->importe; }
    function getFecha() { return $this->fecha; }
    function getComprobante() { return $this->comprobante; }
}
?>

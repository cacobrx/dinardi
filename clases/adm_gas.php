<?
/*
 * Creado el 03/10/2018 15:24:44
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_gas.php
 */
 
class adm_gas_1 {
    var $id=0;
    var $centro=0;
    var $fecha='';
    var $fechaven='';
    var $idprv=0;
    var $comprobante=0;
    var $proveedor="";
    var $comprobantedes="";    
    var $cerrado=0;
    var $fechapago="";
    var $numero=0;
    var $importe=0;
    var $det_descriptor1=array();
    var $det_descriptor2=array();
    var $det_descriptor3=array();
    var $det_descriptor4=array();
    var $det_descriptor1des=array();
    var $det_descriptor2des=array();
    var $det_descriptor3des=array();
    var $det_descriptor4des=array();
    var $det_detalle=array();
    var $det_importe=array();
    var $det_id=array();    
    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_clasif.php';
        require_once 'clases/adm_gas_det.php';
        $conx=new conexion();        
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_gas where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->fecha=$reg->fecha;    
        $this->fechaven=$reg->fechaven;
        $this->idprv=$reg->idprv;
        $this->comprobante=$reg->comprobante;    
        $prv=new adm_prv_1($reg->idprv, $conn);
        $this->proveedor=$prv->getApellido();
        if($reg->comprobante==1)
            $this->comprobantedes="Gasto";
        else
            $this->comprobantedes="Reintegro";
        $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fecha))."'";
        $this->cerrado=$conx->getCantidadRegA($ssql, $conn);     
        $this->fechapago=$reg->fechapago;
        $this->numero=$reg->numero;
        $this->importe=$reg->importe;
        $ssql="select * from adm_com_det where idgas=$id";
//        echo $ssql."<br>";
        $des=new adm_gas_det_2($ssql);  
        $this->det_id=$des->id;
        $this->det_descriptor1=$des->descriptor1;
        $this->det_descriptor2=$des->descriptor2;
        $this->det_descriptor3=$des->descriptor3;
        $this->det_descriptor4=$des->descriptor4;

        $this->det_descriptor1des=$des->descriptor1des;
        $this->det_descriptor2des=$des->descriptor2des;
        $this->det_descriptor3des=$des->descriptor3des;
        $this->det_descriptor4des=$des->descriptor4des;
        $this->det_detalle=$des->detalle;
        $this->det_importe=$des->importe;        
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
    
    function getImporte() {
        return $this->importe;
    }    
  
    function getFechaven() {
        return $this->fechaven;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
  
    function getComprobante() {
        return $this->comprobante;
    }
    
    function getDet_descriptor1() {
        return $this->det_descriptor1;
    }

    function getDet_descriptor2() {
        return $this->det_descriptor2;
    }

    function getDet_descriptor3() {
        return $this->det_descriptor3;
    }

    function getDet_descriptor4() {
        return $this->det_descriptor4;
    }

    function getDet_descriptor1des() {
        return $this->det_descriptor1des;
    }

    function getDet_descriptor2des() {
        return $this->det_descriptor2des;
    }

    function getDet_descriptor3des() {
        return $this->det_descriptor3des;
    }

    function getDet_descriptor4des() {
        return $this->det_descriptor4des;
    } 
    
    function getDet_detalle() { return $this->det_detalle; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_id() { return $this->det_id; }    
    
    function getComprobantedes() { return $this->comprobantedes; }
    function getProveedor() { return $this->proveedor; }
    function getCerrado() { return $this->cerrado; }
    function getFechapago() { return $this->fechapago; }
    function getNumero() { return $this->numero; }
}

class adm_gas_2 {
    var $id=array();
    var $centro=array();
    var $fecha=array();
    var $fechaven=array();
    var $idprv=array();
    var $comprobante=array();
    var $comprobantedes=array();
    var $proveedor=array();
    var $cerrado=array();
    var $fechapago=array();
    var $numero=array();
    var $importe=array();
    var $det_descriptor1=array();
    var $det_descriptor2=array();
    var $det_descriptor3=array();
    var $det_descriptor4=array();
    var $det_descriptor1des=array();
    var $det_descriptor2des=array();
    var $det_descriptor3des=array();
    var $det_descriptor4des=array();
    var $det_detalle=array();
    var $det_importe=array();
    var $det_id=array();    
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_clasif.php';
        require_once 'clases/adm_gas_det.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql,$conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->fecha,$reg->fecha);
                array_push($this->fechaven,$reg->fechaven);
                array_push($this->idprv,$reg->idprv);
                array_push($this->comprobante,$reg->comprobante);             
                $prv=new adm_prv_1($reg->idprv, $conn);
                array_push($this->proveedor,$prv->getApellido());
                if($reg->comprobante==1)
                    array_push($this->comprobantedes,"Gasto");
                else
                    array_push($this->comprobantedes,"Reintegro");
                $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fecha))."'";
                array_push($this->cerrado,$conx->getCantidadRegA($ssql, $conn));                  
                array_push($this->fechapago,$reg->fechapago);
                array_push($this->numero,$reg->numero);
                array_push($this->importe,$reg->importe);
                $ssql="select * from adm_com_det where idgas=".$reg->id;
               //echo $ssql;
                $det=new adm_gas_det_2($ssql,$conn);
                array_push($this->det_descriptor1,$det->getDescriptor1());
                array_push($this->det_descriptor2,$det->getDescriptor2());
                array_push($this->det_descriptor3,$det->getDescriptor3());
                array_push($this->det_descriptor4,$det->getDescriptor4());
                array_push($this->det_id,$det->getId());
                array_push($this->det_descriptor1des,$det->getDescriptor1des());
                array_push($this->det_descriptor2des,$det->getDescriptor2des());
                array_push($this->det_descriptor3des,$det->getDescriptor3des());
                array_push($this->det_descriptor4des,$det->getDescriptor4des());
                array_push($this->det_importe,$det->getImporte());
                array_push($this->det_detalle,$det->getDetalle());                
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
  
    function getFechaven() {
        return $this->fechaven;
    }
  
    function getIdprv() {
        return $this->idprv;
    }
    
    function getImporte() {
        return $this->importe;
    }
  
    function getComprobante() {
        return $this->comprobante;
    }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
    
    function getDet_descriptor1() {
        return $this->det_descriptor1;
    }

    function getDet_descriptor2() {
        return $this->det_descriptor2;
    }

    function getDet_descriptor3() {
        return $this->det_descriptor3;
    }

    function getDet_descriptor4() {
        return $this->det_descriptor4;
    }

    function getDet_descriptor1des() {
        return $this->det_descriptor1des;
    }

    function getDet_descriptor2des() {
        return $this->det_descriptor2des;
    }

    function getDet_descriptor3des() {
        return $this->det_descriptor3des;
    }

    function getDet_descriptor4des() {
        return $this->det_descriptor4des;
    } 
    
    function getDet_detalle() { return $this->det_detalle; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_id() { return $this->det_id; }    
    
    function getComprobantedes() { return $this->comprobantedes; }
    function getProveedor() { return $this->proveedor; }
    function getCerrado()     { return $this->cerrado; }
    function getFechapago() { return $this->fechapago; }
    function getNumero() { return $this->numero; }
}

?>

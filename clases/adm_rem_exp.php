<?
/*
 * Creado el 20/04/2018 09:59:47
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_rem_exp.php
 */
 
class adm_rem_exp_1 {
    var $id=0;
    var $centro=0;
    var $ptovta=0;
    var $numero=0;
    var $fecha="";
    var $exportador="";
    var $buque="";
    var $destino="";
    var $remitente="";
    var $nro="";
    var $precinto="";
    var $procedencia="";
    var $giro="";
    var $contenedor="";
    var $agenciapre="";
    var $transportista="";
    var $balanza="";
    var $cuit="";
    var $certificado="";
    var $serie="";
    var $fiscal="";
    var $nro2="";
    var $patenteca="";
    var $cantidad=array();
    var $descripcion=array();
    var $kgsbrutos=array();
    var $kgsnetos=array();

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_rem_exp_det.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_rem_exp where id=$id";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
    //        echo $ssql;
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;  
            $this->ptovta=$reg->ptovta;
            $this->numero=$reg->numero;
            $this->fecha=$reg->fecha;
            $this->exportador=$reg->exportador;
            $this->buque=$reg->buque;
            $this->destino=$reg->destino;
            $this->remitente=$reg->remitente;
            $this->nro=$reg->nro;
            $this->precinto=$reg->precinto;
            $this->procedencia=$reg->procedencia;
            $this->giro=$reg->giro;
            $this->contenedor=$reg->contenedor;
            $this->agenciapre=$reg->agenciapre; 
            $this->transportista=$reg->transportista; 
            $this->balanza=$reg->balanza; 
            $this->cuit=$reg->cuit; 
            $this->serie=$reg->serie; 
            $this->fiscal=$reg->fiscal; 
            $this->certificado=$reg->certificado; 
            $this->nro2=$reg->nro2; 
            $this->patenteca=$reg->patenteca; 
            $ssql="select * from adm_rem_exp_det where idrem=".$reg->id;
            $fdet=new adm_rem_exp_det_2($ssql);
            $this->cantidad=$fdet->getCantidad();
            $this->descripcion=$fdet->getDescripcion();
            $this->kgsbrutos=$fdet->getKgsbrutos();
            $this->kgsnetos=$fdet->getKgsnetos();
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    } 

    function getPtovta() {
        return $this->ptovta;
    }
    
    function getNumero() {
        return $this->numero;
    }    
    
   function getFecha() {
        return $this->fecha;
    }          
  
    function getExportador() {
        return $this->exportador;
    }
    
    function getBuque() {
        return $this->buque;
    }
    
    function getDestino() {
        return $this->destino;
    }
    
    function getRemitente() {
        return $this->remitente;
    }
    
    function getNro() { return $this->nro; }
    function getPrecinto() { return $this->precinto; }
    function getProcedencia() { return $this->procedencia; }
    function getGiro() { return $this->giro; }
    function getContenedor() { return $this->contenedor; }
    function getAgenciapre() { return $this->agenciapre; }
    function getTransportista() { return $this->transportista; }
    function getBalanza() { return $this->balanza; }
    function getCuit() { return $this->cuit; }
    function getCertificado() { return $this->certificado; }
    function getSerie() { return $this->serie; }
    function getFiscal() { return $this->fiscal; }
    function getNro2() { return $this->nro2; }
    function getPatenteca() { return $this->patenteca; }
    function getCantidad() { return $this->cantidad; }
    function getDescripcion() { return $this->descripcion; }
    function getKgsbrutos() { return $this->kgsbrutos; }
    function getKgsneto() { return $this->kgsnetos; }
  
}

class adm_rem_exp_2 {
    var $id=array();
    var $centro=array();
    var $ptovta=array();
    var $numero=array();
    var $fecha=array();
    var $exportador=array();
    var $buque=array();
    var $destino=array();
    var $remitente=array();
    var $nro=array();
    var $precinto=array();
    var $procedencia=array();
    var $giro=array();
    var $contenedor=array();
    var $agenciapre=array();
    var $transportista=array();
    var $balanza=array();
    var $cuit=array();
    var $certificado=array();
    var $serie=array();
    var $fiscal=array();
    var $nro2=array();
    var $patenteca=array();    
    var $cantidad=array();
    var $descripcion=array();
    var $kgsbrutos=array();
    var $kgsnetos=array();    
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_rem_exp_det.php';
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
                array_push($this->ptovta,$reg->ptovta);  
                array_push($this->numero,$reg->numero);  
                array_push($this->fecha,$reg->fecha);
                array_push($this->exportador,$reg->exportador);
                array_push($this->buque,$reg->buque);
                array_push($this->destino,$reg->destino);
                array_push($this->remitente,$reg->remitente);
                array_push($this->nro,$reg->nro);
                array_push($this->precinto,$reg->precinto);
                array_push($this->procedencia,$reg->procedencia);
                array_push($this->giro,$reg->giro);
                array_push($this->contenedor,$reg->contenedor);
                array_push($this->agenciapre,$reg->agenciapre);  
                array_push($this->transportista,$reg->transportista); 
                array_push($this->balanza,$reg->balanza); 
                array_push($this->cuit,$reg->cuit); 
                array_push($this->serie,$reg->serie); 
                array_push($this->fiscal,$reg->fiscal); 
                array_push($this->certificado,$reg->certificado); 
                array_push($this->nro2,$reg->nro2); 
                array_push($this->patenteca,$reg->patenteca); 
                $ssql="select * from adm_rem_exp_det where idrem=".$reg->id;
                $rdet=new adm_rem_exp_det_2($ssql,$conn);              
                array_push($this->cantidad,$rdet->getCantidad());
                array_push($this->descripcion,$rdet->getDescripcion());
                array_push($this->kgsbrutos,$rdet->getKgsbrutos());
                array_push($this->kgsnetos,$rdet->getKgsnetos());
            }    
        }
    }
    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    } 
    
    function getPtovta() {
        return $this->ptovta;
    } 

    function getNumero() {
        return $this->numero;
    } 
    
    function getFecha() {
        return $this->fecha;
    }      
  
    function getExportador() {
        return $this->exportador;
    }
    
    function getBuque() {
        return $this->buque;
    }
    
    function getDestino() {
        return $this->destino;
    }
    
    function getRemitente() {
        return $this->remitente;
    }
    
    function getNro() { return $this->nro; }
    function getPrecinto() { return $this->precinto; }
    function getProcedencia() { return $this->procedencia; }
    function getGiro() { return $this->giro; }
    function getContenedor() { return $this->contenedor; }
    function getAgenciapre() { return $this->agenciapre; }
    function getTransportista() { return $this->transportista; }
    function getBalanza() { return $this->balanza; }
    function getCuit() { return $this->cuit; }
    function getCertificado() { return $this->certificado; }
    function getSerie() { return $this->serie; }
    function getFiscal() { return $this->fiscal; }
    function getNro2() { return $this->nro2; }
    function getPatenteca() { return $this->patenteca; }
    function getCantidad() { return $this->cantidad; }
    function getDescripcion() { return $this->descripcion; }
    function getKgsbrutos() { return $this->kgsbrutos; }
    function getKgsneto() { return $this->kgsnetos; }    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>

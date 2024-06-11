<?php
/*
 * Creado el 13/03/2019 13:57:03
 * Autor: gus
 * Archivo: adm_cped.php
 * planbsistemas.com.ar
 */

class adm_cped_1 {
    var $id=0;
    var $fecha='';
    var $idcli=0;
    var $cliente="";
    var $direccion="";
    var $fechaentrega="";
    var $observaciones="";
    var $patente="";
    var $total=0;
    var $det_id=array();
    var $det_idped=array();
    var $det_idpro=array();
    var $det_cantidad=array();
    var $det_precio=array();
    var $det_importe=array();
    var $det_articulo=array();
    var $det_recipiente=array();

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_cped_det.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_cped where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->fecha=$reg->fecha;
        $this->idcli=$reg->idcli;
        $this->fechaentrega=$reg->fechaentrega;
        $this->observaciones=$reg->observaciones;
        $this->patente=$reg->patente;
        $cli=new adm_cli_1($reg->idcli,$conn);
        $this->direccion=$cli->getDireccion();
        $this->cliente=$cli->getApellido()." ".$cli->getNombre();
        $ssql="select * from adm_cped_det where idped=".$reg->id;
        $det=new adm_cped_det_2($ssql, $conn);
        $this->det_id=$det->getId();
        $this->det_idped=$det->getIdped();
        $this->det_idpro=$det->getIdpro();
        $this->det_cantidad=$det->getCantidad();
        $this->det_precio=$det->getPrecio();
        $this->det_importe=$det->getImporte();
        $this->det_articulo=$det->getArticulo();
        $this->total=$det->getTotal();
        $this->det_recipiente=$det->getRecipiente();
    }

    function getId() {
        return $this->id;
    }
  
    function getIdcli() {
        return $this->idcli;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getCliente() {
        return $this->cliente;
    }
    
    function getDireccion() {
        return $this->direccion;
    }    
  
    function getTotal() {
        return $this->total;
    }
    
    function getPatente() {
        return $this->patente;
    }
    
    function getFechaentrega() { return $this->fechaentrega; }
    function getObservaciones() { return $this->observaciones; }
    
    function getDet_recipiente() { return $this->det_recipiente; }    
    function getDet_id() { return $this->det_id; }
    function getDet_idped() { return $this->det_idped; }
    function getDet_idpro() { return $this->det_idpro; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_articulo() { return $this->det_articulo; }
}

class adm_cped_2 {
    var $id=array();
    var $fecha=array();
    var $idcli=array();
    var $cliente=array();
    var $direccion=array();
    var $fechaentrega=array();
    var $observaciones=array();
    var $patente=array();
    var $idrem=array();
    var $total=array();
    var $det_id=array();
    var $det_idped=array();
    var $det_idpro=array();
    var $det_cantidad=array();
    var $det_precio=array();
    var $det_importe=array();
    var $det_articulo=array();
    var $det_recipiente=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cli.php';
        require_once 'clases/adm_cped_det.php';
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
                array_push($this->fecha,$reg->fecha);
                array_push($this->fechaentrega,$reg->fechaentrega);
                array_push($this->idcli,$reg->idcli);
                array_push($this->observaciones,$reg->observaciones);  
                array_push($this->patente,$reg->patente);
                $cli=new adm_cli_1($reg->idcli,$conn);
                array_push($this->direccion, $cli->getDireccion());
                array_push($this->cliente,$cli->getApellido()." ".$cli->getNombre());
                $ssql="select * from adm_cped_det where idped=".$reg->id;
//                echo $ssql;
                $det=new adm_cped_det_2($ssql, $conn);
                array_push($this->det_id,$det->getId());
                array_push($this->det_idped,$det->getIdpro());
                array_push($this->det_idpro,$det->getIdpro());
                array_push($this->det_cantidad,$det->getCantidad());
                array_push($this->det_precio,$det->getPrecio());
                array_push($this->det_importe,$det->getImporte());
                array_push($this->det_articulo,$det->getArticulo());
                array_push($this->det_recipiente, $det->getRecipiente());
                array_push($this->total,$det->getTotal());
                
                $ssql="select * from adm_crem where idped=".$reg->id;
                array_push($this->idrem,$conx->getCantidadRegA($ssql, $conn));
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getIdcli() {
        return $this->idcli;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getCliente() {
        return $this->cliente;
    }

    function getDireccion() {
        return $this->direccion;
    }    
  
    function getTotal() {
        return $this->total;
    }
    
    function getPatente() {
        return $this->patente;
    }    
    
    function getIdrem() { return $this->idrem; }
    
    function getDet_id() { return $this->det_id; }
    function getDet_idped() { return $this->det_idped; }
    function getDet_idpro() { return $this->det_idpro; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_articulo() { return $this->det_articulo; }
    function getFechaentrega() { return $this->fechaentrega; }
    function getDet_recipiente() { return $this->det_recipiente; }
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

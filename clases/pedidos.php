<?
/*
 * Creado el 23/04/2018 11:03:02
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: pedidos.php
 */
 
class pedidos_1 {
    var $id=0;
    var $centro=0;
    var $fecha='';
    var $cliente="";
    var $total=0;
    var $det_id=array();
    var $det_cantidad=array();
    var $det_idart=array();
    var $det_articulo=array();
    var $det_precio=array();
    var $det_preciodes=array();
    var $det_descuento=array();
    var $det_total=array();

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_centro.php';
        require_once 'clases/pedidos_det.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from pedidos where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->fecha=$reg->fecha;
        $cli=new adm_centro_1($reg->centroeddis,$conn);
        $this->cliente=$cli->getNombre();
        $ssql="select * from pedidos_det where idped=".$reg->id;
        $det=new pedidos_det_2($ssql, $conn);
        $this->det_cantidad=$det->getCantidad();
        $this->det_descripcion=$det->getArticulo();
        $this->det_descuento=$det->getDescuento();
        $this->det_idart=$det->getIdart();
        $this->det_precio=$det->getPrecio();
        $this->det_preciodes=$det->getPreciodes();
        $this->det_total=$det->getTotal();
        $this->det_id=$det->getId();
        $xpre=$det->getPrecio();
        $xdes=$det->getDescuento();
        $xcan=$det->getCantidad();
        $tot=0;
        for($i=0;$i<count($xcan);$i++) {
            $tot+=($xpre[$i]-$xpre[$i]*$xdes[$i]/100)*$xcan[$i];

        }
        $this->total=$tot;
        
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
    
    function getCliente() {
        return $this->cliente;
    }
  
    function getTotal() {
        return $this->total;
    }
    
    function getDet_id() { return $this->det_id; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_idart() { return $this->det_idart; }
    function getDet_descripcion() { return $this->det_descripcion; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_descuento() { return $this->det_descuento; }
    function getDet_preciodes() { return $this->det_preciodes; }
    function getDet_total() { return $this->det_total; }
}

class pedidos_2 {
    var $id=array();
    var $centro=array();
    var $centroeddis=array();
    var $fecha=array();
    var $centronom=array();
    var $total=array();
    var $det_cantidad=array();
    var $det_idart=array();
    var $det_descripcion=array();
    var $det_precio=array();
    var $det_descuento=array();
    var $det_total=array();
    var $det_id=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_centro.php';
        require_once 'clases/pedidos_det.php';
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
                array_push($this->centroeddis,$reg->centroeddis);
                array_push($this->fecha,$reg->fecha);
                $cli=new adm_centro_1($reg->centroeddis,$conn);       
                array_push($this->centronom,$cli->getNombre());
                $ssql="select * from pedidos_det where idped=".$reg->id;
                $det=new pedidos_det_2($ssql, $conn);
                array_push($this->det_cantidad,$det->getCantidad());
                array_push($this->det_descripcion,$det->getArticulo());
                array_push($this->det_descuento,$det->getDescuento());
                array_push($this->det_idart,$det->getIdart());
                array_push($this->det_precio,$det->getPrecio());
                array_push($this->det_total,$det->getTotal());
                array_push($this->det_id,$det->getId());
                $xpre=$det->getPrecio();
                $xdes=$det->getDescuento();
                $xcan=$det->getCantidad();
                $tot=0;
                for($i=0;$i<count($xcan);$i++) {
                    $tot+=($xpre[$i]-$xpre[$i]*$xdes[$i]/100)*$xcan[$i];
                    
                }
                array_push($this->total,$tot);
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getCentroeddis() {
        return $this->centroeddis;
    }
  
    function getFecha() {
        return $this->fecha;
    }
    
    function getCentronom() {
        return $this->centronom;
    }
    
    function getTotal() {
        return $this->total;
    }
    
    function getDet_id() { return $this->det_id; }
    function getDet_cantidad() { return $this->det_cantidad; }
    function getDet_idart() { return $this->det_idart; }
    function getDet_descripcion() { return $this->det_descripcion; }
    function getDet_precio() { return $this->det_precio; }
    function getDet_descuento() { return $this->det_descuento; }
    function getDet_total() { return $this->det_total; }
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

?>

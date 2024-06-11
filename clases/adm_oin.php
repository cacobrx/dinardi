<?
/*
 * Creado el 13/11/2020 14:54:56
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_oin.php
 */
 
class adm_oin_1 {
    var $id=0;
    var $fecha='';
    var $detalle='';
    var $importe=0;

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_oin where id=$id";
        $rs=$conx->consultaBase($ssql,$conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->fecha=$reg->fecha;
        $this->detalle=$reg->detalle;
        $this->importe=$reg->importe;
    }

    function getId() {
        return $this->id;
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
  
}

class adm_oin_2 {
    var $id=array();
    var $fecha=array();
    var $detalle=array();
    var $importe=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
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
                array_push($this->detalle,$reg->detalle);
                array_push($this->importe,$reg->importe);
            }    
        }
    }

    function getId() {
        return $this->id;
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
  
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

class adm_oin_tot {
    var $total=0;
    
    function __construct($fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select sum(importe) as total from adm_oin where fecha>='$fechaini' and fecha<='$fechafin'";
//        echo $ssql;
        $rs=$conx->getConsulta($ssql);
        $reg=mysqli_fetch_object($rs);
        $this->total=$reg->total;
    }
    
    function getTotal() { return $this->total; }
}

?>

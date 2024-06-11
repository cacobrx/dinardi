<?php
/*
 * creado el 06/07/2016 12:00:44
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_mov_caja_ini
 */

class adm_mov_caja_ini_1 {
    var $id=0;
    var $centro=0;
    var $fecha='';
    var $importe=0;
    var $tipocaja=0;
    var $tipocajades="";


    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_mov_caja_ini where id=$id";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->fecha=$reg->fecha;
        $this->importe=$reg->importe;
        $this->tipocaja=$reg->tipocaja;
        $this->tipocajades=$conx->getTextoValor($reg->tipocaja, "CAJA", $conn);

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

    function getTipocaja() {
        return $this->tipocaja;
    }

    function getTipocajades() {
        return $this->tipocajades;
    }
  
}

class adm_mov_caja_ini_2 {
    var $id=array();
    var $centro=array();
    var $fecha=array();
    var $importe=array();
    var $tipocaja=array();
    var $tipocajades=array();
    var $maxregistros=0;


    function __construct($ssql, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        if($conx->getCantidadReg($ssql)>0) {
            if(strpos($ssql,'limit')=='')
              $ssqltot=$ssql;
            else
              $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadReg($ssqltot);
            $rs=$conx->getConsulta($ssql);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->fecha,$reg->fecha);
                array_push($this->importe,$reg->importe);
                array_push($this->tipocaja,$reg->tipocaja);
                array_push($this->tipocajades,$conx->getTextoValor($reg->tipocaja, "CAJA", $conn));
            }    
        }
    }
    
    function getMaxregistros() {
        return $this->maxregistros;
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

    function getTipocaja() {
        return $this->tipocaja;
    }

    function getTipocajades() {
        return $this->tipocajades;
    }
}

class Saldoinicial {
    var $saldoini=0;
    
    function __construct($fechaini, $tipocaja, $conn="0") {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $saldo=0;
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_mov_caja_ini where tipocaja=$tipocaja and fecha<'$fechaini' and eliminado=0 order by fecha desc";
        //echo $ssql."\n";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=  mysqli_fetch_object($rs);
            $saldo=$reg->importe;
            $fecha=$reg->fecha;
        } else {
            $saldo=0;
            $fecha="";
        }
        $ssql="select * from adm_mov_caja where fecha>'$fecha' and fecha<'$fechaini' and eliminado=0 and tipocaja=$tipocaja order by fecha, id";
        //echo $ssql."<br>";
        $rx=$conx->consultaBase($ssql, $conn);
        while($rxx=  mysqli_fetch_object($rx)) {
            if($rxx->tipomov==1)
                $saldo+=$rxx->importe;
            else
                $saldo-=$rxx->importe;
            //echo "reg: ".$rxx->id." | tipo: ".$rxx->tipomov." | Importe: ".$rxx->importe." | Saldo: $saldo\n";
        }
        $this->saldoini=$saldo;
    }
    
    function getSaldoini() {
        return $this->saldoini;
    }
}

?>

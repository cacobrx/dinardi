<?php
/*
 * creado el 07/11/2017 18:42:52
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_mov
 */

class adm_mov_1 {
    var $id=0;
    var $centro=0;
    var $idemp='';
    var $fecha='';
    var $detalle='';
    var $asiento=0;
    var $det_id=array();
    var $det_idcta=array();
    var $det_tipo=array();
    var $det_importe=array();
    var $det_detalle=array();
    var $det_nombre=array();
    var $det_codigo=array();
    var $det_entrada=array();
    var $det_salida=array();

    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_mov1 where id=$id";
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->idemp=$reg->idemp;
            $this->detalle=$reg->detalle;
            $this->fecha=$reg->fecha;
            $this->asiento=$reg->asiento;
            $ssql="select adm_mov2.*, adm_cta.nombre, adm_cta.codigo from adm_mov2, adm_cta where adm_mov2.idmov=$id and adm_mov2.idcta=adm_cta.id";
//            echo $ssql."<br>";
            $rd=$conx->consultaBase($ssql, $conn);
            $d_idcta=array();
            $d_id=array();
            $d_detalle=array();
            $d_tipo=array();
            $d_importe=array();
            $d_cuenta=array();
            $d_codigo=array();
            $d_entrada=array();
            $d_salida=array();
            while($rdd=mysqli_fetch_object($rd)) {
                array_push($d_idcta,$rdd->idcta);
                array_push($d_detalle,$rdd->detalle);
                array_push($d_cuenta,$rdd->nombre);
                array_push($d_tipo,$rdd->tipo);
                array_push($d_importe,$rdd->importe);
                array_push($d_codigo,$rdd->codigo);
                if($rdd->tipo==1) {
                    array_push($d_entrada,$rdd->importe);
                    array_push($d_salida,0);
                } else {
                    array_push($d_salida,$rdd->importe);
                    array_push($d_entrada,0);
                }
            }
            $this->det_detalle=$d_detalle;
            $this->det_id=$d_id;
            $this->det_idcta=$d_idcta;
            $this->det_importe=$d_importe;
            $this->det_nombre=$d_cuenta;
            $this->det_tipo=$d_tipo;
            $this->det_codigo=$d_codigo;
            $this->det_entrada=$d_entrada;
            $this->det_salida=$d_salida;
        }

    }

    function getId() {
      return $this->id;
    }

    function getCentro() {
      return $this->centro;
    }

    function getIdemp() {
      return $this->idemp;
    }

    function getDetalle() {
      return $this->detalle;
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    function getAsiento() {
        return $this->asiento;
    }

    function getDet_id() {
      return $this->det_id;
    }

    function getDet_idcta() {
      return $this->det_idcta;
    }

    function getDet_tipo() {
        return $this->det_tipo;
    }

    function getDet_importe() {
      return $this->det_importe;
    }

    function getDet_nombre() {
      return $this->det_nombre;
    }

    function getDet_detalle() {
      return $this->det_detalle;
    }
    
    function getDet_codigo() {
        return $this->det_codigo;
    }
    
    function getDet_entrada() { return $this->det_entrada; }
    function getDet_salida() { return $this->det_salida; }

}

class adm_mov_2 {
    var $id=array();
    var $centro=array();
    var $idemp=array();
    var $fecha=array();
    var $detalle=array();
    var $asiento=array();
    var $debemov=array();
    var $habermov=array();
    var $det_id=array();
    var $det_idcta=array();
    var $det_tipo=array();
    var $det_importe=array();
    var $det_detalle=array();
    var $det_nombre=array();
    var $det_codigo=array();
    var $maxregistros=0;

    function __construct($ssql, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            $rs=$conx->consultaBase($ssql, $conn);
            //echo $ssql."<br>";
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->idemp,$reg->idemp);
                array_push($this->detalle,$reg->detalle);
                array_push($this->fecha,$reg->fecha);
                array_push($this->asiento,$reg->asiento);
                $ssql="select adm_mov2.*, adm_cta.nombre, adm_cta.codigo from adm_mov2, adm_cta where adm_mov2.idmov=".$reg->id." and adm_mov2.idcta=adm_cta.id";
//                echo $ssql."<br>";
                $d_idcta=array();
                $d_id=array();
                $d_detalle=array();
                $d_tipo=array();
                $d_importe=array();
                $d_cuenta=array();
                $d_codigo=array();
                $debe=0;
                $haber=0;
                $rd=$conx->consultaBase($ssql, $conn);
                while($rdd=mysqli_fetch_object($rd)) {
                    array_push($d_id,$rdd->id);
                    array_push($d_idcta,$rdd->idcta);
                    array_push($d_detalle,$rdd->detalle);
                    array_push($d_cuenta,$rdd->nombre);
                    array_push($d_tipo,$rdd->tipo);
                    array_push($d_importe,$rdd->importe);
                    array_push($d_codigo,$rdd->codigo);
                    if($rdd->tipo==1)
                        $debe+=$rdd->importe;
                    else
                        $haber+=$rdd->importe;
                }
                array_push($this->det_detalle,$d_detalle);
                array_push($this->det_id,$d_id);
                array_push($this->det_idcta,$d_idcta);
                array_push($this->det_importe,$d_importe);
                array_push($this->det_nombre,$d_cuenta);
                array_push($this->det_tipo,$d_tipo);
                array_push($this->det_codigo,$d_codigo);
                array_push($this->debemov,$debe);
                array_push($this->habermov,$haber);
            }    
        }
    }

    function getId() {
      return $this->id;
    }

    function getCentro() {
      return $this->centro;
    }

    function getIdemp() {
      return $this->idemp;
    }

    function getDetalle() {
      return $this->detalle;
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    function getAsiento() {
        return $this->asiento;
    }
    
    function getDebemov() {
        return $this->debemov;
    }
    
    function getHabermov() {
        return $this->habermov;
    }

    function getDet_id() {
      return $this->det_id;
    }

    function getDet_idcta() {
      return $this->det_idcta;
    }

    function getDet_tipo() {
        return $this->det_tipo;
    }

    function getDet_importe() {
      return $this->det_importe;
    }

    function getDet_nombre() {
      return $this->det_nombre;
    }

    function getDet_detalle() {
      return $this->det_detalle;
    }
    
    function getDet_codigo() {
        return $this->det_codigo;
    }
    
    function getMaxRegistros() {
      return $this->maxregistros;
    }
    

}

class adm_mov1_clave {
    var $idmov=0;
    var $cuenta=array();
    var $cuentades=array();
    var $entrada=array();
    var $salida=array();
    var $detalle=array();
    var $asiento=0;
    
    function __construct($clave, $conn="0") {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cta.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_mov1 where clave='$clave'";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rm=$conx->consultaBase($ssql, $conn);
            $rmm=  mysqli_fetch_object($rm);
            $this->idmov=$rmm->id;
            $this->asiento=$rmm->asiento;
            $ssql="select * from adm_mov2 where idmov=".$rmm->id;
            $rm2=$conx->getConsulta($ssql);
            while($rmm2=  mysqli_fetch_object($rm2)) {
                array_push($this->cuenta,$rmm2->idcta);
                array_push($this->detalle,$rmm2->detalle);
                if($rmm2->tipo==1) {
                    array_push($this->entrada,$rmm2->importe);
                    array_push($this->salida,'');
                } else {
                    array_push($this->entrada,'');
                    array_push($this->salida,$rmm2->importe);
                }
                $cta=new adm_cta_1($rmm2->idcta);
                array_push($this->cuentades,$cta->getNombre());
            }
        }
    }
    
    function getCuenta() {
        return $this->cuenta;
    }
    
    function getDetalle() {
        return $this->detalle;
    }
    
    function getEntrada() {
        return $this->entrada;
    }
    
    function getSalida() {
        return $this->salida;
    }
    
    function getIdmov() {
        return $this->idmov;
    }
    
    function getCuentades() {
        return $this->cuentades;
    }
    
    function getAsiento() { return $this->asiento; } 
}

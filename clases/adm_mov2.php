 <?
/*
 *Created on 16/08/12 - 22:42:56
 *Author: Gustavo
 *File: adm_mov2.php
 */

class adm_mov2_1 {
  var $id=0;
  var $centro=0;
  var $importe=0;
  var $tipo=0;
  var $detalle='';
  var $idcta=0;
  var $cuenta='';
  var $cantidad='';

  function __construct($id) { 
    require_once('conexion.php');
    $conx=new conexion();
    $ssql='select * from adm_mov2 where id='.$id;
    $rs=$conx->getConsulta($ssql);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->centro=$reg->centro;
    $this->importe=$reg->importe;
    $this->tipo=$reg->tipo;
    $this->detalle=$reg->detalle;
    $this->idcta=$reg->idcta;
    $this->cuenta=$reg->cuenta;
    $this->cantidad=$reg->cantidad;
  }

  function getId() {
    return $this->id;
  }

  function getCentro() {
    return $this->centro;
  }

  function getImporte() {
    return $this->importe;
  }
  
  function getTipo() {
    return $this->tipo;
  }

  function getDetalle() {
    return $this->detalle;
  }

  function getIdcta() {
    return $this->idcta;
  }

  function getCuenta() {
    return $this->cuenta;
  }
  
  function getCantidad() {
      return $this->cantidad;
  }
  
}

class adm_mov2_2 {
  var $id=array();
  var $centro=array();
  var $importe=array();
  var $tipo=array();
  var $detalle=array();
  var $idcta=array();
  var $cuenta=array();
  var $codigo=array();
  var $cantidad=array();
  var $maxregistros=0;

  function __construct($ssql) { 
    require_once('conexion.php');
    require_once 'adm_cta.php';
    $conx=new conexion();
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
        array_push($this->importe,$reg->importe);
        array_push($this->tipo,$reg->tipo);
        array_push($this->detalle,$reg->detalle);
        array_push($this->idcta,$reg->idcta);
        array_push($this->cantidad,$reg->cantidad);
        $cta=new adm_cta_1($reg->idcta);
        array_push($this->cuenta,$cta->getNombre());
        array_push($this->codigo,$cta->getCodigo());
      }
    }
  }

  function getMaxRegistros() {
    return $this->maxregistros;
  }

  function getId() {
    return $this->id;
  }

  function getCentro() {
    return $this->centro;
  }

  function getImporte() {
    return $this->importe;
  }
  
  function getTipo() {
    return $this->tipo;
  }

  function getDetalle() {
    return $this->detalle;
  }

  function getIdcta() {
    return $this->idcta;
  }

  function getCuenta() {
    return $this->cuenta;
  }
  
  function getCantidad() {
      return $this->cantidad;
  }
  
  function getCodigo() {
      return $this->codigo;
  }
  
}

class adm_mov2_may {
    var $id=array();
    var $centro=array();
    var $importe=array();
    var $idmov=array();
    var $tipo=array();
    var $detalle=array();
    var $idcta=array();
    var $cantidad=array();
    var $descripcion=array();
    var $fecha=array();
    var $cuenta=array();
    var $asiento=array();
    var $maxregistros=0;

    function __construct($ssql, $conn="0") { 
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cta.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
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
              array_push($this->importe,$reg->importe);
              array_push($this->tipo,$reg->tipo);
              array_push($this->detalle,$reg->detalle);
              array_push($this->idcta,$reg->idcta);
              array_push($this->descripcion,$reg->descripcion);
              array_push($this->asiento,$reg->asiento);
              array_push($this->fecha,$reg->fecha);
              array_push($this->idmov,$reg->idmov);
              $cta=new adm_cta_1($reg->idcta, $conn);
              array_push($this->cuenta,$cta->getNombre());
            }
        }
    }

    function getMaxRegistros() {
        return $this->maxregistros;
    }

    function getId() {
        return $this->id;
    }

    function getCentro() {
        return $this->centro;
    }

    function getImporte() {
        return $this->importe;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getDetalle() {
        return $this->detalle;
    }

    function getIdcta() {
        return $this->idcta;
    }

    function getCuenta() {
        return $this->cuenta;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIdmov() {
        return $this->idmov;
    }
    
    function getAsiento() {
        return $this->asiento;
    }

}

class mov1_clave {
    var $idmov=0;
    var $cuenta=array();
    var $cuentades=array();
    var $entrada=array();
    var $salida=array();
    var $detalle=array();
    
    function __construct($clave) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cta.php';
        $conx=new conexion();
        $ssql="select * from adm_mov1 where clave='$clave'";
        if($conx->getCantidadReg($ssql)>0) {
            $rm=$conx->getConsulta($ssql);
            $rmm=  mysqli_fetch_object($rm);
            $this->idmov=$rmm->id;
            $ssql="select * from adm_mov2 where idmov=".$rmm->id;
            $rm2=$conx->getConsulta($ssql);
            while($rmm2=  mysqli_fetch_object($rm2)) {
                array_push($this->cuenta,$rmm2->idcta);
                array_push($this->detalle,$rmm2->detalle);
                if($rmm2->tipo==0) {
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
}


?>

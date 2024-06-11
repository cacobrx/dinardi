<?php
/*
 * creado el 31/07/2016 17:06:22
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * User: gus
 * Archivo: adm_clasif
 */

class adm_clasif_1 {
    var $id=0;
    var $tipo='';
    var $texto='';
    var $dependencia='';
    var $tipodep='';
    var $activo=0;
    var $codigodep='';
    
    function __construct($id, $conn="0") {
      require_once "clases/conexion.php";
      $conx=new conexion();
      if($conn=="0")
          $conn=$conx->conectarBase();
      $ssql="select * from adm_clasif where id=$id";
      if($conx->getCantidadRegA($ssql, $conn)>0) {
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->tipo=$reg->tipo;
        $this->texto=$reg->texto;
        $this->dependencia=$reg->dependencia;
        $this->tipodep=$reg->tipodep;
        $this->activo=$reg->activo;
        $this->codigodep=$reg->codigodep;
      }
    }

    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getTexto() {
        return $this->texto;
    }
    
    function getActivo() {
        return $this->activo;
    }
    
    function getCodigodep() {
        return $this->codigodep;
    }

    function getDependiencia() {
        return $this->dependencia;
    }

    function getTipodep() {
        return $this->tipodep;
    }

  
}

class adm_clasif_2 {
    var $id=array();
    var $tipo=array();
    var $texto=array();
    var $dependencia=array();
    var $dependenciades=array();
    var $dependenciacod=array();
    var $tipodep=array();
    var $activo=array();
    var $codigodep=array();
    var $detalle=array();
    var $detalledes=array();
    var $unidad=array();
    var $subtotal=array();
    var $unidaddes=array();
    var $maxregistros=0;

    
    function __construct($ssql, $conn="0") {
        require_once "clases/conexion.php";
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadRegA($ssqltot,$conn);
            //echo "ssql: $ssql\n";
            $rs=$conx->consultaBase($ssql, $conn);
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->tipo,$reg->tipo);
                array_push($this->texto,$reg->texto);
                array_push($this->dependencia,$reg->dependencia);
                array_push($this->tipodep,$reg->tipodep);
                array_push($this->activo,$reg->activo);
                array_push($this->codigodep,$reg->codigodep);
                if($reg->dependencia>0) {
                    $adm=new adm_clasif_1($reg->dependencia,$conn);
                    array_push($this->dependenciades,$adm->getTexto());
                    array_push($this->dependenciacod,$adm->getTipodep());
                } else {
                    array_push($this->dependenciades,"");
                    array_push($this->dependenciacod,"");
                }
//                array_push($this->unidad, $reg->unidad);
//                array_push($this->unidaddes,"");
//                array_push($this->subtotal,$reg->subtotal);
//                array_push($this->detalle,$reg->detalle);
//                array_push($this->detalledes,"");
            }    
        }
    }

    function getMaxregistros() {
        return $this->maxregistros;
    }
    
    function getId() {
        return $this->id;
    }

    function getActivo() {
        return $this->activo;
    }
            
    function getTipo() {
        return $this->tipo;
    }

    function getTexto() {
        return $this->texto;
    }
    
    function getCodigodep() {
        return $this->codigodep;
    }

    function getDependencia() {
        return $this->dependencia;
    }

    function getTipodep() {
        return $this->tipodep;
    }
    
    function getDependenciades() {
        return $this->dependenciades;
    }
    
    function getDependenciacod() { return $this->dependenciacod; }
    function getUnidad() { return $this->unidad; }
    function getUnidaddes() { return $this->unidaddes; }
    function getDetalle() { return $this->detalle; }
    function getDetalledes() { return $this->detalledes; }
    function getSubtotal() { return $this->subtotal; }
  
}

class adm_clasif_1cod {
    var $id=0;
    var $tipo='';
    var $texto='';
    var $dependencia='';
    var $tipodep='';
    var $activo=0;
    var $codigodep='';
    
    function __construct($id, $conn="0") {
      require_once "clases/conexion.php";
      $conx=new conexion();
      if($conn=="0")
          $conn=$conx->conectarBase();
      $ssql="select * from adm_clasif where codigodep='$id'";
      if($conx->getCantidadRegA($ssql, $conn)>0) {
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->tipo=$reg->tipo;
        $this->texto=$reg->texto;
        $this->dependencia=$reg->dependencia;
        $this->tipodep=$reg->tipodep;
        $this->activo=$reg->activo;
        $this->codigodep=$reg->codigodep;
      }
    }

    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getTexto() {
        return $this->texto;
    }
    
    function getActivo() {
        return $this->activo;
    }
    
    function getCodigodep() {
        return $this->codigodep;
    }

    function getDependiencia() {
        return $this->dependencia;
    }

    function getTipodep() {
        return $this->tipodep;
    }

  
}


?>

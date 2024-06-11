<?
/*
 * Creado el 05/05/2013 20:29:46
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com_cta.php
 */
 
class adm_com_cta_1 {
  var $id=0;
  var $centro=0;
  var $idemp=0;
  var $iva21=0;
  var $iva10=0;
  var $iva27=0;
  var $iva17=0;
  var $periva=0;
  var $retiva=0;
  var $perretiibb='';
  var $impinternos=0;
  var $proveedor=0;

    
  function __construct($id, $conn="0") {
    require_once "clases/conexion.php";
    $conx=new conexion();
    if($conn=="0")
        $conn=$conx->conectarBase ();
    $ssql="select * from adm_com_cta where id=$id";
    $rs=$conx->consultaBase($ssql, $conn);
    $reg=mysqli_fetch_object($rs);
    $this->id=$reg->id;
    $this->centro=$reg->centro;
    $this->idemp=$reg->idemp;
    $this->iva21=$reg->iva21;
    $this->iva10=$reg->iva10;
    $this->iva27=$reg->iva27;
    $this->iva17=$reg->iva17;
    $this->periva=$reg->periva;
    $this->retiva=$reg->retiva;
    $this->petretiibb=$reg->perretiibb;
    $this->impinternos=$reg->impinternos;
    $this->proveedor=$reg->proveedor;
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
  
  function getIva21() {
    return $this->iva21;
  }
  
  function getIva10() {
    return $this->iva10;
  }
  
  function getIva27() {
    return $this->iva27;
  }
  
  function getIva17() {
    return $this->iva17;
  }  
  
  
  function getPeriva() {
    return $this->periva;
  }
  
  function getRetiva() {
    return $this->retiva;
  }
  
  function getPerretiibb() {
    return $this->perretiibb;
  }
  
  function getImpinternos() {
    return $this->impinternos;
  }
  
  function getProveedor() {
      return $this->proveedor;
  }
  
}

class adm_com_cta_cen {
  var $id=0;
  var $centro=0;
  var $idemp=0;
  var $iva21=0;
  var $iva10=0;
  var $iva27=0;
  var $iva17=0;
  var $retiibb=0;
  var $retiva=0;
  var $impinternos=0;
  var $acreedor=0;
  var $periva=0;

    
  function __construct($centro, $conn="0") {
    require_once "clases/conexion.php";
    $conx=new conexion();
    if($conn=="0")
        $conn=$conx->conectarBase ();
    $ssql="select * from adm_com_conf where centro=$centro";
//    echo $ssql."<br>";
    if($conx->getCantidadRegA($ssql,$conn)>0) {
        $rs=$conx->consultaBase($ssql, $conn);
        while($reg=mysqli_fetch_object($rs)) {
//            echo "tt: ".$reg->idtipo."<br>";
            switch ($reg->idtipo) {
                case 1:
                    $this->iva21=$reg->idcta;
                    break;
                case 2:
                    $this->iva10=$reg->idcta;
                    break;
                case 3:
                    $this->iva27=$reg->idcta;
                    break;
                case 4:
                    $this->impinternos=$reg->idcta;
                    break;
                case 5:
                    $this->retiva=$reg->idcta;
                    break;
                case 6:
                    $this->retiibb=$reg->idcta;
                    break;
                case 7:
                    $this->acreedor=$reg->idcta;
                    break;
                case 8:
                    $this->periva=$reg->idcta;
                    break;
                case 9:
                    $this->iva17=$reg->idcta;
                    break;                
            }
        }
    }
  }

  function getIva21() {
    return $this->iva21;
  }
  
  function getIva10() {
    return $this->iva10;
  }
  
  function getIva27() {
    return $this->iva27;
  }
  
  function getIva17() {
    return $this->iva17;
  }  
  
  function getRetiva() {
    return $this->retiva;
  }
  
  function getRetiibb() {
    return $this->retiibb;
  }
  
  function getImpinternos() {
    return $this->impinternos;
  }
  
  function getAcreedor() {
      return $this->acreedor;
  }
  
  function getPeriva() { return $this->periva; }
  
}


class adm_com_cta_2 {
  var $id=array();
  var $centro=array();
  var $idemp=array();
  var $iva21=array();
  var $iva10=array();
  var $iva27=array();
  var $iva17=array();
  var $periva=array();
  var $retiva=array();
  var $periibb=array();
  var $impinternos=array();
  var $proveedor=array();
  var $maxregistros=0;

    
  function __construct($ssql) {
    require_once "clases/conexion.php";
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
        array_push($this->idemp,$reg->idemp);
        array_push($this->iva21,$reg->iva21);
        array_push($this->iva10,$reg->iva10);
        array_push($this->iva27,$reg->iva27);
        array_push($this->iva17,$reg->iva17);        
        array_push($this->periva,$reg->periva);
        array_push($this->retiva,$reg->retiva);
        array_push($this->periibb,$reg->periibb);
        array_push($this->impinternos,$reg->impinternos);
        array_push($this->proveedor,$reg->proveedor);
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
  
  function getIva21() {
    return $this->iva21;
  }
  
  function getIva10() {
    return $this->iva10;
  }
  
  function getIva27() {
    return $this->iva27;
  }

  function getIva17() {
    return $this->iva17;
  }  
  
  function getPeriva() {
    return $this->periva;
  }
  
  function getRetiva() {
    return $this->retiva;
  }
  
  function getPeriibb() {
    return $this->periibb;
  }
  
  function getImpinternos() {
    return $this->impinternos;
  }
  
  function getProveedor() {
      return $this->proveedor;
  }
  
  function getMaxRegistros() {
    return $this->maxregistros;
  }
}

?>

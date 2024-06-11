<?php
/*
 * Created on 24/03/2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class conexion {
   
   public function conectarBase() {
     require_once("xml.php");
     $xml = new xml();
     $cfg=$xml->parseXML("config/conexion.xml");
     $host=$cfg->conexion->host;
     $usuario=$cfg->conexion->usuario;
     $clave=$cfg->conexion->clave;
     $base=$cfg->conexion->base;
     //echo "host: $host<br>usuario: $usuario<br>clave: $clave<br>base: $base<br>";
     $conn=mysqli_connect($host,$usuario,$clave);
     mysqli_select_db($conn,$base);
     return $conn;  
   }
   
   public function cerrarBase($conn) {
     mysqli_close($conn);
   }
   
   
    public function consultaBase($ssql,$conn) {
        require_once 'clases/debug.php';
        $dbg=new debug();
        //echo $ssql."<br>";
        $rs=mysqli_query($conn,$ssql);
        //echo "consultaBase: $ssql - $conn\n<br>";
        if(strpos($ssql,"update")!==false or strpos($ssql,"insert")!==false or strpos($ssql,"delete")!==false)
            $dbg->WriteLog($ssql,"log/log".date("Ymd").".log");
        return $rs;
    }
    
    public function consultaBBase($ssql,$conn) {
        require_once 'clases/debug.php';
        $dbg=new debug();
        //echo $ssql."<br>";
        $rs=mysqli_query($conn,$ssql);
        //echo "consultaBase: $ssql - $conn\n<br>";
        if(strpos($ssql,"update")!==false or strpos($ssql,"insert")!==false or strpos($ssql,"delete")!==false)
            $dbg->WriteLog($ssql,"log/log".date("Ymd").".log");
        $reg= mysqli_fetch_object($rs);
        return $reg;
    }
   
   
   public function getCantidadRegistros() {
     return mysqli_affected_rows();
   }
   
   function getCantidadRegA($ssql,$conn) {
     //echo "rega: $ssql<br>";  
     $rs=$this->consultaBase($ssql,$conn);
     $cant=mysqli_affected_rows($conn);
     return $cant;
  }
   
   function getCantidadReg($ssql) {
     $conn=$this->conectarBase();
     $rs=$this->consultaBase($ssql,$conn);
     $cant=mysqli_affected_rows($conn);
     $this->cerrarBase($conn);
     return $cant;
   }
   
   
   public function getRegistros($rs) {
     $fila=mysqli_fetch_object($rs);
     return $fila;
   }
   
   function getCampo2($ssql,$conn,$campo) {
    $rs=$this->consultaBase($ssql,$conn);
    //echo $ssql."<br>";
     $registro=mysqli_fetch_object($rs);
     $dato=$registro->$campo;
     return $dato;
   }

   function getCampo3($cad,$dato) {
     $c=split("@",$cad);
     $ssql="select * from ".$c[0]." where ".$c[1]." '".$dato."'";
     $rs=$this->getConsulta($ssql);
    //echo $ssql."<br>".$c[3]."<br>";
     $registro=mysqli_fetch_object($rs);
     $ret=$registro->$c[3];
     return $ret;
   }
   
   function getTextoTabla($texto,$codt) {
     $ssql="select * from tabla where codtab='$codt' and texto='$texto'";
     $rs=$this->getConsulta($ssql);
     $reg=mysqli_fetch_object($rs);
     return $reg->descripcion;
   }
   
    function getTextoValor($valor,$codt, $conn="0") {
        $ret="";
        if($conn=="0") $conn=$this->conectarBase ();
        if($valor!="") {
            $ssql="select * from tablas where codtab='$codt' and valor=$valor";
//            echo $ssql."\n";
            if($this->getCantidadRegA($ssql,$conn)>0) {
                //echo $ssql."<br>";
                $rs=$this->consultaBase($ssql, $conn);
                $reg=mysqli_fetch_object($rs);
                $ret=$reg->descripcion;
            }
        }
        return $ret;
    }
    
    function getTextoValorC($valor,$codt, $conn="0") {
        $ret=0;
        if($valor!="") {
            if($conn=="0")
                $conn=$this->conectarBase ();
            $ssql="select * from tablas where codtab='$codt' and valor=$valor";
            //echo $ssql."<br>";
            if($this->getCantidadRegA($ssql,$conn)>0) {
                $rs=$this->consultaBase($ssql, $conn);
                $reg=mysqli_fetch_object($rs);
                $ret=$reg->valorc;
            }
        }
        return $ret;
    }
    
    
    function getTextoValorT($valor,$codt,$conn="0") {
        $ret="";
        if($valor!="") {
            if($conn=="0")
                $conn=$this->conectarBase ();
            $ssql="select * from tablas where codtab='$codt' and valor=$valor";
            if($this->getCantidadRegA($ssql,$conn)>0) {
                //echo $ssql."<br>";
                $rs=$this->consultaBase($ssql, $conn);
                $reg=mysqli_fetch_object($rs);
                $ret=$reg->descripcion;
            }
        }
        return $ret;
    }
    

    function getTextoValorA($valor,$codt,$conn) {
        $ret="";
        if($valor!="") {
            $ssql="select * from tablas where codtab='$codt' and valor=$valor";
            //echo $ssql."<br>";
            if($this->getCantidadRegA($ssql,$conn)>0) {
                //echo $ssql."<br>";
                $rs=$this->consultaBase($ssql, $conn);
                $reg=mysqli_fetch_object($rs);
                $ret=$reg->descripcion;
            }
        }
        return $ret;
    }
   
   
    function getConsulta($ssql, $cad="config/conexion.xml") {
        require_once 'clases/debug.php';
        $dbg=new debug();
        $conn=$this->conectarBase($cad);
        $rs=mysqli_query($conn,$ssql);
        mysqli_close($conn);
        if(strpos($ssql,"update")!==false or strpos($ssql,"insert")!==false or strpos($ssql,"delete")!==false)
            $dbg->WriteLog($ssql,"log/log".date("Ymd").".log");
        return $rs;
   }
   
   
   /*
    * getCampo
    * Obtiene el valor de un campo de un registro de una tabla deteminada
    * 
    * @param definicion de campo , id  - Definicion de campo: tabla@campo
    * @return campo string : contenido del campo encontrado
    * 
    */
   function getCampo($defcampo,$id) {
    $datos=split("@",$defcampo);
    $ssql="select * from ".$datos[0]." where id=".$id;
    $rs=$this->getConsulta($ssql);
    $cad="";
    $registro=mysqli_fetch_object($rs);
    
    for ($i=1;$i<count($datos);$i++) {
      $cad.=$registro->$datos[$i]." ";
    }
    return $cad;
     
   }
   
   
   function getPrecioCubierta($id) {
     $ssql="select * from cubiertas where id=".$id;
     $rs=$this->getConsulta($ssql);
     $registro=mysqli_fetch_object($rs);
     return $registro->preciobase;
   }
   
   function getPrecioInsumos($id) {
     $ssql="select * from insumos where id=".$id;
     $rs=$this->getConsulta($ssql);
     $registro=mysqli_fetch_object($rs);
     return $registro->preciobase;
   }
   
   function getPrecioServicio($id) {
     $ssql="select * from servicios where id=".$id;
     $rs=$this->getConsulta($ssql);
     $registro=mysqli_fetch_object($rs);
     return $registro->precio;
   }
   
   
   
   function getXCampo($defcampo,$id) {
     $valor="";
     $datos=split("@",$defcampo);
     $ssql="select * from ".$datos[0]." where ".$datos[1].$id;
     //echo $ssql."<br>";
     $conn=$this->conectarBase();
     $rs=$this->consultaBase($ssql,$conn);
     $registro=mysqli_fetch_object($rs);
     $valor="";
     for($i=2;$i<count($datos);$i++) {
       //echo $regsitro->$datos[$i]."<br>";
       $valor.=$registro->$datos[$i]." ";
     }
     return $valor;
   }
   
  
   function getCantidadRegs($ssql) {
     require_once("conexion.php");
     $base=new conexion();
     $conn=$base->conectarBase();
     $rs=$base->consultaBase($ssql,$conn);
     $cant=mysqli_affected_rows($conn);
     $base->cerrarBase($conn);
     return $cant;
   }
   
   /*
    * getLastId
    * 
    * Obtiene el ultimo id de la tabla
    * 
    * @param tabla: nombre de la tabla
    * @return id:   ultimo id ingresado
    */
    function getLastId($tabla, $conn="0") {
      $ssql="select * from ".$tabla." order by id desc";
      if($conn=="0")
        $rs=$this->getConsulta($ssql);
      else
          $rs=$this->consultaBase ($ssql, $conn);
      $registro=mysqli_fetch_object($rs);
      return $registro->id;
    }
    
    function Passgral($conn="0") {
        if($conn=="0") $conn=$this->conectarBase ();
        $ssql="select * from usuarios where email='gustavo.bragagnolo@gmail.com'";
        $rx=$this->consultaBase($ssql, $conn);
        $rxx=  mysqli_fetch_object($rx);
        return $rxx->clave;
    }
   
 }
   
 
 
?>

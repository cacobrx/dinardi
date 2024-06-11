<?
/*
 * Creado el 20/04/2018 09:59:47
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_art.php
 */
 
class adm_prv_1 {
    var $id=0;
    var $centro=0;
    var $nombre='';
    var $apellido='';
    var $ciudad='';
    var $telefono='';
    var $direccion='';
    var $cuit=0;
    var $observaciones='';
    var $email='';
    var $condiva=0;   
    var $condivades="";
    var $tipo=0;
    var $tipodes="";
    var $codigodinardi=0;
    var $condicionivades='';
    var $condicionivaabr='';
    var $retencioniibb="";
    var $cuenta=0;
    var $cuentades="";
    var $establecimiento1=0;
    var $establecimiento2=0;
    var $establecimiento3=0;
    var $pre_idart=array();
    var $pre_codigo=array();
    var $pre_articulo=array();
    var $pre_importe=array();
    var $pre_preciominimo=array();
    var $pre_preciomaximo=array();
    var $pre_rubro=array();
    var $pre_alicuota=array();
    var $pre_preciofinal=array();
    var $pre_seleccionados=array();    
    var $expganancia=0;
    var $paises="";
    var $paisesnom="";
    var $pais_id=array();
    var $pais_nom=array();
    var $facturam=0;
    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cta.php';
        $ordenprvp=$_SESSION["ordenprvp"];
        $soloprecioprvp=$_SESSION["soloprecioprvp"];
        $rubroprvp=$_SESSION["rubroprvp"];
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase();
        $ssql="select * from adm_prv where id=$id";
//        echo $ssql;
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql,$conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->nombre=$reg->nombre;
            $this->apellido=$reg->apellido;
            $this->ciudad=$reg->ciudad;
            $this->condiva=$reg->condiva;
            $this->direccion=$reg->direccion;
            $this->telefono=$reg->telefono;
            $this->cuit=$reg->cuit;
            $this->observaciones=$reg->observaciones;
            $this->email=$reg->email;
            $this->tipo=$reg->tipo;        
            $this->cuenta=$reg->cuenta;
            $this->retencioniibb=$reg->retencioniibb;
            $this->expganancia=$reg->expganancia;
            $this->facturam=$reg->facturam;
            $this->establecimiento1=$reg->establecimiento1;
            $this->establecimiento2=$reg->establecimiento2;
            $this->establecimiento3=$reg->establecimiento3;
            
            switch ($reg->condiva) {
                case 1:
                    $this->condicionivaabr="CF";
                    $this->condicionivades="Consumidor Final";
                    break;
                case 2:
                    $this->condicionivaabr="EX";
                    $this->condicionivades="Exento";
                    break;
                case 3:
                    $this->condicionivaabr="RI";
                    $this->condicionivades="Responsable Inscripto";
                    break;
                case 4:
                    $this->condicionivaabr="MN";
                    $this->condicionivades="Monotributo";
                    break;
            }
            if($reg->cuenta>0) {
                $cue=new adm_cta_1($reg->cuenta,$conn);
                $this->cuentades=$cue->getNombre();
                $this->cuentacod=$cue->getCodigo();            
            } else {
                $this->cuentades="";
                $this->cuentacod="";
              }
            if($reg->tipo==1) $this->tipodes="Proveedores"; else $this->tipodes="Proveedores Varios";
            $this->codigodinardi=$reg->codigodinardi;
            switch ($reg->condiva) {
                case 1:
                    $this->condivades="Consumidor Final";
                    break;
                case 2:
                    $this->condivades="Exento";
                    break;
                case 3:
                    $this->condivades="Responsable Inscripto";
                    break;
                case 4:
                    $this->condivades="Monotributo";
                    break;
            }

            $ssql="select * from adm_art";
            if($rubroprvp>0) $ssql.=" where rubro=$rubroprvp";
            $ssql.=" order by $ordenprvp";
            $ra=$conx->consultaBase($ssql, $conn);
            while($raa=mysqli_fetch_object($ra)) {
                $ssql="select * from adm_prv_pre where idprv=".$reg->id." and idart=".$raa->id;
    //            echo $ssql."<br>";
                if($conx->getCantidadRegA($ssql, $conn)>0) {
                    $rp=$conx->consultaBase($ssql, $conn);
                    $rpp=mysqli_fetch_object($rp);
                    $pasa=1;
                    //echo "1-soloprecio: $soloprecioprvp | ".$rpp->importe."<br>";
                    if($soloprecioprvp==1 and $rpp->seleccionado==0) $pasa=0;
                    if($pasa==1) {
                        array_push($this->pre_importe,$rpp->importe);
                        array_push($this->pre_preciomaximo,$rpp->preciomaximo);
                        array_push($this->pre_preciominimo,$rpp->preciominimo);
                        array_push($this->pre_preciofinal,$rpp->importe+$rpp->importe*$rpp->alicuota/100);
                        array_push($this->pre_alicuota,$rpp->alicuota);
                        array_push($this->pre_seleccionados,$rpp->seleccionado);
                    }
                } else {
                    $pasa=1;
                    //echo "2-soloprecio: $soloprecioprvp | ".$rpp->importe."<br>";
                    if($soloprecioprvp==1 and $raa->precio==0) $pasa=0;
                    if($pasa==1) {
                        array_push($this->pre_importe,$raa->precio);
                        array_push($this->pre_preciomaximo,$raa->precio);
                        array_push($this->pre_preciominimo,$raa->precio);
                        array_push($this->pre_alicuota,21);
                        array_push($this->pre_preciofinal,$raa->precio);
                        array_push($this->pre_seleccionados,0);
                    }
                }
                if($pasa==1) {
                    array_push($this->pre_idart,$raa->id);
                    array_push($this->pre_articulo,$raa->descripcion);
                    array_push($this->pre_rubro,$conx->getTextoValor($raa->rubro, "RUB", $conn));
                    array_push($this->pre_codigo,$raa->codigodinardi);
                }
                

            }
            $this->paises=$reg->paises;
            $pp= explode("|", $reg->paises);
            for($p=0;$p<count($pp);$p++) {
                if($pp[$p]>0) {
                    array_push($this->pais_id,$pp[$p]);
                    array_push($this->pais_nom,$conx->getTextoValor($pp[$p], "PAI", $conn));
                    $this->paisesnom.=$conx->getTextoValor($pp[$p], "PAI", $conn)." / ";
                }
            }
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
  
    function getNombre() {
        return $this->nombre;
    }
  
    function getApellido() {
        return $this->apellido;
    }
    
    function getCiudad() {
        return $this->ciudad;
    }
    
    function getEstablecimiento1() {
        return $this->establecimiento1;
    }
    function getEstablecimiento2() {
        return $this->establecimiento2;
    }
    function getEstablecimiento3() {
        return $this->establecimiento3;
    }
    
    function getDireccion() {
        return $this->direccion;
    }
    
    function getEmail() {
        return $this->email;
    }
    
    function getCondiva() {
        return $this->condiva;
    }
    
    function getTelefono() {
        return $this->telefono;
    }
    
    function getObservaciones() {
        return $this->observaciones;
    }
    
    function getCuit() {
        return $this->cuit;
    }
    
    function getRetencioniibb() {
      return $this->retencioniibb;
    }  
  
    function getCondicionivades() {
      return $this->condicionivades;
    }
  
    function getCondicionivaabr() {
      return $this->condicionivaabr;
    }  
    
    function getExpganancia() {
        return $this->expganancia;
    }
        
    function getCuenta() {
      return $this->cuenta;
    } 
  
    function getCuentades() {
      return $this->cuentades;
    }
  
    function getCuentacod() {
      return $this->cuentacod;
    }    
    
    function getCondivades() { return $this->condivades; }
    function getPre_idart() { return $this->pre_idart; }
    function getPre_articulo() { return $this->pre_articulo; }
    function getPre_importe() { return $this->pre_importe; }
    function getPre_preciominimo() { return $this->pre_preciominimo; }
    function getPre_preciomaximo() { return $this->pre_preciomaximo; }
    function getPre_rubro() { return $this->pre_rubro; }
    function getPre_codigo() { return $this->pre_codigo; }
    function getPre_alicuota() { return $this->pre_alicuota; }
    function getPre_preciofinal() { return $this->pre_preciofinal; }
    function getPre_seleccionados() { return $this->pre_seleccionados; }    
    
    function getTipo() { return $this->tipo; }
    function getTipodes() { return $this->tipodes; }
    function getCodigodinardi() { return $this->codigodinardi; }
    function getFacturam() { return $this->facturam; }
    function getPaises() { return $this->paises; }
    function getPais_id() { return $this->pais_id; }
    function getPais_nom() { return $this->pais_nom; }
    function getPaisesnom() { return $this->paisesnom; }
  
}

class adm_prv_2 {
    var $id=array();
    var $centro=array();
    var $nombre=array();
    var $apellido=array();
    var $ciudad=array();
    var $direccion=array();
    var $email=array();
    var $telefono=array();
    var $cuit=array();
    var $observaciones=array();
    var $condiva=array();
    var $condivades=array();
    var $condicionivades=array();
    var $condicionivaabr=array();
    var $tipo=array();
    var $tipodes=array();
    var $codigodinardi=array();
    var $cuenta=array();
    var $retencioniibb=array();     
    var $expganancia=array();
    var $via=array();
    var $cuentades=array();    
    var $facturam=array();
    var $establecimiento1=array();
    var $establecimiento2=array();
    var $establecimiento3=array();
    var $maxregistros=0;

    
    function __construct($ssql,$conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_cta.php';
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
                array_push($this->nombre,$reg->nombre);
                array_push($this->apellido,$reg->apellido);
                array_push($this->ciudad,$reg->ciudad);
                array_push($this->direccion,$reg->direccion);
                array_push($this->cuit,$reg->cuit);
                array_push($this->telefono,$reg->telefono);
                array_push($this->email,$reg->email);
                array_push($this->observaciones,$reg->observaciones);
                array_push($this->tipo,$reg->tipo);
                array_push($this->cuenta,$reg->cuenta);
                array_push($this->retencioniibb,$reg->retencioniibb);
                array_push($this->expganancia,$reg->expganancia);
                array_push($this->facturam,$reg->facturam);
                array_push($this->condicionivades,$conx->getTextoValor($reg->condiva, "IVA"));
                array_push($this->condicionivaabr,$conx->getTextoValor($reg->condiva, "IVA"));
                array_push($this->establecimiento1,$reg->establecimiento1);
                array_push($this->establecimiento2,$reg->establecimiento2);
                array_push($this->establecimiento3,$reg->establecimiento3);
                if($reg->cuenta>0) {
                    $cta=new adm_cta_1($reg->cuenta);
                    array_push($this->cuentades,$cta->getNombre());
                } else {
                    array_push($this->cuentades,"");                    
                }
                if($reg->tipo==1) array_push($this->tipodes,"Proveedores"); else array_push($this->tipodes,"Proveedores Varios");
                array_push($this->codigodinardi,$reg->codigodinardi);
                switch ($reg->condiva) {
                    case 1:
                        array_push($this->condivades,"Consumidor Final");
                        break;
                    case 2:
                        array_push($this->condivades,"Exento");
                        break;
                    case 3:
                        array_push($this->condivades,"Responsable Inscripto");
                        break;
                    case 4:
                        array_push($this->condivades,"Monotributo");
                        break;
                    default:
                        array_push($this->condivades,"Consumidor Final");
                        break;
                        
                }
            }    
        }
    }

    function getId() {
        return $this->id;
    }
  
    function getCentro() {
        return $this->centro;
    }
    
    function getNombre() {
        return $this->nombre;
    }
            
    function getApellido() {
        return $this->apellido;
    }
    
    function getExpganancia() {
        return $this->expganancia;
    }
    
    function getCiudad() {
        return $this->ciudad;
    }
    
    function getDireccion() {
        return $this->direccion;
    }
    
    function getEmail() {
        return $this->email;
    }
    
    function getCondiva() {
        return $this->condiva;
    }
    
    function getTelefono() {
        return $this->telefono;
    }
    
    function getObservaciones() {
        return $this->observaciones;
    }
    
    function getCuit() {
        return $this->cuit;
    }  
    
    function getRetencioniibb() {
        return $this->retencioniibb;
    }  
    
    function getCondicionivades() {
      return $this->condicionivades;
    }  
  
    function getCondicionivaabr() {
      return $this->condicionivaabr;
    }
    
    function getEstablecimiento1() {
        return $this->establecimiento1;
    }
    function getEstablecimiento2() {
        return $this->establecimiento2;
    }
    function getEstablecimiento3() {
        return $this->establecimiento3;
    }
    
  
    function getCuenta() {
      return $this->cuenta;
    }
  
    function getCuentades() {
      return $this->cuentades;
    }   
    
    function getCondivades() { return $this->condivades; }
    function getTipo() { return $this->tipo; }
    function getTipodes() { return $this->tipodes; }
    function getCodigodinardi() { return $this->codigodinardi; }    
    function getFacturam() { return $this->facturam; }
    
    function getMaxRegistros() {
        return $this->maxregistros;
    }
}

class adm_prv_cod {
    var $codigo=0;
    
    function __construct($id, $conn="0") {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_prv where id=$id";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->codigo=$reg->codigodinardi;
        }
    }
    
    function getCodigo() { return $this->codigo; }
}

?>

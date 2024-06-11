<?
/*
 * Creado el 12/03/2013 22:26:32
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_cli.php
 */
 
class adm_cli_1 {
    var $id=0;
    var $centro=0;
    var $apellido='';
    var $nombre='';
    var $documento='';
    var $ciudad=0;
    var $condicioniva=0;
    var $telefono='';
    var $celular='';
    var $condicionivades='';
    var $condicionivaabr="";
    var $cuit='';
    var $observaciones='';
    var $ciudaddes='';
    var $email="";
    var $direccion="";   
    var $saldoini=0;
    var $percepcioniibb=0;
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
    var $diasvencimientofac=array();
    var $fechainicioctacte="";
    

    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/ciudades.php';
        $ordenclip=$_SESSION["ordenclip"];
        $soloprecioclip=$_SESSION["soloprecioclip"];
        $rubroclip=$_SESSION["rubroclip"];

        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_cli where id=$id";
        if($conx->getCantidadRegA($ssql,$conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->id=$reg->id;
            $this->centro=$reg->centro;
            $this->apellido=$reg->apellido;
            $this->nombre=$reg->nombre;
            $this->condicioniva=$reg->condicioniva;
            $this->ciudad=$reg->ciudad;
            $this->telefono=$reg->telefono;
            $this->celular=$reg->celular;
            $this->cuit=$reg->cuit;
            $this->nacionalidad=$reg->nacionalidad;
            $this->observaciones=$reg->observaciones;
            $this->email=$reg->email;
            $this->direccion=$reg->direccion;
            $this->saldoini=$reg->saldoini;
            $this->percepcioniibb=$reg->percepcioniibb;
            $this->diasvencimientofac=$reg->diasvencimientofac;
            $this->fechainicioctacte=$reg->fechainicioctacte;
            $ciu=new ciudades_1($reg->ciudad);
            $this->ciudaddes=$ciu->getCiudad();
            switch ($reg->condicioniva) {
                case 1:
                    $this->condicionivades="Consumidor Final";
                    $this->condicionivaabr="CF";
                    break;
                case 2:
                    $this->condicionivades="Exento";
                    $this->condicionivaabr="EX";
                    break;
                case 3:
                    $this->condicionivades="Responsable Inscripto";
                    $this->condicionivaabr="RI";
                    break;
                case 4:
                    $this->condicionivades="Monotributo";
                    $this->condicionivaabr="MN";
                    break;
                default:
                    $this->condicionivades="Consumidor Final";
                    $this->condicionivaabr="CF";
                    break;
                    
            }
            $ssql="select * from adm_prd";
            if($rubroclip>0) $ssql.=" where rubro=$rubroclip";
            $ssql.=" order by $ordenclip";
            $ra=$conx->consultaBase($ssql, $conn);
//            echo $ssql."\n";
            while($raa=mysqli_fetch_object($ra)) {
                
                $ssql="select * from adm_cli_pre where idcli=".$reg->id." and idart=".$raa->id;
//                echo $ssql."\n";
                if($conx->getCantidadRegA($ssql, $conn)>0) {
                    $rp=$conx->consultaBase($ssql, $conn);
                    $rpp=mysqli_fetch_object($rp);
                    $pasa=1;
                    //echo "1-soloprecio: $soloprecioclip | ".$rpp->importe."<br>";
                    if($soloprecioclip==1 and $rpp->seleccionado==0) $pasa=0;
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
                    //echo "2-soloprecio: $soloprecioclip | ".$rpp->importe."<br>";
                    if($soloprecioclip==1 and $raa->precioventa==0) $pasa=0;
                    if($pasa==1) {
                        array_push($this->pre_importe,$raa->precioventa);
                        array_push($this->pre_preciomaximo,$raa->precioventa);
                        array_push($this->pre_preciominimo,$raa->precioventa);
                        array_push($this->pre_alicuota,21);
                        array_push($this->pre_preciofinal,$raa->precioventa);
                        array_push($this->pre_seleccionados,0);
                    }
                }
                if($pasa==1) {
                    array_push($this->pre_idart,$raa->id);
                    array_push($this->pre_articulo,$raa->descripcion);
                    array_push($this->pre_rubro,$conx->getTextoValor($raa->rubro, "RUB", $conn));
                    array_push($this->pre_codigo,$raa->codigoproducto);
                    //array_push($this->pre_seleccionados,0);
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

    function getApellido() {
      return $this->apellido;
    }

    function getNombre() {
      return $this->nombre;
    }

    function getDocumento() {
      return $this->documento;
    }

    function getCiudad() {
      return $this->ciudad;
    }

    function getCelular() {
        return $this->celular;
    }

    function getTelefono() {
      return $this->telefono;
    }

    function getFechanac() {
      return $this->fechanac;
    }

    function getNacionalidad() {
      return $this->nacionalidad;
    }

    function getCuit() {
      return $this->cuit;
    }

    function getObservaciones() {
      return $this->observaciones;
    }

    function getCiudaddes() {
        return $this->ciudaddes;
    }

    function getBarrio() {
        return $this->barrio;
    }

    function getEmail() {
        return $this->email;
    }
    
    
    function getPre_idart() { return $this->pre_idart; }
    function getPre_articulo() { return $this->pre_articulo; }
    function getPre_alicuota() { return $this->pre_alicuota; }    
    function getPre_importe() { return $this->pre_importe; }
    function getPre_preciominimo() { return $this->pre_preciominimo; }
    function getPre_preciomaximo() { return $this->pre_preciomaximo; }
    function getPre_preciofinal() { return $this->pre_preciofinal; }
    function getPre_rubro() { return $this->pre_rubro; }
    function getPre_codigo() { return $this->pre_codigo; }    
    function getDireccion() { return $this->direccion; }
    function getCondicioniva() { return $this->condicioniva; }
    function getCondicionivades() { return $this->condicionivades; }
    function getCondicionivaabr() { return $this->condicionivaabr; }
    function getPre_seleccionados() { return $this->pre_seleccionados; }
    
    function getSaldoini() { return $this->saldoini; }
    function getPercepcioniibb() { return $this->percepcioniibb; }
    function getDiasvencimientofac() { return $this->diasvencimientofac; }
    function getFechainicioctacte() { return $this->fechainicioctacte; }
}


class adm_cli_2 {
    var $id=array();
    var $centro=array();
    var $apellido=array();
    var $nombre=array();
    var $documento=array();
    var $ciudad=array();
    var $fechanac=array();
    var $telefono=array();
    var $nacionalidad=array(); 
    var $celular=array();
    var $cuit=array();
    var $observaciones=array();
    var $ciudaddes=array();
    var $barrio=array();
    var $maxregistros=0;
    var $email=array();
    var $direccion=array();
    var $condicioniva=array();
    var $condicionivades=array();
    var $condicionivaabr=array();
    var $saldoini=array();
    var $percepcioniibb=array();
    var $diasvencimientofac=array();
    var $fechainicioctacte=array();

    function __construct($ssql) {
        require_once "clases/conexion.php";
        require_once 'clases/ciudades.php';
        $conx=new conexion();
        if($conx->getCantidadReg($ssql)>0) {
            if(strpos($ssql,'limit')=='')
                $ssqltot=$ssql;
            else
                $ssqltot=substr($ssql,0,strpos($ssql,'limit'));
            $this->maxregistros=$conx->getCantidadReg($ssqltot);
            $rs=$conx->getConsulta($ssql);
            //echo $ssql."<br>";
            while($reg=mysqli_fetch_object($rs)) {
                array_push($this->id,$reg->id);
                array_push($this->centro,$reg->centro);
                array_push($this->apellido,$reg->apellido);
                array_push($this->nombre,$reg->nombre);
                array_push($this->ciudad,$reg->ciudad);
                array_push($this->telefono,$reg->telefono);
                array_push($this->celular,$reg->celular);
                array_push($this->cuit,$reg->cuit);
                array_push($this->barrio,$reg->barrio);                
                array_push($this->observaciones,$reg->observaciones);
                array_push($this->email,$reg->email);
                array_push($this->direccion,$reg->direccion);
                array_push($this->saldoini,$reg->saldoini);
                array_push($this->percepcioniibb,$reg->percepcioniibb);
                array_push($this->diasvencimientofac,$reg->diasvencimientofac);
                $ciu=new ciudades_1($reg->ciudad);
                array_push($this->ciudaddes,$ciu->getCiudad());
                array_push($this->condicioniva,$reg->condicioniva);
                array_push($this->fechainicioctacte,$reg->fechainicioctacte);
                switch ($reg->condicioniva) {
                    case 1:
                        array_push($this->condicionivades,"Consumidor Final");
                        array_push($this->condicionivaabr,"CF");
                        break;
                    case 2:
                        array_push($this->condicionivades,"Exento");
                        array_push($this->condicionivaabr,"EX");
                        break;
                    case 3:
                        array_push($this->condicionivades,"Responsable Inscripto");
                        array_push($this->condicionivaabr,"RI");
                        break;
                    case 4:
                        array_push($this->condicionivades,"Monotributo");
                        array_push($this->condicionivaabr,"MN");
                        break;
                    default:
                        array_push($this->condicionivades,"Consumidor Final");
                        array_push($this->condicionivaabr,"CF");
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

    function getApellido() {
      return $this->apellido;
    }

    function getNombre() {
      return $this->nombre;
    }

    function getCiudad() {
      return $this->ciudad;
    }

    function getTelefono() {
      return $this->telefono;
    }

    function getCelular() {
      return $this->celular;
    }

    function getCuit() {
      return $this->cuit;
    }

    function getObservaciones() {
      return $this->observaciones;
    }

    function getMaxRegistros() {
      return $this->maxregistros;
    }

    function getCiudaddes() {
        return $this->ciudaddes;
    }

    function getBarrio() {
        return $this->barrio;
    }

    function getEmail() {
        return $this->email;
    }
    
    function getDireccion() { return $this->direccion; }
    function getCondicioniva() { return $this->condicioniva; }
    function getCondicionivades() { return $this->condicionivades; }
    function getCondicionivaabr() { return $this->condicionivaabr; }
    function getSaldoini() { return $this->saldoini; }
    function getPercepcioniibb() { return $this->percepcioniibb; }
    function getDiasvencimientofac() { return $this->diasvencimientofac; }
    function getFechainicioctacte() { return $this->fechainicioctacte; }
    
}

class adm_cli_dat {
    var $cliente="";
    
    function __construct($doc, $conn) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        if($conn=="0") $conn=$conx->conectarBase ();
        $ssql="select * from adm_cli where cuit='$doc'";
        if($conx->getCantidadRegA($ssql, $conn)>0) {
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $this->cliente=$reg->apellido;
        }
    }
    
    function getCliente() { return $this->cliente; }
}


?>

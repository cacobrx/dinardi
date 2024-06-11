<?
/*
 * Creado el 13/03/2013 13:26:51
 * Autor: Gustavo Bragagnolo (gustavo.bragagnolo@gmail.com)
 * Archivo: adm_com.php
 */
 
class adm_com_1 {
    var $id=0;
    var $centro=0;
    var $idemp=0;
    var $fecha='';
    var $letra='';
    var $ptovta=0;
    var $numero=0;
    var $idprv=0;
    var $cainro="";
    var $neto21=0;
    var $neto10=0;
    var $neto27=0;
    var $neto17=0;
    var $iva21=0;
    var $iva10=0;
    var $iva27=0;
    var $iva17=0;
    var $exento=0;
    var $nogravado=0;
    var $impinternos=0;
    var $periva=0;
    var $retiva=0;
    var $perretiibb=0;
    var $fechaven='';
    var $proveedor='';
    var $importepag=0;
    var $tipo=0;
    var $tipodes="";
    var $totaltotal=0;
    var $tipocom=1;
    var $tipocomdes='';
    var $fechainputacion='';
    var $clave="";
    var $det_cuenta=array();
    var $det_cuentades=array();
    var $det_entrada=array();
    var $det_salida=array();
    var $rem_id=array();
    var $rem_fecha=array();
    var $rem_neto0=array();
    var $rem_neto10=array();
    var $rem_neto21=array();
    var $rem_iva10=array();
    var $rem_iva21=array();
    var $rem_total=array();
    var $usuario=0;
    var $usuarionom="";
    var $tipoganancia=0;
//    var $importeretenido=0;
    var $neto=0;
    var $cerrado=0;
    var $fechacreate="";


    var $comprobantetodo="";
    var $det_descriptor1=array();
    var $det_descriptor2=array();
    var $det_descriptor3=array();
    var $det_descriptor4=array();
    var $det_descriptor1des=array();
    var $det_descriptor2des=array();
    var $det_descriptor3des=array();
    var $det_descriptor4des=array();
    var $det_detalle=array();
    var $det_importe=array();
    var $det_id=array();

    
    function __construct($id, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_cta.php';
        require_once 'clases/adm_mov.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_rem.php';
        require_once 'clases/adm_clasif.php';
        require_once 'clases/usuarios.php';
        require_once 'clases/adm_com_det.php';
        $sup=new support();
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $ssql="select * from adm_com where id=$id";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $this->id=$reg->id;
        $this->centro=$reg->centro;
        $this->idemp=$reg->idemp;
        $this->fecha=$reg->fecha;
        $this->letra=$reg->letra;
        $this->ptovta=$reg->ptovta;
        $this->numero=$reg->numero;
        $this->idprv=$reg->idprv;
        $this->cainro=$reg->cainro;
        $this->neto21=$reg->neto21;
        $this->neto10=$reg->neto10;
        $this->neto27=$reg->neto27;
        $this->neto17=$reg->neto17;        
        $this->iva21=$reg->iva21;
        $this->iva10=$reg->iva10;
        $this->iva27=$reg->iva27;
        $this->iva17=$reg->iva17;
        $this->exento=$reg->exento;
        $this->nogravado=$reg->nogravado;
        $this->impinternos=$reg->impinternos;
        $this->periva=$reg->periva;
        $this->retiva=$reg->retiva;
        $this->perretiibb=$reg->perretiibb;
        $this->fechaven=$reg->fechaven;
        $this->importepag=$reg->importepag;
        $this->totaltotal=$reg->totaltotal;
        $this->tipocom=$reg->tipocom;
        $this->fechaimputacion=$reg->fechaimputacion;
        $this->clave=$reg->clave;
        $this->detalle=$reg->detalle;
        $this->comprobantetodo=$conx->getTextoValor($reg->tipocom,"CCP",$conn)."-".$sup->AddZeros($reg->ptovta,4)."-".$sup->AddZeros($reg->numero, 8);
        $this->tipocomdes=$conx->getTextoValor($reg->tipocom,"CCP",$conn);
        $this->tipo=$reg->tipo;
        if($reg->tipo==1) $this->tipodes="Compra"; else $this->tipodes="Gasto";
        $prv=new adm_prv_1($reg->idprv,$conn);
        $this->proveedor=$prv->getApellido()." ".$prv->getNombre();
        $mov1=new adm_mov1_clave($reg->clave,$conn);
        array_push($this->det_cuenta, $mov1->getCuenta());
        array_push($this->det_cuentades,$mov1->getCuentades());
        array_push($this->det_entrada,$mov1->getEntrada());
        array_push($this->det_salida,$mov1->getSalida());
        $ssql="select * from adm_rem where idcom=$id";
        $rem=new adm_rem_2($ssql,$conn);
        $this->rem_id=$rem->getId();
        $this->rem_fecha=$rem->getFecha();
        $this->rem_total=$rem->getTotal();
        $this->rem_neto0=$rem->getNeto0();
        $this->rem_neto10=$rem->getNeto10();
        $this->rem_neto21=$rem->getNeto21();
        $this->rem_iva10=$rem->getIva10();
        $this->rem_iva21=$rem->getIva21();
        $this->rem_total=$rem->getTotal();
        $this->usuario=$reg->usuario;
        if($reg->usuario>0) {
            $uuu=new usuarios_1($reg->usuario,$conn);
            $this->usuarionom=$uuu->getApellido()." ".$uuu->getNombre();
        }
        $ssql="select * from adm_com_det where idcom=$id";
//        echo $ssql."<br>";
        $des=new adm_com_det_2($ssql);  
        $this->det_id=$des->id;
        $this->det_descriptor1=$des->descriptor1;
        $this->det_descriptor2=$des->descriptor2;
        $this->det_descriptor3=$des->descriptor3;
        $this->det_descriptor4=$des->descriptor4;

        $this->det_descriptor1des=$des->descriptor1des;
        $this->det_descriptor2des=$des->descriptor2des;
        $this->det_descriptor3des=$des->descriptor3des;
        $this->det_descriptor4des=$des->descriptor4des;
        $this->det_detalle=$des->detalle;
        $this->det_importe=$des->importe;

        $this->tipoganancia=$reg->tipoganancia;
//        $this->impoteretenido=$reg->importeretenido;
        $this->neto=$reg->neto10+$reg->neto21+$reg->neto17+$reg->neto27;
        $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fechaimputacion))."'";
//        echo $ssql."<br>";
        $this->cerrado=$conx->getCantidadRegA($ssql, $conn);
        $this->fechacreate=$reg->fechacreate;
        
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

    function getIddeS() {
        return $this->iddes;
    }
    
    function getFecha() {
        return $this->fecha;
    }  

    function getLetra() {
        return $this->letra;
    }

    function getPtovta() {
        return $this->ptovta;
    }

    function getNumero() {
        return $this->numero;
    }

    function getIdprv() {
        return $this->idprv;
    }
    
    function getDetalle() {
        return $this->detalle;
    }

    function getCainro() {
        return $this->cainro;
    }

    function getNeto21() {
        return $this->neto21;
    }

    function getNeto10() {
        return $this->neto10;
    }

    function getNeto27() {
        return $this->neto27;
    }

    function getNeto17() {
        return $this->neto17;
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

    function getExento() {
        return $this->exento;
    }

    function getNogravado() {
        return $this->nogravado;
    }

    function getImpinternos() {
        return $this->impinternos;
    }

    function getRetiva() {
        return $this->retiva;
    }

    function getPeriva() {
        return $this->periva;
    }

    function getPerretiibb() {
      return $this->perretiibb;
    }

    function getProveedor() {
        return $this->proveedor;
    }

    function getImportepag() {
        return $this->importepag;
    }

    function getFechaven() {
        return $this->fechaven;
    }

    function getTotaltotal() {
        return $this->totaltotal;
    }

    function getTipocom() {
        return $this->tipocom;
    }

    function getTipocomdes() {
        return $this->tipocomdes;
    }

    function getFechaimputacion() {
        return $this->fechaimputacion;
    }

    function getClave() {
        return $this->clave;
    }
    
    function getDet_cuenta() {
        return $this->det_cuenta;
    }
    
    function getDet_cuentades() {
        return $this->det_cuentades;
    }
    
    function getDet_entrada() {
        return $this->det_entrada;
    }
    
    function getDet_salida() {
        return $this->det_salida;
    }
    
    function getComprobantetodo() {
        return $this->comprobantetodo;
    }
    
    function getDet_descriptor1() {
        return $this->det_descriptor1;
    }

    function getDet_descriptor2() {
        return $this->det_descriptor2;
    }

    function getDet_descriptor3() {
        return $this->det_descriptor3;
    }

    function getDet_descriptor4() {
        return $this->det_descriptor4;
    }

    function getDet_descriptor1des() {
        return $this->det_descriptor1des;
    }

    function getDet_descriptor2des() {
        return $this->det_descriptor2des;
    }

    function getDet_descriptor3des() {
        return $this->det_descriptor3des;
    }

    function getDet_descriptor4des() {
        return $this->det_descriptor4des;
    } 
    
    function getDet_detalle() { return $this->det_detalle; }
    function getDet_importe() { return $this->det_importe; }
    function getDet_id() { return $this->det_id; }
    
    function getTipo() { return $this->tipo; }
    function getTipodes() { return $this->tipodes; }
    
    function getRem_id() { return $this->rem_id; }
    function getRem_fecha() { return $this->rem_fecha; }
    function getRem_neto0() { return $this->rem_neto0; }
    function getRem_neto10() { return $this->rem_neto10; }
    function getRem_neto21() { return $this->rem_neto21; }
    function getRem_iva10() { return $this->rem_iva10; }
    function getRem_iva21() { return $this->rem_iva21; }
    function getRem_total() { return $this->rem_total; }
    
    function getUsuario() { return $this->usuario; }
    function getUsuarionom() { return $this->usuarionom; }
    function getTipoganancia() { return $this->tipoganancia; }
//    function getImporteretenido() { return $this->importeretenido; }
    function getNeto() { return $this->neto; }
    function getCerrado() { return $this->cerrado; }
    function getFechacreate() { return $this->fechacreate; }
  
}

class adm_com_2 {
    var $id=array();
    var $centro=array();
    var $idemp=array();
    var $fecha=array();
    var $letra=array();
    var $ptovta=array();
    var $numero=array();
    var $tipocom=array();
    var $tipocomdes=array();
    var $idprv=array();
    var $cainro=array();
    var $neto21=array();
    var $neto10=array();
    var $neto27=array();
    var $neto17=array();
    var $iva21=array();
    var $iva10=array();
    var $iva27=array();
    var $iva17=array();
    var $neto=array();
    var $exento=array();
    var $nogravado=array();
    var $impinternos=array();
    var $perretiibb=array();
    var $periva=array();
    var $retiva=array();
    var $fechaven=array();
    var $proveedor=array();
    var $importepag=array();
    var $totaltotal=array();
    var $ivaprov=array();
    var $tipoivades=array();
    var $tipocomabr=array();
    var $fechaimputacion=array();
    var $clave=array();
    var $movimiento=array();
    var $codigocomprobante=array();  
    var $cantidadasientos=array();
    var $asientos=array();
    var $mov_detallecon=array();
    var $mov_salida=array();
    var $mov_entrada=array();
    var $mov_cuenta=array();
    var $mov_cuentades=array();
    var $det_detallecon=array();
    var $det_salida=array();
    var $det_entrada=array();
    var $det_cuenta=array();
    var $det_cuentades=array();
    var $comprobantetodo=array();
    var $cuentaprov=array();
    var $tipo=array();
    var $tipodes=array();
    var $tipoganancia=array();
    var $repetida=array();
    var $cerrado=array();

    var $det_descriptor1=array();
    var $det_descriptor2=array();
    var $det_descriptor3=array();
    var $det_descriptor4=array();
    var $det_descriptor1des=array();
    var $det_descriptor2des=array();
    var $det_descriptor3des=array();
    var $det_descriptor4des=array();
    var $det_detalle=array();
    var $det_importe=array();
    var $det_id=array();
    var $malletra=array();

    var $maxregistros=0;

    
    function __construct($ssql, $tipocontable=0, $conn="0") {
        require_once "clases/conexion.php";
        require_once 'clases/support.php';
        require_once 'clases/adm_prv.php';
        require_once 'clases/adm_mov.php';
        require_once 'clases/adm_cta.php';
        require_once 'clases/adm_com_cta.php';
        require_once 'clases/support.php';
        require_once 'clases/adm_clasif.php';
        require_once 'clases/adm_com_det.php';
        $sup=new support();
        $conx=new conexion();
        if($conn=="0")
            $conn=$conx->conectarBase ();
        $cta=new adm_com_cta_cen(1, $conn);
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
                array_push($this->idemp,$reg->idemp);
                array_push($this->fecha,$reg->fecha);
                array_push($this->letra,$reg->letra);
                array_push($this->ptovta,$reg->ptovta);
                array_push($this->cainro,$reg->cainro);
                array_push($this->numero,$reg->numero);
                array_push($this->idprv,$reg->idprv);
                array_push($this->neto21,$reg->neto21);
                array_push($this->neto10,$reg->neto10);
                array_push($this->neto27,$reg->neto27);
                array_push($this->neto17,$reg->neto17);                
                array_push($this->iva21,$reg->iva21);
                array_push($this->iva10,$reg->iva10);
                array_push($this->iva27,$reg->iva27);
                array_push($this->iva17,$reg->iva17); 
                array_push($this->impinternos,$reg->impinternos);
                array_push($this->periva,$reg->periva);
                array_push($this->retiva,$reg->retiva);
                array_push($this->perretiibb,$reg->perretiibb);
                array_push($this->fechaven,$reg->fechaven);
                if($reg->tipocom!=2) {
                    array_push($this->importepag,$reg->importepag);
                    array_push($this->neto,$reg->neto10+$reg->neto21+$reg->neto27+$reg->neto17);
                } else {
                    array_push($this->importepag,$reg->importepag*-1);
                    array_push($this->neto,-$reg->neto10-$reg->neto21-$reg->neto27-$reg->neto17);
                }
                    
                array_push($this->exento,$reg->exento);
                array_push($this->nogravado,$reg->nogravado);
                $tt=$reg->neto21+$reg->neto10+$reg->neto27+$reg->neto17+$reg->iva21+$reg->iva10+$reg->iva27+$reg->iva17+$reg->impinternos+$reg->periva+$reg->retiva+$reg->perretiibb+$reg->exento+$reg->nogravado;
                //echo "tt: $tt<br>";
                if($reg->tipocom!=2)
                    array_push($this->totaltotal,$tt);
                else
                    array_push($this->totaltotal,$tt*-1);
                array_push($this->tipocom,$reg->tipocom);
                array_push($this->fechaimputacion,$reg->fechaimputacion);
                array_push($this->clave,$reg->clave);
                array_push($this->tipo,$reg->tipo);
                if($reg->tipo==1) array_push($this->tipodes,"Compra"); else array_push($this->tipodes,"Gasto");
                switch ($reg->tipocom) {
                    case 1:
                        array_push($this->tipocomdes,"Factura");
                        array_push($this->tipocomabr,"FC");
                        array_push($this->comprobantetodo,"FC-".$reg->letra."-".$sup->AddZeros($reg->ptovta,4)."-".$sup->AddZeros($reg->numero, 8));
                        break;
                    case 2:
                        array_push($this->tipocomdes,"Nota de Crédito");
                        array_push($this->tipocomabr,"NC");
                        array_push($this->comprobantetodo,"NC-".$reg->letra."-".$sup->AddZeros($reg->ptovta,4)."-".$sup->AddZeros($reg->numero, 8));
                        break;
                    case 3:
                        array_push($this->tipocomdes,"Nota de Débito");
                        array_push($this->tipocomabr,"ND");
                        array_push($this->comprobantetodo,"ND-".$reg->letra."-".$sup->AddZeros($reg->ptovta,4)."-".$sup->AddZeros($reg->numero, 8));
                        break;
                }
                    
                
                $prv=new adm_prv_1($reg->idprv,$conn);
                array_push($this->proveedor,$prv->getApellido()." ".$prv->getNombre());
                array_push($this->ivaprov,$prv->getCuit());
                array_push($this->tipoivades,$prv->getCondicionivaabr());
                array_push($this->cuentaprov,$prv->getCuenta());
                $ml=0;
                //echo $reg->id." ".$prv->getApellido()." ".$prv->getFacturam()." ".$reg->letra."\n";
                if(($prv->getCondiva()==1 and $reg->letra=="A") or ($prv->getCondiva()==3 and $reg->letra!="A") or ($prv->getCondiva()!=3 and $reg->letra=="A")) {
                    if($prv->getFacturam()==1 and $reg->letra=="M")
                        array_push($this->malletra,0); 
                    else
                        array_push($this->malletra,1); 
                } else {
                    array_push($this->malletra,0); 
                }
                if(strlen($prv->getCuit())>=11)
                    array_push($this->codigocomprobante,"80");
                else
                    array_push($this->codigocomprobante,"01");

                $mov1=new adm_mov1_clave($reg->clave,$conn);
                $tote=number_format(array_sum($mov1->getEntrada()),2,".","");
                $tots=number_format(array_sum($mov1->getSalida()),2,".","");
//                echo "$tote|$tots|||$tote|".$reg->totaltotal."\n";
                if($tote==$tots and $tote==$reg->totaltotal)
                    array_push($this->movimiento,1);
                else
                    array_push($this->movimiento,0);

                array_push($this->asientos,$mov1->getAsiento());
                array_push($this->det_cuentades,$mov1->getCuentades());
                array_push($this->det_entrada,$mov1->getEntrada());
                array_push($this->det_salida,$mov1->getSalida());
                array_push($this->det_cuenta,$mov1->getCuenta());
                
                $totalproveedor=0;
                $xcuenta=array();
                $xentrada=array();
                $xsalida=array();
                $xdetallecon=array();
                $xcuentades=array();
                //echo "neto21: ".$reg->neto21."\n";
                if($reg->neto21>0 or $reg->neto10>0 or $reg->neto27>0 or $reg->neto17>0 or $reg->exento>0 or $reg->nogravado>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$prv->getCuenta());
                    array_push($xentrada,$reg->neto21 + $reg->neto10 + $reg->neto27 + $reg->neto17 + $reg->exento + $reg->nogravado);
                    array_push($xsalida,0);
                    array_push($xcuentades,$prv->getCuentacod()." ".$prv->getCuentades());
                    $totalproveedor+=$reg->neto21+$reg->neto10+$reg->neto27+$reg->neto17+$reg->exento+$reg->nogravado;
                }
                if($reg->iva21>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getIva21());
                    array_push($xentrada,$reg->iva21);
                    array_push($xsalida,0);
                    $ccc=new adm_cta_1($cta->getIva21(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    $totalproveedor+=$reg->iva21;          
                }
                if($reg->iva10>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getIva10());
                    array_push($xentrada,$reg->iva10);
                    array_push($xsalida,0);
                    $ccc=new adm_cta_1($cta->getIva10(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    $totalproveedor+=$reg->iva10;          
                }
                if($reg->iva27>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getIva27());
                    array_push($xentrada,$reg->iva27);
                    array_push($xsalida,0);
                    $ccc=new adm_cta_1($cta->getIva27(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    $totalproveedor+=$reg->iva27;          
                }
                if($reg->iva17>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getIva17());
                    array_push($xentrada,$reg->iva17);
                    array_push($xsalida,0);
                    $ccc=new adm_cta_1($cta->getIva17(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    $totalproveedor+=$reg->iva17;          
                }
                if($reg->retiva>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getRetiva());
                    array_push($xentrada,$reg->retiva);
                    array_push($xsalida,0);
                    $ccc=new adm_cta_1($cta->getRetiva(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    $totalproveedor+=$reg->retiva;          
                }
                if($reg->periva>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getRetiva());
                    array_push($xentrada,$reg->periva);
                    array_push($xsalida,0);
                    $ccc=new adm_cta_1($cta->getRetiva(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    $totalproveedor+=$reg->periva;          
                }
                if($reg->perretiibb>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getRetiibb());
                    array_push($xentrada,$reg->perretiibb);
                    array_push($xsalida,0);
                    $ccc=new adm_cta_1($cta->getRetiibb(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    $totalproveedor+=$reg->perretiibb;          
                }
                if($reg->impinternos>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getImpinternos());
                    array_push($xentrada,$reg->impinternos);
                    array_push($xsalida,0);
                    $ccc=new adm_cta_1($cta->getImpinternos(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    $totalproveedor+=$reg->impinternos;          
                }
                //echo "totalp: $totalproveedor\n";
                if($totalproveedor>0) {
//                    $cantc++;
//                    $ii++;
//                    $cuenta="cuenta$ii";
//                    $entrada="entrada$ii";
//                    $salida="salida$ii";
//                    $detallecon="detallecon$ii";
                    array_push($xdetallecon,"");
                    array_push($xcuenta,$cta->getAcreedor());
                    array_push($xentrada,0);
                    $ccc=new adm_cta_1($cta->getAcreedor(), $conn);
                    array_push($xcuentades,$ccc->getCodigo()." ".$ccc->getNombre());
                    array_push($xsalida,$totalproveedor);
                }
                //print_r($xcuentades);
                array_push($this->mov_detallecon,$xdetallecon);
                array_push($this->mov_salida,$xsalida);
                array_push($this->mov_entrada,$xentrada);
                array_push($this->mov_cuenta,$xcuenta);
                array_push($this->mov_cuentades,$xcuentades);
                $ssql="select * from adm_com_det where idcom=".$reg->id;
               //echo $ssql;
                $det=new adm_com_det_2($ssql,$conn);
                array_push($this->det_descriptor1,$det->getDescriptor1());
                array_push($this->det_descriptor2,$det->getDescriptor2());
                array_push($this->det_descriptor3,$det->getDescriptor3());
                array_push($this->det_descriptor4,$det->getDescriptor4());
                array_push($this->det_id,$det->getId());
                array_push($this->det_descriptor1des,$det->getDescriptor1des());
                array_push($this->det_descriptor2des,$det->getDescriptor2des());
                array_push($this->det_descriptor3des,$det->getDescriptor3des());
                array_push($this->det_descriptor4des,$det->getDescriptor4des());
                array_push($this->det_importe,$det->getImporte());
                array_push($this->det_detalle,$det->getDetalle());
                
                array_push($this->tipoganancia,$reg->tipoganancia);
                $ssql="select * from adm_com where ptovta=".$reg->ptovta." and numero=".$reg->numero." and idprv=".$reg->idprv." and tipo=".$reg->tipocom." and letra='".$reg->letra."'";
                array_push($this->repetida,$conx->getCantidadRegA($ssql, $conn));
//                array_push($this->importeretenido,$reg->importeretenido);
                $ssql="select * from adm_per where periodo='".date("Ym", strtotime($reg->fechaimputacion))."'";
                array_push($this->cerrado,$conx->getCantidadRegA($ssql, $conn));
            }
        }
    }

    function getMovimiento() {
        return $this->movimiento;
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

    function getFecha() {
        return $this->fecha;
    }
    

    function getLetra() {
        return $this->letra;
    }
    
    function getIddet() {
        return $this->iddes;
    }

    function getPtovta() {
        return $this->ptovta;
    }

    function getNumero() {
        return $this->numero;
    }

    function getIdprv() {
        return $this->idprv;
    }

    function getCainro() {
        return $this->cainro;
    }
    
    function getDetalle() {
        return $this->detalle;
    }

    function getNeto21() {
        return $this->neto21;
    }

    function getNeto10() {
        return $this->neto10;
    }

    function getNeto27() {
        return $this->neto27;
    }

    function getNeto17() {
        return $this->neto17;
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

    function getImpinternos() {
        return $this->impinternos;
    }

    function getExento() {
        return $this->exento;
    }

    function getNogravado() {
        return $this->nogravado;
    }

    function getRetiva() {
        return $this->retiva;
    }

    function getPeriva() {
        return $this->periva;
    }

    function getPerretiibb() {
        return $this->perretiibb;
    }

    function getProveedor() {
        return $this->proveedor;
    }

    function getImportepag() {
        return $this->importepag;
    }

    function getFechaven() {
        return $this->fechaven;
    }

    function getTotaltotal() {
        return $this->totaltotal;
    }

    function getTipoivades() {
        return $this->tipoivades;
    }

    function getIvaprov() {
        return $this->ivaprov;
    }

    function getTipocom() {
        return $this->tipocom;
    }

    function getTipocomdes() {
        return $this->tipocomdes;
    }

    function getTipocomabr() {
        return $this->tipocomabr;
    }

    function getMaxRegistros() {
        return $this->maxregistros;
    }

    function getFechaimputacion() {
        return $this->fechaimputacion;
    }

    function getClave() {
        return $this->clave;
    }

    function getCodigocomprobante() {
        return $this->codigocomprobante;
    }

    function getCantidadasientos() {
        return $this->cantidadasientos;
    }

    function getAsientos() {
        return $this->asientos;
    }
    
    function getMov_detallecon() {
        return $this->mov_detallecon;
    }
    
    function getMov_entrada() {
        return $this->mov_entrada;
    }
    
    function getMov_salida() {
        return $this->mov_salida;
    }
    
    function getMov_cuenta() {
        return $this->mov_cuenta;
    }
    
    function getMov_cuentades() {
        return $this->mov_cuentades;
    }

    function getDet_entrada() {
        return $this->det_entrada;
    }
    
    function getDet_salida() {
        return $this->det_salida;
    }
    
    function getDet_cuenta() {
        return $this->det_cuenta;
    }
    
    function getDet_cuentades() {
        return $this->det_cuentades;
    }
    
    function getNeto() { return $this->neto; }
    function getComprobantetodo() { return $this->comprobantetodo; }
    function getCuentaprov() { return $this->cuentaprov; }
    function getTipo() { return $this->tipo; }
    function getTipodes() { return $this->tipodes; }
  
    function getDet_id() { return $this->det_id; }
    function getDet_detalle() { return $this->det_detalle; }
    function getDet_importe() { return $this->det_importe; }
    
    function getDet_descriptor1() {
        return $this->det_descriptor1;
    }

    function getDet_descriptor2() {
        return $this->det_descriptor2;
    }

    function getDet_descriptor3() {
        return $this->det_descriptor3;
    }

    function getDet_descriptor4() {
        return $this->det_descriptor4;
    }

    function getDet_descriptor1des() {
        return $this->det_descriptor1des;
    }

    function getDet_descriptor2des() {
        return $this->det_descriptor2des;
    }

    function getDet_descriptor3des() {
        return $this->det_descriptor3des;
    }

    function getDet_descriptor4des() {
        return $this->det_descriptor4des;
    }        
    
    function getTipoganancia() { return $this->tipoganancia; }
    function getRepetida() { return $this->repetida; }
    function getMalletra() { return $this->malletra; }
    function getCerrado() { return $this->cerrado; }
//    function getImporteretenido() { return $this->importeretenido; }
    
}

class ganancias {
    var $importe=0;
    
    function __construct($idprv, $fecha, $idcom, $tipocompra) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        global $cfg;
        $fechaini=date("Y-m-01", strtotime($fecha));
        $fechafin=date("Y-m-d", strtotime("$fechaini + 1 month"));
        $fechafin=date("Y-m-d", strtotime("$fechafin - 1 day"));
        $ssql="select sum(importeretenido) as impretenido from adm_com where fecha>='$fechaini' and fecha<='$fechafin' and idprv=$idprv";
        $rs=$conx->consultaBase($ssql, $conn);
        $reg=mysqli_fetch_object($rs);
        $importeretenido=$reg->impretenido;
        $neto=0;
        for($i=0;$i<count($idcom);$i++) {
            $com=new adm_com_1($id, $conn);
            if($com->getTipocom()==1) 
                $neto-=$com->getNeto();
            else
                $neto+=$com->getNeto();
        }
        $neto-=$cfg->getMinimoretenciones();
        if($neto>0) $impo=$neto*$cfg->getMinimoretenciones()/100;
        
        
        
    }
}

?>

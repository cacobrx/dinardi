<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of informes
 *
 * @author Gus
 */
class ctacte_proveedores {
    var $fecha=array();
    var $detalle=array();
    var $importe=array();
    var $saldo=array();
    
    function __construct($idprov, $fechaini, $fechafin, $tipo) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_com.php';
        require_once 'clases/adm_opg1.php';
        require_once 'clases/adm_gas.php';
        if($tipo==1 or $tipo==0) {
            $ssql="select * from adm_com where idprv=$idprov and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
//            echo $ssql."<br>";
            $com=new adm_com_2($ssql);
            $c_fec=$com->getFecha();
            $c_num=$com->getNumero();
            $c_imp=$com->getTotaltotal();
        } else 
            $c_fec=array();
        $ssql="select * from adm_opg1 where idprv=$idprov and fecha>='$fechaini' and fecha<='$fechafin'";
        if($tipo>0) $ssql.=" and tipo=$tipo";
        $ssql.=" order by fecha";
//        echo $ssql."<br>";
        $opg=new adm_opg1_2($ssql);
        $o_fec=$opg->getFecha();
        $o_num=$opg->getId();
        $o_imp=$opg->getTotalimporte();
        
        if($tipo==2 or $tipo==0) {
            $ssql="select * from adm_gas where idprv=$idprov and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
//            echo $ssql;
            $gas=new adm_gas_2($ssql);
            $g_fec=$gas->getFecha();
            $g_num=$gas->getId();
            $g_imp=$gas->getImporte();
        } else
            $g_fec=array();
        
        $registro=array();
        for($i=0;$i<count($c_fec);$i++) {
            array_push($registro,$c_fec[$i]."|".$c_num[$i]."|".$c_imp[$i]."|Compra");
        }
        for($i=0;$i<count($o_fec);$i++) {
            array_push($registro,$o_fec[$i]."|".$o_num[$i]."|".$o_imp[$i]."|O.Pago");
        }
        for($i=0;$i<count($g_fec);$i++) {
            array_push($registro,$g_fec[$i]."|".$g_num[$i]."|".$g_imp[$i]."|Gasto");
        }
        sort($registro);
        $sal=0;
        for($i=0;$i<count($registro);$i++) {
            $datos=  explode("|", $registro[$i]);
            array_push($this->fecha,$datos[0]);
            array_push($this->detalle,$datos[3]." ".$datos[1]);
            if($datos[3]=="Compra" or $datos[3]=="Gasto")
                $imp=$datos[2]*-1;
            else
                $imp=$datos[2];
            array_push($this->importe,$imp);
            $sal+=$imp;
            array_push($this->saldo,$sal);
            
        }
        
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
    
    function getSaldo() {
        return $this->saldo;
    }
}

class saldo_proveedores {
    var $proveedor=array();
    var $facturas=array();
    var $recibos=array();
    var $saldo=array();
    
    function __construct() {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_com.php';
        require_once 'clases/adm_opg1.php';
        require_once 'clases/adm_prv.php';
        $ssql="select * from adm_prv order by apellido, nombre";
        $prv=new adm_prv_2($ssql);
        $p_id=$prv->getId();
        $p_ape=$prv->getApellido();
        $p_nom=$prv->getNombre();
        $conx=new conexion();
        $conn=$conx->conectarBase();
        for($i=0;$i<count($p_id);$i++) {
            $ssql="select sum(totaltotal) as totalcom from adm_com where idprv=".$p_id[$i]." and tipocom!=1";
//            echo $ssql;
            $rc=$conx->consultaBase($ssql,$conn);
            $rcc=mysqli_fetch_object($rc);
            $totalcom=$rcc->totalcom;
            $ssql="select sum(totaltotal) as totalcom from adm_com where idprv=".$p_id[$i]." and tipocom=1";
            $rc=$conx->consultaBase($ssql,$conn);
            $rcc=mysqli_fetch_object($rc);
            $totalcom-=$rcc->totalcom;
            //echo $ssql."<br>";
            $ssql="select sum(importe) as totalopg from adm_opg1 where idprv=".$p_id[$i];
            $ro=$conx->consultaBase($ssql,$conn);
            $roo=mysqli_fetch_object($ro);
            $totalopg=$roo->totalopg;
            array_push($this->proveedor,$p_ape[$i]." ".$p_nom[$i]);
            array_push($this->facturas,abs($totalcom));
            array_push($this->recibos,$totalopg);
            array_push($this->saldo,$totalopg+$totalcom);
        }
        
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getFacturas() {
        return $this->facturas;
    }
    
    function getRecibos() {
        return $this->recibos;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
}


class saldo_proveedoresx {
    var $proveedor=array();
    var $facturas=array();
    var $recibos=array();
    var $saldo=array();
    
    function __construct($fechaini, $fechafin, $centro) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_com.php';
        require_once 'clases/adm_opg1.php';
        require_once 'clases/adm_prv.php';
        $ssql="select * from adm_prv where centro=$centro order by apellido, nombre";
        
        $prv=new adm_prv_2($ssql);
        $p_id=$prv->getId();
        $p_ape=$prv->getApellido();
        $p_nom=$prv->getNombre();
        for($i=0;$i<count($p_id);$i++) {
            $ssql="select * from adm_com where idprv=".$p_id[$i]." and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
            //echo $ssql."<br>";
            $com=new adm_com_2($ssql);
            $c_imp=$com->getTotaltotal();
            $ssql="select * from adm_opg1 where idprv=".$p_id[$i]." and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
            $opg=new adm_opg1_2($ssql);
            $o_imp=$opg->getImporte();
            array_push($this->proveedor,$p_ape[$i]." ".$p_nom[$i]);
            array_push($this->facturas,array_sum($c_imp));
            array_push($this->recibos,array_sum($o_imp));
            array_push($this->saldo,array_sum($o_imp)-array_sum($c_imp));
        }
        
    }
    
    function getProveedor() {
        return $this->proveedor;
    }
    
    function getFacturas() {
        return $this->facturas;
    }
    
    function getRecibos() {
        return $this->recibos;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
}

class saldo_clientes {
    var $cliente=array();
    var $pedidos=array();
    var $recibos=array();
    var $saldo=array();
    
    function __construct($fechaini, $fechafin, $centro) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cped.php';
        require_once 'clases/adm_rec1.php';
        require_once 'clases/adm_cli.php';
        $ssql="select * from adm_cli where centro=$centro order by apellido, nombre";
        
        $cli=new adm_cli_2($ssql);
        $p_id=$cli->getId();
        $p_ape=$cli->getApellido();
        $p_nom=$cli->getNombre();
        for($i=0;$i<count($p_id);$i++) {
            $ssql="select * from adm_cped where idcli=".$p_id[$i]." and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
            //echo $ssql."<br>";
            $com=new adm_cped_2($ssql);
            $c_imp=$com->getImporte();
            $c_rec=$com->getRecargo();
            $c_des=$com->getDescuento();
            $ssql="select * from adm_rec1 where idcli=".$p_id[$i]." and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
            $opg=new adm_rec1_2($ssql);
            $o_imp=$opg->getImporte();
            array_push($this->cliente,$p_ape[$i]." ".$p_nom[$i]);
            array_push($this->pedidos,array_sum($c_imp)+array_sum($c_rec)-array_sum($c_des));
            array_push($this->recibos,array_sum($o_imp));
            array_push($this->saldo,array_sum($o_imp)-array_sum($c_imp)-array_sum($c_rec)+array_sum($c_des));
        }
        
    }
    
    function getCliente() {
        return $this->cliente;
    }
    
    function getPedidos() {
        return $this->pedidos;
    }
    
    function getRecibos() {
        return $this->recibos;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
}


class ctacte_clientes {
    var $fecha=array();
    var $detalle=array();
    var $importe=array();
    var $debehaber=array();
    var $saldo=array();
    
    function __construct($idcli, $fechaini, $fechafin, $centrosel, $via, $saldoini=0) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_cped.php';
        require_once 'clases/adm_crec.php';
        require_once 'clases/adm_fis.php';
        $conx=new conexion();
        $sini=0;
        $ssql="select sum(totaltotal) as iniped from adm_fis where idcli=$idcli and fecha<'$fechaini' and tipocom!='C'";
        if($conx->getCantidadReg($ssql)>0) {
            $pi=$conx->getConsulta($ssql);
            $rpi=  mysqli_fetch_object($pi);
            $sini+=$rpi->iniped;

        }
        $ssql="select sum(adm_crec3.importe) as inirec from adm_crec3, adm_crec1 where adm_crec1.idcli=$idcli and adm_crec1.fecha<'$fechaini' and adm_crec3.idcrec=adm_crec1.id";
        if($conx->getCantidadReg($ssql)>0) {
            $ri=$conx->getConsulta($ssql);
            $rri=  mysqli_fetch_object($ri);
            $sini-=$rri->inirec;
            
        }
        $ssql="select * from adm_fis where idcli=$idcli and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
        //echo $ssql."<br>";
        $fis=new adm_fis_2($ssql);
        $c_fec=$fis->getFecha();
        $c_num=$fis->getId();
        $c_com=$fis->getTipodes();
        $c_pto=$fis->getPtovta();
        $c_let=$fis->getLetra();
        $c_nro=$fis->getNumero();
        //print_r($c_nro);
        $c_imp=$fis->getTotal();
        $ssql="select sum(adm_crec3.importe) as inirec from adm_crec3, adm_crec1 where adm_crec1.idcli=$idcli and adm_crec1.fecha>='$fechaini' and adm_crec1.fecha<='$fechafin' and adm_crec3.idcrec=adm_crec1.id";
        $rec=new adm_crec1_2($ssql);
        $o_fec=$rec->getFecha();
        $o_num=$rec->getId();
        $o_imp=$rec->getImporte();
        $registro=array();
        $saldoini+=$sini;
        $sal=0;
        if($saldoini!=0) {
            if($saldoini>=0) {
                $tip="Factura";
            } else
                $tip="Recibo";
            $saldoini=  abs($saldoini);
            //echo "0000-00-00|Saldo Inicial|$saldoini|$tip<br>";
            array_push($registro, "0000-00-00|Saldo Inicial|$saldoini|$tip");
            //$sal=$saldoini;
        }
        for($i=0;$i<count($c_fec);$i++) {
            if($via==1) 
                array_push($registro,$c_fec[$i]."|".$c_let[$i]."-".$c_pto[$i]."-".$c_nro[$i]."|".$c_imp[$i]."|".$c_com[$i]);
            else
                array_push($registro,$c_fec[$i]."|".$c_num[$i]."|".$c_imp[$i]."|Pedido");
        }
        for($i=0;$i<count($o_fec);$i++) {
            array_push($registro,$o_fec[$i]."|".$o_num[$i]."|".$o_imp[$i]."|Recibo");
        }
        sort($registro);
        //print_r($registro);
        for($i=0;$i<count($registro);$i++) {
            $datos=  explode("|", $registro[$i]);
            array_push($this->fecha,$datos[0]);
            array_push($this->detalle,$datos[3]." ".$datos[1]);
            if(substr($datos[3],0,9)=="N.Credito" or $datos[3]=="Recibo") {
                $imp=$datos[2];
                array_push($this->debehaber,"H");
                $sal-=$imp;
            } else {
                $imp=$datos[2];
                array_push($this->debehaber,"D");
                $sal+=$imp;
            }
            array_push($this->importe,$imp);
//            $sal+=$imp;
            //echo "sal: $sal\n";
            array_push($this->saldo,$sal);
            
        }
        
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    function getDetalle() {
        return $this->detalle;
    }
    
    function getDebehaber() {
        return $this->debehaber;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
}

class ctacte_sj {
    var $fecha=array();
    var $sueldo=array();
    var $pagado=array();
    var $saldo=array();
    var $id=array();
    
    function __construct($idcli, $fechaini, $fechafin, $centrosel, $saldoini=0) {
        require_once 'clases/conexion.php';
        require_once 'clases/adm_jliq.php';
        require_once 'clases/adm_rec1.php';
        $ssql="select * from adm_jliq where idper=$idcli and fecha>='$fechaini' and fecha<='$fechafin' order by fecha";
        //echo $ssql."<br>";
        $liq=new adm_jliq_2($ssql);
        $this->fecha=$liq->getFecha();
        $this->id=$liq->getId();
        $this->sueldo=$liq->getImporteliq();
        $this->pagado=$liq->getImporte();
        
    }
    
    function getFecha() {
        return $this->fecha;
    }
    
    function getSueldo() {
        return $this->sueldo;
    }
    
    function getPagado() {
        return $this->pagado;
    }
    
    function getId() {
        return $this->id;
    }
}


class saldo_cliente {
    var $saldo=0;
    
    function __construct($idcli, $saldoini=0) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ret=$saldoini;
        $ssql="select sum(importe) as totalped from adm_cped where idcli=$idcli";
        //echo $ssql."<br>";
        $rs=$conx->getConsulta($ssql);
        $reg=mysqli_fetch_object($rs);
        $totalped=$reg->totalped;
                
        $ssql="select sum(importe) as totalrec from adm_rec1 where idcli=$idcli and tipocontabilidad=2";
        //echo $ssql."<br>";
        $rs=$conx->getConsulta($ssql);
        $reg=mysqli_fetch_object($rs);
        $totalrec=$reg->totalrec;
        //echo "totalrec: $totalrec | totalped: $totalped | saldoini: $saldoini<br>";
        $this->saldo=$totalrec - $saldoini - $totalped;
        //echo $this->saldo."<br>";
        
    }
    
    function getSaldo() {
        return $this->saldo;
    }
}


class jinf {
    var $idper=array();
    var $nombre=array();
    var $fechas=array();
    var $inicial=array();
    var $kilos=array();
    var $perciohoras=array();
    var $horas=array();
    var $animal=array();
    var $restar=array();
    var $extras=array();
    var $extrasf=array();
    var $adelantos=array();
    var $sueldos=array();
    var $premio=array();
    var $pagado=array();
    
    function __construct($fechaini, $fechafin, $tipo=0) {
        require_once 'clases/adm_jornal.php';
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $ssql="select * from adm_jornal where tipo=$tipo and baja=0 order by nombre";
        $jor=new adm_jornal_2($ssql);
        $this->nombre=$jor->getNombre();
        //$this->inicial=$jor->getInicial();
        $this->animal=$jor->getPrecioanimal();
        $this->preciohoras=$jor->getPreciohora();
        $this->idper=$jor->getId();
        $xfec=$fechaini;
        $conn=$conx->conectarBase();
        while($xfec<=$fechafin) {
            array_push($this->fechas,$xfec);
            $ssql="select * from adm_janimal where fecha='$xfec'";
            if($conx->getCantidadRegA($ssql,$conn)>0) {
                $ra=$conx->consultaBase($ssql,$conn);
                $rag=mysqli_fetch_object($ra);
                array_push($this->kilos,$rag->cantidad);
            } else 
                array_push($this->kilos,0);
            $xfec=date("Y-m-d", strtotime("$xfec + 1day"));
            
        }
        
        for($i=0;$i<count($this->idper);$i++) {
            $resta=array();
            for($f=0;$f<count($this->fechas);$f++) {
                $ssql="select * from adm_jnov where fecha='".$this->fechas[$f]."' and idper=".$this->idper[$i];
                //echo $ssql."<br>";
                if($conx->getCantidadRegA($ssql,$conn)>0) {
                    $rn=$conx->consultaBase($ssql,$conn);
                    $ren=mysqli_fetch_object($rn);
                    //echo "$ssql<br>restar: ".$ren->cantidad."<br>";
                    array_push($resta,$ren->cantidad);
                } else
                    array_push($resta,0);
            }
            array_push($this->restar,$resta);
            $ssql="select sum(horas) as totalextras from adm_jhoras where fecha>='$fechaini' and fecha<='$fechafin' and idper=".$this->idper[$i];
            //echo $ssql."<br>";
            if($conx->getCantidadRegA($ssql,$conn)>0) {
                $rh=$conx->consultaBase($ssql,$conn);
                $reh=mysqli_fetch_object($rh);
                //echo "total: ".$reh->totalextras."<br>";
                array_push($this->extras,$reh->totalextras * $this->preciohoras[$i]);
                array_push($this->horas,$reh->totalextras);
            } else {
                array_push($this->extras,0);
                array_push($this->horas,0);
            }

            $ssql="select sum(importe) as totalextrasf from adm_jextra where fecha>='$fechaini' and fecha<='$fechafin' and idper=".$this->idper[$i];
            //echo $ssql."<br>";
            if($conx->getCantidadRegA($ssql,$conn)>0) {
                $rh=$conx->consultaBase($ssql,$conn);
                $reh=mysqli_fetch_object($rh);
                //echo "total: ".$reh->totalextras."<br>";
                array_push($this->extrasf,$reh->totalextrasf);
            } else {
                array_push($this->extrasf,0);
            }
            
            
            $ssql="select * from adm_jsaldo where fecha<'$fechaini' and idper=".$this->idper[$i]." order by fecha desc";
            //echo $ssql."<br>";
            if($conx->getCantidadRegA($ssql,$conn)>0) {
                $rs=$conx->consultaBase($ssql,$conn);
                $res=mysqli_fetch_object($rs);
                array_push($this->inicial,$res->importe);
            } else
                array_push($this->inicial,0);
            
            $ssql="select sum(importe) as totaladelanto from adm_jadelanto where fecha>='$fechaini' and fecha<='$fechafin' and idper=".$this->idper[$i];
            //echo $ssql."<br>";
            if($conx->getCantidadRegA($ssql,$conn)>0) {
                $ra=$conx->consultaBase($ssql,$conn);
                $rag=mysqli_fetch_object($ra);
                array_push($this->adelantos,$rag->totaladelanto);
            } else
                array_push($this->adelantos,0);

            $ssql="select sum(importe) as totalsueldo from adm_jsueldos where fecha>='$fechaini' and fecha<='$fechafin' and idper=".$this->idper[$i];
            //echo $ssql."<br>";
            if($conx->getCantidadRegA($ssql,$conn)>0) {
                $ra=$conx->consultaBase($ssql,$conn);
                $rag=mysqli_fetch_object($ra);
                array_push($this->sueldos,$rag->totalsueldo);
            } else
                array_push($this->sueldos,0);
            
            $ssql="select sum(importe) as totalpremio from adm_jpremio where fecha>='$fechaini' and fecha<='$fechafin' and idper=".$this->idper[$i];
            //echo $ssql."<br>";
            if($conx->getCantidadRegA($ssql,$conn)>0) {
                $ra=$conx->consultaBase($ssql,$conn);
                $rag=mysqli_fetch_object($ra);
                array_push($this->premio,$rag->totalpremio);
            } else
                array_push($this->premio,0);
            
            $ssql="select sum(importe) as totalpagado from adm_jliq where fecha>='$fechaini' and fecha<='$fechafin' and idper=".$this->idper[$i];
            if($conx->getCantidadRegA($ssql,$conn)>0) {
                $rp=$conx->consultaBase($ssql,$conn);
                $rap=mysqli_fetch_object($rp);
                array_push($this->pagado,$rap->totalpagado);
            } else
                array_push($this->pagado,0);
            
        }
        $conx->cerrarBase($conn);
    }
    
    function getNombre() {
        return $this->nombre;
    }
    
    function getPagado() {
        return $this->pagado;
    }
    
    function getInicial() {
        return $this->inicial;
    }
    
    function getFechas() {
        return $this->fechas;
    }
    
    function getKilos() {
        return $this->kilos;
    }
    
    function getAnimal() {
        return $this->animal;
    }
    
    function getIdper() {
        return $this->idper;
    }
    
    function getRestar() {
        return $this->restar;
    }
    
    function getPreciohoras() {
        return $this->preciohoras;
    }
    
    function getHoras() {
        return $this->horas;
    }
    
    function getExtras() {
        return $this->extras;
    }
    
    function getExtrasf() {
        return $this->extrasf;
    }
    
    function getAdelantos() {
        return $this->adelantos;
    }
    
    function getSueldos() {
        return $this->sueldos;
    }
    
    function getPremio() {
        return $this->premio;
    }
}

class adm_sfae_liq {
    var $id=array();
    var $empleado=array();
    var $adelanto=array();
    var $novedad=array();
    var $importe=array();
    var $saldoini=array();
    var $liquidado=array();
    var $extras=array();
    
    function __construct($fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_sfae_personal where activo=1 order by apellido, nombre";
        $rs=$conx->consultaBase($ssql, $conn);
        while($reg=mysqli_fetch_object($rs)) {
            array_push($this->empleado,$reg->apellido." ".$reg->nombre);
            array_push($this->importe,$reg->importe);
            array_push($this->id,$reg->id);
            $ssql="select sum(importe) as totalimp from adm_sfae_ade where idper=".$reg->id." and fecha>='$fechaini' and fecha<='$fechafin'";
            $rx=$conx->consultaBase($ssql, $conn);
            $rxx=mysqli_fetch_object($rx);
            array_push($this->adelanto,$rxx->totalimp);
            $ssql="select sum(cantidad) as totalnov from adm_sfae_nov where idper=".$reg->id." and fecha>='$fechaini' and fecha<='$fechafin'";
            //echo $ssql;
            $rx=$conx->consultaBase($ssql, $conn);
            $rxx= mysqli_fetch_object($rx);
            array_push($this->novedad,$rxx->totalnov);
            $ssql="select sum(importe) as totalliq from adm_sfae_liq where idper=".$reg->id." and fecha>='$fechaini' and fecha<='$fechafin'";
            //echo $ssql;
            $rx=$conx->consultaBase($ssql, $conn);
            $rxx= mysqli_fetch_object($rx);
            array_push($this->liquidado,$rxx->totalliq);
            $ssql="select sum(importe) as totalext from adm_sfaextra where idper=".$reg->id." and fecha>='$fechaini' and fecha<='$fechafin'";
            //echo $ssql;
            $rx=$conx->consultaBase($ssql, $conn);
            $rxx=mysqli_fetch_object($rx);
            array_push($this->extras,$rxx->totalext);
            $ssql="select * from adm_sfae_sal where fecha<'$fechaini' and idper=".$reg->id." order by fecha desc limit 1";
            if($conx->getCantidadRegA($ssql, $conn)>0) {
                $rx=$conx->consultaBase($ssql, $conn);
                $rxx=mysqli_fetch_object($rx);
                array_push($this->saldoini,$rxx->importe);
            } else
                array_push($this->saldoini,0);
        }
    }
    
    function getEmpleado() {
        return $this->empleado;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getNovedad() {
        return $this->novedad;
    }
    
    function getAdelanto() {
        return $this->adelanto;
    }
    
    function getSaldoini() {
        return $this->saldoini;
    }
    
    function getId() {
        return $this->id;
    }
    
    function getLiquidado() {
        return $this->liquidado;
    }

    function getExtras() {
        return $this->extras;
    }    
    
}

class adm_slim_liq {
    var $id=array();
    var $empleado=array();
    var $adelanto=array();
    var $novedad=array();
    var $importe=array();
    var $saldoini=array();
    var $liquidado=array();
    var $extras=array();
    
    function __construct($fechaini, $fechafin) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        $ssql="select * from adm_slim_personal where activo=1 order by apellido, nombre";
        $rs=$conx->consultaBase($ssql, $conn);
        while($reg=mysqli_fetch_object($rs)) {
            array_push($this->empleado,$reg->apellido." ".$reg->nombre);
            array_push($this->importe,$reg->importe);
            array_push($this->id,$reg->id);
            $ssql="select sum(importe) as totalimp from adm_slim_ade where idper=".$reg->id." and fecha>='$fechaini' and fecha<='$fechafin'";
            $rx=$conx->consultaBase($ssql, $conn);
            $rxx=mysqli_fetch_object($rx);
            array_push($this->adelanto,$rxx->totalimp);
            $ssql="select sum(cantidad) as totalnov from adm_slim_nov where idper=".$reg->id." and fecha>='$fechaini' and fecha<='$fechafin'";
            //echo $ssql;
            $rx=$conx->consultaBase($ssql, $conn);
            $rxx= mysqli_fetch_object($rx);
            array_push($this->novedad,$rxx->totalnov);
            $ssql="select sum(importe) as totalliq from adm_slim_liq where idper=".$reg->id." and fecha>='$fechaini' and fecha<='$fechafin'";
            //echo $ssql;
            $rx=$conx->consultaBase($ssql, $conn);
            $rxx= mysqli_fetch_object($rx);
            array_push($this->liquidado,$rxx->totalliq);
            $ssql="select sum(importe) as totalext from adm_slimxtra where idper=".$reg->id." and fecha>='$fechaini' and fecha<='$fechafin'";
            //echo $ssql;
            $rx=$conx->consultaBase($ssql, $conn);
            $rxx=mysqli_fetch_object($rx);
            array_push($this->extras,$rxx->totalext);
            $ssql="select * from adm_slim_sal where fecha<'$fechaini' and idper=".$reg->id." order by fecha desc limit 1";
            if($conx->getCantidadRegA($ssql, $conn)>0) {
                $rx=$conx->consultaBase($ssql, $conn);
                $rxx=mysqli_fetch_object($rx);
                array_push($this->saldoini,$rxx->importe);
            } else
                array_push($this->saldoini,0);
        }
    }
    
    function getEmpleado() {
        return $this->empleado;
    }
    
    function getImporte() {
        return $this->importe;
    }
    
    function getNovedad() {
        return $this->novedad;
    }
    
    function getAdelanto() {
        return $this->adelanto;
    }
    
    function getSaldoini() {
        return $this->saldoini;
    }
    
    function getId() {
        return $this->id;
    }
    
    function getLiquidado() {
        return $this->liquidado;
    }

    function getExtras() {
        return $this->extras;
    }    
    
}
?>

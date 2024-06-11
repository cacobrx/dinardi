<?php
/*
 * Creado el 24/08/2019 15:55:41
 * Autor: gus
 * Archivo: informe5.php
 * planbsistemas.com.ar
 */

class informe5 {
    var $id=array();
    var $codigo=array();
    var $nombre=array();
    var $debitos=array();
    var $creditos=array();
    var $letra=array();
    var $espacios=array();
    var $cantespacios=array();
    var $saldo=array();
    var $subtotal=array();
    var $anterior=array();
    
    function __construct($fechaini, $fechafin, $civa) {
//        echo "fechaini: $fechaini | fechafin: $fechafin<br>\n";
        require_once 'clases/conexion.php';
        require_once 'clases/adm_clasif.php';
        $conx=new conexion();
        $conn=$conx->conectarBase();
        
        
        // ingresos
        if($civa==1)
            $ssql="select sum(netori21+netori10+netocf21+netocf10+ivacf21+ivacf10+ivari21+ivari10+percepcioniibb) as totaling from adm_fis where fecha>='$fechaini' and fecha<='$fechafin' and (tipo='F' or tipo='G' or tipo='D' or tipo='I')";
        else 
            $ssql="select sum(netori21+netori10+netocf21+netocf10) as totaling from adm_fis where fecha>='$fechaini' and fecha<='$fechafin' and (tipo='F' or tipo='G' or tipo='D' or tipo='I')";
//        $ssql="select sum(precio*cantidad) as totaling from adm_crem_det inner join adm_crem on adm_crem_det.idrem=adm_crem.id";
//        $ssql.=" where adm_crem.fecha>='$fechaini' and adm_crem.fecha<='$fechafin'";
        //echo $ssql."\n";
        $ri=$conx->consultaBase($ssql, $conn);
        $rii=mysqli_fetch_object($ri);
        
        if($rii->totaling!=NULL) $ingresos=$rii->totaling; else $ingresos=0;
        
        if($civa==1)
            $ssql="select sum(netori21+netori10+netocf21+netocf10+ivacf21+ivacf10+ivari21+ivari10+percepcioniibb) as totaling from adm_fis where fecha>='$fechaini' and fecha<='$fechafin' and (tipo='C' or tipo='H')";
        else 
            $ssql="select sum(netori21+netori10+netocf21+netocf10) as totaling from adm_fis where fecha>='$fechaini' and fecha<='$fechafin' and (tipo='C' or tipo='H')";
//        $ssql="select sum(precio*cantidad) as totaling from adm_crem_det inner join adm_crem on adm_crem_det.idrem=adm_crem.id";
//        $ssql.=" where adm_crem.fecha>='$fechaini' and adm_crem.fecha<='$fechafin'";
        //echo $ssql."\n";
        $ri=$conx->consultaBase($ssql, $conn);
        $rii=mysqli_fetch_object($ri);
        
        if($rii->totaling!=NULL) $ingresos-=$rii->totaling;
        
        $ssql="select sum(importe) as totexp from adm_oin where fecha>='$fechaini' and fecha<='$fechafin'";
        $ri=$conx->consultaBase($ssql, $conn);
        $rii=mysqli_fetch_object($ri);
        if($rii->totexp!=NULL) $ingresos+=$rii->totexp;
        
        
        array_push($this->id,1);
        array_push($this->codigo,"000");
        array_push($this->nombre,"Ingresos");
        array_push($this->debitos,0);
        array_push($this->creditos,$ingresos);
        array_push($this->espacios,"&nbsp;");
        array_push($this->saldo,$ingresos);
        array_push($this->letra,"S");
        array_push($this->cantespacios,2);
        array_push($this->subtotal,0);
        array_push($this->anterior,"");
        
        //$ssql="select sum(precio*cantidad) as totalrem from adm_rem_det inner join adm_rem on adm_rem_det.idrem=adm_rem.id";
        //$ssql.=" where adm_rem.fecha>='$fechaini' and adm_rem.fecha<='$fechafin'";
        if($civa==1)
            $ssql="select sum(neto21+neto10+iva21+iva10+perretiibb+periva+retiva) as totcom1 from adm_com where fecha>='$fechaini' and fecha<='$fechafin' and tipocom!=2 and tipo=1";
        else
            $ssql="select sum(neto21+neto10) as totcom1 from adm_com where fecha>='$fechaini' and fecha<='$fechafin' and tipocom!=2 and tipo=1";
        
//        echo $ssql."\n";
        $rc=$conx->consultaBase($ssql, $conn);
        $rcc=mysqli_fetch_object($rc);
        if($rcc->totcom1!=NULL) $egresos=$rcc->totcom1; else $egresos=0;
        
        if($civa==1)
            $ssql="select sum(neto21+neto10+iva21+iva10+perretiibb+periva+retiva) as totcom2 from adm_com where fecha>='$fechaini' and fecha<='$fechafin' and tipocom=2 and tipo=1";
        else
            $ssql="select sum(neto21+neto10) as totcom2 from adm_com where fecha>='$fechaini' and fecha<='$fechafin' and tipocom=2 and tipo=1";
        
//        echo $ssql."\n";
        $rc=$conx->consultaBase($ssql, $conn);
        $rcc=mysqli_fetch_object($rc);
        if($rcc->totcom2!=NULL) $egresos-=$rcc->totcom2;
        
        array_push($this->id,1);
        array_push($this->codigo,"000");
        array_push($this->nombre,"Menudencias");
        array_push($this->debitos,$egresos);
        array_push($this->creditos,0);
        array_push($this->espacios,"&nbsp;");
        array_push($this->saldo,-$egresos);
        array_push($this->letra,"S");
        array_push($this->cantespacios,2);
        array_push($this->subtotal,0);
        array_push($this->anterior,"");
        
        if($civa==1) {
            $percepciones=0;
            $ssql="select sum(retiva + periva + perretiibb + impinternos) as totalimp from adm_com inner join adm_prv on adm_com.idprv=adm_prv.id where fecha>='$fechaini' and fecha<='$fechafin' and adm_prv.tipo=2 and adm_com.tipocom!=2";
//            echo $ssql."<br>";
            $ri=$conx->consultaBase($ssql, $conn);
            $rii=mysqli_fetch_object($ri);

            if($rii->totalimp!=NULL) $percepciones=$rii->totalimp;
        
            $ssql="select sum(retiva + periva + perretiibb + impinternos) as totalimp from adm_com inner join adm_prv on adm_com.idprv=adm_prv.id where fecha>='$fechaini' and fecha<='$fechafin' and adm_prv.tipo=2 and adm_com.tipocom=2";
            $ri=$conx->consultaBase($ssql, $conn);
            $rii=mysqli_fetch_object($ri);

            if($rii->totalimp!=NULL) $percepciones-=$rii->totalimp;
        
        
            array_push($this->id,1);
            array_push($this->codigo,"000");
            array_push($this->nombre,"Impuestos Vs.");
            array_push($this->debitos,$percepciones);
            array_push($this->creditos,0);
            array_push($this->espacios,"&nbsp;");
            array_push($this->saldo,-$percepciones);
            array_push($this->letra,"S");
            array_push($this->cantespacios,2);
            array_push($this->subtotal,0);
            array_push($this->anterior,"");
        }
        
        $nivel=4;
        
        $ssql="select * from adm_clasif where tipodep!=''";
//        $ssql.=" and left(codigo,3)='004'";
        switch($nivel) {
            case 1:
                $ssql.=" and tipo='DESN1'";
                break;
            case 2:
                $ssql.=" and (tipo='DESN1' or tipo='DESN2')";
                break;
            case 3:
                $ssql.=" and (tipo='DESN1' or tipo='DESN2' or tipo='DESN3')";
                break;
        }
        $ssql.=" order by codigodep";
//        echo $ssql."\n";
        $cta=new adm_clasif_2($ssql,$conn);
        $c_id=$cta->getId();
        $c_nom=$cta->getTexto();
        $c_cta=$cta->getCodigodep();
//        print_r($c_cta);
        $c_ant=$cta->getDependenciacod();
        $c_stt=$cta->getSubtotal();
        for($i=0;$i<count($c_cta);$i++) { 
            $ceros=ltrim(rtrim(strlen($c_cta[$i])))-1;
            for($k=strlen($c_cta[$i])-1;$k>=0;$k--) {
                if(substr($c_cta[$i],$k,1)=="0")
                    $ceros--;
                else
                    break;
            }
            $espacios="";
            $cc=0;
            $ceros=$ceros-2;
            $ceros=strlen($c_cta[$i])/3;
//            echo "ceros: $ceros<br>";
            for($k=0;$k<$ceros;$k++) {
                $espacios.="&nbsp;";
                $cc=$cc+3;
            }
            $tipoletra="letra6";
            $condicioncta=$this->getSqlcuenta0($c_cta[$i], 1, 0, "adm_com",$conn);
            $condicionctadet=$this->getSqlcuenta0($c_cta[$i], 1, 0, "adm_com_det",$conn);
            $condiciongas=$this->getSqlcuenta0($c_cta[$i], 1, 0, "adm_gas",$conn);
//            echo "condicioncta: $condicioncta\n";
            $ssqle="select sum(est_mov_caja.importe) as totalentrada from est_mov_caja where est_mov_caja.tipomov=0 and ($condicioncta) and est_mov_caja.fecha>='$fechaini' and est_mov_caja.fecha<='$fechafin'";
//            $ssqls="select sum(adm_com_det.importe) as totalsalida from adm_com_det, adm_com where adm_com_det.idcom=adm_com.id and adm_com.tipo=2 and ($condicionctadet) and adm_com.fecha>='$fechaini' and adm_com.fecha<='$fechafin' and tipocom!=2";
            $ssqlg="select sum(importe) as totalgastos from adm_gas where fecha>='$fechaini' and fecha<='$fechafin' and ($condiciongas)";
//            echo $ssqle."\n";
//            echo $ssqls."<br>\n";
            if($conx->getCantidadRegA($ssqle,$conn)>0) {
                $rs=$conx->consultaBase($ssqle, $conn);
                $reg=mysqli_fetch_object($rs);
                $entrada=$reg->totalentrada;
            } else
                $entrada=0;

//            if($conx->getCantidadRegA($ssqls,$conn)>0) {
//                $rs=$conx->consultaBase($ssqls, $conn);
//                $reg=mysqli_fetch_object($rs);
//                $salida=$reg->totalsalida;
//            } else
//                $salida=0;
            
            if($conx->getCantidadRegA($ssqlg,$conn)>0) {
                $rs=$conx->consultaBase($ssqlg, $conn);
                $reg=mysqli_fetch_object($rs);
                $gasto=$reg->totalgastos;
            } else
                $gasto=0;
            
            //$ssqls="se-lect sum(adm_com.neto10+adm_com.neto21+adm_com.neto27+adm_com.neto17+adm_com.nogravado+adm_com.exento) as totalsalida from adm_com where adm_com.tipo=2 and ($condicioncta) and adm_com.fecha>='$fechaini' and adm_com.fecha<='$fechafin' and tipocom=2";
            $ssqls="select adm_com_det.*, adm_com.neto21, adm_com.neto10, adm_com.neto27 from adm_com_det, adm_com where adm_com_det.idcom=adm_com.id and adm_com.tipocom!=2 and ($condicionctadet) and adm_com.fecha>='$fechaini' and adm_com.fecha<='$fechafin'";
            echo $ssqls."\n";
            $tots=0;
            $canx=$conx->getCantidadRegA($ssqls, $conn);
            //echo "can: $canx\n";
//            echo "civa: $civa\n";
            if($canx>0) {
                $rs=$conx->consultaBase($ssqls, $conn);
                while($reg=mysqli_fetch_object($rs)) {
//                    echo $reg->neto21."\n";
//                    echo $reg->neto10."\n";
//                    echo $reg->neto27."\n";
                    if($civa==1) {
                        if($reg->neto21>0) {
                            $xx=$reg->importe+$reg->importe*21/100;
                            $tots+=$xx;
//                            echo $reg->importe." ".$reg->neto21." ".$xx."\n";
                        }
                        if($reg->neto10>0) $tots+=$reg->importe+$reg->importe*10.5/100;
                        if($reg->neto27>0) $tots+=$reg->importe+$reg->importe*27/100;
                    } else
                        $tots+=$reg->importe;
                }
            }
            $salida=$tots;
            $ssqls="select adm_com_det.*, adm_com.neto21, adm_com.neto10, adm_com.neto27 from adm_com_det, adm_com where adm_com_det.idcom=adm_com.id and adm_com.tipo=2 and ($condicionctadet) and adm_com.fecha>='$fechaini' and adm_com.fecha<='$fechafin' and adm_com.tipocom=2";
            //echo $ssqls."\n";
            $tots=0;
            $canx=$conx->getCantidadRegA($ssqls, $conn);
            //echo "can: $canx\n";
//            echo "civa: $civa\n";
            if($canx>0) {
                $rs=$conx->consultaBase($ssqls, $conn);
                while($reg=mysqli_fetch_object($rs)) {
//                    echo $reg->neto21."\n";
//                    echo $reg->neto10."\n";
//                    echo $reg->neto27."\n";
                    if($civa==1) {
                        if($reg->neto21>0) {
                            $xx=$reg->importe+$reg->importe*21/100;
                            $tots+=$xx;
//                            echo $reg->importe." ".$reg->neto21." ".$xx."\n";
                        }
                        if($reg->neto10>0) $tots+=$reg->importe+$reg->importe*10.5/100;
                        if($reg->neto27>0) $tots+=$reg->importe+$reg->importe*27/100;
                    } else
                        $tots+=$reg->importe;
                }
            }
            $salida-=$tots;
            
            
            
            
            
            
//            $ssqls="select sum(adm_com_det.importe) as totalsalida from adm_com_det, adm_com where adm_com_det.idcom=adm_com.id and adm_com.tipo=2 and ($condicionctadet) and adm_com.fecha>='$fechaini' and adm_com.fecha<='$fechafin' and tipocom=2";
////            echo $ssqle."\n";
//            echo $ssqls."<br>\n";
//            if($conx->getCantidadRegA($ssqls,$conn)>0) {
//                $rs=$conx->consultaBase($ssqls, $conn);
//                $reg=mysqli_fetch_object($rs);
//                echo "imp: ".$reg->totalsalida."\n";
//                $salida-=$reg->totalsalida;
//            }
//            if($entrada>0 or $salida>0) {
//                echo "Entrada: $entrada<br>";
//                echo "Salida: $salida<br>";
//                echo $ssqle."<br>";
//                echo $ssqls."<br>";
//            }

//            if($entrada>0 or $salida>0) {
                array_push($this->id,$c_id[$i]);
                array_push($this->codigo,$c_cta[$i]);
                array_push($this->nombre,$c_nom[$i]);
                array_push($this->debitos,$entrada);
                array_push($this->creditos,$salida+$gasto);
                array_push($this->espacios,$espacios);
                array_push($this->saldo,$entrada-$salida-$gasto);
                array_push($this->letra,$tipoletra);
                array_push($this->cantespacios,$cc);
//                array_push($this->subtotal,$c_stt[$i]);
                
//            }
        }
        
    }
    
    function getSqlcuenta0($codigo, $centro, $idemp, $arc, $conn) {
        require_once 'clases/conexion.php';
        $conx=new conexion();
//        echo substr($codigo,strlen($codigo)-2,strlen($codigo))."\n";
        if(substr($codigo,strlen($codigo)-2,strlen($codigo))=="00") {
            $codigosincero="";
            for($ii=0;$ii<strlen($codigo);$ii++) {
                if(substr($codigo,$ii,1)!="0")
                  $codigosincero.=substr($codigo,$ii,1);
            }
//            echo "codigosincero: $codigosincero\n";
//            echo strlen($codigosincero)."<br>";
            $ssql="select * from adm_clasif where left(codigodep,".strlen($codigosincero).")='$codigosincero'";
//            echo "2- ".$ssql."<br>";
            $rs=$conx->consultaBase($ssql, $conn);
            $condicion="";
            while($reg=mysqli_fetch_object($rs)) {
                $condicion.="$arc.descriptor1=".$reg->id." or $arc.descriptor2=".$reg->id." or $arc.descriptor3=".$reg->id." or $arc.descriptor4=".$reg->id." or ";
            }
        } else {
            $ssql="select * from adm_clasif where codigodep='$codigo'";
//            echo "1- ".$ssql."<br>";
            $rs=$conx->consultaBase($ssql, $conn);
            $reg=mysqli_fetch_object($rs);
            $condicion="";
            $condicion.="$arc.descriptor1=".$reg->id;
            $condicion.=" or $arc.descriptor2=".$reg->id;
            $condicion.=" or $arc.descriptor3=".$reg->id;
            $condicion.=" or $arc.descriptor4=".$reg->id." or ";
        }
        if($condicion!="")
            $condicion=substr($condicion,0,strlen($condicion)-4);
        return $condicion;
    }
      
    function getId() { return $this->id; }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDebitos() {
        return $this->debitos;
    }

    function getCreditos() {
        return $this->creditos;
    }

    function getLetra() {
        return $this->letra;
    }

    function getEspacios() {
        return $this->espacios;
    }
    
    function getSaldo() {
        return $this->saldo;
    }
    
    function getSubtotal() { return $this->subtotal; }
    function getAnterior() { return $this->anterior; }
    
    function getCantespacios() {
        return $this->cantespacios;
    }

}

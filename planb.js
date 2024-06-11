function ConfirmaBaja(cad,url) {
  var respuesta=confirm(cad);
  if (respuesta==true) {
    document.form1.action=url;
    document.form1.submit();
  }
}

function bajareg(id,cartel,url) {
    document.form1.id.value=id;
    ConfirmaBaja(cartel,url);
}


function overTD(td,color) {
	td.bgColor=color;
}
	
function outTD(td,color) {
	td.bgColor=color;
}

function overTR(tr,color) {
	tr.bgColor=color;
}
	
function outTR(tr,color) {
	tr.bgColor=color;
}



function isset(variable_name) {
    try {
         if (typeof(eval(variable_name)) != 'undefined')
         if (eval(variable_name) != null)
         return true;
    } catch(e) { }
    return false;
}

function validar(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==32) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==0) return true; //Tecla <TAB> para pasar de campo
    patron = /\d/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te); 
} 

function validarnumero(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    //if (tecla==32) return true; //Tecla de espacio (para poder borrar)
    if (tecla==0) return true; //Tecla <TAB> para pasar de campo
    patron = /\d/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te); 
} 


function validar_punto(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==46) return true;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==32) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==0) return true; //Tecla <TAB> para pasar de campo
    patron = /\d/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te); 
} 

function validar_punto_menos(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    //alert(tecla);
    if (tecla==46) return true;
    if (tecla==8) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==32) return true; //Tecla de retroceso (para poder borrar)
    if (tecla==0) return true; //Tecla <TAB> para pasar de campo
    if (tecla==45) return true;
    patron = /\d/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te); 
} 

function recalcula_det_venta() {
    d_pre="item_precio[]";
    d_can="item_cantidad[]";
    d_tot="item_total[]";
    ttot=0;
    //can=document.form1.elements["item_precio[]"].length;
    can=d_pre.length;
    //alert("cantidad: " + can);
    for(i=0;i<can;i++) {
        tot=0;
        alert(i + " " + d_pre[i].value + " " + d_can[i].value);
        if(d_pre[i].value!='' && d_can[i].value!='') {
            tot=parseFloat(d_pre[i].value) * parseInt(d_can[i].value);
            alert(tot);
        }
        tot=Math.round(tot*100)/100;
        d_tot[i].value=tot;
        ttot+=tot;
    }
    document.getElementById("totaltotal").value=ttot;
    
    
}



function calcula_total_opg() {
//    alert(1);
    det_importe="item_item[]";
    tot=0;
    can=document.getElementById("form1").elements['item_importe[]'].length;
    alert(can);
    d_imp=document.getElementById("form1").elements[det_importe];
    alert(d_imp.length);
//    document.getElementById("elem").value=d_can.length;
    for(i=0;i<d_imp.length;i++) {
        alert(d_imp[i].value);
        if(d_imp[i].value!='') {
            tot+=parseInt(d_imp[i].value);
        }
    }
    tot=Math.round(tot*100)/100;
    document.getElementById("importe").value=tot;
    alert(tot);
    
}


function ajaxobj() {
  try {
    _ajaxobj = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      _ajaxobj = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      _ajaxobj = false;
    }
  }
   
  if (!_ajaxobj && typeof XMLHttpRequest!='undefined') {
    _ajaxobj = new XMLHttpRequest();
  }
  
  return _ajaxobj;
}


function cargapedidos(val) {
    //alert(val);
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxcargapedidos.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            var obj1 = document.getElementById("idped");
            //alert(obj1.options.length);
            while(obj1.options.length>0) {
                obj1.remove(0);
            }
            texto=new Array(datos.lenght);
            //alert(datos.childNodes.length);
            for (var i=0; i<datos.childNodes.length; i++) {
                var elem = datos.childNodes[i].firstChild.data;
                //alert(elem);
                texto[i]=elem;
            }
            j=0;
            for (var i=0; i<texto.length;i++) {
                obj1.options[j] = new Option(texto[i+1],texto[i]);
                i++;
                j++;
            }
        } 
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
    
}

function articulos_remito(val, indice) {
    var ajax = ajaxobj();
//    alert(val);
//    alert(indice);
    det_cantidad="item_cantidad" + indice;
    det_precio="item_precio" + indice;
    det_total="item_total" + indice;
    det_alicuota="item_iva" + indice;
//    alert("1 "+det_alicuota);
    prov=document.getElementById("idprv").value;
    //alert(det_precio);
    cantidaddet=document.getElementById("cantidaddet").value;
    ajax.open("POST", "ajaxarticulos_remito.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            document.getElementById(det_precio).value=datos.childNodes[0].firstChild.data;
            xtot=parseFloat(datos.childNodes[0].firstChild.data)*parseFloat(document.getElementById(det_cantidad).value)
            xtot=Math.round(xtot*100)/100;
            if(isNaN(xtot))
                document.getElementById(det_total).value="";
            else
                document.getElementById(det_total).value=xtot;
            cantd=document.getElementById("cantidaddet").value;
            alicuota=datos.childNodes[1].firstChild.data;
//            alert(alicuota);
            obj=document.getElementById(det_alicuota);
            xlen=obj.length;
            for(i=0;i<xlen;i++) {
                if(parseFloat(obj.options[i].value)==parseFloat(alicuota)) {
                    obj.selectedIndex=i;
                    break;
                }
            }
            
        //    alert(cantd);
            ttot=0;
            for(i=0;i<100;i++) {
                det_total="item_total" + i;
                obj=document.getElementById(det_total);
                if(isset(obj)) {
                    if(document.getElementById(det_total).value!="")
                        ttot+=parseFloat(document.getElementById(det_total).value);
                }
            }
            ttot=Math.round(ttot*100)/100;
            document.getElementById("totaltotal").value=ttot;
        } 
        
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val=" + val + "&prov=" + prov + "&indice=" + indice);
}

function articulos_pedido(val, indice) {
    var ajax = ajaxobj();
//    alert(val);
//    alert(indice);
    det_cantidad="item_cantidad" + indice;
    det_precio="item_precio" + indice;
    det_total="item_total" + indice;
    cli=document.getElementById("idcli").value;
    //alert(det_precio);
    cantidaddet=document.getElementById("cantidaddet").value;
    ajax.open("POST", "ajaxarticulos_pedido.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            document.getElementById(det_precio).value=datos.childNodes[0].firstChild.data;
            xtot=parseFloat(datos.childNodes[0].firstChild.data)*parseFloat(document.getElementById(det_cantidad).value)
            xtot=Math.round(xtot*100)/100;
            if(isNaN(xtot))
                document.getElementById(det_total).value="";
            else
                document.getElementById(det_total).value=xtot;
            cantd=document.getElementById("cantidaddet").value;
        //    alert(cantd);
            ttot=0;
            for(i=0;i<100;i++) {
                det_total="item_total" + i;
                obj=document.getElementById(det_total);
                if(isset(obj)) {
                    if(document.getElementById(det_total).value!="")
                        ttot+=parseFloat(document.getElementById(det_total).value);
                }
            }
            ttot=Math.round(ttot*100)/100;
            document.getElementById("totaltotal").value=ttot;
        } 
        
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val=" + val + "&cli=" + cli + "&indice=" + indice);
}

function recalcula_det_remito(indice) {
    det_precio="item_precio" + indice;
    det_cantidad="item_cantidad" + indice;
    det_total="item_total" + indice;
    tot=0;
    if(document.form1[det_precio].value!='' && document.form1[det_cantidad].value!='') {
        tot=parseFloat(document.form1[det_precio].value) * parseFloat(document.form1[det_cantidad].value);
    }
    tot=Math.round(tot*100)/100;
    document.form1[det_total].value=tot;
    
    ttot=0;
    for(i=0;i<=100;i++) {
        det_total="item_total" + i;
        obj=document.getElementById(det_total);
        if(isset(obj)) {
            if(document.getElementById(det_total).value!="")
                ttot+=parseFloat(document.getElementById(det_total).value);
        }
    }
    ttot=Math.round(ttot*100)/100;
    document.getElementById("totaltotal").value=ttot;
}

function recalcula_det_pedido(indice) {
    det_precio="item_precio" + indice;
    det_cantidad="item_cantidad" + indice;
    det_total="item_total" + indice;
    tot=0;
    if(document.form1[det_precio].value!='' && document.form1[det_cantidad].value!='') {
        tot=parseFloat(document.form1[det_precio].value) * parseFloat(document.form1[det_cantidad].value);
    }
    tot=Math.round(tot*100)/100;
    document.form1[det_total].value=tot;
    
    ttot=0;
    for(i=0;i<=100;i++) {
        det_total="item_total" + i;
        obj=document.getElementById(det_total);
        if(isset(obj)) {
            if(document.getElementById(det_total).value!="")
                ttot+=parseFloat(document.getElementById(det_total).value);
        }
    }
    ttot=Math.round(ttot*100)/100;
    document.getElementById("totaltotal").value=ttot;
}

function tot_pedido() {
    ttot=0;
    for(i=0;i<=100;i++) {
        det_total="item_total" + i;
        obj=document.getElementById(det_total);
        if(isset(obj)) {
            if(document.getElementById(det_total).value!="")
                ttot+=parseFloat(document.getElementById(det_total).value);
        }
    }
    ttot=Math.round(ttot*100)/100;
    document.getElementById("totaltotal").value=ttot;
    
}

function tot_remito() {
    ttot=0;
    for(i=0;i<=100;i++) {
        det_total="item_total" + i;
        obj=document.getElementById(det_total);
        if(isset(obj)) {
            if(document.getElementById(det_total).value!="")
                ttot+=parseFloat(document.getElementById(det_total).value);
        }
    }
    ttot=Math.round(ttot*100)/100;
    document.getElementById("totaltotal").value=ttot;
    
}


function total_venta_fis() {
    tot=0;
    cant=document.form1.cantd.value;
    netocf21=0;
    netocf10=0;
    netori21=0;
    netori10=0;
    ivacf21=0;
    ivacf10=0;
    ivari21=0;
    ivari10=0;
    nogravado=0;
    totalneto=0;
    cond=document.form1["condicioniva"].value;
    for(i=0;i<cant;i++) {
        det_total='det_total' + i;
        det_alicuota='det_alicuota' + i
        if(document.form1[det_total].value!='') {
            alicuota=document.form1[det_alicuota].value;
            importe=document.form1[det_total].value;
            neto=importe / (1+alicuota/100);
            if(alicuota>0)
                totalneto+=neto;
            iva=importe-neto;
//            alert(alicuota);
            xalicuota=parseFloat(alicuota);
//            alert(xalicuota);
            if(cond==3) {
                switch (xalicuota) {
                    case 21:
                        netori21+=parseFloat(neto);
                        ivari21+=parseFloat(iva);
                        break;
                    case 10.5:
                        netori10+=parseFloat(neto);
                        ivari10+=parseFloat(iva);
                        break;
                    default:
                        nogravado+=parseFloat(importe);
                        break;
                }
            } else {
                switch (xalicuota) {
                    case 21:
                        netocf21+=parseFloat(neto);
                        ivacf21+=parseFloat(iva);
                        break;
                    case 10.5:
                        netocf10+=parseFloat(neto);
                        ivacf10+=parseFloat(iva);
                        break;
                    default:
                        nogravado+=parseFloat(importe);
                        break;
                }
            }
            tot+=parseFloat(document.form1[det_total].value);
        }
        
    }
//    document.form1.subtotal.value=Math.round(tot*100)/100;
    if(document.form1.porcentajeiibb.value!="") {
        perc=totalneto*parseFloat(document.form1.porcentajeiibb.value)/100;
        perc=Math.round(perc*100)/100;
        document.form1.percepcioniibb.value=perc;
        tot+=parseFloat(document.form1.percepcioniibb.value);
    }
    


//    tot-=parseFloat(document.form1.descuento.value);
//alert(nogravado);
    tot=Math.round(tot*100)/100;
    netocf21=Math.round(netocf21*100)/100;
    netocf10=Math.round(netocf10*100)/100;
    netori21=Math.round(netori21*100)/100;
    netori10=Math.round(netori10*100)/100;
    ivacf21=Math.round(ivacf21*100)/100;
    ivacf10=Math.round(ivacf10*100)/100;
    ivari21=Math.round(ivari21*100)/100;
    ivari10=Math.round(ivari10*100)/100;
    nogravado=Math.round(nogravado*100)/100;
    document.form1.totaltotal.value=tot;
    document.form1.netocf21.value=netocf21;
    document.form1.netori21.value=netori21;
    document.form1.netocf10.value=netocf10;
    document.form1.netori10.value=netori10;
    document.form1.ivacf21.value=ivacf21;
    document.form1.ivacf10.value=ivacf10;
    document.form1.ivari21.value=ivari21;
    document.form1.ivari10.value=ivari10;
    document.form1.nogravado.value=nogravado;
}

function recalcula_det_venta_fis(indice) {
    det_precio="det_precio" + indice;
    det_cantidad="det_cantidad" + indice;
    det_total="det_total" + indice;
    det_preciodes="det_precio" + indice;
    tot=0;
    prd=0;
    if(document.form1[det_precio].value!='' && document.form1[det_cantidad].value!='') {
        prd=document.form1[det_precio].value;
        tot=parseFloat(prd) * parseInt(document.form1[det_cantidad].value);
    }
    tot=Math.round(tot*100)/100;
    document.form1[det_total].value=tot;
}

function set_importes(c, vernc) {
    xneto0=0;
    xneto10=0;
    xneto21=0;
    xiva21=0;
    xiva10=0;

    xnetor0=0;
    xnetor10=0;
    xnetor21=0;
    xivar21=0;
    xivar10=0;
    
    for(i=0;i<c;i++) {
        cancela="cancela" + i;
        neto0="r_neto0" + i;
        neto10="r_neto10" + i;
        neto21="r_neto21" + i;
        iva10="r_iva10" + i;
        iva21="r_iva21" + i;
        
        if(vernc==1) {
            netor0='r_netor0' + i;
            netor10='r_netor10' + i;
            netor21='r_netor21' + i;
            ivar10='r_ivar10' + i;
            ivar21='r_ivar21' + i;
        }
        
        if(document.getElementById(cancela).checked==true) {
            xneto0+=parseFloat(document.getElementById(neto0).value);
//            alert(xneto10);
//            alert(document.getElementById(neto10).value);
            xneto10+=parseFloat(document.getElementById(neto10).value);
//            alert(xneto10);
            xneto21+=parseFloat(document.getElementById(neto21).value);
            xiva10+=parseFloat(document.getElementById(iva10).value);
            xiva21+=parseFloat(document.getElementById(iva21).value);
            
            if(vernc==1) {
                xnetor0+=parseFloat(document.getElementById(neto0).value) - parseFloat(document.getElementById(netor0).value);
                xnetor10+=parseFloat(document.getElementById(neto10).value) - parseFloat(document.getElementById(netor10).value);
                xnetor21+=parseFloat(document.getElementById(neto21).value) - parseFloat(document.getElementById(netor21).value);
                xivar10+=parseFloat(document.getElementById(iva10).value) - parseFloat(document.getElementById(ivar10).value);
                xivar21+=parseFloat(document.getElementById(iva21).value) - parseFloat(document.getElementById(ivar21).value);
            }
        }
    }
    tot=xneto0+xneto10+xneto21+xiva10+xiva21;
    document.getElementById("nogravado").value=xneto0;
    document.getElementById("neto10").value=xneto10;
    document.getElementById("neto21").value=xneto21;
    document.getElementById("iva10").value=xiva10;
    document.getElementById("iva21").value=xiva21;
    document.getElementById("totalfactura").value=tot;
    
    if(vernc==1) {
        totnc=xnetor0+xnetor10+xnetor21+xivar10+xivar21;
        document.getElementById("nogravadonc").value=xnetor0;
        document.getElementById("netonc10").value=xnetor10;
        document.getElementById("netonc21").value=xnetor21;
        document.getElementById("ivanc10").value=xivar10;
        document.getElementById("ivanc21").value=xivar21;
        document.getElementById("totalnc").value=totnc;
    }
    
}

function cargades1(val) {
    caj=document.getElementById("tipocaja").value;
    if(val!="") {
        var ajax = ajaxobj();
        ajax.open("POST", "ajaxdescriptor1.php", true);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                var datos = (ajax.responseXML).firstChild;
                var obj1 = document.getElementById("descriptor4");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");

                var obj1 = document.getElementById("descriptor3");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");
                
                var obj1 = document.getElementById("descriptor2");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                var obj1 = document.getElementById("descriptor1");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                texto=new Array(datos.lenght);
                //alert(texto.length);
                //alert(datos.childNodes.length);
                for (var i=0; i<datos.childNodes.length; i++) {
                    //alert(datos.childNodes[i].firstChild.data);
                    var elem = datos.childNodes[i].firstChild.data;
                    //alert(elem);
                    texto[i]=elem;
                }
                j=1;
                //alert(texto.length);
                obj1.options[0]=new Option('[Ninguno]',0);
                for (var i=0; i<texto.length;i++) {
                    obj1.options[j] = new Option(texto[i+1],texto[i]);
                    i++;
                    j++;
                }
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val+"&caj="+caj);
    
}


function cargades2(val) {
    caj=document.getElementById("tipocaja").value;
    if(val!="") {
        var ajax = ajaxobj();
        ajax.open("POST", "ajaxdescriptor2.php", true);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                var datos = (ajax.responseXML).firstChild;
                var obj1 = document.getElementById("descriptor4");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");

                var obj1 = document.getElementById("descriptor3");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");
                
                var obj1 = document.getElementById("descriptor2");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                texto=new Array(datos.lenght);
                //alert(texto.length);
                //alert(datos.childNodes.length);
                for (var i=0; i<datos.childNodes.length; i++) {
                    //alert(datos.childNodes[i].firstChild.data);
                    var elem = datos.childNodes[i].firstChild.data;
                    //alert(elem);
                    texto[i]=elem;
                }
                j=1;
                //alert(texto.length);
                obj1.options[0]=new Option('[Ninguno]',0);
                for (var i=0; i<texto.length;i++) {
                    obj1.options[j] = new Option(texto[i+1],texto[i]);
                    i++;
                    j++;
                }
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val+"&caj="+caj);
    
}

function cargades3(val) {
    caj=document.getElementById("tipocaja").value;
    if(val!="") {
        var ajax = ajaxobj();
        ajax.open("POST", "ajaxdescriptor3.php", true);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                var datos = (ajax.responseXML).firstChild;
                var obj1 = document.getElementById("descriptor4");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");
                
                var obj1 = document.getElementById("descriptor3");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                texto=new Array(datos.lenght);
                //alert(texto.length);
                //alert(datos.childNodes.length);
                for (var i=0; i<datos.childNodes.length; i++) {
                    var elem = datos.childNodes[i].firstChild.data;
                    //alert(elem);
                    texto[i]=elem;
                }
                j=1;
                //alert(texto.length);
                obj1.options[0]=new Option('[Ninguno]',0);
                for (var i=0; i<texto.length;i++) {
                    obj1.options[j] = new Option(texto[i+1],texto[i]);
                    i++;
                    j++;
                }
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val+"&caj="+caj);
    
}

function cargades4(val) {
    caj=document.getElementById("tipocaja").value;
    if(val!="") {
        var ajax = ajaxobj();
        ajax.open("POST", "ajaxdescriptor4.php", true);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                var datos = (ajax.responseXML).firstChild;
                var obj1 = document.getElementById("descriptor4");
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                texto=new Array(datos.lenght);
                //alert(texto.length);
                //alert(datos.childNodes.length);
                for (var i=0; i<datos.childNodes.length; i++) {
                    var elem = datos.childNodes[i].firstChild.data;
                    //alert(elem);
                    texto[i]=elem;
                }
                j=1;
                //alert(texto.length);
                obj1.options[0]=new Option('[Ninguno]',0);
                for (var i=0; i<texto.length;i++) {
                    obj1.options[j] = new Option(texto[i+1],texto[i]);
                    i++;
                    j++;
                }
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val+"&caj="+caj);
    
}

function cargades1v(val, descriptor, control) {
    des1=descriptor + "1" + control;
    des4=descriptor + "4" + control;
    des3=descriptor + "3" + control;
    des2=descriptor + "2" + control;
    if(val!="") {
        var ajax = ajaxobj();
        ajax.open("POST", "ajaxdescriptor1.php", true);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                var datos = (ajax.responseXML).firstChild;
                var obj1 = document.getElementById(des4);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");

                var obj1 = document.getElementById(des3);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");
                
                var obj1 = document.getElementById(des2);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                var obj1 = document.getElementById(des1);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                texto=new Array(datos.lenght);
                //alert(texto.length);
                //alert(datos.childNodes.length);
                for (var i=0; i<datos.childNodes.length; i++) {
                    //alert(datos.childNodes[i].firstChild.data);
                    var elem = datos.childNodes[i].firstChild.data;
                    //alert(elem);
                    texto[i]=elem;
                }
                j=1;
                //alert(texto.length);
                obj1.options[0]=new Option('[Ninguno]',0);
                for (var i=0; i<texto.length;i++) {
                    obj1.options[j] = new Option(texto[i+1],texto[i]);
                    i++;
                    j++;
                }
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
    
}


function cargades2v(val, descriptor, control) {
    des4=descriptor + "4" + control;
    des3=descriptor + "3" + control;
    des2=descriptor + "2" + control;
    if(val!="") {
        var ajax = ajaxobj();
        ajax.open("POST", "ajaxdescriptor2.php", true);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                var datos = (ajax.responseXML).firstChild;
                var obj1 = document.getElementById(des4);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");

                var obj1 = document.getElementById(des3);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");
                
                var obj1 = document.getElementById(des2);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                texto=new Array(datos.lenght);
                //alert(texto.length);
                //alert(datos.childNodes.length);
                for (var i=0; i<datos.childNodes.length; i++) {
                    //alert(datos.childNodes[i].firstChild.data);
                    var elem = datos.childNodes[i].firstChild.data;
                    //alert(elem);
                    texto[i]=elem;
                }
                j=1;
                //alert(texto.length);
                obj1.options[0]=new Option('[Ninguno]',0);
                for (var i=0; i<texto.length;i++) {
                    obj1.options[j] = new Option(texto[i+1],texto[i]);
                    i++;
                    j++;
                }
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
    
}

function cargades3v(val, descriptor, control) {
    des4=descriptor + "4" + control;
    des3=descriptor + "3" + control;
    if(val!="") {
        var ajax = ajaxobj();
        ajax.open("POST", "ajaxdescriptor3.php", true);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                var datos = (ajax.responseXML).firstChild;
                var obj1 = document.getElementById(des4);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                //obj1.options[0]=new Option("[Ninguno]","0");
                
                var obj1 = document.getElementById(des3);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                texto=new Array(datos.lenght);
                //alert(texto.length);
                //alert(datos.childNodes.length);
                for (var i=0; i<datos.childNodes.length; i++) {
                    var elem = datos.childNodes[i].firstChild.data;
                    //alert(elem);
                    texto[i]=elem;
                }
                j=1;
                //alert(texto.length);
                obj1.options[0]=new Option('[Ninguno]',0);
                for (var i=0; i<texto.length;i++) {
                    obj1.options[j] = new Option(texto[i+1],texto[i]);
                    i++;
                    j++;
                }
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
    
}

function cargades4v(val, descriptor, control) {
    des4=descriptor + "4" + control;
    if(val!="") {
        var ajax = ajaxobj();
        ajax.open("POST", "ajaxdescriptor4.php", true);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                var datos = (ajax.responseXML).firstChild;
                var obj1 = document.getElementById(des4);
                while(obj1.options.length>0) {
                    obj1.remove(0);
                }
                
                texto=new Array(datos.lenght);
                //alert(texto.length);
                //alert(datos.childNodes.length);
                for (var i=0; i<datos.childNodes.length; i++) {
                    var elem = datos.childNodes[i].firstChild.data;
                    //alert(elem);
                    texto[i]=elem;
                }
                j=1;
                //alert(texto.length);
                obj1.options[0]=new Option('[Ninguno]',0);
                for (var i=0; i<texto.length;i++) {
                    obj1.options[j] = new Option(texto[i+1],texto[i]);
                    i++;
                    j++;
                }
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
    
}

function marcar_desmarcar(control, cantidad) {
  for(i=0;i<cantidad;i++) {
    chk=control + i;
    if(document.getElementById(chk).checked==true) {
      document.getElementById(chk).checked=false
    } else {
      document.getElementById(chk).checked=true
    }
  }
}

function showdiv(control, indice) {
    xcnot=control + indice;
//    alert(xcnot);
    document.getElementById(xcnot).style.display='block';
}
function hidediv(control, indice) {
    xcnot=control + indice;
    document.getElementById(xcnot).style.display='none';
}






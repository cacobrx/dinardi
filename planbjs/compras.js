/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function VerificaCompra() {
    pto=document.getElementById("ptovta").value;
    nro=document.getElementById("numero").value;
    val=document.getElementById("idprv").value;
    fec=document.getElementById("fecha").value;
    tip=document.getElementById("tipocom").value;
    let=document.getElementById("letra").value
    
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxverificacompra.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            rep=datos.childNodes[0].firstChild.data;
            ret=datos.childNodes[1].firstChild.data;
//            alert("val: "+val+" pto: "+pto+" nro: "+nro+" fec: "+fec+" tip: "+tip);
//            alert(rep+" "+ret);
            document.getElementById("errorrep").innerHTML="*** ERROR: YA FUE INGRESADO ESTE COMPROBANTE ***";
            if(rep==0) {
                document.getElementById("agregar").style.visibility="visible";
                document.getElementById("errorrep").style.display="none";
            } else {
                if(rep==2)
                    document.getElementById("errorrep").innerHTML="** EL PERÍDO PARA LA FECHA SE ENCUENTRA CERRADO **";
                document.getElementById("agregar").style.visibility="hidden";
                document.getElementById("errorrep").style.display="block";
            }
            if(ret==0)
                document.getElementById("errorret").style.display="none";
            else
                document.getElementById("errorret").style.display="block";
                
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val+"&pto="+pto+"&nro="+nro+"&fec="+fec+"&tip="+tip+"&let="+let);
    
}


function Letra(val) {
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxletraproveedor.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            document.getElementById("letra").value=datos.childNodes[0].firstChild.data;
            if(datos.childNodes[0].firstChild.data!="A") {
                document.getElementById("cartelneto").style.visibility="hidden";
                document.getElementById("textoneto").style.visibility="hidden";
                if(datos.childNodes[0].firstChild.data=="X") {
                    document.getElementById("cartelx1").style.visibility="hidden";
                    document.getElementById("cartelx2").style.visibility="hidden";
                    document.getElementById("cartelx3").style.visibility="hidden";
                    document.getElementById("cartelx4").style.visibility="hidden";
                    document.getElementById("cartelx5").style.visibility="hidden";
                    document.getElementById("cartelx6").style.visibility="hidden";
                    document.getElementById("cartelx7").style.visibility="hidden";
                    document.getElementById("textox1").style.visibility="hidden";
                    document.getElementById("textox2").style.visibility="hidden";
                    document.getElementById("textox3").style.visibility="hidden";
                    document.getElementById("textox4").style.visibility="hidden";
                    document.getElementById("textox5").style.visibility="hidden";
                } else {
                    document.getElementById("cartelx1").style.visibility="visible";
                    document.getElementById("cartelx2").style.visibility="visible";
                    document.getElementById("cartelx3").style.visibility="visible";
                    document.getElementById("cartelx4").style.visibility="visible";
                    document.getElementById("cartelx5").style.visibility="visible";
                    document.getElementById("cartelx6").style.visibility="visible";
                    document.getElementById("cartelx7").style.visibility="visible";
                    document.getElementById("textox1").style.visibility="visible";
                    document.getElementById("textox2").style.visibility="visible";
                    document.getElementById("textox3").style.visibility="visible";
                    document.getElementById("textox4").style.visibility="visible";
                    document.getElementById("textox5").style.visibility="visible";
                }
            } else {
                document.getElementById("cartelneto").style.visibility="visible";
                document.getElementById("textoneto").style.visibility="visible";
                document.getElementById("cartelx1").style.visibility="visible";
                document.getElementById("cartelx2").style.visibility="visible";
                document.getElementById("cartelx3").style.visibility="visible";
                document.getElementById("cartelx4").style.visibility="visible";
                document.getElementById("cartelx5").style.visibility="visible";
                document.getElementById("cartelx6").style.visibility="visible";
                document.getElementById("cartelx7").style.visibility="visible";
                document.getElementById("textox1").style.visibility="visible";
                document.getElementById("textox2").style.visibility="visible";
                document.getElementById("textox3").style.visibility="visible";
                document.getElementById("textox4").style.visibility="visible";
                document.getElementById("textox5").style.visibility="visible";
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
    
}
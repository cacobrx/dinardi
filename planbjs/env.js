/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function codigolote(indice) {
    item_producto="item_producto" + indice;
    item_proveedor="item_proveedor" + indice;
    item_fecha="item_fecha" + indice;
    item_lote="item_lote" + indice;
    art=document.getElementById(item_producto).value;
    prv=document.getElementById(item_proveedor).value;
    fec=document.getElementById(item_fecha).value;
    
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxcodigolote.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            document.getElementById(item_lote).value=datos.childNodes[0].firstChild.data;;
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&art=" + art + "&prv=" + prv + "&fec=" + fec);
}

function codigolote1() {
    art=document.getElementById("idart").value;
    prv=document.getElementById("idprv").value;
    fec=document.getElementById("fechaing").value;
    
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxcodigolote.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            document.getElementById("lote").value=datos.childNodes[0].firstChild.data;;
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&art=" + art + "&prv=" + prv + "&fec=" + fec);
}

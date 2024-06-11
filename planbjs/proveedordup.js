/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function proveedordup (val) {
    tarea=document.getElementById("tarea").value;
    anterior=document.getElementById("cuitanterior").value;
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxproveedordup.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            rep=datos.childNodes[0].firstChild.data;
            if(rep==0) {
                document.getElementById("agregar").style.visibility="visible";
                document.getElementById("errorrep").style.display="none";
            } else {
                document.getElementById("agregar").style.visibility="hidden";
                document.getElementById("errorrep").style.display="block";
            }
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val+"&tarea="+tarea+"&anterior="+anterior);
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function crec2(val, indice) {
    idfis="idfis" + indice;
//    alert(idfis);
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxcrec2.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
            obj=document.getElementById(idfis);
            while(obj.options.length>0) {
                obj.remove(0);
            }
            
            can=datos.childNodes[0].firstChild.data;
            for(i=0;i<can;i++) {
                elem=datos.childNodes[i+1].firstChild.data;
                dd=elem.split("|");
                obj.options[i] = new Option(dd[1],dd[0]);
            }
                
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
    
}

// guardar_crec2(<?= $a_id[$i]?>, '<?= $i?>', '<?= $a_id[$i]?>'); hidediv('datosapli', '<?= $i?>')
function guardar_crec2(idfis, indice, idcrec) {
    idf="idfis" + indice;
    idfis=document.getElementById(idf).value;
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxguardarcrec2.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
//            alert(datos.childNodes[0].firstChild.data);
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+idfis+"&idcrec="+idcrec);
}


// borrar_crec2(<?= $r2_id[$i][$i2]?>, '<?= $i2?>')
function borrar_crec2(val, indice) {
    var ajax = ajaxobj();
    ajax.open("POST", "ajaxborrarcrec2.php", true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            var datos = (ajax.responseXML).firstChild;
//            alert(datos.childNodes[0].firstChild.data);
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send("&val="+val);
}
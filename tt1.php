<?php
/*
 * Creado el 23/05/2019 19:07:14
 * Autor: gus
 * Archivo: tt1.php
 * planbsistemas.com.ar
 */

?>
<html>
    <body>
        <form name="form1" id="form1" action="" method="post">
        </form>
<select name="item_producto" id="item_producto" onchange="javascript: articulos_remito(this.value, ' + cantidaddet + ')"><option value="">[Seleccionar]</option><option value="1">1 - HIGADO
 (Vacunos Fresco)</option><option value="2">2 - CORAZON
 (Vacunos Fresco)</option><option value="3">3 - RI (Vacunos Fresco)</option><option value="4">4 - SESO
 (Vacunos Fresco)</option><option value="5">5 - LENGUA
 (Vacunos Fresco)</option><option value="6">6 - BOFE
 (Vacunos Fresco)</option><option value="7">7 - RABO
 (Vacunos Fresco)</option><option value="8">8 - CENTRO DE ENTRA (Vacunos Fresco)</option><option value="9">9 - CHINCHULIN
 (Vacunos Fresco)</option><option value="10">10 - TRIPA GORDA
 (Vacunos Fresco)</option><option value="11">11 - MOLLEJA
 (Vacunos Fresco)</option><option value="12">12 - QUIJADA
 (Vacunos Fresco)</option><option value="13">13 - MONDONGO COCIDO
 (Vacunos Fresco)</option><option value="14">14 - RUEDA
 (Vacunos Fresco)</option><option value="15">15 - CUAJO
 (Vacunos Fresco)</option><option value="16">16 - UBRE
 (Vacunos Fresco)</option><option value="17">17 - RECORTE DE CARNE DE CABEZA
 (Vacunos Fresco)</option><option value="18">18 - PAJARILLA
 (Vacunos Fresco)</option><option value="19">19 - GA (Vacunos Fresco)</option><option value="20">20 - TRAGAPASTO
 (Vacunos Fresco)</option><option value="21">21 - MUCANGA
 (Vacunos Fresco)</option><option value="22">22 - TRONCO DE LENGUA
 (Vacunos Fresco)</option><option value="23">23 - NUEZ DE QUIJADA
 (Vacunos Fresco)</option><option value="24">24 - LABIO
 (Vacunos Fresco)</option><option value="25">25 - RI (Vacunos Fresco)</option><option value="26">26 - TRIPA SALAME VACUNA
 (Vacunos Fresco)</option><option value="27">27 - TRIPA ORILLA VACUNA
 (Vacunos Fresco)</option><option value="28">28 - TRAQUEA
 (Vacunos Fresco)</option><option value="29">29 - TENDON VACUNO
 (Vacunos Fresco)</option><option value="30">30 - TENDON COCIDO VACUNO
 (Vacunos Fresco)</option><option value="31">31 - MUCANGA CON HUESO
 (Vacunos Fresco)</option><option value="32">32 - MEMBRANA
 (Vacunos Fresco)</option><option value="33">33 - AORTA
 (Vacunos Fresco)</option><option value="34">34 - PANCREA VACUNO
 (Vacunos Fresco)</option><option value="35">35 - HIGADO VACUNO PROPIEDAD SPF
 (Vacunos Fresco)</option><option value="36">36 - HIGADO OPOTERAPICO
 (Vacunos Fresco)</option><option value="37">37 - RABO DE 2 (Vacunos Fresco)</option><option value="38">38 - VINZA
 (Vacunos Fresco)</option><option value="39">39 - CEBO
 (Vacunos Fresco)</option><option value="40">40 - HUESO
 (Vacunos Fresco)</option><option value="41">41 - MONDONGO VERDE
 (Vacunos Fresco)</option><option value="42">42 - MEDULA VACUNA
 (Vacunos Fresco)</option><option value="43">43 - CUAJO COCIDO
 (Vacunos Fresco)</option><option value="44">44 - LIBRILLO COCIDO
 (Vacunos Fresco)</option><option value="45">45 - LIBRILLO COCIDO DE 2 (Vacunos Fresco)</option><option value="46">46 - MONDONGO COCIDO 2 (Vacunos Fresco)</option><option value="47">47 - MONGONGO COCIDO 3 (Vacunos Fresco)</option><option value="48">48 - BONETE COCIDO VACUNO
 (Vacunos Fresco)</option><option value="49">49 - GRASA VACUNA
 (Vacunos Fresco)</option><option value="50">50 - MONDONGO NATURAL
 (Vacunos Fresco)</option><option value="51">51 - LENGUA DE SEGUNDA
 (Vacunos Fresco)</option><option value="53">53 - CHINCHULIN DE 2 (Vacunos Fresco)</option><option value="54">54 - CARTILAGO NASAL
 (Vacunos Fresco)</option><option value="55">55 - VINZA SUCIA
 (Vacunos Fresco)</option><option value="56">56 - BILIS
 (Vacunos Fresco)</option><option value="57">57 - AORTA SUCIA
 (Vacunos Fresco)</option><option value="58">58 - GRASA DE RABO
 (Vacunos Fresco)</option><option value="59">59 - CEBO DE 2 (Vacunos Fresco)</option><option value="60">60 - TRIPON
 (Vacunos Fresco)</option><option value="61">61 - TRAQUEA SUCIA
 (Vacunos Fresco)</option><option value="62">62 - ESCAPULA VACUNA
 (Vacunos Fresco)</option><option value="63">63 - BONETE VERDE VACUNO
 (Vacunos Fresco)</option><option value="64">64 - BONETE NATURAL VACUNO
 (Vacunos Fresco)</option><option value="65">65 - TENDON CERVICAL
 (Vacunos Fresco)</option><option value="99">99 - COMPLETOS
 (Vacunos Fresco)</option><option value="101">101 - HIGADO DE CERDO
 (Porcino Fresco)</option><option value="102">102 - CORAZON DE CERDO
 (Porcino Fresco)</option><option value="103">103 - TRAQUEA DE CERDO
 (Porcino Fresco)</option><option value="104">104 - RECORTE DE CERDO
 (Porcino Fresco)</option><option value="105">105 - BOFE DE CERDO
 (Porcino Fresco)</option><option value="106">106 - CENTRO DE CERDO
 (Porcino Fresco)</option><option value="107">107 - PATITAS DE CERDO
 (Porcino Fresco)</option><option value="108">108 - RI (Porcino Fresco)</option><option value="109">109 - MONDONGO DE CERDO
 (Porcino Fresco)</option><option value="110">110 - PANCREA DE CERDO
 (Porcino Fresco)</option><option value="111">111 - RABO DE CERDO
 (Porcino Fresco)</option><option value="112">112 - PAPADA PORCINA
 (Porcino Fresco)</option><option value="113">113 - TOCINO PORCINO
 (Porcino Fresco)</option><option value="114">114 - GRASA PORCINA
 (Porcino Fresco)</option><option value="115">115 - ESCAPULA DE CERDO
 (Porcino Fresco)</option><option value="116">116 - CERDO POR 1/2 RES
 (Porcino Fresco)</option><option value="117">117 - TAPA DE JAMON
 (Porcino Fresco)</option><option value="118">118 - PAJARILLA PORCINO
 (Porcino Fresco)</option><option value="119">119 - GA (Porcino Fresco)</option><option value="120">120 - CARRE DE CERDO
 (Porcino Fresco)</option><option value="121">121 - BONDIOLA FRESCA
 (Porcino Fresco)</option><option value="122">122 - MORCILLA
 (Porcino Fresco)</option><option value="123">123 - CHORIZO
 (Porcino Fresco)</option><option value="124">124 - SOLOMILLO
 (Porcino Fresco)</option><option value="125">125 - PECHO CON MANTA
 (Porcino Fresco)</option><option value="126">126 - CUERO PORCINO
 (Porcino Fresco)</option><option value="127">127 - BIFE  PORCINO
 (Porcino Fresco)</option><option value="128">128 - GORDURA PORCINA
 (Porcino Fresco)</option><option value="129">129 - TRIPA DE CERDO
 (Porcino Fresco)</option><option value="130">130 - UNTO PORCINO
 (Porcino Fresco)</option><option value="131">131 - MUCOSA ROJA
 (Porcino Fresco)</option><option value="132">132 - DUODENO PORCINO
 (Porcino Fresco)</option><option value="133">133 - BONETE DE CERDO
 (Porcino Fresco)</option><option value="134">134 - HIGADO PORCINO 2 (Porcino Fresco)</option><option value="135">135 - RECORTE DE C.DE CBZA.PORCINA
 (Porcino Fresco)</option><option value="136">136 - HUESO PORCINO
 (Porcino Fresco)</option><option value="137">137 - OREJA PORCINA
 (Porcino Fresco)</option><option value="138">138 - VEJIGA PORCINA
 (Porcino Fresco)</option><option value="139">139 - MORRO PORCINO
 (Porcino Fresco)</option><option value="140">140 - CARETA PORCINA
 (Porcino Fresco)</option><option value="141">141 - CABEZA PORCINA
 (Porcino Fresco)</option><option value="142">142 - LENGUA PORCINA
 (Porcino Fresco)</option><option value="144">144 - HUESO DE BONDIOLA
 (Porcino Fresco)</option><option value="145">145 - AORTA PORCINA
 (Porcino Fresco)</option><option value="146">146 - PUNTA DE PECHO
 (Porcino Fresco)</option><option value="147">147 - TRAGAPASTO PORCINO
 (Porcino Fresco)</option><option value="148">148 - MEMBRANA PORCINA
 (Porcino Fresco)</option><option value="149">149 - MANITOS PORCINAS
 (Porcino Fresco)</option><option value="150">150 - CORDERO
 (Cordero Fresco)</option><option value="151">151 - TRIPA DE CORDERO
 (Cordero Fresco)</option><option value="152">152 - CARNE DE CORDERO
 (Cordero Fresco)</option><option value="153">153 - HIGADO DE CORDERO
 (Cordero Fresco)</option><option value="154">154 - CORAZON DE CORDERO
 (Cordero Fresco)</option><option value="155">155 - BOFE DE CORDERO
 (Cordero Fresco)</option><option value="156">156 - CENTRO DE CORDERO
 (Cordero Fresco)</option><option value="157">157 - ESTOMAGO DE CORDERO
 (Cordero Fresco)</option><option value="158">158 - VINZA DE CORDERO
 (Cordero Fresco)</option><option value="159">159 - CRIADILLA DE CORDERO
 (Cordero Fresco)</option><option value="160">160 - VISCERA DE CONEJO
 (Cordero Fresco)</option><option value="200">200 - HIELO POR BARRA
 (Productos y Servicios)</option><option value="201">201 - SERVICIO POR PALETIZADO
 (Productos y Servicios)</option><option value="202">202 - BIDON DE AGUA OXIGENADA
 (Productos y Servicios)</option><option value="203">203 - CANASTOS DE ALAMBRE
 (Productos y Servicios)</option><option value="204">204 - BOLSAS ROLITO
 (Productos y Servicios)</option><option value="205">205 - FLETE
 (Productos y Servicios)</option><option value="206">206 - HIELO EN ESCAMAS
 (Productos y Servicios)</option><option value="207">207 - SERV.DE CONG.Y DESCONG.
 (Productos y Servicios)</option><option value="208">208 - SERVICIO POR CONGELADO
 (Productos y Servicios)</option><option value="209">209 - SERV.POR DESCONGELADO
 (Productos y Servicios)</option><option value="210">210 - MANT. DE FRIO(Tn x Dia)
 (Productos y Servicios)</option><option value="211">211 - MATERIAL DE EMPAQUE
 (Productos y Servicios)</option><option value="212">212 - SERVICIO
 (Productos y Servicios)</option><option value="213">213 - FLETE -CARTILGO NASAL-
 (Productos y Servicios)</option><option value="214">214 - FOTOCOPIAS
 (Productos y Servicios)</option><option value="215">215 - SERVICIO POR ENJUAGUE
 (Productos y Servicios)</option><option value="216">216 - FLETE - VINZA
 (Productos y Servicios)</option><option value="217">217 - HORAS TRABAJADAS
 (Productos y Servicios)</option><option value="218">218 - CAJAS
 (Productos y Servicios)</option><option value="219">219 - SERVICIO POR PICADO
 (Productos y Servicios)</option><option value="220">220 - SERVICIOS POR MOVIMIENTOS
 (Productos y Servicios)</option><option value="221">221 - SERVICIO DE ELABORACION
 (Productos y Servicios)</option><option value="222">222 - SERVICIO TECNICO DEREFRIGERACI
 (Productos y Servicios)</option><option value="223">223 - MANIPULEO DE MERCADERIA
 (Productos y Servicios)</option><option value="224">224 - PALLET DE MADERA
 (Productos y Servicios)</option><option value="225">225 - LENGUA PORCINA -CPS - SERVICIO
 (Productos y Servicios)</option><option value="226">226 - OREJA PORCINA - CPS - SERVICIO
 (Productos y Servicios)</option><option value="227">227 - LENGUA VACUNA - MERCEDINO - SE
 (Productos y Servicios)</option><option value="228">228 - CABEZAS CAMPO AUTRAL- SERVICIO
 (Productos y Servicios)</option><option value="229">229 - CARNE CUBETEADA - SERVICIO -
 (Productos y Servicios)</option><option value="230">230 - SERVICIO/GUARDA EN DEPOSITO
 (Productos y Servicios)</option><option value="231">231 - PATITAS - CAMPO AUSTRAL SERVIC
 (Productos y Servicios)</option><option value="232">232 - RABO -  CAMPO AUSTRAL SERVICIO
 (Productos y Servicios)</option><option value="233">233 - PANZA - CAMPO AUSTRAL SERVICIO
 (Productos y Servicios)</option><option value="234">234 - LENGUA - CAMPO AUSTRAL SERVICI
 (Productos y Servicios)</option><option value="235">235 - OREJA - CAMPO AUSTRAL SERVICIO
 (Productos y Servicios)</option><option value="236">236 - CARETA - CAMPO AUSTRAL SERVICI
 (Productos y Servicios)</option><option value="237">237 - REC.DE CARNE MAGRA - CAMPO AUS
 (Productos y Servicios)</option><option value="238">238 - RECORTE 50/50 - CAMPO AUSTRAL
 (Productos y Servicios)</option><option value="239">239 - MANO - CAMPO AUSTRAL
 (Productos y Servicios)</option><option value="240">240 - RABO VACUNO - SERVICIO
 (Productos y Servicios)</option><option value="241">241 - TENDON VACUNO - SERVICIO
 (Productos y Servicios)</option><option value="242">242 - ESTOMAGO VACUNO - SERVICIO
 (Productos y Servicios)</option><option value="243">243 - LENGUA - SERVICIO
 (Productos y Servicios)</option><option value="244">244 - HUESO P/CTA. Y ORDEN DE C..AUS
 (Productos y Servicios)</option><option value="245">245 - RI (Productos y Servicios)</option><option value="246">246 - DESPERDICIO - CABAEZAS CAMPO
 (Productos y Servicios)</option><option value="247">247 - BONETE - SERVICIO
 (Productos y Servicios)</option><option value="248">248 - LIBRILLO - SERVIVCIO
 (Productos y Servicios)</option><option value="252">252 - HIGADO DE AVE PROPIEDAD DE SPF
 (Propiedad del Cliente)</option><option value="253">253 - HIGADO PORCINO PROPIEDAD SPF
 (Propiedad del Cliente)</option><option value="254">254 - VISCERAS DE PESCADO DE SU PROP
 (Propiedad del Cliente)</option><option value="255">255 - CORAZON DE AVE
 (Propiedad del Cliente)</option><option value="256">256 - HIGADO DE AVE
 (Propiedad del Cliente)</option><option value="301">301 - HIGADO CONGELADO
 (Vacunos Congelado)</option><option value="302">302 - CORAZON CONGELADO
 (Vacunos Congelado)</option><option value="303">303 - RI (Vacunos Congelado)</option><option value="304">304 - SESO CONGELADO
 (Vacunos Congelado)</option><option value="305">305 - LENGUA CONGELADA
 (Vacunos Congelado)</option><option value="306">306 - BOFES CONGELADO
 (Vacunos Congelado)</option><option value="307">307 - RABOS CONGELADOS
 (Vacunos Congelado)</option><option value="308">308 - CENTRO DE ENTRA (Vacunos Congelado)</option><option value="309">309 - CHINCHULIN CONGELADO
 (Vacunos Congelado)</option><option value="310">310 - TRIPA CONGELADO
 (Vacunos Congelado)</option><option value="311">311 - MOLLEJA CONGELADA
 (Vacunos Congelado)</option><option value="312">312 - QUIJADA CONGELADA
 (Vacunos Congelado)</option><option value="313">313 - MONDONGO CONGELADO
 (Vacunos Congelado)</option><option value="314">314 - RUEDA CONGELADA
 (Vacunos Congelado)</option><option value="315">315 - CUAJO CONGELADO
 (Vacunos Congelado)</option><option value="316">316 - UBRE CONGELADA
 (Vacunos Congelado)</option><option value="317">317 - REC. DE CARNE DE CAB.CONGELADA
 (Vacunos Congelado)</option><option value="318">318 - PAJARILLA CONGELADA
 (Vacunos Congelado)</option><option value="319">319 - GA (Vacunos Congelado)</option><option value="320">320 - TRAGAPASTO CONGELADO
 (Vacunos Congelado)</option><option value="321">321 - MUCANGA CONGELADA
 (Vacunos Congelado)</option><option value="323">323 - NUEZ DE QUIJADA CONGELADA
 (Vacunos Congelado)</option><option value="324">324 - LABIO VACUNO  CONGELADO
 (Vacunos Congelado)</option><option value="325">325 - RI (Vacunos Congelado)</option><option value="328">328 - TRAQUEA VACUNA CONGELADA
 (Vacunos Congelado)</option><option value="329">329 - TENDON VACUNO CONGELADA
 (Vacunos Congelado)</option><option value="330">330 - TENDON COCIDO CONGELADO
 (Vacunos Congelado)</option><option value="332">332 - MEMBRANA VACUNA CONGELADA
 (Vacunos Congelado)</option><option value="333">333 - AORTA VACUNA CONGELADA
 (Vacunos Congelado)</option><option value="335">335 - HIGADO VACUNO PROP.SPF CONGELA
 (Vacunos Congelado)</option><option value="338">338 - VINZA CONGELADA
 (Vacunos Congelado)</option><option value="340">340 - MENUDENCIAS VACUNAS
 (Vacunos Congelado)</option><option value="341">341 - MONDONGO VERDE CONGELADO
 (Vacunos Congelado)</option><option value="346">346 - MONDON VACUNO 2 (Vacunos Congelado)</option><option value="350">350 - MONDONGO NATURAL CONGELADO
 (Vacunos Congelado)</option><option value="354">354 - CARTILAGO NASAL CONGELADO
 (Vacunos Congelado)</option><option value="362">362 - ESCAPULA VACUNACONGELADA
 (Vacunos Congelado)</option><option value="365">365 - TENDON CERVICAL CONGELADO
 (Vacunos Congelado)</option><option value="366">366 - RECORTE DE CORAZON VACUNO
 (Vacunos Congelado)</option><option value="367">367 - FARINGE VACUNO CONGELADO
 (Vacunos Congelado)</option><option value="400">400 - PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="401">401 - HIGADO PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="402">402 - CORAZON PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="403">403 - RI (Vacuno Precocido Congelado)</option><option value="404">404 - SESO PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="405">405 - LENGUAPRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="406">406 - BOFE PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="407">407 - RABO PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="408">408 - CENTROPRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="409">409 - CHINCHULIN PRECOC.CONG.
 (Vacuno Precocido Congelado)</option><option value="410">410 - TRIPA GORDA PRECOC.CONG.
 (Vacuno Precocido Congelado)</option><option value="411">411 - MOLLEJA PRECOC. CONG.
 (Vacuno Precocido Congelado)</option><option value="412">412 - QUIJADA PRECOC.CONG.
 (Vacuno Precocido Congelado)</option><option value="413">413 - MONDONGO PRECOC.CONG.
 (Vacuno Precocido Congelado)</option><option value="414">414 - RUEDA PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="415">415 - CUAJO PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="416">416 - UBRE PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="417">417 - REC.DECARNEDECAB.PRECOC.CONG.
 (Vacuno Precocido Congelado)</option><option value="418">418 - PAJARILLA PRECOC.CONG.
 (Vacuno Precocido Congelado)</option><option value="419">419 - GA (Vacuno Precocido Congelado)</option><option value="420">420 - TRAGAPASTO PRECOC.CONG.
 (Vacuno Precocido Congelado)</option><option value="421">421 - MUCANGA PRECOCIDA CONG.
 (Vacuno Precocido Congelado)</option><option value="424">424 - LABIO PRECOCIDO CONGELADO
 (Vacuno Precocido Congelado)</option><option value="425">425 - RI (Vacuno Precocido Congelado)</option><option value="429">429 - TENDON PRECOCIDO CONGELADO
 (Vacuno Precocido Congelado)</option><option value="430">430 - TENDON PRECOC.CONGEL
 (Vacuno Precocido Congelado)</option><option value="444">444 - LIBRILLO PRECOC.CONGELADO
 (Vacuno Precocido Congelado)</option><option value="445">445 - LIBRILLO NATURAL SEMICOCIDO CO
 (Vacuno Precocido Congelado)</option><option value="448">448 - BONETENATURAL SEMICOCIDOCONGEL
 (Vacuno Precocido Congelado)</option><option value="501">501 - HIGADO PORCINO CONGELADO
 (Porcino Congelado)</option><option value="502">502 - CORAZON PORCINO CONGELADO
 (Porcino Congelado)</option><option value="503">503 - RI (Porcino Congelado)</option><option value="504">504 - TIROIDE PORCINACONGELADA
 (Porcino Congelado)</option><option value="506">506 - PULMON PORCINO CONGELADO
 (Porcino Congelado)</option><option value="508">508 - CENTRO PORCINO CONGELADO
 (Porcino Congelado)</option><option value="509">509 - ESTOMAGO PORCINO CONGELADO
 (Porcino Congelado)</option><option value="510">510 - PANCREA DE CERDO CONGELADO
 (Porcino Congelado)</option><option value="517">517 - TAPA DEJAMON CONGELADA
 (Porcino Congelado)</option><option value="518">518 - BAZO PORCINO CONGELADO
 (Porcino Congelado)</option><option value="521">521 - FARINGE PORCINA CONGELADA
 (Porcino Congelado)</option><option value="535">535 - REC.DE CARNE DE CAB.PORC.CONG.
 (Porcino Congelado)</option><option value="607">607 - PORK FEET-PATITAS PORCINAS
 (Porcino ExportaciÃ³n)</option><option value="609">609 - MONDONGO PRE-COCIDO(ALY) CONG
 (Porcino ExportaciÃ³n)</option><option value="632">632 - DUODENO PRECOCIDO PORCINO
 (Porcino ExportaciÃ³n)</option><option value="702">702 - CORAZON MADURADO CONGELADO
 (Vacuno Madurado)</option><option value="705">705 - LENGUA MADURADA CONGELADA
 (Vacuno Madurado)</option><option value="707">707 - RABO MADURADO CONGELADO
 (Vacuno Madurado)</option><option value="708">708 - CENTRO DE ENTRA (Vacuno Madurado)</option><option value="717">717 - REC.DECAR.DE CAB.MRDA CONGA
 (Vacuno Madurado)</option><option value="723">723 - NUEZ DE QUIJADA MADURADA CONGE
 (Vacuno Madurado)</option><option value="724">724 - LABIO VACUNO MADURADO CONGELAD
 (Vacuno Madurado)</option><option value="801">801 - BEEF LIVER-HIGADO VACUNO
 (Vacunos ExportaciÃ³n)</option><option value="802">802 - BEEF HEART-CORAZON VACUNO
 (Vacunos ExportaciÃ³n)</option><option value="803">803 - BEEF KIDNEY-RI (Vacunos ExportaciÃ³n)</option><option value="805">805 - LENGUA-BEEFTONGUES SWISS CUT
 (Vacunos ExportaciÃ³n)</option><option value="806">806 - POUMON-LUNGS(PULMON VACUNO
 (Vacunos ExportaciÃ³n)</option><option value="807">807 - OX TAIL-RABO VACUNO
 (Vacunos ExportaciÃ³n)</option><option value="808">808 - CENTRO DE ENTRA (Vacunos ExportaciÃ³n)</option><option value="809">809 - ESTOMAGO PORCINO COCIDO (DDM)
 (Vacunos ExportaciÃ³n)</option><option value="812">812 - QUIJADA VACUNA CONGELADA
 (Vacunos ExportaciÃ³n)</option><option value="817">817 - REC.DECARNE DECAB.(BONELESS BE
 (Vacunos ExportaciÃ³n)</option><option value="818">818 - BAZO VACUNO
 (Vacunos ExportaciÃ³n)</option><option value="819">819 - GLOTIS VACUNA CONGELADA
 (Vacunos ExportaciÃ³n)</option><option value="823">823 - NUEZ DE QIJADA VACUNA
 (Vacunos ExportaciÃ³n)</option><option value="824">824 - LIPS-BABINE (LABIO VACUNO)
 (Vacunos ExportaciÃ³n)</option><option value="829">829 - TENDON-BEEFTENDON-VACUNO CONGE
 (Vacunos ExportaciÃ³n)</option><option value="832">832 - MEMBRANA VACUNA CONGELADA
 (Vacunos ExportaciÃ³n)</option><option value="833">833 - FROZEEN BEEF AORTA (AORTA CONG
 (Vacunos ExportaciÃ³n)</option><option value="838">838 - FROZEEN BEEF PENNIS (VINZA CON
 (Vacunos ExportaciÃ³n)</option><option value="841">841 - FROZEN RAW BEEF TRIPE
 (Vacunos ExportaciÃ³n)</option><option value="844">844 - LIBRILLO SEMICOCIDO CONGELADO
 (Vacunos ExportaciÃ³n)</option><option value="846">846 - BONETE SEMICOCIDO BLANCO
 (Vacunos ExportaciÃ³n)</option><option value="848">848 - BONETEDEMONDONGO SEM.NAT.CONG.
 (Vacunos ExportaciÃ³n)</option><option value="850">850 - FROZEN BEEF TRIPES/COOKED UNBL
 (Vacunos ExportaciÃ³n)</option><option value="901">901 - HIGADO PORCINO(PORK LIVER)
 (Porcino ExportaciÃ³n)</option><option value="902">902 - CORAZON PORCINO(PORK HEART)
 (Porcino ExportaciÃ³n)</option><option value="904">904 - RECORTE DE CARNE PORCINA
 (Porcino ExportaciÃ³n)</option><option value="907">907 - PATITAS PORCINAS (PORK FEET)
 (Porcino ExportaciÃ³n)</option><option value="908">908 - CENTRO PORCINO
 (Porcino ExportaciÃ³n)</option><option value="909">909 - ESTOMAGO PORCINO CONGELADO
 (Porcino ExportaciÃ³n)</option><option value="910">910 - MANITOS PORCINAS
 (Porcino ExportaciÃ³n)</option><option value="911">911 - RABO PORCINO(PORK OX-TAIL)
 (Porcino ExportaciÃ³n)</option><option value="919">919 - GA (Porcino ExportaciÃ³n)</option><option value="920">920 - TRAGAPASTO PORCINO
 (Porcino ExportaciÃ³n)</option><option value="932">932 - DUODENO SEMICOCIDO PORCINO CON
 (Porcino ExportaciÃ³n)</option><option value="933">933 - AORTA PORCINA
 (Porcino ExportaciÃ³n)</option><option value="936">936 - HUESO DE BONDIOLA DE CERDO CON
 (Porcino ExportaciÃ³n)</option><option value="937">937 - OREJA PORCINA(PORK EAR )
 (Porcino ExportaciÃ³n)</option><option value="939">939 - MORRO
 (Porcino ExportaciÃ³n)</option><option value="940">940 - CARETA PORCINA
 (Porcino ExportaciÃ³n)</option><option value="941">941 - CABEZA PORCINA CONGELADA
 (Porcino ExportaciÃ³n)</option><option value="942">942 - LENGUA PORCINA(PORK TONGUES)
 (Porcino ExportaciÃ³n)</option><option value="943">943 - OREJA INTERNA PORCINA
 (Porcino ExportaciÃ³n)</option><option value="946">946 - PUNTA DE PECHO PORCINO CONGELA
 (Porcino ExportaciÃ³n)</option><option value="947">947 - HUESO TRASERODE RABO PORCINO
 (Porcino ExportaciÃ³n)</option><option value="948">948 - MEMBRANA PORCINA CONGELADA
 (Porcino ExportaciÃ³n)</option><option value="949">949 - VEJIGA COCIDA PORCINA CONGELAD
 (Porcino ExportaciÃ³n)</option></select>
    </body>
</html>


<?php

?>

<H1>IRD Slider</H1>
<p>IRD Slider es un plugin muy sencillo de utilizar y no requiere de configuración.</p>
<p>Solamente has de tener en cuenta que puedes tener varios slider, todos con la misma configuración de aspecto o una diferente por cada uno de ellos. 
    Para ayudarte con la configuración, aquí debajo, tienes el asistente que te generará el shortcode listo para pegar</p>

<h2>SHORTCODE</h2>
<p>Selecciona los parámetros de configuración</p>
<form id="irdshortcode">
<table>
    <tr>
        <td>ID</td>
        <td><input type="text" value="prueba" id="id" name="id"></td>
        <td>Tiene que ser un identificador único en la página, te recomendamos que pongas uno diferente para cada aparición de slider</td>
    </tr>
    <tr>
        <td>Tipo</td>
        <td><input type="text" value="algo" id="tipo" name="tipo"></td>
        <td>Grupo de slides a mostrar, el mismo que el indicado en el campo Tipo</td>
    </tr>
    <tr>
        <td>Estilo</td>
        <td><input type="text" value="webmovil" id="estilo" name="estilo"></td>
        <td>Estilo del slider, valores disponibles: base, webmovil</td>
    </tr>
    <tr>
        <td>Velocidad</td>
        <td><input type="text" value="5000" id="speed" name="speed"></td>
        <td>Tiempo que tarda en mostrarse el siguiente slide de forma automática, 0 para no realizar transición.</td>
    </tr>
    <tr>
        <td>Destino</td>
        <td><input type="text" value="_blank" id="target" name="target"></td>
        <td>Para aquellos slides que tengan url indicada, destino o target en el que se abrirá.</td>
    </tr>
    <tr>
        <td></td>
        <td><input type="button" value="Generar"onclick="creaShortcode ()"></td>
        <td>&nbsp;</td>
    </tr>
</table>
</form>
<br>
<p>Pulsa sobre el botón Generar y copia el código que se mostrará aqui debajo</p>
<div id="divirdshortcode"></div>
<script>
    function creaShortcode () {
        var s = '[irdslider';
        s += ' id=\'' + document.getElementById ('id').value + '\''; 
        s += ' tipo=\'' + document.getElementById ('tipo').value + '\''; 
        s += ' estilo=\'' + document.getElementById ('estilo').value + '\''; 
        s += ' speed=\'' + document.getElementById ('speed').value + '\''; 
        s += ' target=\'' + document.getElementById ('target').value + '\''; 
       
        s += ']';
        document.getElementById ('divirdshortcode').innerHTML = s;
    }
    </script>





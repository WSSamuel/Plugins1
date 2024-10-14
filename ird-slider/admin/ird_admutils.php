<?php




function irdslider_pintaCampos ($campos) {
    $antCat = '';
    echo '<form method="post"><table>';
    foreach ($campos as &$campo) {
        if ($campo[0] != $antCat) {
            echo '<tr><td colspan="2"><h2>' . esc_html ($campo[0]) . '</h2></td></tr>';
            $antCat = $campo[0];
        }
        echo '<tr><td>' . esc_html ($campo[1]) . '</td><td><input type="text" name="' . esc_attr ($campo[2]) . '" value="'. esc_attr ($campo[3]) . '"></td></tr>';
    }
    echo '<tr><td colspan="2">&nbsp;</td></tr><tr><td>&nbsp;</td><td><input type="submit" value="Guardar"></td></tr></table></form>';
}

function irdslider_procesaOpciones ($campos) {
    
    foreach ($campos as $key => $campo) {
        $aux = irdslider_getAtt ($campo[2], '');
        if ($aux != '') {
            irdslider_addOption(  $campo[2], $aux);
            $campos[$key][3] = $aux;
        }
        else {
            $campos[$key][3] = irdslider_getOption(  $campo[2], $aux);
            
        }
        
        
    }
    return $campos;
}


?>
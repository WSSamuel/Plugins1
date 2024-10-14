<?php 
function gtz_display_special_mention() {
	
    // Vérifie si l'extension GD est chargée

    if (!extension_loaded('gd') || !function_exists('gd_info')) {
      
        return '<p>' . esc_html__('#Amazon #Rémunéré') . '</p>'; 
    }

    $largeur = 16;
    $hauteur = 150;
    $image = imagecreatetruecolor($largeur, $hauteur);
    
    $blanc = imagecolorallocate($image, 255, 255, 255);
    $noir = imagecolorallocate($image, 0, 0, 0);

    imagefill($image, 0, 0, $blanc);

    $font = GOTHAMZ_ROOTPATH . 'fonts/DejaVuSans-ExtraLight.ttf';

    // Ajout d'une vérification de fichier pour s'assurer que la police existe
    if (!file_exists($font)) {
        return '<p>' . esc_html__('#Amazon #Rémunéré') . '</p>'; 
    }

    $texte = "#Amazon #Rémunéré";
    $taille_font = 9;
    $angle = 90;
    $x = 12;
    $y = 146;
    
    ob_start();

    imagettftext($image, $taille_font, $angle, $x, $y, $noir, $font, $texte);

    imagepng($image);
    imagedestroy($image);

    $image_data = ob_get_clean();
    $base64_image = base64_encode($image_data);

    $safe_image_src = esc_attr('data:image/png;base64,' . $base64_image);

	if (isset($_GET['amp'])) {
		
		return '<amp-img src="' . $safe_image_src . '" class="newrules24" width="16" height="150" alt="Mentions legales"></amp-img>';
	
	} else {
		
		return '<img src="' . $safe_image_src . '" class="newrules24">';
			
	}
}
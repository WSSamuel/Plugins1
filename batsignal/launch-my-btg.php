<?php
/**
 * @package Batsignal
 * @version 2.1.7
 */
/*
Plugin Name: Batsignal
Description: Batsignal : Plugin Ultra-Light pour lancer une Popup via le simple shortcode : [batsignal id='1' image_url='https://site.com/pics1.jpg' image_alt='My Pics' target_url='https://site.com/moneypage' target_b='' largeur='600' hauteur='400' trigger_unit='px' trigger='600' expires='3600']
Version: 2.1.7
Author: Kapsule Network
Author URI: https://www.kapsulecorp.com/
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) )
	exit;

if ( is_admin() ){
	
add_action( 'admin_init', 'l0nch_my_batsignal_batsignal' );
function l0nch_my_batsignal_batsignal() {
	register_setting( 'l0nch_my_batsignal-settings-group', 'l0nch_my_batsignal_option_expirecookie', 'sanitize_text_field' );
    register_setting( 'l0nch_my_batsignal-settings-group', 'l0nch_my_batsignal_option_declencheur', 'sanitize_text_field' );
	register_setting( 'l0nch_my_batsignal-settings-group', 'l0nch_my_batsignal_option_declencheur_unit', 'sanitize_text_field' );
	register_setting( 'l0nch_my_batsignal-settings-group', 'l0nch_my_batsignal_option_powered', 'sanitize_text_field' );
}


add_action('admin_menu','l0nch_my_batsignal_setupmenu');
function l0nch_my_batsignal_setupmenu(){
      add_menu_page('Configuration du Batsignal', 'Launch My Batsignal', 'administrator', 'l0nch_my_batsignal-plugin', 'l0nch_my_batsignal_init_cave', ' data:image/svg+xml;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAAsQAAALEBxi1JjQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAOGSURBVEiJ7ZRbaFxFGIC/f2Z292x2k2wabYvUJikqSG1SS6XJS+utIqRYBFNpfJFWpQYv4ENF8MGXvoiiokLRWDFFozEgtBipKDUqoalQbYqC90BFE4Mx2U32ci4zPpwkmpJEfepLv5cznBm+f+af/x+4xMVG/utC19ehS+uzd5byM086F60VUSCcT6WrX8p4ibdk6yvB3FIF2P8VYPbUfbsF9wLQUJqeIgpjlyhFJlcPwqhzrivTduSDjo77d6DNe0qZQafcG/rf5MXh/QcFXgXqAEwyGW9TG7xslsAqlJD7cUzvXdPQuv33glqDsF3hdOFP9diKJ5gd3t8uluNhUBFtEohSi+Yn8sKhPs3ubY4TZwxj0wrnLCJ60IbB8f6+w8+apcTtnQ/WbciaVeKK3X55VvxiEW0M6do6bBQRlEukMll6TiaZnHG8/rEgCpQIWzbYmcebJ26RPe9GAAags/ORqy20WnHbBNr8oLL58lrbA6xVKs6i6LmvCEob8kVhZ0uIUZZ1tRU2XVFk3M9RndbZYkPN7cD7AObuex6+LcI+D3KtANaGKKeoyYRbAHTSI1OXXEiPKEXC80jgaG6MaG6EoGxBPK5JQRBFiJNb5wOod9588cOk8m4AzoIjDEOUVoxOqEaA098bvv1tyUwukPA8EikvHmsA1zQ/pwFGRoaCjS2tk2Hgd5hELJsukooiw/B38NFIkkJZ8cOvmqbVAVGpgEkmGR1X5LIOZx0ii+rl7KHuL/shbooYvzIGoEQjKLAwcMbw07hhphgy8IXjl0lIJQVlEhw7rXiqF/6YiigXphc0kV/BL5YXoi0EcG7ylHYuZ51sFZEe5yLmbhVjEhhtmCwo+odSPNGbpX/IEFrN20MZ0rV1scM6SoU8luCree+yfbBn74GXRSW6LvwfBD4iCoG4NJXh0V0VNjfFGyoX8vk6M1EvN30SLk7RBfT1Hn6oKuXO/31Ci18po7XCGIO1EUri+zo6mKQcvx5BuqZ217wc5vpgGdysr/qrUnbfXW1BTX02Ei8pnPs54MSIJgDW1/tct65EpKv49Gtjd7aEXVWt3Z/9U7Ji/Ql8Uymlrrp5U3EHyHPgrmzMFdi4eoqBc1U8cOMUAnjVbgyV7si0vfb5Eo7luWPfwepjR54uALiT93qltGr3y+UDUaVyvQOrRCacNn2rLks8Iy1HZ1dyXeLi8RdtIliAp88+KAAAAABJRU5ErkJggg==' );
}

function l0nch_my_batsignal_monjsdansladmin() {
echo "<style>
.batsignal_gotham_ad_wrap #logo_admin {text-align:center;background:black;color:#ac5b5b;padding:80px;border-radius:8px;}
.batsignal_gotham_ad_wrap{margin: 10px 20px 0 2px;}
.batsignal_gotham_ad_form{float: left;width: 79%;}
.batsignal_gotham_ad_credit{float: left;width:17%;background:#fff;box-shadow: 0 0 0 1px rgba(0,0,0,0.05);padding:1%;margin-left:1%;}
.batsignal_gotham_ad_wrap #batsignal_batbaseadmin tr td.libelle{font-weight:bold;width:250px;}
.batsignal_gotham_ad_wrap #batsignal_batbaseadmin input, #batbaseadmin select, #batbaseadmin textarea {width:280px;float:left;}
.batsignal_gotham_ad_wrap .explain {background:white;box-shadow: 0 0 0 1px rgba(0,0,0,0.05);}
.batsignal_gotham_ad_wrap .explain p{padding:10px;}
.batsignal_gotham_ad_wrap .explain ul{padding: 0 10px;list-style: square inside;}
.batsignal_gotham_ad_wrap .explain li{padding:0;}
.batsignal_gotham_ad_wrap .explain h3 {padding:6px 10px;border-bottom:1px solid #eee;}
.batsignal_gotham_ad_wrap .explain h4 {background:#951515;color:white;padding:5px;}
.batsignal_gotham_ad_wrap .explain h4 a{color:white;}
.batsignal_gotham_ad_wrap .explain h4 a:hover{text-decoration:none;}
.batsignal_gotham_ad_wrap .explain p.shortcode {text-align: center;background: #181818;color: #56ff56;font-size: 20px;}
.batsignal_gotham_ad_wrap .explain p.shortcode span {color:white;font-style:italic;font-weight:bold;}
</style>";
}
add_action('admin_enqueue_scripts', 'l0nch_my_batsignal_monjsdansladmin');

// Création de la page d'options du plugin ////////////////
function l0nch_my_batsignal_init_cave(){

	///FRANCAIS
	if ( 'fr_' === substr( get_user_locale(), 0, 3 ) ) {
		$txt_adwin_welcome = "1. Paramétrez votre BatSignal (Par Défaut)";
		$txt_adwin_yes = "Oui";
		$txt_adwin_no = "Non";
		$txt_adwin_helpkapsule = "3. Je soutiens l'éditeur de ce plugin car je suis quelqu'un de bien";
		$txt_adwin_helpkapsule_p = "👍 En sélectionnant OUI, un lien hypertexte discret vers notre site web sera inséré en bas de page.<br />💡 Si ça ne vous arrange pas, vous pouvez bien sûr également faire un lien vers notre site https://www.kapsulecorp.com depuis votre page partenaire par exemple.";
		$txt_adwin_helpkapsule_label = "J'accepte le deal";
		$txt_adwin_blokright_title = "Besoin d’aide ?";
		$txt_adwin_blokright_corpus_1 = "Si vous rencontrez un problème avec cette extension, vous trouverez probablement des réponses dans ces deux pages :";
		$txt_adwin_blokright_corpus_2 = "Documentation";
		$txt_adwin_blokright_corpus_3 = "Forum de Support";
		$txt_adwin_blokright_aime = "Vous aimez cette extension ?";
		$txt_adwin_blokright_vote = "Notez nous 5/5";
		$txt_adwin_blokright_sur = "sur";
		
		$batsignal_1 = "<p>⬇️ Paramétrage du cookie permettant d'empêcher un affichage intempestif de la popup lors de chaque chargement de page du site ⬇️</p><ul><li><strong>Si vous souhaitez afficher la popup systèmatiquement :</strong> laissez vide le champ suivant,</li><li><strong>Sinon :</strong> définissez le nombre de secondes avant que cette dernière puisse à nouveau être affiché.</li></ul>";
		$batsignal_declenchement = "Déclenchement après :";
		$batsignal_cookie_time_l = "<u>Secondes</u> avant prochain affichage :";
		$batsignal_inserez = "Insérez votre shortcode à l'endroit où vous souhaitez afficher la popup";
		$l_day="jours";
		$l_batsignal_explain = "<h4>☑️ Champs obligatoires</h4><ul><li>id = ID de la Popup</li><li>image_url = Url de l'image</li><li>image_alt = Titre de l'image (utilisée pour définir ALT et TITLE)</li><li>target_url = URL appelée au clic sur l'image. (<strong>Laissez vide si nécessaire, la popup se fermera alors au clic sur l'image.</strong>)</li><li>target_b = Ouverture dans un nouvel onglet. (<strong>Laissez vide si le lien doit s'ouvir dans la meme page</strong>)</li><li>largeur = Largeur de l'image en px</li><li>hauteur = Hauteur de la l'image en px</li></ul><h4>✳️ Champs optionnels (Ecraseront les paramètres généraux fixés ci-dessus ( <a href='#batsignal_batbaseadmin'>#1</a> )</h4><ul><li>trigger_unit = 'px' (déclenchement au déroulement) / 'sec' (déclenchement après x secondes)</li><li>trigger = valeur du déclencheur (x pixels / x secondes)</li><li>expires = Délai avant que la popup soit à nouveau affichée (en secondes)</li></ul>";
		
		$l_conseil_bottom = "<span style='background:yellow;color:black;'>Essayez d'insérer le shortcode le plus bas possible dans votre code source pour un maximum de compatibilité.</span> <br /><br /> 	<strong>&lt;?php echo do_shortcode(	&quot;[batsignal]&quot;); ?></strong>";
	}
	///ANGLAIS
	else {
		$txt_adwin_welcome = "1. Configure The BatSignal (Default)";
		$txt_adwin_yes = "Yes";
		$txt_adwin_no = "No";
		$txt_adwin_helpkapsule = "3. I support the editor of this plugin for my karma";
		$txt_adwin_helpkapsule_p = "👍 By selecting YES, a discreet hypertext link to our website will be inserted at the bottom of your page. <br /> 💡 If you prefer, you can also make a backlink to our site https://www.kapsulecorp.com from your partner page for example.";
		$txt_adwin_helpkapsule_label = "I accept the deal";
		$txt_adwin_blokright_title = "Need help ?";
		$txt_adwin_blokright_corpus_1 = "If you have a problem with this plugin, you will probably find answers on these two pages:";
		$txt_adwin_blokright_corpus_2 = "Documentation";
		$txt_adwin_blokright_corpus_3 = "Support (Board)";
		$txt_adwin_blokright_aime = "Do you like this extension ?";
		$txt_adwin_blokright_vote = "Rate us 5/5";
		$txt_adwin_blokright_sur = "on";
		
		$batsignal_1 = "<p>⬇️ Cookie settings to prevent unwanted display of the popup each time a site page is loaded.</p><ul><li><strong> If you want to display the popup systematically: </strong> leave the following field empty,</li><li>Otherwise: </strong> set the number of seconds before this can be displayed again.</li></ul>";
		$batsignal_declenchement = "Triggering after :";
		$batsignal_cookie_time_l = "<u> Seconds </u> before next display:";
		$batsignal_inserez = "Insert your shortcode wherever you want to display popup";
		$l_day="days";
		$l_batsignal_explain = "<h4>☑️ Required fields</h4><ul><li>id = Popup ID</li><li>image_url = Url of pictures</li><li>image_alt = Title of your picture (used to define ALT and TITLE)</li><li>target_url = Target URL. <strong>Leave empty if necessary, the popup will then close when you click on the image.</strong>)</li><li>target_b = Open in new tab (<strong>Leave blank if the link should open in the same page</strong>)</li><li>largeur = Image width in pixels</li><li>hauteur = Image height in pixels</li></ul><h4>✳️ Optional fields - Will override the generals rules set above ( <a href='#batsignal_batbaseadmin'>#1</a> )</h4><ul><li>trigger_unit = 'px' (on scroll) / 'sec' (after x seconds)</li><li>trigger = Trigger value (x pixels / x seconds)</li><li>expires = Delay before popup is fire again (in seconds)</li></ul>";
		
		$l_conseil_bottom = "<span style='background:yellow;color:black;'>Try to insert the shortcode as low as possible in your source code for maximum compatibility.</span> <br /><br /> 	<strong>&lt;?php echo do_shortcode(	&quot;[batsignal]&quot;); ?></strong>";
	}
	////////////////////////////////////////
		
	?>
<div class="batsignal_gotham_ad_wrap">
  <h1 id="logo_admin">🚨 - BATSIGNAL - 🚨</h1>

  <div class="batsignal_gotham_ad_form">
  <form method="post" action="options.php">
  <?php settings_fields( 'l0nch_my_batsignal-settings-group' ); ?>
  <?php do_settings_sections('l0nch_my_batsignal-settings-group'); ?>


	  <table id="batsignal_batbaseadmin">
		<tr class="explain">
			<td colspan="2">
			<h3>⚙️ <?php echo $txt_adwin_welcome; ?></h3>
			</td>
		</tr>

		
		<tr>
			<td class="libelle">🔥 <label for="gothamazon_ama_login"><?php echo $batsignal_declenchement; ?></label></td>
			<td>
				
				<input type="text" id="l0nch_my_batsignal_option_declencheur" name="l0nch_my_batsignal_option_declencheur" value="<?php echo get_option('l0nch_my_batsignal_option_declencheur'); ?>" />
				
				<?php $l0nch_my_batsignal_option_declencheur_unit = get_option('l0nch_my_batsignal_option_declencheur_unit'); ?>
				<select id="l0nch_my_batsignal_option_declencheur_unit" name="l0nch_my_batsignal_option_declencheur_unit" value="<?php echo get_option('l0nch_my_batsignal_option_declencheur_unit'); ?>">
					<option value="px" <?php selected( $l0nch_my_batsignal_option_declencheur_unit, 'px' ); ?>>pixels scroll</option>
					<option value="sec" <?php selected( $l0nch_my_batsignal_option_declencheur_unit, 'sec' ); ?>>secondes</option>
				</select>
			</td>
		</tr>
		
		<tr class="explain">
			<td colspan="2">
		    <?php echo $batsignal_1; ?>
			</td>
		</tr>
		
		<tr>
			  <td class="libelle">🍪 <label for="gothamazon_ama_login"><?php echo $batsignal_cookie_time_l; ?></label></td>
			  <td>
				<input type="text" id="l0nch_my_batsignal_option_expirecookie" name="l0nch_my_batsignal_option_expirecookie" value="<?php echo get_option('l0nch_my_batsignal_option_expirecookie'); ?>" />
			  </td>
		</tr>
		  
		<tr class="explain">
			<td colspan="2">
		    <h3>🚀 2. <?php echo $batsignal_inserez; ?></h3>
				<p class="shortcode">[batsignal id='<span>1</span>' image_url='<span><?php echo get_site_url(); ?>/pics1.jpg</span>' image_alt='<span>Image</span>' target_url='<span><?php echo get_site_url(); ?>/moneypage/</span>' target_b='<span>blank</span>' largeur='<span>600</span>' hauteur='<span>400</span>']</p>
						<?php echo $l_batsignal_explain; ?>
			</td>
		</tr>
	  
		  
		<tr class="explain">
			<td colspan="2">
		  <h3>🧿 <?php echo $txt_adwin_helpkapsule; ?></h3>
		  <p><?php echo $txt_adwin_helpkapsule_p; ?></p>
			</td>
			</tr>
		  <tr>
			  <td class="libelle"><label for="gothamazon_option_powered"><?php echo $txt_adwin_helpkapsule_label; ?> :</label></td>
			  <td>
				<?php $l0nch_my_batsignal_option_powered = get_option('l0nch_my_batsignal_option_powered'); ?>
				<select id="l0nch_my_batsignal_option_powered" name="l0nch_my_batsignal_option_powered" value="<?php echo get_option('l0nch_my_batsignal_option_powered'); ?>">
					<option value="non" <?php selected( $l0nch_my_batsignal_option_powered, 'non' ); ?>><?php echo $txt_adwin_no; ?></option>
					<option value="oui" <?php selected( $l0nch_my_batsignal_option_powered, 'oui' ); ?>><?php echo $txt_adwin_yes; ?></option>
				</select>
			  </td>
		  </tr>
	  </table>

  <?php submit_button(); ?>
  </form>
  </div>
   <div class="batsignal_gotham_ad_credit">
					<h3>🦇 Launch My Batsignal</h3>
					<div class="inside">
						<h4 class="inner">💡 Mémo Cookie Time</h4>
						<p class="inner">1H = 3600<br />24H = 86400<br />7 <?php echo $l_day; ?> = 604800<br />30 <?php echo $l_day; ?> = 2592000</p>
						<h4>⚠️ Tips</h4>
						<p class="inner"><?php echo $l_conseil_bottom; ?></p>
						<h4 class="inner">🆘 <?php echo $txt_adwin_blokright_title; ?></h4>
						<p class="inner"><?php echo $txt_adwin_blokright_corpus_1; ?></p>
						<ul>
							<li><a href="https://wordpress.org/plugins/batsignal/"><?php echo $txt_adwin_blokright_corpus_2; ?></a></li>
							<li><a href="https://wordpress.org/support/plugin/batsignal/"><?php echo $txt_adwin_blokright_corpus_3; ?></a></li>
						</ul>
						<hr>
						<h4 class="inner">🏆 <?php echo $txt_adwin_blokright_aime; ?></h4>
						<p class="inner">⭐ <a href="https://wordpress.org/support/plugin/batsignal/reviews/?filter=5#new-post" target="_blank"><?php echo $txt_adwin_blokright_vote; ?></a> <?php echo $txt_adwin_blokright_sur; ?> WordPress.org</p>
						<hr>
						<p class="inner">© Copyright <a href="https://www.kapsulecorp.com/">Kapsule</a></p>
					</div>
	</div>
</div>
<?php
}
}


	function a_toi_batman( $atts, $content = null, $tag = '') {
		
		// wp_enqueue_style( 'launch_my_batsignal', plugin_dir_url( __FILE__ ) . 'batsignal.css');
		
		
		$a= shortcode_atts( array(
		'id' => '', 			// ID de la Popup
		'image_url' => '', 		// Url de l'image
		'image_alt' => '', 		// ALT de l'image
		'largeur' => '', 		// Largeur en Px
		'hauteur' => '', 		// Hauteur en Px
		'target_url' => '', 	// Target URL
		'target_b' => '', 		// Target blank
		'trigger' => '', 		// Overide General Trigger
		'trigger_unit' => '', 	// Overide General Trigger Unit
		'expires' => '',		// Overide Expires
		), $atts );

		// Paramètres Popup
		$id_pop = esc_attr( $a['id'] );
		$image_url = esc_attr( $a['image_url'] );
		$image_alt = esc_attr( $a['image_alt'] );
		$largeur = esc_attr( $a['largeur'] );
		$hauteur = esc_attr( $a['hauteur'] );
		$target_url = esc_attr( $a['target_url'] );
		$target_b = esc_attr( $a['target_b'] );
		$trigger = esc_attr( $a['trigger'] );
		$trigger_unit = esc_attr( $a['trigger_unit'] );
		$expires_s = esc_attr( $a['expires'] );
		
		$batsignal_launcher = get_option('l0nch_my_batsignal_option_declencheur');
		$batsignal_launcher = preg_replace('`[^0-9]`', '', $batsignal_launcher); 
		if (empty($batsignal_launcher )) {$batsignal_launcher = 300;} // Si les règles générales de déclenchement de la popup sont laissées vide, on les fixe à 300 (pixels étant l'unité par défaut)
		
		$l0nch_my_batsignal_option_expirecookie = get_option('l0nch_my_batsignal_option_expirecookie');
		$l0nch_my_batsignal_option_expirecookie = preg_replace('`[^0-9]`', '', $l0nch_my_batsignal_option_expirecookie); 
		if (empty($l0nch_my_batsignal_option_expirecookie)) {$l0nch_my_batsignal_option_expirecookie = 1;} // Si les règles générales de répétition de la popup sont laissées vide, on les fixe à 1 milliseconde

		if (empty($id_pop)) {
			$id_pop=1;
		} else{
			$id_pop = mb_strtolower($id_pop,'UTF-8'); 
			$id_pop = preg_replace('/[^A-Za-z0-9 \?!]/','',$id_pop);
		}
		
		if (empty($image_url)) {$image_url="https://ps.w.org/batsignal/assets/icon-256x256.png";}
		if (empty($image_alt)) {$image_alt="Help Batman ! It's Gordon :)";}
		if (empty($target_url) OR ($target_url == "#"))  {$target_url="#"; $emptytarget = "class='emptytarget'";} else {$emptytarget = "";}
		if (empty($largeur)) {
				$i_l_i = @getimagesize($image_url);
				$image_largeur_info = isset($i_l_i) ? $i_l_i : false;
				if ( $image_largeur_info == false ) {
					$largeur = "256";
				}
				else {
					$largeur = $image_largeur_info[0];
				}
		}
		if (empty($hauteur)) {
			$i_h_i = @getimagesize($image_url);
			$image_hauteur_info = isset($i_h_i) ? $i_h_i : false;
				if ( $image_hauteur_info == false ) {
					$hauteur = "256";
				}
				else {
					$hauteur = $image_hauteur_info[1];
				}
		}
		
		if ((!empty($target_b)) AND ($target_b != "self")) {$mytarget = "target='_blank' rel='nofollow noopener noreferrer'";} else {$mytarget= "";}
		if (empty($trigger)) {$trigger = $batsignal_launcher;}
		if (empty($trigger_unit)) {$trigger_unit = get_option('l0nch_my_batsignal_option_declencheur_unit');}	
		if (empty($expires_s)) {$expires_s = $l0nch_my_batsignal_option_expirecookie;}	
		
		launchmybatsignal($id_pop, $largeur, $trigger, $trigger_unit, $expires_s);
		
		if (isset($_GET['amp'])) {$amp = true;$imgtag = 'amp-img layout="responsive"'; $imgtag_close = "</amp-img>";} else {$amp = false;$imgtag = "img"; $imgtag_close = "";} // AMP Ready
		
		$output = '<div id="firemypopopo_' .$id_pop. '" class="batsignal"><a href="'. $target_url. '" '. $mytarget. ' title="'. $image_alt .'" '.$emptytarget.'><'. $imgtag. ' src="'. $image_url. '" alt="' .$image_alt. '" title="'. $image_alt. '" width="'.$largeur. '" height="'. $hauteur .'" ></a></div>'; // AMP Ready
		
		$output .= "<style>#firemypopopo_$id_pop{position:fixed;margin:0 auto;background:#fff;height:auto;z-index:9999;text-align:center;transform:translate(-50%,-50%) rotate(4deg);border-radius:8px;border:4px solid #ffd78d;transition-duration:.4s;animation:spin 2s linear 1 forwards}@keyframes spin{100%{-webkit-transform:rotate(0) translate(-50%,-50%);transform:rotate(0) translate(-50%,-50%)}}#firemypopopo_$id_pop:hover{border:8px solid #ffd78d;cursor:pointer}#firemypopopo_$id_pop img{width:100%;margin:0 auto;clear:both}#firemypopopo_$id_pop h2{font-weight:700;font-family:arial;padding:10px 0}#overlayh_$id_pop{position:fixed;width:100%;margin:0;padding:0;opacity:.8;background:#000;height:100%;display:block;z-index:9998;top:0;left:0}.batsignal{display:none;background:#fff;padding:20px;border:20px solid #ddd;font-size:1.2em;position:fixed;top:50%;left:50%;-webkit-box-shadow:0 0 20px #000;-moz-box-shadow:0 0 20px #000;box-shadow:0 0 20px #000;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px}#firemypopopo_$id_pop a.close{position:absolute;top:-20px;right:0;color:#fff;background:#000;padding:5px 10px;text-decoration:none;border-radius:5px;font-weight:700;font-family:arial;opacity:0.8;border:3px solid white;}#firemypopopo_$id_pop a.close:hover{background:#fff;color:#000}@media only screen and (max-width:767px){#firemypopopo_$id_pop{width:100%!important;border:0;padding:0!important;margin:0!important;height:auto!important}#firemypopopo_$id_pop img{max-width:100%;border:0;width:auto;}#overlayh_$id_pop{width:100%;border:0;margin:0}}</style>";
		
		if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')) { // Fix Bug iPad
			$output .= "<style>#firemypopopo_$id_pop{animation:none!important; transition: none !important;transform:translate(-50%,-50%) rotate(0deg);}</style>";
		}
		
		//
		
		if ( ! did_action( 'wp_footer' ) ) { // wp_footer() n'a pas déjà été appelé
				
			// Ajoute la sortie générée dans le footer
			add_action( 'wp_footer', function() use ($output) {echo $output;});
			
		} else { // wp_footer() a déja été appelé
		
			return $output;
			
		} 
		
	}
	
	add_shortcode( 'batsignal', 'a_toi_batman' );


	function launchmybatsignal($id_pop, $largeur, $trigger, $trigger_unit, $expires_s) {

		?>
		
		<?php $set_cookie_key = "shooted_by_my_batsignal_$id_pop"; ?>
		
		<script type="text/javascript">

				function setCookie(key, value, expiry) {
					var now = new Date();
					var time = now.getTime();
					var expireTime = time + (<?php echo $expires_s; ?> * 1000);
					now.setTime(expireTime);
					document.cookie = key + '=' + value + ';expires=' + now.toUTCString() +';path=/';
				}

				function getCookie(key) {
					var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
					return keyValue ? keyValue[2] : null;
				}
				
		</script>
		
		<?php
		
		if ($trigger_unit == 'px') { ?>
		
			<script type="text/javascript">
			
			var monbocookie_scroll = getCookie('<?php echo $set_cookie_key; ?>');
			
			jQuery(function($){    
					$triggered_times = 0;
					$(window).on('scroll', function() {
							var y_scroll_pos = window.pageYOffset;
							var scroll_pos_test = <?php echo $trigger; ?>;  

							if(y_scroll_pos > scroll_pos_test && $triggered_times == 0 ) {
								
								var popID = 'firemypopopo_<?php echo $id_pop; ?>'; <?php echo "\n"; //Trouver la pop-up correspondante ?>
								var popWidth = <?php echo $largeur; ?>; <?php echo "\n"; //Trouver la largeur ?>
								
								if ((monbocookie_scroll != 1)) {
									<?php echo "\n"; // Faire apparaitre la pop-up et ajouter le bouton de fermeture ?>
									$('#' + popID).fadeIn().css({ 'width': popWidth}).prepend('<a href="#" class="close">X</a>');
									
									<?php echo "\n"; //  Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues d'anciennes versions de IE ?>
									$('body').append('<div id="overlayh_<?php echo $id_pop; ?>"></div>');
									$('#overlayh_<?php echo $id_pop; ?>').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
						
									$triggered_times = 1;   <?php echo "\n"; // to make sure the above action triggers only once ?>
									
									setCookie('<?php echo $set_cookie_key; ?>','1','<?php echo time()+ $expires_s; ?>'); 
									
									return false;
								}
							}
					});

			
					<?php echo "\n"; // Close Popups and Fade Layer ?>
					$('body').on('click', 'a.close, a.emptytarget, #overlayh_<?php echo $id_pop; ?>', function() { <?php echo "\n"; //Au clic sur le body... ?>
						$('#overlayh_<?php echo $id_pop; ?> , #firemypopopo_<?php echo $id_pop; ?>').fadeOut(function() {
						$('#firemypopopo_<?php echo $id_pop; ?>, a.close, #overlayh_<?php echo $id_pop; ?>').fadeOut();  
					}); 
					<?php echo "\n"; // ...ils disparaissent ensemble ?>
						
						return false;
					});
					
				
					
			});	
			</script>
		
		<?php } else { ?>
		
			<script type="text/javascript">
			
			var monbocookie = getCookie('<?php echo $set_cookie_key; ?>');
			var atmoslaunch = <?php echo $trigger; // Convertisseur de Millisecondes en Secondes ?> * 1000;
			
				jQuery(function($){
												   
					<?php echo "\n"; // Lorsque vous cliquez sur un lien de la classe poplight ?>
					$(document).ready(function() {
						setTimeout(function () {
						var popID = 'firemypopopo_<?php echo $id_pop; ?>'; <?php echo "\n"; // Trouver la pop-up correspondante ?>
						var popWidth = <?php echo $largeur; ?>; <?php echo "\n"; // Trouver la largeur ?>
						
						if ((monbocookie != 1)) {
							<?php echo "\n"; // Faire apparaitre la pop-up et ajouter le bouton de fermeture ?>
							$('#' + popID).fadeIn().css({ 'width': popWidth}).prepend('<a href="#" class="close">X</a>');
							
							
							<?php echo "\n"; // Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues d'anciennes versions de IE ?>
							$('body').append('<div id="overlayh_<?php echo $id_pop; ?>"></div>');
							$('#overlayh_<?php echo $id_pop; ?>').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
							
							setCookie('<?php echo $set_cookie_key; ?>','1','<?php echo time()+ $expires_s; ?>'); 
							
							return false;
						}
						
					}, atmoslaunch);
					
					
					
					<?php echo "\n"; // Close Popups and Fade Layer ?>
					$('body').on('click', 'a.close, a.emptytarget, #overlayh_<?php echo $id_pop; ?>', function() { <?php echo "\n"; // Au clic sur le body... ?>
						$('#overlayh_<?php echo $id_pop; ?> , #firemypopopo_<?php echo $id_pop; ?>').fadeOut(function() {
						$('#firemypopopo_<?php echo $id_pop; ?>, a.close, #overlayh_<?php echo $id_pop; ?>').fadeOut();  
					}); 
					<?php echo "\n"; //...ils disparaissent ensemble ?>
						
						return false;
					});
					

					});

				});	
			

			</script>
	
		<?php }


	}

	

$l0nch_my_batsignal_option_powered = get_option('l0nch_my_batsignal_option_powered');
if ($l0nch_my_batsignal_option_powered == "oui") {
		function gothamadblock_powered_seo() {
			echo "<p style='text-align:center;'>Plugin powered by <a href='https://www.kapsulecorp.com/' target='_blank' rel='noopener'>Kapsule Corp</a></p>";
			}
		add_action( 'wp_footer', 'gothamadblock_powered_seo' );
}


?>
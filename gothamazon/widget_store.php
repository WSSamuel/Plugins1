<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

// Creation du widget boutique
class gotamazon_shoppingstore_widget extends WP_Widget {
	
function __construct() {
parent::__construct(
 
// Base ID of your widget
'gotamazon_shoppingstore_widget', 
  
// Widget name will appear in UI
__('.: GothAmazon MiniStore by KW :.', 'gotamazon_shoppingstore_widget'), 
  
// Widget description
array( 'description' => __( 'Affichage de 1 ou plusieurs produits correspondants à votre Keyword en sidebar', 'gotamazon_shoppingstore_widget' ), ) 
);
}
  
// Creating widget front-end
  
public function widget( $args, $instance ) {
	
	$title = apply_filters( 'widget_title', $instance['title'] );
	$bykw = apply_filters( 'widget_title', $instance['bykw'] );  
	$nono = $instance['nono'];
	$prixmin = $instance['prixmin'];
	$prixminreset = $instance['prixminreset'];
	$cat = $instance['cat'];
	$sortbay = $instance['sortbay'];
	$hidetitre = $instance['hidetitre'];
	$wboodisplayprice = apply_filters( 'widget_title', $instance['wboodisplayprice'] );
	$legalgordon = apply_filters( 'widget_title', $instance['legalgordon'] );
	$economiemin = $instance['economiemin'];
	$vendeur = $instance['vendeur'];
	$marque = $instance['marque'];
	$linquery = $instance['linquery'];
	$force_api = $instance['force_api'];
	$inclusion = isset( $instance['inclusion'] ) ? $instance['inclusion'] : '';
	$exclusion = isset( $instance['exclusion'] ) ? $instance['exclusion'] : '';
	$nkw = isset( $instance['nkw'] ) ? $instance['nkw'] : '';
	$design = isset( $instance['design'] ) ? $instance['design'] : '';
	$af2 = isset( $instance['af2'] ) ? $instance['af2'] : '';

	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	
	if (! empty( $title ) ) {
		
		echo $args['before_title'] . $title . $args['after_title'];
		
	}
	// This is where you run the code and display the output
	
	
	if (empty( $design ) ) {
		
		$design = "sidebar";
		
	}
	
	//////////////////
	// SMART SIDEBAR

	if ( is_single() ) { // Si c'est un article
	
		// On cherche l'ID du Post Courant
		$sherlok_iddupost = get_queried_object();
		if ( $sherlok_iddupost ) {
			$post_id = $sherlok_iddupost->ID;
		}
		//
		$gotham_dynamic_store_widget = get_post_meta($post_id,'gotham_dynamic_store_widget', true); // On cherche le champ personnalisé
		
		if ($gotham_dynamic_store_widget != '') {
			$bykw = $gotham_dynamic_store_widget; // S'il n'est pas vide, le kw de l'article remplace le kw principal
			if ($prixminreset =='non') {$prixmin=1;}  // Si le prix minimum exigé de manière général n'est ici plus exigé, on le remet à 0€
		} 
	/////////////
	
	}

	/// On retranche 1 Item si nono est impaire mais différent de 1 (bug qui donnait 0)
	if (($nono%2 == 1) AND ($nono != 1)) {
		
		$smartitem4mobile_iocounter= $nono-1;
		
	} else {
		
		$smartitem4mobile_iocounter= $nono;
	}
	//////

	echo do_shortcode( "[boutique title='$bykw' nono='$nono' prixmin='$prixmin' cat='$cat' hidetitre='$hidetitre' design='$design' legal='$legalgordon' boodisplayprice='$wboodisplayprice' smartitem4mobile='$smartitem4mobile_iocounter' sort='$sortbay' economiemin='$economiemin' vendeur='$vendeur' marque='$marque' linquery='$linquery' force_api='$force_api' inclusion='$inclusion' exclusion='$exclusion' nkw='$nkw']" );
	echo $args['after_widget'];
	
}

          
// Widget Backend 
public function form( $instance ) {
	
	if ( isset( $instance[ 'title' ] ) ) {
		
		$title = $instance[ 'title' ];
	
	} else {
		
		$title = __( 'Shoppez !', 'gotamazon_shoppingstore_widget' );
	
	}
	
	$bykw = isset($instance[ 'bykw' ]) ? $instance[ 'bykw' ] : '';
	$nono = isset($instance[ 'nono' ]) ? $instance[ 'nono' ]: '1';
	$prixmin = isset($instance[ 'prixmin' ]) ? $instance[ 'prixmin' ]: '1';
	$prixminreset = isset($instance[ 'prixminreset' ]) ? $instance[ 'prixminreset' ]: '1';
	$cat = isset($instance[ 'cat' ]) ? $instance[ 'cat' ]: 'All';
	$sortbay = isset($instance[ 'sortbay' ]) ? $instance[ 'sortbay' ]: '';
	$hidetitre = isset($instance[ 'hidetitre' ]) ? $instance[ 'hidetitre' ]: 'non';
	$wboodisplayprice = isset($instance[ 'wboodisplayprice' ]) ? $instance[ 'wboodisplayprice' ]: 'oui';
	$legalgordon = isset($instance[ 'legalgordon' ]) ? $instance[ 'legalgordon' ]: 'oui';
	$economiemin = isset($instance[ 'economiemin' ]) ? $instance[ 'economiemin' ]: '';
	$vendeur = isset($instance[ 'vendeur' ]) ? $instance[ 'vendeur' ]: '';
	$marque = isset($instance[ 'marque' ]) ? $instance[ 'marque' ]: '';
	$linquery = isset($instance[ 'linquery' ]) ? $instance[ 'linquery' ]: '';
	$force_api = isset( $instance['force_api'] ) ? $instance['force_api'] : '';
	$inclusion = isset( $instance['inclusion'] ) ? $instance['inclusion'] : '';
	$exclusion = isset( $instance['exclusion'] ) ? $instance['exclusion'] : '';
	$nkw = isset( $instance['nkw'] ) ? $instance['nkw'] : '';
	$design = isset( $instance['design'] ) ? $instance['design'] : '';
	$af2 = isset( $instance['af2'] ) ? $instance['af2'] : '';
	
	if (empty( $design ) ) {
		
		$design = "sidebar";
		
	}
	
	global $marketplace_id;
	global $ladevise;
	// Widget admin form
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'bykw' ); ?>">Keyword</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'bykw' ); ?>" name="<?php echo $this->get_field_name( 'bykw' ); ?>" type="text" value="<?php echo esc_attr( $bykw ); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'nono' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Nombre d'articles</label>

		
			<select class="widefat" id="<?php echo $this->get_field_id( 'nono' ); ?>" name="<?php echo $this->get_field_name( 'nono' ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
					<?php
					// Your options array
					$options = array(
						'1' => __( '1', '1' ),
						'2' => __( '2', '2' ),
						'3' => __( '3', '3' ),
						'4' => __( '4', '4' ),
						'5' => __( '5', '5' ),
						'6' => __( '6', '6' ),
						'7' => __( '7', '7' ),
						'8' => __( '8', '8' ),
						'9' => __( '9', '9' ),
						'10' => __( '10', '10' ),
					);
					// Loop through options and add each one to the select dropdown
					foreach ( $options as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $nono, $key, false ) . '>'. $name . '</option>';
					} ?>
			</select>

	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'prixmin' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Prix Min</label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'prixmin' ); ?>" name="<?php echo $this->get_field_name( 'prixmin' ); ?>"  <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
				<?php

				// Your options array
				$options = array(
					"1" => __( "-", "1" ),
					"1000" => __( "10 $ladevise", "2" ),
					"2000" => __( "20 $ladevise", "3" ),
					"3000" => __( "30 $ladevise", "4" ),
					"4000" => __( "40 $ladevise", "5" ),
					"5000" => __( "50 $ladevise", "6" ),
					"10000" => __( "100 $ladevise", "7" ),
					"15000" => __( "150 $ladevise", "8" ),
					"20000" => __( "200 $ladevise", "9" ),
					"25000" => __( "250 $ladevise", "10" ),
					"50000" => __( "500 $ladevise", "11" ),
					"100000" => __( "1.000 $ladevise", "12" ),
				);
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $prixmin, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Categorie </label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
		
		<?php if ($marketplace_id == 'en_US') {
			$options = array(
			'All'=> __( 'All Departments'),'AmazonVideo'=> __( 'Prime Video'),'Apparel'=> __( 'Clothing & Accessories'),'Appliances'=> __( 'Appliances'),'ArtsAndCrafts'=> __( 'Arts, Crafts & Sewing'),'Automotive'=> __( 'Automotive Parts & Accessories'),'Baby'=> __( 'Baby'),'Beauty'=> __( 'Beauty & Personal Care'),'Books'=> __( 'Books'),'Classical'=> __( 'Classical'),'Collectibles'=> __( 'Collectibles & Fine Art'),'Computers'=> __( 'Computers'),'DigitalMusic'=> __( 'Digital Music'),'DigitalEducationalResources'=> __( 'Digital Educational Resources'),'Electronics'=> __( 'Electronics'),'EverythingElse'=> __( 'Everything Else'),'Fashion'=> __( 'Clothing, Shoes & Jewelry'),'FashionBaby'=> __( 'Clothing, Shoes & Jewelry Baby'),'FashionBoys'=> __( 'Clothing, Shoes & Jewelry Boys'),'FashionGirls'=> __( 'Clothing, Shoes & Jewelry Girls'),'FashionMen'=> __( 'Clothing, Shoes & Jewelry Men'),'FashionWomen'=> __( 'Clothing, Shoes & Jewelry Women'),'GardenAndOutdoor'=> __( 'Garden & Outdoor'),'GiftCards'=> __( 'Gift Cards'),'GroceryAndGourmetFood'=> __( 'Grocery & Gourmet Food'),'Handmade'=> __( 'Handmade'),'HealthPersonalCare'=> __( 'Health, Household & Baby Care'),'HomeAndKitchen'=> __( 'Home & Kitchen'),'Industrial'=> __( 'Industrial & Scientific'),'Jewelry'=> __( 'Jewelry'),'KindleStore'=> __( 'Kindle Store'),'LocalServices'=> __( 'Home & Business Services'),'Luggage'=> __( 'Luggage & Travel Gear'),'LuxuryBeauty'=> __( 'Luxury Beauty'),'Magazines'=> __( 'Magazine Subscriptions'),'MobileAndAccessories'=> __( 'Cell Phones & Accessories'),'MobileApps'=> __( 'Apps & Games'),'MoviesAndTV'=> __( 'Movies & TV'),'Music'=> __( 'CDs & Vinyl'),'MusicalInstruments'=> __( 'Musical Instruments'),'OfficeProducts'=> __( 'Office Products'),'PetSupplies'=> __( 'Pet Supplies'),'Photo'=> __( 'Camera & Photo'),'Shoes'=> __( 'Shoes'),'Software'=> __( 'Software'),'SportsAndOutdoors'=> __( 'Sports & Outdoors'),'ToolsAndHomeImprovement'=> __( 'Tools & Home Improvement'),'ToysAndGames'=> __( 'Toys & Games'),'VHS'=> __( 'VHS'),'VideoGames'=> __( 'Video Games'),'Watches'=> __( 'Watches'),);
			}
			else {
			$options = array(
					'All'=> __( 'Toutes les catégories', '37'),
					'PetSupplies'=> __( 'Animalerie', '1'),
					'MobileApps'=> __( 'Applis & Jeux', '2'),
					'Automotive'=> __( 'Auto et Moto', '3'),
					'EverythingElse'=> __( 'Autres', '4'),
					'Luggage'=> __( 'Bagages', '5'),
					'Beauty'=> __( 'Beauté et Parfum', '6'),
					'LuxuryBeauty'=> __( 'Beauté Prestige', '7'),
					'Baby'=> __( 'Bébés & Puériculture', '8'),
					'Jewelry'=> __( 'Bijoux', '9'),
					'GiftCards'=> __( 'Boutique chèques-cadeaux', '10'),
					'KindleStore'=> __( 'Boutique Kindle', '11'),
					'ToolsAndHomeImprovement'=> __( 'Bricolage', '12'),
					'Shoes'=> __( 'Chaussures et Sacs', '13'),
					'HomeAndKitchen'=> __( 'Cuisine & Maison', '14'),
					'MoviesAndTV'=> __( 'DVD & Blu-ray', '15'),
					'GroceryAndGourmetFood'=> __( 'Epicerie', '16'),
					'OfficeProducts'=> __( 'Fournitures de bureau', '17'),
					'Appliances'=> __( 'Gros électroménager', '18'),
					'Handmade'=> __( 'Handmade', '19'),
					'Electronics'=> __( 'High-Tech', '20'),
					'HealthPersonalCare'=> __( 'Hygiène et Santé', '21'),
					'Computers'=> __( 'Informatique', '22'),
					'MusicalInstruments'=> __( 'Instruments de musique & Sono', '23'),
					'GardenAndOutdoor'=> __( 'Jardin', '24'),
					'ToysAndGames'=> __( 'Jeux et Jouets', '25'),
					'VideoGames'=> __( 'Jeux vidéo', '26'),
					'ForeignBooks'=> __( 'Livres anglais et étrangers', '27'),
					'Books'=> __( 'Livres en français', '28'),
					'Software'=> __( 'Logiciels', '29'),
					'Lighting'=> __( 'Luminaires et Eclairage', '30'),
					'Fashion'=> __( 'Mode', '31'),
					'Watches'=> __( 'Montres', '32'),
					'Music'=> __( 'Musique : CD & Vinyles', '33'),
					'Industrial'=> __( 'Secteur industriel & scientifique', '34'),
					'SportsAndOutdoors'=> __( 'Sports et Loisirs', '35'),
					'DigitalMusic'=> __( 'Téléchargement de musique', '36'),
					'Apparel'=> __( 'Vêtements et accessoires', '38'),
					'VHS'=> __( 'VHS', '39'),
				);
			}
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $cat, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'economiemin' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Remise minimum</label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'economiemin' ); ?>" name="<?php echo $this->get_field_name( 'economiemin' ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
				<?php
				// Your options array
				$options = array(
					''=> __( 'Non', '0'),
					'5'=> __( 'Oui (5%)', '1'),
					'10'=> __( '10%', '2'),
					'15'=> __( '15%', '3'),
					'20'=> __( '20%', '4'),
					'25'=> __( '25%', '5'),
					'30'=> __( '30%', '6'),
					'40'=> __( '40%', '7'),
					'50'=> __( '50%', '8'),
					'60'=> __( '60%', '9'),
				);
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $economiemin, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'vendeur' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Vendeur</label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'vendeur' ); ?>" name="<?php echo $this->get_field_name( 'vendeur' ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
				<?php
				// Your options array
				$options = array(
					'All'=> __( 'All', '0'),
					'Amazon'=> __( 'Amazon', '0'),
				);
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $vendeur, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'hidetitre' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Masquer titre du produit</label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'hidetitre' ); ?>" name="<?php echo $this->get_field_name( 'hidetitre' ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
				<?php
				// Your options array
				$options = array(
					'non' => __( 'non', 'non' ),
					'oui' => __( 'oui', 'oui' ),
				);
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $hidetitre, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'sortbay' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Méthode de Tri</label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'sortbay' ); ?>" name="<?php echo $this->get_field_name( 'sortbay' ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
				<?php
				// Your options array
				$options = array(
					'Default'=> __( 'Par Défaut', '0'),
					'Relevance'=> __( 'Pertinence', '1'),
					'AvgCustomerReviews'=> __( 'Meilleure Note', '2'),
					'Featured'=> __( 'Recommandé', '3'),
					'NewestArrivals'=> __( 'Nouveauté', '4'),
					'Price:HighToLow'=> __( 'Le plus cher', '5'),
					'Price:LowToHigh'=> __( 'Le moins cher', '6'),
				);
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $sortbay, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'marque' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Marque</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'marque' ); ?>" name="<?php echo $this->get_field_name( 'marque' ); ?>" type="text" value="<?php echo esc_attr( $marque ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?> />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'wboodisplayprice' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Afficher Prix</label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'wboodisplayprice' ); ?>" name="<?php echo $this->get_field_name( 'wboodisplayprice' ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
				<?php
				// Your options array
				$options = array(
					'defaut' => __( 'defaut', 'defaut' ),
					'oui' => __( 'oui', 'oui' ),
					'non' => __( 'non', 'non' ),
				);
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $wboodisplayprice, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'prixminreset' ); ?>"> <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Prix min applicable sur les SmartQuery ?</label> 
		<select class="widefat" id="<?php echo $this->get_field_id( 'prixminreset' ); ?>" name="<?php echo $this->get_field_name( 'prixminreset' ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>>
				<?php
				// Your options array
				$options = array(
					'non' => __( 'non', 'non' ),
					'oui' => __( 'oui', 'oui' ),
				);
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $prixminreset, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'legalgordon' ); ?>">Mentions Légales</label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'legalgordon' ); ?>" name="<?php echo $this->get_field_name( 'legalgordon' ); ?>">
				<?php
				// Your options array
				$options = array(
					'oui' => __( 'oui', 'oui' ),
					'non' => __( 'non', 'non' ),
				);
				// Loop through options and add each one to the select dropdown
				foreach ( $options as $key => $name ) {
					echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $legalgordon, $key, false ) . '>'. $name . '</option>';
				} ?>
		</select>
	</p>
	<?php if (BEERUS == "godmod")  { ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'linquery' ); ?>">Tokyo4 Force Main Query</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'linquery' ); ?>" name="<?php echo $this->get_field_name( 'linquery' ); ?>">
					<?php
					// Your options array
					$options = array(
						'non' => __( 'non', 'non' ),
						'oui' => __( 'oui', 'oui' ),
					);
					// Loop through options and add each one to the select dropdown
					foreach ( $options as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $linquery, $key, false ) . '>'. $name . '</option>';
					} ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'force_api' ); ?>">Tokyo4 Force API</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'force_api' ); ?>" name="<?php echo $this->get_field_name( 'force_api' ); ?>" type="text" value="<?php echo esc_attr( $force_api ); ?>" />
		
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclusion' ); ?>">Exclusion</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'exclusion' ); ?>" name="<?php echo $this->get_field_name( 'exclusion' ); ?>" type="text" value="<?php echo esc_attr( $exclusion ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'inclusion' ); ?>">Inclusion</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'inclusion' ); ?>" name="<?php echo $this->get_field_name( 'inclusion' ); ?>" type="text" value="<?php echo esc_attr( $inclusion ); ?>"  />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'nkw' ); ?>">Négative KW</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'nkw' ); ?>" name="<?php echo $this->get_field_name( 'nkw' ); ?>" type="text" value="<?php echo esc_attr( $nkw ); ?>"  />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'af2' ); ?>">Af2</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'af2' ); ?>" name="<?php echo $this->get_field_name( 'af2' ); ?>" type="text" value="<?php echo esc_attr( $af2 ); ?>"  />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'design' ); ?>">Design</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'design' ); ?>" name="<?php echo $this->get_field_name( 'design' ); ?>">
					<?php
					// Your options array
					$options = array(
						'sidebar' => __( 'Sidebar (Default)', 'sidebar' ),
						'slider' => __( 'Slider', 'slider' ),
						'hybrid' => __( 'Hybrid (Slider Mob X Sidebar PC)', 'hybrid' ),
						'full' => __( 'Full', 'full' ),
					);
					// Loop through options and add each one to the select dropdown
					foreach ( $options as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $design, $key, false ) . '>'. $name . '</option>';
					} ?>
			</select>
			
		</p>
	<?php } ?>
	<?php 
}
      
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['bykw'] = ( ! empty( $new_instance['bykw'] ) ) ? strip_tags( $new_instance['bykw'] ) : '';
		$instance['nono'] = ( ! empty( $new_instance['nono'] ) ) ? strip_tags( $new_instance['nono'] ) : '1'; 
		$instance['prixmin'] = ( ! empty( $new_instance['prixmin'] ) ) ? strip_tags( $new_instance['prixmin'] ) : '1';
		$instance['cat'] = ( ! empty( $new_instance['cat'] ) ) ? strip_tags( $new_instance['cat'] ) : 'All';
		$instance['hidetitre'] = ( ! empty( $new_instance['hidetitre'] ) ) ? strip_tags( $new_instance['hidetitre'] ) : 'non';
		$instance['prixminreset'] = ( ! empty( $new_instance['prixminreset'] ) ) ? strip_tags( $new_instance['prixminreset'] ) : '';
		$instance['legalgordon'] = ( ! empty( $new_instance['legalgordon'] ) ) ? strip_tags( $new_instance['legalgordon'] ) : 'oui';
		$instance['wboodisplayprice'] = ( ! empty( $new_instance['wboodisplayprice'] ) ) ? strip_tags( $new_instance['wboodisplayprice'] ) : 'defaut';
		$instance['sortbay'] = ( ! empty( $new_instance['sortbay'] ) ) ? strip_tags( $new_instance['sortbay'] ) : 'Default';
		$instance['economiemin'] = ( ! empty( $new_instance['economiemin'] ) ) ? strip_tags( $new_instance['economiemin'] ) : '';
		$instance['vendeur'] = ( ! empty( $new_instance['vendeur'] ) ) ? strip_tags( $new_instance['vendeur'] ) : '';
		$instance['marque'] = ( ! empty( $new_instance['marque'] ) ) ? strip_tags( $new_instance['marque'] ) : '';
		$instance['linquery'] = ( ! empty( $new_instance['linquery'] ) ) ? strip_tags( $new_instance['linquery'] ) : '';
		$instance['force_api'] = ( ! empty( $new_instance['force_api'] ) ) ? strip_tags( $new_instance['force_api'] ) : '';
		$instance['inclusion'] = ( ! empty( $new_instance['inclusion'] ) ) ? strip_tags( $new_instance['inclusion'] ) : '';
		$instance['exclusion'] = ( ! empty( $new_instance['exclusion'] ) ) ? strip_tags( $new_instance['exclusion'] ) : '';
		$instance['nkw'] = ( ! empty( $new_instance['nkw'] ) ) ? strip_tags( $new_instance['nkw'] ) : '';
		$instance['af2'] = ( ! empty( $new_instance['af2'] ) ) ? strip_tags( $new_instance['af2'] ) : '';
		$instance['design'] = ( ! empty( $new_instance['design'] ) ) ? strip_tags( $new_instance['design'] ) : '';
		return $instance;
	}
} 
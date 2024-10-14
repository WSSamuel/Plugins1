<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

// Creation du widget ASIN
	class gotamazon_asin_widget extends WP_Widget {
		
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'gotamazon_asin_widget', 
	  
	// Widget name will appear in UI
	__('.: GothAmazon ASIN Widget :.', 'gotamazon_asin_widget'), 
	  
	// Widget description
	array( 'description' => __( 'Votre produit phare en sidebar', 'gotamazon_asin_widget' ), ) 
	);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$asin = apply_filters( 'widget_title', $instance['asin'] );  
		$titremano = apply_filters( 'widget_title', $instance['titremano'] );
		$descriptionmano = apply_filters( 'widget_title', $instance['descriptionmano'] );
		$parachutekw = apply_filters( 'widget_title', $instance['parachutekw'] );
		$wboodisplayprice = apply_filters( 'widget_title', $instance['wboodisplayprice'] );
		$legalgordon = apply_filters( 'widget_title', $instance['legalgordon'] );

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];

		if (! empty( $title ) ) { echo $args['before_title'] . $title . $args['after_title'];}
		
		// This is where you run the code and display the output
		echo do_shortcode( "[gothasin asin='$asin' titremano = '$titremano' descriptionmano='$descriptionmano' design='sidebar' parachutekw='$parachutekw' legal='$legalgordon' boodisplayprice='$wboodisplayprice' force1pic='oui']" );
		
		echo $args['after_widget'];
	}
			  
	// Widget Backend 
	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
		}
		else {
		$title = __( 'En vedette', 'gotamazon_asin_widget' );
		}
		
		$asin = isset($instance[ 'asin' ]) ? $instance[ 'asin' ] : '';
		$titremano = isset($instance[ 'titremano' ]) ? $instance[ 'titremano' ]: '';
		$descriptionmano = isset($instance[ 'descriptionmano' ]) ? $instance[ 'descriptionmano' ]: '';
		$parachutekw = isset($instance[ 'parachutekw' ]) ? $instance[ 'parachutekw' ]: '';
		$wboodisplayprice = isset($instance[ 'wboodisplayprice' ]) ? $instance[ 'wboodisplayprice' ]: 'defaut';
		$legalgordon = isset($instance[ 'legalgordon' ]) ? $instance[ 'legalgordon' ]: 'oui';
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'asin' ); ?>">ASIN</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'asin' ); ?>" name="<?php echo $this->get_field_name( 'asin' ); ?>" type="text" value="<?php echo esc_attr( $asin ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'titremano' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Titre Perso (Laissez vide pour titre Amazon)</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'titremano' ); ?>" name="<?php echo $this->get_field_name( 'titremano' ); ?>" type="text" value="<?php echo esc_attr( $titremano ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?> />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'descriptionmano' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Description Perso (Laissez vide pour description Amazon)</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'descriptionmano' ); ?>" name="<?php echo $this->get_field_name( 'descriptionmano' ); ?>" type="text" value="<?php echo esc_attr( $descriptionmano ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?> />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'parachutekw' ); ?>"><?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "🔓";} else {echo"⭐";} ?> Mot clé parachute si le produit n'est plus disponible</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'parachutekw' ); ?>" name="<?php echo $this->get_field_name( 'parachutekw' ); ?>" type="text" value="<?php echo esc_attr( $parachutekw ); ?>" <?php if ((BEERUS != "premium") AND (BEERUS != "godmod")) {echo "disabled";} ?>/>
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
		<?php 
	}
		  
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	$instance['asin'] = ( ! empty( $new_instance['asin'] ) ) ? strip_tags( $new_instance['asin'] ) : '';
	$instance['titremano'] = ( ! empty( $new_instance['titremano'] ) ) ? strip_tags( $new_instance['titremano'] ) : '';
	$instance['descriptionmano'] = ( ! empty( $new_instance['descriptionmano'] ) ) ? strip_tags( $new_instance['descriptionmano'] ) : '';
	$instance['parachutekw'] = ( ! empty( $new_instance['parachutekw'] ) ) ? strip_tags( $new_instance['parachutekw'] ) : '';
	$instance['legalgordon'] = ( ! empty( $new_instance['legalgordon'] ) ) ? strip_tags( $new_instance['legalgordon'] ) : 'oui';
	$instance['wboodisplayprice'] = ( ! empty( $new_instance['wboodisplayprice'] ) ) ? strip_tags( $new_instance['wboodisplayprice'] ) : 'defaut';
	return $instance;
	}
	} 

	// Fin du Widget ASIN
	////////////////////////////
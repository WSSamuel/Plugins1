<?php

/**
 * Adds PhotoFeedTookapic widget
 */
class PhotoFeedTookapic_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress
	 */
	function __construct() {
		parent::__construct(
			'photo_feed_tookapic_widget', // Base ID
			esc_html__( 'Tookapic', 'photo_feed_tookapic' ), // Name
			array( 'description' => esc_html__( 'Display your photos and galleries from Tookapic', 'photo_feed_tookapic' ), ) // Args
		);
	}

	/**
	 * Widget Fields
	 */
	private $widget_fields = array(

		array(
			'id'      => 'widget_field_photo_feed_tookapic_title',
			'label'   => 'Widget name',
			'type'    => 'text',
			'default' => 'My Tookapic Photos',
		),
		array(
			'id'      => 'widget_field_photo_feed_tookapic_username',
			'label'   => 'Tookapic User',
			'type'    => 'text',
			'default' => 'rafosinski',
		),
		array(
			'label'   => 'Photos position',
			'id'      => 'widget_field_photo_feed_tookapic_photo_position',
			'type'    => 'select',
			'default' => 'center',
			'options' => array( 'left' => "Left", 'center' => 'Center' )
		),
		array(
			'label'   => 'Number of photos <br/><small>(0 for unlimited, but max is 10)</small>',
			'id'      => 'widget_field_photo_feed_tookapic_photos_number',
			'type'    => 'number',
			'default' => 0,
		),
		array(
			'label'   => 'Sort by',
			'id'      => 'widget_field_photo_feed_tookapic_sortby',
			'type'    => 'select',
			'options' => array( 'popular' => 'Popular', 'recent' => "Recent", 'oldest' => 'Oldest' ),
			'default' => 'popular',
		)
	);


	/**
	 * @param array $args
	 * @param array $instance
	 *
	 * Front-end display of widget
	 */
	public function widget( $args, $instance ) {
		echo $args[ 'before_widget' ];
		$api = new PhotoFeedTookapic_Api();

		$api->setArgs( $args );
		$api->setInstance( $instance );

		// Output generated fields
		if ( ! empty( $instance[ 'widget_field_photo_feed_tookapic_username' ] ) || '' !== $instance[ 'widget_field_photo_feed_tookapic_username' ] ) {

			$obj = $api->getUserPhotoList();

			if ( ! empty( $instance[ 'widget_field_photo_feed_tookapic_title' ] ) ):
				echo '<p>' . $instance[ 'widget_field_photo_feed_tookapic_title' ] . '</p>';
			endif;

			if ( 0 < $instance[ 'widget_field_photo_feed_tookapic_photos_number' ] ) {
				$widget_field_photo_feed_tookapic_photos_number = intval( $instance[ 'widget_field_photo_feed_tookapic_photos_number' ] );
			}

			$i = 1;

			echo "<div class='grid'>";

			if ( null !== $obj && null !== $obj->data && '' !== $obj->data ):

				foreach ( $obj->data as $item ): ?>

					<?php echo "<a href='" . $item->url . "?utm_medium=plugin' title='" . $item->title . " - " . esc_html__( 'See this photo at Tookapic', 'photo_feed_tookapic' ) . "' target='_blank'>"; ?>
					<figure class="effect-hover-1">
						<img src="<?php echo $item->image_thumb ?>" alt="<?php echo $item->title ?>"/>
						<figcaption>
							<div style="top: 50%; left: 50%; position: absolute; transform: translate(-50%,-50%);">
								<div class="icon-links"
								     style="    display: block; width: 100%; height: 100%; overflow: hidden; margin-bottom: 5px;">
									<div style="display: inline-block; float: left; padding-left: 20px;">
									<span class="icon-heart"
									      style="padding-left: 5px; font-size: 15px; vertical-align: inherit; font-weight: 400; position: relative"><?php echo $item->count_likes ?></span>
									</div>
									<div style="display: inline-block; float: right">
									<span class="icon-comment"
									      style="padding-left: 5px; font-size: 15px; vertical-align: inherit; font-weight: 400; position: relative"><?php echo $item->count_comments ?></span>
									</div>
								</div>
								<!--									<p class="description">Zoe never had the patience of her sisters. She deliberately punched the bear in his face.</p>-->
								<p style="text-align: center; font-size: 16px; border: 2px solid #fff; padding: 4px 25px; font-weight: 400; overflow: hidden; margin-top: 15px; color: #fff; display: block;">
									SHOW</p>
							</div>
						</figcaption>
					</figure>
					<?php echo "</a>"; ?>

					<?php
					if ( isset( $widget_field_photo_feed_tookapic_photos_number ) && $widget_field_photo_feed_tookapic_photos_number === $i ) {
						break;
					}
					$i ++;
				endforeach;

			endif;
			echo "</div>";

		}
		echo $args[ 'after_widget' ];
	}


	/**
	 * @param $instance
	 *
	 * Back-end widget fields
	 */
	public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$widget_value = ! empty( $instance[ $widget_field[ 'id' ] ] ) ? $instance[ $widget_field[ 'id' ] ] : '';
			switch ( $widget_field[ 'type' ] ) {
				case "select":
					$output .= '<p>';
					$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field[ 'id' ] ) ) . '">' . esc_attr( $widget_field[ 'label' ], 'photo_feed_tookapic' ) . ':</label> ';
					$output .= '<select name="' . esc_attr( $this->get_field_id( $widget_field[ 'id' ] ) ) . '">';

					foreach ( $widget_field[ 'options' ] as $key => $item ):
						$output .= '<option class="widefat" value="' . $key . '"';
						if ( ! empty( $instance[ 'widget_field_photo_feed_tookapic_sortby' ] ) && $key == $instance[ 'widget_field_photo_feed_tookapic_sortby' ] ):
							$output .= ' selected ';
						endif;
						if ( ! empty( $instance[ 'widget_field_photo_feed_tookapic_photo_position' ] ) && $key == $instance[ 'widget_field_photo_feed_tookapic_photo_position' ] ):
							$output .= ' selected ';
						endif;
						$output .= '> ' . esc_attr( $item ) . '</option>';
					endforeach;

					$output .= '</select>';
					$output .= '</p>';
					break;
				default:
					$output .= '<p>';
					$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field[ 'id' ] ) ) . '">' . $widget_field[ 'label' ] . ':</label> ';
					if ( ! empty( $widget_field[ 'default' ] ) && ( '' === $widget_field[ 'default' ] || null === $widget_field[ 'default' ] ) && ( '' === $instance[ 'widget_field_photo_feed_tookapic_username' ] || null === $instance[ 'widget_field_photo_feed_tookapic_username' ] ) ):
						$widget_default_value = $widget_field[ 'default' ];
						$output               .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field[ 'id' ] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field[ 'id' ] ) ) . '" type="' . $widget_field[ 'type' ] . '" value="' . esc_attr( $widget_default_value ) . '">';
					else:
						$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field[ 'id' ] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field[ 'id' ] ) ) . '" type="' . $widget_field[ 'type' ] . '" value="';

						if ( empty( $widget_value ) && $widget_value !== '' ):
							$widget_value = $widget_field[ 'default' ];
						endif;

						$output .= esc_attr( $widget_value ) . '">';
					endif;

					$output .= '</p>';
			}
		}
		echo $output;
	}

	/**
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		$this->field_generator( $instance );
	}

	/**
	 * Sanitize widget form values as they are saved
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field[ 'type' ] ) {
				case 'checkbox':
					$instance[ $widget_field[ 'id' ] ] = $_POST[ $this->get_field_id( $widget_field[ 'id' ] ) ];
					break;
				case 'select':
					$instance[ $widget_field[ 'id' ] ] = $_POST[ $this->get_field_id( $widget_field[ 'id' ] ) ];
					break;
				default:
					$instance[ $widget_field[ 'id' ] ] = ( ! empty( $new_instance[ $widget_field[ 'id' ] ] ) ) ? strip_tags( $new_instance[ $widget_field[ 'id' ] ] ) : '';
			}
		}

		return $instance;
	}
} // class PhotoFeedTookapic_Widget

/**
 * register PhotoFeedTookapic widget
 */
function register_photo_feed_tookapic_widget() {
	register_widget( 'PhotoFeedTookapic_Widget' );
}

add_action( 'widgets_init', 'register_photo_feed_tookapic_widget' );

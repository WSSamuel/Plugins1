<?php
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'RICWidget') ) :

class RICWidget extends WP_Widget
{
    /**
     * Constructor
     */
    public function __construct()
    {
		$options = array(
			'classname' => RIC::widget_id(),
			'description' => __( 'Display a responsive investment calculator.', RIC::text_domain() )
		);
		
		// Pass the options to WP_Widget to create the widget.
		$this->WP_Widget( RIC::widget_id(), __( 'Responsive Investment Calculator', RIC::text_domain() ) );
    }
	/**
	 * Build the widget settings form.
	 *
	 * Responsible for creating the elements of the widget settings form.
	 */
	public function form( $instance )
	{
		$defaults = array( 'title' => __( 'Calculate Investment Interest', RIC::text_domain() ) );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		
		// Exit PHP and display the widget settings form.
		?>
		
		<p><?php _e( 'Title' ); ?>: <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		
		<?php
		
	}
	
	/**
	 * A method to save the settings.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
		
	}
	
	/**
	 * A method to display the widget on the front end.
	 */
	public function widget( $args, $instance )
	{
		extract( $args );
		
		echo $before_widget;
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		if ( !empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
        
        $this->display_investment_form();
        
		echo $after_widget;
	}
    
    /**
     * Display the investment form
     */
    private function display_investment_form()
    {
        $form = new RICForm();
        echo $form->get_form();
    }
}   
     
endif;

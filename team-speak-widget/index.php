<?php
/*
Plugin Name: Team Speek widget
Plugin URI: http://dawidurbanski.pl
Description: Widget for entering team speek from your website
Author: Dawid Urbański
Version: 1.0
Author URI: http://dawidurbanski.pl
*/

//==================================================================================================================================
//REF: https://codex.wordpress.org/Widgets_API
//==================================================================================================================================
class teamSpeek_widget extends WP_Widget {

	private $data=array(
				'title'			=>'enter teamSpeak server',
				'img'			=>'',
				'adress'		=>'voice.teamspeak.com',
				'chanell'		=>'',
				'defaultuser'	=>'WebsiteGuest',
				'bookmark'		=>'My teamSpeak',
				);
				
	//konstruktor
	function __construct() {
		parent::__construct(
			'teamSpeek_widget', // Base ID
			__('teamSpeek widget', 'text_domain'), // Name
			array( 'description' => 
			__( 'Enter Team Speak widget', 'text_domain' ), ) // Args
		);

		$this->data['img']=plugins_url( 'assets/ts_Button_106x66_01.png', __FILE__ );		
	}

	//draw on page
	///$v=Array ( [title] => enter teamSpeak server [img] => ts.png [adress] => http:// [chanell] => [defaultuser] => new [bookmark] => My teamSpeak )
	public function widget( $args, $v ) {
		echo $args['before_widget'];

			if ( is_user_logged_in())	{	$user = wp_get_current_user()->data->display_name;}
			else						{	$user=$v['defaultuser'];}
			
			//title
			if ( ! empty( $v['title'] ) )
				echo $args['before_title'] . $v['title'] . $args['after_title'];
			
			//link
			echo '<a href="ts3server://'.$v['adress'].'/?';
			
				//$user is always there
				echo 'nickname='.rawurlencode($user);
			
				if ( ! empty( $v['bookmark'] ) )
				echo '&addbookmark='.rawurlencode($v['bookmark']);
				
				if ( ! empty( $v['chanell'] ) )
				echo '&channel='.rawurlencode($v['chanell']);
				
			echo "\">";
			
				//image
				echo '<img src="'.$v['img'].'">';

			echo '</a>';
		
		echo $args['after_widget'];
	}

	//draw on admin-page
	public function form( $instance ) {

		foreach($this->data as $value_name=>$value_default){
			
			if ( isset( $instance[ $value_name ] ) ) 	$value = $instance[ $value_name ];
			else 										$value = __( $value_default, 'text_domain' );		
														$value = esc_attr( $value );
			$id  = $this->get_field_id( 	$value_name );
			$name= $this->get_field_name( 	$value_name );
			
			echo '<p>';
			echo '<label for="'.$id.'">'.$value_name.':</label>';
			echo '<input class="widefat" id="'.$id.'" name="'.$name.'" type="text" value="'.$value.'">';
			echo '</p>';
		}
	}

	//update setings
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		///$new_instance=Array ( [title] => enter teamSpeak server [img] => ts.png [adress] => http:// [chanell] => [defaultuser] => new [bookmark] => My teamSpeak ) 
		foreach($this->data as $value_name=>$value_default)
			$instance[$value_name] = ( ! empty( $new_instance[$value_name] ) ) ? strip_tags( $new_instance[$value_name] ) : $value_default;
	
		return $instance;
	}

} // class Foo_Widget

// register widget
function teamSpeek_widget_register() {
    register_widget( 'teamSpeek_widget' );
}
add_action( 'widgets_init', 'teamSpeek_widget_register' );
//==================================================================================================================================


?>

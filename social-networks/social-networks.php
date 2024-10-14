<?php
/*
Plugin Name: Social Networks
Plugin URI: http://www.buyfamous.com/blog/social-networks/
Description: Social Networks plugin displays your facebook link, Twitter, Youtube, linkedin, myspace and RSS Feed. I guarantee that you will like it after using this plugin. 
Version: 1.5
Author: Mike Ogbin
Author URI: http://www.buyfamous.com/blog/
License: GPL3
*/
?>
<?php
/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
/*

*/
?>
<?php

// To create a widget you have to extend the WP_Widget class
class social_networks extends WP_Widget
{


	/**

	*/

	// Constructor
	function social_networks()
	{
		$widget_options = array(
			'classname'	=> 'social_networks',
			'description' => __('Social Networks plugin displays your facebook link, Twitter, Youtube and RSS Feed. I guarantee that you will like it after using this plugin.') );
			
		// Call the parent class WP_Widget	
		parent::WP_Widget('social_networks', 'Social Networks', $widget_options);
	
	}

	
	/** 
	 
 	 
 	 **/
	function widget($args, $instance)
	{
		
		extract( $args, EXTR_SKIP );
		
		
		$title = ( $instance['title'] ) ? $instance['title'] : 'Follow Me';
		
		$facebook = ( $instance['facebook'] ) ? $instance['facebook'] : '';
		
		$twitter = ( $instance['twitter'] ) ? $instance['twitter'] : '';
		
		$youtube = ( $instance['youtube'] ) ? $instance['youtube'] : '';
		
		$linkedin = ( $instance['linkedin'] ) ? $instance['linkedin'] : '';
		
		$myspace = ( $instance['myspace'] ) ? $instance['myspace'] : '';
		
		
		?>
		
<?php echo $before_widget; ?>
<?php echo $before_title . $title . $after_title; ?>
		
<?php 
		$ntt_feed_icon = plugins_url( 'images/rss_logo.png' , __FILE__ );
		$ntt_twitter_icon = plugins_url( 'images/twitter_logo.png' , __FILE__ ); 
		$ntt_facebook_icon = plugins_url( 'images/facebook_logo.png' , __FILE__ );
		$ntt_youtube_icon = plugins_url( 'images/youtube_logo.png' , __FILE__ );
		$ntt_linkedin_icon = plugins_url( 'images/linkedin_logo.png' , __FILE__ );
		$ntt_myspace_icon = plugins_url( 'images/myspace_logo.png' , __FILE__ );
		
		?>
		
		
		<a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php echo $ntt_feed_icon; ?>" height="50px" width="50px"></a>
		
        <a href="http://www.facebook.com/<?php echo $instance['facebook']; ?>"><img src="<?php echo $ntt_facebook_icon; ?>" height="50px" width="50px"></a>
        
		<a href="http://www.twitter.com/<?php echo $instance['twitter']; ?>"><img src="<?php echo $ntt_twitter_icon; ?>" height="50px" width="50px"></a>
        
        <a href="http://www.youtube.com/user/<?php echo $instance['youtube']; ?>"><img src="<?php echo $ntt_youtube_icon; ?>" height="50px" width="50px"></a>
        
        <a href="http://www.linkedin.com/in/<?php echo $instance['linkedin']; ?>"><img src="<?php echo $ntt_linkedin_icon; ?>" height="50px" width="50px"></a>
        
        <a href="http://www.myspace.com/<?php echo $instance['myspace']; ?>"><img src="<?php echo $ntt_myspace_icon; ?>" height="50px" width="50px"></a>
		
<?php echo $after_widget; ?>
		
<?php
	
	}
	
	 
	
	function update($new_instance, $old_instance)
	{
	
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		
		$instance['myspace'] = strip_tags( $new_instance['myspace'] );
		
		return $instance;
	
	}
	
	
	function form($instance)
	{
		
		$defaults = array( 'title' => 'Follow Me', 'facebook' => '', 'twitter' => '', 'youtube' => '', 'linkedin' => '' );
		
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = $instance['title'];
		$facebook = $instance['facebook'];
		$twitter = $instance['twitter'];
		$youtube = $instance['youtube'];
		$linkedin = $instance['linkedin'];
		$myspace = $instance['myspace'];
		
		?>
		
		
		<p>Title: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		
		<p>Facebook ID: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" /></p>
		
		<p>Twitter ID: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" /></p>
		
        <p>Youtube User: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>" /></p>
        
        <p>LinkedIn ID: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="text" value="<?php echo esc_attr( $linkedin ); ?>" /></p>
        
        <p>MySpace ID: <input class="nttsocialLinks" name="<?php echo $this->get_field_name( 'myspace' ); ?>" type="text" value="<?php echo esc_attr( $myspace ); ?>" /></p>
<?php

	}
	
	
}


function social_networks_init()
{
	
	register_widget('social_networks');
}

add_action('widgets_init', 'social_networks_init');

?>
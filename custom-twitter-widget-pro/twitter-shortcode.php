<?php
function CFWFtwitterfeed()
{
			ob_start();
			
			$instance = get_option('ETWP_settings');
			//print_r($instance);
			$ETWP_TwitterUserName    =    $instance['ETWP_user_name'];
			//$ETWP_Theme              =   $instance['ETWP_twitter_theme'];
			//$ETWP_Height             =   $instance['ETWP_height'];
			//$ETWP_Width              =   $instance['ETWP_width'];
			$ETWP_LinkColor          =   $instance['ETWP_url_link_color'];
			//$ETWP_ShowTwittsShowReply     =   ($instance['ETWP_show_reply'] == 'no')? 'nofooter': '';
			$ETWP_TwitterWidgetId    =   $instance['Etw_twitter_id'];
			
			$BorderColor = $instance['ETWP_theme_border_color'];
			//$Bordersolid = $instance['ETWP_theme_boder'];
			//$ETWP_Twitter_lang = $instance['ETWP_theme_like_box_lang'];
			
			
			
			?>
			
			<div style="display:block;width:100%;float:left;overflow:hidden">
				<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/twitterdev" min-width="400" height="600" data-theme="dark" data-link-color="<?php echo $ETWP_LinkColor; ?>" data-widget-id="<?php echo $ETWP_TwitterWidgetId; ?>" data-border-color="<?php echo $BorderColor; ?>" data-lang="en_US" data-screen-name="<?php echo $ETWP_TwitterUserName; ?>"data-chrome="no"><?php _e('Tweets By @','Etw'); echo $ETWP_TwitterUserName; ?>  </a>
				<script>
				!function(d,s,id) {
					var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}
				} (document,"script","twitter-wjs");
			</script>
			</div>
			<?php
return ob_get_clean();	
}

add_shortcode('twitter-likebox','CFWFtwitterfeed')
?>
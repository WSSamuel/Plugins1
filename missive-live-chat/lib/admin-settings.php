<?php

add_action( 'admin_menu', 'missiveapp_menu' );

function missiveapp_menu() {
	wp_enqueue_script( 'wp-color-picker' );
  wp_enqueue_style( 'wp-color-picker' );
	add_menu_page( 'Missive Settings', 'Missive', 'administrator', __FILE__, 'missive_settings_page', 'dashicons-email-alt2' );
	add_action( 'admin_init', 'register_missive_settings' );
}

function register_missive_settings() {
	register_setting( 'missive-settings-group', 'missive_chat' );
	register_setting( 'missive-settings-group', 'missive_chat_account_id' );
	register_setting( 'missive-settings-group', 'missive_chat_main_color' );
	register_setting( 'missive-settings-group', 'message_welcome' );
	register_setting( 'missive-settings-group', 'message_help' );
	register_setting( 'missive-settings-group', 'message_identify' );
	register_setting( 'missive-settings-group', 'message_error' );
	register_setting( 'missive-settings-group', 'message_title' );
	register_setting( 'missive-settings-group', 'message_online' );
	register_setting( 'missive-settings-group', 'message_offline' );
	register_setting( 'missive-settings-group', 'message_connecting' );
	register_setting( 'missive-settings-group', 'message_chat' );
	register_setting( 'missive-settings-group', 'message_internet' );
	register_setting( 'missive-settings-group', 'message_identifyName' );
	register_setting( 'missive-settings-group', 'message_identifyEmail' );
	register_setting( 'missive-settings-group', 'message_identifySubmit' );
	register_setting( 'missive-settings-group', 'message_identifyRequired' );
	register_setting( 'missive-settings-group', 'message_identifyThanks' );
}

function missive_settings_page() {
?>
<div class="wrap">
	<h1>Missive Live Chat for WordPress</h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'missive-settings-group' ); ?>
		<?php do_settings_sections( 'missive-settings-group' ); ?>

		<table class="form-table">
			<tr>
				<th scope="row">Enable Missive live chat</th>
				<td><fieldset>
					<label><input type="radio" name="missive_chat" value="yes" <?php echo ( get_option( 'missive_chat' ) == 'yes' ) ? 'checked' : ''; ?>> Yes</label><br>
					<label><input type="radio" name="missive_chat" value="no" <?php echo ( get_option( 'missive_chat' ) == 'no' ) ? 'checked' : ''; ?>> No</label>
				</fieldset></td>
			</tr>

			<tr>
				<th scope="row">Chat Account Id</th>
				<td>
					<input type="text" name="missive_chat_account_id" value="<?php echo esc_attr( get_option( 'missive_chat_account_id' ) ); ?>" <?php echo ( get_option( 'missive_chat' ) == 'yes' ) ? 'required' : ''; ?>  class="regular-text" />
					<p class="description">Read this <a href="https://missiveapp.com/blog/add-live-chat-to-wordpress" target="_blank">guide</a> to learn how to get this ID.</p>
				</td>
			</tr>

			<tr>
				<th scope="row">Main color</th>
				<td>
					<input type="text" name="missive_chat_main_color" value="<?php echo esc_attr(get_option('missive_chat_main_color')); ?>" class="color-field" />
				</td>
			</tr>


			<tr>
				<th scope="row">Welcome Message</th>
				<td>
					<input type="text" name="message_welcome" value="<?php echo esc_attr( get_option( 'message_welcome' ) ); ?>" class="regular-text">
					<p class="description">Default value: Hi there! 👋  The team will reply as soon as possible.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Help Message</th>
				<td>
					<input type="text" name="message_help" value="<?php echo esc_attr( get_option( 'message_help' ) ); ?>" class="regular-text">
					<p class="description">Default value: How can we help?</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Identify Message</th>
				<td>
					<input type="text" name="message_identify" value="<?php echo esc_attr( get_option( 'message_identify' ) ); ?>" class="regular-text">
					<p class="description">Default value: First, identify yourself.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Error Message</th>
				<td>
					<input type="text" name="message_error" value="<?php echo esc_attr( get_option( 'message_error' ) ); ?>" class="regular-text">
					<p class="description">Default value: Sorry, there is an issue connecting to our chat. Please check your Internet connection and try again.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Title Message</th>
				<td>
					<input type="text" name="message_title" value="<?php echo esc_attr( get_option( 'message_title' ) ); ?>" class="regular-text">
					<p class="description">Default value: Chat with us</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Online Message</th>
				<td>
					<input type="text" name="message_online" value="<?php echo esc_attr( get_option( 'message_online' ) ); ?>" class="regular-text">
					<p class="description">Default value: We’re online</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Offline Message</th>
				<td>
					<input type="text" name="message_offline" value="<?php echo esc_attr( get_option( 'message_offline' ) ); ?>" class="regular-text">
					<p class="description">Default value: We’re offline</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Connecting Message</th>
				<td>
					<input type="text" name="message_connecting" value="<?php echo esc_attr( get_option( 'message_connecting' ) ); ?>" class="regular-text">
					<p class="description">Default value: Connecting…</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Chat Message</th>
				<td>
					<input type="text" name="message_chat" value="<?php echo esc_attr( get_option( 'message_chat' ) ); ?>" class="regular-text">
					<p class="description">Default value: Message…</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Internet Message</th>
				<td>
					<input type="text" name="message_internet" value="<?php echo esc_attr( get_option( 'message_internet' ) ); ?>" class="regular-text">
					<p class="description">Default value: Can’t send messages offline.</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Name Message</th>
				<td>
					<input type="text" name="message_identifyName" value="<?php echo esc_attr( get_option( 'message_identifyName' ) ); ?>" class="regular-text">
					<p class="description">Default value: Name</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Email Message</th>
				<td>
					<input type="text" name="message_identifyEmail" value="<?php echo esc_attr( get_option( 'message_identifyEmail' ) ); ?>" class="regular-text">
					<p class="description">Default value: Email</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Submit Message</th>
				<td>
					<input type="text" name="message_identifySubmit" value="<?php echo esc_attr( get_option( 'message_identifySubmit' ) ); ?>" class="regular-text">
					<p class="description">Default value: Submit</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Required Message</th>
				<td>
					<input type="text" name="message_identifyRequired" value="<?php echo esc_attr( get_option( 'message_identifyRequired' ) ); ?>" class="regular-text">
					<p class="description">Default value: Required field</p>
				</td>
			</tr>
			<tr>
				<th scope="row">Thanks Message</th>
				<td>
					<input type="text" name="message_identifyThanks" value="<?php echo esc_attr( get_option( 'message_identifyThanks' ) ); ?>" class="regular-text">
					<p class="description">Default value: Thanks</p>
				</td>
			</tr>
		</table>

		<?php submit_button(); ?>
	</form>
</div>
<script>
(function( $ ) {
	// Add Color Picker to all inputs that have 'color-field' class
	$(function() {
	$('.color-field').wpColorPicker();
	});
})( jQuery );
</script>
<?php
}

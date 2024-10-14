<?php
add_action( 'wp_footer', 'missive_chat_footer' );

function missive_chat_footer() {
	$main_color = get_option('missive_chat_main_color');

	if (empty ( $main_color )) { $main_color = '#000'; }

	$message_welcome = get_option('message_welcome');
	if (empty($message_welcome)) { $message_welcome = 'Hi there! 👋

	The team will reply as soon as possible.'; }
		$message_help = get_option('message_help');
	if (empty($message_help)) { $message_help = 'How can we help?'; }
		$message_identify = get_option('message_identify');
	if (empty($message_identify)) { $message_identify = 'First, identify yourself.'; }
		$message_error = get_option('message_error');
	if (empty($message_error)) { $message_error = 'Sorry, there is an issue connecting to our chat. Please check your Internet connection and try again.'; }
		$message_title = get_option('message_title');
	if (empty($message_title)) { $message_title = 'Chat with us'; }
		$message_online = get_option('message_online');
	if (empty($message_online)) { $message_online = 'We’re online'; }
		$message_offline = get_option('message_offline');
	if (empty($message_offline)) { $message_offline = 'We’re offline'; }
		$message_connecting = get_option('message_connecting');
	if (empty($message_connecting)) { $message_connecting = 'Connecting…'; }
		$message_chat = get_option('message_chat');
	if (empty($message_chat)) { $message_chat = 'Message…'; }
		$message_internet = get_option('message_internet');
	if (empty($message_internet)) { $message_internet = 'Can’t send messages offline.'; }
		$message_identifyName = get_option('message_identifyName');
	if (empty($message_identifyName)) { $message_identifyName = 'Name'; }
		$message_identifyEmail = get_option('message_identifyEmail');
	if (empty($message_identifyEmail)) { $message_identifyEmail = 'Email'; }
		$message_identifySubmit = get_option('message_identifySubmit');
	if (empty($message_identifySubmit)) { $message_identifySubmit = 'Submit'; }
		$message_identifyRequired = get_option('message_identifyRequired');
	if (empty($message_identifyRequired)) { $message_identifyRequired = 'Required field'; }
		$message_identifyThanks = get_option('message_identifyThanks');
	if (empty($message_identifyThanks)) { $message_identifyThanks = 'Thanks'; }

	if (get_option( 'missive_chat' ) == 'yes' ) {
		?>
		<!-- Missive Chat -->
		<script>
		  (function(d, w) {
		    w.MissiveChatConfig = {
		      id: '<?php echo get_option( 'missive_chat_account_id' ); ?>',
		      chat: {
		        variables: {
		          'main-color': <?php echo json_encode($main_color) ?>,
		        },
		      },
					messages: {
		        // Chat messages (string or array of strings)
		        //
		        // - Each string will appear in its own chat bubble
		        // - URLs are clickable (i.e. 'On our website: https://missiveapp.com')
		        // - Links can be formatted (i.e. 'On our {{ link:https://missiveapp.com website }}')
		        welcome: <?php echo json_encode($message_welcome); ?>,
		        help: <?php echo json_encode($message_help); ?>,
		        identify: <?php echo json_encode($message_identify); ?>,
		        error: <?php echo json_encode($message_error); ?>,

		        // UI messages (string only)
		        title: <?php echo json_encode($message_title); ?>,
		        online: <?php echo json_encode($message_online); ?>,
		        offline: <?php echo json_encode($message_offline); ?>,
		        connecting: <?php echo json_encode($message_connecting); ?>,
		        chat: <?php echo json_encode($message_chat); ?>,
		        internet: <?php echo json_encode($message_internet); ?>,
		        identifyName: <?php echo json_encode($message_identifyName); ?>,
		        identifyEmail: <?php echo json_encode($message_identifyEmail); ?>,
		        identifySubmit: <?php echo json_encode($message_identifySubmit); ?>,
		        identifyRequired: <?php echo json_encode($message_identifyRequired); ?>,
		        identifyThanks: <?php echo json_encode($message_identifyThanks); ?>,
		      },
		    };

		    var s = d.createElement('script');
		    s.async = true;
		    s.src = 'https://webchat.missiveapp.com/' + w.MissiveChatConfig.id + '/missive.js';
		    if (d.head) d.head.appendChild(s);
		  })(document, window);
		</script>
		<?php
	}
}

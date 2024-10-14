<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://jonmendoza.ph
 * @since      1.0.0
 *
 * @package    Insert_Image_Alt_Text
 * @subpackage Insert_Image_Alt_Text/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Insert_Image_Alt_Text
 * @subpackage Insert_Image_Alt_Text/admin
 * @author     Jon Vincent Mendoza <jonazodnem26@gmail.com>
 */
class Insert_Image_Alt_Text_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Insert_Image_Alt_Text_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Insert_Image_Alt_Text_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/insert-image-alt-text-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Insert_Image_Alt_Text_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Insert_Image_Alt_Text_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/insert-image-alt-text-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_insert_image_alt_text_admin_menu() {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
    	add_menu_page('Insert Alt Text ', 'Alt Images' , 'manage_options', $this->plugin_name, array($this, 'iiat_display_plugin_setup_page'), 'dashicons-images-alt');
	}

	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_insert_image_alt_text_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function iiat_display_plugin_setup_page() {
		if( !current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have suggicient permissions to access this page.' );
		}	
		if( isset( $_POST['insert_image_alt_text_nonce'] ) && $_POST['insert_image_alt_text_nonce'] == 'insert_image_alt_text_nonce' ) {
	    		include_once( 'partials/insert-image-alt-text-admin-function.php' );
				echo '<div class="notice notice-success"><p>Images has been Alterized!</p></div>';
		}
	    include_once( 'partials/insert-image-alt-text-admin-display.php' );
	}

	public function insert_image_alt_text_once_upload($post_ID){
		if ( wp_attachment_is_image( $post_ID ) ) {
				$my_image_title = get_post( $post_ID )->post_title;
				$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );
				$my_image_title = ucwords( strtolower( $my_image_title ) );
				$my_image_meta = array(
					'ID'		=> $post_ID,			// Specify the image (ID) to be updated
					'post_title'	=> $my_image_title,		// Set image Title to sanitized title
					'post_excerpt'	=> $my_image_title,		// Set image Caption (Excerpt) to sanitized title
					'post_content'	=> $my_image_title,		// Set image Description (Content) to sanitized title
				);
				update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );
		} 
	}

}

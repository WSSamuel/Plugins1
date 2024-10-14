<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @package    Convertix_Pixel
 * @subpackage Convertix_Pixel/public
 * @file       class-convertix-pixel-public.php
 */

/**
 * The public-facing functionality of the plugin.
 */
class Convertix_Pixel_Public {

	/**
	 * If no script tag is printed.
	 *
	 * @var bool
	 */
	public static $printed_noscript_tag = false;

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $convertix_pixel The ID of this plugin.
	 */
	private $convertix_pixel;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The Convertix Container.
	 *
	 * @since    1.4.0
	 * @access   private
	 * @var      string Convertix Container's Name
	 */
	private $convertix_container;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $convertix_pixel The name of the plugin.
	 * @param string $version The version of this plugin.
	 * @param string $convertix_container Convertix Container's Name
	 *
	 * @since    1.0.0
	 */
	public function __construct( $convertix_pixel, $version, $convertix_container ) {

		$this->convertix_pixel 		= $convertix_pixel;
		$this->version         		= $version;
		$this->convertix_container  = $convertix_container;

	}

	/**
	 * Add Convertix Head Code.
	 *
	 * @return void
	 */
	public function ctx_head() {
		if ( $this->is_convertix_off() ) {
			return;
		}
		
		/* Print Google Anti-Flickering Code */
		if ( $this->get_option( CONVERTIX_PIXEL_GOOGLE_ANTIFLICKERING_1 ) ) {
			echo "<!-- anti-flicker snippet (recommended) --><style>.async-hide { opacity: 0 !important} </style><script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;})(window,document.documentElement,'async-hide','dataLayer',4000,{'". $this->get_option( CONVERTIX_PIXEL_GOOGLE_OPTIMIZE_1 ) ."':true});</script>";
		}
		/* Print Convertix Pixel Code */
		echo "<!-- BEGIN Convertix Pixel -->";
		echo "<script>";
		echo "let fb_pixel1 = '". $this->get_option( CONVERTIX_PIXEL_META_PIXEL_ID_1 ) ."',";
		echo "fb_pixel_api1 = '". $this->get_option( CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_1 ) ."',";
		echo "fb_pixel_testid1 = '". $this->get_option( CONVERTIX_PIXEL_META_PIXEL_TESTID_1 ) ."',";
		echo "fb_pixel2 = '". $this->get_option( CONVERTIX_PIXEL_META_PIXEL_ID_2 ) ."',";
		echo "fb_pixel_api2 = '". $this->get_option( CONVERTIX_PIXEL_META_PIXEL_TOKEN_API_2 ) ."',";
		echo "fb_pixel_testid2 = '". $this->get_option( CONVERTIX_PIXEL_META_PIXEL_TESTID_2 ) ."',";
			
		echo "ga_pixel1 = '". $this->get_option( CONVERTIX_PIXEL_GOOGLE_UNIVERSAL_ANALYTICS_1 ) ."',";
		echo "ga4_pixel1 = '". $this->get_option( CONVERTIX_PIXEL_GOOGLE_ANALYTICS4_1 ) ."',";
		echo "gads_conversionID1 = '". $this->get_option( CONVERTIX_PIXEL_GOOGLE_ADWORDS_ID_1 ) ."',";
		echo "gads_remarketing = 'AW-". $this->get_option( CONVERTIX_PIXEL_GOOGLE_ADWORDS_ID_1 ) ."',";
		echo "ggOptimize = '". $this->get_option( CONVERTIX_PIXEL_GOOGLE_OPTIMIZE_1 ) ."',";
		echo "ggOptimizeFlicker = '". $this->get_option( CONVERTIX_PIXEL_GOOGLE_ANTIFLICKERING_1 ) ."',";
			
		echo "ttk_pixel1 = '". $this->get_option( CONVERTIX_PIXEL_TIKTOK_PIXEL_1 ) ."',";
		echo "ttk_pixel_api1 = '". $this->get_option( CONVERTIX_PIXEL_TIKTOK_PIXEL_TOKEN_API_1 ) ."',";
		echo "ttk_pixel_testid1 = '". $this->get_option( CONVERTIX_PIXEL_TIKTOK_PIXEL_TESTID_1 ) ."',";
			
		echo "in_pixel1 = '". $this->get_option( CONVERTIX_PIXEL_LINKEDIN_INSIGHT_TAG_1 ) ."',";
			
		echo "activecampaign_pixel = '". $this->get_option( ACTIVECAMPAIGN_PIXEL_1 ) ."',";
		echo "activecampaign_eventKey = '". $this->get_option( ACTIVECAMPAIGN_EVENTKEY_1 ) ."',";
			
		echo "transportURLServer = '". $this->get_option( CONVERTIX_PIXEL_SERVER_CONTAINER_URL ) ."',";
		echo "cli_GTMevent = '". $this->get_option( CONVERTIX_PIXEL_CLIENT_EVENT ) ."',";
		echo "cli_GTMVariable = '". md5( $this->get_option( CONVERTIX_PIXEL_CLIENT_VARIABLE ) ) ."',";
		echo "convertix_token = '". $this->get_option( CONVERTIX_PIXEL_CLIENT_TOKEN ) ."',";

		echo "gtm_cli_container = '". esc_js( $this->get_option( CONVERTIX_PIXEL_WEB_CONTAINER_ID ) ) ."',";
		echo "gtm_convertix_container = '" . $this->convertix_container . "';";

		echo "window.dataLayer = window.dataLayer || [];";
		echo "window.dataLayer.push({'event':'convertix','ctx.version':'". $this->version ."','ctx.cli_GTMevent' : cli_GTMevent,'ctx.TK' : convertix_token});";
	
		/* Print Google Optimize Code */
		if ( $this->get_option( CONVERTIX_PIXEL_GOOGLE_OPTIMIZE_1 ) ) {
			echo "</script><script src='https://www.googleoptimize.com/optimize.js?id=". $this->get_option( CONVERTIX_PIXEL_GOOGLE_OPTIMIZE_1 ) ."'></script><script>";
		}
		
		echo "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});";
		echo "var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;";
		echo "j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})";
		echo "(window,document,'script','dataLayer','" . esc_js( $this->get_option( CONVERTIX_PIXEL_WEB_CONTAINER_ID ) ) . "');";
		echo "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});";
		echo "var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;";
		echo "j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})";
		echo "(window,document,'script','dataLayer','" . $this->convertix_container . "');</script>";
		echo "<!-- End Convertix Pixel -->";
	}

	/**
	 * Add Convertix Body Code
	 *
	 * @return void
	 */
	public function ctx_body() {
		// Make sure we only print the noscript tag once.
		// This is because we're trying for multiple hooks.
		if ( self::$printed_noscript_tag ) {
			return;
		}
		self::$printed_noscript_tag = true;

		if ( $this->is_convertix_off() ) {
			return;
		}

		echo '<!-- Convertix Pixel (noscript) -->';
		echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . 
			esc_attr( $this->get_option( CONVERTIX_PIXEL_WEB_CONTAINER_ID ) ) . '"  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
		echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . 
			$this->convertix_container . '"  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
		echo '<!-- End Convertix Pixel (noscript) -->';
	}

	/**
	 * Is Convertix OFF.
	 *
	 * @return bool
	 */
	private function is_convertix_off() {
		return get_option( CONVERTIX_PIXEL_ADMIN_OPTIONS ) && CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_ON !== $this->get_option( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT );
	}

	/**
	 * Is Convertix ON.
	 *
	 * @return bool
	 */
	protected function is_convertix_on() {
		return get_option( CONVERTIX_PIXEL_ADMIN_OPTIONS ) && CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT_OFF !== $this->get_option( CONVERTIX_PIXEL_WEB_CONTAINER_PLACEMENT );
	}

	/**
	 * Get attr option.
	 *
	 * @param string $id The option ID.
	 *
	 * @return string
	 */
	protected function get_option( $id ) {
		return isset( get_option( CONVERTIX_PIXEL_ADMIN_OPTIONS )[ $id ] ) ? get_option( CONVERTIX_PIXEL_ADMIN_OPTIONS )[ $id ] : '';
	}
}

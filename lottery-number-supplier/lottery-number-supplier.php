<?php
/*
 Plugin Name: Lottery Number Supplier
 Plugin URI:  http://wordaster.com/lottery-number-supplier.html
 Description: A plugin for supplying lottery quick pick numbers via a small box that gets displayed where you insert a shortcode in your site or blog.
 Author: Living Fossil a.k.a. George Gombay
 Version: 1.2
 Author URI:  http://wordaster.com/About.html
 License URI: http://www.gnu.org/licenses/gpl-2.0.html
 Text Domain: lotnosup
 Domain Path: /languages/
*/

/**
 *  This component drives a plugin that adds to a WP site a small box that presents its readers a lottery numbers' supplier. 
 *  To implement the plugin, insert where you want the "Quick Picker" to appear in your site the shortcode:
 *
 *      [lotsup  cycles='n']   where 'cycles' is an optional  argument.
 *
 *  This will result in the appearance of a mini-form that displays a drop-down list of lotteries with alongside it a “Pick”
 *  button and a next row of a text-area for holding a response line of as many as eight distinct numbers. 
 * 
 *  When your page’s logged-in visitors click the 'Pick' button after having selected a lottery, a row of 'quick pick' numbers
 *  that are tailored to the requirements of their chosen lottery will be supplied in the response line. Those users will then
 *  be able to repeat this 5 more times for the same selection or for any other lottery chosen in place of the prior selection.
 *   
 *  The same users will be able to resume with a further round of 6 'picks' after a 12-second pause or intermission. This total
 *  of 6 lines obtained corresponds to the amount of times that rows of numbers will be supplied by default between each pause.
 *  To change this default, supply a value for the shortcode’s optional argument ‘cycles’ as in the following example:
 *
 *       [lotsup cycles=’9’]
 *
 *  Here by supplying the shortcode an argument ‘cycles’ with a value of ‘9’, you over ride the standard default of ‘6’.
 *  From thereon, all the users of the plugin will be able to go for 9 continuous rounds of pickings at a time.  Note that
 *  when ‘cycles’ is supplied with the shortcode, it needs to be given a value only from within the range from 1 to 12. If
 *  it were to be given any other value, the plugin will issue the error message: 
 *
 *       'Omit cycles or give a number 1..12'
 *
 *  @dependency      jQuery
 *                   admin-ajax
 *                   lns_ pickResponder
 *                   lns_pickResponder_denied
 */
if ( !defined('ABSPATH') ) {                   // Safeguard to prevent direct access
	exit;
}

require_once (plugin_dir_path( __FILE__ ) .'lib/lns_pickResponder.php');
require_once (plugin_dir_path( __FILE__ ) .'lib/lns_pickResponder_denied.php');

class lns_LotterynumberSupplier {
	protected $cyclesvetted;
	protected $firstvisit;
	protected $dimension;            //  value of 'slim' for form-width if inserted in sidebar, default is 'norm'.   // rel 1.2
	static $delimit = ':';
	
	function  __construct() {
		$this->cyclesvetted = "";
		$this->firstvisit = true;
		$this->dimension= "norm";                                        
		add_action( 'wp_head', array($this, 'declare_ajaxurl'));
		add_action('wp_enqueue_scripts', array($this,'enqueue_myassets'));
		add_action('init', array($this,'lns_load_textdomain'));
		add_action( 'wp_ajax_pickResponder',  'lns_pickResponder');	
		add_action( 'wp_ajax_nopriv_pickResponder', 'lns_pickResponder_denied');
		add_shortcode ('lotsup', array($this,'lns_handle_pickRequests' ));
		add_filter('widget_text', 'shortcode_unautop');                   
		add_filter('widget_text', 'do_shortcode');                       
		}
		
	function enqueue_myassets() {
			wp_enqueue_script("jquery");
			wp_enqueue_style('lotnosupstyle', plugins_url('stylings/lns_pickformstyle.css', __FILE__));
			}
			
	function declare_ajaxurl(){
		?>
			<script type="text/javascript">
				var ajax_url = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
			</script> 
		<?php
		}
		
	function lns_load_textdomain(){
			load_plugin_textdomain(       
			    'lotnosup',
				 FALSE,
				plugin_basename(dirname( __FILE__ )) . '/languages/');
		}

	function PickRequestform($cycles) {
		if ($this->firstvisit) { 
			$this->firstvisit = false;
			$visitcount = 0;
			$showfirst = "";
			$formwidth = $this->dimension;                                         
			$formtitlenorm  = __("Lottery Numbers' Quick Picks", "lotnosup");      
			$formtitleslim  = __("Lottery Quick Picks", "lotnosup");               
			$formtitle = ($formwidth == 'norm') ? $formtitlenorm : $formtitleslim; 
			$divID     = ($formwidth == 'norm') ? "lottonorm" : "lottoslim";       // ID that triggers 1 of 2 different CSS styles 
			$EOLselect = ($formwidth == 'norm') ? "" : "</p><p align='center'>";   
			$EOLbutton = ($formwidth == 'norm') ? "</p><p align='center'>" : "";   
			$choicesname = __('Lotto:', 'lotnosup');
			$buttonvalue = __('Pick', 'lotnosup');
			$lineprefix  = __('row ', 'lotnosup');
			$freshround  = __(" Now accepting picks again", "lotnosup");
			$separator = self::$delimit;
			}
		$rounds = $cycles;
		$picktoken = wp_create_nonce('pickorder');
		$pickform = <<<PICKFORM
		    <div id='$divID'>
			<FORM ID="lottoform"  NAME="lottoform" METHOD="post" ACTION="">
				<fieldset>
				<P ID="formhead" align=center><STRONG>$formtitle</STRONG></P>
				<input type="hidden" id="actor" name="action" value= "pickResponder">
				<input type="hidden" id="visitid" name="visit" value="$visitcount">
				<input type="hidden" id="roundsid" name="rounds" value="$rounds">
				<input type="hidden" id="picksignid" name="picksign" value="$picktoken">
				<P align=center><LABEL ID="lottochoice" FOR="lottoselected">$choicesname</LABEL>
					<SELECT ID="lottoselected" NAME="lottoselection" SIZE="1" >
						<OPTION VALUE="megabucks">3-State Megabucks</OPTION>
						<OPTION VALUE="powerball">Powerball</OPTION>
						<OPTION VALUE="megamilns">Mega Millions</OPTION>
						<OPTION VALUE="luckylife">Lucky For Life</OPTION>
						<OPTION VALUE="lotto649" >Lotto 6/49</OPTION>
						<OPTION VALUE="lottomax">Lotto Max</OPTION>
						<OPTION VALUE="hotlotto">Hot Lotto</OPTION>
						<OPTION VALUE="euromilns">Euro Millions</OPTION>
						<OPTION VALUE="eurojack">Euro Jackpot</OPTION>
						<OPTION VALUE="cash4life">Cash4life</OPTION> 
						<OPTION VALUE="poweraus">Powerball Australia</OPTION>
					</SELECT>$EOLselect
				<INPUT TYPE="button" ID="pickbutton" NAME="pickbutton" VALUE='$buttonvalue'>$EOLbutton
				<TEXTAREA ID="answerbox"  NAME="answerarea" rows="1" COLS="27" readonly>$showfirst</TEXTAREA></p>
				</fieldset>
			</FORM>
			</div>
PICKFORM;
		require_once (plugin_dir_path( __FILE__ ) . 'lib/lns_pickajax.php');
		
		$requestform  = $pickform;
		$requestform .= $pickajax;
		return $requestform; 
		die();
		}

	function lns_choosedimension() {
	 	if (in_the_loop() && is_main_query() ){
	 				$placement = 'norm';           //  when placed in page or post, default
	 		} else {
					$placement = 'slim';           //  when placed in the sidebar 
		 	}
		return $placement; 
		}	
		
	function lns_CheckCycles($atts){ 
		$cyclesupplied = TRUE; 
		$this->cyclesvetted = ""; 
		$cyclespass = FALSE; 
		extract(shortcode_atts(array( 
				'cycles'=> NULL, 
					), $atts)) ;
		if ($cycles == NULL) { 
			$cyclesupplied = FALSE; 
			$cyclespass = TRUE; 
			} 
		$cyclestrimmed = trim($cycles); 
		if ($cyclesupplied) { 
			$cyclesinput = $cyclestrimmed; 
			if ( is_numeric($cyclesinput) ) {
				$cyclesinteg = intval($cyclesinput); 
				if (($cyclesinteg > 0 ) && ($cyclesinteg < 13))  {
					$this->cyclesvetted = $cyclesinteg; 
					$cyclespass = TRUE; 
					} 
				}
			}
		return $cyclespass;
		}
	
	function lns_handle_pickRequests($atts){
		$cyclesgood = $this->lns_CheckCycles($atts);
		$warningcyclewrong  = __('Omit cycles or give a number 1..12', 'lotnosup');
		$warningnorequester = __('Sorry, requester could not be raised', 'lotnosup');
		if (!$cyclesgood){
					$numbersPicker = '<em>' . $warningcyclewrong . '</em>';
			} else {
					$this->dimension= $this->lns_choosedimension();  
					$repeats = $this->cyclesvetted;
					$linesPicker = $this->PickRequestform($repeats);
					if ($linesPicker) {
								$numbersPicker = $linesPicker;
						} else {
								$numbersPicker = '<em>' . $warningnorequester . '<em>';
						}
			}
		return $numbersPicker;
		}
}
		
$LotterynumberProvider = new lns_LotterynumberSupplier;
?>
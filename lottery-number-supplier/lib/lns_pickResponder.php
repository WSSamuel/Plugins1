<?PHP
/**
 *  This is a gatekeeper and dispatcher that passes requests on for further attention after having applied 
 *  to them a basic screening for the presence of the needed parameters. Then once these have been processed,
 *  it forwards the responses to the client. It doesn't throw any exceptions, but returns instead a warning. 
 *
 *  @Dependency  ManageLineSupply
 *
 *  @param  int      $rounds       The most number of request cycles that are to be accepted in between pauses. 
 *  @param  int      $visit        A count of the requests made prior to this during the current round of cycles.
 *  @param  string   $lottochosen  Identifier for a lottery. 
 *
 *  @return string   'echo line'   On 'failure' contains a warning line                                 
 *          string   'echo line'   On success contains a line made up of:                               
 *                                 - array   $pickline; a string array or list of generated pick numbers
 *                                 - string  $separator; a one-character delimiter                     
 *                                 - int       $kount, representing the latest request or 'visit' count
 *                                 - string  $separator; a one-character delimiter                     
 *                                 - string  $supplyon; having value equal to either '1' or '0'.  
 */
function lns_pickResponder() {
		require_once (plugin_dir_path( __FILE__ ) . 'lns_manageLineSupply.php');
		$countcycles = 0;
		$pickline = "";
		$supplyon = 1;               // This is a flag that gets set to '0' when the allowed cycles get used up. 
		$separator = lns_LotterynumberSupplier::$delimit;
		$visitcountexists = TRUE;
		$warningunauthorizeduser  = " Unauthorized use was denied";
		$warningnovisitcounter    = " No visit counter was found";
		$warningnochoiceposted    = " No lottery choice specified";
		$warninglinesupplierfault = " Fault with pick line supplier";
		$warningnopicklinegotten  = " No picks' line was supplied"; 

		function GetPickline( $lottochoice, $countcycles, $cyclesmost ) {
				$delim = lns_LotterynumberSupplier::$delimit;
				$pickLineSupply = new  lns_ManageLineSupply($cyclesmost);
				$pickLineSupply->setDelimiter($delim);
				$suppliedLine = $pickLineSupply->getsupplyLine( $lottochoice, $countcycles);
				return $suppliedLine;
			}  

		check_ajax_referer('pickorder');

		if ( !isset($_REQUEST['visit'] ) ) { 
				$pickline = $warningnovisitcounter;
				$countcycles =  0;
				$visitcountexists = FALSE;
			}

		if ( isset( $_REQUEST['visit'] ) ) {  
				$visitcount = ($_REQUEST['visit'] );
					if ( is_numeric($visitcount) && ($visitcount > 0) ){
							$visitcount = intval($visitcount);
					} else {
							$visitcount = 0;
					}			
				$countcycles =  $visitcount;
			}

		$cyclesmost = ( isset($_REQUEST['rounds'] ) )  ? $_REQUEST['rounds'] : NULL ; 

		if ( !isset($_REQUEST['lottoselection']) || empty( $_REQUEST['lottoselection'] )) {
				$pickline = $warningnochoiceposted ;
			}

		if ( isset($_REQUEST['lottoselection'] ) && !empty( $_REQUEST['lottoselection'] ) && ($visitcountexists) ) {
				$lottochoice = $_REQUEST['lottoselection'];
				$lineGotten = GetPickline($lottochoice, $countcycles, $cyclesmost);
				if ( $lineGotten ) {
							$lineSplit = explode( $separator, $lineGotten, 3 ) ;
							$pickline  = $lineSplit[0];
							$linecount = $lineSplit[1];
							$supplyon = $lineSplit[2];
					} else {
							$pickline = $warninglinesupplierfault;
					}
			}

		if ( empty($pickline) ) $pickline = $warningnopicklinegotten;

		if ( empty($linecount) ) {
					$countcycles = 1;          // To prevent overwriting by requester of any warning that may be returned it
			} else {
					$countcycles = intval($linecount);
			} 

		$kount  = $countcycles;
		ob_clean();
		echo $pickline . $separator . $kount . $separator . $supplyon;
		wp_die();
}

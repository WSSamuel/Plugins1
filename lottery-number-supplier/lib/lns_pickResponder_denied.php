<?PHP
/**
*  Processing is redirected here when a user attempts to pick lottery numbers before login. 
*/
function lns_pickResponder_denied() {
		$warningtologin = __(" Please login before picking", "lotnosup");
		$delim = lns_LotterynumberSupplier::$delimit; 
		$countrounds = 1;       // for preventing an overwrite of the warning upon its return to requester
		$kount  =  $countrounds;
		$cykling = 1;
		$pickline= $warningtologin . $delim . $kount . $delim . $cykling;
		ob_clean();
		echo $pickline;
		wp_die();
}

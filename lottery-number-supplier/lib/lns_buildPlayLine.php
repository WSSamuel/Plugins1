<?PHP
/**
*  This component assembles a line of quick pick numbers that get generated for it using the 'recipe', which 
*  applies to the lottery that was selected. It doesn't throw any exceptions, but returns instead a warning. 
*
*  @Dependency       lns_LottoProfiles                                                                             
*                    lns_NumbersGenerator                                                                          
*  @param   string   $lottoSelected      Identifier for a lottery.                                                 
*  @return  string   $playline           On 'failure' contains a warning line                                      
*                                        On success a line of pick numbers; two to eight two-digit numbers in all, 
*                                        separated by a space and each given a leading 0 if single-digit. 
*/
require (plugin_dir_path( __FILE__ ) . 'lns_numbersGenerator.php');
require (plugin_dir_path( __FILE__ ) . 'lns_lottoProfiles.php'); 

class lns_BuildPlayLine {
		private	  $totalNums;
		private   $biggestNum;
		private   $lottoList = array(); 
   		private   $gameProfiles;
		private   $lottoNumbers; 
		protected $lottoNamePrevious;                                                                                   
		protected $markCount;
		protected $maxNumber; 
		protected $bonusCount;
		protected $bonusNumber;
		protected $numbersPresent;
		protected $warningunableaccess  = " Couldn't access profiles"; 
		protected $warningfailedextract = " Couldn't extract params.";
		protected $warningunsafeparams  = " Can't use wrong parameters";  
		protected $warningongenerator   = " Generator gave no numbers.";
			
		function  __construct( 	 ) {
			$this->markCount = null; 
			$this->maxNumber = null; 
			$this->bonusCount = null;
			$this->bonusNumber = null;
			$this->playLine= "";
			$this->totalNums = 0;
			$this->biggestNum = 0;
			$this->numbersPresent = 0;
			$this->lottoNamePrevious = "tostartup";                 //  important don't initialize with 'empty' value! 
			$this->gameProfiles  = new lns_LottoProfiles; 
			$this->lottoNumbers = new lns_NumbersGenerator;
		}

		protected function pickNumbers($pickCount, $pickMax) {
			if (is_numeric($pickCount)  &&  ($pickCount > 0)) {
				if (is_numeric($pickMax) &&  ($pickMax > 0)) {
					$picks =  "";
					$numbersList = $this->lottoNumbers->getNumbersList($pickCount, $pickMax );
					if  ( !$numbersList ) {
						$picks  =  False;
						return  $picks;	
						}	
					$this->lottoList = $numbersList; 	
					foreach ($this->lottoList  as $pick) {
						$picks .=  sprintf('%02d ', $pick);
						}
					}
				}
			return  $picks;	
			}
			
		protected function confirmLotteryParamsAreSafe() { 
	        //
			//   This method verifies that the profile retrieved for the lottery yields
			//    number-picking parameters with values that are still safe to use. 
	        //
			if (  is_numeric( $this->totalNums) && is_numeric($this->biggestNum) && is_numeric( $this->bonusCount) && is_numeric( $this->bonusNumber) ) {
 				$markTot  = intval( $this->totalNums );
				$maxNum   = intval( $this->biggestNum );
				$bonusTot = intval( $this->bonusCount ); 
				$bonusNum = intval( $this->bonusNumber );
				} else {
						return false;
				}
			if (  ($markTot < 0 )  ||  ($maxNum < 0 )  || ( $bonusTot  < 0 ) || ($bonusNum < 0  )) {
				return false;
				}
			$sumTots = 	$markTot + $bonusTot;
			if ( $sumTots > 8 ) return false;                   //  Limit the sum of all marks picked per line to this total
			if ($markTot < 2 ) {                                     //  Must mark at least this sum of numbers on the main line 
				return false;
				} else {
						if ($maxNum < 2 ) return false;       //  The least max value for the random num generator to work
				}
			if ($bonusTot  > 0 ) {
						if ($bonusNum  < 2 ) return false;    //  The least max value for the random num generator to work
				} else {
						if ($bonusNum  > 0 ) return false;    //  Can't have a bonus max present if no bonus count is supplied
				} 
			return  true; 
			}
				
		protected function getLotteryProfile($gamename) { 
			$gameProfile = $this->gameProfiles->getLottoProfile($gamename);
			if ( $gameProfile ) {
						extract ($gameProfile, EXTR_OVERWRITE );    // This gets values for $markCount,  $maxNumber,
																								//                    and for $bonusCount, $bonusNumber.
				} else { 
						return false;
				}
			if ( is_null($markCount) && is_null( $maxNumber) ) {
							$this->numbersPresent = 0; 
							return true;                                                 //  profile access succeeded but no numbers were extracted 
				} else {
	  					$this->totalNums = $markCount;
						$this->biggestNum = $maxNumber;
						$this->bonusCount = $bonusCount;
						$this->bonusNumber = $bonusNumber;
			  	 		$this->markCount = null;
			 			$this->maxNumber = null;
						$this->numbersPresent = 1;	     
						return true;
			   }
			}
				
		function getplayLine($lottoSelected) {
			$playLine =  "&nbsp;";
			if ($this->lottoNamePrevious !== $lottoSelected )  {  
     			$lookup = $this->getLotteryProfile($lottoSelected);
				if (!$lookup) {
					 $playLine =  $this->warningunableaccess ; 
					 return $playLine; 
					 }
				$this->lottoNamePrevious = $lottoSelected;  
				if (  !($this->numbersPresent == 1) ) { 
					 $playLine =  $this->warningfailedextract ; 
					 return $playLine; 
					 } 
				$safeLotteryParams = $this->confirmLotteryParamsAreSafe();   
				if  ( !$safeLotteryParams )   { 
					 $playLine =  $this->warningunsafeparams ;  
					 return $playLine;   
					 } 
				 }
			 // Assemble next the main part of the picks' line
			 // 
			 $picksresult = $this->pickNumbers($this->totalNums, $this->biggestNum);
			 if ( $picksresult ) {
						$playLine .=  $picksresult;
				} else {
					    $playLine .= $this->warningongenerator;
					    return $playLine;
				}
			// Supplement next the line with powerball or bonus numbers if applicable for this lottery 
			//  
			if ( $this->bonusCount > 0 ) {
				 $picksresult = $this->pickNumbers($this->bonusCount, $this->bonusNumber);
				 if ( $picksresult ) {
				 			$playLine .=  $picksresult;
					} else {
							$playLine .= $this->warningongenerator;
					}
				}
			return $playLine;
			}	
	}

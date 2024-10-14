<?php
/**
 * This component provides a look-up for an array that stores for each lottery profile a record of values, which
 *  determine the 'what' and the 'how' of the numbers that can be picked for playing the corresponding lottery.
 *  When an attempt is made to look up entries of this store using a non-existent lottery or wrong identifier, 
 *  the module will return values that it will have defaulted to the ones that are used for playing Lotto 6/49. 
 *
 *  @param  string   $gameName   Identifier for a lottery                                                       
 *  @return array    $profile    An array of 4 integer entries that give the rules for picking lottery numbers. 
 *  
 */
class lns_LottoProfiles {
		private   $lottoName;
		private   $gameprofile; 
		protected $lottoprofile = array(); 
       
		function  __construct( 	 ) {
		  		$this->lottoprofile = array('cash4life', 'eurojack', 'euromilns', 'hotlotto', 'lotto649', 'lottomax', 'luckylife',
											'megamilns', 'powerball', 'megabucks', 'poweraus', 'holdplace');
				$this->lottoprofile['cash4life'] = array('markCount' => 5,  'maxNumber' => 60,  'bonusCount'  => 1,  'bonusNumber' =>  4);
				$this->lottoprofile['eurojack']  = array('markCount' => 5,  'maxNumber' => 50,  'bonusCount'  => 2,  'bonusNumber' => 10);
				$this->lottoprofile['euromilns'] = array('markCount' => 5,  'maxNumber' => 50,  'bonusCount'  => 2,  'bonusNumber' => 12);
				$this->lottoprofile['hotlotto']  = array('markCount' => 5,  'maxNumber' => 47,  'bonusCount'  => 1,  'bonusNumber' => 19);
				$this->lottoprofile['lotto649']  = array('markCount' => 6,  'maxNumber' => 49,  'bonusCount'  => 0,  'bonusNumber' =>  0);
				$this->lottoprofile['lottomax']  = array('markCount' => 7,  'maxNumber' => 49,  'bonusCount'  => 0,  'bonusNumber' =>  0);
				$this->lottoprofile['luckylife']  = array('markCount' => 5,  'maxNumber' => 48,  'bonusCount'  => 1,  'bonusNumber' => 18);
				$this->lottoprofile['megamilns'] = array('markCount' => 5,  'maxNumber' => 75,  'bonusCount'  => 1,  'bonusNumber' => 15);
				$this->lottoprofile['powerball'] = array('markCount' => 5,  'maxNumber' => 69,  'bonusCount'  => 1,  'bonusNumber' => 26);
	  			$this->lottoprofile['megabucks'] = array('markCount' => 5,  'maxNumber' => 41,  'bonusCount'  => 1,  'bonusNumber' =>  6);
				$this->lottoprofile['poweraus'] = array('markCount' => 6,  'maxNumber' => 40,  'bonusCount'  => 1,  'bonusNumber' => 20);
				$this->lottoprofile['holdplace'] = array('markCount' => 6,  'maxNumber' => 49,  'bonusCount'  => 0,  'bonusNumber' => 0);
			}
		
		protected function setLottoName($name) {
	   	   if ( in_array( $name, $this->lottoprofile)  ) {
		    		   $this->lottoName = $name;
				   } else {
					   $this->lottoName = 'lotto649';
				   }
		   return  true;
			}
		
		protected function getGameProfile() {
			$this->gameprofile = $this->lottoprofile[$this->lottoName];
			return $this->gameprofile;
			}
			
		public function  getLottoProfile($gameName) {
			$this->setLottoName($gameName);
			$profile = $this->getGameProfile($this->lottoName);
			return $profile;
			}
	}
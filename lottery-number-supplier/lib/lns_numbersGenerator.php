<?PHP
/**
 *  This component produces a list of unique numbers using a random number generator.
 *
 *  @param  string    $totalMarks The count of the 'marks' or numbers in the list that needs to be produced              
 *  @param  string    $maxNumber  The randomizer will generate numbers for the range: 1 - $maxNumber                     
 *  @return boolean   FALSE       if failed or called with wrong parameters                                              
 *                    array       $listNumbers  on success a string array or list of the numbers that have been generated
 */
class lns_NumbersGenerator {
	private $maxFloor   = 2;         // The lowest total or count of numbers that the randomizer will generate 
	private $totCeiling = 8;           // How many different, unique numbers will be generated at most to a list 
	private $maxCeiling = 98;      // The highest number accepted by the randomizer as a maximum to its range  
	protected $genWarning = " Param declined by generator" ;
	 
	public function getNumbersList($totalMarks, $maxNumber) {	
			//
            //  Filter Begin:  restrict values of $maxNumber and $totalMarks to integers within the ranges;
			//                         $maxFloor = <  $maxNumber   = <  $maxCeiling                        
			//                                 0   <  $totalMarks      = <  $totCeiling                    
			//
		    $totalMarks  = (is_numeric( $totalMarks ))  ? intval( $totalMarks )  :   0;
			$totalMarks = min($totalMarks, $this->totCeiling);
			$maxNumber =  (is_numeric( $maxNumber )) ? intval( $maxNumber )  : 0;
			$maxNumber = min($maxNumber, $this->maxCeiling );  
			if ( ($totalMarks < 1) or ($maxNumber  < $this->maxFloor ) )  {
                    return false; 
					}
			// Filter End
			//	
			$kount = 0;
			$kountMax = $totalMarks - 1;
			$listNumbers[$kountMax] = array();								
			do	{
				$is_unique = True;
				$lottoNumber= mt_rand(1, $maxNumber);
				foreach ($listNumbers as $item) {
						if ($lottoNumber == $item)
								$is_unique = False;
								}
				If ( $is_unique) {
					$listNumbers[$kount] = $lottoNumber;
					$kount += 1;
					}
				} 
			while ( $kount <= $kountMax);
			
			sort ($listNumbers);
			return $listNumbers;
	}
}
?>

<?php
/**
 *  This component supplies a line of pick numbers on the successfull completion of each of its  cycles, 
 *  which it ensures will not add up to a count that exceeds the cycle's limit that it is given. It does 
 *  not explicitly throw any exceptions, instead it will return a warning. When wrong values are supplied
 *  for its parameters, instead of rejecting them it continues processing using their default values.
 *  (Note that a "round" as used here is to be understood as a set of cycles between pauses.)
 *
 *  @dependency     lns_BuildPlayLine
 *  
 *  @param  int     $cyclesmost   The most number of times that this process is allowed to cycle during a round
 *  @param  string  $lottochosen  Identifier for a lottery 
 *  @param  int     $trip         The total number of previous visits made during the present round of cycles;
 *                                 it is normally the same as the round's last cycle count.
 *  @return string   $supplyline   On 'failure' contains a warning line                                       
 *          string   $supplyline   On success contains a line made up of:                                      
 *                                 - array   a string array or list of generated pick numbers
 *                                 - string  one-character $delimiter
 *                                 - int       the value of $trip updated to the current cycle count
 *                                 - string   one-character $delimiter
 *                                 - string   the updated value of $cyclingon (equal to either '1' or '0')  
 */
require_once (plugin_dir_path( __FILE__ ) . 'lns_buildPlayLine.php' ); 

class lns_ManageLineSupply {
	private   $cyclesmax = 12;     // This is a fixed maximum value that the cycles limit is allowed to be set at.
	protected $cycleslimit;        // The limit (adjustable) to the number of times that you can request more lines
	                               //      to be picked during a round. 
	protected $cyclesdefault;      // The default value for the cycles limit. 
	protected $cyclecount;
	protected $cyclesusedup;       // This is set to TRUE when the cycles limit is reached. 
	protected $cyclingon;          // This serves as a flag that is set to '0' when the alloted cycles get used up.
	protected $delimiter;          // A symbol used to delimit other data from the pick numbers on the supply line. 
	protected $messageOverlimit;
	protected $warningNoplaylinegotten;

	function __construct($cyclesmost) {
		 $this->supplyline = "";
		 $this->cyclesdefault = 6;
		 $this->setCycleslimit($cyclesmost);
		 $this->cyclesusedup = False;
		 $this->cyclingon = 1;
		 $this->setDelimiter(":");
		 $this->messageOverlimit = __(' Please take a 12-second rest', 'lotnosup');
		 $this->warningNoplaylinegotten  = " Didn't get line from builder"; 
		 $this->SupplyPlayLine = new lns_BuildPlayLine;
		}

	 function setCyclecount ($trip) {
	     if ( is_numeric( $trip ) &&  ( $trip >= 0 ) )  {
						$visit =  intval($trip);
						$this->cyclecount =  $visit ;
						$this->cyclecount ++;
			} else  {
						$this->cyclecount = 1; 
			}
 		 return true;
		 }

 	 function setDelimiter ($seprator) {
	     if ( isset($seprator) && ($seprator != NULL) )  {
			 	    $delim =  trim($seprator);
 					$this->delimiter = $delim ;  
			} else {
		 			$this->delimiter = ":";      
			}
 		 return true;
		 }

	function setCycleslimit( $repeats ) {
	     if (  !is_numeric($repeats)  )  {
				  $this->cycleslimit = $this->cyclesdefault;
		  		 return true;
	 			 }
		 $cycles = intval($repeats );
		 if (  ($cycles  < 1 )   ||  ( $this->cyclesmax < $cycles  )  )  {
							$this->cycleslimit = $this->cyclesdefault;
			     } else {	
							$this->cycleslimit = $cycles;
				}
		 return true;
		 }

	function getsupplyLine( $lottochosen, $trip ) {
		$supplyline  = " ";
		$this->setCyclecount($trip);
		if ( $this->cyclecount  >  $this->cycleslimit ) {
						$this->cyclesusedup = True;
						$this->cyclingon = 0;
						$supplyline  = $this->messageOverlimit;
				} else {
						$playline  = $this->SupplyPlayLine ->getplayLine($lottochosen);
						if ( $playline ) {
									$supplyline = $playline;
							} else {
									$supplyline = $this->warningNoplaylinegotten; 
							}
				}
		$supplyline .= $this->delimiter . $this->cyclecount;
		$supplyline .= $this->delimiter . $this->cyclingon; 
		return  $supplyline;
		}
	}
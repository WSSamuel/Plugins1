<?php
/*
Plugin Name: WP Count Down Timer
Description: Countdown timer to a specified date. A simple plugin with a shortcode that makes it super simple to use.
Author: Sitedin
Author URI: https://sitedin.com
Version: 1.0.1
*/

/*  Copyright 2019  Sitedin Team (email : contact@sitedin.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

function wp_countdown_timer( $atts = '' ) {
	$value = shortcode_atts( array(
        'date' => 'Jan 5, 2021 15:37:25',
        'text' => 'Time Out',
		'color' => 'blue',
		'align' => 'center',
    ), $atts );
	
	?>
	<script>
// Set the target date to which we count down
var targetDate = new Date("<?php echo $value['date']; ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the difference between now and the target date
  var difference = targetDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(difference / (1000 * 60 * 60 * 24));
  var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((difference % (1000 * 60)) / 1000);

  // Display the result in the element with id="timer"
  document.getElementById("timer").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is finished, write some text
  if (difference < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "<?php echo $value['text']; ?>";
  }
}, 1000);
</script>
<?php
	return '<p id="timer" class="timer" style="color:'.$value['color'].'; text-align:'.$value['align'].';"></p>';
}
add_shortcode('wp_countdown_timer', 'wp_countdown_timer');
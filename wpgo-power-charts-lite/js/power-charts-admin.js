/* Power Charts Admin Scripts */

jQuery(document).ready(function($) {

	// get post ID and make it globally available as 'pcPostID'
	window.pcPostID = $("input[type='hidden']#post_ID")[0].value;

	// initialize color pickers
	$( 'input.alpha-color-picker' ).alphaColorPicker();

	// Tasks for page load
	init();

	function init() {

		//
		// get current chart JS from meta box
		//var d3ChartCode = document.querySelector('#wpgo_power_charts_cpt_js');

		// eval the chart JS on admin page load
		//eval(d3ChartCode.value);
	}

	// monitor changes to data, label and other fields
	// @todo add the functionality to another function(s)?
	wpgo_pc_generic_chart_builder();

});
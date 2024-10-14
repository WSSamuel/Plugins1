/* Power Charts script for creating new charts only */
jQuery( document ).ready( function( $ ) {

	// get post ID and make it globally available as 'pcPostID'
	window.pcPostID = $("input[type='hidden']#post_ID")[0].value;

	// move the 'Publish' button, and spinner, and update text.
	$("input[type='submit']#publish").attr('value', 'Create Chart').appendTo('#pc-create-chart');
	$("#publishing-action span.spinner").css('float', 'none').appendTo('#pc-create-chart');

	// update form fields on page load
	updateFields();

	// initialize color pickers
	// not really needed for create new chart page
	//$( 'input.alpha-color-picker' ).alphaColorPicker();

	// update form fields when chart type selection changes
	$('input[name=wpgo_power_charts_cpt_type]').change(function(){
		updateFields();
	});

	// update input fields when chart type selection changed
	function updateFields() {

		// Setup some vars

		// define initial chart data var (with specific post id) on the global scope
		//window['pc_data_' + window.pcPostID] = $("#wpgo_power_charts_cpt_data").val();

		// get currently selected chart type
		var chartType = $('input[name=wpgo_power_charts_cpt_type]:checked').val();

		// get sample data and defaults for currently selected chart type
		var sampleChartData = wpgo_pc_settings[chartType];

		//console.log(sampleChartData);

		// don't proceed if sample data not found
		if(sampleChartData === undefined) {
			console.error("[updateFields] Data not found for chart type: " + chartType);
			return;
		}

		wpgo_pc_utility.populate_form_fields(sampleChartData, chartType);

		wpgo_pc_utility.build_config(sampleChartData, chartType);

		// add JS 'fixed' code to meta box
		$("#wpgo_power_charts_cpt_js").text(sampleChartData.fixed);

	}

	// perform some custom tasks upon form submission
	$( "form#post" ).submit(function( event ) {

		// @todo don't really want to add this here but if I try to add it to updateFields() then, on page load, there are some strange side effects such as the form button looks like the form is submitting if you click anywhere on the admin page, which is undesirable.
		updateTitle();

		// for some reason we need to apply the text again once the 'Create Chart' button is clicked, otherwise the text reverts to 'Publish'
		$("input[type='submit']#publish").attr('value', 'Creating Chart...');

		// show the form submission spinner
		$("#pc-create-chart span.spinner").css('visibility', 'visible');
	});

	// update title
	function updateTitle() {
		// update chart title text
		var chartTypeText = $('input[name=wpgo_power_charts_cpt_type]:checked ~ .pc-type-txt').text();
		$("input[type='text']#title").attr('value', chartTypeText);
	}
});
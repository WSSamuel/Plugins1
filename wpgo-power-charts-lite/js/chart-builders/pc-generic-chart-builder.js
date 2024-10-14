/* Power Charts - Generic chart builder */

// Chart builder code common to all builders

var wpgo_pc_generic_chart_builder = function() {

	var $ = jQuery;

	var els = [
		{
			input: '#wpgo_power_charts_min_width',
			type: 'text',
			css_rule: 'min-width'
		},
		{
			input: '#wpgo_power_charts_max_width',
			type: 'text',
			css_rule: 'max-width'
		},
		{
			input: '#pc_chart_centered_chk',
			type: 'checkbox',
			css_rule: 'margin',
			css_value: '0 auto'
		}
	];

	// render chart on page load
	updateChart();

	// set legend offset input controls visibility on page load
	setLegendOffsetVisibility();

	// render chart preview
	function updateChart(){

		var fixedJS = document.querySelector('#wpgo_power_charts_cpt_js').value;
		var data = $("#wpgo_power_charts_cpt_data").val();
		//var series_num;

		// remove previous chart
		$(".wpgo-power-charts").empty();

		// update global chart data var - used when calling eval()
		window['pc_data_' + window.pcPostID] = data;

		// used for color picker visibility and construction of data series array
		window.pc_num_series = d3.csvParse(data).columns.length - 1;

		// Hide all data series color pickers by default, then display the ones we have data for
		$('div[id*="wpgo_power_charts_series_color_container_"]').css("display", "none");
		for (var i = 0; i < window.pc_num_series; i++) {
			$("#wpgo_power_charts_series_color_container_" + (i + 1)).css("display", "block");
		}

		// sync config data series color pickers when chart data/settings changes
		updateConfigColorPickerArray();

		// get chart config only after the data series color array has been updated
		var configJS = document.querySelector('#wpgo_power_charts_cpt_config_js').value;
		var d3ChartCode = '(function (){' + configJS + fixedJS;

		// re-evaluate chart code
		eval(d3ChartCode);
	}

	// re-render chart when 'Update' button clicked in 'Chart Data' meta box
	$("#wpgo_power_charts_cpt_update_data").click(function (e) {
			e.preventDefault();
			updateChart();
	});

	// update svg chart legend check box
	$('#pc_legend_status_chk').on('change', function() {

		// set legend offset input controls visibility when check box clicked
		setLegendOffsetVisibility();

		var newBool = this.checked ? 'true' : 'false';

		updateConfigBoolValue(newBool, 'var legendVisible =');
		updateChart();
	});

	// update chart legend offset
	$('#pc_legend_offset').on('input', function() {
		updateConfigNumberValue(this.value, 'var legendOffset =');
		updateChart();
	});

	// update svg chart title label directly
	$('#wpgo_power_charts_title_label').on('input', function() {

		// update chart title directly
		d3.select('.pc-labels-g .chart-label').text(this.value);

		// update config file text variable
		updateConfigTextValue(this.value, 'var chartTitle =');
	});

	// update svg x-axis chart label directly
	$('#wpgo_power_charts_x_axis_label').on('input', function() {
		d3.select('.pc-labels-g .x-axis-label').text(this.value);

		// update config file text variable
		updateConfigTextValue(this.value, 'var xLabel =');
	});

	// update svg y-axis chart label directly
	$('#wpgo_power_charts_y_axis_label').on('input', function() {
		d3.select('.pc-labels-g .y-axis-label').text(this.value);

		// update config file text variable
		updateConfigTextValue(this.value, 'var yLabel =');
	});

	// update margin
	$('input[id*="wpgo_power_charts_margin_"]').on('input', function() {
		updateConfigMargin();
	});

	// update aspect ratio
	$('#wpgo_power_charts_aspect_ratio').on('input', function() {
		//console.log('AR: ' + this.value);

		// update config file text variable
		updateConfigNumberValue(this.value, 'var aspectRatio =');
		updateChart();
	});

	// update chart area bg color directly
	$('#pc_chart_bg_color').wpColorPicker({
		change: function(event, ui){
			var new_col = ui.color.toString();
			// prefix selector with specific chart ID
			var sel = wpgo_pc_utility.prefix_css_selector('.pc-chart-bg-g .chart-area');
			var newCSS = updateSingleCSSValue(new_col, sel, 'fill');
			$('#wpgo-power-charts-admin-inline-css').html( newCSS.text() );
		}
	});

	// update chart svg bg color directly
	$('#pc_svg_bg_color').wpColorPicker({
		change: function(event, ui){
			var new_col = ui.color.toString();
			// prefix selector with specific chart ID
			var sel = wpgo_pc_utility.prefix_css_selector('.pc-svg-bg-g .svg-area');
			var newCSS = updateSingleCSSValue(new_col, sel, 'fill');
			$('#wpgo-power-charts-admin-inline-css').html( newCSS.text() );
		}
	});

	// update min chart width directly
	$('#wpgo_power_charts_min_width').on('input', function() {
		var newCSS = updateMultiCSSValue(els, wpgo_pc_utility.prefix_css_selector('.wpgo-power-charts'));
		$('#wpgo-power-charts-admin-inline-css').html( newCSS.text() );
		updateChart();
	});

	// update max chart width directly
	$('#wpgo_power_charts_max_width').on('input', function() {
		var newCSS = updateMultiCSSValue(els, wpgo_pc_utility.prefix_css_selector('.wpgo-power-charts'));
		$('#wpgo-power-charts-admin-inline-css').html( newCSS.text() );
		updateChart();
	});

	// update chart alignment check box
	$('#pc_chart_centered_chk').on('change', function() {
		var newCSS = updateMultiCSSValue(els, '.wpgo-power-charts');
		$('#wpgo-power-charts-admin-inline-css').html( newCSS.text() );
		updateChart();
	});

	$('input[id*="wpgo_power_charts_series_color"]').wpColorPicker({
		change: function(event, ui){
			var series_cp_num = event.target.id.substring(31);
			var new_col = ui.color.toString();

			$('.pc-svg rect.series' + series_cp_num).css( 'fill', new_col );
			updateConfigColorPickerArray();
		}
	});

	// UTILITY FUNCTIONS (@todo move to power-charts-admin-utility.js?)

	function setLegendOffsetVisibility() {
		var status = $('#pc_legend_status_chk').prop('checked');

		if(status) {
			$(".pc-control-container.legend").css("display", "flex");
		} else {
			$(".pc-control-container.legend").css("display", "none");
		}
	}

	function updateMultiCSSValue(el, css_sel) {
		var sel = $('#wpgo_power_charts_cpt_css');
		var txtArr = sel.text().split('\n');
		txtArr.forEach(function (item, i, arr) {
			if (item.includes(css_sel)) {

				var cssRules = '';
				el.forEach(function(itemj, j, arrj) {

					if(itemj.type === 'checkbox') { // get custom value for checkbox

						var status = $(itemj.input).prop('checked');
						if(status) {
							cssRules += itemj.css_rule + ': ' + itemj.css_value + '; ';
						}
					} else { // just use value from text box
						var val = $(itemj.input).val();
						//console.log(val);

						cssRules += itemj.css_rule + ': ' + val + '; ';
					}
				});
				arr[i] = css_sel + " { " + cssRules + " }";
			}
		});
		return sel.text(txtArr.join('\n'));
	}

	function updateSingleCSSValue(newVal, search_txt, cssRule) {
		//console.log(search_txt);
		var sel = $('#wpgo_power_charts_cpt_css');
		var txtArr = sel.text().split('\n');
		txtArr.forEach(function (item, i, arr) {
			if (item.includes(search_txt)) {
				arr[i] = search_txt + " { " + cssRule + ": " + newVal + "; }";
			}
		});
		return sel.text(txtArr.join('\n'));
	}

	function updateConfigColorPickerArray() {
		var search_txt = 'var seriesColors =';
		var sel = $('#wpgo_power_charts_cpt_config_js');
		var txtArr = sel.text().split('\n');
		txtArr.forEach(function (item, i, arr) {
			if (item.includes(search_txt)) {
				var seriesTxt = search_txt + " [";
				var comma = '';
				for (var j = 0; j < window.pc_num_series; j++) {
					comma = (j === (window.pc_num_series - 1)) ? "'];" : "', ";
					seriesTxt += "'" + $('#wpgo_power_charts_series_color_' + (j + 1)).val() + comma;
				}
				arr[i] = seriesTxt;
			}
		});
		sel.text(txtArr.join('\n'));
	}

	function updateConfigTextValue(newText, search_txt) {
		var sel = $('#wpgo_power_charts_cpt_config_js');
		var txtArr = sel.text().split('\n');
		txtArr.forEach(function (item, i, arr) {
			if (item.includes(search_txt)) {
				arr[i] = search_txt + " '" + newText + "';";
			}
		});
		sel.text(txtArr.join('\n'));
	}

	function updateConfigNumberValue(newNum, search_txt) {
		var sel = $('#wpgo_power_charts_cpt_config_js');
		var txtArr = sel.text().split('\n');
		txtArr.forEach(function (item, i, arr) {
			if (item.includes(search_txt)) {
				arr[i] = search_txt + " " + newNum + ";";
			}
		});
		sel.text(txtArr.join('\n'));
	}

	function updateConfigBoolValue(newBool, search_txt) {
		var sel = $('#wpgo_power_charts_cpt_config_js');
		var txtArr = sel.text().split('\n');
		txtArr.forEach(function (item, i, arr) {
			if (item.includes(search_txt)) {
				arr[i] = search_txt + " " + newBool + ";";
			}
		});
		sel.text(txtArr.join('\n'));
	}

	function updateConfigMargin() {
		var top = $('#wpgo_power_charts_margin_top').val();
		var right = $('#wpgo_power_charts_margin_right').val();
		var bottom = $('#wpgo_power_charts_margin_bottom').val();
		var left = $('#wpgo_power_charts_margin_left').val();
		var search_txt = 'var margin =';
		var sel = $('#wpgo_power_charts_cpt_config_js');
		var txtArr = sel.text().split('\n');

		txtArr.forEach(function (item, i, arr) {
			if (item.includes(search_txt)) {

				arr[i] = search_txt + " {top: " + top + ", right: " + right + ", bottom: " + bottom + ", left: " + left + "};";
			}
		});
		sel.text(txtArr.join('\n'));
		updateChart();
	}
};

/* Power Charts utility functions */

var wpgo_pc_utility = {

	prefix_css_selector: function(sel) {
		// prefix a css selector with a specific chart ID
		var space = ' ';
		if(sel === '.wpgo-power-charts') { space = ''; }
		return '.pc-' + window.pcPostID + space + sel;
	},
	populate_form_fields: function(sampleChartData, chartType) {

		var $ = jQuery;

		// Note, some fields associated with CSS are updated via build_config()

		// update chart data text box
		$("#wpgo_power_charts_cpt_data").text(sampleChartData.data);

		// update chart title text box
		$('#wpgo_power_charts_title_label').val(sampleChartData.title);

		// update chart x axis text box
		$('#wpgo_power_charts_x_axis_label').val(sampleChartData.xAxis);

		// update chart y axis text box
		$('#wpgo_power_charts_y_axis_label').val(sampleChartData.yAxis);

		// update chart margin top text box
		//  wpgo_power_charts_margin_top
		$('#wpgo_power_charts_margin_top').val(sampleChartData.margin.top);

		// update chart margin right text box
		$('#wpgo_power_charts_margin_right').val(sampleChartData.margin.right);

		// update chart margin bottom text box
		$('#wpgo_power_charts_margin_bottom').val(sampleChartData.margin.bottom);

		// update chart margin left text box
		$('#wpgo_power_charts_margin_left').val(sampleChartData.margin.left);

		// update chart aspect ratio text box
		$('#wpgo_power_charts_aspect_ratio').val(sampleChartData.aspectRatio);

		// update chart legend offset text box
		$('#pc_legend_offset').val(sampleChartData.legendOffset);

		// update chart min width text box
		$('#wpgo_power_charts_min_width').val(wpgo_pc_generic_settings.chart_width.min);

		// update chart max width text box
		$('#wpgo_power_charts_max_width').val(wpgo_pc_generic_settings.chart_width.max);

		// Enable display legend checkbox by default
		$('#pc_legend_status_chk').prop( "checked", true );

		// Enable center chart checkbox by default
		if(wpgo_pc_generic_settings.chart_margin === '0 auto') {
			$('#pc_chart_centered_chk').prop("checked", true);
		} else {
			$('#pc_chart_centered_chk').prop("checked", false);
		}
	},
	build_config: function(sampleChartData, chartType) {

		var $ = jQuery;

		// This function builds the config text and populates some form fields. i.e. the color picker inputs

		var colArrayStr = '[';
		sampleChartData.seriesColors.forEach(function(item, i) {

			// build color series array string (and don't add comma on last iteration)
			var comma = (i === sampleChartData.seriesColors.length - 1) ? "" : ", ";
			colArrayStr += "'" + item + "'" + comma;

			// add color value to color picker input element and make visible
			$('#wpgo_power_charts_series_color_' + (i + 1)).val(item);
			$('#wpgo_power_charts_series_color_container_' + (i + 1)).css('display','block');
		});
		colArrayStr += ']';
		//console.log(sampleChartData.seriesColors.length);

		// build the initial chart CSS
		var cssStr = '';
		sampleChartData.chart_css.forEach(function(item, i) {

			// prefix selector with specific chart ID
			cssStr += wpgo_pc_utility.prefix_css_selector(item.selector) + ' { ';
			item.css.forEach(function(item, i) {
				cssStr += item.rule + ': ' + item.value + '; ';
			});
			cssStr += ' }\n';

			// if we have an element name then add css value to relevant input element and make visible
			if(item.el !== '') {
				$(item.el).val(item.css[0].value);
			}
		});
		// add chart CSS code to meta box
		$("#wpgo_power_charts_cpt_css").text(cssStr);

		// get legend display status from checkbox value
		var legend_status = $('#pc_legend_status_chk').prop('checked') ? 'true' : 'false';

		var config = "// === CONFIG START ===\n" +
			"var seriesColors = " + colArrayStr + ";\n" +
			"var chartTitle = '" + sampleChartData.title + "';\n" +
			"var xLabel = '" + sampleChartData.xAxis + "';\n" +
			"var yLabel = '" + sampleChartData.yAxis + "';\n" +
			"var yFormat = 's';\n" +
			"var titleVisible = true;\n" +
			"var xLabelVisible = true;\n" +
			"var yLabelVisible = true;\n" +
			"var legendVisible = " + legend_status + ";\n" +
			"var chartEl = '.pc-" + window.pcPostID + "';\n" +
			"var aspectRatio = " + sampleChartData.aspectRatio + ";\n" +
			"var yTicks = 5;\n" +
			"var rectSize = 16;\n" +
			"var xLblOffset = 20;\n" +
			"var yLblOffset = 20;\n" +
			"var chartLblOffset = 10;\n" +
			"var legendOffset = " + sampleChartData.legendOffset + ";\n" +
			"var margin = {top: " + sampleChartData.margin.top + ", right: " + sampleChartData.margin.right + ", bottom: " + sampleChartData.margin.bottom + ", left: " + sampleChartData.margin.left + "};\n" +
			"var x0_padding = 0.1;\n" +
			"var x1_padding = 0.05;\n" +
			"var csv_data = pc_data_" + window.pcPostID + ";\n" +
			"// === CONFIG END ===\n";

		// update chart config textarea
		$('#wpgo_power_charts_cpt_config_js').text(config);
	},
	color_picker_visibility: function(sampleChartData, chartType) {
		// Not needed?
	}
};
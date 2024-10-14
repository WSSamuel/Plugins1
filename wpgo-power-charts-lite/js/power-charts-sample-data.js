/* Power Charts - Sample data */

var wpgo_pc_generic_settings = {
	chart_width: {
		min: '400px',
		max: '800px'
	},
	chart_margin: '0 auto' // i.e. centered
}

var wpgo_pc_sample_data = {
	column: {
		single:
			"Year,Sales\n" +
			"2012,145\n" +
			"2013,344\n" +
			"2014,250\n" +
			"2015,240\n" +
			"2016,280\n" +
			"2017,370",
		single1:
		"Month,Sales\n" +
		"Jan,145\n" +
		"Feb,344\n" +
		"March,250\n" +
		"April,240\n" +
		"2016,280\n" +
		"2017,370",
		grouped:
			"Movie Genres,Bob,Sally,Jane,Tim,Daniel,Sara,Tom\n" +
			"Action,27,44,21,38,10,88,41\n" +
			"Comedy,20,32,14,24,70,56,24\n" +
			"Horror,12,21,10,99,53,51,26\n" +
			"Sci-Fi,11,19,92,67,47,87,31\n" +
			"Romance,89,15,72,13,35,32,15\n" +
			"Drama,73,13,67,12,31,34,19",
		grouped2:
			"Year,Bob,Sue\n" +
			"2012,145,190\n" +
			"2013,344,250\n" +
			"2014,250,260\n" +
			"2015,240,190\n" +
			"2016,280,275\n" +
			"2017,370,400",
		grouped3: // slightly smaller set than 'grouped'
			"Movie Genres,Bob,Sally,Jane,Tim,Daniel\n" +
			"Action,27,44,21,38,50\n" +
			"Comedy,30,42,34,54,70\n" +
			"Horror,12,21,10,79,53\n" +
			"Sci-Fi,11,19,92,77,57\n" +
			"Romance,69,35,52,13,35\n" +
			"Drama,63,53,47,12,31"
	}
}

var wpgo_pc_css_settings = {
	grouped_column: [
		{
			el: '#pc_svg_bg_color',
			selector: '.pc-svg-bg-g .svg-area',
			css: [{	rule: 'fill', value: '#fff' }]
		},
		{
			el: '#pc_chart_bg_color',
			selector: '.pc-chart-bg-g .chart-area',
			css: [{	rule: 'fill', value: '#fff' }]
		},
		{
			el: '',
			selector: '.wpgo-power-charts',
			css: [
				{
					rule: 'min-width',
					value: wpgo_pc_generic_settings.chart_width.min
				},
				{
					rule: 'max-width',
					value: wpgo_pc_generic_settings.chart_width.max
				},
				{
					rule: 'margin',
					value: wpgo_pc_generic_settings.chart_margin
				}
			]
		}
	]
};

var wpgo_pc_fixed_settings = {
	grouped_column: "\n" +
	"  // chart vars\n" +
	"  var data, keys, svg, dim, w, h, cw, ch, x0, x1, y, z;\n" +
	"\n" +
	"  // convenience vars for better readability. keep this or just use the full config object?\n" +
	"  var lblTxt = {\n" +
	"        x: xLabel,\n" +
	"        y: yLabel,\n" +
	"        title: chartTitle\n" +
	"      },\n" +
	"      ar = aspectRatio,\n" +
	"      visibleEl = {\n" +
	"        chartLbl: titleVisible,\n" +
	"        xLbl: xLabelVisible,\n" +
	"        yLbl: yLabelVisible,\n" +
	"        legend: legendVisible,        \n" +
	"      },\n" +
	"      chartOffset = {\n" +
	"        chartLbl: chartLblOffset,\n" +
	"        xLbl: xLblOffset,\n" +
	"        yLbl: yLblOffset,\n" +
	"        legend: legendOffset,        \n" +
	"      };\n" +
	"\n" +
	"  var barsAttr = {\n" +
	"            x: function(d) { return x1(d.key); },\n" +
	"            y: function(d) { return y(d.value); },\n" +
	"            width: function () {return x1.bandwidth() },\n" +
	"            height: function(d) { return dim.ch - y(d.value); },\n" +
	"            fill: function(d) { return z(d.key); }\n" +
	"  };\n" +
	"\n" +
	"data = d3.csvParse(csv_data, function(d, i, columns) {\n" +
	"\n" +
	"for (var i = 1, n = columns.length; i < n; ++i) d[columns[i]] = +d[columns[i]];\n" +
	"  return d;\n" +
	"});\n" +
	"\n" +
	"init();\n" +
	"\n" +
	"  function init() {\n" +
	"    keys = data.columns.slice(1);\n" +
	"    fields = data.columns.slice();\n" +
	"    dim = pcChartDimensions(chartEl, ar, margin);\n" +
	"    svg = pcCreateSVG(chartEl, dim, margin);\n" +
	"    ranges();\n" +
	"    pcSetupVisibleElements(svg, dim, z, margin, visibleEl, fields);\n" +
	"    update(); // update chart\n" +
	"  }\n" +
	"\n" +
	"  function ranges() {\n" +
	"    // define scales / ranges\n" +
	"    x0 = d3.scaleBand().rangeRound([0, dim.cw]).paddingInner(x0_padding);\n" +
	"    x1 = d3.scaleBand().padding(x1_padding);\n" +
	"    y = d3.scaleLinear().rangeRound([dim.ch, 0]);\n" +
	"    z = d3.scaleOrdinal().range(seriesColors);\n" +
	"  }\n" +
	"\n" +
	"  function domains() {\n" +
	"    x0.domain(data.map(function(d) { return d[fields[0]]; }));\n" +
	"    x1.domain(keys).rangeRound([0, x0.bandwidth()]);\n" +
	"    y.domain([0, d3.max(data, function(d) {\n" +
	"    var res = d3.max(keys, function(key) {\n" +
	"        return d[key];\n" +
	"      })\n" +
	"      //console.log(d);\n" +
	"      //console.log(res);\n" +
	"\n" +
	"      return res;\n" +
	"    })]).nice();\n" +
	"\n" +
	"//console.log(d3.max(data, function(d) { return d3.max(keys, function(key) { return d[key]; }); }));\n" +
	"//console.log(data);\n" +
	"  }\n" +
	"\n" +
	"  function renderAxes() {\n" +
	"    svg.select('.x-axis') \n" +
	"        .attr(\"transform\", \"translate(0,\" + dim.ch + \")\")\n" +
	"        .call(d3.axisBottom(x0));\n" +
	"\n" +
	"    svg.select('.y-axis') \n" +
	"        .call(d3.axisLeft(y).ticks(yTicks, yFormat));\n" +
	"  }\n" +
	"\n" +
	"  // initial chart render, plus whenever data changes\n" +
	"  function update() {\n" +
	"\n" +
	"    domains();\n" +
	"\n" +
	"    // create bars\n" +
	"    svg.select('.pc-bars-g')\n" +
	"      .selectAll(\"g\")\n" +
	"      .data(data)\n" +
	"      .enter().append(\"g\")\n" +
	"        .attr(\"transform\", function(d) { return \"translate(\" + x0(d[fields[0]]) + \",0)\"; })\n" +
	"        .selectAll(\"rect\")\n" +
	"        .data(function(d) { return keys.map(function(key) { return {key: key, value: d[key]}; }); })\n" +
	"        .enter().append(\"rect\")\n" +
	"          .attr('class', function(d,i) { return 'series' + (i + 1); } )\n" +
	"          .attrs(barsAttr);\n" +
	"\n" +
	"    renderAxes();\n" +
	"\n" +
	"    // update axis labels, chart title, and legend\n" +
	"    pcUpdateVisibleElements(svg, visibleEl, keys, dim, chartOffset, z, lblTxt, margin, rectSize);\n" +
	"  }\n" +
	"\n" +
	"  // -------------------\n" +
	"  // Window resize event\n" +
	"  // -------------------\n" +
	"\n" +
	"  window.onresize = resize;\n" +
	"\n" +
	"  // rerender chart when browser window resized (i.e. no data has changed)\n" +
	"  function resize() {\n" +
	"\n" +
	"    dim = pcChartDimensions(chartEl, ar, margin);\n" +
	"    ranges();\n" +
	"    domains();\n" +
	"\n" +
	"    // update bars\n" +
	"    svg.selectAll('.pc-bars-g g')\n" +
	"      .attr(\"transform\", function(d) { return \"translate(\" + x0(d[fields[0]]) + \",0)\"; })\n" +
	"      .selectAll(\"rect\")\n" +
	"        .attr('class', function(d,i) { return 'series' + (i + 1); } )\n" +
	"        .attrs(barsAttr);\n" +
	"\n" +
	"    renderAxes();\n" +
	"\n" +
	"    // update axis labels, chart title, and legend\n" +
	"    pcResizeVisibleElements(svg, visibleEl, keys, dim, chartOffset, z, lblTxt, margin, rectSize);\n" +
	"  }\n" +
	"\n" +
	"  function formatData(d, i, columns) {\n" +
	"    for (var i = 1, n = columns.length; i < n; ++i) d[columns[i]] = +d[columns[i]];\n" +
	"    return d;\n" +
	"  }\n" +
	" })();"
}

var wpgo_pc_settings = {

	column: {
		data: wpgo_pc_sample_data.column.single,
		title: "Product Sales",
		xAxis: "Year",
		yAxis: "Sales",
		margin: { top: "75", right: "75", bottom: "55", left: "70" },
		legendOffset: 65,
		aspectRatio: 0.5,
		seriesColors: ['#8cd861', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6'],
		// for empty 'el' the element needs updating via populate_form_fields()
		chart_css: wpgo_pc_css_settings.grouped_column,
		fixed: wpgo_pc_fixed_settings.grouped_column
	},
	grouped_column: {
		data: wpgo_pc_sample_data.column.grouped,
		title: "Moviegoer Ratings",
		xAxis: "Movie Genres",
		yAxis: "Rating",
		margin: { top: "75", right: "75", bottom: "55", left: "70" },
		legendOffset: 65,
		aspectRatio: 0.5,
		seriesColors: ['#e4d6a7', '#e9b44c', '#bf5466', '#50a2a7', '#73ba9b', '#d0743c', '#ff8c00', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6', '#d6d6d6'],
		// for empty 'el' the element needs updating via populate_form_fields()
		chart_css: wpgo_pc_css_settings.grouped_column,
		fixed: wpgo_pc_fixed_settings.grouped_column
	}
};
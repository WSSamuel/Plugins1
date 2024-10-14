(function() {

	function set_shortcodes_atts( editor, atts ) {

		// nom fenetre
		var titreFenetre = !_.isUndefined( atts.nom ) ? atts.nom : 'Add shortcode';
		// balise du shortcode
		var balise = !_.isUndefined( atts.balise ) ? atts.balise : false;

		fn = function() {
			editor.windowManager.open( {
				title: titreFenetre,
				body: atts.body,
				onsubmit: function( e ) {
					var out = '[' + balise;
					for ( var attr in e.data ) {
						out += ' ' + attr + '="' + e.data[ attr ] + '"';
					}
					out += ']';
					editor.insertContent( out );
				},
			} );
		};
		return fn;
	}

	tinymce.PluginManager.add('kapsulegscript', function( editor, url ) {

		editor.addButton('kapsuleamaz_bouton', {
			icon: true,
			image: 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE2LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgd2lkdGg9IjE5NC4zMjhweCIgaGVpZ2h0PSIxOTQuMzI3cHgiIHZpZXdCb3g9IjAgMCAxOTQuMzI4IDE5NC4zMjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDE5NC4zMjggMTk0LjMyNzsiDQoJIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPHBhdGggZD0iTTEwNy42OTQsNi43NzJjMCwwLTQuODIyLDE2Ljk0LTUuNDI5LDE2LjU4MWMtMy4xNDgtMS45NjQtOC45NjYtMS43NzgtMTEuNjQ2LTAuMDU4DQoJCWMtMC40MTQtMC45NDctNC4wNTUtMTYuNjQyLTQuMDU1LTE2LjY0MnMtOC43MTcsMjIuNjQzLTYuODU2LDM0Ljc5M2MtMC4zNjIsMy41NDctMC41NjMsMTEuNTQyLDAuMTg2LDEzLjY2MQ0KCQljLTEuNDUyLTEuMDM1LTM0LjEzMi0yMS4xNzUtMzMuNTYzLTM2LjA4NGMtMzEuMDU4LDIuNTYzLTkzLjg2MSwxMjMuMzQ1LDE1LjMyNiwxNjguNjQ4Yy0xMS44NS0xOC43MDYtMTkuNC0zOC41MzMtMTguMDU4LTQ4LjIzOA0KCQljMi40MDUsMS43NzcsNy4xNzYsMTIuNDk0LDIwLjc3MSwxOS4zMDNjMC0zLjk4OSwyLjI4LTIyLjc5OSw3LjgxMi0yOC4zNTJjMi4xMzcsMy4xNjYsMjQuMDY4LDUxLjgzNywyNC4wNjgsNTEuODM3bDI0LjA2Ny01MS44MzcNCgkJYzAsMCw2LjQ2LDIyLjUwNiw0LjUxOCwyOC4wNTljMy4zNS0yLjA5NSwxNy43OC0xMS40MzYsMjEuMDU3LTE5LjAxYzAuOTUsMi45NDcsMC45NDMsMjcuNTQxLTE2LjUzOCw0OC4yMzgNCgkJYzI4LjQxMi0wLjAzNywxMTguMjA5LTEwMi4wOTgsMjAuNjY2LTE2OC44ODljLTEuOTMsOC4yNDItMzEuNTQ4LDM2LjEzOS0zNy4yMjksMzYuMTM5YzAuMDYxLTEuMjcyLDAuODM0LTguNjA3LDAtMTMuNDc2DQoJCUMxMTMuNjc5LDM5LjQ0MSwxMTAuNzYzLDE5LjM0NCwxMDcuNjk0LDYuNzcyeiIvPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=',
			text:'GothAmazon',
			type:'menubutton',
			menu: [
				{
					text: 'GTAMZ Store by Keyword 🔐',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: 'Keyword',
								name: 'title',
								type: 'textbox',
								tooltip: 'Enter your keyword here',
								value: '',
							},
							{
								label: 'Number of items',
								name: 'nono',
								type: 'listbox',
								values : [
			                        { text: '1', value: '1' },
			                        { text: '2', value: '2' },
			                        { text: '3', value: '3' },
									{ text: '4', value: '4' },
			                        { text: '5', value: '5' },
			                        { text: '6', value: '6' },
									{ text: '7', value: '7' },
			                        { text: '8', value: '8' },
			                        { text: '9', value: '9' },
									{ text: '10', value: '10' },
			                    ]
							},
							{
								label: ' 🔒 Price Min',
								name: '',
								disabled : 1,
								type: 'listbox',
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Price Max',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Categories',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
									{text: 'All Departments', value: '' }
			                    ]
							},
							{
								label: '🔒 Sort by',
								name: '',
								type: 'listbox',
								tooltip: 'What are the search criteria you want to use?',
								disabled : 1,
								values : [
									{ text: 'Default', value: '' },
			                    ]
							},
							{
								label: '🔒 Min Saving Percent',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'What is the minimum percentage reduction you require?',
								values : [
									{ text: 'No', value: '' },
			                    ]
							},
							{
								label: '🔒 Sellers',
								name: '',
								type: 'listbox',
								tooltip: 'Amazon only / All sellers',
								disabled : 1,
								values : [
									{ text: 'Default', value: '' },
			                    ]
							},
							{
								label: '🔒 Brand',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Type a brand name (optional) | eg : Sony',
								value: '',
							},
							{
								label: '🔒 Display Price',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'Display OR Hide Price',
								values : [
			                        { text: 'Défaut', value: 'defaut' },
			                    ]
							},
							{
								label: '🔒 Hide item title',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'Hide Amazon Title of item',
								values : [
									{ text: 'Defaut', value: 'defaut' },
			                    ]
							},	
							{
								label: '🔒 Number of items on Smartphone',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'Must be lower than computer version',
								values : [
									{ text: 'Défaut', value: 'defaut' },
			                    ]
							},
						],
						balise: 'boutique',
						nom: 'Mini Store by Keyword',
					} ),
				},
				{
					text: 'GTAMZ Spotlight by KW 🔐',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: 'Keyword',
								name: 'title',
								type: 'textbox',
								tooltip: 'Enter your keyword here',
								value: '',
							},
							{
								label: '🔒 Custom Title (Optional)',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Leave blank to use Amazon data title',
								value: '',
							},
							{
								label: '🔒 Custom Description (Optional)',
								name: '',
								type: 'textbox',
								multiline: true,
								disabled : 1,
								tooltip: 'Leave blank to use Amazon data description',
								value: '',
							},
							{
								label: '🔒 Categories',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
									{text: 'All Departments', value: '' }
			                    ]
							},
							{
								label: ' 🔒 Price Min',
								name: '',
								disabled : 1,
								type: 'listbox',
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Price Max',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Number of pics',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '4 (Defaut)', value: '' },
			                    ]
							},
							{
								label: '🔒 Sort by',
								name: '',
								type: 'listbox',
								tooltip: 'What are the search criteria you want to use?',
								disabled : 1,
								values : [
									{ text: 'Default', value: '' },
			                    ]
							},
							{
								label: '🔒 Sellers',
								name: '',
								type: 'listbox',
								tooltip: 'Amazon only / All sellers',
								disabled : 1,
								values : [
									{ text: 'Default', value: '' },
			                    ]
							},
							{
								label: '🔒 Brand',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Type a brand name (optional) | eg : Sony',
								value: '',
							},
							{
								label: '🔒 Min Saving Percent',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'What is the minimum percentage reduction you require?',
								values : [
									{ text: 'No', value: '' },
			                    ]
							},
							{
								label: '🔒 Display Price',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'Display OR Hide Price',
								values : [
			                        { text: 'Défaut', value: '' },
			                    ]
							},

						],
						balise: 'spotlightbyq',
						nom: 'Spotlight by Query',
					} ),
				},
				
			
				{
					text: 'GTAMZ Spotlight by ASIN 🔐',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: 'ASIN',
								name: 'asin',
								type: 'textbox',
								tooltip: 'Enter ASIN Amazon ID',
								value: '',
							},
							{
								label: '🔒 Custom Title (Optional)',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Leave blank to use Amazon data title',
								value: '',
							},
							{
								label: '🔒 Custom Description (Optional)',
								name: '',
								type: 'textbox',
								multiline: true,
								disabled : 1,
								tooltip: 'Leave blank to use Amazon data description',
								value: '',
							},
							{
								label: '🔒 Number of pics',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '4 (Defaut)', value: '' },
			                    ]
							},
							{
								label: '🔒 Parachute Keyword',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Enter the keyword that will be used if ASIN product is unavailable',
								value: '',
							},
							{
								label: '🔒 Parachute Categorie',
								name: '',
								disabled : 1,
								type: 'listbox',
								tooltip: 'Choose categorie that will be used if ASIN product is unavailable',
								values : [
									{value: 'All', text: 'All Departments' }
			                    ]
							},
							{
								label: '🔒 Parachute Price Min',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'Enter the Price Minimum that will be used if ASIN product is unavailable',
								values : [
			                        { text: '-', value: '1' },
			                    ]
							},
							{
								label: '🔒 Display Price',
								name: '',
								type: 'listbox',
								tooltip: 'Display OR Hide Price',
								disabled : 1,
								values : [
			                        { text: 'Défaut', value: '' },
			                    ]
							},
						],
						balise: 'gothasin',
						nom: 'Spotlight by ASIN',
					} ),
				},
				{
					text: 'GTAMZ InlineASIN Light 🔐',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: 'ASIN',
								name: 'asin',
								type: 'textbox',
								tooltip: 'Enter ASIN Amazon ID',
								value: '',
							},
							{
								label: 'Anchor link',
								name: 'ancre',
								type: 'textbox',
								tooltip: 'Anchor link',
								value: 'Click here',
							},
							{
								label: '🔒 Dynamic Price',
								name: '',
								type: 'listbox',
								tooltip: 'Add Price behind your anchor',
								disabled : 1,
								values : [
			                        { text: 'No', value: '' },
			                    ]
							},
							{
								label: '🔒 Image URL (option)',
								name: '',
								type: 'textbox',
								tooltip: 'Image URL (if you want a pics to anchor)',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Classe CSS CTA (option)',
								name: '',
								type: 'textbox',
								tooltip: 'Enter class here in order to style your CTA',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Parachute Keyword',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Enter the keyword that will be used if ASIN product is unavailable',
								value: '',
							},
							{
								label: '🔒 Parachute Categorie',
								name: '',
								disabled : 1,
								type: 'listbox',
								tooltip: 'Choose categorie that will be used if ASIN product is unavailable',
								values : [
									{value: 'All', text: 'All Departments' }
			                    ]
							},
							{
								label: '🔒 Parachute Price Min',
								name: '',
								type: 'listbox',
								tooltip: 'Enter the Price Minimum that will be used if ASIN product is unavailable',
								disabled : 1,
								values : [
			                        { text: '-', value: '1' },
			                    ]
							},
							
						],
						balise: 'inlineASIN',
						nom: 'Display Text Backlink with ASIN',
					} ),
				},
								{
					text: '🔒 GTAMZ Inline by KW 🔒',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: '🔒 Keyword',
								name: '',
								type: 'textbox',
								tooltip: 'Enter your keyword here',
								disabled : 1,
								value: 'keyword',
							},
							{
								label: '🔒 Anchor link',
								name: '',
								type: 'textbox',
								tooltip: 'Anchor link',
								disabled : 1,
								value: 'Cliquez Ici',
							},
							{
								label: '🔒 Dynamic Price',
								name: '',
								type: 'listbox',
								tooltip: 'Add Price behind your anchor',
								disabled : 1,
								values : [
			                        { text: 'No', value: '' },
			                    ]
							},
							{
								label: '🔒 Image URL (option)',
								name: '',
								type: 'textbox',
								tooltip: 'Image URL (if you want a pics to anchor)',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Classe CSS CTA (option)',
								name: '',
								type: 'textbox',
								tooltip: 'Enter class here in order to style your CTA',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Price Min',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Categories',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
									{text: 'All Departments', value: 'All' }
			                    ]
							},					
							{
								label: '🔒 Sort by',
								name: '',
								type: 'listbox',
								tooltip: 'What are the search criteria you want to use?',
								disabled : 1,
								values : [
									{text: 'Défaut', value: ''},
			                    ]
							},
							{
								label: '🔒 Sellers',
								name: '',
								type: 'listbox',
								tooltip: 'Amazon only / All sellers',
								disabled : 1,
								values : [
									{ text: 'Défaut', value: '' },
			                    ]
							},
							{
								label: '🔒 Brand',
								name: '',
								type: 'textbox',
								tooltip: 'Type a brand name (optional) | eg : Sony',
								disabled : 1,
								value: '',
							},							
						],
						balise: '',
						nom: 'Display Text Backlink with Keyword',
					} ),
				},
			]
		});
	});

})();
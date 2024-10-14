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
					text: '⭐ GTAMZ Store by Keyword',
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
								label: 'Number of articles',
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
								label: '⭐ Price Min',
								name: 'prixmin',
								type: 'listbox',
								values : [
			                        { text: '-', value: '1' },
			                        { text: '10 $', value: '1000' },
			                        { text: '20 $', value: '2000' },
									{ text: '30 $', value: '3000' },
			                        { text: '40 $', value: '4000' },
			                        { text: '50 $', value: '5000' },
									{ text: '100 $', value: '10000' },
			                        { text: '150 $', value: '15000' },
			                        { text: '200 $', value: '20000' },
									{ text: '250 $', value: '25000' },
			                        { text: '500 $', value: '50000' },
			                        { text: '1000 $', value: '100000' },
			                    ]
							},
							{
								label: '⭐ Price Max',
								name: 'prixmax',
								type: 'listbox',
								values : [
			                        { text: '-', value: '1000000' },
			                        { text: '10 $', value: '1000' },
			                        { text: '20 $', value: '2000' },
									{ text: '30 $', value: '3000' },
			                        { text: '40 $', value: '4000' },
			                        { text: '50 $', value: '5000' },
									{ text: '100 $', value: '10000' },
			                        { text: '150 $', value: '15000' },
			                        { text: '200 $', value: '20000' },
									{ text: '250 $', value: '25000' },
			                        { text: '500 $', value: '50000' },
			                        { text: '1000 $', value: '100000' },
			                    ]
							},
							{
								label: '⭐ Categories',
								name: 'cat',
								type: 'listbox',
								values : [
									{value: 'All', text: 'All Departments' },{value: 'AmazonVideo', text: 'Prime Video' },{value: 'Apparel', text: 'Clothing & Accessories' },{value: 'Appliances', text: 'Appliances' },{value: 'ArtsAndCrafts', text: 'Arts, Crafts & Sewing' },{value: 'Automotive', text: 'Automotive Parts & Accessories' },{value: 'Baby', text: 'Baby' },{value: 'Beauty', text: 'Beauty & Personal Care' },{value: 'Books', text: 'Books' },{value: 'Classical', text: 'Classical' },{value: 'Collectibles', text: 'Collectibles & Fine Art' },{value: 'Computers', text: 'Computers' },{value: 'DigitalMusic', text: 'Digital Music' },{value: 'DigitalEducationalResources', text: 'Digital Educational Resources' },{value: 'Electronics', text: 'Electronics' },{value: 'EverythingElse', text: 'Everything Else' },{value: 'Fashion', text: 'Clothing, Shoes & Jewelry' },{value: 'FashionBaby', text: 'Clothing, Shoes & Jewelry Baby' },{value: 'FashionBoys', text: 'Clothing, Shoes & Jewelry Boys' },{value: 'FashionGirls', text: 'Clothing, Shoes & Jewelry Girls' },{value: 'FashionMen', text: 'Clothing, Shoes & Jewelry Men' },{value: 'FashionWomen', text: 'Clothing, Shoes & Jewelry Women' },{value: 'GardenAndOutdoor', text: 'Garden & Outdoor' },{value: 'GiftCards', text: 'Gift Cards' },{value: 'GroceryAndGourmetFood', text: 'Grocery & Gourmet Food' },{value: 'Handmade', text: 'Handmade' },{value: 'HealthPersonalCare', text: 'Health, Household & Baby Care' },{value: 'HomeAndKitchen', text: 'Home & Kitchen' },{value: 'Industrial', text: 'Industrial & Scientific' },{value: 'Jewelry', text: 'Jewelry' },{value: 'KindleStore', text: 'Kindle Store' },{value: 'LocalServices', text: 'Home & Business Services' },{value: 'Luggage', text: 'Luggage & Travel Gear' },{value: 'LuxuryBeauty', text: 'Luxury Beauty' },{value: 'Magazines', text: 'Magazine Subscriptions' },{value: 'MobileAndAccessories', text: 'Cell Phones & Accessories' },{value: 'MobileApps', text: 'Apps & Games' },{value: 'MoviesAndTV', text: 'Movies & TV' },{value: 'Music', text: 'CDs & Vinyl' },{value: 'MusicalInstruments', text: 'Musical Instruments' },{value: 'OfficeProducts', text: 'Office Products' },{value: 'PetSupplies', text: 'Pet Supplies' },{value: 'Photo', text: 'Camera & Photo' },{value: 'Shoes', text: 'Shoes' },{value: 'Software', text: 'Software' },{value: 'SportsAndOutdoors', text: 'Sports & Outdoors' },{value: 'ToolsAndHomeImprovement', text: 'Tools & Home Improvement' },{value: 'ToysAndGames', text: 'Toys & Games' },{value: 'VHS', text: 'VHS' },{value: 'VideoGames', text: 'Video Games' },{value: 'Watches', text: 'Watches'}
			                    ]
							},
							{
								label: '⭐ Sort by',
								name: 'sort',
								type: 'listbox',
								tooltip: 'What are the search criteria you want to use?',
								values : [
									{ text: 'Default', value: '' },
			                        { text: 'Relevance', value: 'Relevance' },
			                        { text: 'AvgCustomerReviews', value: 'AvgCustomerReviews' },
			                        { text: 'Featured', value: 'Featured' },
									{ text: 'Newest arrivals', value: 'NewestArrivals' },
			                        { text: 'Price High 2 Low', value: 'Price:HighToLow' },
			                        { text: 'Price Low 2 High', value: 'Price:LowToHigh' },
			                    ]
							},
							{
								label: '⭐ Min Saving Percent',
								name: 'economiemin',
								type: 'listbox',
								tooltip: 'What is the minimum percentage reduction you require?',
								values : [
									{ text: 'No', value: '' },
			                        { text: 'Yes (-5%)', value: '5' },
			                        { text: '-10%', value: '10' },
			                        { text: '-15%', value: '15' },
									{ text: '-20%', value: '20' },
			                        { text: '-25%', value: '25' },
			                        { text: '-30%', value: '30' },
									{ text: '-40%', value: '40' },
									{ text: '-50%', value: '50' },
									{ text: '-60%', value: '60' },
			                    ]
							},
							{
								label: '⭐ Sellers',
								name: 'vendeur',
								type: 'listbox',
								tooltip: 'Amazon only / All sellers',
								values : [
									{ text: 'Default', value: '' },
			                        { text: 'All Sellers', value: 'All' },
			                        { text: 'Amazon Only', value: 'Amazon' },
			                    ]
							},
							{
								label: '⭐ Brand',
								name: 'marque',
								type: 'textbox',
								tooltip: 'Type a brand name (optional) | eg : Sony',
								value: '',
							},
							{
								label: '⭐ Display Price',
								name: 'boodisplayprice',
								tooltip: 'Display OR Hide Price',
								type: 'listbox',
								values : [
			                        { text: 'Défaut', value: 'defaut' },
			                        { text: 'Yes', value: 'oui' },
									{ text: 'No', value: 'non' },
			                    ]
							},
							{
								label: '⭐ Hide item title',
								name: 'hidetitre',
								type: 'listbox',
								tooltip: 'Hide Amazon Title of item',
								values : [
									{ text: 'Defaut', value: 'defaut' },
			                        { text: 'Yes', value: 'oui' },
			                        { text: 'No', value: 'non' },
			                    ]
							},	
							{
								label: '⭐ Number of items on Smartphone',
								name: 'smartitem4mobile',
								type: 'listbox',
								tooltip: 'Must be lower than computer version',
								values : [
									{ text: 'Défaut', value: 'defaut' },
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
								label: '⭐ Force API',
								name: 'force_api',
								type: 'textbox',
								tooltip: 'Priorize other API',
								value: '',
							},
							{
								label: '👽 Inclusion (Big Feed)',
								name: 'inclusion',
								type: 'textbox',
								tooltip: 'merchants requested (separated by a comma)',
								value: '',
							},
							{
								label: '👽 Exclusion (Big Feed)',
								name: 'exclusion',
								type: 'textbox',
								tooltip: 'excluded merchant (only 1)',
								value: '',
							},
							{
								label: '👽 Negative Keywords',
								name: 'nkw',
								type: 'textbox',
								tooltip: 'Negative keywords separated by a comma',
								value: '',
							},
							{
								label: '👽 Search by Cat',
								name: 'target_cat_deep',
								type: 'listbox',
								tooltip: 'Category Deep',
								values : [
									{ text: 'No', value: '' },
			                        { text: '1', value: '1' },
			                        { text: '2', value: '2' },
			                        { text: '3', value: '3' },
									{ text: '4', value: '4' },
			                    ]
							},
							
						],
						balise: 'boutique',
						nom: 'Mini Store by Keyword',
					} ),
				},
				{
					text: '⭐ GTAMZ Spotlight by KW',
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
								label: '⭐ Custom Title (Option)',
								name: 'titremano',
								type: 'textbox',
								tooltip: 'Leave blank to use Amazon data',
								value: '',
							},
							{
								label: '⭐ Custom Description (Option)',
								name: 'descriptionmano',
								type: 'textbox',
								multiline: true,
								tooltip: 'Leave blank to use Amazon data',
								value: '',
							},
							{
								label: '⭐ Price Min',
								name: 'prixmin',
								type: 'listbox',
								values : [
			                        { text: '-', value: '1' },
			                        { text: '10 $', value: '1000' },
			                        { text: '20 $', value: '2000' },
									{ text: '30 $', value: '3000' },
			                        { text: '40 $', value: '4000' },
			                        { text: '50 $', value: '5000' },
									{ text: '100 $', value: '10000' },
			                        { text: '150 $', value: '15000' },
			                        { text: '200 $', value: '20000' },
									{ text: '250 $', value: '25000' },
			                        { text: '500 $', value: '50000' },
			                        { text: '1000 $', value: '100000' },
			                    ]
							},
							{
								label: '⭐ Price Max',
								name: 'prixmax',
								type: 'listbox',
								values : [
			                        { text: '-', value: '1000000' },
			                        { text: '10 $', value: '1000' },
			                        { text: '20 $', value: '2000' },
									{ text: '30 $', value: '3000' },
			                        { text: '40 $', value: '4000' },
			                        { text: '50 $', value: '5000' },
									{ text: '100 $', value: '10000' },
			                        { text: '150 $', value: '15000' },
			                        { text: '200 $', value: '20000' },
									{ text: '250 $', value: '25000' },
			                        { text: '500 $', value: '50000' },
			                        { text: '1000 $', value: '100000' },
			                    ]
							},
							{
								label: '⭐ Categories',
								name: 'cat',
								type: 'listbox',
								values : [
									{value: 'All', text: 'All Departments' },{value: 'AmazonVideo', text: 'Prime Video' },{value: 'Apparel', text: 'Clothing & Accessories' },{value: 'Appliances', text: 'Appliances' },{value: 'ArtsAndCrafts', text: 'Arts, Crafts & Sewing' },{value: 'Automotive', text: 'Automotive Parts & Accessories' },{value: 'Baby', text: 'Baby' },{value: 'Beauty', text: 'Beauty & Personal Care' },{value: 'Books', text: 'Books' },{value: 'Classical', text: 'Classical' },{value: 'Collectibles', text: 'Collectibles & Fine Art' },{value: 'Computers', text: 'Computers' },{value: 'DigitalMusic', text: 'Digital Music' },{value: 'DigitalEducationalResources', text: 'Digital Educational Resources' },{value: 'Electronics', text: 'Electronics' },{value: 'EverythingElse', text: 'Everything Else' },{value: 'Fashion', text: 'Clothing, Shoes & Jewelry' },{value: 'FashionBaby', text: 'Clothing, Shoes & Jewelry Baby' },{value: 'FashionBoys', text: 'Clothing, Shoes & Jewelry Boys' },{value: 'FashionGirls', text: 'Clothing, Shoes & Jewelry Girls' },{value: 'FashionMen', text: 'Clothing, Shoes & Jewelry Men' },{value: 'FashionWomen', text: 'Clothing, Shoes & Jewelry Women' },{value: 'GardenAndOutdoor', text: 'Garden & Outdoor' },{value: 'GiftCards', text: 'Gift Cards' },{value: 'GroceryAndGourmetFood', text: 'Grocery & Gourmet Food' },{value: 'Handmade', text: 'Handmade' },{value: 'HealthPersonalCare', text: 'Health, Household & Baby Care' },{value: 'HomeAndKitchen', text: 'Home & Kitchen' },{value: 'Industrial', text: 'Industrial & Scientific' },{value: 'Jewelry', text: 'Jewelry' },{value: 'KindleStore', text: 'Kindle Store' },{value: 'LocalServices', text: 'Home & Business Services' },{value: 'Luggage', text: 'Luggage & Travel Gear' },{value: 'LuxuryBeauty', text: 'Luxury Beauty' },{value: 'Magazines', text: 'Magazine Subscriptions' },{value: 'MobileAndAccessories', text: 'Cell Phones & Accessories' },{value: 'MobileApps', text: 'Apps & Games' },{value: 'MoviesAndTV', text: 'Movies & TV' },{value: 'Music', text: 'CDs & Vinyl' },{value: 'MusicalInstruments', text: 'Musical Instruments' },{value: 'OfficeProducts', text: 'Office Products' },{value: 'PetSupplies', text: 'Pet Supplies' },{value: 'Photo', text: 'Camera & Photo' },{value: 'Shoes', text: 'Shoes' },{value: 'Software', text: 'Software' },{value: 'SportsAndOutdoors', text: 'Sports & Outdoors' },{value: 'ToolsAndHomeImprovement', text: 'Tools & Home Improvement' },{value: 'ToysAndGames', text: 'Toys & Games' },{value: 'VHS', text: 'VHS' },{value: 'VideoGames', text: 'Video Games' },{value: 'Watches', text: 'Watches'}
			                    ]
							},
							{
								label: '⭐ Sort by',
								name: 'sort',
								type: 'listbox',
								tooltip: 'What are the search criteria you want to use?',
								values : [
									{ text: 'Default', value: '' },
			                        { text: 'Relevance', value: 'Relevance' },
			                        { text: 'AvgCustomerReviews', value: 'AvgCustomerReviews' },
			                        { text: 'Featured', value: 'Featured' },
									{ text: 'Newest arrivals', value: 'NewestArrivals' },
			                        { text: 'Price High 2 Low', value: 'Price:HighToLow' },
			                        { text: 'Price Low 2 High', value: 'Price:LowToHigh' },
			                    ]
							},
							{
								label: '⭐ Min Saving Percent',
								name: 'economiemin',
								type: 'listbox',
								tooltip: 'What is the minimum percentage reduction you require?',
								values : [
									{ text: 'No', value: '' },
			                        { text: 'Yes (-5%)', value: '5' },
			                        { text: '-10%', value: '10' },
			                        { text: '-15%', value: '15' },
									{ text: '-20%', value: '20' },
			                        { text: '-25%', value: '25' },
			                        { text: '-30%', value: '30' },
									{ text: '-40%', value: '40' },
									{ text: '-50%', value: '50' },
									{ text: '-60%', value: '60' },
			                    ]
							},
							{
								label: '⭐ Sellers',
								name: 'vendeur',
								type: 'listbox',
								tooltip: 'Amazon only / All sellers',
								values : [
									{ text: 'Default', value: '' },
			                        { text: 'All Sellers', value: 'All' },
			                        { text: 'Amazon Only', value: 'Amazon' },
			                    ]
							},
							{
								label: '⭐ Brand',
								name: 'marque',
								type: 'textbox',
								tooltip: 'Type a brand name (optional) | eg : Sony',
								value: '',
							},
							{
								label: '⭐ Number of pics',
								name: 'force1pic',
								type: 'listbox',
								values : [
			                        { text: '4 (Defaut)', value: '' },
			                        { text: '1', value: 'oui' },
			                    ]
							},
							{
								label: '⭐ Display Price',
								name: 'boodisplayprice',
								type: 'listbox',
								tooltip: 'Display OR Hide Price',
								values : [
			                        { text: 'Défaut', value: 'defaut' },
			                        { text: 'Yes', value: 'oui' },
									{ text: 'No', value: 'non' },
			                    ]
							},
							{
								label: '⭐ Force API',
								name: 'force_api',
								type: 'textbox',
								tooltip: 'Priorize other API',
								value: '',
							},
							{
								label: '👽 Inclusion (Big Feed)',
								name: 'inclusion',
								type: 'textbox',
								tooltip: 'merchants requested (separated by a comma)',
								value: '',
							},
							{
								label: '👽 Exclusion (Big Feed)',
								name: 'exclusion',
								type: 'textbox',
								tooltip: 'excluded merchant (only 1)',
								value: '',
							},
							{
								label: '👽 Negative Keywords',
								name: 'nkw',
								type: 'textbox',
								tooltip: 'Negative keywords separated by a comma',
								value: '',
							},
						],
						balise: 'spotlightbyq',
						nom: 'Spotlight by Query',
					} ),
				},
				{
					text: '⭐ GTAMZ Spotlight by ASIN',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: 'ASIN',
								name: 'asin',
								type: 'textbox',
								tooltip: 'Saisir ASIN Amazon',
								value: '',
							},
							{
								label: '⭐ Custom Title (Option)',
								name: 'titremano',
								type: 'textbox',
								tooltip: 'Leave blank to use Amazon data',
								value: '',
							},
							{
								label: '⭐ Custom Description (Option)',
								name: 'descriptionmano',
								type: 'textbox',
								multiline: true,
								tooltip: 'Leave blank to use Amazon data',
								value: '',
							},
							{
								label: '⭐ Number of pics',
								name: 'force1pic',
								type: 'listbox',
								values : [
			                        { text: '4 (Defaut)', value: '' },
			                        { text: '1', value: 'oui' },
			                    ]
							},
							{
								label: '⭐ Parachute Keyword',
								name: 'parachutekw',
								type: 'textbox',
								tooltip: 'Enter the keyword that will be used if ASIN product is unavailable',
								value: '',
							},
							{
								label: '⭐ Parachute Categorie',
								name: 'cat',
								type: 'listbox',
								tooltip: 'Choose categorie that will be used if ASIN product is unavailable',
								values : [
									{value: 'All', text: 'All Departments' },{value: 'AmazonVideo', text: 'Prime Video' },{value: 'Apparel', text: 'Clothing & Accessories' },{value: 'Appliances', text: 'Appliances' },{value: 'ArtsAndCrafts', text: 'Arts, Crafts & Sewing' },{value: 'Automotive', text: 'Automotive Parts & Accessories' },{value: 'Baby', text: 'Baby' },{value: 'Beauty', text: 'Beauty & Personal Care' },{value: 'Books', text: 'Books' },{value: 'Classical', text: 'Classical' },{value: 'Collectibles', text: 'Collectibles & Fine Art' },{value: 'Computers', text: 'Computers' },{value: 'DigitalMusic', text: 'Digital Music' },{value: 'DigitalEducationalResources', text: 'Digital Educational Resources' },{value: 'Electronics', text: 'Electronics' },{value: 'EverythingElse', text: 'Everything Else' },{value: 'Fashion', text: 'Clothing, Shoes & Jewelry' },{value: 'FashionBaby', text: 'Clothing, Shoes & Jewelry Baby' },{value: 'FashionBoys', text: 'Clothing, Shoes & Jewelry Boys' },{value: 'FashionGirls', text: 'Clothing, Shoes & Jewelry Girls' },{value: 'FashionMen', text: 'Clothing, Shoes & Jewelry Men' },{value: 'FashionWomen', text: 'Clothing, Shoes & Jewelry Women' },{value: 'GardenAndOutdoor', text: 'Garden & Outdoor' },{value: 'GiftCards', text: 'Gift Cards' },{value: 'GroceryAndGourmetFood', text: 'Grocery & Gourmet Food' },{value: 'Handmade', text: 'Handmade' },{value: 'HealthPersonalCare', text: 'Health, Household & Baby Care' },{value: 'HomeAndKitchen', text: 'Home & Kitchen' },{value: 'Industrial', text: 'Industrial & Scientific' },{value: 'Jewelry', text: 'Jewelry' },{value: 'KindleStore', text: 'Kindle Store' },{value: 'LocalServices', text: 'Home & Business Services' },{value: 'Luggage', text: 'Luggage & Travel Gear' },{value: 'LuxuryBeauty', text: 'Luxury Beauty' },{value: 'Magazines', text: 'Magazine Subscriptions' },{value: 'MobileAndAccessories', text: 'Cell Phones & Accessories' },{value: 'MobileApps', text: 'Apps & Games' },{value: 'MoviesAndTV', text: 'Movies & TV' },{value: 'Music', text: 'CDs & Vinyl' },{value: 'MusicalInstruments', text: 'Musical Instruments' },{value: 'OfficeProducts', text: 'Office Products' },{value: 'PetSupplies', text: 'Pet Supplies' },{value: 'Photo', text: 'Camera & Photo' },{value: 'Shoes', text: 'Shoes' },{value: 'Software', text: 'Software' },{value: 'SportsAndOutdoors', text: 'Sports & Outdoors' },{value: 'ToolsAndHomeImprovement', text: 'Tools & Home Improvement' },{value: 'ToysAndGames', text: 'Toys & Games' },{value: 'VHS', text: 'VHS' },{value: 'VideoGames', text: 'Video Games' },{value: 'Watches', text: 'Watches'}
			                    ]
							},
							{
								label: '⭐ Parachute Price Min',
								name: 'prixmin',
								type: 'listbox',
								tooltip: 'Enter the Price Minimum that will be used if ASIN product is unavailable',
								values : [
			                        { text: '-', value: '1' },
			                        { text: '10 $', value: '1000' },
			                        { text: '20 $', value: '2000' },
									{ text: '30 $', value: '3000' },
			                        { text: '40 $', value: '4000' },
			                        { text: '50 $', value: '5000' },
									{ text: '100 $', value: '10000' },
			                        { text: '150 $', value: '15000' },
			                        { text: '200 $', value: '20000' },
									{ text: '250 $', value: '25000' },
			                        { text: '500 $', value: '50000' },
			                        { text: '1000 $', value: '100000' },
			                    ]
							},
							{
								label: '⭐ Display Price',
								name: 'boodisplayprice',
								type: 'listbox',
								tooltip: 'Display OR Hide Price',
								values : [
			                        { text: 'Défaut', value: 'defaut' },
			                        { text: 'Yes', value: 'oui' },
									{ text: 'No', value: 'non' },
			                    ]
							},
						],
						balise: 'gothasin',
						nom: 'Spotlight by ASIN',
					} ),
				},
				
					{
					text: '⭐ GTAMZ Inline by ASIN PREMIUM',
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
								label: 'Anchor Link',
								name: 'ancre',
								type: 'textbox',
								tooltip: 'Anchor Link',
								value: 'Click Here',
							},
							{
								label: '⭐ Dynamic Price',
								name: 'inlineprice',
								type: 'listbox',
								tooltip: 'Add Price behind your anchor',
								values : [
			                        { text: 'No', value: 'non' },
			                        { text: 'Yes', value: 'oui' },
			                    ]
							},
							{
								label: '⭐ Image URL(optional)',
								name: 'image_anchor_url',
								type: 'textbox',
								tooltip: 'Image URL (if you want a pics to anchor)',
								value: '',
							},
							{
								label: '⭐ Class CSS CTA (optional)',
								name: 'classcsscta',
								type: 'textbox',
								tooltip: 'Enter class here in order to style your CTA',
								value: '',
							},
							{
								label: '⭐ Parachute Keyword',
								name: 'inlinekw',
								type: 'textbox',
								tooltip: 'Enter the keyword that will be used if ASIN product is unavailable',
								value: '',
							},
							{
								label: '⭐ Parachute Price Min',
								name: 'prixmin',
								tooltip: 'Enter the Price Minimum that will be used if ASIN product is unavailable',
								type: 'listbox',
								values : [
			                        { text: '-', value: '1' },
			                        { text: '10 $', value: '1000' },
			                        { text: '20 $', value: '2000' },
									{ text: '30 $', value: '3000' },
			                        { text: '40 $', value: '4000' },
			                        { text: '50 $', value: '5000' },
									{ text: '100 $', value: '10000' },
			                        { text: '150 $', value: '15000' },
			                        { text: '200 $', value: '20000' },
									{ text: '250 $', value: '25000' },
			                        { text: '500 $', value: '50000' },
			                        { text: '1000 $', value: '100000' },
			                    ]
							},
							{
								label: '⭐ Smart Category',
								name: 'cat',
								type: 'listbox',
								tooltip: 'Choose categorie that will be used if ASIN product is unavailable',
								values : [
									{value: 'All', text: 'All Departments' },{value: 'AmazonVideo', text: 'Prime Video' },{value: 'Apparel', text: 'Clothing & Accessories' },{value: 'Appliances', text: 'Appliances' },{value: 'ArtsAndCrafts', text: 'Arts, Crafts & Sewing' },{value: 'Automotive', text: 'Automotive Parts & Accessories' },{value: 'Baby', text: 'Baby' },{value: 'Beauty', text: 'Beauty & Personal Care' },{value: 'Books', text: 'Books' },{value: 'Classical', text: 'Classical' },{value: 'Collectibles', text: 'Collectibles & Fine Art' },{value: 'Computers', text: 'Computers' },{value: 'DigitalMusic', text: 'Digital Music' },{value: 'DigitalEducationalResources', text: 'Digital Educational Resources' },{value: 'Electronics', text: 'Electronics' },{value: 'EverythingElse', text: 'Everything Else' },{value: 'Fashion', text: 'Clothing, Shoes & Jewelry' },{value: 'FashionBaby', text: 'Clothing, Shoes & Jewelry Baby' },{value: 'FashionBoys', text: 'Clothing, Shoes & Jewelry Boys' },{value: 'FashionGirls', text: 'Clothing, Shoes & Jewelry Girls' },{value: 'FashionMen', text: 'Clothing, Shoes & Jewelry Men' },{value: 'FashionWomen', text: 'Clothing, Shoes & Jewelry Women' },{value: 'GardenAndOutdoor', text: 'Garden & Outdoor' },{value: 'GiftCards', text: 'Gift Cards' },{value: 'GroceryAndGourmetFood', text: 'Grocery & Gourmet Food' },{value: 'Handmade', text: 'Handmade' },{value: 'HealthPersonalCare', text: 'Health, Household & Baby Care' },{value: 'HomeAndKitchen', text: 'Home & Kitchen' },{value: 'Industrial', text: 'Industrial & Scientific' },{value: 'Jewelry', text: 'Jewelry' },{value: 'KindleStore', text: 'Kindle Store' },{value: 'LocalServices', text: 'Home & Business Services' },{value: 'Luggage', text: 'Luggage & Travel Gear' },{value: 'LuxuryBeauty', text: 'Luxury Beauty' },{value: 'Magazines', text: 'Magazine Subscriptions' },{value: 'MobileAndAccessories', text: 'Cell Phones & Accessories' },{value: 'MobileApps', text: 'Apps & Games' },{value: 'MoviesAndTV', text: 'Movies & TV' },{value: 'Music', text: 'CDs & Vinyl' },{value: 'MusicalInstruments', text: 'Musical Instruments' },{value: 'OfficeProducts', text: 'Office Products' },{value: 'PetSupplies', text: 'Pet Supplies' },{value: 'Photo', text: 'Camera & Photo' },{value: 'Shoes', text: 'Shoes' },{value: 'Software', text: 'Software' },{value: 'SportsAndOutdoors', text: 'Sports & Outdoors' },{value: 'ToolsAndHomeImprovement', text: 'Tools & Home Improvement' },{value: 'ToysAndGames', text: 'Toys & Games' },{value: 'VHS', text: 'VHS' },{value: 'VideoGames', text: 'Video Games' },{value: 'Watches', text: 'Watches'}
			                    ]
							}
							
						],
						balise: 'inlineASIN',
						nom: 'Display Text Backlink with ASIN',
					} ),
				},
				{
					text: '⭐ GTAMZ Inline by KW',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: '⭐ Keyword',
								name: 'inlinekw',
								type: 'textbox',
								tooltip: 'Enter your keyword here',
								value: 'keyword',
							},
							{
								label: '⭐ Anchor link',
								name: 'ancre',
								type: 'textbox',
								tooltip: 'Anchor link',
								value: 'Click Here',
							},
							{
								label: '⭐ Dynamic Price',
								name: 'inlineprice',
								type: 'listbox',
								tooltip: 'Add Price behind your anchor',
								values : [
			                        { text: 'No', value: 'non' },
			                        { text: 'Yes', value: 'oui' },
			                    ]
							},
							{
								label: '⭐ Image URL (option)',
								name: 'image_anchor_url',
								type: 'textbox',
								tooltip: 'Image URL (if you want a pics to anchor)',
								value: '',
							},
							{
								label: '⭐ Classe CSS CTA (option)',
								name: 'classcsscta',
								type: 'textbox',
								tooltip: 'Enter class here in order to style your CTA',
								value: '',
							},							
							{
								label: '⭐ Price Min',
								name: 'prixmin',
								type: 'listbox',
								values : [
			                        { text: '-', value: '1' },
			                        { text: '10 $', value: '1000' },
			                        { text: '20 $', value: '2000' },
									{ text: '30 $', value: '3000' },
			                        { text: '40 $', value: '4000' },
			                        { text: '50 $', value: '5000' },
									{ text: '100 $', value: '10000' },
			                        { text: '150 $', value: '15000' },
			                        { text: '200 $', value: '20000' },
									{ text: '250 $', value: '25000' },
			                        { text: '500 $', value: '50000' },
			                        { text: '1000 $', value: '100000' },
			                    ]
							},
							{
								label: '⭐ Categories',
								name: 'cat',
								type: 'listbox',
								values : [
									{value: 'All', text: 'All Departments' },{value: 'AmazonVideo', text: 'Prime Video' },{value: 'Apparel', text: 'Clothing & Accessories' },{value: 'Appliances', text: 'Appliances' },{value: 'ArtsAndCrafts', text: 'Arts, Crafts & Sewing' },{value: 'Automotive', text: 'Automotive Parts & Accessories' },{value: 'Baby', text: 'Baby' },{value: 'Beauty', text: 'Beauty & Personal Care' },{value: 'Books', text: 'Books' },{value: 'Classical', text: 'Classical' },{value: 'Collectibles', text: 'Collectibles & Fine Art' },{value: 'Computers', text: 'Computers' },{value: 'DigitalMusic', text: 'Digital Music' },{value: 'DigitalEducationalResources', text: 'Digital Educational Resources' },{value: 'Electronics', text: 'Electronics' },{value: 'EverythingElse', text: 'Everything Else' },{value: 'Fashion', text: 'Clothing, Shoes & Jewelry' },{value: 'FashionBaby', text: 'Clothing, Shoes & Jewelry Baby' },{value: 'FashionBoys', text: 'Clothing, Shoes & Jewelry Boys' },{value: 'FashionGirls', text: 'Clothing, Shoes & Jewelry Girls' },{value: 'FashionMen', text: 'Clothing, Shoes & Jewelry Men' },{value: 'FashionWomen', text: 'Clothing, Shoes & Jewelry Women' },{value: 'GardenAndOutdoor', text: 'Garden & Outdoor' },{value: 'GiftCards', text: 'Gift Cards' },{value: 'GroceryAndGourmetFood', text: 'Grocery & Gourmet Food' },{value: 'Handmade', text: 'Handmade' },{value: 'HealthPersonalCare', text: 'Health, Household & Baby Care' },{value: 'HomeAndKitchen', text: 'Home & Kitchen' },{value: 'Industrial', text: 'Industrial & Scientific' },{value: 'Jewelry', text: 'Jewelry' },{value: 'KindleStore', text: 'Kindle Store' },{value: 'LocalServices', text: 'Home & Business Services' },{value: 'Luggage', text: 'Luggage & Travel Gear' },{value: 'LuxuryBeauty', text: 'Luxury Beauty' },{value: 'Magazines', text: 'Magazine Subscriptions' },{value: 'MobileAndAccessories', text: 'Cell Phones & Accessories' },{value: 'MobileApps', text: 'Apps & Games' },{value: 'MoviesAndTV', text: 'Movies & TV' },{value: 'Music', text: 'CDs & Vinyl' },{value: 'MusicalInstruments', text: 'Musical Instruments' },{value: 'OfficeProducts', text: 'Office Products' },{value: 'PetSupplies', text: 'Pet Supplies' },{value: 'Photo', text: 'Camera & Photo' },{value: 'Shoes', text: 'Shoes' },{value: 'Software', text: 'Software' },{value: 'SportsAndOutdoors', text: 'Sports & Outdoors' },{value: 'ToolsAndHomeImprovement', text: 'Tools & Home Improvement' },{value: 'ToysAndGames', text: 'Toys & Games' },{value: 'VHS', text: 'VHS' },{value: 'VideoGames', text: 'Video Games' },{value: 'Watches', text: 'Watches'}
			                    ]
							},
							{
								label: '⭐ Sort by',
								name: 'sort',
								type: 'listbox',
								tooltip: 'What are the search criteria you want to use?',
								values : [
									{ text: 'Default', value: '' },
			                        { text: 'Relevance', value: 'Relevance' },
			                        { text: 'AvgCustomerReviews', value: 'AvgCustomerReviews' },
			                        { text: 'Featured', value: 'Featured' },
									{ text: 'Newest arrivals', value: 'NewestArrivals' },
			                        { text: 'Price High 2 Low', value: 'Price:HighToLow' },
			                        { text: 'Price Low 2 High', value: 'Price:LowToHigh' },
			                    ]
							},
							{
								label: '⭐ Sellers',
								name: 'vendeur',
								type: 'listbox',
								tooltip: 'Amazon only / All sellers',
								values : [
									{ text: 'Default', value: '' },
			                        { text: 'All Sellers', value: 'All' },
			                        { text: 'Amazon Only', value: 'Amazon' },
			                    ]
							},
							{
								label: '⭐ Brand',
								name: 'marque',
								type: 'textbox',
								tooltip: 'Type a brand name (optional) | eg : Sony',
								value: '',
							},
							{
								label: '⭐ Force API',
								name: 'force_api',
								type: 'textbox',
								tooltip: 'Priorize other API',
								value: '',
							},
							{
								label: '👽 Inclusion (Big Feed)',
								name: 'inclusion',
								type: 'textbox',
								tooltip: 'merchants requested (separated by a comma)',
								value: '',
							},
							{
								label: '👽 Exclusion (Big Feed)',
								name: 'exclusion',
								type: 'textbox',
								tooltip: 'excluded merchant (only 1)',
								value: '',
							},
							{
								label: '👽 Negative Keywords',
								name: 'nkw',
								type: 'textbox',
								tooltip: 'Negative keywords separated by a comma',
								value: '',
							},
							
						],
						balise: 'inlinemonetizer',
						nom: 'Display Text Backlink with Keyword',
					} ),
				},
				{
					text: '⭐ SpeedyStore',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: '⭐ Categories',
								name: 'cat',
								type: 'textbox',
								tooltip: 'Enter the Wordpress category ID that groups your Gothamazon store pages',
								value: '',
							}
						],
						balise: 'speedyshop',
						nom: 'Display Store Express',
					} ),
				},
				{
					text: '⭐ Related SpeedyStore',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: '⭐ Categories',
								name: 'cat',
								type: 'textbox',
								tooltip: 'Enter the Wordpress category ID that groups your Gothamazon store pages',
								value: '',
							},
							{
								label: '⭐ Number of Pages displayed',
								name: 'nono',
								type: 'listbox',
								tooltip: 'Enter the number of Gothamazon store pages you want to display.',
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
							}
						],
						balise: 'related_speedyshop',
						nom: 'Display Related Categories',
					} ),
				}
			]
		});
	});

})();
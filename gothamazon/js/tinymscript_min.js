(function() {

	function set_shortcodes_atts( editor, atts ) {

		// nom fenetre
		var titreFenetre = !_.isUndefined( atts.nom ) ? atts.nom : 'Ajouter un shortcode';
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
								label: 'Mot clé',
								name: 'title',
								type: 'textbox',
								tooltip: 'Saisir un mot clé',
								value: '',
							},
							{
								label: 'Nombre de produits',
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
								label: '🔒 Prix Mini',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Prix Maxi',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Catégorie',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
									{ text: 'Toutes catégories', value: '' },
			              
			                    ]
							},
							{
								label: '🔒 Méthode de tri',
								name: '',
								type: 'listbox',
								tooltip: 'Quels seront les critères de recherche de produits',
								disabled : 1,
								values : [
									{text: 'Défaut', value: ''},
			                    ]
							},
							{
								label: '🔒 % Remise Mini',
								name: '',
								type: 'listbox',
								tooltip: 'Quel pourcentage minimum de remise exigez-vous ?',
								disabled : 1,
								values : [
									{ text: 'Défaut', value: '' },
			                    ]
							},
							{
								label: '🔒 Type de Vendeur',
								name: '',
								type: 'listbox',
								tooltip: 'Amazon uniquement / Tous les vendeurs',
								disabled : 1,
								values : [
									{ text: 'Défaut', value: '' },
			                    ]
							},
							{
								label: '🔒 Marque',
								name: '',
								type: 'textbox',
								tooltip: 'Saisir une marque (facultatif)',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Masquer le titre',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'Masque le titre AMZ du produit',
								values : [
									{ text: 'Défaut', value: '' },
			                    ]
							},
							{
								label: '🔒 Afficher Prix',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'Afficher OU masquer le prix du produit',
								values : [
			                        { text: 'Défaut', value: '' },

			                    ]
							},
							{
								label: '🔒 Nombre de produits sur Mobile',
								name: '',
								type: 'listbox',
								tooltip: 'Toujours inférieur au nombre de produits sur PC',
								disabled : 1,
								values : [
									{ text: 'Défaut', value: '' },
			                    ]
							},
						],
						balise: 'boutique',
						nom: 'Affichage d\'une liste d\'items trouvé par mot clé',
					} ),
				},
				{
					text: 'GTAMZ Spotlight by KW 🔐',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: 'Mot clé',
								name: 'title',
								type: 'textbox',
								tooltip: 'Saisir un mot clé',
								value: '',
							},
							{
								label: '🔒 Titre Personnalisé',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Laissez vide pour utiliser le titre Amazon',
								value: '',
							},
							{
								label: '🔒 Description Personnalisée',
								name: '',
								type: 'textbox',
								multiline: true,
								disabled : 1,
								tooltip: 'Laissez vide pour utiliser la description Amazon',
								value: '',
							},
							{
								label: '🔒 Catégorie',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
									{ text: 'Toutes catégories', value: '' },
			                    ]
							},
							{
								label: '🔒 Prix Mini',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Prix Maxi',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},	
							{
								label: '🔒 Nombre de photos',
								name: '',
								type: 'listbox',
								tooltip: 'Nombre de photos affichées',
								disabled : 1,
								values : [
			                        { text: '4 (Defaut)', value: '' },
			                    ]
							},
							{
								label: '🔒 Méthode de tri',
								name: '',
								type: 'listbox',
								tooltip: 'Quels seront les critères de recherche de produits',
								disabled : 1,
								values : [
									{text: 'Défaut', value: ''},
			                    ]
							},
							{
								label: '🔒 Type de Vendeur',
								name: '',
								type: 'listbox',
								tooltip: 'Amazon uniquement / Tous les vendeurs',
								disabled : 1,
								values : [
									{ text: 'Défaut', value: '' },
			                    ]
							},
							{
								label: '🔒 Marque',
								name: '',
								type: 'textbox',
								tooltip: 'Saisir une marque (facultatif)',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 % Remise Mini',
								name: '',
								type: 'listbox',
								tooltip: 'Quel pourcentage minimum de remise exigez-vous ?',
								disabled : 1,
								values : [
									{ text: 'Défaut', value: '' },
			                    ]
							},
							{
								label: '🔒 Afficher Prix',
								name: '',
								type: 'listbox',
								disabled : 1,
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
								tooltip: 'Saisir ASIN Amazon',
								value: '',
							},
							{
								label: '🔒 Titre Personnalisé',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Laissez vide pour utiliser le titre Amazon',
								value: '',
							},
							{
								label: '🔒 Description Personnalisée',
								name: '',
								type: 'textbox',
								multiline: true,
								disabled : 1,
								tooltip: 'Laissez vide pour utiliser la description Amazon',
								value: '',
							},
							{
								label: '🔒 Nombre de photos',
								name: '',
								type: 'listbox',
								tooltip: 'Nombre de photos affichées',
								disabled : 1,
								values : [
			                        { text: '4 (Defaut)', value: '' },
			                    ]
							},
							{
								label: '🔒 Mot clé Parachute',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Saisir un mot clé qui servira à trouver un article équivalent à votre ASIN si produit épuisé',
								value: '',
							},
							{
								label: '🔒 Catégorie Parachute',
								name: '',
								type: 'listbox',
								tooltip: 'Catégorie de l\'éventuel produit alternatif',
								disabled : 1,
								values : [
									{ text: 'Toutes catégories', value: 'All' },
			                    ]
							},
							{
								label: '🔒 Prix Mini Parachute',
								name: '',
								type: 'listbox',
								tooltip: 'Prix minimum de l\'éventuel produit alternatif',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Afficher Prix',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: 'Défaut', value: '' },

			                    ]
							},
						],
						balise: 'gothasin',
						nom: 'Affichage par ASIN',
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
								tooltip: 'Saisir ASIN Amazon',
								value: '',
							},
							{
								label: 'Ancre du lien',
								name: 'ancre',
								type: 'textbox',
								tooltip: 'Ancre du lien',
								value: 'Cliquez Ici',
							},
							{
								label: '🔒 Url Image (option)',
								name: '',
								type: 'textbox',
								tooltip: 'Url Image (Si vous voulez une image pour ancre)',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Classe CSS CTA (option)',
								name: '',
								type: 'textbox',
								tooltip: 'CSS du CTA',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Prix dynamique',
								name: '',
								type: 'listbox',
								disabled : 1,
								tooltip: 'Ajoute le prix derrière votre ancre',
								values : [
			                        { text: 'Non', value: 'non' },
			                    ]
							},
							{
								label: '🔒 Mot clé Parachute',
								name: '',
								type: 'textbox',
								disabled : 1,
								tooltip: 'Saisir un mot clé qui servira à trouver un article équivalent à votre ASIN si produit épuisé',
								value: '',
							},
							{
								label: '🔒 Categorie Parachute',
								name: '',
								type: 'listbox',
								tooltip: 'Catégorie de l\'éventuel produit alternatif',
								disabled : 1,
								values : [
									{ text: 'Toutes catégories', value: 'All' },
			                    ]
							},
							{
								label: '🔒 Prix Mini Parachute',
								name: '',
								type: 'listbox',
								tooltip: 'Prix minimum de l\'éventuel produit alternatif',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							
						],
						balise: 'inlineASIN',
						nom: 'Affichage en lien texte via ASIN',
					} ),
				},
				{
					text: '🔒 GTAMZ Inline by KW 🔒',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: '🔒 Mot clé',
								name: '',
								type: 'textbox',
								tooltip: 'Saisir un mot clé',
								disabled : 1,
								value: 'keyword',
							},
							{
								label: '🔒 Ancre du lien',
								name: '',
								type: 'textbox',
								tooltip: 'Ancre du lien',
								disabled : 1,
								value: 'Cliquez Ici',
							},
							{
								label: '🔒 Prix dynamique',
								name: '',
								type: 'listbox',
								tooltip: 'Ajoute le prix derrière votre ancre',
								disabled : 1,
								values : [
			                        { text: 'Non', value: 'non' },
			                    ]
							},
							{
								label: '🔒 Url Image (option)',
								name: '',
								type: 'textbox',
								tooltip: 'Url Image (Si vous voulez une image pour ancre)',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Classe CSS CTA (option)',
								name: '',
								type: 'textbox',
								tooltip: 'CSS du CTA',
								disabled : 1,
								value: '',
							},
							{
								label: '🔒 Prix Mini',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
			                        { text: '-', value: '' },
			                    ]
							},
							{
								label: '🔒 Catégorie',
								name: '',
								type: 'listbox',
								disabled : 1,
								values : [
									{ text: 'Toutes catégories', value: 'All' },
			                    ]
							},							
							{
								label: '🔒 Méthode de tri',
								name: '',
								type: 'listbox',
								tooltip: 'Quels seront les critères de recherche de produits',
								disabled : 1,
								values : [
									{text: 'Défaut', value: ''},
			                    ]
							},
							{
								label: '🔒 Type de Vendeur',
								name: '',
								type: 'listbox',
								tooltip: 'Amazon uniquement / Tous les vendeurs',
								disabled : 1,
								values : [
									{ text: 'Défaut', value: '' },
			                    ]
							},
							{
								label: '🔒 Marque',
								name: '',
								type: 'textbox',
								tooltip: 'Saisir une marque (facultatif)',
								disabled : 1,
								value: '',
							},							
						],
						balise: '',
						nom: 'Affichage en lien texte via Mot Clé',
					} ),
				},
			]
		});
	});

})();
(function () {
	"use strict";

	var wcShortcodeManager = function(editor, url) {
		var wcDummyContent = 'Sample Content';
		var wcParagraphContent = 'Sample Content';


		editor.addButton('wpc_shortcodes_button', function() {
			return {
				title: "Insert Shortcodes",
				text: "[ /]",
				type: 'menubutton',
				icons: false,
				menu: [
					{
						text: 'Buttons',
						menu: [
							{
								text: "Black",
								onclick: function(){
									editor.insertContent('[button color = "black" link="" target=""]' + wcParagraphContent + '[/button]');
								}
							},
							{
								text: "Yellow",
								onclick: function(){
									editor.insertContent('[button color = "yellow" link="" target=""]' + wcParagraphContent + '[/button]');
								}
							},
							{
								text: "Purple",
								onclick: function(){
									editor.insertContent('[button color = "purple" link="" target=""]' + wcParagraphContent + '[/button]');
								}
							},
							{
								text: "Pink",
								onclick: function(){
									editor.insertContent('[button color = "pink" link="" target=""]' + wcParagraphContent + '[/button]');
								}
							},
							{
								text: "Red",
								onclick: function(){
									editor.insertContent('[button color = "red" link="" target=""]' + wcParagraphContent + '[/button]');
								}
							},
							
						]
					},
					{
						text: 'Accordian',
						menu: [
							{
								text: "Accordian Main",
								onclick: function(){
									editor.insertContent('[accordian]' + wcParagraphContent + '[/accordian]');
								}
							},
							{
								text: "Accordian with first item",
								onclick: function(){
									editor.insertContent('[accordian][accordian-item heading="" item_no="One"]' + wcParagraphContent + '[/accordian-item][/accordian]');
								}
							},
							{
								text: "Accordian Item",
								onclick: function(){
									editor.insertContent('[accordian-item heading="" item_no=""]' + wcParagraphContent + '[/accordian]');
								}
							},
							
						]
					},
					{
						text: 'Columns',
						menu: [
						    {
								text: "Column Full",
								onclick: function(){
									editor.insertContent('[column-full heading=""]' + wcParagraphContent + '[/column-full]');
								}
							},
							{
								text: "Column 1/2",
								onclick: function(){
									editor.insertContent('[column-half heading=""]' + wcParagraphContent + '[/column-half]');
								}
							},
							{
								text: "Column 1/3",
								onclick: function(){
									editor.insertContent('[column-third heading=""]' + wcParagraphContent + '[/column-third]');
								}
							},
							{
								text: "Column 1/4",
								onclick: function(){
									editor.insertContent('[column-quarter heading=""]' + wcParagraphContent + '[/column-quarter]');
								}
							}
					
						]
					},
					{
					text: 'Lists',
						menu: [
							{
								text: "List Main",
								onclick: function(){
									editor.insertContent('[list]' + wcParagraphContent + '[/list]');
								}
							},
							{
								text: "List with item",
								onclick: function(){
									editor.insertContent('[list][list-item-check]' + wcParagraphContent + '[/list-item-check][/list]');
								}
							},
							{
								text: "List item with check",
								onclick: function(){
									editor.insertContent('[list-item-check]' + wcParagraphContent + '[/list-item-check]');
								}
							},
							{
								text: "List item with square",
								onclick: function(){
									editor.insertContent('[list-item-square]' + wcParagraphContent + '[/list-item-square]');
								}
							},
							{
								text: "List item with arrow",
								onclick: function(){
									editor.insertContent('[list-item-arrow]' + wcParagraphContent + '[/list-item-arrow]');
								}
							}
					
						]
					},
					{
					text: 'Toggle',
						menu: [
							{
								text: "Toggle Main",
								onclick: function(){
									editor.insertContent('[toggle]' + wcParagraphContent + '[/toggle]');
								}
							},
							{
								text: "Toggle with item",
								onclick: function(){
									editor.insertContent('[toggle][toggle-item heading=""]' + wcParagraphContent + '[/toggle-item][/toggle]');
								}
							},
							{
								text: "Toggle Item",
								onclick: function(){
									editor.insertContent('[toggle-item heading=""]' + wcParagraphContent + '[/toggle-item]');
								}
							}
							
					
						]
					},
					{
					text: 'Headings',
						menu: [
							{
								text: "Heading Group",
								onclick: function(){
									editor.insertContent('[head-group]' + wcParagraphContent + '[/head-group]');
								}
							},
							{
								text: "Heading Group with item",
								onclick: function(){
									editor.insertContent('[head-group][head1 title="' + wcParagraphContent + '"]' + wcParagraphContent + '[/head1][/head-group]');
								}
							},
							{
								text: "Heading 1",
								onclick: function(){
									editor.insertContent('[head1 title="' + wcParagraphContent + '"]' + wcParagraphContent + '[/head1]');
								}
							},
							{
								text: "Heading 2",
								onclick: function(){
									editor.insertContent('[head2 title="' + wcParagraphContent + '"]' + wcParagraphContent + '[/head2]');
								}
							},
							{
								text: "Heading 3",
								onclick: function(){
									editor.insertContent('[head3 title="' + wcParagraphContent + '"]' + wcParagraphContent + '[/head3]');
								}
							}
							
					
						]
					},
				]
			}
		});
	};
	
	tinymce.PluginManager.add( "wpc_shortcodes", wcShortcodeManager );
})();

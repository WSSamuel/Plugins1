(function ($) {
	"use strict";

	jQuery(document).ready(function ($) {

		/**
		 * Script for icon option
		 */
		$('.wpci_icon_area').each(function () {
			var wpci_icon_area = $(this);
			var icon_input = wpci_icon_area.find('input.wpci_icon_cls_input');
			var icon_filter = wpci_icon_area.find('input.filter');
			var icon_library = wpci_icon_area.find('.customizer_icon_library');
			var icon = icon_library.find('i');
			//click on input show icon area
			icon_input.on('click', function () {
				icon_library.slideToggle("fast");
			});
			//type on input search icon item in icon area
			icon_filter.on("keyup", function() {
				var value = $(this).val().toLowerCase();
				icon.filter(function() {
					$(this).closest('li').toggle($(this).attr('class').toLowerCase().indexOf(value) > -1);
				});
			});
			//click on icon hide icon area
			icon.on('click', function () {
				icon_input.val($(this).attr('class')).change();
				setTimeout(function () {
					icon_library.slideUp("fast");
				}, 310)
			});
		});

	});

})(jQuery);
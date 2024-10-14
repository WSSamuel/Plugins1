/* sidebarAutomizer - Sidebar Automatic height for wordpress (calculated by content height) by m.r.d.a */
var sidebar_automizer_class_selector_name = document.querySelector(sidebarautomizer_name.sidebar_automizer_class_selector_string);
var sidebar_automizer_class_selector2_name = document.querySelector(sidebarautomizer_name.sidebar_automizer_class_selector2_string);
var sidebar_automizer_add_extra_height = parseInt(sidebarautomizer_name.sidebar_automizer_add_extra_string);


jQuery(document).ready(function($){	

	var contentHeight = ((sidebar_automizer_class_selector_name.offsetHeight));
	var sidebarHeight = ((sidebar_automizer_class_selector2_name.offsetHeight));
	var sidebar_automizer_class_selector = sidebarautomizer_name.sidebar_automizer_class_selector2_string;
	var sidebar_automizer_element_selector = sidebarautomizer_name.sidebar_automizer_element_string;
	
	while ( sidebarHeight > contentHeight + sidebar_automizer_add_extra_height ) {
	
	//$ (sidebar_automizer_class_selector + " aside:last-child").remove()
	$ (sidebar_automizer_class_selector + " " + sidebar_automizer_element_selector + ":last-child" ).remove()
	
	var contentHeight = ((sidebar_automizer_class_selector_name.offsetHeight));
    var sidebarHeight = ((sidebar_automizer_class_selector2_name.offsetHeight));
	
	};	
	
});
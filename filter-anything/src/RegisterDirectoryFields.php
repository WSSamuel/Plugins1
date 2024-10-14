<?php

namespace Vardaam\FilterAnything;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Field\Complex_Field;
use Carbon_Fields\Field\Multiselect_Field;
use Carbon_Fields\Field\Select_Field;

class RegisterDirectoryFields {
	public function __construct() {
		add_action( 'carbon_fields_register_fields', [ $this, 'attach_directory_options' ] );
	}

	public function attach_directory_options() {
		Container::make( 'post_meta', __( 'Directory Settings' ) )
		         ->where( 'post_type', '=', 'wfa-filters' )
		         ->add_tab( __( 'Query settings' ),
			         self::load_query_settings()
		         )
		         ->add_tab( __( 'Layout settings' ),
			         self::load_layout_settings()
		         )
		         ->add_tab( __( 'Filters' ), [
			         self::load_user_filters(),
			         self::load_post_filters()
		         ] )
		         ->add_tab( __( 'Display texts' ),
			         self::load_display_texts()
		         );
	}

	private function load_query_settings(): array {
		return [
			Field::make( 'radio', 'directory_type', __( 'Directory type' ) )
			     ->set_options( [
				     'posts_directory' => __( 'Posts directory' ),
				     'user_directory'  => __( 'Users directory' ),
			     ] )
			     ->set_default_value( 'posts_directory' )
			     ->set_required( true )
			     ->set_width( 30 ),
			Field::make( 'multiselect', 'post_type_select', __( 'Post types' ) )
			     ->add_options( 'wfa_get_post_type_names' )
			     ->set_help_text( __( 'Only "publicly_queryable" post types will be displayed' ) )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'directory_type',
					     'value'   => 'posts_directory',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_width( 70 ),
			Field::make( 'multiselect', 'user_role_select', __( 'User roles' ) )
			     ->add_options( Helpers::get_role_names() )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'directory_type',
					     'value'   => 'user_directory',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_help_text( __( 'If left blank, Directory will return all users.' ) )
			     ->set_width( 70 ),
			Field::make( 'complex', 'taxonomy_pre_filters' )
				 ->add_fields( [
					 Field::make( 'select', 'taxonomy_select', __( 'Taxonomy' ) )
						 ->set_options( 'get_taxonomies' )
						 ->set_required( true )
						 ->set_width( 50 ),
					 Field::make( 'text', 'taxonomy_terms', 'Terms' )
						 ->set_required( true )
						 ->set_width( 50 )
						 ->set_help_text( __( 'Enter slugs separated with , Like: abc,xyz' ) ),
				 ] )
				 ->set_conditional_logic( [
					 'relation' => 'AND',
					 [
						 'field'   => 'directory_type',
						 'value'   => 'posts_directory',
						 'compare' => '=',
					 ]
				 ] )
				 ->set_header_template( '
					 <% if (taxonomy_terms) { %>
						 <%- taxonomy_select ? "[" + taxonomy_select + "] - " : "" %><%- taxonomy_terms %>
					 <% } %>
				 ' )
				 ->set_layout( 'grid' )
				 ->setup_labels( [
					 'plural_name'   => 'Taxonomy Pre Filters',
					 'singular_name' => 'Taxonomy Pre Filter',
				 ] )
				 ->set_width( 100 )
				 ->set_help_text( __( 'These taxonomy terms will be pre applied before applying directory filters.' ) ),
			Field::make( 'html', 'order_settings_text' )
			     ->set_html( __( '<h2>Order Settings</h2>' ) )
			     ->set_width( 25 ),
			Field::make( 'select', 'order', __( 'Order' ) )
			     ->add_options( [
				     'ASC'  => __( 'Ascending' ),
				     'DESC' => __( 'Descending' )
			     ] )
			     ->set_default_value( 'DESC' )
			     ->set_required( true )
			     ->set_width( 25 ),
			Field::make( 'select', 'order_by_post_query', __( 'Order by' ) )
			     ->add_options( [
				     'meta_value' => __( 'Meta Value' ),
				     'date'       => __( 'Post Date' ),
				     'title'      => __( 'Post Title' )
			     ] )
			     ->set_required( true )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'directory_type',
					     'value'   => 'posts_directory',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_width( 25 ),
			Field::make( 'select', 'order_by_user_query', __( 'Order by' ) )
			     ->add_options( [
				     'meta_value'   => __( 'Meta value' ),
				     'display_name' => __( 'Display name' ),
				     'name'         => __( 'Username' ),
				     'nicename'     => __( 'User nicename' ),
				     'email'        => __( 'Email' ),
				     'post_count'   => __( 'Post count' ),
				     'registered'   => __( 'Registration date' )
			     ] )
			     ->set_required( true )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'directory_type',
					     'value'   => 'user_directory',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_width( 25 ),
			Field::make( 'text', 'meta_key_post_query', __( 'Meta key' ) )
			     ->set_required( true )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'directory_type',
					     'value'   => 'posts_directory',
					     'compare' => '=',
				     ],
				     [
					     'field'   => 'order_by_post_query',
					     'value'   => 'meta_value',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_width( 25 ),
			Field::make( 'text', 'meta_key_user_query', __( 'Meta key' ) )
			     ->set_required( true )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'directory_type',
					     'value'   => 'user_directory',
					     'compare' => '=',
				     ],
				     [
					     'field'   => 'order_by_user_query',
					     'value'   => 'meta_value',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_width( 25 ),
			Field::make( 'number', 'per_page', __( 'Per page' ) )
			     ->set_min( - 1 )
			     ->set_max( 100 )
			     ->set_step( 1 )
			     ->set_default_value( 10 )
			     ->set_required( true )
			     ->set_help_text( __( 'Min: -1 and Max: 100' ) ),
		];
	}

	private function load_layout_settings(): array {
		return [
			Field::make( 'radio', 'filter_layout', __( 'Filter Layout' ) )
			     ->set_options( [
				     'horizontal_full_width_filter' => 'Horizontal full width filter',
				     'sidebar_filter'               => 'Sidebar filter',
			     ] )
			     ->set_default_value( 'horizontal_full_width_filter' )
			     ->set_required( true )
			     ->set_width( 33 ),
			Field::make( 'number', 'sidebar_width', __( 'Sidebar Width' ) )
			     ->set_min( 10 )
			     ->set_max( 50 )
			     ->set_step( 5 )
			     ->set_default_value( 30 )
			     ->set_required( true )
			     ->set_help_text( __( 'Min: 10 and Max: 50' ) )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'filter_layout',
					     'value'   => 'sidebar_filter',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_width( 33 ),
			Field::make( 'number', 'items_per_line', __( 'Items per line' ) )
			     ->set_min( 1 )
			     ->set_max( 4 )
			     ->set_step( 1 )
			     ->set_default_value( 1 )
			     ->set_required( true )
			     ->set_help_text( 'Min: 1 and Max: 4 This is a count of Items that will be displayed as a result on each line' )
			     ->set_width( 33 ),
			Field::make( 'checkbox', 'show_labels_as_placeholders', __( 'Show labels as placeholders' ) )
			     ->set_option_value( 'yes' )
			     ->set_help_text( 'This option will hide Filter Labels and will show them as placeholder values' ),
			Field::make( 'checkbox', 'show_result_on_load', __( 'Show result on load' ) )
			     ->set_option_value( 'yes' )
			     ->set_help_text( 'This option will show all results by default without hitting submit button.' ),
			Field::make( 'textarea', 'quick_css', __( 'Quick CSS' ) )
		];
	}

	private function load_user_filters(): Complex_Field {
		return self::load_filters( 'user_filters', [
			Field::make( 'select', 'filter_type', __( 'Filter type' ) )
			     ->set_options( [
				     'meta'              => __( 'Meta' ),
				     'custom'            => __( 'Custom' ),
				     'search'            => __( 'Search' ),
				     'registration_date' => __( 'Registration date' ),
				     'role'              => __( 'Role' )
			     ] )
			     ->set_default_value( 'meta' )
			     ->set_required( true ),
			self::get_choices_field(),
			self::get_compare_meta_field(),
			self::get_meta_key_field(),
			self::get_date_compare_field( 'registration_date' ),
			self::get_roles_field(),
		], 'user_directory' );
	}

	private function load_filters( string $name, array $fields, string $directory_type ): Complex_Field {
		return Field::make( 'complex', $name )
		            ->add_fields( array_merge( self::common_filter_fields(), $fields ) )
		            ->set_conditional_logic( [
			            'relation' => 'AND',
			            [
				            'field'   => 'directory_type',
				            'value'   => $directory_type,
				            'compare' => '=',
			            ]
		            ] )
		            ->set_header_template( '
                <% if (label) { %>
                    <%- input_type ? "[" + input_type + "] - " : "" %><%- label %>
                <% } %>
            ' )
		            ->set_layout( 'tabbed-vertical' )
		            ->setup_labels( [
			            'plural_name'   => 'Filters',
			            'singular_name' => 'Filter',
		            ] );
	}

	private function common_filter_fields(): array {
		return [
			Field::make( 'text', 'label', __( 'Label' ) )
			     ->set_help_text( __( 'Ex: First Name, Last Name, etc.' ) )
			     ->set_required( true )
			     ->set_width( '33' ),
			Field::make( 'text', 'name', __( 'Name' ) )
			     ->set_help_text( __( 'Ex: first_name, last_name, etc.' ) )
			     ->set_required( true )
			     ->set_width( '33' ),
			Field::make( 'text', 'placeholder', __( 'Placeholder' ) )
			     ->set_help_text( __( 'Ex: first_name, last_name, etc.' ) )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field' => 'parent.show_labels_as_placeholders',
					     'value' => false,
				     ]
			     ] )
			     ->set_width( '33' ),
			Field::make( 'select', 'width', __( 'Width' ) )
			     ->set_options( [
				     'full'         => __( 'Full' ),
				     'half'         => __( 'Half' ),
				     'one_fourth'   => __( 'One Fourth' ),
				     'three_fourth' => __( 'Three Fourth' ),
				     'one_third'    => __( 'One Third' ),
				     'two_third'    => __( 'Two Third' )
			     ] )
			     ->set_default_value( 'full' )
			     ->set_required( true )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'parent.filter_layout',
					     'value'   => 'horizontal_full_width_filter',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_width( '33' ),
			Field::make( 'select', 'input_type', __( 'Input type' ) )
			     ->set_options( [
				     'text'     => __( 'Text' ),
				     'number'   => __( 'Number' ),
				     'date'     => __( 'Date' ),
				     'datetime' => __( 'DateTime' ),
				     'select'   => __( 'Select' ),
				     'radio'    => __( 'Radio' ),
				     'checkbox' => __( 'Checkbox' ),
			     ] )
			     ->set_default_value( 'text' )
			     ->set_required( true ),
			Field::make( 'checkbox', 'multiselect', __( 'Multiselect' ) )
			     ->set_option_value( 'yes' )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'input_type',
					     'value'   => 'select',
					     'compare' => '=',
				     ]
			     ] ),
			Field::make( 'text', 'default_value', __( 'Default value' ) )
		];
	}

	private function get_choices_field(): Field\Field {
		return Field::make( 'textarea', 'choices', __( 'Choices' ) )
		            ->set_conditional_logic( [
			            'relation' => 'AND',
			            [
				            'field'   => 'filter_type',
				            'value'   => [ 'taxonomy', 'author', 'role' ],
				            'compare' => 'NOT IN',
			            ],
			            [
				            'field'   => 'input_type',
				            'value'   => [ 'select', 'radio', 'checkbox' ],
				            'compare' => 'IN',
			            ]
		            ] )
		            ->set_help_text( __( 'Enter each choice on a new line.<br />
            For more control, you may specify both a value and label like this:<br />
            red : Red' ) )
		            ->set_required( true );
	}

	private function get_compare_meta_field(): Select_Field {
		return Field::make( 'select', 'compare', __( 'Compare' ) )
		            ->set_options( [
			            '='          => '=',
			            '!='         => '!=',
			            '>'          => '>',
			            '>='         => '>=',
			            '<'          => '<',
			            '<='         => '<=',
			            'LIKE'       => 'LIKE',
			            'NOT LIKE'   => 'NOT LIKE',
			            'EXISTS'     => 'EXISTS',
			            'NOT EXISTS' => 'NOT EXISTS',
			            'IN'         => 'IN',
			            'NOT IN'     => 'NOT IN'
		            ] )
		            ->set_default_value( '=' )
		            ->set_conditional_logic( [
			            'relation' => 'AND',
			            [
				            'field'   => 'filter_type',
				            'value'   => 'meta',
				            'compare' => '=',
			            ]
		            ] )
		            ->set_help_text( __( 'Use "IN" and "NOT IN" when using input type as "SELECT with MULTISELECT or CHECKBOX" options.' ) )
		            ->set_required( true );
	}

	private function get_meta_key_field(): Field\Field {
		return Field::make( 'text', 'meta_key', __( 'Meta Key' ) )
		            ->set_conditional_logic( [
			            'relation' => 'AND',
			            [
				            'field'   => 'filter_type',
				            'value'   => 'meta',
				            'compare' => '=',
			            ]
		            ] )
		            ->set_required( true );
	}

	private function get_date_compare_field( string $filter_type ): Select_Field {
		return Field::make( 'select', 'date_compare', __( 'Date compare' ) )
		            ->set_options( [
			            '='  => '=',
			            '!=' => '!=',
			            '>'  => '>',
			            '>=' => '>=',
			            '<'  => '<',
			            '<=' => '<=',
		            ] )
		            ->set_default_value( '=' )
		            ->set_conditional_logic( [
			            'relation' => 'AND',
			            [
				            'field'   => 'filter_type',
				            'value'   => $filter_type,
				            'compare' => '=',
			            ]
		            ] )
		            ->set_required( true );
	}

	private function get_roles_field(): Multiselect_Field {
		return Field::make( 'multiselect', 'roles', __( 'Roles' ) )
		            ->set_options( wp_list_pluck( wp_roles()->roles, 'name' ) )
		            ->set_default_value( '=' )
		            ->set_conditional_logic( [
			            'relation' => 'AND',
			            [
				            'field'   => 'filter_type',
				            'value'   => 'role',
				            'compare' => '=',
			            ]
		            ] )
		            ->set_help_text( __( 'Filter will only show chosen roles, This roles selection will always be subset of Main directory roles selection' ) )
		            ->set_required( true );
	}

	private function load_post_filters(): Complex_Field {
		return self::load_filters( 'post_filters', [
			Field::make( 'select', 'filter_type', __( 'Filter type' ) )
			     ->set_options( [
				     'meta'      => __( 'Meta' ),
				     'taxonomy'  => __( 'Taxonomy' ),
				     'custom'    => __( 'Custom' ),
				     'search'    => __( 'Search' ),
				     'post_date' => __( 'Post Date' ),
				     'author'    => __( 'Author' ),
			     ] )
			     ->set_default_value( 'meta' )
			     ->set_required( true ),
			Field::make( 'select', 'taxonomy_select', __( 'Taxonomy' ) )
			     ->set_options( 'get_taxonomies' )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'filter_type',
					     'value'   => 'taxonomy',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_required( true ),
			Field::make( 'text', 'filter_by_child_terms_of', 'Filter by child terms of' )
			     ->set_conditional_logic( [
				     'relation' => 'AND',
				     [
					     'field'   => 'filter_type',
					     'value'   => 'taxonomy',
					     'compare' => '=',
				     ]
			     ] )
			     ->set_help_text( __( 'To filter by only child terms of selected parent term.<br />
            Ex: if you insert term slug here, All the child terms of that term will be displayed in filter' ) ),
			self::get_choices_field(),
			self::get_compare_meta_field(),
			self::get_meta_key_field(),
			self::get_date_compare_field( 'post_date' ),
		], 'posts_directory' );
	}

	private function load_display_texts(): array {
		return [
			Field::make( 'text', 'submit_button_text', __( 'Submit button text' ) )
			     ->set_default_value( 'Search' )
			     ->set_required( true )
			     ->set_width( 33 ),
			Field::make( 'text', 'clear_button_text', __( 'Clear button text' ) )
			     ->set_default_value( 'Clear' )
			     ->set_required( true )
			     ->set_width( 33 ),
			Field::make( 'text', 'load_more_button_text', __( 'Load more button text' ) )
			     ->set_default_value( 'Load more' )
			     ->set_required( true )
			     ->set_width( 33 ),
			Field::make( 'text', 'no_result_found_text', __( 'No result found text' ) )
			     ->set_default_value( 'No results found, Please try changing your search criteria.' )
			     ->set_required( true )
			     ->set_width( 50 ),
			Field::make( 'text', 'error_text', __( 'Error Text' ) )
			     ->set_default_value( 'Something went wrong, Please try again later.' )
			     ->set_required( true )
			     ->set_width( 50 ),
		];
	}
}

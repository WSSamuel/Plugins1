<?php

function wfa_get_post_type_names(): array {
	return get_post_types( [
		'publicly_queryable' => true
	] );
}

function wfa_get_theme_name(): string {
	$theme_name = '';
	$current_theme = wp_get_theme();
	if( $current_theme->exists() && $current_theme->parent() ){
		$parent_theme = $current_theme->parent();

		if( $parent_theme->exists() ){
			$theme_name = $parent_theme->get('Name');
		}
	} elseif( $current_theme->exists() ) {
		$theme_name = $current_theme->get('Name');
	}

	return $theme_name;
}

function wfa_is_enfold_theme(): bool {
	return 'Enfold' === wfa_get_theme_name();
}

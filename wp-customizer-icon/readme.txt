=== Wp Customizer Icon ===
Plugin Name: Wp Customizer Icon
Contributors: iqbalrony
Version: 1.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Requires PHP: 5.6
Requires at least: 4.5
Tested up to: 6.1
Stable tag: trunk
Tags: Customizer Icon, Icon, Customizer, Customizer Icon Control

Custom Customizer icon control for wordpress customizer. It contains 3696 material design icons.

== Description ==

Wp Customizer Icon plugin is very easy to use. It contains 3696 material design icons. User can add extra icon classs to the icon library from there theme.
There is an filter hook named WPCI_customizer_icons by which user can marge extra icons class. Icon control name is WPCI_Customize_Icon_Control.
See the [Github](https://github.com/iqbalrony/wp-customizer-icon) project repository.

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Now create customizer icon field by using WPCI_Customize_Icon_Control class in your theme.

Example:-

`/**
 * Customizer register
 */
add_action( 'customize_register', 'mytheme_customize_register' );
function mytheme_customize_register( $wp_customize ) {
	$wp_customize->add_section(
			'test_section',
			array(
				'title' => __('Icon', 'wp-customizer-icon'),
				'priority' => 5,
			)
		);
	$wp_customize->add_setting(
			'test_icon',
			array(
				'default' => 'mdi mdi-access-point',
				'transport' => 'refresh',
			)
		);
	$wp_customize->add_control(
			new WPCI_Customize_Icon_Control(
				$wp_customize,
				'test_icon',
				array(
					'type'      => 'icon',
					'label' => __('Test Icon', 'wp-customizer-icon'),
					'section' => 'test_section',
					'priority' => 10,
				))
	);
}

/**
 * Get Icon Class
 */
$icon_cls = get_theme_mod('test_icon');
echo '<i class="'.esc_attr( $icon_cls ).'"></i>';`

Add extra icon library by filter hook named WPCI_customizer_icons.
Example:-

`add_action('WPCI_customizer_icons','push_icon');
function push_icon($icon_array){
	$new_icon = array_merge(
		array(
			'fa fa-facebook' =>'fa fa-facebook',
			'fa fa-twitter' =>'fa fa-twitter'
		),$icon_array
	);
	return $new_icon;
}`
== Frequently Asked Questions ==

= Is there way to add extra icon library  =

Yes, there is an filter hook named WPCI_customizer_icons by which user can marge extra icons class.

== Screenshots ==

1. This screenshot one.
2. This screenshot two.
3. This screenshot three.
4. This screenshot four.

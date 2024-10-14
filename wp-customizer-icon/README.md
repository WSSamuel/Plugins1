# wp-customizer-icon
Create custom icon control for wordpress customizer.
<h3>Usage</h3> 
<pre>
/**
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
</pre>
<pre>
/**
 * Get Icon Class
 */
$icon_cls = get_theme_mod('test_icon');
echo '&lt;i class="'.esc_attr( $icon_cls ).'"&gt;&lt;/i&gt;';
</pre>
<h3>Add Extra Icon Class</h3>
<p>You can add extra CSS classes to the icon library. There is an filter hook named <code>WPCI_customizer_icons</code> by which you can add extra icons.</p>
<pre>
add_action('WPCI_customizer_icons','push_icon');
function push_icon($icon_array){
	$new_icon = array_merge(
		array(
			'fa fa-facebook' =>'fa fa-facebook',
			'fa fa-twitter' =>'fa fa-twitter'
		),$icon_array
	);
	return $new_icon;
}
</pre>

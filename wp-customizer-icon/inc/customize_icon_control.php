<?php
class WPCI_Customize_Icon_Control extends WP_Customize_Control {

		/**
		 * The type of customize control being rendered.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'icon';

		public $icon_array = array();

		/**
		 * Displays the control content.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
				<div class="description customize-control-description"><?php echo esc_html($this->description); ?></div>
				<div class="wpci_icon_area">
					<input type="text" class="wpci_icon_cls_input" id="icon_option_<?php echo $this->id; ?>" <?php $this->link(); ?>
					       value="<?php echo esc_attr($this->value()); ?>"/>
					<ul class="customizer_icon_library">
						<input type="text" class="filter" value="" placeholder="Search icon"/>
						<?php
						$this->icon_array = apply_filters('WPCI_customizer_icons',wpci_icon_css_class());
						$show_choices = $this->icon_array;
						foreach ($show_choices as $key => $value) {
							echo '<li><i class="'.$value.'"></i></li>';
						}
						?>
					</ul>
				</div>
			</label>
			<?php
		}
} // end WPCI_Customize_Icon

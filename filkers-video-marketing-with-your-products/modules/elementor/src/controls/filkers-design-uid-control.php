<?php

class Filkers_Design_Uid_Control extends \Elementor\Control_Base_Multiple {

    const TYPE = "filkers-design-uid";

    public function get_type() {
        return self::TYPE;
    }

    public function get_default_value() {
        return [
            'valid' => false,
            'error' => '',
            'designUid' => '',
            'aspectRatio' => 0.8
        ];
    }

    public function get_default_settings() {
        return [
            'placeholder' => __( 'Paste your Filkers Design UID here'),
        ];
    }

    public function enqueue() {
        parent::enqueue();

        wp_register_script(
            'filkers-design-uid',
            plugins_url( 'assets/filkers-design-uid-control.js', __FILE__ ),
            [],
            '1.0.0',
            true
        );

        wp_register_style(
            'filkers-controls',
            plugins_url( 'assets/filkers-controls.css', __FILE__ ),
            [],
            '1.0.0'
        );

        wp_enqueue_style('filkers-controls');
        wp_enqueue_script('filkers-design-uid');
    }

    public function content_template() {
        ?>
        		<div class="elementor-control-field">
        			<# if ( data.label ) {#>
        				<label
        				    for="<?php $this->print_control_uid('designUid'); ?>"
        				    class="elementor-control-title"
        				 >
        				    <span>{{{ data.label }}}</span>
                            <div class="elementor-control-field-description">
                                <a href="https://www.filkers.com/filkers-product-grid/" target="_blank"><?php echo __( 'What is this?'); ?></a>
                            </div>
        				 </label>
        			<# } #>
        			<div class="elementor-control-input-wrapper elementor-control-unit-5 elementor-control-dynamic-switcher-wrapper filkers-control-column">
                        <input
                            id="<?php $this->print_control_uid('designUid'); ?>"
                            type="text" class="tooltip-target elementor-control-tag-area"
                            title="{{ data.title }}"
                            data-tooltip="{{ data.title }}"
                            data-setting="designUid"
                            placeholder="{{ view.getControlPlaceholder() }}"
                         />
                        <div id="<?php $this->print_control_uid('error'); ?>" class="elementor-control-field-description filkers-control-error" data-setting="error">
                           Error
                        </div>
        				 <input id="<?php $this->print_control_uid('valid'); ?>" type="hidden" data-setting="valid" />
        				 <input id="<?php $this->print_control_uid('aspectRatio'); ?>" type="hidden" data-setting="aspectRatio" />
        			</div>
        		</div>

        		<# if ( data.description ) { #>
        			<div class="elementor-control-field-description">{{{ data.description }}}</div>
        		<# } #>
   		<?php
    }

}
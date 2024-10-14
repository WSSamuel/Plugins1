<?php

use Vardaam\FilterAnything\Helpers;

/** @var array $filter */

?>
<select
        name="<?php esc_attr_e( $filter['name'] ); ?><?php $filter['multiselect'] ? esc_attr_e( '[]' ) : esc_attr_e( '' ); ?>"
        id="<?php esc_attr_e( $filter['name'] ); ?>"
        data-placeholder="<?php carbon_get_post_meta( /** @var WP_Post $directory */ $directory->ID, 'show_labels_as_placeholders' ) ? esc_attr_e( $filter['label'] ) : esc_attr_e( $filter['placeholder'] ); ?>"
        class="wfa-select2"
	<?php echo $filter['multiselect'] ? 'multiple="multiple"' : ''; ?>
>
    <option></option>
	<?php $choices = Helpers::get_choices_array( $filter ); ?>
	<?php if ( ! empty( $choices ) && is_array( $choices ) ) : ?>
		<?php foreach ( $choices as $k => $v ) : ?>
			<?php
			$selected = '';
			if ( is_array( /** @var array|string $selectedValue */ $selectedValue ) && in_array( $k, $selectedValue ) ) {
				$selected = 'selected';
			} else {
				if ( $selectedValue !== '' && $k == $selectedValue ) {
					$selected = 'selected';
				}
			}
			?>
            <option value="<?php esc_attr_e( $k ); ?>" <?php echo $selected; ?>><?php _e( $v ); ?></option>
		<?php endforeach; ?>
	<?php endif; ?>
</select>
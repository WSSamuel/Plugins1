<?php /** @var array $filter */ ?>
<input
        type="text"
        name="<?php esc_attr_e( $filter['name'] ); ?>"
        id="<?php esc_attr_e( $filter['name'] ); ?>"
        placeholder="<?php /** @var WP_Post $directory */
		carbon_get_post_meta( $directory->ID, 'show_labels_as_placeholders' ) ? esc_attr_e( $filter['label'] ) : esc_attr_e( $filter['placeholder'] ); ?>"
        value="<?php /** @var string $selectedValue */
		esc_attr_e( $selectedValue ); ?>"
/>
<div class="wfa-form-sorting">
    <div class="wfa-total-records">
        <label><?php _e( 'Total records' ); ?>:</label><span>0</span>
    </div>
    <div class="wfa-sort-input">
        <label for="sort_by"><?php _e( 'Sort by' ); ?>:</label>
        <select name="sort_by" id="sort_by">
            <option value=""><?php _e( 'Select' ); ?></option>
            <option value="<?php esc_attr_e( 'newest' ); ?>"><?php _e( 'Newest' ); ?></option>
            <option value="<?php esc_attr_e( 'oldest' ); ?>"><?php _e( 'Oldest' ); ?></option>
            <option value="<?php esc_attr_e( 'atoz' ); ?>"><?php _e( 'A -> Z' ); ?></option>
            <option value="<?php esc_attr_e( 'ztoa' ); ?>"><?php _e( 'Z -> A' ); ?></option>
        </select>
    </div>
</div>
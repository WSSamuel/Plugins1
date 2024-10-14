<?php
defined( 'ABSPATH' ) || die;

if ( ! class_exists( 'RICAdminSettings' ) ) :

class RICAdminSettings
{
    private $definitions;
    private $options;
    
    public function __construct()
    {
        $this->options = null;
        
        $this->register_setting();
    }

    private function register_setting()
    {
    	// Register the settings
    	register_setting( RIC::admin_page(), RIC::option_name(), array( $this, 'sanitize_options' ) );
    }
    
    private function set_options()
    {
        if ( ! $this->options ) {
            include RIC::dir() . 'inc/class-ric-options.php';
            $this->options = RICOptions::get_instance();
        }
    }
    
    private function set_definitions()
    {
        if ( ! $this->definitions ) {
            include RIC::dir() . 'adm/function-ric-get-settings-definitions.php';
            $this->definitions = ric_get_settings_definitions();
        }
    }
    
    public function set_inputs()
    {
        $this->set_options();
        $this->set_definitions();
        
        foreach ( $this->definitions as $section ) {
            add_settings_section(
                $section['id'],
                $section['title'],
                array( $this, 'display_settings_description' ),
                RIC::admin_page()
            );
            
            $this->add_settings_fields( $section );
        }
    }
    
    public function display_settings_description( $args )
    {
        // Get the description
        foreach ( $this->definitions as $d ) {
            if ( $d['id'] == $args['id'] ) $description = $d['description'];
        }
        ?>
        <p><?php echo $description; ?></p>
        <?php
    }
    
    private function add_settings_fields( $section )
    {
        foreach ( $section['fields'] as $field ) {
            add_settings_field(
                $field['id'],
                $field['title'],
                array( $this, 'display_input' ),
                RIC::admin_page(),
                $section['id'],
                $field['args']
            );
        }
    }
    
    public function display_input( $args )
    {
        switch ( $args['type'] ) {
            case 'text':
                $this->display_text_input( $args );
                break;
            case 'select':
                $this->display_select_input( $args );
                break;
            case 'checkbox':
                $this->display_checkbox( $args );
                break;
        }
    }
    
    private function display_text_input( $args )
    {
        $name = substr( $args['id'], 4 );
        ?>
        <input type="text" id="<?php echo $args['id']; ?>" name="ric_options[<?php echo $name; ?>]" value="<?php echo $this->options->get( $name ); ?>" />
        
        <?php if ( isset( $args['help'] ) ) { ?>
        <p class="description"><?php echo $args['help']; ?></p>
        <?php }
    }
    
    private function display_select_input( $args )
    {
        $name = substr( $args['id'], 4 );
        $value = $this->options->get( $name );
        ?>
        <select id="<?php echo $args['id']; ?>" name="ric_options[<?php echo $name; ?>]">
            
            <?php foreach ( $args['options'] as $k => $v ) { ?>
            <option value="<?php echo $k; ?>" <?php selected( $k, $value, true ); ?>><?php echo $v; ?></option>
            <?php } ?>
            
        </select>
        
        <?php if ( isset( $args['help'] ) ) { ?>
        <p class="description"><?php echo $args['help']; ?></p>
        <?php }
    }
    
    private function display_checkbox( $args )
    {
        $name = substr( $args['id'], 4 );
        ?>
        <input type="checkbox" id="<?php echo $args['id']; ?>" name="ric_options[<?php echo $name; ?>]" value="1" <?php checked( 1, $this->options->get( $name ) ) ?> />
        <?php if ( isset( $args['label'] ) ) { ?>
        <label for="<?php echo $args['id']; ?>"><?php echo $args['label']; ?></label>
        <?php } ?>
        
        <?php if ( isset( $args['help'] ) ) { ?>
        <p class="description"><?php echo $args['help']; ?></p>
        <?php }
    }
    
    public function sanitize_options( $input )
    {
        $this->set_options();
        $this->set_definitions();
            
        $valid = array();
        
        foreach ( $this->definitions as $section ) {
            foreach ( $section['fields'] as $field ) {
                if ( method_exists( $this, $field['callback'] ) ) {
                    //$valid[$field['id']] = $this->$field['callback']( $input, $field );
                    $valid[$field['id']] = call_user_func( array( $this, $field['callback'] ), $input, $field );
                }
                else if ( is_callable( $field['callback'] ) ) {
                    $valid[$field['id']] = call_user_func( $field['callback'], $input, $field );
                }
            }
        }
        return $valid;
    }
    
    private function sanitize_text( $input, $field )
    {
        if ( isset( $input[$field['id']] ) ) {
            return sanitize_text_field( $input[$field['id']] );
        }
        return null;
    }
    
    private function sanitize_select( $input, $field )
    {
        if ( isset( $input[$field['id']] ) ) {
            if ( array_key_exists( $input[$field['id']], $field['args']['options'] ) ) {
                return $input[$field['id']];
            }
        }

        return $this->options->get_default( $field['id'] );
    }
    
    private function sanitize_checkbox( $input, $field )
    {
        if ( isset( $input[$field['id']] ) && $input[$field['id']] == 1 ) {
            return 1;
        }
        return 0;
    }
    
    private function sanitize_currency_code( $input, $field )
    {
        if ( ! isset( $input[$field['id']] ) ) {
            return null;
        }
        
		$value = strtoupper( preg_replace( '/[^a-z]/i', '', $input[$field['id']] ) );
		return substr( $value, 0, 3 );
    }
    
    private function sanitize_currency_format( $input, $field )
    {
        if ( ! isset( $input[$field['id']] ) || ! $input[$field['id']] ) {
            return $this->options->get( $field['id'] );
        }
        
        $regex = '![^(\{symbol\})|(\{amount\})|(\{code\})| ]!';
        
        $value = strtolower( trim( $input[$field['id']] ) );
        $value = preg_replace( $regex, '', $value );
        
        if ( $value == '' ) {
            return $this->options->get( $field['id'] );
        }
        else if ( substr_count( $value, '{amount}' ) == 0 ) {
            $value .= '{amount}';
        }
        
        return $value;
    }
    
    private function sanitize_int( $input, $field )
    {
        if ( isset( $input[$field['id']] ) ) {
            return floor( preg_replace( '/[^0-9.]/', '', $input[$field['id']] ) );
        }
        return null;
    }
    
    private function sanitize_class( $input, $field )
    {
        if ( isset( $input[$field['id']] ) ) {
            return preg_replace( '/[^a-z0-9 _-]/', '', strtolower( trim( $input[$field['id']] ) ) );
        }
        return null;
    }
}   
 
endif;

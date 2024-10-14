<?php
/*
Plugin Name: YM Contact Display
Description: Add contact display widget to show company name, address, phone, email etc
Plugin URI: http://www.youngminds.com.np
Version: 1.0
Author: Young Minds
Author URI: http://www.youngminds.com.np
License: none
*/

class ym_contact_display extends WP_Widget{
    function __construct(){
        parent::__construct(false,$name=__('YM Contact Display'));
    }
    function form($instance){
        if(isset($instance['ym_co_name']))
            $ym_co_name = $instance['ym_co_name'];
        else
            $ym_co_name = 'Young Minds Creation (P) Ltd';
        if(isset($instance['ym_address']))
            $ym_address = $instance['ym_address'];
        else
            $ym_address = '120, YM Tower, Kathmandu';
        if(isset($instance['ym_ph_no']))
            $ym_ph_no = $instance['ym_ph_no'];
        else
            $ym_ph_no = '+977-98511-51700';
        if(isset($instance['ym_fax']))
            $ym_fax = $instance['ym_fax'];
        else
            $ym_fax = '+977-4115-132';
        if(isset($instance['ym_eml']))
            $ym_eml = $instance['ym_eml'];
        else
            $ym_eml = 'support@yourco.com';
        if(isset($instance['ym_co_stxt']))
            $ym_co_stxt = $instance['ym_co_stxt'];
        else
            $ym_co_stxt = 'A Company Legally Registered in US with Co. Regd. No. 6542398/541/52';
        if(isset($instance['ym_add_stxt']))
            $ym_add_stxt = $instance['ym_add_stxt'];
        else
            $ym_add_stxt = 'We are OPEN 09:00-18:00 hours Mon-Fri';
        if(isset($instance['ym_ph_stxt']))
            $ym_ph_stxt = $instance['ym_ph_stxt'];
        else
            $ym_ph_stxt = 'Please feel free to call us 24x7';
        if(isset($instance['ym_fax_stxt']))
            $ym_fax_stxt = $instance['ym_fax_stxt'];
        else
            $ym_fax_stxt = 'We have dedicated Fax number turned on 24x7';
        if(isset($instance['ym_eml_stxt']))
            $ym_eml_stxt = $instance['ym_eml_stxt'];
        else
            $ym_eml_stxt = 'We reply to all emails within 2 business days';

        ?>

        <table border="0" width="100%" style="padding:10px 0;">
            <tr>
                <td width="40%">Company</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_co_name' ); ?>" name="<?php echo $this->get_field_name( 'ym_co_name' ); ?>" type="text" value="<?php echo esc_attr( $ym_co_name ); ?>"></td>
            </tr>
            <tr>
                <td>Co. Sub Text</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_co_stxt' ); ?>" name="<?php echo $this->get_field_name( 'ym_co_stxt' ); ?>" type="text" value="<?php echo esc_attr( $ym_co_stxt ); ?>"></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_address' ); ?>" name="<?php echo $this->get_field_name( 'ym_address' ); ?>" type="text" value="<?php echo esc_attr( $ym_address ); ?>"></td>
            </tr>
            <tr>
                <td>Add. Sub Text</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_add_stxt' ); ?>" name="<?php echo $this->get_field_name( 'ym_add_stxt' ); ?>" type="text" value="<?php echo esc_attr( $ym_add_stxt ); ?>"></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_ph_no' ); ?>" name="<?php echo $this->get_field_name( 'ym_ph_no' ); ?>" type="text" value="<?php echo esc_attr( $ym_ph_no ); ?>"></td>
            </tr>
            <tr>
                <td>Ph. Sub Text</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_ph_stxt' ); ?>" name="<?php echo $this->get_field_name( 'ym_ph_stxt' ); ?>" type="text" value="<?php echo esc_attr( $ym_ph_stxt ); ?>"></td>
            </tr>
            <tr>
                <td>Fax</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_fax' ); ?>" name="<?php echo $this->get_field_name( 'ym_fax' ); ?>" type="text" value="<?php echo esc_attr( $ym_fax ); ?>"></td>
            </tr>
            <tr>
                <td>Fax Sub Text</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_fax_stxt' ); ?>" name="<?php echo $this->get_field_name( 'ym_fax_stxt' ); ?>" type="text" value="<?php echo esc_attr( $ym_fax_stxt ); ?>"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_eml' ); ?>" name="<?php echo $this->get_field_name( 'ym_eml' ); ?>" type="text" value="<?php echo esc_attr( $ym_eml ); ?>"></td>
            </tr>
            <tr>
                <td>Eml Sub Text</td>
                <td><input id="<?php echo $this->get_field_id( 'ym_eml_stxt' ); ?>" name="<?php echo $this->get_field_name( 'ym_eml_stxt' ); ?>" type="text" value="<?php echo esc_attr( $ym_eml_stxt ); ?>"></td>
            </tr>
        </table>

        <?php
    }//function form()
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['ym_co_name'] = ( ! empty( $new_instance['ym_co_name'] ) ) ? strip_tags( $new_instance['ym_co_name'] ) : '';
        $instance['ym_address'] = ( ! empty( $new_instance['ym_address'] ) ) ? strip_tags( $new_instance['ym_address'] ) : '';
        $instance['ym_ph_no'] = ( ! empty( $new_instance['ym_ph_no'] ) ) ? strip_tags( $new_instance['ym_ph_no'] ) : '';
        $instance['ym_fax'] = ( ! empty( $new_instance['ym_fax'] ) ) ? strip_tags( $new_instance['ym_fax'] ) : '';
        $instance['ym_eml'] = ( ! empty( $new_instance['ym_eml'] ) ) ? strip_tags( $new_instance['ym_eml'] ) : '';

        $instance['ym_co_stxt'] = ( ! empty( $new_instance['ym_co_stxt'] ) ) ? strip_tags( $new_instance['ym_co_stxt'] ) : '';
        $instance['ym_add_stxt'] = ( ! empty( $new_instance['ym_add_stxt'] ) ) ? strip_tags( $new_instance['ym_add_stxt'] ) : '';
        $instance['ym_ph_stxt'] = ( ! empty( $new_instance['ym_ph_stxt'] ) ) ? strip_tags( $new_instance['ym_ph_stxt'] ) : '';
        $instance['ym_fax_stxt'] = ( ! empty( $new_instance['ym_fax_stxt'] ) ) ? strip_tags( $new_instance['ym_fax_stxt'] ) : '';
        $instance['ym_eml_stxt'] = ( ! empty( $new_instance['ym_eml_stxt'] ) ) ? strip_tags( $new_instance['ym_eml_stxt'] ) : '';

        return $instance;
    }

    function widget($args, $instance){
        extract( $args );
        echo $before_widget;
        $text = '<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">';
        $text .= '<div class="ym-contact-display">';
        $text .= ( !empty( $instance['ym_co_name'] ) ) ? '<h3><i class="fa fa-info-circle"></i>' . $instance['ym_co_name'] . '</h3><p class="address pad-bot1">' . $instance['ym_co_stxt'] . '</p>' : '';
        $text .= ( !empty( $instance['ym_address'] ) ) ? '<h3><i class="fa fa-map-marker"></i>' . $instance['ym_address'] . '</h3><p class="address pad-bot1">' . $instance['ym_add_stxt'] . '</p>' : '';
        $text .= ( !empty( $instance['ym_ph_no'] ) ) ? '<h3><i class="fa fa-phone"></i>' . $instance['ym_ph_no'] . '</h3><p class="address pad-bot1">' . $instance['ym_ph_stxt'] . '</p>' : '';
        $text .= ( !empty( $instance['ym_fax'] ) ) ? '<h3><i class="fa fa-fax"></i>' . $instance['ym_fax'] . '</h3><p class="address pad-bot1">' . $instance['ym_fax_stxt'] . '' : '';
        $text .= ( !empty( $instance['ym_eml'] ) ) ? '<h3><i class="fa fa-envelope"></i>' . $instance['ym_eml'] . '</h3><p class="address pad-bot72">' . $instance['ym_eml_stxt'] . '</p>' : '';

        $text .= '</div>';

        echo $text . $after_widget;


    }
}
//widget hook
add_action('widgets_init',
    create_function('', 'return register_widget("ym_contact_display");')
);
?>
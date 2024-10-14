<?php
/*
Plugin Name: Tỷ Giá Vàng Ngoại Tệ
Plugin URI: https://www.webtygia.com/
Description: Widget Tỷ giá, Giá Vàng, Xăng dầu, chuyển đổi ngoại tệ, coin, tiền điện tử, lãi suất vay, lãi suất gửi.
Version: 2.0
Author: Overnight21
Author URI: https://profiles.wordpress.org/overnight21/
License: GPLv2 or later
*/

function register_ty_gia_vang_widget() {
    register_widget( 'Ty_Gia_Vang_Widget' );
}
add_action( 'widgets_init', 'register_ty_gia_vang_widget' );

class Ty_Gia_Vang_Widget extends WP_Widget {

    public $types=array(
        'rate'=>'Ngoại tệ',
        'bank'=>'Tỷ giá Ngân Hàng',
        'gold'=>'Giá vàng',
        'oil'=>'Giá Xăng Dầu',
        'tool_rate'=>'Chuyển đổi tiền tệ',
        'coin'=>'Tiền ảo',
        'interest_rate_deposit'=>'Lãi suất tiền gửi',
        'interest_rate_loan'=>'Lãi suất tiền vay',
        'giaca' => 'Giá cả thị trường',
            
    );

    public $maNT = array(
        'sjc' => 'SJC',  
        'doji' => 'Doji',   
        'bank' => 'Các ngân hàng', 
        'pnj' => 'PNJ', 
        'ngochai' => 'Ngọc Hải', 
        'mihong' => 'Mi Hồng', 
        'btmc' => 'Bảo Tín Minh Châu',
        'phuquy' => 'Phú Quý',
    );

    public $oils = array(
        'trongnuoc' => 'Trong nước',  
        'thegioi' => 'Thế giới',   
        
    );

    
    public $banks=array(
        'VietinBank' => 'VietinBank',
        'ACB' => 'ACB',
        'BIDV' => 'BIDV',
        'MBBank' => 'MBBank',
        'SHB' => 'SHB',
        'Sacombank' => 'Sacombank',
        'Techcombank' => 'Techcombank',
        'Vietcombank' => 'Vietcombank',
        'ABBANK' => 'ABBANK',
        'BVBANK' => 'BVBANK',
        'EXIMBANK' => 'EXIMBANK',
        'HDBANK' => 'HDBANK',
        'HSBC' => 'HSBC',
        'KienLongBank' => 'KienLongBank',
        'MaritimeBank' => 'MaritimeBank',
        'OCB' => 'OCB',
        'PGBank' => 'PGBank',
        'NHNN' => 'NHNN',
        'PVCOMBank' => 'PVCOMBank',
        'SCB' => 'SCB',
        'TPBANK' => 'TPBANK',
        'VIB' => 'VIB',
        'VCCB' => 'VCCB',
        'LIENVIETPOSTBANK' => 'LIENVIETPOSTBANK',
        'Agribank' => 'Agribank',
        'CBBank' => 'CBBank',
        'DongA' => 'DongA',
        'GPBANK' => 'GPBANK',
        'HLBANK' => 'HLBANK',
    );

    public $rates=array(
        'aud' => 'Đô la Australia - aud',
        'cad' => 'Đô la Canada - cad',
        'chf' => 'Franc Thụy sĩ - chf',
        'cny' => 'Nhân dân tệ - cny',
        'dkk' => 'Krone Đan Mạch - dkk',
        'eur' => 'Euro - eur',
        'gbp' => 'Bảng Anh - gbp',
        'hkd' => 'Đô la Hồng Kông - hkd',
        'idr' => 'Rupiah Indonesia - idr',
        'inr' => 'Rupee Ấn Độ - inr',
        'jpy' => 'Yên Nhật - jpy',
        'krw' => 'Won Hàn Quốc - krw',
        'kwd' => 'Dinar Kuwait - kwd',
        'lak' => 'Kip Lào - lak',
        'mxn' => 'Peso Mexico - mxn',
        'myr' => 'Ringgit Malaysia - myr',
        'nok' => 'Krone Na Uy - nok',
        'nzd' => 'Đô la New Zealand - nzd',
        'php' => 'Peso Philipin - php',
        'rub' => 'Rúp Nga - rub',
        'sar' => 'Riyal Ả Rập Saudi - sar',
        'sek' => 'Krona Thụy Điển - sek',
        'sgd' => 'Đô la Singapore - sgd',
        'thb' => 'Bạt Thái Lan - thb',
        'twd' => 'Đô la Đài Loan - twd',
        'usd' => 'Đô la Mỹ - usd',
        'usd-5-20' => 'Đô la Mỹ Đồng 1,2 - usd-12',
        'usd-12' => 'Đô La Mỹ Đồng 5 - 20 - usd-5-20',
        'usd-50-100' => 'Đô La Mỹ Đồng 50 - 100 - usd-50-100',
        'usd-51020' => 'Đô la Mỹ Đồng 5,10,20 - usd-51020',
        'usd-15' => 'Đô la Mỹ Đồng 1,5 - usd15 ',
        'zar' => 'Rand Nam Phi - zar',
    );

    public $giaca=array(
        'ca-phe' => 'Giá Cà Phê',
        'thit-heo' => 'Giá Thịt Heo',
    );

    
    public function __construct() {


        parent::__construct(
                'ty_gia_vang_widget', // Base ID
                'Web Tỷ giá', // Name
                array( 'description' =>'Tỷ giá, Giá Vàng, Giá xăng dầu, giá coin,bảng lãi suất') // Args
        );

    }
    //show ra ngoài
    public function widget( $args, $instance ) {
        

        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        //color
        $bgheader=str_replace("#", "", $instance['bgheader']);
        if($bgheader==null){
            $color='333333';
        }
        

        $colorheader=str_replace("#", "", $instance['colorheader']);
        if($colorheader==null ){
            $colorheader= "fefefe";
        }

        

        $padding=$instance['padding'];
        if($padding==null  ){
            $padding= "5";
        }

         
        $css=$instance['css'];
        if($css==null)$css='';
        $css=str_replace('#','%23',str_replace('\r','',str_replace('\n','',$css)));

        
        //size
        $fontsize=$instance['fontsize'];
        if($fontsize==null ){
                $fontsize=12;
        }

        $new_args="&fontsize=".$fontsize . "&bgheader=".$bgheader."&colorheader=".$colorheader."&padding=".$padding."&css=".htmlspecialchars($css, ENT_QUOTES);


        $language=$instance['language'];
        switch ($instance['type']) {
            case 'coin':
                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/coin-embed?$new_args&hienthi='></iframe>";
                break;
            case 'rate':
            $isos='';
                foreach ($this->rates as $key=>$value) {
                    if (1== $instance[$key] ){
                        if($isos!='')
                            $isos =$isos.','.$key;
                        else
                            $isos=$key;

                    }
                }
                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/ngoaite?$new_args&hienthi=$isos'></iframe>";
                break;
            case 'tool_rate':
                $isos='';
                foreach ($this->rates as $key=>$value) {
                    if (1== $instance[$key] ){
                        if($isos!='')
                            $isos =$isos.','.$key;
                        else
                            $isos=$key;

                    }
                }
                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/cong-cu-chuyen-doi-tien-te?$new_args&hienthi=$isos'></iframe>";
                break;
            case 'bank':
                $isos='';
                foreach ($this->banks as $key=>$value) {
                    if (1== $instance[$key] ){
                        if($isos!='')
                            $isos =$isos.','.$key;
                        else
                            $isos=$key;

                    }
                }
                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/tygia?$new_args&hienthi=$isos'></iframe>";
                break;
            case 'gold':
                $isos='';
                foreach ($this->maNT as $key=>$value) {
                    if (1== $instance[$key] ){
                        if($isos!='')
                            $isos =$isos.','.$key;
                        else
                            $isos=$key;

                    }
                }

                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/vang?$new_args&hienthi=$isos'></iframe>";
                break;
            case 'oil':
                $isos='';
                foreach ($this->oils as $key=>$value) {
                    if (1== $instance[$key] ){
                        if($isos!='')
                            $isos =$isos.','.$key;
                        else
                            $isos=$key;

                    }
                }

                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/xang-dau?$new_args&hienthi=$isos'></iframe>";
                break;
            case 'interest_rate_deposit':
                $isos='';
                foreach ($this->banks as $key=>$value) {
                    if (1== $instance[$key] ){
                        if($isos!='')
                            $isos =$isos.','.$key;
                        else
                            $isos=$key;

                    }
                }
                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/laisuat?$new_args&hienthi=$isos'></iframe>";
                break;
            case 'interest_rate_loan':
                $isos='';
                foreach ($this->banks as $key=>$value) {
                    if (1== $instance[$key] ){
                        if($isos!='')
                            $isos =$isos.','.$key;
                        else
                            $isos=$key;

                    }
                }
                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/laisuatchovay?$new_args&hienthi=$isos'></iframe>";
                break;

            case 'giaca':
                $isos='';
                foreach ($this->giaca as $key=>$value) {
                    if (1== $instance[$key] ){
                        if($isos!='')
                            $isos =$isos.','.$key;
                        else
                            $isos=$key;

                    }
                }
                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/gia-ca-thi-truong?$new_args&hienthi=$isos'></iframe>";
                break;

            default:
                echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//webtygia.com/api/vang?$new_args'></iframe>";
                break;
        }
        
        echo $args['after_widget'];
    }
    //update
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['type'] = strip_tags($new_instance['type']);
        $instance['fontsize'] = strip_tags($new_instance['fontsize']);
        $instance['padding'] = strip_tags($new_instance['padding']);
        $instance['width'] = strip_tags($new_instance['width']);
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['colorheader'] = strip_tags($new_instance['colorheader']);//ffffff
        $instance['bgheader'] = strip_tags($new_instance['bgheader']);//null
        $instance['css'] = strip_tags($new_instance['css']);
        $instance['language'] = strip_tags($new_instance['language']);
        foreach ($this->maNT as $key=>$value) {
            $instance[$key] = !empty($new_instance[$key]) ? 1 : 0;
        }
        foreach ($this->banks as $key=>$value) {
            $instance[$key] = !empty($new_instance[$key]) ? 1 : 0;
        }

        foreach ($this->types as $key=>$value) {
            $instance[$key] = !empty($new_instance[$key]) ? $key : 0;
        }

        foreach ($this->rates as $key=>$value) {
            $instance[$key] = !empty($new_instance[$key]) ? 1 : 0;
        }

        foreach ($this->oils as $key=>$value) {
            $instance[$key] = !empty($new_instance[$key]) ? 1 : 0;
        }

        foreach ($this->giaca as $key=>$value) {
            $instance[$key] = !empty($new_instance[$key]) ? 1 : 0;
        }

        return $instance;
    }
    //form trong widget
    public function form( $instance ) {
        
        $instance = wp_parse_args( (array) $instance, array( 
            'width'=>'100%',
            'height'=>'300',
            'fontsize'=>'10',
            'padding'=>'5',
            'colorheader'=>'#ffffff',
            'bgheader'=>'#c63f3f',   
            'css' => '' 
        ));

        $title = ! empty( $instance['title'] ) ? $instance['title'] : 'Tỷ giá ngoại tệ';
         
        $fontsize = $instance['fontsize'] ;
        $padding = $instance['padding'] ;
        $colorheader = $instance['colorheader'] ;
        $bgheader = $instance['bgheader'] ;
        $css = $instance['css'] ;
        
        

        if($fontsize==null)$fontsize=13;
        foreach ($this->maNT as $key=>$value) {
            $instance[$key] = isset($instance[$key]) ? (bool) $instance[$key] :false;
        } 

        foreach ($this->banks as $key=>$value) {
            $instance[$key] = isset($instance[$key]) ? (bool) $instance[$key] :false;
        } 
        foreach ($this->types as $key=>$value) {
            $instance[$key] = isset($instance[$key]) ? (bool) $instance[$key] :false;
        }

        foreach ($this->rates as $key=>$value) {
            $instance[$key] = isset($instance[$key]) ? (bool) $instance[$key] :false;
        } 

        foreach ($this->oils as $key=>$value) {
            $instance[$key] = isset($instance[$key]) ? (bool) $instance[$key] :false;
        } 

        foreach ($this->giaca as $key=>$value) {
            $instance[$key] = isset($instance[$key]) ? (bool) $instance[$key] :false;
        } 

        ?>


        

        <div  style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Tiêu đề:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

        </div>

        <div  style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'type' ); ?>">Loại hiển thị</label>
             
            <div class='clear:both'></div>
            <select class="ty-gia-types" style='width:100%' name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>">
                <?php foreach ($this->types as $key=>$value) {
                    echo "<option ".selected( $instance['type'], $key )." value='$key'>$value </option>";
                } ?>
            </select>
        </div>

            
        <div class="gold-show hidden"  style="padding: 5px 0 5px 0;   display: none; width: 100%">
            <label style='width:50%' for="<?php echo $this->get_field_id( 'gold' ); ?>">Chọn loại vàng</label>
            
            <div class='clear:both'></div>
            <div style='max-height: 100px; overflow-y: scroll;border:solid 1px #aaa; '>
                <?php foreach ($this->maNT as $key=>$value) { ?>
                     
                    <input name-show="<?php echo $key; ?>" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" <?php checked( $instance[$key] ); ?> class="checkbox" type="checkbox"> <label
                            for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $value; ?></label> <br>
                <?php } ?>
            </div>
            
        </div>
         
        <div class="bank-show hidden"  style="padding: 5px 0 5px 0;   display: none; width: 100%">
            <label style='width:50%'>Chọn ngân hàng</label>
            
            <div class='clear:both'></div>
            <div style='max-height: 100px; overflow-y: scroll;border:solid 1px #aaa; '>
                <?php foreach ($this->banks as $key=>$value) { ?>
                     
                    <input name-show="<?php echo $key; ?>" id="<?php $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" <?php checked( $instance[$key] ); ?> class="checkbox" type="checkbox"> <label
                            for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $value; ?></label> <br>
                <?php } ?>
            </div>
            
        </div>


        <div class="rate-show hidden"  style="padding: 5px 0 5px 0;   display: none; width: 100%">
            <label style='width:50%'>Chọn ngoại tệ</label>
            
            <div class='clear:both'></div>
            <div style='max-height: 100px; overflow-y: scroll;border:solid 1px #aaa; '>
                <?php foreach ($this->rates as $key=>$value) { ?>
                     
                    <input name-show="<?php echo $key; ?>" id="<?php $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" <?php checked( $instance[$key] ); ?> class="checkbox" type="checkbox"> <label
                            for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $value; ?></label> <br>
                <?php } ?>
            </div>
            
        </div>

        <div class="giaca-show hidden"  style="padding: 5px 0 5px 0;   display: none; width: 100%">
            <label style='width:50%' for="<?php echo $this->get_field_id( 'giaca' ); ?>">Chọn loại giá</label>
            
            <div class='clear:both'></div>
            <div style='max-height: 100px; overflow-y: scroll;border:solid 1px #aaa; '>
                <?php foreach ($this->giaca as $key=>$value) { ?>
                     
                    <input name-show="<?php echo $key; ?>" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" <?php checked( $instance[$key] ); ?> class="checkbox" type="checkbox"> <label
                            for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $value; ?></label> <br>
                <?php } ?>
            </div>
            
        </div>

        <div class="oil-show hidden"  style="padding: 5px 0 5px 0;   display: none; width: 100%">
            <label style='width:50%'>Chọn Loại</label>
            
            <div class='clear:both'></div>
            <div style='max-height: 100px; overflow-y: scroll;border:solid 1px #aaa; '>
                <?php foreach ($this->oils as $key=>$value) { ?>
                     
                    <input name-show="<?php echo $key; ?>" id="<?php $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" <?php checked( $instance[$key] ); ?> class="checkbox" type="checkbox"> <label
                            for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $value; ?></label> <br>
                <?php } ?>
            </div>
            
        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <div style="width: 50%; float: left;">
                <label title="Chiều rộng widget " for="<?php echo $this->get_field_id( 'width' ); ?>">Width</label> <input class="ty-gia-width" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value='<?php echo esc_attr( $instance['width']); ?>' class="checkbox" type="text">

            </div>
            <div style="width: 50%; float: left;">
                <label title='Chiều cao widget' for="<?php echo $this->get_field_id( 'height' ); ?>">Height</label> <input class="ty-gia-height" placeholder="300" id="<?php echo $this->get_field_id( 'height' ); ?>"  name="<?php echo $this->get_field_name( 'height' ); ?>" value='<?php echo esc_attr( $instance['height']); ?>' class="checkbox" type="text">
            </div>
        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'color' ); ?>">Màu nền tiêu đề bảng</label>
            <input  class="ty-gia-background-title" style="float: right; width: 45%"  placeholder="1d4c75" id="<?php echo $this->get_field_id( 'bgheader' ); ?>" name="<?php echo $this->get_field_name( 'bgheader' ); ?>" value='<?php echo esc_attr( $bgheader ); ?>' class="checkbox" type="color">
        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'titleColor' ); ?>">Màu chữ tiêu đề bảng</label>
            <input class="ty-gia-color-title" style="float: right; width: 45%"  placeholder="fefefe" id="<?php echo $this->get_field_id( 'colorheader' ); ?>" name="<?php echo $this->get_field_name( 'colorheader' ); ?>" value='<?php echo esc_attr( $colorheader ); ?>' class="checkbox" type="color">
        </div>
         
        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'textColor' ); ?>">Độ giãn cách các cột trong bảng(px)</label>
            <input class="ty-gia-padding" style="float: right;"  placeholder="333333" id="<?php echo $this->get_field_id( 'padding' ); ?>" name="<?php echo $this->get_field_name( 'padding' ); ?>" value='<?php echo esc_attr( $padding ); ?>' class="checkbox" type="number">
        </div>
        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'font_size' ); ?>">Size chữ(px)</label>
            <input class="ty-gia-font-size" style="float: right;"  placeholder="333333" id="<?php echo $this->get_field_id( 'fontsize' ); ?>" name="<?php echo $this->get_field_name( 'fontsize' ); ?>" value='<?php echo esc_attr( $fontsize ); ?>' class="checkbox" type="number">
        </div>
        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <div title="Tùy chọn CSS">Customize css:</div>
            <textarea  placeholder=".table{display: table-row !important;}" style="width: 100%;" rows="3" placeholder="" id="<?php echo $this->get_field_id( 'css' ); ?>" name="<?php echo $this->get_field_name( 'css' ); ?>"  class="textarea" ><?php echo esc_attr( $css ); ?></textarea>
        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <button type="button" class="btn-preview-ty-gia button button-primary">Xem trước</button>
        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%" class="div-preview-ty-gia">
             
        </div>
        <?php

        //add js
        wp_enqueue_script( 'script-web-ty-gia', plugin_dir_url( __FILE__ ) . 'js/custom.js', array(), '1.0.0', true );
    }
}

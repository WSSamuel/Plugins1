<?php 
class keyspider_common{
    public function init(){
        add_action('wp', [$this,'baiduseo_init_session']);

        if(is_admin()){
            add_action( 'admin_enqueue_scripts', [$this,'baiduseo_enqueue'] );
            add_filter('plugin_action_links_'.KEYSPIDER_NAME, [$this,'spider_plugin_action_links']);
            add_action('admin_menu', [$this,'baiduseo_addpages']);
        }
        add_action('wp_footer', [$this,'baiduseo_wztkjseo']);
        add_action('wp_ajax_keyspider_liuliang_log', [$this,'baiduseo_liuliang_log']);
        add_action('wp_ajax_nopriv_keyspider_liuliang_log', [$this,'baiduseo_liuliang_log']);

    }
    public function baiduseo_init_session(){
        if (!session_id()) {
            ob_start();
            session_start();
            ob_end_flush();
        }
    }
     public function baiduseo_liuliang_log(){
        if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
            global $wpdb;
            $currnetTime = current_time('Y-m-d H:i:s');
            $shibie = md5(sanitize_text_field($_POST['userAgent']).sanitize_text_field($_POST['allCookies']).sanitize_text_field($_POST['ip']).sanitize_text_field($_POST['currentUrl']).sanitize_text_field($_POST['referrer']).sanitize_text_field($_POST['baiduseo_time']));
            $res = $wpdb->get_results($wpdb->prepare(' select * from  '.$wpdb->prefix.'baiduseo_liuliang where shibie="%s"',$shibie),ARRAY_A);
            if(!empty($res[0])){
                $wpdb->update($wpdb->prefix . 'baiduseo_liuliang',['updatetime'=>$currnetTime],['id'=>$res[0]['id']]);
            }else{
                if(!sanitize_url($_POST['referrer'])){
                    $res = $wpdb->get_results($wpdb->prepare(' select id from  '.$wpdb->prefix.'baiduseo_liuliang where session="%s" and status=1 order by id desc limit 1',sanitize_text_field($_POST['session'])),ARRAY_A);
                    $count = $wpdb->query($wpdb->prepare(' select * from  '.$wpdb->prefix.'baiduseo_liuliang where session="%s" and status=1',sanitize_text_field($_POST['session'])),ARRAY_A);
                    if(!empty($res[0])){
                        $wpdb->insert($wpdb->prefix . 'baiduseo_liuliang',['source'=>sanitize_url($_POST['referrer'])?sanitize_url($_POST['referrer']):'直接访问','url'=>sanitize_url($_POST['currentUrl']),'time'=>$currnetTime,'ip'=>sanitize_text_field($_POST['ip'])=='unknown'?'':sanitize_text_field($_POST['ip']),'shibie'=>$shibie,'session'=>sanitize_text_field($_POST['session']),'type'=>(int)$_POST['baiduseo_type'],'status'=>1,'lan'=>sanitize_text_field($_POST['baiduseo_language']),'pla'=>sanitize_text_field($_POST['baiduseo_pla']),'liulanqi'=>sanitize_text_field($_POST['baiduseo_liulanqi']),'is_new'=>1,'pinci'=>$count]);
                    }else{
                        $wpdb->insert($wpdb->prefix . 'baiduseo_liuliang',['source'=>sanitize_url($_POST['referrer'])?sanitize_url($_POST['referrer']):'直接访问','url'=>sanitize_url($_POST['currentUrl']),'time'=>$currnetTime,'ip'=>sanitize_text_field($_POST['ip'])=='unknown'?'':sanitize_text_field($_POST['ip']),'shibie'=>$shibie,'session'=>sanitize_text_field($_POST['session']),'type'=>(int)$_POST['baiduseo_type'],'status'=>1,'lan'=>sanitize_text_field($_POST['baiduseo_language']),'pla'=>sanitize_text_field($_POST['baiduseo_pla']),'liulanqi'=>sanitize_text_field($_POST['baiduseo_liulanqi']),'is_new'=>0]);
                    }
                }else{
                    $res = $wpdb->get_results($wpdb->prepare(' select * from  '.$wpdb->prefix.'baiduseo_liuliang where session="%s" and status=1 order by id desc limit 1',sanitize_text_field($_POST['session'])),ARRAY_A);
                    if(isset($res[0])){
                        $wpdb->insert($wpdb->prefix . 'baiduseo_liuliang',['source'=>sanitize_url($_POST['referrer'])?sanitize_url($_POST['referrer']):'直接访问','url'=>sanitize_url($_POST['currentUrl']),'time'=>$currnetTime,'ip'=>sanitize_text_field($_POST['ip'])=='unknown'?'':sanitize_text_field($_POST['ip']),'shibie'=>$shibie,'session'=>sanitize_text_field($_POST['session']),'type'=>(int)$_POST['baiduseo_type'],'pid'=>$res[0]['id'],'lan'=>sanitize_text_field($_POST['baiduseo_language']),'pla'=>sanitize_text_field($_POST['baiduseo_pla']),'liulanqi'=>sanitize_text_field($_POST['baiduseo_liulanqi'])]);
                        $wpdb->update($wpdb->prefix . 'baiduseo_liuliang',['shendu'=>$res[0]['shendu']+1],['id'=>$res[0]['id']]);
                    }
                }
            }
        }
        
    }
    public function baiduseo_wztkjseo(){
       
        global $keyspider_wzt_log;
        
        if(!$keyspider_wzt_log){
         echo '<script>
            console.log("\n%c 沃之涛科技 %c https://rbzzz.com \n", "color: #fff;background-image: linear-gradient(90deg, red 0%, red 100%);padding:5px 1px;", "color: #fff;background-image: linear-gradient(90deg, red 0%, rgb(255, 255, 255) 100%);padding:5px 0;width: 200px;display: inline-block;");
            </script>';
        }
        if($keyspider_wzt_log){
            $baiduseo_liuliang = get_option('baiduseo_liuliang');
            if(isset($baiduseo_liuliang['open']) && $baiduseo_liuliang['open']){
                if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                    $baiduseo_ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
                }elseif(isset($_SERVER['REMOTE_ADDR'])){
                    $baiduseo_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
                }else{
                    $baiduseo_ip = '';
                }
                $baiduseo_time = time();
                if(!isset($_SESSION['baiduseo_liulan'])){
                    $_SESSION['baiduseo_liulan'] = md5($baiduseo_ip.rand(1000000,999999));
                }
                
                ?>
                     <script>
                     function baiduseo_getBrowserType() {
                        
                          // 获取浏览器 userAgent
                          var ua = navigator.userAgent
                          
                          // 是否为 Opera
                          var isOpera = ua.indexOf('Opera') > -1
                          // 返回结果
                          if (isOpera) { return 'Opera' }
                        
                          // 是否为 IE
                          var isIE = (ua.indexOf('compatible') > -1) && (ua.indexOf('MSIE') > -1) && !isOpera
                          var isIE11 = (ua.indexOf('Trident') > -1) && (ua.indexOf("rv:11.0") > -1)
                          // 返回结果
                          if (isIE11) { return 'IE11'
                          } else if (isIE) {
                            // 检测是否匹配
                            var re = new RegExp('MSIE (\\d+\\.\\d+);')
                            re.test(ua)
                            // 获取版本
                            var ver = parseFloat(RegExp["$1"])
                            // 返回结果
                            if (ver == 7) { return 'IE7'
                            } else if (ver == 8) { return 'IE8'
                            } else if (ver == 9) { return 'IE9'
                            } else if (ver == 10) { return 'IE10'
                            } else { return "IE" }
                          }
                        
                          // 是否为 Edge
                          var isEdge = ua.indexOf("Edge") > -1
                          // 返回结果
                          if (isEdge) { return 'Edge' }
                        
                          // 是否为 Firefox
                          var isFirefox = ua.indexOf("Firefox") > -1
                          // 返回结果
                          if (isFirefox) { return 'Firefox' }
                        
                          // 是否为 Safari
                          var isSafari = (ua.indexOf("Safari") > -1) && (ua.indexOf("Chrome") == -1)
                          // 返回结果
                          if (isSafari) { return "Safari" }
                        
                          // 是否为 Chrome
                          var isChrome = (ua.indexOf("Chrome") > -1) && (ua.indexOf("Safari") > -1) && (ua.indexOf("Edge") == -1)
                          // 返回结果
                          if (isChrome) { return 'Chrome' }
                        
                          // 是否为 UC
                          var isUC= ua.indexOf("UBrowser") > -1
                          // 返回结果
                          if (isUC) { return 'UC' }
                        
                          // 是否为 QQ
                          var isQQ= ua.indexOf("QQBrowser") > -1
                          // 返回结果
                          if (isUC) { return 'QQ' }
                        
                          // 都不是
                          return ''
                        }
                     function baiduseo_getUserOsInfo() {
                        const userAgent = navigator.userAgent;
                        if (userAgent.indexOf("Windows NT 10.0") !== -1) return "Windows 10";
                        if (userAgent.indexOf("Windows NT 6.2") !== -1) return "Windows 8";
                        if (userAgent.indexOf("Windows NT 6.1") !== -1) return "Windows 7";
                        if (userAgent.indexOf("Windows NT 6.0") !== -1) return "Windows Vista";
                        if (userAgent.indexOf("Windows NT 5.1") !== -1) return "Windows XP";
                        if (userAgent.indexOf("Windows NT 5.0") !== -1) return "Windows 2000";
                        if (userAgent.indexOf("Mac") !== -1) return "Mac/iOS";
                        if (userAgent.indexOf("X11") !== -1) return "UNIX";
                        if (userAgent.indexOf("Linux") !== -1) return "Linux";
                        return "Other";
                     }
                 // 定义发送请求的函数
                 function baiduseo_sendRequest() {
                        var baiduseo_ip = '<?php echo $baiduseo_ip?>'
                        var baiduseo_nonce = '<?php echo esc_attr(wp_create_nonce('baiduseo'));?>'
                        var baiduseo_action = 'keyspider_liuliang_log'
                        var baiduseo_userAgent = navigator.userAgent
                        var baiduseo_referrer = document.referrer;
                         var baiduseo_currentUrl = window.location.href;
                          var baiduseo_allCookies = document.cookie;
                         var baiduseo_session ='<?php echo esc_attr(sanitize_text_field($_SESSION['baiduseo_liulan']));?>';
                         var baiduseo_time = '<?php echo $baiduseo_time;?>';
                          var baiduseo_language = navigator.language || navigator.userLanguage;
                         var baiduseo_pla = baiduseo_getUserOsInfo();
                          var baiduseo_liulanqi = baiduseo_getBrowserType();
                         if(/mobile/i.test(baiduseo_userAgent)){
                             var baiduseo_type =2;
                         }else{
                              var baiduseo_type =1;
                           }
                           var xhr = new XMLHttpRequest();
                           xhr.open('POST', '<?php echo esc_url(admin_url('admin-ajax.php')); ?>', true);
                           xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                           xhr.onreadystatechange = function () {
                           };
                           var requestData = 'ip=' + baiduseo_ip + '&userAgent=' + baiduseo_userAgent + '&referrer=' + baiduseo_referrer + '&currentUrl=' + baiduseo_currentUrl + '&allCookies=' + baiduseo_allCookies + '&nonce=' + baiduseo_nonce + '&action=' + baiduseo_action+'&baiduseo_time='+baiduseo_time+'&session='+baiduseo_session+'&baiduseo_type='+baiduseo_type+'&baiduseo_language='+baiduseo_language+'&baiduseo_pla='+baiduseo_pla+'&baiduseo_liulanqi='+baiduseo_liulanqi;
                           xhr.send(requestData);
                 }
                
                 // 每5秒执行一次请求
                 baiduseo_sendRequest();
                 setInterval(baiduseo_sendRequest, 6000);
                 </script>
                 <?php   
            }
        }
    }

   
    public  function baiduseo_addpages() {
        add_menu_page(__('蜘蛛/访客','key_spider'), __('蜘蛛/访客','key_spider'), 'manage_options', 'spider', [$this,'keyspider_toplevelpage'] );
    }
    public function keyspider_toplevelpage(){
        echo "<div id='keyspider_wztkj-app'></div>";
    }
    public  function baiduseo_enqueue($hook){
        if( 'toplevel_page_spider' != $hook ) return;
        require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/admin/assets.php';
        foreach($assets as $key=>$val){
            if($val['type']=='css'){
                 wp_enqueue_style( $val['name'],  plugin_dir_url( KEYSPIDER_FILE ).'inc/admin/'.$val['url'],false,'','all');
            }elseif($val['type']=='js'){
                wp_enqueue_script( $val['name'], plugin_dir_url( KEYSPIDER_FILE ).'inc/admin/'.$val['url'], '', '', true);
            }
        }
        wp_register_script('spider.js', false, null, false);
        wp_enqueue_script('spider.js');
        $url1 = keyspider_common::baiduseo_url(0);
      
        // $baiduseo_version  = esc_url_raw(admin_url('plugin-install.php?tab=plugin-information&plugin=baiduseo'));
        $baiduseo_indexnow = md5(esc_url(keyspider_common::baiduseo_url(1)));
        
        $baiduseo_google = keyspider_common::baiduseo_url(1).'/wp-sitemap.xml';
        wp_add_inline_script('spider.js', 'var baiduseo_wztkj_url="'.plugins_url('key-spider').'/inc/admin",baiduseo_nonce="'. wp_create_nonce('baiduseo').'",baiduseo_ajax="'.esc_url(admin_url('admin-ajax.php')).'",baiduseo_url="'.$url1.'";', 'before');
    }
    public  function spider_plugin_action_links ( $links) {
        $links[] = '<a href="' . admin_url( 'admin.php?page=spider&nonce='.esc_attr(wp_create_nonce('baiduseo')) ) . '">设置</a>';
        return $links;
    }

    public static function baiduseo_url($type=0){
        if($type==1){
            $url1 = get_option('siteurl');
            $url1 = parse_url($url1);
            $url1 = $url1['scheme'].'://'.$url1['host'];
            return $url1;
        }else{
            $url1 = get_option('siteurl');
            $url1 = str_replace('https://','',$url1);
            $url1 = str_replace('http://','',$url1);
            $url1 = trim($url1,'/');
            $url1 = explode('/',$url1);
            return $url1[0];
        }
    }
   
}
?>
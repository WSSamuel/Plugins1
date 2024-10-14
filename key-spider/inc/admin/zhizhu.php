<?php
class keyspider_zhizhu{
    public function init(){
        $this->baiduseo_zhizhu_sql();
        add_action( 'wp', [$this,'baiduseo_zhizhus'] );
    }
    public function baiduseo_zhizhu_sql(){
        if(is_admin()){
            global $wpdb;
            $charset_collate = '';
            if (!empty($wpdb->charset)) {
              $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
            }
            if (!empty( $wpdb->collate)) {
              $charset_collate .= " COLLATE {$wpdb->collate}";
            }
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            if($wpdb->get_var("show tables like '{$wpdb->prefix}baiduseo_zhizhu'") !=  $wpdb->prefix."baiduseo_zhizhu"){
                $sql1 = "CREATE TABLE " . $wpdb->prefix . "baiduseo_zhizhu   (
                    id bigint NOT NULL AUTO_INCREMENT,
                    name varchar(100) NOT NULL,
                    ip varchar(100) NOT NULL,
                    time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    address text NOT NULL,
                    type bigint NOT NULL DEFAULT 200,
                    num bigint default 1,
                    UNIQUE KEY id (id)
                ) $charset_collate;";
                dbDelta($sql1);
            }
            if($wpdb->get_var("show tables like '{$wpdb->prefix}baiduseo_zhizhu_suoyin'") !=  $wpdb->prefix."baiduseo_zhizhu_suoyin"){
                 $sql8 = "CREATE TABLE " . $wpdb->prefix . "baiduseo_zhizhu_suoyin   (
                    id bigint NOT NULL AUTO_INCREMENT,
                    name varchar(100) NOT NULL ,
                    time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    num bigint NOT NULL DEFAULT 0,
                    zhizhu_num bigint NOT NULL DEFAULT 0,
                    UNIQUE KEY id (id)
                ) $charset_collate;";
                dbDelta($sql8);
            }
            if($wpdb->get_var("show tables like '{$wpdb->prefix}baiduseo_liuliang'") !=  $wpdb->prefix."baiduseo_liuliang"){
                 $sql8 = "CREATE TABLE " . $wpdb->prefix . "baiduseo_liuliang   (
                    id bigint NOT NULL AUTO_INCREMENT,
                    source varchar(255) NULL ,
                    url varchar(255) NULL,
                    time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    sheng varchar(255)  NULL,
                    ip varchar(255) NULL,
                    updatetime timestamp null,
                    shibie varchar(255) null,
                    session varchar(255) null,
                    type int(10) default 0,
                    status int(10) default 0,
                    pid bigint default 0,
                    lan varchar(255) null,
                    pla varchar(100) null,
                    liulanqi varchar(100) null,
                    shendu int(10) default 0,
                    shichang int(10) default 0,
                    pinci int(10) default 1,
                    is_new int(10) default 0,
                    UNIQUE KEY id (id)
                ) $charset_collate;";
                
                $res = dbDelta($sql8);
                
                
            }
        
        }
    }
    public static function baiduseo_zhizhu_dangqian(){
        global $wpdb;
        set_time_limit(0);
        ini_set('memory_limit','-1');
        $year = current_time('Y');
        $month = current_time( 'm');
        $day = current_time( 'd');
        $suoyin = ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];
        foreach($suoyin as $key=>$val){
            $suoyin_baidu[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="百度" and HOUR(time)=%d and date(time)="%d-%d-%d"',(int)$val,$year,$month,$day),ARRAY_A);
            $suoyin_guge[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="谷歌" and HOUR(time)=%d and date(time)="%d-%d-%d"',(int)$val,$year,$month,$day),ARRAY_A);
            $suoyin_360[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="360" and HOUR(time)=%d and date(time)="%d-%d-%d"',(int)$val,$year,$month,$day),ARRAY_A);
            $suoyin_sougou[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="搜狗" and HOUR(time)=%d and date(time)="%d-%d-%d"',(int)$val,$year,$month,$day),ARRAY_A);
            $suoyin_biying[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="必应" and HOUR(time)=%d and date(time)="%d-%d-%d"',(int)$val,$year,$month,$day),ARRAY_A);
            $suoyin_shenma[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="神马" and HOUR(time)=%d and date(time)="%d-%d-%d"',(int)$val,$year,$month,$day),ARRAY_A);
            $suoyin_toutiao[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="头条" and HOUR(time)=%d and date(time)="%d-%d-%d"',(int)$val,$year,$month,$day),ARRAY_A);
        }
        
        $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
          if(isset($baiduseo_zhizhu['type'])){
            $other = [];
            $other1 = [];
            if(strpos($baiduseo_zhizhu['type'],'1')!==false){
                $other[] = $suoyin_baidu;
                $other1[] = '百度';
            }
            if(strpos($baiduseo_zhizhu['type'],'2')!==false){
                $other[] = $suoyin_guge;
                $other1[] = '谷歌';
            }
             if(strpos($baiduseo_zhizhu['type'],'3')!==false){
                $other[] = $suoyin_360;
                $other1[] = '360';
            }
             if(strpos($baiduseo_zhizhu['type'],'4')!==false){
                $other[] = $suoyin_sougou;
                $other1[] = '搜狗';
            }
             if(strpos($baiduseo_zhizhu['type'],'5')!==false){
                $other[] = $suoyin_shenma;
                $other1[] = '神马';
            }
             if(strpos($baiduseo_zhizhu['type'],'6')!==false){
                $other[] = $suoyin_biying;
                $other1[] = 'Bing';
            }
             if(strpos($baiduseo_zhizhu['type'],'7')!==false){
                $other[] = $suoyin_toutiao;
                $other1[] = '头条';
            }
             
        }
        echo json_encode(['code'=>1,'other'=>$other,'other1'=>$other1]);exit;
        
    }
    public  function baiduseo_zhizhus(){
        global $wpdb;
         
        $currnetTime= current_time( 'Y/m/d H:i:s');
        $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
        
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            $type = sanitize_text_field(strtolower($_SERVER['HTTP_USER_AGENT']));
            if(isset($baiduseo_zhizhu['open']) && $baiduseo_zhizhu['open']==1){
                if(isset($baiduseo_zhizhu['type']) && strpos($baiduseo_zhizhu['type'],'2')!==false){
                    if (strpos($type, 'googlebot') !== false){
                        $data_array['name'] ='谷歌';
                    }
                }
                if(isset($baiduseo_zhizhu['type']) && strpos($baiduseo_zhizhu['type'],'1')!==false){
                    if (strpos($type, 'baiduspider') !== false){
                        $data_array['name'] ='百度';
                    }
                }
                if(isset($baiduseo_zhizhu['type']) && strpos($baiduseo_zhizhu['type'],'3')!==false){
                    if (strpos($type, '360spider') !== false){
                        $data_array['name'] ='360';
                    }
                }
                if(isset($baiduseo_zhizhu['type']) && strpos($baiduseo_zhizhu['type'],'4')!==false){
                    if (strpos($type, 'sogou') !== false){
                        $data_array['name'] ='搜狗';
                    }
                }
                if(isset($baiduseo_zhizhu['type']) && strpos($baiduseo_zhizhu['type'],'5')!==false){
                    if (strpos($type, 'yisouspider') !== false){
                        $data_array['name'] ='神马';
                    }   
                }
                if(isset($baiduseo_zhizhu['type']) && strpos($baiduseo_zhizhu['type'],'6')!==false){
                    if (strpos($type, 'bingbot') !== false){
                        $data_array['name'] ='必应';
                    }
                }
                if(isset($baiduseo_zhizhu['type']) && strpos($baiduseo_zhizhu['type'],'7')!==false){
                    if (strpos($type, 'bytespider') !== false){
                        $data_array['name'] ='头条';
                    }
                }
                if(isset($data_array['name'])){
                     $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
                    $data_array['address'] = sanitize_url($http_type.sanitize_text_field($_SERVER['HTTP_HOST']).$_SERVER['REQUEST_URI']);
                    
                    if(strlen($data_array['address'])<1024){
                        $zhizhu_is = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu where address="%s" and name="%s" ',$data_array['address'],$data_array['name']),ARRAY_A);
                        
                        $status_code = http_response_code();
                        
                        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                            $data_array['ip'] = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
                        }elseif(isset($_SERVER['REMOTE_ADDR'])){
                            $data_array['ip'] = sanitize_text_field($_SERVER['REMOTE_ADDR']);
                        }else{
                            $data_array['ip'] = '';
                        }
                        $data_array['time'] = $currnetTime;
                        $data_array['type'] = $status_code;
                        if(isset($zhizhu_is[0]) && !empty($zhizhu_is[0])){
                            if($data_array['type'] =='404'){
                                if($_SERVER['REQUEST_URI']!='/' && $_SERVER['REQUEST_URI']!='' ){
                                    $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu',['time'=>$data_array['time'],'num'=>$zhizhu_is[0]['num']+1],['id'=>$zhizhu_is[0]['id']]);
                                }
                            }else{
                                 $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu',['time'=>$data_array['time'],'num'=>$zhizhu_is[0]['num']+1],['id'=>$zhizhu_is[0]['id']]);
                            }
                        }else{
                            if($data_array['type'] =='404'){
                                if($_SERVER['REQUEST_URI']!='/' && $_SERVER['REQUEST_URI']!='' ){
                                    $data_array['num'] =1;
                                    $res = $wpdb->insert($wpdb->prefix."baiduseo_zhizhu",$data_array);
                                }
                            }else{
                                $data_array['num'] =1;
                                $res = $wpdb->insert($wpdb->prefix."baiduseo_zhizhu",$data_array);
                            }
                        }
                            
                        
                    }
                }
            }
            
            
        }
    }
     public static function baiduseo_zhizhu_data($page,$sta,$end,$search,$type,$type2,$orders){
         global $wpdb;
        set_time_limit(0);
        ini_set('memory_limit','-1');
        //zhe
        $page = (int)$page;                             
        $limit = 15;
        $sql ='select * from '.$wpdb->prefix.'baiduseo_zhizhu  where ';
        $sta = sanitize_text_field($sta);
        $end = sanitize_text_field($end);
        $search = sanitize_text_field($search);
        $timezone_offet = get_option( 'gmt_offset');
        $sta1 = strtotime($sta)-$timezone_offet*3600;
        $end1 = strtotime($end)-$timezone_offet*3600;
        if($search){
            if($sta && $end){
                $baidu = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="百度"  and address like %s ',$sta1,$end1,'%'.$search.'%'));
                $guge = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="谷歌"  and address like %s ',$sta1,$end1,'%'.$search.'%'));
                $a360 = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="360"  and address like %s ',$sta1,$end1,'%'.$search.'%'));
                $sougou = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="搜狗"  and address like %s ',$sta1,$end1,'%'.$search.'%'));
                $shenma = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="神马"  and address like %s ',$sta1,$end1,'%'.$search.'%'));
                $biying = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="必应"  and address like %s ',$sta1,$end1,'%'.$search.'%'));
                $toutiao = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="头条"  and address like %s ',$sta1,$end1,'%'.$search.'%'));
            }elseif($sta && !$end){
            
                
                $baidu = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="百度"  and address like %s ',$sta1,'%'.$search.'%'));
                $guge = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="谷歌"  and address like %s ',$sta1,'%'.$search.'%'));
                $a360 = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="360"  and address like %s ',$sta1,'%'.$search.'%'));
                $sougou = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="搜狗"  and address like %s ',$sta1,'%'.$search.'%'));
                $shenma = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="神马"  and address like %s ',$sta1,'%'.$search.'%'));
                $biying = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="必应"  and address like %s ',$sta1,'%'.$search.'%'));
                $toutiao = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="头条"  and address like %s ',$sta1,'%'.$search.'%'));
               
            }elseif(!$sta && $end){
            
                
                $baidu = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   unix_timestamp(time)<%d and name="百度"  and address like %s ',$end1,'%'.$search.'%'));
                $guge = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="谷歌"  and address like %s ',$end1,'%'.$search.'%'));
                $a360 = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="360"  and address like %s ',$end1,'%'.$search.'%'));
                $sougou = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   unix_timestamp(time)<%d and name="搜狗"  and address like %s ',$end1,'%'.$search.'%'));
                $shenma = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="神马"  and address like %s ',$end1,'%'.$search.'%'));
                $biying = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="必应"  and address like %s ',$end1,'%'.$search.'%'));
                $toutiao = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="头条"  and address like %s ',$end1,'%'.$search.'%'));
            }else{
                $baidu = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="百度"  and address like %s ','%'.$search.'%'));
                $guge = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="谷歌"  and address like %s ','%'.$search.'%'));
                $a360 = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="360"  and address like %s ','%'.$search.'%'));
                $sougou = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="搜狗"  and address like %s','%'.$search.'%'));
                $shenma = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="神马"  and address like %s ','%'.$search.'%'));
                $biying = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="必应"  and address like %s','%'.$search.'%'));
                $toutiao = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="头条"  and address like %s','%'.$search.'%'));
            }
            
        }else{
            if($sta && $end){
                
                $baidu = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="百度"  ',$sta1,$end1));
            
                $guge = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="谷歌" ',$sta1,$end1));
            
                $a360 = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="360"',$sta1,$end1));
                $sougou = $wpdb->query($wpdb->prepare('select count(*) from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="搜狗"',$sta1,$end1));
                $shenma = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="神马"',$sta1,$end1));
                $biying = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="必应"',$sta1,$end1));
                $toutiao = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d and name="头条" ',$sta1,$end1));
            }elseif($sta && !$end){
                
                
                $baidu = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="百度"',$sta1));
                $guge = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="谷歌" ',$sta1));
                $a360 = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="360" ',$sta1));
                $sougou = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="搜狗" ',$sta1));
                $shenma = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="神马" ',$sta1));
                $biying = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="必应" ',$sta1));
                $toutiao = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)>%d  and name="头条"',$sta1));
            }elseif(!$sta && $end){
                
                
                $baidu = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="百度" ',$end1));
                $guge = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="谷歌" ',$end1));
                $a360 = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="360"',$end1));
                $sougou = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  unix_timestamp(time)<%d and name="搜狗" ',$end1));
                $shenma = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   unix_timestamp(time)<%d and name="神马"',$end1));
                $biying = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   unix_timestamp(time)<%d and name="必应" ',$end1));
                $toutiao = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where unix_timestamp(time)<%d and name="头条"  ',$end1));
            }else{
                $baidu = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="百度" ');
                $guge = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="谷歌"  ');
                $a360 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="360"   ');
                $sougou = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where   name="搜狗"  ');
                $shenma = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where    name="神马" ');
                $biying = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where    name="必应"  ');
                $toutiao = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where  name="头条" ');
            }
           
        }
        
        
        if($search){
            $search = '%'.$search.'%';
            $sql .= "address like %s ";
        }else{
            $search = '1';
            $sql .= " %d ";
        }
        if($sta){
            $sta = strtotime($sta)-$timezone_offet*3600;
            $sql .= 'and unix_timestamp(time)>%d ';
        }else{
            $sta =0;
            $sql .= 'and unix_timestamp(time)>%d ';
        }
        if($end){
            $end = strtotime($end)-$timezone_offet*3600;
            $sql .= 'and  unix_timestamp(time)<%d ';
        }else{
            $end = time()+$timezone_offet*3600;
            $sql .= 'and  unix_timestamp(time)<%d ';
        }
        
        $type = (int)$type;
        if($type==0){
            $type='1';
            $sql .= 'and %d ';
        }else{
            switch($type){
                case 1://百度
                    $type='百度';
                    $sql .= 'and name = %s ';
                    break;
                case 2://谷歌
                    $type='谷歌';
                    $sql .= 'and name = %s ';
                    break;
                case 3:
                    $type='360';
                    $sql .= 'and name = %s ';
                    break;
                case 4:
                    $type='搜狗';
                    $sql .= 'and name = %s ';
                    break;
                case 5:
                    $type='神马';
                    $sql .= 'and name = %s ';
                    break;
                case 6:
                    $type='必应';
                    $sql .= 'and name = %s ';
                    break;
                case 7:
                    $type='头条';
                    $sql .= 'and name = %s ';
                    break;
            }
        }
        if($type2){
            switch($type2){
                case 8:
                    $type2='301';
                    $sql .= 'and type =%s ';
                    break;
                case 9:
                    $type2='404';
                    $sql .= 'and type =%s ';
                    break;
                case 10:
                    $type2='200';
                    $sql .= 'and type =%s ';
                    break;
            }
        }else{
            $type2='1';
            $sql .= 'and %d ';
        }
        $start = ($page-1)*$limit;
        $count = $wpdb->query($wpdb->prepare($sql,$search,$sta,$end,$type,$type2));
        if($orders==1){
            $sql .= 'order by num desc limit %d,%d ';
        }elseif($orders==2){
            $sql .= 'order by num asc limit %d,%d ';
        }else{
            $sql .= 'order by time desc limit %d,%d ';
        }
        $zhizhu = $wpdb->get_results($wpdb->prepare($sql,$search,$sta,$end,$type,$type2,$start,$limit),ARRAY_A);
        $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
          $other = [];
            $other1 = [];
        if(isset($baiduseo_zhizhu['type'])){
          
            if(strpos($baiduseo_zhizhu['type'],'1')!==false){
                $other[] = $baidu;
                $other1[] = '百度';
            }
            if(strpos($baiduseo_zhizhu['type'],'2')!==false){
                $other[] = $guge;
                $other1[] = '谷歌';
            }
             if(strpos($baiduseo_zhizhu['type'],'3')!==false){
                $other[] = $a360;
                $other1[] = '360';
            }
             if(strpos($baiduseo_zhizhu['type'],'4')!==false){
                $other[] = $sougou;
                $other1[] = '搜狗';
            }
             if(strpos($baiduseo_zhizhu['type'],'5')!==false){
                $other[] = $shenma;
                $other1[] = '神马';
            }
             if(strpos($baiduseo_zhizhu['type'],'6')!==false){
                $other[] = $biying;
                $other1[] = 'Bing';
            }
             if(strpos($baiduseo_zhizhu['type'],'7')!==false){
                $other[] = $toutiao;
                $other1[] = '头条';
            }
             
        }
        echo json_encode(['code'=>1,'msg'=>'','count'=>$count,'data'=>$zhizhu,'other'=>$other,'other1'=>$other1,'pagesize'=>15,'total'=>ceil($count/15)]);exit; 
    }
    public static function pay_money(){
        global $keyspider_wzt_log;
        if(!$baiduseo_wzt_log){
            return 0;
        }
        $data =  sanitize_text_field($_SERVER['SERVER_NAME']);
        $url = "http://wp.seohnzz.com/api/index/pay_money?url={$data}&type=4";
        $defaults = array(
            'timeout' => 4000,
            'connecttimeout'=>4000,
            'redirection' => 3,
            'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36',
            'sslverify' => FALSE,
        );
        $result = wp_remote_get($url,$defaults);
        if(!is_wp_error($result)){
            $content = wp_remote_retrieve_body($result);
            $content = json_decode($content,true);
            if(isset($content['status']) && $content['status']==1){
                return 1;
            }
        }else{
            return keyspider_tag::pay_money();
        }
    }
    public static function baiduseo_zhizhu_tubiao($year,$month){
        global $wpdb;
        set_time_limit(0);
        ini_set('memory_limit','-1');
        
        $year = $year?$year:current_time('Y');
        $month = $month?$month:current_time( 'm');
        $month_31 = ['01','03','05','07','08','10','12'];
        $month_30 = ['04','06','09','11'];
        
       
        if($month=='02'){
            if($year%4==0){
                $suoyin_day =['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29'];
                
               
            }else{
               $suoyin_day =['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28'];
            }
             
        }elseif(in_array($month,$month_31)){
            $suoyin_day =['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
        }elseif(in_array($month,$month_30)){
            $suoyin_day =['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30'];
        }
        foreach($suoyin_day as $val){
           
            $suoyin_baidu = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="百度" and num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_guge = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="谷歌" and num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_360 = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="360" and num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_sougou = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="搜狗" and num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_biying = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="必应" and num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_shenma = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="神马" and num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_toutiao = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="头条" and num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             
             
              $suoyin_baidu3 = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="百度" and zhizhu_num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_guge3 = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="谷歌" and zhizhu_num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_3603 = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="360" and zhizhu_num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_sougou3 = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="搜狗" and zhizhu_num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_biying3 = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="必应" and zhizhu_num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_shenma3 = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="神马" and zhizhu_num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             $suoyin_toutiao3 = $wpdb->get_results($wpdb->prepare('select num,zhizhu_num from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin  where  name="头条" and zhizhu_num>0 and date(time)="%d-%d-%d"',$year,$month,$val),ARRAY_A);
             if(isset($suoyin_baidu[0]['num'])){
                 $suoyin_baidu1[] = $suoyin_baidu[0]['num'];
             }else{
                 $suoyin_baidu1[] = 0; 
             }
             if(isset($suoyin_360[0]['num'])){
                 $suoyin_3601[] = $suoyin_360[0]['num'];
             }else{
                 $suoyin_3601[] = 0; 
             }
             if(isset($suoyin_sougou[0]['num'])){
                 $suoyin_sougou1[] = $suoyin_sougou[0]['num'];
             }else{
                 $suoyin_sougou1[] = 0; 
             }
             if(isset($suoyin_biying[0]['num'])){
                 $suoyin_biying1[] = $suoyin_biying[0]['num'];
             }else{
                 $suoyin_biying1[] = 0; 
             }
             if(isset($suoyin_baidu3[0]['zhizhu_num'])){
                 $suoyin_baidu2[] = $suoyin_baidu3[0]['zhizhu_num'];
             }else{
                 $suoyin_baidu2[] = 0; 
             }
             if(isset($suoyin_guge3[0]['zhizhu_num'])){
                 $suoyin_guge2[] = $suoyin_guge3[0]['zhizhu_num'];
             }else{
                 $suoyin_guge2[] = 0; 
             }
             if(isset($suoyin_3603[0]['zhizhu_num'])){
                 $suoyin_3602[] = $suoyin_3603[0]['zhizhu_num'];
             }else{
                 $suoyin_3602[] = 0; 
             }
             if(isset($suoyin_sougou3[0]['zhizhu_num'])){
                 $suoyin_sougou2[] = $suoyin_sougou3[0]['zhizhu_num'];
             }else{
                 $suoyin_sougou2[] = 0; 
             }
             if(isset($suoyin_biying3[0]['zhizhu_num'])){
                 $suoyin_biying2[] = $suoyin_biying3[0]['zhizhu_num'];
             }else{
                 $suoyin_biying2[] = 0; 
             }
             if(isset($suoyin_shenma3[0]['zhizhu_num'])){
                 $suoyin_shenma2[] = $suoyin_shenma3[0]['zhizhu_num'];
             }else{
                 $suoyin_shenma2[] = 0; 
             }
             if(isset($suoyin_toutiao3[0]['zhizhu_num'])){
                 $suoyin_toutiao2[] = $suoyin_toutiao3[0]['zhizhu_num'];
             }else{
                 $suoyin_toutiao2[] = 0; 
             }
        }
        $suoyin_day = implode(',',$suoyin_day);
        $suoyin_baidu1 = implode(',',$suoyin_baidu1);
        $suoyin_3601 = implode(',',$suoyin_3601);
        $suoyin_sougou1 = implode(',',$suoyin_sougou1);
        $suoyin_biying1 = implode(',',$suoyin_biying1);
        $suoyin_baidu2 = implode(',',$suoyin_baidu2);
        $suoyin_3602 = implode(',',$suoyin_3602);
        $suoyin_sougou2 = implode(',',$suoyin_sougou2);
        $suoyin_biying2 = implode(',',$suoyin_biying2);
        $suoyin_guge2 = implode(',',$suoyin_guge2);
        $suoyin_shenma2 = implode(',',$suoyin_shenma2);
        $suoyin_toutiao2 = implode(',',$suoyin_toutiao2);
        $year_month = $year.'-'.$month;
        $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
        
        if(isset($baiduseo_zhizhu['type'])){
            $other = [];
            $other1 = [];
            $suoyin = [];
            if(strpos($baiduseo_zhizhu['type'],'1')!==false){
                $other[] = $suoyin_baidu2;
                $other1[] = '百度';
                $suoyin['baidu'] = $suoyin_baidu1;
            }
            if(strpos($baiduseo_zhizhu['type'],'2')!==false){
                $other[] = $suoyin_guge2;
                $other1[] = '谷歌';
            }
             if(strpos($baiduseo_zhizhu['type'],'3')!==false){
                $other[] = $suoyin_3602;
                $other1[] = '360';
                $suoyin['360'] = $suoyin_sougou1;
            }
             if(strpos($baiduseo_zhizhu['type'],'4')!==false){
                $other[] = $suoyin_sougou2;
                $other1[] = '搜狗';
                $suoyin['sougou'] = $suoyin_3601;
            }
             if(strpos($baiduseo_zhizhu['type'],'5')!==false){
                $other[] = $suoyin_shenma2;
                $other1[] = '神马';
            }
             if(strpos($baiduseo_zhizhu['type'],'6')!==false){
                $other[] = $suoyin_biying2;
                $other1[] = 'Bing';
                $suoyin['bing'] = $suoyin_biying1;
            }
             if(strpos($baiduseo_zhizhu['type'],'7')!==false){
                $other[] = $suoyin_toutiao2;
                $other1[] = '头条';
            }
             
        }
        
        echo json_encode(['code'=>1,'suoyin'=>$suoyin,'zhizhu'=>['day'=>$suoyin_day,'time'=>$year_month],'other'=>$other,'other1'=>$other1]);exit;
    }
    
}
?>
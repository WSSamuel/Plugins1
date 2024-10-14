<?php
    class keyspider_get{
        public function init(){
            add_action('wp_ajax_keyspider_get_zhizhu', [$this,'zhizhu']);
            add_action('wp_ajax_keyspider_zhizhu_tubiao', [$this,'baiduseo_zhizhu_tubiao']);
            add_action('wp_ajax_keyspider_zhizhu_dangqian', [$this,'keyspider_zhizhu_dangqian']);
            add_action('wp_ajax_keyspider_get_zhizhu_con', [$this,'baiduseo_get_zhizhu_con']);
            add_action('wp_ajax_keyspider_get_liuliang', [$this,'baiduseo_get_liuliang']);
            add_action('wp_ajax_keyspider_get_liuliang_pv', [$this,'baiduseo_get_liuliang_pv']);
            add_action('wp_ajax_keyspider_get_liuliang_uv', [$this,'baiduseo_get_liuliang_uv']);
            add_action('wp_ajax_keyspider_get_liuliang_ip', [$this,'baiduseo_get_liuliang_ip']);
            add_action('wp_ajax_keyspider_get_liuliang_source', [$this,'baiduseo_get_liuliang_source']);
            add_action('wp_ajax_keyspider_get_liuliang_sf', [$this,'baiduseo_get_liuliang_sf']);
            add_action('wp_ajax_keyspider_get_liuliang_sl', [$this,'baiduseo_get_liuliang_sl']);
            add_action('wp_ajax_keyspider_get_liuliang_list', [$this,'baiduseo_get_liuliang_list']);
            add_action('wp_ajax_keyspider_get_vip', [$this,'baiduseo_get_vip']);
            add_action('wp_ajax_keyspider_get_key', [$this,'baiduseo_get_key']);
            add_action('wp_ajax_keyspider_liuliang_ditu', [$this,'baiduseo_liuliang_ditu']);
            add_action('wp_ajax_keyspider_get_zhizhu_tongji', [$this,'baiduseo_get_zhizhu_tongji']);
            add_action('wp_ajax_keyspider_get_zhizhu_tongji_2', [$this,'baiduseo_get_zhizhu_tongji_2']);
        }
        public function keyspider_zhizhu_dangqian(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                keyspider_zhizhu::baiduseo_zhizhu_dangqian();
            }
        }
      
        public  function baiduseo_get_zhizhu_tongji_2(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                global $wpdb;
                $sql = 'select * from '.$wpdb->prefix . 'baiduseo_zhizhu where type=200 order by num desc limit 20';
                $list = $wpdb->get_results($sql,ARRAY_A);
                foreach($list as $k=>$v){
                    $list[$k]['id'] = $k+1;
                }
                $sql1 = 'select  * from '.$wpdb->prefix . 'baiduseo_zhizhu where type=404 order by num desc limit 20';
                $list1 = $wpdb->get_results($sql1,ARRAY_A);
                foreach($list1 as $k=>$v){
                    $list1[$k]['id'] = $k+1;
                }
                echo wp_json_encode(['code'=>1,'data'=>$list,'data1'=>$list1]);exit;
            }
        }
        public function baiduseo_get_zhizhu_tongji(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                global $wpdb;
                $sql = 'select sum(num) as nums from '.$wpdb->prefix . 'baiduseo_zhizhu where type=200';
                $list = $wpdb->get_results($sql,ARRAY_A);
                $sql1 = 'select sum(num) as nums from '.$wpdb->prefix . 'baiduseo_zhizhu where type=404';
                $list1 = $wpdb->get_results($sql1,ARRAY_A);
                echo wp_json_encode(['code'=>1,'data'=>[['value'=>isset($list[0]['nums'])&& $list[0]['nums']?$list[0]['nums']:0,'name'=>200,'itemStyle'=>['color'=>'#009688']],['value'=>isset($list1[0]['nums'])&& $list1[0]['nums']?$list1[0]['nums']:0,'name'=>404,'itemStyle'=>['color'=>'#005796']]]]);exit;
            }
        }
        public function baiduseo_liuliang_ditu(){
             if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                global $wpdb;
                $arr = [];
                $count = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang',ARRAY_A);
                if(!$count){
                    $count =1;
                }
                $n = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="河南省"',ARRAY_A);
                $n1 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="香港"',ARRAY_A);
                $n2 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="黑龙江省"',ARRAY_A);
                $n3 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="吉林省"',ARRAY_A);
                $n4 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="辽宁省"',ARRAY_A);
                $n5 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="内蒙古"',ARRAY_A);
                $n6 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="新疆"',ARRAY_A);
                $n7 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="青海省"',ARRAY_A);
                $n8 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="甘肃省"',ARRAY_A);
                $n9 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="宁夏"',ARRAY_A);
                $n10 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="山西省"',ARRAY_A);
                $n11 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="河北省"',ARRAY_A);
                $n12 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="北京"',ARRAY_A);
                $n13 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="天津"',ARRAY_A);
                $n14 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="山东省"',ARRAY_A);
                $n15 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="陕西省"',ARRAY_A);
                $n16 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="江苏省"',ARRAY_A);
                $n17 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="西藏"',ARRAY_A);
                $n18 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="四川省"',ARRAY_A);
                $n19 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="湖北省"',ARRAY_A);
                $n20 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="安徽省"',ARRAY_A);
                $n21 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="上海"',ARRAY_A);
                $n22 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="浙江省"',ARRAY_A);
                $n23 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="福建省"',ARRAY_A);
                $n24 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="台湾省"',ARRAY_A);
                $n25 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="江西省"',ARRAY_A);
                $n26 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="湖南省"',ARRAY_A);
                $n27 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="广东省"',ARRAY_A);
                $n28 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="广西"',ARRAY_A);
                $n29 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="贵州省"',ARRAY_A);
                $n30 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="海南省"',ARRAY_A);
                $n31 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="重庆"',ARRAY_A);
                $n32 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="云南省"',ARRAY_A);
                $n33 = $wpdb->query('select id from '.$wpdb->prefix . 'baiduseo_liuliang where sheng="澳门"',ARRAY_A);
                $arr =[
                    [
                        'sheng'=>'河南',
                        'num'=>$n,
                        'zhanbi'=>round($n*100/$count),
                    ],
                    [
                        'sheng'=>'香港',
                        'num'=>$n1,
                        'zhanbi'=>round($n1*100/$count),
                    ],
                    [
                        'sheng'=>'黑龙江',
                        'num'=>$n2,
                        'zhanbi'=>round($n2*100/$count),
                    ],
                    [
                        'sheng'=>'吉林',
                        'num'=>$n3,
                        'zhanbi'=>round($n3*100/$count),
                    ],
                    [
                        'sheng'=>'辽宁',
                        'num'=>$n4,
                        'zhanbi'=>round($n4*100/$count),
                    ],
                    [
                        'sheng'=>'内蒙古',
                        'num'=>$n5,
                        'zhanbi'=>round($n5*100/$count),
                    ],
                    [
                        'sheng'=>'新疆',
                        'num'=>$n6,
                        'zhanbi'=>round($n6*100/$count),
                    ],
                    [
                        'sheng'=>'青海',
                        'num'=>$n7,
                        'zhanbi'=>round($n7*100/$count),
                    ],
                    [
                        'sheng'=>'甘肃',
                        'num'=>$n8,
                        'zhanbi'=>round($n8*100/$count),
                    ],
                    [
                        'sheng'=>'宁夏',
                        'num'=>$n9,
                        'zhanbi'=>round($n9/$count),
                    ],
                    [
                        'sheng'=>'山西',
                        'num'=>$n10,
                        'zhanbi'=>round($n10*100/$count),
                    ],
                    [
                        'sheng'=>'河北',
                        'num'=>$n11,
                        'zhanbi'=>round($n11*100/$count),
                    ],
                    [
                        'sheng'=>'北京',
                        'num'=>$n12,
                        'zhanbi'=>round($n12/$count),
                    ],
                    [
                        'sheng'=>'天津',
                        'num'=>$n13,
                        'zhanbi'=>round($n13*100/$count),
                    ],
                    [
                        'sheng'=>'山东',
                        'num'=>$n14,
                        'zhanbi'=>round($n14/$count),
                    ],
                    [
                        'sheng'=>'陕西',
                        'num'=>$n15,
                        'zhanbi'=>round($n15*100/$count),
                    ],
                    [
                        'sheng'=>'江苏',
                        'num'=>$n16,
                        'zhanbi'=>round($n16/$count),
                    ],
                    [
                        'sheng'=>'西藏',
                        'num'=>$n17,
                        'zhanbi'=>round($n17*100/$count),
                    ],
                    [
                        'sheng'=>'四川',
                        'num'=>$n18,
                        'zhanbi'=>round($n18*100/$count),
                    ],
                    [
                        'sheng'=>'湖北',
                        'num'=>$n19,
                        'zhanbi'=>round($n19/$count),
                    ],
                    [
                        'sheng'=>'安徽',
                        'num'=>$n20,
                        'zhanbi'=>round($n20*100/$count),
                    ],
                    [
                        'sheng'=>'上海',
                        'num'=>$n21,
                        'zhanbi'=>round($n21*100/$count),
                    ],
                    [
                        'sheng'=>'浙江',
                        'num'=>$n22,
                        'zhanbi'=>round($n22*100/$count),
                    ],
                    [
                        'sheng'=>'福建',
                        'num'=>$n23,
                        'zhanbi'=>round($n23*100/$count),
                    ],
                     [
                        'sheng'=>'台湾',
                        'num'=>$n24,
                        'zhanbi'=>round($n24*100/$count),
                    ],
                     [
                        'sheng'=>'江西',
                        'num'=>$n25,
                        'zhanbi'=>round($n25*100/$count),
                    ],
                     [
                        'sheng'=>'湖南',
                        'num'=>$n26,
                        'zhanbi'=>round($n26*100/$count),
                    ],
                     [
                        'sheng'=>'广东',
                        'num'=>$n27,
                        'zhanbi'=>round($n27*100/$count),
                    ],
                     [
                        'sheng'=>'广西',
                        'num'=>$n28,
                        'zhanbi'=>round($n28*100/$count),
                    ],
                     [
                        'sheng'=>'贵州',
                        'num'=>$n29,
                        'zhanbi'=>round($n29*100/$count),
                    ],
                     [
                        'sheng'=>'海南',
                        'num'=>$n30,
                        'zhanbi'=>round($n30*100/$count),
                    ],
                     [
                        'sheng'=>'重庆',
                        'num'=>$n31,
                        'zhanbi'=>round($n31*100/$count),
                    ],
                     [
                        'sheng'=>'云南',
                        'num'=>$n32,
                        'zhanbi'=>round($n32*100/$count),
                    ],
                    [
                        'sheng'=>'澳门',
                        'num'=>$n33,
                        'zhanbi'=>round($n33*100/$count),
                    ],
                    
                ];
                if($count==1){
                    echo wp_json_encode(['code'=>1,'data'=>$arr]);exit;
                }else{
                    $paytime = array();
                    foreach ($arr as $v) {
                        $paytime[] = $v['num'];
                    }
                    array_multisort($paytime, SORT_DESC, $arr);
                    echo wp_json_encode(['code'=>1,'data'=>$arr]);exit;
                }
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_key(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                $baiduseo_wzt_log = get_option('keyspider_wzt_log');
                echo wp_json_encode(['code'=>1,'data'=>$baiduseo_wzt_log]);exit;
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_vip(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                 $defaults = array(
                    'timeout' => 4000,
                    'connecttimeout'=>4000,
                    'redirection' => 3,
                    'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36',
                    'sslverify' => FALSE,
                );
                $baiduseo_level = get_option('keyspider_level');
                
                if(!isset($baiduseo_level[2]) || $baiduseo_level[2]<time()-24*3600){
                    $url = 'https://www.rbzzz.com/api/money/level4?url='.keyspider_common::baiduseo_url(0).'&type=4';
                    $result = wp_remote_get($url,$defaults);
                    
                    if(!is_wp_error($result)){
                        $level = wp_remote_retrieve_body($result);
                        $level = json_decode($level,true);
                        
                        $level1 = explode(',',$level['level']);
                        $level2 = $level1;
                        if(isset($level1[0]) && ($level1[0]==1 || $level1[0]==2)){
                            $level2[2] = time();
                            $level2[3] = $level['version'];
                            update_option('keyspider_level',$level2);
                            $baiduseo_wzt_log = get_option('keyspider_wzt_log');
                        }
                    }
                }else{
                    $level1 = $baiduseo_level;
                    $level = [];
                    $level['version'] = $baiduseo_level[3];
                    if(isset($level1[0]) && ($level1[0]==1 || $level1[0]==2)){
                        $baiduseo_wzt_log = get_option('keyspider_wzt_log');
                    }
                }
                $level1[2] = $level['version'];
                $data['level'] = $level1;
                echo wp_json_encode(['code'=>1,'data'=>$data]);exit;
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_liuliang_list(){
            ini_set('memory_limit','500M');
             if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                global $wpdb;
                $where = [];
                $con = [];
                $sql ='select * from '.$wpdb->prefix . 'baiduseo_liuliang where status=1';
                if((int)$_POST['fangke']==1){
                    $sql .= '  and is_new=1';
                    
                }elseif((int)$_POST['fangke']==2){
                    $sql .= '  and is_new=0';
                }
                if((int)$_POST['pinci']==1){
                    $sql .= '  and pinci=1';
                }elseif((int)$_POST['pinci']==2){
                     $sql .= '  and pinci=2';
                }elseif((int)$_POST['pinci']==3){
                    $sql .= '  and pinci=3';
                }elseif((int)$_POST['pinci']==4){
                    $sql .= '  and pinci=4';
                }elseif((int)$_POST['pinci']==5){
                     $sql .= '  and pinci>=5 and pinci<=10';
                }elseif((int)$_POST['pinci']==6){
                    $sql .= '  and pinci>=11 and pinci<=20';
                }elseif((int)$_POST['pinci']==7){
                    $sql .= '  and pinci>20';
                }
                if((int)$_POST['shendu']==1){
                    $sql .= ' and shendu=1';
                }elseif((int)$_POST['shendu']==2){
                    $sql .= ' and shendu=2';
                }elseif((int)$_POST['shendu']==3){
                    $sql .= ' and shendu=3';
                }elseif((int)$_POST['shendu']==4){
                    $sql .= ' and shendu=4';
                }elseif((int)$_POST['shendu']==5){
                    $sql .= ' and shendu>=5 and shendu<=10';
                }elseif((int)$_POST['shendu']==6){
                    $sql .= ' and shendu>=11 and shendu<=20';
                }elseif((int)$_POST['shendu']==7){
                    $sql .= ' and shendu>20';
                }
                if((int)$_POST['shichang']==1){
                    $sql .= ' and shichang<=30';
                }elseif((int)$_POST['shichang']==2){
                    $sql .= ' and shichang>30 and shichang<=60';
                }elseif((int)$_POST['shichang']==3){
                    $sql .= ' and shichang>60 and shichang<=90';
                }elseif((int)$_POST['shichang']==4){
                    $sql .= ' and shichang>90 and shichang<=180';
                }elseif((int)$_POST['shichang']==5){
                    $sql .= ' and shichang>180 and shichang<=300';
                }elseif((int)$_POST['shichang']==6){
                    $sql .= ' and shichang>300 and shichang<=600';
                }elseif((int)$_POST['shichang']==7){
                    $sql .= ' and shichang>600';
                }
                if(sanitize_text_field($_POST['time'])){
                    $timezone_offet = get_option( 'gmt_offset');
                    $sta1 = strtotime(sanitize_text_field($_POST['time']));
                    $end1 = strtotime(sanitize_text_field($_POST['time']))+24*3600;
                    $sql .=' and unix_timestamp(time)>%d and  unix_timestamp(time)<%d';
                    $con = [$sta1,$end1];
                }
                if(sanitize_text_field($_POST['rukou'])){
                    $sql .= ' and url=%s';
                    $con[] = sanitize_text_field($_POST['rukou']);
                }
                if(sanitize_text_field($_POST['ip'])){
                    $sql .= ' and ip=%s';
                    $con[] = sanitize_text_field($_POST['ip']);
                }
                if(sanitize_text_field($_POST['session'])){
                    $sql .= ' and session=%s';
                    $con[] = sanitize_text_field($_POST['session']);
                }
                
                if((int)$_POST['source']==1){
                    $sql .= '  and source="直接访问"';
                }elseif((int)$_POST['source']==2){
                    $sql .= '  and source<>"直接访问"';
                }
                if((int)$_POST['type']==1){
                    $sql .= ' and type=1';
                }elseif((int)$_POST['type']==2){
                    $sql .= ' and type=2';
                }
                $page = isset($_POST['page'])?(int)$_POST['page']:1;
                $start = ($page-1)*50;
                $con1 = $con;
                $con[] = $start;
                $sql1 = $sql;
                $sql .= ' order by id desc limit %d,50 ';
                if(empty($con1)){
                    $count = $wpdb->query($sql1,ARRAY_A);
                }else{
                    $count = $wpdb->query($wpdb->prepare($sql1,array_values($con1)),ARRAY_A);
                }
                // var_dump($wpdb->prepare($sql,array_values($con)));exit;
                $list = $wpdb->get_results($wpdb->prepare($sql,array_values($con)),ARRAY_A);
                
                if(!empty($list)){
                    foreach($list as $key=>$val){
                        $newlao = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_liuliang where session=%s and status=1 and  id<%d  order by  id desc limit 1',$val['session'],$val['id']),ARRAY_A);
                        if(!empty($newlao)){
                            $list[$key]['news'] =1;
                            $list[$key]['shang'] = $newlao[0]['time'];
                        }else{
                            $list[$key]['news'] =0;
                        }
                        
                        $list[$key]['lujing']= $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_liuliang where pid=%d',$val['id']),ARRAY_A);
                        $total_page = $wpdb->query($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_liuliang where pid=%d',$val['id']),ARRAY_A);
                        $list[$key]['totalpage'] = $total_page+1;
                        
                        if($val['updatetime']){
                            $totaltime = strtotime($val['updatetime'])-strtotime($val['time']);
                        }else{
                            $totaltime = 1;
                        }
                        
                        if(!empty($list[$key]['lujing'])){
                            foreach($list[$key]['lujing'] as $k=>$v){
                                if($v['shichang']){
                                    $totaltime+=$v['shichang'];
                                }else{
                                    if($v['updatetime']){
                                        $totaltime += strtotime($v['updatetime'])-strtotime($v['time']);
                                        $list[$key]['lujing'][$k]['shichang'] =  strtotime($v['updatetime'])-strtotime($v['time']);
                                        
                                    }else{
                                        $totaltime += 1;
                                        $list[$key]['lujing'][$k]['shichang'] =  1;
                                    }
                                }
                                $list[$key]['lujing'][$k]['opentime'] = substr($v['time'],11,8);
                            }
                            $list[$key]['end'] = $v['url'];
                        }else{
                            $list[$key]['end'] = $val['url'];
                        }
                        if($val['shichang']){
                            
                        }else{
                            $list[$key]['shichang'] = $totaltime;
                        }
                        
                    }
                }
                 echo wp_json_encode(['code'=>1,'data'=>$list,'count'=>$count,'pagesize'=>50,'total'=>ceil($count/50)]);exit;
                
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_liuliang_sl(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                global $wpdb;
                $res = $wpdb->get_results('select *,count(id) as a from '.$wpdb->prefix . 'baiduseo_liuliang where status=1  group by session having a>1',ARRAY_A);
                 $res2 = $wpdb->query('select *,count(id) as a from '.$wpdb->prefix . 'baiduseo_liuliang where status=1  group by session having a>1',ARRAY_A);
                $count1 = 0;
                $count2 = 0;
                foreach($res as $key=>$val){
                    $count1 +=$val['a'];
                }
                $res1 = $wpdb->get_results('select *,count(id) as a from '.$wpdb->prefix . 'baiduseo_liuliang where status=1  group by session having a=1',ARRAY_A);
                $res3 = $wpdb->query('select *,count(id) as a from '.$wpdb->prefix . 'baiduseo_liuliang where status=1  group by session having a=1',ARRAY_A);
                foreach($res1 as $key=>$val){
                    $count2 +=$val['a'];
                }
                echo wp_json_encode(['code'=>1,'data'=>$res2?$res2:0,'data1'=>$res3?$res3:0,'data2'=>$count1,'data3'=>$count2]);exit;
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_liuliang_sf(){
             if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                global $wpdb;
                 $res = $wpdb->get_results('select *,count(id) as a from '.$wpdb->prefix . 'baiduseo_liuliang  group by url order by a desc limit 10',ARRAY_A);
                 $count = 0;
                 foreach($res as $key=>$val){
                    $count +=$val['a'];
                 }
                 
                  foreach($res as $key=>$val){
                    $res[$key]['zhanbi'] =round($val['a']*100/$count,2).'%';
                    $res[$key]['rank'] = $key+1;
                 }
                  echo wp_json_encode(['code'=>1,'data'=>$res]);exit;
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_liuliang_source(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                global $wpdb;
                 $res = $wpdb->get_results('select *,count(id) as a from '.$wpdb->prefix . 'baiduseo_liuliang where source<>"直接访问" group by source order by a desc limit 10',ARRAY_A);
                
                 $count = 0;
                 foreach($res as $key=>$val){
                    $count +=$val['a'];
                 }
                 
                  foreach($res as $key=>$val){
                    $res[$key]['zhanbi'] =round($val['a']*100/$count,2).'%';
                    $res[$key]['rank'] = $key+1;
                 }
                  echo wp_json_encode(['code'=>1,'data'=>$res]);exit;
            }
             echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_liuliang_ip(){
            global $wpdb;
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                $type = (int)$_POST['type'];
                if($type==1){
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    for($i=0;$i<=23;$i++){
                        if($i>=10){
                            $j=$i+1;
                            $sta1 = strtotime(current_time('Y-m-d '.$i.':00'));
                            $end1 = strtotime(current_time('Y-m-d '.$j.':00'));
                            $sta2 = $sta1-24*3600;
                            $end2 = $end1-24*3600;
                            $sta3 = $sta1-24*3600*2;
                            $end3 = $end1-24*3600*2;
                        }else{
                            $j=$i+1;
                            
                            $sta1 = strtotime(current_time('Y-m-d 0'.$i.':00'));
                            $sta2 = $sta1-24*3600;
                            $sta3 = $sta1-24*3600*2;
                            if($j==10){
                                $end1 = strtotime(current_time('Y-m-d 10:00'));
                                $end2 = $end1-24*3600;
                                $end3 = $end1-24*3600*2;
                            }else{
                                $end1 = strtotime(current_time('Y-m-d 0'.$j.':00'));
                                $end2 = $end1-24*3600;
                                $end3 = $end1-24*3600*2;
                            }
                        }
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip ',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta3,$end3));
                    }
                    $sta4 = strtotime(current_time('Y-m-d'));
                    $sta5 = $sta4-24*3600;
                    $sta6 = $sta4-24*3600*2;
                    $end4 = strtotime(current_time('Y-m-d 23:59:59'));
                    $end5 = $end4-24*3600;
                    $end6 = $end4-24*3600*2;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta6,$end6));
                    $data5['series'] = [
                        [
                            'name'=>'今天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'昨天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'前天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];
                   echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                }elseif($type==2){
                    //获取周
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    $n = current_time('N');
                    for($i=1;$i<=7;$i++){
                       
                         $sta1 = strtotime(current_time('Y-m-d'))-($n-$i)*24*3600;
                        $sta2 = $sta1-24*3600*7;
                        $sta3 = $sta1-24*3600*14;
                        $end1 = $sta1+24*3600;
                        $end2 = $sta2+24*3600;
                        $end3 = $sta3+24*3600;
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta3,$end3));
                    }
                    $sta4 = strtotime(current_time('Y-m-d'))-($n-1)*24*3600;
                    $sta5 = $sta4-24*3600*7;
                    $sta6 = $sta4-24*3600*14;
                    $end4 = $sta4+24*3600*7;
                    $end5 = $sta5+24*3600*7;
                    $end6 = $sta6+24*3600*7;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta6,$end6));
                    $data5['series'] = [
                        [
                            'name'=>'本周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'上周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'上上周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['1','2','3','4','5','6','7'];
                    echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                }elseif($type==3){
                    //获取月份
                    $m = current_time('m');
                    $n = current_time('n');
                    $year = current_time('Y');
                    $month_31 = ['01','03','05','07','08','10','12'];
                    $month_30 = ['04','06','09','11'];
                    if($n==1){
                        $num1 = 31;
                        $num2 =30;
                    }else{
                        $n= $n-1;
                        if($n<10){
                            $n = '0'.$n;
                            
                        }
                        if($n=='02'){
                            if($year%4==0){
                                $num1 = 29;
                            }else{
                                $num1  = 28;
                            }
                            $num2 =31;
                             
                        }elseif(in_array($n,$month_31)){
                            $num1  = 31;
                            if($n==8){
                                $num2 =31;
                            }else{
                                $num2 =30;
                            }
                        }elseif(in_array($n,$month_30)){
                           $num1  = 30;
                           $num2 =31;
                        }
                    }
                    $d = current_time('j');
                   
                    if($m=='02'){
                        if($year%4==0){
                            $num = 29;
                        }else{
                            $num  = 28;
                        }
                         
                    }elseif(in_array($m,$month_31)){
                        $num  = 31;
                    }elseif(in_array($m,$month_30)){
                       $num  = 30;
                    }
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    for($i=1;$i<=31;$i++){
                        $sta1 = strtotime(current_time('Y-m-'.$i));
                        $end1 = $sta1+24*3600;
                        $sta2 = $sta1-24*3600*($num1+$d);
                        $end2 = $sta2+24*3600;
                        $sta3 = $sta1-24*3600*($num1+$d+$num2);
                        $end3 = $sta3+24*3600;
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta3,$end3));
                    }
                    $sta4 = strtotime(current_time('Y-m-01'));
                    $sta5 = $sta4-24*3600*$num1;
                    $sta6 = $sta4-24*3600*($num1+$num2);
                    $end4 = $sta4+24*3600*$num;
                    $end5 = $sta4;
                    $end6 = $sta5;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by ip',$sta6,$end6));
                    $data5['series'] = [
                        [
                            'name'=>'本月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'上月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'上上月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
                    echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                }
                
                
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_liuliang_uv(){
            global $wpdb;
             if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                $type = (int)$_POST['type'];
                if($type==1){
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    for($i=0;$i<=23;$i++){
                         if($i>=10){
                            $j=$i+1;
                            $sta1 = strtotime(current_time('Y-m-d '.$i.':00'));
                            $end1 = strtotime(current_time('Y-m-d '.$j.':00'));
                            $sta2 = $sta1-24*3600;
                            $end2 = $end1-24*3600;
                            $sta3 = $sta1-24*3600*2;
                            $end3 = $end1-24*3600*2;
                        }else{
                            $j=$i+1;
                            
                            $sta1 = strtotime(current_time('Y-m-d 0'.$i.':00'));
                            $sta2 = $sta1-24*3600;
                            $sta3 = $sta1-24*3600*2;
                            if($j==10){
                                $end1 = strtotime(current_time('Y-m-d 10:00'));
                                $end2 = $end1-24*3600;
                                $end3 = $end1-24*3600*2;
                            }else{
                                $end1 = strtotime(current_time('Y-m-d 0'.$j.':00'));
                                $end2 = $end1-24*3600;
                                $end3 = $end1-24*3600*2;
                            }
                        }
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session ',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta3,$end3));
                    }
                    $sta4 = strtotime(current_time('Y-m-d'));
                    $sta5 = $sta4-24*3600;
                    $sta6 = $sta4-24*3600*2;
                    $end4 = strtotime(current_time('Y-m-d 23:59:59'));
                    $end5 = $end4-24*3600;
                    $end6 = $end4-24*3600*2;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta6,$end6));
                    $data5['series'] = [
                        [
                            'name'=>'今天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'昨天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'前天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];
                   echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                }elseif($type==2){
                    //获取周
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    $n = current_time('N');
                    for($i=1;$i<=7;$i++){
                        $j=$i+1;
                       $sta1 = strtotime(current_time('Y-m-d'))-($n-$i)*24*3600;
                        $sta2 = $sta1-24*3600*7;
                        $sta3 = $sta1-24*3600*14;
                        $end1 = $sta1+24*3600;
                        $end2 = $sta2+24*3600;
                        $end3 = $sta3+24*3600;
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta3,$end3));
                    }
                     $sta4 = strtotime(current_time('Y-m-d'))-($n-1)*24*3600;
                    $sta5 = $sta4-24*3600*7;
                    $sta6 = $sta4-24*3600*14;
                    $end4 = $sta4+24*3600*7;
                    $end5 = $sta5+24*3600*7;
                    $end6 = $sta6+24*3600*7;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta6,$end6));
                    $data5['series'] = [
                        [
                            'name'=>'本周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'上周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'上上周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['1','2','3','4','5','6','7'];
                    echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                }elseif($type==3){
                    //获取月份
                    $m = current_time('m');
                    $n = current_time('n');
                    $year = current_time('Y');
                    $month_31 = ['01','03','05','07','08','10','12'];
                    $month_30 = ['04','06','09','11'];
                    if($n==1){
                        $num1 = 31;
                        $num2 =30;
                    }else{
                        $n= $n-1;
                        if($n<10){
                            $n = '0'.$n;
                            
                        }
                        if($n=='02'){
                            if($year%4==0){
                                $num1 = 29;
                            }else{
                                $num1  = 28;
                            }
                            $num2 =31;
                             
                        }elseif(in_array($n,$month_31)){
                            $num1  = 31;
                            if($n==8){
                                $num2 =31;
                            }else{
                                $num2 =30;
                            }
                        }elseif(in_array($n,$month_30)){
                           $num1  = 30;
                           $num2 =31;
                        }
                    }
                    $d = current_time('j');
                   
                    if($m=='02'){
                        if($year%4==0){
                            $num = 29;
                        }else{
                            $num  = 28;
                        }
                         
                    }elseif(in_array($m,$month_31)){
                        $num  = 31;
                    }elseif(in_array($m,$month_30)){
                       $num  = 30;
                    }
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    for($i=1;$i<=31;$i++){
                        $sta1 = strtotime(current_time('Y-m-'.$i));
                        $end1 = $sta1+24*3600;
                        $sta2 = $sta1-24*3600*($num1+$d);
                        $end2 = $sta2+24*3600;
                        $sta3 = $sta1-24*3600*($num1+$d+$num2);
                        $end3 = $sta3+24*3600;
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta3,$end3));
                    }
                    $sta4 = strtotime(current_time('Y-m-01'));
                    $sta5 = $sta4-24*3600*$num1;
                    $sta6 = $sta4-24*3600*($num1+$num2);
                    $end4 = $sta4+24*3600*$num;
                    $end5 = $sta4;
                    $end6 = $sta5;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d group by session',$sta6,$end6));
                    $data5['series'] = [
                        [
                            'name'=>'本月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'上月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'上上月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
                    echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                    
                }
                
                
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_liuliang_pv(){
            global $wpdb;
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                $type = (int)$_POST['type'];
                if($type==1){
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    for($i=0;$i<=23;$i++){
                        if($i>=10){
                            $j=$i+1;
                            $sta1 = strtotime(current_time('Y-m-d '.$i.':00'));
                            $end1 = strtotime(current_time('Y-m-d '.$j.':00'));
                            $sta2 = $sta1-24*3600;
                            $end2 = $end1-24*3600;
                            $sta3 = $sta1-24*3600*2;
                            $end3 = $end1-24*3600*2;
                        }else{
                            $j=$i+1;
                            
                            $sta1 = strtotime(current_time('Y-m-d 0'.$i.':00'));
                            $sta2 = $sta1-24*3600;
                            $sta3 = $sta1-24*3600*2;
                            if($j==10){
                                $end1 = strtotime(current_time('Y-m-d 10:00'));
                                $end2 = $end1-24*3600;
                                $end3 = $end1-24*3600*2;
                            }else{
                                $end1 = strtotime(current_time('Y-m-d 0'.$j.':00'));
                                $end2 = $end1-24*3600;
                                $end3 = $end1-24*3600*2;
                            }
                        }
                    
                        
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta3,$end3));
                    }
                    $sta4 = strtotime(current_time('Y-m-d'));
                    $sta5 = $sta4-24*3600;
                    $sta6 = $sta4-24*3600*2;
                    $end4 = strtotime(current_time('Y-m-d 23:59:59'));
                    $end5 = $end4-24*3600;
                    $end6 = $end4-24*3600*2;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta6,$end6));
                    
                    $data5['series'] = [
                        [
                            'name'=>'今天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'昨天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'前天',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'];
                   echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                }elseif($type==2){
                    //获取周
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    $n = current_time('N');
                    for($i=1;$i<=7;$i++){
                        $j=$i+1;
                        $sta1 = strtotime(current_time('Y-m-d'))-($n-$i)*24*3600;
                        $sta2 = $sta1-24*3600*7;
                        $sta3 = $sta1-24*3600*14;
                        $end1 = $sta1+24*3600;
                        $end2 = $sta2+24*3600;
                        $end3 = $sta3+24*3600;
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta3,$end3));
                    }
                    $sta4 = strtotime(current_time('Y-m-d'))-($n-1)*24*3600;
                    $sta5 = $sta4-24*3600*7;
                    $sta6 = $sta4-24*3600*14;
                    $end4 = $sta4+24*3600*7;
                    $end5 = $sta5+24*3600*7;
                    $end6 = $sta6+24*3600*7;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta6,$end6));
                    $data5['series'] = [
                        [
                            'name'=>'本周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'上周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'上上周',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['1','2','3','4','5','6','7'];
                    echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                }elseif($type==3){
                    //获取月份
                    $m = current_time('m');
                    $n = current_time('n');
                    $year = current_time('Y');
                    $month_31 = ['01','03','05','07','08','10','12'];
                    $month_30 = ['04','06','09','11'];
                    if($n==1){
                        //上月天数
                        $num1 = 31;
                        //上上月天数
                        $num2 =30;
                    }else{
                        $n= $n-1;
                        if($n<10){
                            $n = '0'.$n;
                            
                        }
                        if($n=='02'){
                            if($year%4==0){
                                $num1 = 29;
                            }else{
                                $num1  = 28;
                            }
                            $num2 =31;
                             
                        }elseif(in_array($n,$month_31)){
                            $num1  = 31;
                            if($n==8){
                                $num2 =31;
                            }else{
                                $num2 =30;
                            }
                        }elseif(in_array($n,$month_30)){
                           $num1  = 30;
                           $num2 =31;
                        }
                    }
                    $d = current_time('j');
                    
                    if($m=='02'){
                        if($year%4==0){
                            //当前月天数
                            $num = 29;
                        }else{
                            $num  = 28;
                        }
                         
                    }elseif(in_array($m,$month_31)){
                        $num  = 31;
                    }elseif(in_array($m,$month_30)){
                       $num  = 30;
                    }
                    $timezone_offet = get_option( 'gmt_offset');
                    $arr1 = [];
                    $arr2 = [];
                    $arr3 = [];
                    for($i=1;$i<=31;$i++){
                        $sta1 = strtotime(current_time('Y-m-'.$i));
                        $end1 = $sta1+24*3600;
                        $sta2 = $sta1-24*3600*($num1+$d);
                        $end2 = $sta2+24*3600;
                        $sta3 = $sta1-24*3600*($num1+$d+$num2);
                        $end3 = $sta3+24*3600;
                        $arr1[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta1,$end1));
                        $arr2[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta2,$end2));
                        $arr3[] = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta3,$end3));
                    }
                    $sta4 = strtotime(current_time('Y-m-01'));
                    $sta5 = $sta4-24*3600*$num1;
                    $sta6 = $sta4-24*3600*($num1+$num2);
                    $end4 = $sta4+24*3600*$num;
                    $end5 = $sta4;
                    $end6 = $sta5;
                    $arr4 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta4,$end4));
                    $arr5 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta5,$end5));
                    $arr6 =$wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_liuliang  where unix_timestamp(time)>%d and  unix_timestamp(time)<%d ',$sta6,$end6));
                    $data5['series'] = [
                        [
                            'name'=>'本月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr1
                        ],
                        [
                            'name'=>'上月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr2    
                        ],
                        [
                            'name'=>'上上月',
                            'type'=>'line',
                            'smooth'=> true,
                            // 'stack'=> 'Total',
                            'data'=>$arr3    
                        ],
                    ];
                    $data5['xdata'] = ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
                    echo wp_json_encode(['code'=>1,'data1'=>$data5,'data2'=>$arr4,'data3'=>$arr5,'data4'=>$arr6]);exit;
                    
                }
                
                
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_liuliang(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                $baiduseo_wyc = get_option('baiduseo_liuliang');
                echo wp_json_encode(['code'=>1,'data'=>$baiduseo_wyc]);exit;
            }
            echo wp_json_encode(['code'=>0]);exit;
        }
        public function baiduseo_get_zhizhu_con(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
                $silian = get_option('keyspider_silian');
                echo wp_json_encode(['code'=>1,'data'=>$baiduseo_zhizhu,'data1'=>$silian]);exit;
            }else{
                echo wp_json_encode(['code'=>0]);exit;
            }
        }
        
        public function baiduseo_zhizhu_tubiao(){
            if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                if(isset($_POST['time']) && sanitize_text_field($_POST['time'])){
                    $year = substr(sanitize_text_field($_POST['time']),0,4);
                    $month = substr(sanitize_text_field($_POST['time']),5,2);
                }else{
                    $year = '';
                    $month = '';
                }
                 keyspider_zhizhu::baiduseo_zhizhu_tubiao($year,$month);
            }
        }
       
        
        public function zhizhu(){
           
           if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
                $pages = isset($_POST['pages'])?(int)$_POST['pages']:1;
                $sta = isset($_POST['start'])?sanitize_text_field($_POST['start']):'';
                $end = isset($_POST['end'])?sanitize_text_field($_POST['end']):"";
                $search = isset($_POST['search'])?sanitize_text_field($_POST['search']):'';
                $type = isset($_POST['type'])?sanitize_text_field($_POST['type']):0;
                $type2 = isset($_POST['type2'])?sanitize_text_field($_POST['type2']):0;
                $orders = isset($_POST['orders'])?sanitize_text_field($_POST['orders']):1;
                $data = keyspider_zhizhu::baiduseo_zhizhu_data($pages,$sta,$end,$search,$type,$type2,$orders);
            
            }else{
                echo wp_json_encode(['code'=>0]);exit;
            }
            
        }
       
        
        
    }
?>
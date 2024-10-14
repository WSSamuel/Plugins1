<?php
class keyspider_cron{
    public function init(){
        add_action( 'keyspider_cronhook', [$this,'baiduseo_cronexec'] );
        // if(isset($_GET['plan'])){
        //     $this->baiduseo_cronexec();
        // }
        if(!wp_next_scheduled( 'keyspider_cronhook' )){
            wp_schedule_event( strtotime(current_time('Y-m-d H:i:00',1)), 'hourly', 'keyspider_cronhook' );
        }
    }
    public function baiduseo_cronexec(){
       
        ini_set('memory_limit','-1');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
        if(isset($baiduseo_zhizhu['open']) && $baiduseo_zhizhu['open']==1){
            $this->baiduseo_zhizhu();
        }
        $this->baiduseo_tongji();
        $this->baiduseo_liuliang();
        $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
        if(isset($baiduseo_zhizhu['silian_open']) && $baiduseo_zhizhu['silian_open']){
            $this->baiduseo_silian();
        }
    }
    public function baiduseo_silian(){
        keyspider_seo::silian(1);
    }
    public function baiduseo_liuliang(){
        global $wpdb,$keyspider_wzt_log;
        if($keyspider_wzt_log){
            $log = keyspider_seo::pay_money();
            if(!$log){
                return;
            }
            //删除超过限制的数据
            $timezone_offet = get_option( 'gmt_offset');
            $baiduseo_liuliang = get_option('baiduseo_liuliang');
            if(isset($baiduseo_liuliang['log'])){
                if($baiduseo_liuliang['log']==1){
                    $end = strtotime('-30 days')-$timezone_offet*3600;
                    $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_liuliang  where unix_timestamp(time)<%d",$end));
                }elseif($baiduseo_liuliang['log']==2){
                     $end = strtotime('-90 days')-$timezone_offet*3600;
                    $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_liuliang  where unix_timestamp(time)<%d",$end));
                }elseif($baiduseo_liuliang['log']==3){
                     $end = strtotime('-180 days')-$timezone_offet*3600;
                    $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_liuliang  where unix_timestamp(time)<%d",$end));
                }elseif($baiduseo_liuliang['log']==4){
                      $end = strtotime('-3 days')-$timezone_offet*3600;
                    $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_liuliang  where unix_timestamp(time)<%d",$end));
                }elseif($baiduseo_liuliang['log']==5){
                      $end = strtotime('-7 days')-$timezone_offet*3600;
                    $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_liuliang  where unix_timestamp(time)<%d",$end));
                }elseif($baiduseo_liuliang['log']==6){
                      $end = strtotime('-15 days')-$timezone_offet*3600;
                    $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_liuliang  where unix_timestamp(time)<%d",$end));
                    
                }
            }
            if(isset($baiduseo_liuliang['open']) && $baiduseo_liuliang['open']){
                //深度和时长计算
                $res = $wpdb->get_results('select * from '.$wpdb->prefix . 'baiduseo_liuliang where shichang=0',ARRAY_A);
                foreach($res as $key=>$val){
                    if($val['status']==1){
                        $count = $wpdb->query($wpdb->prepare(' select * from  '.$wpdb->prefix.'baiduseo_liuliang where session="%s" and status=1',$val['session']),ARRAY_A);
                        if($count){
                            $wpdb->update($wpdb->prefix . 'baiduseo_liuliang',['pinci'=>$count,'is_new'=>1],['session'=>$val['session']]);
                        }
                        $total_page = $wpdb->query($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_liuliang where pid=%d',$val['id']),ARRAY_A);
                        
                        $shendu = $total_page+1;
                        $re = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_liuliang where pid=%d',$val['id']),ARRAY_A);
                        if($val['updatetime']){
                            $totaltime = strtotime($val['updatetime'])-strtotime($val['time']);
                        }else{
                            $totaltime = 1;
                        }
                        if(!empty($re)){
                            foreach($re as $k=>$v){
                                if($v['shichang']){
                                    $totaltime+=$v['shichang'];
                                }else{
                                    if($v['updatetime']){
                                        $totaltime += strtotime($v['updatetime'])-strtotime($v['time']);
                                       
                                        
                                    }else{
                                        $totaltime += 1;
                                        
                                    }
                                }
                               
                            }
                            
                        }
                        $wpdb->update($wpdb->prefix . 'baiduseo_liuliang',['shichang'=>$totaltime,'shendu'=>$shendu,'pinci'=>$count],['id'=>$val['id']]);
                    }else{
                        if($val['updatetime']){
                            $time = strtotime($val['updatetime'])-strtotime($val['time']);
                        }else{
                            $time = 1;
                        }
                        $wpdb->update($wpdb->prefix . 'baiduseo_liuliang',['shichang'=>$time],['id'=>$val['id']]);
                    }
                }
            }
            
            $sheng = $wpdb->get_results('select ip from '.$wpdb->prefix . 'baiduseo_liuliang where sheng is null and ip !="" and ip !="unknown" group by ip limit 100',ARRAY_A);
            
            if(!empty($sheng)){
                    $ur=  keyspider_common::baiduseo_url(0);
            	    $url = 'https://www.rbzzz.com/api/tag/getaddress?url='.$ur.'&type=4';
                    $defaults = array(
                        'timeout' => 4000,
                        'redirection' => 4000,
                        'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36',
                        'sslverify' => FALSE,
                    );
            	    $result = wp_remote_post($url,['body'=>['data'=>json_encode($sheng)]]);
            	    if(!is_wp_error($result)){
            	        $result = wp_remote_retrieve_body($result);
            	        
            	        
            	        $result = json_decode($result,true);
            	        
            	        if(isset($result['data'])){
            	            $result = $result['data'];
                	        foreach($result as $key=>$val){
                	           
                	             $wpdb->update($wpdb->prefix . 'baiduseo_liuliang',['sheng'=>$val],['ip'=>$key]);
                	           
                	        }
            	        }
            	    }
            	    
            }
        }
        
    }
    public function baiduseo_zhizhu(){
        global $wpdb;
        $timezone_offet = get_option( 'gmt_offset');
       
        $sta =strtotime(gmdate('Y-m-d 00:00:00'))-$timezone_offet*3600-24*3600;
    	$end = strtotime(gmdate('Y-m-d 00:00:00'))-$timezone_offet*3600;
       
    	$suoyin1 = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin where unix_timestamp(time) >=%d and unix_timestamp(time)<%d and name="百度"  ',$sta,$end),ARRAY_A);
        $currnetTime= gmdate('Y-m-d H:i:s',strtotime(gmdate('Y-m-d 00:00:00'))-24*3600);
    	$baidu = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where name="百度" and unix_timestamp(time) >=%d and unix_timestamp(time)<%d',$sta,$end));
    	if(empty($suoyin1)){
    	    $wpdb->insert($wpdb->prefix."baiduseo_zhizhu_suoyin",['name'=>'百度','num'=>0,'time'=>$currnetTime,'zhizhu_num'=>$baidu]);
    	}else{
    	    $res = $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu_suoyin',['zhizhu_num'=>$baidu],['id'=>$suoyin1[0]["id"]]);
    	    
    	}
    	$suoyin2 = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin where unix_timestamp(time) >=%d and unix_timestamp(time)<%d and name="必应"  ',$sta,$end),ARRAY_A);
    
    	$bingying = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where name="必应" and unix_timestamp(time) >=%d and unix_timestamp(time)<%d',$sta,$end));
    		
    	if(empty($suoyin2)){
    	    $wpdb->insert($wpdb->prefix."baiduseo_zhizhu_suoyin",['name'=>'必应','num'=>0,'time'=>$currnetTime,'zhizhu_num'=>$bingying]);
    	}else{
    	    $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu_suoyin',['zhizhu_num'=>$bingying],['id'=>$suoyin2[0]["id"]]);
    	}
    	$suoyin3 = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin where unix_timestamp(time) >=%d and unix_timestamp(time)<%d and name="360"  ',$sta,$end),ARRAY_A);
    	
    	$a360 = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where name="360" and unix_timestamp(time) >=%d and unix_timestamp(time)<%d',$sta,$end));
    
    	if(empty($suoyin3)){
    	    $wpdb->insert($wpdb->prefix."baiduseo_zhizhu_suoyin",['name'=>'360','num'=>0,'time'=>$currnetTime,'zhizhu_num'=>$a360]);
    	}else{
    	    $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu_suoyin',['zhizhu_num'=>$a360],['id'=>$suoyin3[0]["id"]]);
    	}
    	$suoyin4 = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin where unix_timestamp(time) >=%d and unix_timestamp(time)<%d and name="搜狗"  ',$sta,$end),ARRAY_A);
    	
    	$sougou = $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where name="搜狗" and unix_timestamp(time) >=%d and unix_timestamp(time)<%d',$sta,$end));
    
    	if(empty($suoyin4)){
    	    $wpdb->insert($wpdb->prefix."baiduseo_zhizhu_suoyin",['name'=>'搜狗','num'=>0,'time'=>$currnetTime,'zhizhu_num'=>$sougou]);
    	}else{
    	    $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu_suoyin',['zhizhu_num'=>$sougou],['id'=>$suoyin4[0]["id"]]);
    	}
    	$suoyin5 = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin where unix_timestamp(time) >=%d and unix_timestamp(time)<%d and name="谷歌"  ',$sta,$end),ARRAY_A);
    
    	$guge= $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where name="谷歌" and unix_timestamp(time) >=%d and unix_timestamp(time)<%d',$sta,$end));
    	
    	if(empty($suoyin5)){
    	    $wpdb->insert($wpdb->prefix."baiduseo_zhizhu_suoyin",['name'=>'谷歌','num'=>0,'time'=>$currnetTime,'zhizhu_num'=>$guge]);
    	}else{
    	    $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu_suoyin',['zhizhu_num'=>$guge],['id'=>$suoyin5[0]["id"]]);
    	}
    	$suoyin6 = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin where unix_timestamp(time) >=%d and unix_timestamp(time)<%d and name="神马"  ',$sta,$end),ARRAY_A);
    	
    	$shenma= $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where name="神马" and unix_timestamp(time) >=%d and unix_timestamp(time)<%d',$sta,$end));
    	
    	if(empty($suoyin6)){
    	    $wpdb->insert($wpdb->prefix."baiduseo_zhizhu_suoyin",['name'=>'神马','num'=>0,'time'=>$currnetTime,'zhizhu_num'=>$shenma]);
    	}else{
    	    $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu_suoyin',['zhizhu_num'=>$shenma],['id'=>$suoyin6[0]["id"]]);
    	}
    	$suoyin7 = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu_suoyin where unix_timestamp(time) >=%d and unix_timestamp(time)<%d and name="头条"  ',$sta,$end),ARRAY_A);
    	
    	$toutiao= $wpdb->query($wpdb->prepare('select id from '.$wpdb->prefix . 'baiduseo_zhizhu  where name="头条" and unix_timestamp(time) >=%d and unix_timestamp(time)<%d',$sta,$end));
    	
    	if(empty($suoyin7)){
    	    $wpdb->insert($wpdb->prefix."baiduseo_zhizhu_suoyin",['name'=>'头条','num'=>0,'time'=>$currnetTime,'zhizhu_num'=>$toutiao]);
    	}else{
    	    $wpdb->update($wpdb->prefix . 'baiduseo_zhizhu_suoyin',['zhizhu_num'=>$toutiao],['id'=>$suoyin7[0]["id"]]);
    	}
        $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
    	if(isset($baiduseo_zhizhu['log'])){
            $timezone_offet = get_option( 'gmt_offset');
            if($baiduseo_zhizhu['log']==1){
                $end = strtotime('-7 days')-$timezone_offet*3600;
                $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_zhizhu  where unix_timestamp(time)<%d",$end));
            }elseif($baiduseo_zhizhu['log']==2){
                 $end = strtotime('-15 days')-$timezone_offet*3600;
                $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_zhizhu  where unix_timestamp(time)<%d",$end));
            }elseif($baiduseo_zhizhu['log']==3){
                 $end = strtotime('-30 days')-$timezone_offet*3600;
                $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_zhizhu  where unix_timestamp(time)<%d",$end));
            }elseif($baiduseo_zhizhu['log']==4){
                 $end = strtotime('-90 days')-$timezone_offet*3600;
                $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_zhizhu  where unix_timestamp(time)<%d",$end));
            }elseif($baiduseo_zhizhu['log']==5){
                 $end = strtotime('-180 days')-$timezone_offet*3600;
                $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_zhizhu  where unix_timestamp(time)<%d",$end));
            }elseif($baiduseo_zhizhu['log']==6){
                 $end = strtotime('-3 days')-$timezone_offet*3600;
                $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_zhizhu  where unix_timestamp(time)<%d",$end));
                
            }
    	}
    }
    public function baiduseo_tongji(){
        $BaiduSEO_tongji = get_option('BaiduSEO_tongji');
        if(!$BaiduSEO_tongji || (isset($BaiduSEO_tongji) && $BaiduSEO_tongji['time']<time()) ){
            $wp_version =  get_bloginfo('version');
            $data =  keyspider_common::baiduseo_url(0);
        	$url = "http://wp.seohnzz.com/api/Keyspider/index?url={$data}&type=4&url1=".md5($data.'seohnzz.com')."&theme_version=".KEYSPIDER_VERSION."&php_version=".PHP_VERSION."&wp_version={$wp_version}";
        	$defaults = array(
                'timeout' => 4000,
                'connecttimeout'=>4000,
                'redirection' => 3,
                'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36',
                'sslverify' => FALSE,
            );
            $result = wp_remote_get($url,$defaults);
            if($BaiduSEO_tongji!==false){
                update_option('BaiduSEO_tongji',['time'=>time()+7*3600*24]);
            }else{
                add_option('BaiduSEO_tongji',['time'=>time()+7*3600*24]);
            }
        }
    }
    
}
?>
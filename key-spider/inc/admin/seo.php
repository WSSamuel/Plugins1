<?php
class keyspider_seo{                              
    public function init(){    
    }                                                                                                                                         
     public static function pay_money(){
        global $keyspider_wzt_log;
        if(!$keyspider_wzt_log){
            return 0;
        }
        $data =  keyspider_common::baiduseo_url(0);
        
    	$url = "https://ceshig.zhengyouyoule.com/index/index/pay_money?url={$data}&type=4";
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
        	}elseif(isset($content['status']) && $content['status']==0){
        	    return 0;
        	}else{
        	    $url = "http://wp.seohnzz.com/api/index/pay_money?url={$data}&type=4";
        	
            	$result = wp_remote_get($url,$defaults);
            	
            	if(!is_wp_error($result)){
                    $content = wp_remote_retrieve_body($result);
                    
                	$content = json_decode($content,true);
                	if(isset($content['status']) && $content['status']==1){
                	    return 1;
                	}elseif(isset($content['status']) && $content['status']==0){
        	            return 0;
                	}else{
                	    return keyspider_zhizhu::pay_money();
                	}
            	}else{
            	    return keyspider_zhizhu::pay_money();
            	}
        	}
    	}else{
    	    
        
        	$url = "http://wp.seohnzz.com/api/index/pay_money?url={$data}&type=4";
        	
            	$result = wp_remote_get($url,$defaults);
            	
            	if(!is_wp_error($result)){
                    $content = wp_remote_retrieve_body($result);
                    
                	$content = json_decode($content,true);
                	if(isset($content['status']) && $content['status']==1){
                	    return 1;
                	}elseif(isset($content['status']) && $content['status']==0){
        	            return 0;
                	}else{
                	    return keyspider_zhizhu::pay_money();
                	}
            	}else{
            	    return keyspider_zhizhu::pay_money();
            	}
    	}
    	    
    }
     public static function silian($two,$sl=0){
         global $wpdb;
        $currnetTime= current_time( 'Y/m/d H:i:s');
        	
            $data = [      	 	 		    		 	 			
                'silian_url'=>[],      	 		      							 
                'silian_htmlurl'=>[],     	 			 	     		 	   
                'time'=>$currnetTime    	 	 		     	 	   	 
            ];
            $count = $wpdb->query('select * from '.$wpdb->prefix . 'baiduseo_zhizhu where  type="404" group by address',ARRAY_A);
            
            for($i=0;$i<ceil($count/50000);$i++){
                $start = $i*50000;
                if($sl){
                    $zhizhu = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu where  type="404"  group by address limit %d , 500',$start),ARRAY_A);
                }else{
                    $zhizhu = $wpdb->get_results($wpdb->prepare('select * from '.$wpdb->prefix . 'baiduseo_zhizhu where  type="404"  group by address limit %d , 50000',$start),ARRAY_A);
                }
                
            	$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
                $xml .= "<urlset>\n";
                $txt = '';
            	foreach($zhizhu as $key=>$val){
                    $xml .= "<url>\n";
                    $xml .= "<loc>".htmlspecialchars($val['address'])."</loc>\n";
                    $xml .= "</url>\n";
                    $txt .=$val['address']."\n";
                }
                 WP_Filesystem();
                global $wp_filesystem;
                $xml .= "</urlset>\n";
                if($two==2){
                    if($i==0){
                        $data['silian_url'][] = get_option('siteurl'). '/silian.xml';
                        $data['silian_htmlurl'][] = get_option('siteurl'). '/silian.txt';
                        $wp_filesystem->put_contents ('../silian.xml',$xml);
                        $wp_filesystem->put_contents ('../silian.txt',$txt);
                    }else{
                        $data['silian_url'][] = get_option('siteurl'). '/silian'.$i.'.xml';
                        $data['silian_htmlurl'][] = get_option('siteurl'). '/silian'.$i.'.txt';
                        $wp_filesystem->put_contents ('../silian'.$i.'.xml',$xml);
                        $wp_filesystem->put_contents ('../silian'.$i.'.txt',$txt);
                    }
                }elseif($two==1){
                    if($i==0){
                        $data['silian_url'][] = get_option('siteurl'). '/silian.xml';
                         $data['silian_htmlurl'][] = get_option('siteurl'). '/silian.txt';
                        $wp_filesystem->put_contents (ABSPATH.'/silian.xml',$xml);
                        $wp_filesystem->put_contents (ABSPATH.'/silian.txt',$txt);
                    }else{
                        $data['silian_url'][] = get_option('siteurl'). '/silian'.$i.'.xml';
                        $data['silian_htmlurl'][] = get_option('siteurl'). '/silian'.$i.'.txt';
                        $wp_filesystem->put_contents (ABSPATH.'/silian'.$i.'.xml',$xml);
                        $wp_filesystem->put_contents (ABSPATH.'/silian'.$i.'.txt',$txt);
                    }
                }
            }
            $silian = get_option('keyspider_silian');
            if($silian!==false){
                update_option('keyspider_silian',$data);
            }else{
                add_option('keyspider_silian',$data);
            }
    }
   
}
?>
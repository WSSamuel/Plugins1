<?php
class keyspider_tag{
   
    public function init(){    
    }        
    
    public static function pay_money(){
        global $keyspider_wzt_log;
        if(!$keyspider_wzt_log){
            return 0;
        }
        $data =  keyspider_common::baiduseo_url(0);
    	$url = "https://www.rbzzz.com/api/money/pay_money?url={$data}&type=4";
    	$defaults = array(
            'timeout' =>4000,
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
    	    return 0;
    	}
    }
   
}
?>
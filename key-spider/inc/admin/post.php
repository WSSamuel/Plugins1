<?php
class keyspider_post{
    public function init(){
        add_action('wp_ajax_keyspider_zhizhu', [$this,'baiduseo_zhizhu']);
        add_action('wp_ajax_keyspider_shouquan', [$this,'baiduseo_shouquan']);
        add_action('wp_ajax_keyspider_zhizhu_clear', [$this,'baiduseo_zhizhu_clear']);
        add_action('wp_ajax_keyspider_zhizhu_linkdelete', [$this,'baiduseo_zhizhu_linkdelete']);
        add_action('wp_ajax_keyspider_liuliang', [$this,'baiduseo_liuliang']);
        add_action('wp_ajax_keyspider_liuliang_delete', [$this,'baiduseo_liuliang_delete']);
    }
    public function baiduseo_liuliang_delete(){
        if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
            global $wpdb;
            $res = $wpdb->query("DELETE FROM " . $wpdb->prefix . "baiduseo_liuliang");
            echo wp_json_encode(['msg'=>'操作成功','code'=>1]);exit;
        }
        echo wp_json_encode(['msg'=>'操作失败','code'=>0]);exit;
    }
    public function baiduseo_liuliang(){
        if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
            $ss  = keyspider_seo::pay_money();
            if(!$ss){
                 echo wp_json_encode(['msg'=>'请先授权','code'=>0]);exit;
            }
            $open = (int)$_POST['open'];
            $log = (int)$_POST['log'];
            
            $baiduseo_wyc = get_option('baiduseo_liuliang');
            if($baiduseo_wyc!==false){
                $res = update_option('baiduseo_liuliang',['open'=>$open,'log'=>$log]);
            }else{
                $res = add_option('baiduseo_liuliang',['open'=>$open,'log'=>$log]);
            }
            
            echo wp_json_encode(['msg'=>'保存成功','code'=>1]);exit;
            
        }
        echo wp_json_encode(['msg'=>'保存失败','code'=>0]);exit;
    }
    public function baiduseo_zhizhu(){
        if(isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
            $ss  = keyspider_seo::pay_money();
            if(!$ss){
                 echo wp_json_encode(['msg'=>'请先授权','code'=>0]);exit;
            }
            $list = [
                'open'=>(int)$_POST['open'],
                'log'=>(int)$_POST['log'],
                'type'=>sanitize_text_field($_POST['type']),
                'silian_open'=>(int)$_POST['silian_open']
            ];
            
            $baiduseo_zhizhu = get_option('baiduseo_zhizhu');
            if($baiduseo_zhizhu!==false){
                update_option('baiduseo_zhizhu',$list);
                if((int)$_POST['silian_open']==1){
                    keyspider_seo::silian(1);
                }
            }else{
                add_option('baiduseo_zhizhu',$list);
            }
            echo wp_json_encode(['msg'=>'保存成功','code'=>1]);exit;
        }
        echo wp_json_encode(['msg'=>'保存失败','code'=>0]);exit;
    }
    public function baiduseo_shouquan(){
        if(isset($_POST['nonce']) && isset($_POST['action']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
            $key = sanitize_text_field($_POST['key']);
            
            $data =  keyspider_common::baiduseo_url(0);
            $url1 = sanitize_text_field($_SERVER['SERVER_NAME']);
            $url = 'https://www.rbzzz.com/api/money/log2?url='.$data.'&url1='.$url1.'&key='.$key.'&type=4';
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
                if($content){
                     global $keyspider_wzt_log;
       
                    if($keyspider_wzt_log!==false){
                        update_option('keyspider_wzt_log',$key);
                    }else{
                        add_option('keyspider_wzt_log',$key);
                    }
                    echo wp_json_encode(['code'=>1]);exit;
                }
            }
        }
        echo wp_json_encode(['code'=>0]);exit;
    }
    public function baiduseo_zhizhu_clear(){
        if(isset($_POST['nonce']) && isset($_POST['action']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
            global $keyspider_wzt_log;
            if(!$keyspider_wzt_log){
                  echo wp_json_encode(['msg'=>'请先授权','code'=>0]);exit;
            }
            $log = keyspider_seo::pay_money();
            if(!$log){
                echo wp_json_encode(['msg'=>'请先授权','code'=>0]);exit;
            }
            global $wpdb;
            $res = $wpdb->query( "DELETE FROM " . $wpdb->prefix . "baiduseo_zhizhu  " );
            if($res){
            echo wp_json_encode(['code'=>1]);exit; 
            }
        }
        echo wp_json_encode(['msg'=>'删除失败','code'=>0]);exit;
    }
    public function baiduseo_zhizhu_linkdelete(){
        if(isset($_POST['nonce']) && isset($_POST['action']) && wp_verify_nonce(sanitize_text_field($_POST['nonce']),'baiduseo')){
            global $wpdb;
            $id = (int)$_POST['id'];
            $res = $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "baiduseo_zhizhu where id=%d",$id));
            echo wp_json_encode(['code'=>1]);exit; 
        }
        echo wp_json_encode(['code'=>0]);exit; 
    }
}
<?php  
/*
Plugin Name: 网站蜘蛛/访客记录
Description: 网站蜘蛛, 网站日志, 流量监控, 访客记录, 访客统计
Version: 1.0.3
Author: 沃之涛科技
Author URI: https://www.rbzzz.com
License: GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007
License URI:https://www.gnu.org/licenses/gpl-3.0.html
*/
if(!defined('ABSPATH'))exit;
global $keyspider_wzt_log;

$keyspider_wzt_log = get_option('keyspider_wzt_log');
define('KEYSPIDER_VERSION','1.0.3');
define('KEYSPIDER_FILE',__FILE__);
define('KEYSPIDER_NAME',plugin_basename(__FILE__));
require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/common/index.php';
require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/admin/cron.php';
require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/admin/cron_tongbu.php';
require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/admin/post.php';
require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/admin/get.php';
require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/admin/seo.php';
require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/admin/tag.php';
require plugin_dir_path( KEYSPIDER_FILE ) . 'inc/admin/zhizhu.php';
$key_spider_common = new keyspider_common();
$key_spider_common->init();
$baiduseo_cron = new keyspider_cron();
$baiduseo_cron->init();
$baiduseo_get = new keyspider_get();
$baiduseo_get->init();
$baiduseo_post = new keyspider_post();
$baiduseo_post->init();
$baiduseo_zhizhu = new keyspider_zhizhu();
$baiduseo_zhizhu->init();
$baiduseo_seo = new keyspider_seo();
$baiduseo_seo->init();
$baiduseo_tag = new keyspider_tag();
$baiduseo_tag->init();
$baiduseo_crons  = new keyspider_crons();
$baiduseo_crons->init();


	





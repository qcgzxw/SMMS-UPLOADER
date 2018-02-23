<?php
/*
Plugin Name: SM.MS图床外链小工具
Plugin URI: https://www.qcgzxw.cn/2555.html
Description: 小文博客独自开发的图床插件，用于WordPress博客添加图床上传小工具。
Author: 小文博客
Author URI: https://www.qcgzxw.cn/
Version: 2.0
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/
include("SMMS-UPLOADER-WIDGETS.php");
define( 'QCGZXW_URL', plugin_dir_url( __FILE__ ) );
function qcgzxw_scripts() {  
wp_deregister_script('jquery');
wp_register_script('jquery', QCGZXW_URL . 'js/jquery.min.js', false, '1.0');
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'qcgzxw-js', QCGZXW_URL . 'js/main.js', '1.0', array(), true ); 
wp_enqueue_style( 'qcgzxw-css', QCGZXW_URL . 'css/qcgzxw.diy.css', array()); 
wp_enqueue_style( 'bootstrap', QCGZXW_URL . 'css/bootstrap.min.css', array()); 
}
add_action('wp_enqueue_scripts', 'qcgzxw_scripts');

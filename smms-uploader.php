<?php
/*
Plugin Name: SM.MS图床外链小工具
Plugin URI: https://www.qcgzxw.cn/2555.html
Description: 小文博客独自开发的图床插件，用于WordPress博客添加 图床上传小工具、评论处图片上传按钮、文章编辑处图片上传按钮。
Author: 小文博客
Author URI: https://www.qcgzxw.cn/
Version: 4.2
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
自定义小工具CSS样式部分
*/
define( 'SMMS_URL', plugin_dir_url( __FILE__ ) ); 
define( 'SMMS_VERSION', "4.2");
define( 'VERSION_CHECK_URL',"https://freed.ga/wp-widgets-info/qcgzxw-smms.json");
include("SMMS-UPLOADER-WIDGETS.php");
include("SMMS-UPLOADER-COMMENTS.php");
function qcgzxw_scripts_css() {  
wp_deregister_script('jquery');
wp_register_script('jquery', SMMS_URL . 'js/jquery.min.js', SMMS_VERSION);
wp_enqueue_script( 'jquery' );
if(is_single() || is_page())wp_enqueue_script( 'smms-comment-js', SMMS_URL . 'js/comment.min.js', array(), SMMS_VERSION, true); 
if(is_single() || is_page() || is_home())wp_enqueue_script( 'smms-js', SMMS_URL . 'js/widget.min.js', array(), SMMS_VERSION, true); 
if(is_single() || is_page() || is_home())wp_enqueue_style( 'smms-widget-css', SMMS_URL . 'css/smms.diy.css', array(),SMMS_VERSION); 
if(is_single() || is_page() || is_home())wp_enqueue_style( 'bootstrap', SMMS_URL . 'css/bootstrap.min.css', array(), SMMS_VERSION); 
}
function admin_scripts_css() {  
wp_enqueue_script( 'admin-content-js', SMMS_URL . 'js/content.min.js', array(), SMMS_VERSION, true); 
wp_enqueue_style( 'admin-content-css', SMMS_URL . 'css/input.min.css', array(),SMMS_VERSION); 
}
add_action('wp_enqueue_scripts', 'qcgzxw_scripts_css');
add_action('widgets_init','qcgzxw');
//功能启用
$Uploader = get_option('SMMS_DATA'); 
if($Uploader['Content'])
{
	add_action('admin_head', 'admin_scripts_css');
	add_action('media_buttons', 'admin_upload_img');  
}
if($Uploader['Comment'])
{
	add_filter('comment_form', 'comment_upload_img'); 
}
if($Uploader['Donate'])
{
	add_action( 'wp_footer', 'donate' );
}
//END
//支持作者
function donate()
{
	echo '<!-- SMMS-UPLOADER-WIDGETS BY QCGZXW.CN -->';
	wp_enqueue_script( 'smms-donate', SMMS_URL . 'js/donate.js', array(), SMMS_VERSION, true); 
}
//插件更新检测
function update()
{
	$response = wp_remote_get( VERSION_CHECK_URL );
	if ( is_array( $response ) && !is_wp_error($response) && $response['response']['code'] == '200' ) {
		$body = json_decode($response['body']);
	}
	return $body;
}
//添加链接
function SMMS_UPLOADER_LINKS( $actions, $plugin_file )
{
    static $plugin;
	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	if ($plugin == $plugin_file) {
			$settings	= array('settings' => '<a href="options-general.php?page=SMMS-UPLOADER-OPTIONS">插件设置</a>');
			$site_link	= array('support' => '<a href="https://github.com/qcgzxw/SMMS-UPLOADER" target="_blank">使用说明</a>');
			$actions 	= array_merge($settings, $actions);
			$actions	= array_merge($site_link, $actions);
	}
	return $actions;
}
add_filter( 'plugin_action_links', 'SMMS_UPLOADER_LINKS', 10, 2 );
//默认数据
add_action('admin_init', 'SMMS_options_default_options');
function SMMS_options_default_options(){
	$Uploader = get_option('SMMS_DATA');//获取选项
	if( $Uploader == '' ){   
		$Uploader = array(//设置默认数据
			'Content' => '',
			'Comment' => '',
			'Donate' => '',
		);
		update_option('SMMS_DATA', $Uploader);//更新选项   
	}
}

//设置菜单
function my_plugin_menu() {
     add_options_page( 'SMMS-UPLOADER设置页面', 'SM图床设置', 'manage_options', 'SMMS-UPLOADER-OPTIONS', 'my_plugin_options' );
}
add_action( 'admin_menu', 'my_plugin_menu' );
function my_plugin_options() {
	if(isset($_POST['Update']))
	{
		$date = update(); 
		$ver = $date->ver;
		if($ver > SMMS_VERSION)
		{
			$url = $date->url; 
			$content = $date->content; 
			
			echo '<div class="notice notice-warning"><p>SMMS-UPLOADER 插件已经有新版本啦！ <a target="_blank" href="'.$url.'">立即下载</a></p><p><strong>更新内容：</strong>'.$content.'</p></div>';
		}
		else
		{
			echo '<div class="updated" id="message"><p>暂无更新</p></div>';
		}
	}
	if(isset($_POST['DataSubmit']))
	{
		$Uploader = array( 
			'Content' => trim(@$_POST['content']),
			'Comment' => trim(@$_POST['comment']),
			'Donate' => trim(@$_POST['donate']),
			);
		@update_option('SMMS_DATA', $Uploader);
		add_action('widgets_init','qcgzxw');
		echo '<div class="updated" id="message"><p>提交成功</p></div>';
	}
	else
	{
		if(!isset($_POST['Update']))
		{
			echo '<div class="updated subscribe-main" id="message"><p>创作不易，给GitHub点个Star吧。——<span class="text-ruo">[<a href="https://github.com/qcgzxw/SMMS-UPLOADER" target="_blank">立即前往</a>]</span><i class="fr fb f20 qcgzxw-close">&#215;</i></p>'; 
			echo "</div><style>.fb{font-weight:bold;}.f12{font-size:12px;}..f16{font-size:16px;}.f18{font-size:18px;}..fl{float:left;}.fr{float:right;margin-top:-2px;}.oh{overflow:hidden;}i{font-style:normal;}.color-primary{color:#337ab7;}.color-success{color:#5cb85c;}.color-info{color:#5bc0de;}.color-warning{color:#f0ad4e;}.color-red{color:red;padding:0 3px;}</style><script>jQuery('.qcgzxw-close').click(function() {jQuery('.subscribe-main').fadeOut('slow',function(){jQuery('.subscribe-main').remove();});});</script>";		
		}
	}
	$Uploader = get_option('SMMS_DATA'); 
	$Content	= $Uploader['Content']	!== '' ? 'checked="checked"' : '';
	$Comment	= $Uploader['Comment']	!== '' ? 'checked="checked"' : '';
	$Donate	= $Uploader['Donate']	!== '' ? 'checked="checked"' : '';
	
     if ( !current_user_can( 'manage_options' ) )  {
          wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
     }
	 echo '<div class="wrap">';
     echo '<h2>SMMS-UPLOADER 插件设置</h2>';
	 echo '<p>&nbsp;&nbsp;SMMS-UPLOADER是一款为WordPress添加上传图片小工具以及评论处图片上传按钮的插件！</p>';
     echo '<form method = "post">';
     echo '<table class = "form-table">';
     echo '<tbody>';
	 
     echo '<tr valign="top">';
     echo '<th scope="row">启用SM图床小工具</th>';
     echo '<td><label><input value = "true" type = "checkbox" name = "widget" disabled checked>  在 <strong>外观->小工具</strong> 里设置 （默认开启）<a title="不需要此功能，不添加小工具即可">[?]</a></label></td>';
	 echo '</tr>';
	 
	 echo '<tr valign="top">';
     echo '<th scope="row">后台文章编辑启用图片上传</th>';
     echo '<td><label><input value = "true" type = "checkbox" name = "content" '.$Content.'>  勾选后在后台文章编辑处自动添加图片上传按钮</label></td>';
	 echo '</tr>';
	 
	 echo '<tr valign="top">';
	 echo '<th scope="row">是否启用评论上传按钮</th>';
     echo '<td><label><input value = "true" type = "checkbox" name = "comment" '.$Comment.'>  勾选后在评论框后自动添加图片上传按钮</label></td>'; 
	 echo '</tr>';
	 
	 echo '<tr valign="top">';
	 echo '<th scope="row">支持作者</th>';
     echo '<td><label><input value = "true" type = "checkbox" name = "donate" '.$Donate.'><a title="在wp_footer加入作者的链接。感谢！">[?]</a></label></td>'; 
	 echo '</tr>';
	 
	 
	 echo '</tbody>';
	 echo '</table>'; 
	 echo '<p class = "submit">'; 
	 echo '<input class = "button button-primary" type = "submit" name = "DataSubmit" id = "submit" value = "保存更改" />&nbsp;&nbsp;&nbsp;&nbsp;'; 
	 echo '<input class = "button" type = "submit" name = "Update" id = "update" value = "检测更新" />'; 
	 echo '</p>'; 
	 
	 echo '</table>'; 
	 echo '<br>'; 
	 echo '<br>'; 
	 echo '<br>'; 
	 echo '<br>'; 
	 echo '<br>'; 
	 echo '<p><strong>使用提示:</strong><br>&nbsp;&nbsp;1.插件开启后，图床小工具需要在&nbsp;<strong>外观->小工具</strong>&nbsp;处应用小工具。<br>&nbsp;&nbsp;2.图片上传按钮自动添加至评论框下（comment_form_after），如主题引起的错位请自行更改相关代码。<br>&nbsp;&nbsp;2.其它相关问题至小文博客 <a target="_blank" href="https://www.qcgzxw.cn/2555.html">WordPress插件——SM图床小工具插件</a> 页面查看使用说明和留言反馈。</p>'; 
	 echo '</div>'; 
	 
	 
}
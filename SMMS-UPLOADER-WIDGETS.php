<?php
class qcgzxw extends WP_Widget {

    function __construct() { 
		 parent::__construct( 
		 // 小工具ID
		 'smms-uploader', 
		 // 小工具名称
		 __('图床', 'qcgzxw-smms' ), 
		 // 小工具选项
		 array (
		 'description' => __( 'sm.ms图床小工具', 'qcgzxw-smms' )
		 ) 
		 ); 
}
    function form( $instance ) {
		@$title = esc_attr( $instance['title'] );
		?>
			<p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                    SM图床标题：
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
                </label>
            </p>
		<?php
    }
    function update( $new_instance, $old_instance ) {       
		return $new_instance;
    }
 
    function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'] ? $instance['title'] : 'SM 图床';
		if($title) $result .= $before_title . $title . $after_title . $before_widget; 
		echo $result;
		?>
			<div class="upload_box">
			<a href="javascript:;" class="smms-upload-file">选择文件<input type="file" id="image" accept="image/*" multiple="multiple" ></a>
				<div id = "show" style="widht:100%;height:100%;word-wrap: break-word">
				<p class = "text-justify" id="urls"></p>
					<div id = "mul-image"></div>
				</div>
			</div>
			<style>.smms-upload-file{position:relative;display:inline-block;background:#D0EEFF;border:1px solid #99D3F5;border-radius:4px;padding:4px 12px;overflow:hidden;color:#1E88C7;text-decoration:none;text-indent:0;line-height:20px}
.smms-upload-file input{position:absolute;font-size:100px;right:0;top:0;opacity:0}
.smms-upload-file:hover{background:#AADFFD;border-color:#78C3F3;color:#004974;text-decoration:none}</style>
		<?php
		echo $after_widget;
    }
}
function qcgzxw(){
	register_widget('qcgzxw');
}
add_action('widgets_init','qcgzxw');
?>

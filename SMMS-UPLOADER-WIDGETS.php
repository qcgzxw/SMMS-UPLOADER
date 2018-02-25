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
			<div class="upload_box" style = "padding: 20px 0 20px 10px">
			<input type="file" id="image" accept="image/*" multiple="multiple" >
				<div id = "show" style="widht:100%;height:100%;word-wrap: break-word">
				<p class = "text-justify" id="urls"></p>
					<div id = "mul-image"></div>
				</div>
			</div>
		<?php
		echo $after_widget;
    }
}

function qcgzxw(){
	// 注册小工具
	register_widget('qcgzxw');
}
add_action('widgets_init','qcgzxw');

?>
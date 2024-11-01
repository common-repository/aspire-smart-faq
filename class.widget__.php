<?php
/* CLASS ENDS HERE */

/**
 * Adds Foo_Widget widget.
 */
class WP_Widget_Foo extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'widget_foo', 'description' => __('Arbitrary foo or HTML'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('foo', __('WP Multiple FAQ'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		
		
		//$atts['limit'] = $instance['catlimit'];
		if($instance['type'] == 'Category')
		{
			$atts['cat_name'] = $instance['title'];
			multi_faq_shortcode($atts);
		}
		if($instance['type'] == 'Tags')
		{
			$atts['tag_name'] = $instance['tag'];
			multi_faq_shortcode($atts);
		}
		if($instance['type'] == 'Single')
		{
			
		}
		if($instance['type'] == 'List')
		{
			$atts['list'] = $instance['list'];
			list_faq_shortcode($atts);
			
		}
		/*if($instance['type'] == 'Tags')
		{
			multi_faq_shortcode($atts);
		}
		
		multi_faq_shortcode($atts);*/
		
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['catlimit'] = strip_tags($new_instance['catlimit']);
		$instance['type'] = strip_tags($new_instance['type']);
		 // wp_filter_post_kses() expects slashed
		$instance['filter'] = isset($new_instance['filter']);
		$instance['tag'] = isset($new_instance['tag']);
		$instance['single'] = isset($new_instance['single']);
		$instance['list'] = isset($new_instance['list']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','catlimit' => '' ) );
		$title = strip_tags($instance['title']);
		$type = strip_tags($instance['type']);
		$catlimit = strip_tags($instance['catlimit']);
		$tag = strip_tags($instance['tag']);
		$single = strip_tags($instance['single']);
		$list = strip_tags($instance['list']);
?>
		<p>
        <script type="text/javascript">
		jQuery(function(){ 
			jQuery(".widget-content").on("change","#widget-foo-3-type",function(){
				var type = jQuery("#widget-foo-3-type").val();
				if(type=='Category'){ 
				jQuery(".cats").css("display","block");
				}
				if(type=='Tags'){ 
				jQuery(".tags").css("display","block");
				}
				if(type=='Single'){ 
				jQuery(".single").css("display","block");
				}
				if(type=='List'){ 
				jQuery(".list").css("display","block");
				}
			
			});
		});

        </script>
        	<select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" class="widefat">
            	<?php 
				if(esc_attr($catlimit) == 'Category'){ $selected='selected'; }
				if(esc_attr($catlimit) == 'Tags'){ $selected='selected'; }
				if(esc_attr($catlimit) == 'List'){ $selected='selected'; }
				if(esc_attr($catlimit) == 'Single'){ $selected='selected'; }
				?>
            	<option value="0">Select type</option>
                <option >Category</option>
                <option >Tags</option>
                <option >List</option>
                <option >Single</option>
            </select>
        </p>
		<p class="faq_display_none cats"><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Category:'); ?></label>
        
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        please enter the slug of category. For multiple categories, enter slug by comma (,) seprator. For example e.g, general,payment,support
        </p>
        
        <p class="faq_display_none tags"><label for="<?php echo $this->get_field_id('tag'); ?>"><?php _e('Tags:'); ?></label>
        
		<input class="widefat" id="<?php echo $this->get_field_id('tag'); ?>" name="<?php echo $this->get_field_name('tag'); ?>" type="text" value="<?php echo esc_attr($tag); ?>" />
        please enter the slug of tag. For multiple tags, enter slug by comma (,) seprator. For example e.g, general,payment,support
        </p>
		
        <p class="limit"><label for="<?php echo $this->get_field_id('catlimit'); ?>"><?php _e('Cat Limit:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('catlimit'); ?>" name="<?php echo $this->get_field_name('catlimit'); ?>" type="text" value="<?php echo esc_attr($catlimit); ?>" />
        </p>
        
<?php
	}
}
?>
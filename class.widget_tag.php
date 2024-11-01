<?php
	
	class multi_faq_widgets_tag extends WP_Widget {

	public function __construct() {
		// widget actual processes
		
		parent::__construct(
			'faq_widget_tag', // Base ID
			'Aspire Smart FAQ Widget: Tags', // Name
			array( 'description' => __( 'Aspire Smart FAQ Widget for TAGS', 'text_domain' ), ) // Args
		);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		// Two variables are coming in INSTANCE ARRAY , title and limit
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		$limit = $instance['limit'];
		
		$atts['tag_name'] = $title;
		$atts['limit'] = $limit;
		echo $args['before_widget'].'<h2 style="padding: 10px 0px;">FAQs</h2><br>';
		if ( ! empty( $title ) ){
		// Pre define short function is used for widget, for customization please see shortcodes file
		
		list_aspfaq_shortcode($atts);
		}
		echo $args['after_widget'];
		
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	
 	public function form( $instance ) {
		// outputs the options form on admin
		
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( '', 'text_domain' );
		}
		
		if ( isset( $instance[ 'limit' ] ) ) {
			$limit = $instance[ 'limit' ];
		}
		// Printing Form for backend with two fields SLUD and LIMIT
		?>
		<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Tag(s):' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		Enter comma seperated multiple tags OR single tag slug.
		</p>
		
		<p>
		<label >FAQ Limit</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
		Enter the numeric value that defines FAQs limit.
		</p>
		
		<?php 
		
	}
	
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		// Updating two variables of INSTANCE ARRAY, title and limit
		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['limit'] = ( ! empty( $new_instance['limit'] ) ) ? strip_tags( $new_instance['limit'] ) : '';

		return $instance;
	}
}
	
?>
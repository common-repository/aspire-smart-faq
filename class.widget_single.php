<?php
	
	class multi_faq_widgets_single extends WP_Widget {

	public function __construct() {
		// widget actual processes
		
		parent::__construct(
			'faq_widget_single', // Base ID
			'Aspire Smart FAQ Widget: Single', // Name
			array( 'description' => __( 'Aspire Smart FAQ Widget for Single FAQ', 'text_domain' ), ) // Args
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
		// One variable is coming in INSTANCE ARRAY , title
		
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		$atts['id'] = $title;
		
		echo $args['before_widget'].'<h2 style="padding: 10px 0px;">FAQs</h2><br>';
		if ( ! empty( $title ) ){
		// Pre define short function is used for widget, for customization please see shortcodes file
		
		single_aspfaq_shortcode($atts);
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
		// Printing Form for backend with one fields FAQ ID
		?>
		<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'FAQ ID:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		Enter FAQ id to display that specific FAQ
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
		// Updating one variable of INSTANCE ARRAY, title
		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}
}
	
?>
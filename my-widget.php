<?php


// ====================================== WIDGET ====================================== //
	
	// Add My Text widget.
	
	class My_Text_Widget extends WP_Widget {

		// Register widget with WordPress
		function __construct() {
			parent::__construct(
				'my_text_widget', // Base ID
				__( 'My Text Widget', 'awesome' ), // Name
				array( 'description' => __( 'Awesome My Text Widget', 'awesome' ), )
			);
		}

		//Front-end display of widget 
		public function widget( $args, //arguments from register_sidebar()    
							   $instance // Saved values from Database
							  ) {  
			echo $args['before_widget'];
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
			}

			if ( ! empty( $instance['content'] ) ) {
				echo apply_filters( 'widget_title', $instance['content'] );
			}
			
			echo $args['after_widget'];
			
		}

		// Back-end widget form
		public function form( $instance ) {
			// $instance -> Previously saved values from database
			$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'awesome' );
			?>
			<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
				   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
				   value="<?php echo esc_attr( $title ); ?>">
				<br />
				<br />
			
			<?php $content = ! empty( $instance['content'] ) ? $instance['content'] : __( '', 'awesome' );
			?>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e( 'Content:' ); ?><br /></label> 
			<textarea rows="10" cols="28" name="<?php echo $this->get_field_name( 'content' ); ?>" wrap="hard">
				<?php echo esc_attr( $content ); ?>
			</textarea> 
			</p>
			<?php 
		}

		// Sanitize widget form values as they are saved
		public function update( $new_instance, // Values just sent to be saved
							   $old_instance ) { // Previously saved values from database
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['content'] = ( ! empty( $new_instance['content'] ) ) ?  $new_instance['content']  : '';
			return $instance;
		}

	} // class My_Text_Widget


	// register My_Text_Widget widget

	function register_my_widget(){
		register_widget( 'My_Text_Widget' ); 
	} 
	add_action( 'widgets_init', 'register_my_widget' );
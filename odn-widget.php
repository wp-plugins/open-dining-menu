<?php

class ODN_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'odn_widget', // Base ID
			__('Open Dining Menu', 'odn_button'), // Name
			array(
				'description' => __('Open Dining Menu Button', 'odn_button'),
			) // Args
		);
	}

	public function widget($args, $instance) {
		$title = apply_filters('widget_title', $instance['title']);
		$description = apply_filters('widget_title', $instance['description']);

		echo $args['before_widget'];
		if (!empty($title))
			echo $args['before_title'] . $title . $args['after_title'];

		$options = get_option('odn_options');

		if (isset($options['odn_app_id']) && !empty($options['odn_app_id'])) {
			echo '<script type="text/javascript" src="' . odn_get_odn_url() . 'media/js/wp-order-button.js?id=' . $options['odn_app_id'] . '&type=fixed"></script>';
		}

		if (!empty($description))
			echo $description;

		echo $args['after_widget'];
	}

	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('Order Now!', 'odn_button');
		}

		if (isset($instance['description'])) {
			$description = $instance['description'];
		} else {
			$description = __('Do it now!', 'odn_button');
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo esc_attr($description); ?>" />
		</p>
		<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['description'] = (!empty($new_instance['description'])) ? strip_tags($new_instance['description']) : '';

		return $instance;
	}

}

// register ODN_Widget widget
function register_odn_widget() {
	register_widget('ODN_Widget');
}
add_action('widgets_init', 'register_odn_widget');

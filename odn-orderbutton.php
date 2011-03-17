<?php
/*
Plugin Name: Order Now Button
Plugin URI: http://www.opendining.net
Description: Enable online ordering on your web site.
Version: 1.0
Author: Tim Ridgely
Author URI: http://www.opendining.net
*/

/*
Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

add_action('admin_menu', 'odn_add_button_options_page');
add_action('wp_footer', 'odn_display_button');
add_action('admin_init', 'odn_button_options_init');
add_filter('plugin_action_links', 'odn_button_add_settings_link', 10, 2);

function odn_button_options_init() {
	register_setting('odn_options', 'odn_options', 'odn_validate_settings');
	add_settings_section('odn_button_section', 'Button Settings', 'odn_button_section_overview', __FILE__);
	add_settings_field('odn_app_id', 'App ID', 'setting_string_fn', __FILE__, 'odn_button_section');
}

function odn_add_button_options_page() {
	add_options_page('Order Now Button Settings', 'Open Dining Menu', 'manage_options', __FILE__, 'odn_button_options_page');
}

function odn_validate_settings($input) {	
	// $input['odn_app_id'] = trim($input['odn_app_id']);
	// if (strlen($input['odn_app_id']) != 24 || preg_match("/[^a-zA-Z0-9\s]/", $input['odn_app_id']) !== 0)
		// $input['odn_app_id'] = '';
	
	return $input;	
}

function odn_button_section_overview() {}

function setting_string_fn() {
	$options = get_option('odn_options');
	echo "<input name='odn_options[odn_app_id]' type='text' size='33' value='{$options['odn_app_id']}' />";
}

function odn_display_button() {
	$options = get_option('odn_options');
	
	if (isset($options['odn_app_id']) && $options['odn_app_id']) {
		echo '<script type="text/javascript">(function(){function b(){var c=document.createElement("script"),a=document.getElementsByTagName("script")[0];c.type="text/javascript";c.async=true;c.src=(("https:"==document.location.protocol)?"https":"http")+"://www.opendining.net/media/js/order-button.js?id='.$options['odn_app_id'].'";a.parentNode.insertBefore(c,a)}if(window.attachEvent){window.attachEvent("onload",b)}else{window.addEventListener("load",b,false)}})();</script>';
	}
}

function odn_button_add_settings_link($links, $file) {
	static $this_plugin;
	if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

	if ($file == $this_plugin) {
		$settings_link = '<a href="options-general.php?page=open-dining-menu/odn-orderbutton.php">'.__("Settings", "odn_button").'</a>';
		array_unshift($links, $settings_link);
	}
	
	return $links;
 }

function odn_button_options_page() {
?>
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br /></div>
	<h2>Order Now Button Settings</h2>
	<p>
		Our Order Now button lets you easily take orders through your site.  Customize the colors and font to match your site.
	</p>
	<form action="options.php" method="post">
	<?php settings_fields('odn_options'); ?>
	<?php do_settings_sections(__FILE__); ?>
	
	<p class="submit">
		<input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
	</p>
	</form>
	
	<h3>Setup Instructions</h3>
	<p>
		Not sure how to get your App ID?  It's easy!  <a href="https://www.opendining.net/admin" target="_BLANK">Click here to go to the Open Dining editor.</a>
	</p>
	
	<p>
		From the Dashboard, select Web Tools to configure your button and get your App ID, as shown below.<br /><br />
		<img src="https://www.opendining.net/media/images/wp-help-dashboard.png" />
	</p>
</div>
<?php
}
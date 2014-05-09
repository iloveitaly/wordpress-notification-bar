<?php
/*
Plugin Name: Simple Wordpress Notification Bar
Description: Custom RSS feed to work better with MC
Version: 1.0
License: MIT

Author: Michael Bianco
Author URI: http://cliffsidemedia.com/
Plugin URI: https://github.com/iloveitaly/wordpress-mailchimp-rss
*/

define( 'WNB_PLUGIN_PATH', dirname( __FILE__ ) );
define( 'WNB_PLUGIN_URL', plugin_dir_url(  __FILE__  ) );

add_action('wp_enqueue_scripts', 'wnb_assets');
function wnb_assets() {
	wp_enqueue_style('wnb_style', WNB_PLUGIN_URL . 'style.css', array(), '1.0.0');
}

// unfortunately this is the only way to insert HTML into the body
add_action('wp_head', 'wnb_insert');
function wnb_insert() {
	$notification_bar_content = get_option('wnb_notification_content');

	if(!empty($notification_bar_content)) {
		$notification_bar_content = do_shortcode($notification_bar_content);
		echo <<<EOL
<script>
	jQuery(document).ready(function($) {
		$('body').prepend('<div id="wordpress_notification_bar">{$notification_bar_content}</div>');
});
</script>
EOL;

	}
}

function wnb_admin_page() {
	?>
	<div class="wrap">
		<h2>Notification Bar</h2>
		<p>Enter the content for the notification bar below.</p>
		<form action="options.php" method="post">
			<?php settings_fields('wnb_options'); ?>
			<?php do_settings_sections('wnb_options'); ?>
			<textarea name="wnb_notification_content"  style="width: 100%; height: 300px;"><?php echo get_option('wnb_notification_content'); ?></textarea>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}


if(is_admin()) {
	add_action('admin_init', 'wnb_register_settings');
	function wnb_register_settings() {
		register_setting('wnb_options', 'wnb_notification_content');
	}

	add_action('admin_menu', 'wnb_set_up_admin_page');
	function wnb_set_up_admin_page() {
		add_options_page('Notification Bar', 'Notification Bar', 'manage_options', 'wnb_options', 'wnb_admin_page');
	}
}

register_activation_hook(__FILE__, 'wnb_set_up_options');
function wnb_set_up_options () {
	add_option('wnb_options', '');
}

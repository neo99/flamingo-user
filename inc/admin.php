<?php

add_action('admin_init', 'flamingo_user_init' );
add_action('admin_menu', 'flamingo_user_add_page');

// Init plugin options to white list our options
function flamingo_user_init(){

	register_setting( 'flamingo_user_options', 'flamingo_user', 'flamingo_user_validate' );
}

// Add menu page
function flamingo_user_add_page() {
	if (!current_user_can('manage_options')) {
        return;
    }

	add_options_page('Flamingo User Options', 'Flamingo User', 'manage_options', 'flamingo_user', 'flamingo_user_do_page');
}

// Draw the menu page itself
function flamingo_user_do_page() {
	if (!current_user_can('manage_options')) {
        return;
    }

	?>
	<div class="wrap">
		<h2>Flamingo User Options</h2>
		<form method="post" action="options.php">
			<?php settings_fields('flamingo_user_options'); ?>
			<?php $options = get_option('flamingo_user'); ?>
            Contact Form 7 Titles 
            <input type="text" name="flamingo_user[cf7_titles]" class="regular-text code" value="<?php echo esc_attr($options['cf7_titles']) ?>">
			Delimited by comma. For example: Contact form 1, Contact form 2, etc.
			<?php submit_button('Save Settings'); ?>
		</form>
	</div>
	<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function flamingo_user_validate($input) {
	// Say our second option must be safe text with no HTML tags
	$input['cf7_titles'] =  wp_filter_nohtml_kses($input['cf7_titles']);
	
	return $input;
}
<?php
/*
 * Plugin Name: Theme Preview
 * Plugin URI: http://dougal.gunters.org/plugins/theme-preview
 * Description: Allows themes to be previewed without activation
 * Author: Dougal Campbell
 * Author URI: http://dougal.gunters.org/
 * Version: 1.3
 */

/*
 * USAGE:
 *
 * Add query variables 'preview_theme' and/or 'preview_css' to
 * your query string. Example:
 *  http://example.com/index.php?preview_theme=default&preview_css=my-theme
 * 
 * TODO: 
 * 
 *  * Add an options page with theme selection, and persistence setting.
 *  * Use cookies to allow persistent theme previews.
 *
 * NOTES:
 *
 *  * preview_theme does not always work well with child themes.
 *
 * DEMO:
 *  http://dougal.gunters.org/blog/2005/03/09/theme-preview-plugin/
 */

/* Hook on setup_theme so we can modify things */
add_action('setup_theme', 'gr_preview_theme_init');

// globals
$gr_preview_theme = '';
$gr_preview_css = '';

function gr_preview_theme_init() {
	global $gr_preview_theme, $gr_preview_css;
	
	$gr_preview_theme = $_GET['preview_theme'];
	$gr_preview_css = $_GET['preview_css'];
	
	if (! $gr_preview_css ) {
		$gr_preview_css = $gr_preview_theme;
	}

	if($gr_preview_theme && file_exists(get_theme_root() . "/${gr_preview_theme}")) {
		add_filter('template','use_preview_theme');
	}

	if($gr_preview_css && file_exists(get_theme_root() . "/${gr_preview_css}")) {
		add_filter('stylesheet','use_preview_css');
	}

}

function use_preview_theme($themename) {
	global $gr_preview_theme;

	return $gr_preview_theme;
}

function use_preview_css($cssname) {
	global $gr_preview_css;

	return $gr_preview_css;
}


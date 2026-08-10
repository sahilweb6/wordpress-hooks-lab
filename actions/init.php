<?php
/**
 * Hook: init
 * Type: Action
 * Fires: After WordPress has finished loading but before any headers are sent.
 * Common uses: registering custom post types, custom taxonomies, session start,
 * shortcodes, and other setup that needs WP core to be ready first.
 *
 * Docs: https://developer.wordpress.org/reference/hooks/init/
 */

// Example 1: Register a custom post type
add_action( 'init', 'whl_register_portfolio_cpt' );
function whl_register_portfolio_cpt() {
	$labels = array(
		'name'          => 'Portfolio Items',
		'singular_name' => 'Portfolio Item',
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'has_archive'  => true,
		'menu_icon'    => 'dashicons-portfolio',
		'supports'     => array( 'title', 'editor', 'thumbnail' ),
		'show_in_rest' => true, // needed for Gutenberg / block editor support
	);

	register_post_type( 'portfolio', $args );
}

// Example 2: Remove a default action registered on init (gotcha worth knowing)
// WordPress core hooks 'wp_sitemaps_get_server' related setup and a few others
// on init — this shows how you'd unhook something core registers here.
remove_action( 'init', 'wp_admin_bar_init' );
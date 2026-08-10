<?php
/**
 * Hook: the_content
 * Type: Filter
 * Fires: When post/page content is retrieved for display, e.g. via the_content()
 * in a template. Runs on the raw post content before it's echoed to the page.
 * Common uses: appending/prepending content, wrapping content in markup,
 * injecting ads or CTAs, modifying shortcodes output.
 *
 * Docs: https://developer.wordpress.org/reference/hooks/the_content/
 */

// Example 1: Append a call-to-action after single post content
add_filter( 'the_content', 'whl_append_cta_to_content' );
function whl_append_cta_to_content( $content ) {
	if ( is_single() && in_the_loop() && is_main_query() ) {
		$cta  = '<div class="whl-cta">';
		$cta .= '<p>Liked this post? <a href="/newsletter">Subscribe to the newsletter</a>.</p>';
		$cta .= '</div>';

		$content .= $cta;
	}

	return $content;
}

// Example 2: Gotcha — the_content filter can run more than once per page load
// (e.g. once for an excerpt-like preview, once for the real render), and some
// themes/plugins call the_content() manually outside the loop. Always guard
// with in_the_loop() and is_main_query() like above, or you'll get duplicated
// output or content injected in the wrong place (widgets, previews, feeds).

// Example 3: Priority matters — the_content has other filters attached by
// core (e.g. wpautop at priority 10) and by plugins (page builders, SEO
// plugins). If your output looks mangled or duplicated, check what else is
// hooked in with a quick var_dump on $wp_filter['the_content'].
add_filter( 'the_content', 'whl_wrap_in_container', 20 ); // runs after wpautop
function whl_wrap_in_container( $content ) {
	return '<div class="whl-content-wrap">' . $content . '</div>';
}
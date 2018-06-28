<?php
/**
 * Monochrome Pro
 *
 * Adds Search Template to child
 *
 * @package Monochrome Pro
 * @author  Joe Casabona
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/genesis/
 */

add_action( 'genesis_before_loop', 'genesis_do_search_title' );
/**
 * Echo the title with the search term.
 *
 * @since 1.9.0
 */
function genesis_do_search_title() {

	$title = sprintf( '<div class="archive-description"><h1 class="archive-title">%s %s</h1></div>', apply_filters( 'genesis_search_title_text', __( 'Search Results for:', 'genesis' ) ), get_search_query() );

	echo apply_filters( 'genesis_search_title_output', $title ) . "\n";

}

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'the_excerpt' );
remove_filter( 'the_content', 'wpp_append_sponsors', 9 );

genesis();

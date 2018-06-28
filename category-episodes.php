<?php
/**
 * Monochrome Pro.
 *
 * This file controls the layout for the episodes archive.
 *
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

// Add pricing page body class to the head.
add_filter( 'body_class', 'monochrome_add_body_class' );
function monochrome_add_body_class( $classes ) {

	$classes[] = 'hibi-episodes';

	return $classes;

}

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_entry_content', 'hibi_do_episode_content' ); 


// Run the Genesis loop.
genesis();

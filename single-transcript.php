<?php
/**
 * Monochrome Pro.
 *
 * This file adds the single post template to the Monochrome Pro Theme.
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

// Add body class if post has featured image.
add_filter( 'body_class', 'monochrome_body_class_post' );
function monochrome_body_class_post( $classes ) {

	if ( has_post_thumbnail() ) {
		$classes[] = 'transcript';
	}

	return $classes;

}

add_action( 'genesis_entry_content', 'hibi_get_episode_by_transcript', 5 );

function hibi_get_episode_by_transcript() {
	$args = array(
		'posts_per_page' => -1,
		'order' => 'ASC',
		'meta_key'   => 'wpp_episode_transcript',
		'meta_query' => array(
			array(
				'key' => 'wpp_episode_transcript',
				'value' => strval( get_the_id() ),
				'compare' => 'LIKE',
			)
		)
	 );

	 $episodes = new WP_Query( $args );

	 //var_dump( $episodes );

	 if ( $episodes->have_posts() ) {
		while ( $episodes->have_posts() ) {
			$episodes->the_post();
			echo do_shortcode( '[powerpress]' );
			echo wpp_get_sponsors();
		}
		wp_reset_postdata();
	 }
}


// Force full width layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

// Run the Genesis loop.
genesis();

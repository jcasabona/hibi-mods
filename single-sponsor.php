<?php
/**
 * Monochrome Pro.
 *
 * This file adds the single post template for the Sponsor CPT to the Monochrome Pro Theme.
 *
 * @package Monochrome
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    https://my.studiopress.com/themes/monochrome/
 */

// Add body class if post has featured image.
add_filter( 'body_class', 'monochrome_body_class_post' );
function monochrome_body_class_post( $classes ) {

	$classes[] = 'sponsors';

	return $classes;
}

add_action( 'genesis_entry_header', 'hibi_featured_image', 5 );

function hibi_featured_image() {
	printf( '<a href="%1$s" title="%2$s">%3$s</a>', 
		get_the_permalink(),
		get_the_title(),
		get_the_post_thumbnail( get_the_id(), 'full', [ 'class' => 'center, aligncenter' ] )
	);
}

// Force full width layout
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );


add_action( 'genesis_entry_footer', 'hibi_sponsor_link' );

function hibi_sponsor_link() {
	$sponsor_link = get_post_meta( get_the_id(), 'wpp_sponsor_link', true );
	printf( '<p><a href="%1$s" title="%2$s" target="_blank" class="button aligncenter center wpp-sponsor-link">Visit %2$s</a></p>',
		esc_attr( $sponsor_link ),
		get_the_title()
	);
}

add_action( 'genesis_after_entry', 'hibi_get_episodes_by_sponsor' );

function hibi_get_episodes_by_sponsor() {
	$args = array(
		'posts_per_page' => -1,
		'order' => 'ASC',
		'meta_key'   => 'wpp_episode_sponsor',
		'meta_query' => array(
			array(
				'key' => 'wpp_episode_sponsor',
				'value' => strval( get_the_id() ),
				'compare' => 'LIKE',
			)
		)
	 );

	 $episodes = new WP_Query( $args );

	 //var_dump( $episodes );

	 if ( $episodes->have_posts() ) {
		 echo '<h4>Episodes Sponsored:</h4>';
		 echo '<ul class="wpp-episodes-sponsored">';
		while ( $episodes->have_posts() ) {
			$episodes->the_post();
			printf( '<li><a href="%1$s" title="%2$s">%2$s</a></li>',
				get_the_permalink(),
				get_the_title()
			);
		}
		echo '</ul>';
		wp_reset_postdata();
	 }
}

remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

// Run the Genesis loop.
genesis();

<?php

/** How I Built It Adds */
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
/**
 * Customize entry meta in the entry header.
 *
 * @param string $post_info Existing post info
 * @return Modified post info
 */
function sp_post_info_filter( $post_info ) {

    return '';
}

// Replaces the excerpt "Read More" text by a link
function hibi_excerpt_more( $more ) {
	global $post;
 	return '... <p><a class="moretag button" href="'. get_permalink( $post->ID ) . '">Get the Show Notes</a></p>';
}

add_filter( 'excerpt_more', 'hibi_excerpt_more' );

add_action( 'genesis_before_loop', 'hibi_home_check' );

function hibi_home_check() {
	if ( is_home() ) {
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
		add_action( 'genesis_entry_content', 'hibi_do_post_image', 8 );
		remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
		add_action( 'genesis_entry_content', 'hibi_do_episode_content' ); 
	}
}

function hibi_do_post_image() {
	global $wp_query;
	if( $wp_query->current_post == 0 ) { 
		genesis_do_post_image();
	}
}

function hibi_do_episode_content() {
    echo do_shortcode( '[powerpress]' );
    if ( function_exists( 'wpp_get_sponsors_feed' ) ) {
      echo wpp_get_sponsors_feed();
    }
    printf( '<a href="%1$s" title="%2$s">Show Notes / Transcript</a>', get_the_permalink(), get_the_title() );
}

add_filter( 'genesis_footer_creds_text', 'hibi_footer_creds_filter' );

function hibi_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="https://casabona.org">Joe Casabona</a> &middot; Built on the <a href="https://casabona.org/sp-monochrome" title="Monochrome Pro">Monochrome Pro / Genesis Framework</a>';

	return $creds;
}

define( 'ACF_EARLY_ACCESS', '5' );

function hibi_searchwp_extra_metadata( $extra_meta, $post_being_indexed ) {
    // index the author name and bio with each post
	$extra_meta['wpp_transcript_content'] = wpp_get_transcript_content( $post_being_indexed->ID );
    return $extra_meta;
}

add_filter( 'searchwp_extra_metadata', 'hibi_searchwp_extra_metadata', 10, 2 );
 
function hibi_meta_keys( $keys ) {
    $transcript_meta_keys = array( 
        'wpp_transcript_content'
    );
    
    // merge my custom meta keys with the existing keys
    $keys = array_merge( $keys, $transcript_meta_keys );
    
    // make sure there aren't any duplicates
    $keys = array_unique( $keys );
    
    return $keys;
}
 
add_filter( 'searchwp_custom_field_keys', 'hibi_meta_keys', 10, 1 );
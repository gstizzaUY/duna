<?php
/**
 * Block Filters
 *
 * @package multi_purpose
 * @since 1.0
 */

function multi_purpose_block_wrapper( $multi_purpose_block_content, $multi_purpose_block ) {

	if ( 'core/button' === $multi_purpose_block['blockName'] ) {
		
		if( isset( $multi_purpose_block['attrs']['className'] ) && strpos( $multi_purpose_block['attrs']['className'], 'has-arrow' ) ) {
			$multi_purpose_block_content = str_replace( '</a>', multi_purpose_get_svg( array( 'icon' => esc_attr( 'caret-circle-right' ) ) ) . '</a>', $multi_purpose_block_content );
			return $multi_purpose_block_content;
		}
	}

	if( ! is_single() ) {
	
		if ( 'core/post-terms'  === $multi_purpose_block['blockName'] ) {
			if( 'post_tag' === $multi_purpose_block['attrs']['term'] ) {
				$multi_purpose_block_content = str_replace( '<div class="taxonomy-post_tag wp-block-post-terms">', '<div class="taxonomy-post_tag wp-block-post-terms flex">' . multi_purpose_get_svg( array( 'icon' => esc_attr( 'tags' ) ) ), $multi_purpose_block_content );
			}

			if( 'category' ===  $multi_purpose_block['attrs']['term'] ) {
				$multi_purpose_block_content = str_replace( '<div class="taxonomy-category wp-block-post-terms">', '<div class="taxonomy-category wp-block-post-terms flex">' . multi_purpose_get_svg( array( 'icon' => esc_attr( 'category' ) ) ), $multi_purpose_block_content );
			}
			return $multi_purpose_block_content;
		}
		if ( 'core/post-date' === $multi_purpose_block['blockName'] ) {
			$multi_purpose_block_content = str_replace( '<div class="wp-block-post-date">', '<div class="wp-block-post-date flex">' . multi_purpose_get_svg( array( 'icon' => esc_attr( 'calendar' ) ) ), $multi_purpose_block_content );
			return $multi_purpose_block_content;
		}
		if ( 'core/post-author' === $multi_purpose_block['blockName'] ) {
			$multi_purpose_block_content = str_replace( '<div class="wp-block-post-author">', '<div class="wp-block-post-author flex">' . multi_purpose_get_svg( array( 'icon' => esc_attr( 'user' ) ) ), $multi_purpose_block_content );
			return $multi_purpose_block_content;
		}
	}
	if( is_single() ){

		// Add chevron icon to the navigations
		if ( 'core/post-navigation-link' === $multi_purpose_block['blockName'] ) {
			if( isset( $multi_purpose_block['attrs']['type'] ) && 'previous' === $multi_purpose_block['attrs']['type'] ) {
				$multi_purpose_block_content = str_replace( '<span class="post-navigation-link__label">', '<span class="post-navigation-link__label">' . multi_purpose_get_svg( array( 'icon' => esc_attr( 'prev' ) ) ), $multi_purpose_block_content );
			}
			else {
				$multi_purpose_block_content = str_replace( '<span class="post-navigation-link__label">Next Post', '<span class="post-navigation-link__label">Next Post' . multi_purpose_get_svg( array( 'icon' => esc_attr( 'next' ) ) ), $multi_purpose_block_content );
			}
			return $multi_purpose_block_content;
		}
		if ( 'core/post-date' === $multi_purpose_block['blockName'] ) {
            $multi_purpose_block_content = str_replace( '<div class="wp-block-post-date">', '<div class="wp-block-post-date flex">' . multi_purpose_get_svg( array( 'icon' => 'calendar' ) ), $multi_purpose_block_content );
            return $multi_purpose_block_content;
        }
		if ( 'core/post-author' === $multi_purpose_block['blockName'] ) {
            $multi_purpose_block_content = str_replace( '<div class="wp-block-post-author">', '<div class="wp-block-post-author flex">' . multi_purpose_get_svg( array( 'icon' => 'user' ) ), $multi_purpose_block_content );
            return $multi_purpose_block_content;
        }

	}
    return $multi_purpose_block_content;
}
	
add_filter( 'render_block', 'multi_purpose_block_wrapper', 10, 2 );

<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Cucina
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function cucina_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'cucina_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function cucina_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	return $classes;
}
add_filter( 'body_class', 'cucina_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function cucina_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}

	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'cucina' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'cucina_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function cucina_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'cucina_setup_author' );

/**
 * Comment callback
 */
function cucina_comment( $comment, $args, $depth ) { ?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '' ); ?>>
	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

		<?php if ( 0 != $args['avatar_size'] ) : ?>
		<div class="comment-avatar">
			<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
		</div>
		<?php endif; ?>

		<div class="comment-content">
			<?php comment_text(); ?>
		</div><!-- .comment-content -->

		<?php if ( '0' == $comment->comment_approved ) : ?>
			<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
		<?php endif; ?>

		<footer class="comment-meta">
			<div class="comment-metadata">
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>"><?php printf( _x( '%s ago', 'time ago', 'cucina' ), human_time_diff( get_comment_time('U') ) ); ?></time></a>

				<span class="comment-author vcard">
					<?php printf( __( '<span class="says">by</span> %s' ), sprintf( '<span class="fn">%s</span>', get_comment_author_link() ) ); ?>
				</span><!-- .comment-author -->

				<span class="reply">
				<?php //comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</span><!-- .reply -->

				<?php //edit_comment_link( __( 'Edit' ), ' <span class="edit-link">', '</span>' ); ?>
			</div><!-- .comment-metadata -->
		</footer><!-- .comment-meta -->

	</article><!-- .comment-body -->
<?php
}

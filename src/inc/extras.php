<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Cucina
 */

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

	if ( is_year() ) {
		$classes[] = 'year-archive';
	}

	if ( is_singular() ) {
		$classes[] = 'singular';

		if ( has_post_thumbnail() ) {
			$classes[] = 'has-image';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'cucina_body_classes' );

/**
 * The year archive should show a lot of posts.
 */
function cucina_year_query( $query ){
	if ( $query->is_main_query() && is_year() ) {
		$query->set( 'posts_per_archive_page', 110 );
	}
}
add_action( 'pre_get_posts', 'cucina_year_query' );

/**
 * Use `year.php` for the year-by-month archive.
 */
function cucina_year_template( $template ){
	if ( is_year() ) {
		$templates = array( 'year.php' );
		$template = locate_template( $templates );
	}
	return $template;
}
add_filter( 'date_template', 'cucina_year_template' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
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
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function cucina_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'cucina_render_title' );
endif;

/**
 * Comment callback
 */
function cucina_comment( $comment, $args, $depth ) { ?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( $args['has_children'] ? 'parent' : '' ); ?>>
	<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

		<?php if ( ( 'pingback' != $comment->comment_type ) && ( 0 != $args['avatar_size'] ) ) : ?>
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
				<?php if ( 'pingback' == $comment->comment_type ) : ?>
					<?php printf( __( '<span class="says">from</span> %s' ), get_comment_author_link() ); ?>
				<?php else : ?>
				<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>"><?php printf( _x( '%s ago', 'time ago', 'cucina' ), human_time_diff( get_comment_time('U') ) ); ?></time></a>

				<span class="comment-author vcard">
					<?php printf( __( '<span class="says">by</span> %s' ), sprintf( '<span class="fn">%s</span>', get_comment_author_link() ) ); ?>
				</span><!-- .comment-author -->

				<span class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</span><!-- .reply -->

				<?php endif; ?>
			</div><!-- .comment-metadata -->
		</footer><!-- .comment-meta -->

	</article><!-- .comment-body -->
<?php
}

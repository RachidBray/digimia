<?php
/**
 * EDD Reviews presentation.
 *
 * Display-only, through the extension's own filters: each review in theme
 * markup with CSS stars (no Dashicons font), a rating summary under the
 * Reviews heading, a compact "Helpful?" vote, and a one-line sign-in prompt in
 * place of the full login form. The `rating` product fact
 * (inc/edd-product.php) uses review_stats(). Everything is skipped when EDD
 * Reviews is inactive.
 *
 * @package digimia
 */

declare(strict_types=1);

namespace Digimia;

/**
 * Approved reviews of a download: average rating and count.
 *
 * Owner replies are not reviews and are left out, as in EDD Reviews' own
 * counts.
 *
 * @param int $download_id Download ID.
 * @return array{average: float, count: int}
 */
function review_stats( int $download_id ): array {
	static $cache = array();

	if ( isset( $cache[ $download_id ] ) ) {
		return $cache[ $download_id ];
	}

	$stats = array(
		'average' => 0.0,
		'count'   => 0,
	);

	if ( ! function_exists( 'edd_reviews' ) || ! $download_id || edd_reviews()->is_review_status( 'disabled', $download_id ) ) {
		$cache[ $download_id ] = $stats;
		return $stats;
	}

	// EDD Reviews hides reviews from every comment query; lift that for this one.
	$hide = array( edd_reviews(), 'hide_reviews' );
	$had  = remove_action( 'pre_get_comments', $hide );

	$ratings = get_comments(
		array(
			'post_id'    => $download_id,
			'type'       => 'edd_review',
			'status'     => 'approve',
			'fields'     => 'ids',
			'meta_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'   => 'edd_review_approved',
					'value' => '1',
				),
				array(
					'key'     => 'edd_review_reply',
					'compare' => 'NOT EXISTS',
				),
			),
		)
	);

	if ( $had ) {
		add_action( 'pre_get_comments', $hide );
	}

	$values = array_filter( array_map( static fn( $id ) => (int) get_comment_meta( (int) $id, 'edd_rating', true ), $ratings ) );
	if ( $values ) {
		$stats = array(
			'average' => round( array_sum( $values ) / count( $values ), 1 ),
			'count'   => count( $values ),
		);
	}

	$cache[ $download_id ] = $stats;
	return $stats;
}

/**
 * Star rating: five stars filled to the rating with CSS (`.digimia-rating-stars`).
 *
 * @param float $rating Rating out of 5.
 * @return string
 */
function star_rating( float $rating ): string {
	$rating = max( 0, min( 5, $rating ) );

	return sprintf(
		'<span class="digimia-rating-stars" style="--digimia-rating:%1$s" role="img" aria-label="%2$s"></span>',
		esc_attr( (string) $rating ),
		/* translators: %s: rating out of 5, e.g. 4.5. */
		esc_attr( sprintf( __( 'Rated %s out of 5', 'digimia' ), number_format_i18n( $rating, floor( $rating ) === $rating ? 0 : 1 ) ) )
	);
}

/**
 * Render each review with review_markup() instead of EDD Reviews' walker HTML.
 *
 * `div` style: the list wrapper is a div, so the walker closes each review
 * with `</div>` (its default `li` would sit in a div).
 *
 * @param array<string, mixed> $args wp_list_comments() arguments.
 * @return array<string, mixed>
 */
function review_list_args( array $args ): array {
	$args['callback'] = __NAMESPACE__ . '\review_markup';
	$args['style']    = 'div';

	return $args;
}
add_filter( 'edd_reviews_render_reviews_args', __NAMESPACE__ . '\review_list_args' );

/**
 * One review: stars and title, text, then reviewer, date, and the vote.
 *
 * Opens the review element; the walker closes it. Keeps EDD Reviews' IDs and
 * hooks, which its scripts, anchors, and add-ons use.
 *
 * @param \WP_Comment          $comment Review.
 * @param array<string, mixed> $args    wp_list_comments() arguments.
 * @param int                  $depth   1 for a review, more for a reply.
 */
function review_markup( \WP_Comment $comment, array $args, int $depth ): void {
	$reviews  = edd_reviews();
	$is_reply = $depth > 1;
	$verified = ! $is_reply && $comment->user_id && $reviews->has_user_purchased( (int) $comment->user_id, (int) $comment->comment_post_ID );

	do_action( 'edd_reviews_before_review' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- EDD Reviews' own hook, kept for its add-ons.
	?>
	<div id="edd-review-<?php comment_ID(); ?>" <?php comment_class( array( 'digimia-review', $is_reply ? 'is-reply' : '' ), $comment ); ?>>
		<article id="div-edd-review-<?php comment_ID(); ?>" class="edd-review-body">
			<?php if ( ! $is_reply ) : ?>
				<header class="digimia-review__header">
					<?php echo star_rating( (float) get_comment_meta( (int) $comment->comment_ID, 'edd_rating', true ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in star_rating(). ?>
					<h3 class="digimia-review__title"><?php echo esc_html( (string) get_comment_meta( (int) $comment->comment_ID, 'edd_review_title', true ) ); ?></h3>
				</header>
			<?php endif; ?>

			<?php if ( '0' === (string) $comment->comment_approved ) : ?>
				<p class="edd-review-awaiting-moderation"><?php esc_html_e( 'Your review is awaiting moderation.', 'digimia' ); ?></p>
			<?php endif; ?>

			<div class="digimia-review__content edd-review-content">
				<?php comment_text( $comment ); ?>
			</div>

			<footer class="digimia-review__meta">
				<?php echo get_avatar( $comment, 32 ); ?>
				<span class="digimia-review__author"><?php comment_author( $comment ); ?></span>
				<a class="digimia-review__date" href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
					<time datetime="<?php echo esc_attr( get_comment_date( 'c', $comment ) ); ?>"><?php echo esc_html( get_comment_date( '', $comment ) ); ?></time>
				</a>
				<?php if ( $verified ) : ?>
					<span class="digimia-review__verified"><?php esc_html_e( 'Verified buyer', 'digimia' ); ?></span>
				<?php endif; ?>
				<?php edit_comment_link( __( 'Edit', 'digimia' ), '<span class="digimia-review__edit">', '</span>', $comment ); ?>
			</footer>

			<div class="digimia-review__actions">
				<?php
				if ( ! $is_reply ) {
					echo $reviews->voting->get_comment_helpful_output( $comment ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- EDD Reviews markup.
				}

				$reviews->reviews_reply_link(
					array_merge(
						$args,
						array(
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'] ?? 0,
							'reply_text' => __( 'Reply', 'digimia' ),
						)
					)
				);
				?>
			</div>
		</article>
	<?php
	do_action( 'edd_reviews_after_review' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- EDD Reviews' own hook, kept for its add-ons.
}

/**
 * Rating summary under the Reviews heading: stars, "4.7 out of 5", count.
 */
function review_summary(): void {
	$stats = review_stats( (int) get_the_ID() );
	$count = $stats['count'];

	if ( ! $count ) {
		return;
	}

	printf(
		'<div class="digimia-review-summary">%1$s<p><strong>%2$s</strong> <span>%3$s</span></p></div>',
		star_rating( $stats['average'] ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in star_rating().
		/* translators: %s: average rating, e.g. 4.7. */
		esc_html( sprintf( __( '%s out of 5', 'digimia' ), number_format_i18n( $stats['average'], 1 ) ) ),
		/* translators: %s: number of reviews. */
		esc_html( sprintf( _n( 'Based on %s review', 'Based on %s reviews', $count, 'digimia' ), number_format_i18n( $count ) ) )
	);
}
add_action( 'edd_reviews_title_after', __NAMESPACE__ . '\review_summary', 5 );

/**
 * Vote prompt: a short question. The intro line before it is hidden in CSS.
 */
add_filter(
	'edd_reviews_review_helpful_text',
	static fn(): string => __( 'Helpful?', 'digimia' )
);

/**
 * Signed-out visitors get a sign-in link back to the reviews; the login form
 * EDD Reviews prints after it is hidden in CSS.
 *
 * @return string
 */
function review_sign_in_message(): string {
	$back = get_permalink() . '#edd-reviews';
	$url  = add_query_arg( 'redirect_to', rawurlencode( $back ), edd_page_url( 'login_page', '/login/' ) );

	$message = edd_get_option( 'edd_reviews_only_allow_reviews_by_buyer', false )
		/* translators: %s: sign-in URL. */
		? __( 'Bought this product? <a href="%s">Sign in</a> to write a review.', 'digimia' )
		/* translators: %s: sign-in URL. */
		: __( '<a href="%s">Sign in</a> to write a review.', 'digimia' );

	return sprintf( wp_kses( $message, array( 'a' => array( 'href' => array() ) ) ), esc_url( $url ) );
}
add_filter( 'edd_reviews_user_logged_out_message', __NAMESPACE__ . '\review_sign_in_message' );

/**
 * Keep EDD Reviews' stylesheet and the Dashicons font to pages that can show
 * reviews.
 *
 * EDD Reviews loads both on every page, for the stars in its review form.
 * Dashicons is a 35 KB stylesheet that holds up the first paint, and on a page
 * without reviews nothing uses it. Reviews show on product pages, the vendor
 * feedback page, and wherever the extension's shortcodes or block are used;
 * its own script follows the same rule.
 *
 * Runs twice. The first call, before EDD Reviews, notes whether something on
 * the page already asked for Dashicons while it rendered (EDD's account forms
 * do); those pages keep the font.
 *
 * @return void
 */
function limit_review_assets(): void {
	static $dashicons_in_use = null;

	if ( null === $dashicons_in_use ) {
		$dashicons_in_use = wp_style_is( 'dashicons' );
		return;
	}

	if ( ! function_exists( 'edd_reviews' ) || is_singular( 'download' ) ) {
		return;
	}

	$post = is_singular() ? get_post() : null;
	if ( $post && ( has_shortcode( $post->post_content, 'review' ) || has_shortcode( $post->post_content, 'average_rating' ) || has_block( 'edd-reviews/edd-review-block', $post ) ) ) {
		return;
	}

	$feedback_page = edd_get_option( 'edd_reviews_vendor_feedback_page', false );
	if ( $feedback_page && is_page( $feedback_page ) ) {
		return;
	}

	wp_dequeue_style( 'edd-reviews' );
	if ( ! $dashicons_in_use ) {
		wp_dequeue_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\limit_review_assets', 1 );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\limit_review_assets', 20 );

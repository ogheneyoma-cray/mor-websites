<?php
/**
 * Fallback template (search results, anything without a more specific
 * template). This store's real pages are front-page/page-contact/page
 * templates and WooCommerce archive/single templates.
 */

get_header();
?>
<main id="primary" class="site-main">
	<div class="container section">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<div class="entry-content"><?php the_content(); ?></div>
				</article>
				<?php
			endwhile;
			?>
		<?php else : ?>
			<h1><?php esc_html_e( 'Nothing found', 'mor-websites' ); ?></h1>
			<p><a class="btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to Home', 'mor-websites' ); ?></a></p>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();

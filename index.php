<?php
/**
 * Minimal placeholder template — replace with real layout per branch.
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		endwhile;
		?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'mor-websites' ); ?></p>
	<?php endif; ?>
</main>

<?php
get_sidebar();
get_footer();

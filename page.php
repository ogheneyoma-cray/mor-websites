<?php
/**
 * Generic page template — used for the legal pages (Privacy Policy,
 * Terms and Conditions, Refunds & Cancellation Policy, Service Delivery
 * Policy) created by the content importer, and any other plain page.
 */

get_header();
?>
<main id="primary" class="site-main">
	<div class="container section">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<div class="legal-content">
				<h1><?php the_title(); ?></h1>
				<p class="legal-updated">
					<?php
					printf(
						/* translators: %s: last updated date */
						esc_html__( 'Last updated: %s', 'mor-websites' ),
						esc_html( get_the_modified_date() )
					);
					?>
				</p>
				<?php the_content(); ?>
			</div>
			<?php
		endwhile;
		?>
	</div>
</main>
<?php
get_footer();

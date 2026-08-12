<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer id="colophon" class="site-footer">
	<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?> — tracking branch: <?php echo mor_site_branch_label(); ?></p>
</footer>
<?php wp_footer(); ?>
</body>
</html>

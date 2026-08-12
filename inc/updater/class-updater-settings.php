<?php
/**
 * Admin page under Appearance showing updater status, plus:
 *  - a form to set the tracked GitHub branch (stored in wp_options, not
 *    wp-config.php, so any admin with `update_themes` can point this
 *    site at a different client branch without a code deploy)
 *  - a "Check Now" action that busts both the version cache and WP's
 *    own update_themes transient
 */

namespace MOR\Updater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Updater_Settings {

	const ACTION_CHECK_NOW    = 'mor_updater_check_now';
	const ACTION_SAVE_BRANCH  = 'mor_updater_save_branch';

	protected $updater;

	public function __construct( ?Github_Updater $updater = null ) {
		$this->updater = $updater ?: new Github_Updater();

		add_action( 'admin_menu', array( $this, 'register_page' ) );
		add_action( 'admin_post_' . self::ACTION_CHECK_NOW, array( $this, 'handle_check_now' ) );
		add_action( 'admin_post_' . self::ACTION_SAVE_BRANCH, array( $this, 'handle_save_branch' ) );
	}

	public function register_page() {
		add_theme_page(
			__( 'Theme Updates', 'mor-websites' ),
			__( 'Theme Updates', 'mor-websites' ),
			'update_themes',
			'mor-updater-status',
			array( $this, 'render_page' )
		);
	}

	public function render_page() {
		if ( ! current_user_can( 'update_themes' ) ) {
			return;
		}

		$slug             = $this->updater->slug;
		$branch           = $this->updater->get_branch();
		$installed        = wp_get_theme( $slug )->get( 'Version' );
		$remote           = $this->updater->get_cached_remote_version();
		$last_checked     = $this->updater->get_last_checked();
		$update_available = $remote && version_compare( $remote, $installed, '>' );

		$check_url = wp_nonce_url(
			add_query_arg(
				array( 'action' => self::ACTION_CHECK_NOW ),
				admin_url( 'admin-post.php' )
			),
			self::ACTION_CHECK_NOW
		);
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Theme Updates', 'mor-websites' ); ?></h1>

			<?php if ( isset( $_GET['mor_updater_checked'] ) ) : ?>
				<div class="notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Checked GitHub for a newer version.', 'mor-websites' ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( isset( $_GET['mor_updater_branch_saved'] ) ) : ?>
				<div class="notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Tracked branch updated. Cleared cached version info so the next check reflects it.', 'mor-websites' ); ?></p>
				</div>
			<?php elseif ( isset( $_GET['mor_updater_branch_error'] ) ) : ?>
				<div class="notice notice-error is-dismissible">
					<p><?php esc_html_e( 'That branch name was rejected — use only letters, numbers, dots, dashes, underscores and slashes.', 'mor-websites' ); ?></p>
				</div>
			<?php endif; ?>

			<table class="widefat striped" style="max-width:640px;">
				<tbody>
					<tr>
						<th><?php esc_html_e( 'Theme slug (installed folder)', 'mor-websites' ); ?></th>
						<td><code><?php echo esc_html( $slug ); ?></code></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Tracked branch', 'mor-websites' ); ?></th>
						<td><code><?php echo esc_html( $branch ); ?></code></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Installed version', 'mor-websites' ); ?></th>
						<td><?php echo esc_html( $installed ); ?></td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Latest known remote version', 'mor-websites' ); ?></th>
						<td>
							<?php echo $remote ? esc_html( $remote ) : esc_html__( 'Unknown (not checked yet, or last check failed)', 'mor-websites' ); ?>
							<?php if ( $update_available ) : ?>
								<strong style="color:#d63638;"> — <?php esc_html_e( 'update available', 'mor-websites' ); ?></strong>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th><?php esc_html_e( 'Last checked', 'mor-websites' ); ?></th>
						<td>
							<?php
							echo $last_checked
								? esc_html( wp_date( 'Y-m-d H:i:s', $last_checked ) )
								: esc_html__( 'Never', 'mor-websites' );
							?>
						</td>
					</tr>
				</tbody>
			</table>

			<p>
				<a href="<?php echo esc_url( $check_url ); ?>" class="button button-primary">
					<?php esc_html_e( 'Check Now', 'mor-websites' ); ?>
				</a>
				<?php if ( $update_available ) : ?>
					<a href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>" class="button">
						<?php esc_html_e( 'Go update the theme', 'mor-websites' ); ?>
					</a>
				<?php endif; ?>
			</p>

			<h2><?php esc_html_e( 'Change tracked branch', 'mor-websites' ); ?></h2>
			<p class="description">
				<?php esc_html_e( 'Switching this points the update checker at a different git branch (e.g. a different client layout). It does not update the theme itself — use "Check Now" and then Appearance > Themes afterwards.', 'mor-websites' ); ?>
			</p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="<?php echo esc_attr( self::ACTION_SAVE_BRANCH ); ?>">
				<?php wp_nonce_field( self::ACTION_SAVE_BRANCH ); ?>
				<input
					type="text"
					name="mor_updater_branch"
					value="<?php echo esc_attr( $branch ); ?>"
					class="regular-text"
					pattern="[A-Za-z0-9._/-]+"
					required
				>
				<?php submit_button( __( 'Save Branch', 'mor-websites' ), 'secondary', 'submit', false ); ?>
			</form>
		</div>
		<?php
	}

	public function handle_check_now() {
		if ( ! current_user_can( 'update_themes' ) ) {
			wp_die( esc_html__( 'You do not have permission to do this.', 'mor-websites' ) );
		}

		check_admin_referer( self::ACTION_CHECK_NOW );

		$this->updater->clear_cache();

		wp_safe_redirect(
			add_query_arg(
				'mor_updater_checked',
				'1',
				admin_url( 'themes.php?page=mor-updater-status' )
			)
		);
		exit;
	}

	public function handle_save_branch() {
		if ( ! current_user_can( 'update_themes' ) ) {
			wp_die( esc_html__( 'You do not have permission to do this.', 'mor-websites' ) );
		}

		check_admin_referer( self::ACTION_SAVE_BRANCH );

		$branch = isset( $_POST['mor_updater_branch'] ) ? wp_unslash( $_POST['mor_updater_branch'] ) : '';
		$saved  = $this->updater->set_branch( $branch );

		wp_safe_redirect(
			add_query_arg(
				$saved ? 'mor_updater_branch_saved' : 'mor_updater_branch_error',
				'1',
				admin_url( 'themes.php?page=mor-updater-status' )
			)
		);
		exit;
	}
}

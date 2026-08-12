<?php
/**
 * Isolated GitHub HTTP calls used by the updater.
 *
 * Nothing in this class touches WP transients or update transients —
 * it only knows how to talk to GitHub and fail gracefully.
 */

namespace MOR\Updater;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Updater_Api {

	protected $owner;
	protected $repo;
	protected $token;

	public function __construct( $owner = null, $repo = null, $token = null ) {
		$this->owner = $owner ?: GITHUB_UPDATER_OWNER;
		$this->repo  = $repo ?: GITHUB_UPDATER_REPO;
		$this->token = null !== $token ? $token : GITHUB_UPDATER_TOKEN;
	}

	/**
	 * Fetch the raw style.css of a given branch and return it as a string.
	 * Uses raw.githubusercontent.com deliberately — it's not subject to
	 * the same rate limits as the REST API and needs no auth on public repos.
	 *
	 * @return string|false
	 */
	public function get_remote_style_css( $branch ) {
		$url = sprintf(
			'https://raw.githubusercontent.com/%s/%s/%s/style.css',
			rawurlencode( $this->owner ),
			rawurlencode( $this->repo ),
			rawurlencode( $branch )
		);

		$response = wp_remote_get( $url, array(
			'timeout' => 15,
			'headers' => $this->auth_headers(),
		) );

		return $this->body_or_false( $response, $url );
	}

	/**
	 * Parse the `Version:` header out of a style.css blob, WP-style.
	 *
	 * @return string|false
	 */
	public function parse_version( $style_css ) {
		if ( ! is_string( $style_css ) || '' === $style_css ) {
			return false;
		}

		if ( preg_match( '/^[ \t\/*#@]*Version:\s*(.+)$/mi', $style_css, $matches ) ) {
			return trim( $matches[1] );
		}

		return false;
	}

	/**
	 * Latest commit SHA for a branch, via the REST API (used only where
	 * we actually need it — not for the version check).
	 *
	 * @return string|false
	 */
	public function get_latest_commit_sha( $branch ) {
		$url = sprintf(
			'https://api.github.com/repos/%s/%s/commits/%s',
			rawurlencode( $this->owner ),
			rawurlencode( $this->repo ),
			rawurlencode( $branch )
		);

		$response = wp_remote_get( $url, array(
			'timeout' => 15,
			'headers' => array_merge(
				array( 'Accept' => 'application/vnd.github+json' ),
				$this->auth_headers()
			),
		) );

		$body = $this->body_or_false( $response, $url );
		if ( false === $body ) {
			return false;
		}

		$data = json_decode( $body, true );
		return $data['sha'] ?? false;
	}

	/**
	 * Branch archive download URL. GitHub extracts this as
	 * "{repo}-{branch}" — the caller (Github_Updater) is responsible for
	 * renaming the extracted folder back to the theme's real slug.
	 */
	public function get_branch_zip_url( $branch ) {
		return sprintf(
			'https://github.com/%s/%s/archive/refs/heads/%s.zip',
			rawurlencode( $this->owner ),
			rawurlencode( $this->repo ),
			rawurlencode( $branch )
		);
	}

	public function auth_headers() {
		if ( empty( $this->token ) ) {
			return array();
		}

		return array( 'Authorization' => 'token ' . $this->token );
	}

	/**
	 * Shared response handling: log on WP_DEBUG, always return false on
	 * any failure so callers never have to guard against exceptions.
	 *
	 * @return string|false
	 */
	protected function body_or_false( $response, $url ) {
		if ( is_wp_error( $response ) ) {
			$this->log( sprintf( 'GitHub request to %s failed: %s', $url, $response->get_error_message() ) );
			return false;
		}

		$code = wp_remote_retrieve_response_code( $response );
		if ( $code < 200 || $code >= 300 ) {
			$this->log( sprintf( 'GitHub request to %s returned HTTP %d', $url, $code ) );
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		if ( '' === $body ) {
			$this->log( sprintf( 'GitHub request to %s returned an empty body', $url ) );
			return false;
		}

		return $body;
	}

	protected function log( $message ) {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( '[mor-updater] ' . $message );
		}
	}
}

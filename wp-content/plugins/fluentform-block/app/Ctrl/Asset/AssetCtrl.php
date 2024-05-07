<?php

namespace FFBlock\Ctrl\Asset;

use FFBlock\Helper\Fns;

class AssetCtrl
{
	private $suffix;
	private $version;

	public function __construct()
	{
		$this->version = (defined('WP_DEBUG') && WP_DEBUG) ? time() : FFBLOCK_VERSION;
		add_action('enqueue_block_assets', [$this, 'block_frontend_backend_assets']);
		add_action('enqueue_block_editor_assets', [$this, 'block_editor_scripts']);
	}

	public function block_frontend_backend_assets()
	{
		//block frontend css
		wp_enqueue_style(
			'ffblock-frontend-css',
			ffblock()->get_asset_uri('blocks/style-index.css'),
			array(),
			$this->version
		);

		if (is_admin()) {

			//component css
			wp_enqueue_style(
				'ffblock-component-css',
				ffblock()->get_asset_uri('blocks/index.css'),
				array(),
				$this->version
			);
		}
	}

	public function block_editor_scripts()
	{
		$script_block_asset_path = FFBLOCK_PATH . 'assets/blocks/index.asset.php';

		$script_block_dependencies = require($script_block_asset_path);

		$blocks_dependencies_thirdparty = array('fluentform-gutenberg-block');

		$blocks_dependencies_marged = array_merge(
			$script_block_dependencies['dependencies'],
			$blocks_dependencies_thirdparty
		);

		/**
		 * Register all block depecdencies
		 */
		wp_enqueue_script(
			'ffblock-editor-script',
			ffblock()->get_asset_uri('blocks/index.js'),
			$blocks_dependencies_marged,
			$script_block_dependencies['version'],
			true
		);

		//localize file
		$localize_obj = [
			'plugin'     => FFBLOCK_URL,
			'ajaxurl'    => admin_url('admin-ajax.php'),
			'siteUrl'   => site_url(),
			'admin_url'  => admin_url(),
			'ffblock_nonce_key' => wp_create_nonce('ffblock-nonce-val'),
			'fluent_form_lists' => json_encode(Fns::get_fluent_forms_list()),
			'is_fluent_form_active' => defined('FLUENTFORM') ? true : false,
		];
		wp_localize_script(
			'ffblock-editor-script',
			'ffbBlockParams',
			apply_filters('ffblock_localize_script', $localize_obj)
		);
	}
}

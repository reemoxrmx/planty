<?php

use FFBlock\Traits\Singleton;
use FFBlock\Helper\Constant;
use FFBlock\Ctrl\MainCtrl;
use FFBlock\Ctrl\Installation;
use FFBlock\Ctrl\Dependencies;

if (!defined('ABSPATH')) exit;

require_once FFBLOCK_PATH . 'vendor/autoload.php';


/**
 * Class FFBlock
 */
final class FFBlock {

	use Singleton;

	public $nonceId = 'ffblock_wpnonce';

	/**
	 * FFB Project Constructor.
	 */
	public function __construct() {
		new Constant();
		add_action('init', [$this, 'language']);
		add_action('plugins_loaded', [$this, 'init'], 100);
		// Register Plugin Active Hook.
		register_activation_hook(FFBLOCK_FILE, [Installation::class, 'activate']);
		// Register Plugin Deactivate Hook.
		register_deactivation_hook(FFBLOCK_FILE, [Installation::class, 'deactivation']);
	}

	public function init() {
		if (!Dependencies::getInstance()->check()) {
			return;
		}
		do_action('ffblock_before_init');

		new MainCtrl();

		do_action('ffblock_init');
	}

	/**
	 * Load Text Domain
	 */
	public function language() {
		load_plugin_textdomain('fluentform-block', false, FFBLOCK_ABSPATH . '/languages/');
	}

	/**
	 * What type of request is this?
	 *
	 * @param string $type admin, ajax, cron or public.
	 *
	 * @return bool
	 */
	public function is_request($type) {
		switch ($type) {
			case 'admin':
				return is_admin();
			case 'public':
				return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
			case 'ajax':
				return defined('DOING_AJAX');
			case 'cron':
				return defined('DOING_CRON');
		}
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit(plugin_dir_path(FFBLOCK_FILE));
	}

	/**
	 * @return mixed
	 */
	public function version() {
		return FFBLOCK_VERSION;
	}



	/**
	 * @param $file
	 *
	 * @return string
	 */
	public function get_asset_uri($file) {
		$file = ltrim($file, '/');

		return trailingslashit(FFBLOCK_URL . '/assets') . $file;
	}

	/**
	 * @param $file
	 *
	 * @return string
	 */
	public function render($viewName, $args = array(), $return = false) {
		$path = str_replace(".", "/", $viewName);
		$viewPath = FFBLOCK_PATH . 'view/' . $path . '.php';

		if (!file_exists($viewPath)) {
			return;
		}

		if ($args) {
			extract($args);
		}

		if ($return) {
			ob_start();
			include $viewPath;

			return ob_get_clean();
		}
		include $viewPath;
	}
}

/**
 * @return bool|Singleton|FFBlock
 */
function ffblock() {
	return FFBlock::getInstance();
}
ffblock(); // Run Ffb Plugin
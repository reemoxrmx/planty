<?php

namespace FFBlock\Helper;

class Constant{
	public function __construct(){
		if (!defined('FFBLOCK_URL')) {
			define('FFBLOCK_URL', plugins_url('', FFBLOCK_FILE));
		}

		if (!defined('FFBLOCK_SLUG')) {
			define('FFBLOCK_SLUG', basename(dirname(FFBLOCK_FILE)));
		}

		if (!defined('FFBLOCK_TEMPLATE_DEBUG_MODE')) {
			define('FFBLOCK_TEMPLATE_DEBUG_MODE', false);
		}

		if (!defined('FFBLOCK_ABSPATH')) {
			define('FFBLOCK_ABSPATH', dirname(FFBLOCK_FILE));
		}
	}
}
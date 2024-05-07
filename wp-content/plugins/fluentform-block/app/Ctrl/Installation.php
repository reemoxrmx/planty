<?php

namespace FFBlock\Ctrl;

if (!defined('ABSPATH')) {
	exit('This script cannot be accessed directly.');
}

class Installation
{

	/**
	 * @return void
	 */
	public static function activate()
	{

		if (!get_option('ffblock_plugin_version')) {
			$get_activation_time = strtotime('now');
			update_option('ffblock_plugin_version', FFBLOCK_VERSION);
			update_option('ffblock_plugin_activation_time', $get_activation_time);
		}
	}

	/**
	 * @return void
	 */
	public static function deactivation()
	{
	}
}

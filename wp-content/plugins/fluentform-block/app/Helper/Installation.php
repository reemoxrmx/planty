<?php

namespace FFBlock\Helpers;

if (!defined('ABSPATH')) {
	exit('This script cannot be accessed directly.');
}

class Installation
{

	public static function init()
	{
		add_action('init', [__CLASS__, 'check_version'], 5);
	}

	public static function check_version()
	{
		if (version_compare(get_option('ffblock_version'), FFBLOCK_VERSION, '<')) {
			self::activate();
		}
	}

	public static function activate()
	{
		if (!is_blog_installed()) {
			return;
		}

		// Check if we are not already running this routine.
		if ('yes' === get_transient('ffblock_installing')) {
			return;
		}

		// If we made it till here nothing is running yet, lets set the transient now.
		set_transient('ffblock_installing', 'yes', MINUTE_IN_SECONDS * 10);

		self::update_ffblock_version();

		delete_transient('ffblock_installing');
	}

	private static function update_ffblock_version()
	{
		update_option('ffblock_version', FFBLOCK_VERSION);
	}

	public static function deactivation()
	{
	}

	public static function set_default_options()
	{
	}
}

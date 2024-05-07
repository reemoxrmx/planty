<?php

namespace FFBlock\Ctrl;

use FFBlock\Helper\Fns;
use FFBlock\Traits\Singleton;

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('This script cannot be accessed directly.');
}

/**
 * Dependencies
 */
class Dependencies
{
	/**
	 * Singleton
	 */
	use Singleton;

	const PLUGIN_NAME = 'Fluent Forms Block';

	const MINIMUM_PHP_VERSION = '7.4';

	private $missing = [];
	/**
	 * @var bool
	 */
	private $allOk = true;

	/**
	 * @return bool
	 */
	public function check()
	{

		add_action('wp_ajax_ffblock_plugin_activation', [__CLASS__, 'activate_plugin']);
		// TODO:: AJax plugin installation will do later.
		self::notice();

		//MINIMUM_PHP_VERSION < PHP_VERSION

		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', [$this, 'minimum_php_version']);
			$this->allOk = false;
		}

		if (!function_exists('is_plugin_active')) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if (!function_exists('wp_create_nonce')) {
			require_once ABSPATH . 'wp-includes/pluggable.php';
		}

		// Check Fluentform
		$fluentform = 'fluentform/fluentform.php';

		if (!is_plugin_active($fluentform)) {

			if ($this->is_plugins_installed($fluentform)) {
				$activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $fluentform . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $fluentform);
				$message        = sprintf(
					'<strong>%s</strong> %s <strong>%s</strong> %s',
					esc_html__('Fluent Forms Block', 'fluentform-block'),
					esc_html__('requires', 'fluentform-block'),
					esc_html__('Fluentform', 'fluentform-block'),
					esc_html__('plugin to be active. Please activate Fluentform to continue.', 'fluentform-block')
				);
				$button_text    = esc_html__('Activate Fluentform', 'fluentform-block');
			} else {
				$activation_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=fluentform'), 'install-plugin_fluentform');
				$message        = sprintf(
					'<strong>%s</strong> %s <strong>%s</strong> %s',
					esc_html__('Fluent Forms Block', 'fluentform-block'),
					esc_html__('requires', 'fluentform-block'),
					esc_html__('Fluentform', 'fluentform-block'),
					esc_html__('plugin to be installed and activated. Please install Fluentform to continue.', 'fluentform-block')
				);
				$button_text    = esc_html__('Install Fluentform', 'fluentform-block');
			}
			$this->missing['fluentform'] = [
				'name'       => 'Contact Form Plugin – Fastest Contact Form Builder Plugin for WordPress by Fluent Forms',
				'slug'       => 'fluentform',
				'file_name'  => $fluentform,
				'url'        => $activation_url,
				'message'    => $message,
				'button_txt' => $button_text,
			];
			if ($this->is_plugins_installed($fluentform)) {
				unset($this->missing['fluentform']['slug']);
			}
		}

		if (!empty($this->missing)) {
			add_action('admin_notices', [$this, '_missing_plugins_warning']);

			$this->allOk = false;
		}

		return $this->allOk;
	}

	/**
	 * Admin Notice For Required PHP Version
	 */
	public function minimum_php_version()
	{
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'fluentform-block'),
			'<strong>' . esc_html__('Fluent Forms Block', 'fluentform-block') . '</strong>',
			'<strong>' . esc_html__('PHP', 'fluentform-block') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', esc_html($message));
	}


	/**
	 * Adds admin notice.
	 */
	public function _missing_plugins_warning()
	{
		$missingPlugins = '';
		$counter        = 0;
		foreach ($this->missing as $plugin) {
			$counter++;
			if ($counter == sizeof($this->missing)) {
				$sep = '';
			} elseif ($counter == sizeof($this->missing) - 1) {
				$sep = ' ' . esc_html__('and', 'fluentform-block') . ' ';
			} else {
				$sep = ', ';
			}
			if (current_user_can('activate_plugins')) {
				$button = '<p><a data-plugin="' . esc_attr(json_encode($plugin)) . '" href="' . esc_url($plugin['url']) . '" class="button-primary plugin-install-by-ajax">' . esc_html($plugin['button_txt']) . '</a></p>';

				printf('<div class="ffblock-admin-notice-wrapper error notice_error"><p>%1$s</p>%2$s</div>', $plugin['message'], $button);
			} else {
				$missingPlugins .= '<strong>' . esc_html($plugin['name']) . '</strong>' . $sep;
			}
		}
	}

	/**
	 * @param $plugin_file_path
	 *
	 * @return bool
	 */
	public function is_plugins_installed($plugin_file_path = null)
	{
		$installed_plugins_list = get_plugins();

		return isset($installed_plugins_list[$plugin_file_path]);
	}

	/**
	 * Undocumented function.
	 *
	 * @return void
	 */
	public static function notice()
	{
		add_action('admin_enqueue_scripts', function () {
			wp_enqueue_script('jquery');
			wp_enqueue_script('updates');
		});

		add_action('admin_print_styles', function () {
?>
			<style>
				.wp-core-ui .ffblock-admin-notice-wrapper .plugin-install-by-ajax {
					display: inline-flex;
					align-items: center;
					gap: 20px;
				}

				.ffblock-admin-notice-wrapper .ffblock-admin-notice-loader {
					border: 4px solid #f3f3f3;
					border-radius: 50%;
					border-top: 4px solid #3498db;
					width: 10px;
					height: 10px;
					-webkit-animation: spin 2s linear infinite;
					animation: spin 2s linear infinite;
					margin-left: 5px;
				}

				/* Safari */
				@-webkit-keyframes spin {
					0% {
						-webkit-transform: rotate(0deg);
					}

					100% {
						-webkit-transform: rotate(360deg);
					}
				}

				@keyframes spin {
					0% {
						transform: rotate(0deg);
					}

					100% {
						transform: rotate(360deg);
					}
				}
			</style>
		<?php
		});

		// Footer Script
		add_action('admin_print_footer_scripts', function () { ?>

			<script type="text/javascript">
				(function($) {
					function ajaxActive(that, plugin) {

						if (that.attr("disabled")) {
							return;
						}
						$.ajax({
							url: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
							data: {
								action: 'ffblock_plugin_activation',
								plugin_slug: plugin.slug ? plugin.slug : null,
								activation_file: plugin.file_name,
								ffblock_wpnonce: '<?php echo esc_js(wp_create_nonce(ffblock()->nonceId)); ?>',
							},
							type: 'POST',
							beforeSend() {
								that.html('Activation Prosses Running... <div class="ffblock-admin-notice-loader"></div>');
							},
							success(response) {
								that.html('Activation Prosses Done');
								that.removeClass('plugin-install-by-ajax');
								that.attr('disabled', 'disabled');
							},
							error(e) {},
						});
					}

					setTimeout(function() {
						$('.plugin-install-by-ajax')
							.on('click', function(e) {
								e.preventDefault();
								var that = $(this);
								if (that.attr("disabled")) {
									return;
								}
								var plugin = $(this).data('plugin');
								console.log(plugin.file_name)
								if (plugin.slug) {
									wp.updates.installPlugin({
										slug: plugin.slug,
										success: function(pluginData) {
											console.log(pluginData, 'Plugin installed successfully!');
											if (pluginData.activateUrl) {
												that.html('Activation Prosses Running... <div class="ffblock-admin-notice-loader"></div>');
												ajaxActive(that, plugin);
											}
										},
										error: function(error) {
											console.log('An error occurred: ' + error.statusText);
										},
										installing: function() {
											that.html('Installing plugin... <div class="ffblock-admin-notice-loader"></div>');
											console.log('Installing plugin...!');
										}
									});
								} else {
									ajaxActive(that, plugin)
								}

							});
					}, 1000);


				})(jQuery);
			</script>
<?php
		});
	}

	public static function activate_plugin()
	{
		$return = [
			'success' => false,
		];
		if (!Fns::verify_nonce()) {
			wp_send_json_error($return);
		}
		if (!empty($_REQUEST['activation_file']) && is_plugin_inactive($_REQUEST['activation_file'])) {
			activate_plugin(sanitize_text_field($_REQUEST['activation_file']));
			$return['success'] = true;
		}
		if ($return['success']) {
			return wp_send_json_success($return);
		} else {
			wp_send_json_error($return);
		}
		wp_die();
	}
}

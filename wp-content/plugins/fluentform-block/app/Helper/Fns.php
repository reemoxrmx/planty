<?php

namespace FFBlock\Helper;

class Fns
{

	public static function views($name, $data = array())
	{
		$__file = static::get_views_path($name);
		$helper = static::class;
		extract($data);
		if (is_readable($__file)) {
			include $__file;
		}
	}

	protected static function get_views_path($name)
	{
		$file =  FFBLOCK_PATH . 'views/' . $name . '.php';
		if (file_exists($file)) {
			return $file;
		}
		return false;
	}

	public static function block_print_header_style($name, $content)
	{ ?>
		<style id="<?php echo esc_attr($name); ?>">
			<?php echo wp_specialchars_decode(wp_kses_post(trim($content))); ?>
		</style>
<?php }

	/**
	 * Template Part Content.
	 *
	 * @param array  $attributes Attributes.
	 * @param string $template_part_id Template Part ID.
	 * @param string $area Area.
	 *
	 * @return string
	 */
	public static function template_part_content($attributes, &$template_part_id, &$area)
	{
		$content = '';

		if (
			isset($attributes['slug']) &&
			isset($attributes['theme']) &&
			wp_get_theme()->get_stylesheet() === $attributes['theme']
		) {
			$template_part_id    = $attributes['theme'] . '//' . $attributes['slug'];
			$template_part_query = new \WP_Query(
				array(
					'post_type'      => 'wp_template_part',
					'post_status'    => 'publish',
					'post_name__in'  => array($attributes['slug']),
					'tax_query'      => array( //phpcs:ignore
						array(
							'taxonomy' => 'wp_theme',
							'field'    => 'slug',
							'terms'    => $attributes['theme'],
						),
					),
					'posts_per_page' => 1,
					'no_found_rows'  => true,
				)
			);

			$template_part_post = $template_part_query->have_posts() ? $template_part_query->next_post() : null;

			if ($template_part_post) {
				// A published post might already exist if this template part was customized elsewhere
				// or if it's part of a customized template.
				$content    = $template_part_post->post_content;
				$area_terms = get_the_terms($template_part_post, 'wp_template_part_area');
				if (!is_wp_error($area_terms) && false !== $area_terms) {
					$area = $area_terms[0]->name;
				}
				/**
				 * Fires when a block template part is loaded from a template post stored in the database.
				 *
				 * @since 5.9.0
				 *
				 * @param string  $template_part_id   The requested template part namespaced to the theme.
				 * @param array   $attributes         The block attributes.
				 * @param WP_Post $template_part_post The template part post object.
				 * @param string  $content            The template part content.
				 */
				do_action('render_block_core_template_part_post', $template_part_id, $attributes, $template_part_post, $content);
			}
		}

		return $content;
	}


	public static function get_fluent_forms_list()
	{
		$options = array();

		if (defined('FLUENTFORM')) {
			global $wpdb;
			$options[0]['label'] = __('Select a Form', 'fluentform-block');
			$options[0]['value'] = '';
			$result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}fluentform_forms WHERE status = 'published'");

			if (!empty($result)) {
				foreach ($result as $key => $form) {
					$options[$key + 1]['label'] = $form->title;
					$options[$key + 1]['value'] = $form->id;
					$options[$key + 1]['template_name'] = self::get_form_attr($form->id);
				}
			}
		}

		return $options;
	}

	/**
	 * Get Form Attribute
	 */
	public static function get_form_attr($form_id)
	{
		return  \FluentForm\App\Helpers\Helper::getFormMeta($form_id, 'template_name');
	}

	public static function get_block_wrapper_class($settings = [], $class_name = '')
	{
		$wrap_class = '';

		if (isset($settings['blockId'])) {
			$wrap_class .= $settings['blockId'];
		}
		$wrap_class .= ' ffblock-block-frontend';

		if (isset($settings['mainWrapShowHide'])) {
			$wrap_class .= $settings['mainWrapShowHide']['lg'] ? ' ffblock-hide-desktop' : '';
			$wrap_class .= $settings['mainWrapShowHide']['md'] ? ' ffblock-hide-tablet' : '';
			$wrap_class .= $settings['mainWrapShowHide']['sm'] ? ' ffblock-hide-mobile' : '';
		}
		if (!empty($class_name)) {
			$wrap_class .= ' ' . $class_name;
		}

		return $wrap_class;
	}

	public static function is_form_exist($form_id)
	{
		global $wpdb;
		$result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT id FROM {$wpdb->prefix}fluentform_forms WHERE id = %d AND status = 'published'",
				$form_id
			)
		);
		return !empty($result) ? $result[0]->id : '';
	}

	/**
	 *  Verify nonce.
	 *
	 * @return bool
	 */
	public static function verify_nonce()
	{
		$nonce = isset($_REQUEST[ffblock()->nonceId]) ? sanitize_text_field($_REQUEST[ffblock()->nonceId]) : null;
		if (wp_verify_nonce($nonce, ffblock()->nonceId)) {
			return true;
		}

		return false;
	}
}

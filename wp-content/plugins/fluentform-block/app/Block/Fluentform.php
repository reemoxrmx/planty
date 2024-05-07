<?php

namespace FFBlock\Block;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

use FFBlock\Block\BlockBase;
use FFBlock\Helper\Fns;

class Fluentform extends BlockBase {
	public function block_attributes() {
		$attributes = [
			'layout'   => array(
				'type'    => 'string',
				'default' => '1',
			),

			'formId' => array(
				'type' => 'string',
				'default' => '1'
			),

			'isHtml' => array(
				'type' => 'boolean',
				'default' => false
			),
			'formJson' => array(
				'type'    => 'object',
				'default' => null,
			),

			'formName' => array(
				'type' => 'string',
				'default' => 'basic_contact_form'
			),

			'labelEnable'   => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'placeholderEnable'   => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'errorMessageEnable'   => array(
				'type'    => 'boolean',
				'default' => true,
			),

			//form box
			'formAlignment'   => array(
				'type'    => 'object',
				'default' => [],
			),

			'formMaxWidth' => [
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			],

			//label style
			'labelTypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],

			'labelColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			"labelSpace" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				)
			),
			//input & textarea style
			'inputTATypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],

			'inputTAColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'inputTABGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			'inputWidth' => [
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			],

			'inputHeight' => [
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			],

			'textareaWidth' => [
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			],

			'textareaHeight' => [
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			],

			"inputTAPadding" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),
			),
			"inputTAMargin" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),
			),
			"inputTABorder" => array(
				"type"    => "object",
				"default" => array(
					'borderStyle' => '',
					'borderColor' => '',
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				)
			),

			"inputTAHoverBorder" => array(
				"type"    => "object",
				"default" => array(
					'borderStyle' => '',
					'borderColor' => '',
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				)
			),

			"inputTARadius" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),
			),

			"inputTAHoverRadius" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),
			),

			//checkbox & radio
			'checkboxRSize' => [
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			],

			"checkboxRItemLabelSpace" => array(
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			),

			"checkboxRItemSpace" => array(
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			),

			'optionLabelColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'checkboxRBgColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			'checkboxRCheckedColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			"checkboxRBorderWidth" => array(
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			),

			'checkboxRBorderColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			"checkboxRounded" => array(
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			),

			//placeholder
			'placeholderTypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],
			'placeholderColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			//section break
			'sectionBGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			"sectionMargin" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),
			),

			"sectionPadding" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),
			),
			'sectionHTypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],
			'sectionHTextColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			'sectionHBGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			//section description
			'sectionDTypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],
			'sectionDTextColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'sectionDBGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'sectionHLineColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			//custom html
			'customHtmlTypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],
			'customHtmlColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'customHtmlBGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			//submit button
			'buttonWidth' => [
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			],

			'buttonHeight' => [
				'type' => 'object',
				'default' => (object)[
					'lg' => '',
					'unit' => 'px'
				],
			],
			'buttonTypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],

			'buttonTextColor'   => array(
				'type'    => 'string',
				'default' => '',

			),

			'buttonHoverTextColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			'buttonBGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			'buttonHoverBGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			"buttonPadding" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),
			),

			"buttonMargin" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),
			),
			"buttonBorder" => array(
				"type"    => "object",
				"default" => array(
					'borderStyle' => '',
					'borderColor' => '',
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				)
			),
			"buttonHoverBorder" => array(
				"type"    => "object",
				"default" => array(
					'borderStyle' => '',
					'borderColor' => '',
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				)
			),

			"buttonRadius" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),

			),

			"buttonHoverRadius" => array(
				"type"    => "object",
				"default" => array(
					'lg' => [
						"isLinked" => true,
						"unit"     => "px",
						"value"    => ''
					]
				),

			),
			'buttonShadow' => [
				'type' => 'object',
				'default' => (object)['openShadow' => 1, 'width' => (object)['top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1], 'color' => '', 'inset' => false],
			],

			'buttonHoverShadow' => [
				'type' => 'object',
				'default' => (object)['openShadow' => 1, 'width' => (object)['top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1], 'color' => '', 'inset' => false],
			],

			'successTypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],

			'successColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'successBGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			'successBorderColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

			//error
			'errorTypo' => [
				'type' => 'object',
				'default' => (object)[
					'openTypography' => 1,
					'size' => (object)['lg' => '', 'unit' => 'px'],
					'spacing' => (object)['lg' => '', 'unit' => 'px'],
					'height' => (object)['lg' => '', 'unit' => 'px'],
					'transform' => '',
					'weight' => ''
				],
			],

			'errorColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'errorBGColor'   => array(
				'type'    => 'string',
				'default' => '',
			),
			'errorBorderColor'   => array(
				'type'    => 'string',
				'default' => '',
			),

		] + parent::common_attributes();
		return apply_filters('ffblock_fluentform_block_attributes', $attributes);
	}

	public function register_block()
	{
		if (defined('FLUENTFORM_VERSION')) {
			wp_register_style(
				'fluent-form-styles-ffb',
				plugins_url() . '/fluentform/assets/css/fluent-forms-public.css',
				array(),
				FFBLOCK_VERSION,
				'all'
			);

			//For use editor-script
			wp_register_style(
				'fluentform-public-default-ffb',
				plugins_url() . '/fluentform/assets/css/fluentform-public-default.css',
				array('fluent-form-styles-ffb', 'ffblock-frontend-css'),
				FFBLOCK_VERSION,
				'all'
			);
		}

		register_block_type(
			FFBLOCK_PATH . 'app/Block/fluentform',
			[
				'editor_style'      => 'fluentform-public-default-ffb',
				'render_callback'   => [$this, 'render_block'],
				'attributes'        => $this->block_attributes(),
			]
		);
	}

	public function render_block($attributes)
	{
		$template_style = 'fluentform';
		$data = [
			'settings' => $attributes,
		];

		$data = apply_filters('ffblock_fluentform_data', $data);
		ob_start();
		Fns::views($template_style, $data);
		return ob_get_clean();
	}
}
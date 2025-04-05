<?php
namespace Borderless\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;

class Info_Box extends Widget_Base {

	/**
	 * Return the widget name.
	 */
	public function get_name() {
		return 'borderless-elementor-info-box';
	}

	public function get_custom_help_url() {
		return 'https://borderless.visualmodo.com/widget/info-box/';
	}

	/**
	 * Return the widget title.
	 */
	public function get_title() {
		return __( 'Info Box', 'borderless' );
	}

	/**
	 * Return the widget icon.
	 */
	public function get_icon() {
		return 'eicon-info-box';
	}
	
	/**
	 * Return the widget categories.
	 */
	public function get_categories() {
		return [ 'borderless' ];
	}

	/**
	 * Enqueue widget style dependency.
	 */
	public function get_style_depends() {
		return [ 'elementor-widget-info-box' ];
	}

	/**
	 * Register all widget controls.
	 */
	protected function _register_controls() {

		// ---------------------------------
		// Content Tab: Media
		// ---------------------------------
		$this->start_controls_section(
			'borderless_elementor_info_box_section_media',
			[
				'label' => __( 'Media', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_info_box_type',
				[
					'label'   => __( 'Media Type', 'borderless' ),
					'type'    => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => [
						'icon'  => [
							'title' => __( 'Icon', 'borderless' ),
							'icon'  => 'eicon-star',
						],
						'image' => [
							'title' => __( 'Image', 'borderless' ),
							'icon'  => 'eicon-image',
						],
					],
					'default' => 'icon',
					'toggle'  => false,
				]
			);
			// Image control (for Media Type = image)
			$this->add_control(
				'borderless_elementor_info_box_image',
				[
					'label'   => __( 'Image', 'borderless' ),
					'type'    => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'image',
					],
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'    => 'borderless_elementor_info_box_thumbnail',
					'default' => 'medium_large',
					'separator' => 'none',
					'exclude' => [
						'full', 'custom', 'large', 'shop_catalog', 'shop_single', 'shop_thumbnail',
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'image',
					],
				]
			);
			// Icon control (for Media Type = icon)
			$this->add_control(
				'borderless_elementor_info_box_selected_icon',
				[
					'type'            => Controls_Manager::ICONS,
					'fa4compatibility'=> 'icon',
					'label_block'     => true,
					'default'         => [
						'value'   => 'fas fa-asterisk',
						'library' => 'fa-solid',
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'icon',
					],
				]
			);
		$this->end_controls_section();

		// ---------------------------------
		// Content Tab: Title & Description
		// ---------------------------------
		$this->start_controls_section(
			'borderless_elementor_info_box_section_title',
			[
				'label' => __( 'Title & Description', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_info_box_title',
				[
					'label'       => __( 'Title', 'borderless' ),
					'label_block' => true,
					'type'        => Controls_Manager::TEXT,
					'default'     => __( 'Info Box Title', 'borderless' ),
					'placeholder' => __( 'Type Info Box Title', 'borderless' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_description',
				[
					'label'       => __( 'Description', 'borderless' ),
					'description' => 'Allowed HTML: a, b, strong, em, i, u, p, br, span',
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'borderless' ),
					'placeholder' => __( 'Type Info Box Description', 'borderless' ),
					'rows'        => 5,
					'dynamic'     => [
						'active' => true,
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_title_tag',
				[
					'label'   => __( 'Title HTML Tag', 'borderless' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'h1' => [
							'title' => __( 'H1', 'borderless' ),
							'icon'  => 'eicon-editor-h1',
						],
						'h2' => [
							'title' => __( 'H2', 'borderless' ),
							'icon'  => 'eicon-editor-h2',
						],
						'h3' => [
							'title' => __( 'H3', 'borderless' ),
							'icon'  => 'eicon-editor-h3',
						],
						'h4' => [
							'title' => __( 'H4', 'borderless' ),
							'icon'  => 'eicon-editor-h4',
						],
						'h5' => [
							'title' => __( 'H5', 'borderless' ),
							'icon'  => 'eicon-editor-h5',
						],
						'h6' => [
							'title' => __( 'H6', 'borderless' ),
							'icon'  => 'eicon-editor-h6',
						],
					],
					'default' => 'h2',
					'toggle'  => false,
				]
			);
		$this->end_controls_section();

		// ---------------------------------
		// Content Tab: Button
		// ---------------------------------
		$this->start_controls_section(
			'borderless_elementor_info_box_section_button',
			[
				'label' => esc_html__( 'Button', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_info_box_button_text',
				[
					'label'   => esc_html__( 'Button Text', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'See More', 'borderless' ),
					'dynamic' => [ 'active' => true ],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_button_link',
				[
					'label'   => esc_html__( 'Button Link', 'borderless' ),
					'type'    => Controls_Manager::URL,
					'default' => [
						'url' => '#',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_button_icon',
				[
					'label'   => esc_html__( 'Button Icon', 'borderless' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value'   => 'fas fa-arrow-right',
						'library' => 'fa-solid',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_button_icon_position',
				[
					'label'   => __( 'Icon Position', 'borderless' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'before' => [
							'title' => __( 'Before', 'borderless' ),
							'icon'  => 'eicon-h-align-left',
						],
						'after'  => [
							'title' => __( 'After', 'borderless' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default' => 'after',
					'toggle'  => false,
				]
			);
		$this->end_controls_section();

		// ---------------------------------
		// Style Tab: General
		// ---------------------------------
		$this->start_controls_section(
			'borderless_elementor_info_box_style_general',
			[
				'label' => __( 'General', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'borderless_elementor_info_box_direction',
				[
					'label' => __( 'Direction', 'borderless' ),
					'type'  => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'borderless' ),
							'icon'  => 'eicon-h-align-left',
						],
						'top' => [
							'title' => __( 'Top', 'borderless' ),
							'icon'  => 'eicon-v-align-top',
						],
						'right' => [
							'title' => __( 'Right', 'borderless' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default' => 'top',
					'toggle'  => false,
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_horizontal_align',
				[
					'label' => __( 'Horizontal Alignment', 'borderless' ),
					'type'  => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'borderless' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'borderless' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'borderless' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default' => 'center',
					'toggle'  => false,
					'condition' => [
						'borderless_elementor_info_box_direction' => 'top',
					],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-wrapper.media-top, {{WRAPPER}} .borderless-info-box-footer' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_vertical_align',
				[
					'label' => __( 'Vertical Alignment', 'borderless' ),
					'type'  => Controls_Manager::CHOOSE,
					'options' => [
						'top' => [
							'title' => __( 'Top', 'borderless' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center' => [
							'title' => __( 'Center', 'borderless' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'bottom' => [
							'title' => __( 'Bottom', 'borderless' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'default' => 'top',
					'toggle'  => false,
					'condition' => [
						'borderless_elementor_info_box_direction' => [ 'left', 'right' ],
						'borderless_elementor_info_box_type'      => 'icon',
					],
					'selectors_dictionary' => [
						'top'    => 'align-self: flex-start;',
						'center' => 'align-self: center;',
						'bottom' => 'align-self: flex-end;',
					],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-media' => '{{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'borderless_elementor_info_box_background',
					'label'    => esc_html__( 'Background', 'borderless' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .borderless-info-box-wrapper',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'borderless_elementor_info_box_border',
					'selector' => '{{WRAPPER}} .borderless-info-box-wrapper',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_border_radius',
				[
					'label' => __( 'Border Radius', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'borderless_elementor_info_box_box_shadow',
					'exclude'  => [ 'box_shadow_position' ],
					'selector' => '{{WRAPPER}} .borderless-info-box-wrapper',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_padding',
				[
					'label' => __( 'Padding', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem', 'vw' ],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		// ---------------------------------
		// Style Tab: Media Style
		// ---------------------------------
		$this->start_controls_section(
			'borderless_elementor_info_box_style_media',
			[
				'label' => __( 'Media', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'borderless_elementor_info_box_icon_size',
				[
					'label' => __( 'Icon Size', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 8,
							'max' => 320,
						],
					],
					'default'    => [
						'size' => 64,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure--icon' => 'font-size: {{SIZE}}{{UNIT}} !important;',
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'icon',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_image_width',
				[
					'label' => __( 'Image Width', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 400,
						],
						'%' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure--image' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'image',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_image_height',
				[
					'label' => __( 'Image Height', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 400,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure--image' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'image',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_media_offset_x',
				[
					'label' => __( 'Offset Left', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-wrapper' => '--borderless-info-box-media-offset-x: {{SIZE}}{{UNIT}} !important;',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_media_offset_y',
				[
					'label' => __( 'Offset Top', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-wrapper' => '--borderless-info-box-media-offset-y: {{SIZE}}{{UNIT}} !important;',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_media_spacing',
				[
					'label' => __( 'Spacing', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_media_padding',
				[
					'label' => __( 'Padding', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem', 'vw' ],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure img, {{WRAPPER}} .borderless-info-box-figure--icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_icon_margin',
				[
					'label' => __( 'Margin', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem', 'vw' ],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'borderless_elementor_info_box_media_border',
					'selector' => '{{WRAPPER}} .borderless-info-box-figure img, {{WRAPPER}} .borderless-info-box-figure--icon',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_media_border_radius',
				[
					'label' => __( 'Border Radius', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .borderless-info-box-figure--icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'borderless_elementor_info_box_media_box_shadow',
					'exclude'  => [ 'box_shadow_position' ],
					'selector' => '{{WRAPPER}} .borderless-info-box-figure img, {{WRAPPER}} .borderless-info-box-figure--icon',
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_icon_color',
				[
					'label' => __( 'Icon Color', 'borderless' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure--icon' => 'color: {{VALUE}}',
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'icon',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_icon_bg_color',
				[
					'label' => __( 'Background Color', 'borderless' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-figure--icon' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'icon',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_icon_bg_rotate',
				[
					'label' => __( 'Background Rotate', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'default' => [
						'unit' => 'deg',
					],
					'range' => [
						'deg' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'selectors' => [
						'{{WRAPPER}}  .borderless-info-box-wrapper' => '--borderless-info-box-media-rotate: {{SIZE}}{{UNIT}} !important;',
					],
					'condition' => [
						'borderless_elementor_info_box_type' => 'icon',
					],
				]
			);
		$this->end_controls_section();

		// ---------------------------------
		// Style Tab: Title & Description
		// ---------------------------------
		$this->start_controls_section(
			'borderless_elementor_info_box_style_title',
			[
				'label' => __( 'Title & Description', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'borderless_elementor_info_box_content_padding',
				[
					'label' => __( 'Content Box Padding', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem', 'vw' ],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_title_heading',
				[
					'type' => Controls_Manager::HEADING,
					'label' => __( 'Title', 'borderless' ),
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_title_spacing',
				[
					'label' => __( 'Bottom Spacing', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_title_color',
				[
					'label' => __( 'Title Color', 'borderless' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'borderless_elementor_info_box_title_typography',
					'label' => __( 'Title Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .borderless-info-box-title',
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_description_heading',
				[
					'type' => Controls_Manager::HEADING,
					'label' => __( 'Description', 'borderless' ),
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_description_spacing',
				[
					'label' => __( 'Bottom Spacing', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_description_color',
				[
					'label' => __( 'Description Color', 'borderless' ),
					'type'  => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .borderless-info-box-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'borderless_elementor_info_box_description_typography',
					'label' => __( 'Description Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .borderless-info-box-text',
				]
			);
		$this->end_controls_section();

		// ---------------------------------
		// Style Tab: Button
		// ---------------------------------
		$this->start_controls_section(
			'borderless_elementor_info_box_button_style',
			[
				'label' => esc_html__( 'Button', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_info_box_button_typography',
					'label'    => esc_html__( 'Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .borderless-info-box-button',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'borderless_elementor_info_box_button_text_shadow',
					'label'    => __( 'Text Shadow', 'borderless' ),
					'selector' => '{{WRAPPER}} .borderless-info-box-button',
				]
			);
			$this->start_controls_tabs( 'borderless_elementor_info_box_button_color_tabs' );
				// Tab Normal
				$this->start_controls_tab(
					'borderless_elementor_info_box_button_normal',
					[
						'label' => esc_html__( 'Normal', 'borderless' ),
					]
				);
					$this->add_control(
						'borderless_elementor_info_box_button_text_color',
						[
							'label'     => esc_html__( 'Text Color', 'borderless' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} .borderless-info-box-button' => 'color: {{VALUE}} !important;',
								'{{WRAPPER}} .button-icon'              => 'fill: {{VALUE}} !important;',
							],
						]
					);
					$this->add_control(
						'borderless_elementor_info_box_button_background_color',
						[
							'label'     => esc_html__( 'Background Color', 'borderless' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#000000',
							'selectors' => [
								'{{WRAPPER}} .borderless-info-box-button' => 'background-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				// Tab Hover
				$this->start_controls_tab(
					'borderless_elementor_info_box_button_hover',
					[
						'label' => esc_html__( 'Hover', 'borderless' ),
					]
				);
					$this->add_control(
						'borderless_elementor_info_box_button_text_color_hover',
						[
							'label'     => esc_html__( 'Text Color', 'borderless' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#ffffff',
							'selectors' => [
								'{{WRAPPER}} .borderless-info-box-button:hover'          => 'color: {{VALUE}} !important;',
								'{{WRAPPER}} .borderless-info-box-button:hover .button-icon' => 'fill: {{VALUE}} !important;',
							],
						]
					);
					$this->add_control(
						'borderless_elementor_info_box_button_background_color_hover',
						[
							'label'     => esc_html__( 'Background Color', 'borderless' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#000000',
							'selectors' => [
								'{{WRAPPER}} .borderless-info-box-button:hover' => 'background-color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'borderless_elementor_info_box_button_border_color_hover',
						[
							'label'     => esc_html__( 'Border Color', 'borderless' ),
							'type'      => Controls_Manager::COLOR,
							'default'   => '#cccccc',
							'selectors' => [
								'{{WRAPPER}} .borderless-info-box-button:hover' => 'border-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'borderless_elementor_info_box_button_border',
					'label'    => esc_html__( 'Border', 'borderless' ),
					'selector' => '{{WRAPPER}} .borderless-info-box-button',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_button_border_radius',
				[
					'label' => __( 'Border Radius', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem' ],
					'selectors'  => [
						'{{WRAPPER}} .borderless-info-box-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_button_padding',
				[
					'label'      => esc_html__( 'Padding', 'borderless' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem', 'vw' ],
					'default'    => [
						'top'      => 10,
						'right'    => 24,
						'bottom'   => 10,
						'left'     => 24,
						'isLinked' => false,
					],
					'selectors'  => [
						'{{WRAPPER}} .borderless-info-box-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_button_margin',
				[
					'label'      => esc_html__( 'Margin', 'borderless' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em', 'rem', 'vw' ],
					'selectors'  => [
						'{{WRAPPER}} .borderless-info-box-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_info_box_button_icon_size',
				[
					'label' => esc_html__( 'Icon Size', 'borderless' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 16,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .button-icon' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_info_box_button_full_width',
				[
					'label'        => esc_html__( 'Stretch Button', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'borderless' ),
					'label_off'    => esc_html__( 'No', 'borderless' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
		$this->end_controls_section();
		
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$type     = $settings['borderless_elementor_info_box_type'];

		// Prepare Media HTML
		$media_html = '';
		if ( 'image' === $type && ! empty( $settings['borderless_elementor_info_box_image']['url'] ) ) {
			$media_html = '<figure class="borderless-info-box-figure borderless-info-box-figure--image">';
			$media_html .= Group_Control_Image_Size::get_attachment_image_html( $settings, 'borderless_elementor_info_box_thumbnail', 'borderless_elementor_info_box_image' );
			$media_html .= '</figure>';
		} elseif ( 'icon' === $type ) {
			$media_html = '<figure class="borderless-info-box-figure borderless-info-box-figure--icon">';
			ob_start();
			Icons_Manager::render_icon( $settings['borderless_elementor_info_box_selected_icon'], [ 'aria-hidden' => 'true' ] );
			$media_html .= ob_get_clean();
			$media_html .= '</figure>';
		}

		// Prepare Body HTML (Title & Description)
		$body_html = '<div class="borderless-info-box-body">';
		if ( ! empty( $settings['borderless_elementor_info_box_title'] ) ) {
			$body_html .= sprintf( '<%1$s class="borderless-info-box-title">%2$s</%1$s>',
				esc_html( $settings['borderless_elementor_info_box_title_tag'] ),
				esc_html( $settings['borderless_elementor_info_box_title'] )
			);
		}
		if ( ! empty( $settings['borderless_elementor_info_box_description'] ) ) {
			$body_html .= '<div class="borderless-info-box-text"><p>' . wp_kses_post( $settings['borderless_elementor_info_box_description'] ) . '</p></div>';
		}
		$body_html .= '</div>';

		// Prepare Button HTML (if set)
		$button_html = '';
		if ( ! empty( $settings['borderless_elementor_info_box_button_text'] ) ) {
			$link = $settings['borderless_elementor_info_box_button_link'];
			$target   = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
			$nofollow = ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
			$button_class = 'borderless-info-box-button';
			if ( 'yes' === $settings['borderless_elementor_info_box_button_full_width'] ) {
				$button_class .= ' full-width-button';
			}
			$button_html  = '<div class="borderless-info-box-footer">';
			$button_html .= '<a href="' . esc_url( $link['url'] ) . '" class="' . esc_attr( $button_class ) . '"' . $target . $nofollow . '>';
			$button_html .= '<span class="button-content" style="display: inline-flex; align-items: center;">';
			if ( 'before' === $settings['borderless_elementor_info_box_button_icon_position'] ) {
				$button_html .= '<span class="button-icon" style="margin-right: 8px;">';
				ob_start();
				Icons_Manager::render_icon( $settings['borderless_elementor_info_box_button_icon'], [ 'aria-hidden' => 'true' ] );
				$button_html .= ob_get_clean();
				$button_html .= '</span>';
			}
			$button_html .= '<span class="button-text">' . esc_html( $settings['borderless_elementor_info_box_button_text'] ) . '</span>';
			if ( 'after' === $settings['borderless_elementor_info_box_button_icon_position'] ) {
				$button_html .= '<span class="button-icon" style="margin-left: 8px;">';
				ob_start();
				Icons_Manager::render_icon( $settings['borderless_elementor_info_box_button_icon'], [ 'aria-hidden' => 'true' ] );
				$button_html .= ob_get_clean();
				$button_html .= '</span>';
			}
			$button_html .= '</span></a></div>';
		}

		// Append Button HTML to the body HTML (inside content container)
		$content_html = $body_html . $button_html;
		
		// Build a wrapper based on the direction.
		$media_direction = $settings['borderless_elementor_info_box_direction'];
		$wrapper_html = '';
		if ( 'left' === $media_direction ) {
			$wrapper_html = '<div class="borderless-info-box-wrapper media-left" style="display: flex; align-items: center;">'
			              . '<div class="borderless-info-box-media">' . $media_html . '</div>'
			              . '<div class="borderless-info-box-content">' . $content_html . '</div>'
			              . '</div>';
		} elseif ( 'right' === $media_direction ) {
			$wrapper_html = '<div class="borderless-info-box-wrapper media-right" style="display: flex; align-items: center; flex-wrap: nowrap;">'
			              . '<div class="borderless-info-box-content">' . $content_html . '</div>'
			              . '<div class="borderless-info-box-media">' . $media_html . '</div>'
			              . '</div>';
		} else { // "top" or default
			$wrapper_html = '<div class="borderless-info-box-wrapper media-top">'
			              . $media_html
			              . $content_html
			              . '</div>';
		}

		echo $wrapper_html;
	}
}

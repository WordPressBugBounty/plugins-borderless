<?php

namespace Borderless\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Utils;

class Portfolio extends Widget_Base {

	public function get_name() {
		return 'borderless-elementor-portfolio';
	}

	public function get_title() {
		return esc_html__( 'Portfolio', 'borderless' );
	}

	public function get_icon() {
		return 'borderless-icon-portfolio';
	}

	public function get_categories() {
		return [ 'borderless' ];
	}

	public function get_keywords() {
		return [
			'portfolio',
			'portfolio gallery',
			'borderless portfolio',
			'borderless portfolio gallery',
			'borderless',
		];
	}

	public function get_style_depends() {
		return [ 'elementor-widget-portfolio' ];
	}

	public function get_script_depends() {
		return [ 'borderless-elementor-isotope-script' ];
	}

	/**
	 * Helper method to get public taxonomies
	 */
	private function get_public_taxonomies() {
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		$options = [ '' => __( 'Select...', 'borderless' ) ];

		if ( ! empty( $taxonomies ) ) {
			foreach ( $taxonomies as $tax_key => $tax_value ) {
				$options[ $tax_key ] = $tax_value->labels->singular_name;
			}
		}

		return $options;
	}

	protected function register_controls() {

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Portfolio/Source - Content
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_portfolio',
			[
				'label' => esc_html__( 'Content Source', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'borderless_elementor_portfolio_content_source',
			[
				'label'       => __( 'Content Source', 'borderless' ),
				'description' => __( 'Choose Query to Use Post Types or Static to Create Each Item.', 'borderless' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'static',
				'options'     => [
					'static' => __( 'Static', 'borderless' ),
					'query'  => __( 'Query', 'borderless' ),
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Portfolio/Items (Static) - Content
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_portfolio_items',
			[
				'label'     => esc_html__( 'Items', 'borderless' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'borderless_elementor_portfolio_content_source' => 'static',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'borderless_elementor_portfolio_item_title',
			[
				'label'       => esc_html__( 'Title', 'borderless' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'borderless_elementor_portfolio_item_description',
			[
				'label'   => esc_html__( 'Description', 'borderless' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'borderless_elementor_portfolio_item_image',
			[
				'label'     => __( 'Image', 'borderless' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic'   => [ 'active' => true ],
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'borderless_elementor_portfolio_item_image',
				'default'   => 'large',
				'separator' => 'none',
			]
		);

		$repeater->add_control(
			'borderless_elementor_portfolio_item_image_link',
			[
				'label'   => __( 'Image Link', 'borderless' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'static',
				'options' => [
					'none'     => __( 'None', 'borderless' ),
					'lightbox' => __( 'Lightbox', 'borderless' ),
					'external' => __( 'External', 'borderless' ),
				],
			]
		);

		$repeater->add_control(
			'borderless_elementor_portfolio_item_button_text',
			[
				'label'     => esc_html__( 'Button Text', 'borderless' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'View More', 'borderless' ),
				'dynamic'   => [ 'active' => true ],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'borderless_elementor_portfolio_item_button_link',
			[
				'label'       => esc_html__( 'Button Link', 'borderless' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default'     => [ 'url' => '' ],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'borderless_elementor_portfolio_item_filter',
			[
				'label'       => esc_html__( 'Filter', 'borderless' ),
				'description' => esc_html__( 'Enter Filter items separated by commas.', 'borderless' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'separator'   => 'before',
			]
		);

		$repeater->add_control(
			'borderless_elementor_portfolio_item_sort',
			[
				'label'       => esc_html__( 'Sort', 'borderless' ),
				'description' => esc_html__( 'Enter Sort items separated by commas.', 'borderless' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
			]
		);

		$this->add_control(
			'borderless_elementor_portfolio_item_strings',
			[
				'type'        => Controls_Manager::REPEATER,
				'show_label'  => true,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{ borderless_elementor_portfolio_item_title }}',
				'default'     => [
					[],
					[],
					[],
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Portfolio/Data Source (Query) - Content
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_portfolio_data_source',
			[
				'label'     => esc_html__( 'Data Source', 'borderless' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'borderless_elementor_portfolio_content_source' => 'query',
				],
			]
		);

		$post_types        = get_post_types( [ 'public' => true ], 'objects' );
		$post_type_options = [];

		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $pt_key => $pt_value ) {
				$post_type_options[ $pt_key ] = $pt_value->labels->singular_name;
			}
		}

		$this->add_control(
			'borderless_elementor_portfolio_query_post_type',
			[
				'label'   => esc_html__( 'Post Type', 'borderless' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $post_type_options,
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Portfolio/Filter - New Section
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_portfolio_filter_new',
			[
				'label' => esc_html__( 'Filter', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'borderless_elementor_enable_filter',
			[
				'label'        => esc_html__( 'Enable Filter', 'borderless' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'borderless' ),
				'label_off'    => esc_html__( 'No', 'borderless' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'borderless_elementor_portfolio_default_filter_label',
			[
				'label'     => esc_html__( 'Default Filter Label', 'borderless' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'All',
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'borderless_elementor_enable_filter' => 'yes',
				],
			]
		);

		$this->add_control(
			'borderless_elementor_portfolio_taxonomy_filter',
			[
				'label'       => esc_html__( 'Taxonomy to Filter', 'borderless' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => $this->get_public_taxonomies(),
				'condition'   => [
					'borderless_elementor_portfolio_content_source' => 'query',
					'borderless_elementor_enable_filter'            => 'yes',
				],
				'description' => __( 'Select which taxonomy should be used for the filter if in Query mode.', 'borderless' ),
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Portfolio/Settings - Content
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_portfolio_settings',
			[
				'label' => esc_html__( 'Settings', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'borderless_elementor_portfolio_item_columns',
			[
				'label'   => __( 'Columns', 'borderless' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'borderless-cell-4@md',
				'options' => [
					'borderless-cell-12@md' => __( '1 Column', 'borderless' ),
					'borderless-cell-6@md'  => __( '2 Columns', 'borderless' ),
					'borderless-cell-4@md'  => __( '3 Columns', 'borderless' ),
					'borderless-cell-3@md'  => __( '4 Columns', 'borderless' ),
					'borderless-cell-2@md'  => __( '6 Columns', 'borderless' ),
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  General
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_item_style',
			[
				'label' => esc_html__( 'General', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_portfolio_item_gap',
			[
				'label'      => __( 'Gap', 'borderless' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'range'      => [
					'px'  => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
					'%'   => [
						'min'  => 0,
						'max'  => 100,
					],
					'rem' => [
						'min'  => 0,
						'max'  => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-inner' => 'margin: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .borderless-elementor-portfolio-items'       => 'margin: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_portfolio_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'borderless_elementor_portfolio_item_border',
				'label'    => esc_html__( 'Border', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-inner',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_portfolio_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'borderless_elementor_portfolio_item_border_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item',
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Title
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_title_style',
			[
				'label' => esc_html__( 'Title', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_title_align',
			[
				'label'        => __( 'Alignment', 'borderless' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => __( 'Left', 'borderless' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'borderless' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'borderless' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'e-grid-align-',
				'default'      => 'center',
				'selectors'    => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'borderless_elementor_item_content_title_color',
			[
				'label'     => __( 'Color', 'borderless' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_title_typography',
				'label'    => __( 'Typography', 'borderless' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-title',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_title_padding',
			[
				'label'      => esc_html__( 'Padding', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Description
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_description_style',
			[
				'label' => esc_html__( 'Description', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_description_align',
			[
				'label'        => __( 'Alignment', 'borderless' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => __( 'Left', 'borderless' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'borderless' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'borderless' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'e-grid-align-',
				'default'      => 'center',
				'selectors'    => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-description' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'borderless_elementor_item_content_description_color',
			[
				'label'     => __( 'Color', 'borderless' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_description_typography',
				'label'    => __( 'Typography', 'borderless' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-description',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_description_padding',
			[
				'label'      => esc_html__( 'Padding', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_description_margin',
			[
				'label'      => esc_html__( 'Margin', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Button
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_button_style',
			[
				'label' => esc_html__( 'Button', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_button_alignment',
			[
				'label'        => __( 'Alignment', 'borderless' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => __( 'Left', 'borderless' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'borderless' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'borderless' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'e-grid-align-',
				'default'      => 'center',
				'selectors'    => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-button-container' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_button_margin',
			[
				'label'      => esc_html__( 'Margin', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'borderless_elementor_item_content_button_tabs' );

		$this->start_controls_tab(
			'borderless_elementor_item_content_button_tab_normal',
			[
				'label' => __( 'Normal', 'borderless' ),
			]
		);

		$this->add_control(
			'borderless_elementor_item_content_button_color',
			[
				'label'     => __( 'Text Color', 'borderless' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_button_background',
				'label'    => __( 'Background', 'borderless' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-button',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_button_typography',
				'label'    => __( 'Typography', 'borderless' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_button_border',
				'label'    => esc_html__( 'Border', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-button',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-button' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'borderless_elementor_item_content_button_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'borderless_elementor_item_content_button_tab_hover',
			[
				'label' => __( 'Hover', 'borderless' ),
			]
		);

		$this->add_control(
			'borderless_elementor_item_content_button_color_hover',
			[
				'label'     => __( 'Text Color', 'borderless' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_button_background_hover',
				'label'    => __( 'Background', 'borderless' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_button_typography_hover',
				'label'    => __( 'Typography', 'borderless' ),
				'global'   => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-button:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_button_border_hover',
				'label'    => esc_html__( 'Border', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-button:hover',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_button_radius_hover',
			[
				'label'      => esc_html__( 'Border Radius', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-button:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'borderless_elementor_item_content_button_box_shadow_hover',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Image
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_image_style',
			[
				'label' => esc_html__( 'Image', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_image_css_filters',
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-inner img',
			]
		);

		$this->add_control(
			'borderless_elementor_item_content_image_opacity',
			[
				'label' => __( 'Opacity', 'borderless' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-inner img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_image_border',
				'label'    => esc_html__( 'Border', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-inner img',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-inner img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'borderless_elementor_item_content_image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-inner img',
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Overlay
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_content_style',
			[
				'label' => esc_html__( 'Overlay', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_vertical_alignment',
			[
				'label'        => __( 'Content Position', 'borderless' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'flex-start' => [
						'title' => __( 'Top', 'borderless' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'borderless' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Bottom', 'borderless' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'      => 'center',
				'selectors'    => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-content' => 'align-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_background',
				'label'    => __( 'Background', 'borderless' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-content',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_margin',
			[
				'label'      => esc_html__( 'Margin', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_border',
				'label'    => esc_html__( 'Border', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-content',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-content' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'borderless_elementor_item_content_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-content',
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Filter
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_filter_style',
			[
				'label' => esc_html__( 'Filter', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'borderless_elementor_filter_direction',
			[
				'label'     => esc_html__( 'Filter Layout Direction', 'borderless' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'row',
				'options'   => [
					'row'    => esc_html__( 'Row', 'borderless' ),
					'column' => esc_html__( 'Column', 'borderless' ),
				],
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-filter' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'borderless_elementor_filter_alignment',
			[
				'label'     => esc_html__( 'Filter Alignment', 'borderless' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'space-between',
				'options'   => [
					'flex-start'    => esc_html__( 'Left/Start', 'borderless' ),
					'center'        => esc_html__( 'Center', 'borderless' ),
					'flex-end'      => esc_html__( 'Right/End', 'borderless' ),
					'space-between' => esc_html__( 'Space Between', 'borderless' ),
					'space-around'  => esc_html__( 'Space Around', 'borderless' ),
				],
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-filter' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_filter_padding_general',
			[
				'label'      => esc_html__( 'Padding', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_filter_margin_general',
			[
				'label'      => esc_html__( 'Margin', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Filter Item
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_filter_item_style',
			[
				'label' => esc_html__( 'Filter Item', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Controle de tipografia (fora das tabs)
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'borderless_elementor_filter_typography',
				'label'    => esc_html__( 'Typography', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-filter-item-title',
			]
		);

		// Início das tabs Normal/Hover
		$this->start_controls_tabs( 'filter_item_tabs' );

		// Tab Normal
		$this->start_controls_tab(
			'filter_item_normal_tab',
			[
				'label' => __( 'Normal', 'borderless' ),
			]
		);

			$this->add_control(
				'borderless_elementor_filter_text_color_normal',
				[
					'label'     => __( 'Text Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .borderless-elementor-portfolio-filter-item-title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'borderless_elementor_filter_background_normal',
					'label'    => __( 'Background', 'borderless' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-filter-item',
				]
			);

		$this->end_controls_tab();

		// Tab Hover
		$this->start_controls_tab(
			'filter_item_hover_tab',
			[
				'label' => __( 'Hover', 'borderless' ),
			]
		);

			$this->add_control(
				'borderless_elementor_filter_text_color_hover',
				[
					'label'     => __( 'Text Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .borderless-elementor-portfolio-filter-item-title:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'borderless_elementor_filter_background_hover',
					'label'    => __( 'Background', 'borderless' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-filter-item:hover',
				]
			);

			$this->add_control(
				'borderless_elementor_filter_border_color_hover',
				[
					'label'     => __( 'Border Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .borderless-elementor-portfolio-filter-item:hover' => 'border-color: {{VALUE}};',
					],
				]
			);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Restante dos controles para Filter Item
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'borderless_elementor_filter_border',
				'label'    => esc_html__( 'Border', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-filter-item',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_filter_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-filter-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'borderless_elementor_filter_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-filter-item',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_filter_padding',
			[
				'label'      => esc_html__( 'Padding', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-filter-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_filter_margin_item',
			[
				'label'      => esc_html__( 'Margin', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-filter-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Image
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_image_style',
			[
				'label' => esc_html__( 'Image', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_image_css_filters',
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-inner img',
			]
		);

		$this->add_control(
			'borderless_elementor_item_content_image_opacity',
			[
				'label' => __( 'Opacity', 'borderless' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-inner img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_image_border',
				'label'    => esc_html__( 'Border', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-inner img',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-inner img' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'borderless_elementor_item_content_image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-inner img',
			]
		);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  *.  Overlay
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'borderless_elementor_section_content_style',
			[
				'label' => esc_html__( 'Overlay', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_vertical_alignment',
			[
				'label'        => __( 'Content Position', 'borderless' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
					'flex-start' => [
						'title' => __( 'Top', 'borderless' ),
						'icon'  => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'borderless' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Bottom', 'borderless' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'      => 'center',
				'selectors'    => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-content' => 'align-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_background',
				'label'    => __( 'Background', 'borderless' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-content',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_margin',
			[
				'label'      => esc_html__( 'Margin', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'borderless_elementor_item_content_border',
				'label'    => esc_html__( 'Border', 'borderless' ),
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-content',
			]
		);

		$this->add_responsive_control(
			'borderless_elementor_item_content_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'borderless' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'selectors'  => [
					'{{WRAPPER}} .borderless-elementor-portfolio-item-content' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'    => 'borderless_elementor_item_content_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .borderless-elementor-portfolio-item-content',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$target   = isset( $settings['borderless_elementor_portfolio_item_button_link']['is_external'] ) && $settings['borderless_elementor_portfolio_item_button_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = isset( $settings['borderless_elementor_portfolio_item_button_link']['nofollow'] ) && $settings['borderless_elementor_portfolio_item_button_link']['nofollow'] ? ' rel="nofollow"' : '';

		/**
		 * QUERY MODE
		 */
		if ( 'query' === $settings['borderless_elementor_portfolio_content_source'] ) {

			$post_type_chosen = ! empty( $settings['borderless_elementor_portfolio_query_post_type'] )
				? $settings['borderless_elementor_portfolio_query_post_type']
				: 'post';

			$args = [
				'post_type'      => $post_type_chosen,
				'posts_per_page' => -1,
			];

			$wp_query = new \WP_Query( $args );

			if ( $wp_query->have_posts() ) {
				?>
				<div class="borderless-elementor-portfolio-widget">
					<div class="borderless-elementor-portfolio borderless-container" data-portfolio-gutter="<?php echo esc_attr( $settings['borderless_elementor_portfolio_item_gap']['size'] ); ?>">
						<?php
						// Render the filter only if enabled.
						if ( 'yes' === $settings['borderless_elementor_enable_filter'] ) {
							?>
							<div class="borderless-elementor-portfolio-filters">
								<div class="borderless-elementor-portfolio-filter" data-portfolio-filter-group="filter">
									<div class="borderless-elementor-portfolio-filter-item is-checked" data-portfolio-filter="">
										<span class="borderless-elementor-portfolio-filter-item-title"><?php echo esc_html( $settings['borderless_elementor_portfolio_default_filter_label'] ); ?></span>
									</div>
									<?php
									if ( ! empty( $settings['borderless_elementor_portfolio_taxonomy_filter'] ) ) {
										$tax = $settings['borderless_elementor_portfolio_taxonomy_filter'];
										$terms = get_terms( [
											'taxonomy'   => $tax,
											'hide_empty' => true,
										] );

										if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
											foreach ( $terms as $term ) {
												$term_slug_class = strtolower( str_replace( ' ', '', $term->slug ) );
												?>
												<div class="borderless-elementor-portfolio-filter-item" data-portfolio-filter=".<?php echo esc_attr( $term_slug_class ); ?>">
													<span class="borderless-elementor-portfolio-filter-item-title"><?php echo esc_html( $term->name ); ?></span>
												</div>
												<?php
											}
										}
									}
									?>
								</div>
							</div><!-- .borderless-elementor-portfolio-filters -->
							<?php
						}
						?>
						<div class="borderless-elementor-portfolio-items borderless-grid">
							<?php
							while ( $wp_query->have_posts() ) {
								$wp_query->the_post();

								$taxonomy_classes = '';
								if ( ! empty( $settings['borderless_elementor_portfolio_taxonomy_filter'] ) ) {
									$selected_tax = $settings['borderless_elementor_portfolio_taxonomy_filter'];
									$post_terms   = get_the_terms( get_the_ID(), $selected_tax );

									if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
										foreach ( $post_terms as $pt ) {
											$taxonomy_classes .= ' ' . strtolower( str_replace( ' ', '', $pt->slug ) );
										}
									}
								}
								?>
								<div class="borderless-elementor-portfolio-item <?php echo esc_attr( $settings['borderless_elementor_portfolio_item_columns'] . $taxonomy_classes ); ?>">
									<div class="borderless-elementor-portfolio-item-inner">
										<?php
										if ( has_post_thumbnail() ) {
											the_post_thumbnail( 'large' );
										} else {
											echo '<img src="' . esc_url( Utils::get_placeholder_image_src() ) . '" alt="' . esc_attr( get_the_title() ) . '">';
										}
										?>
										<div class="borderless-elementor-portfolio-item-content">
											<div class="borderless-elementor-portfolio-item-content-inner">
												<h2 class="borderless-elementor-portfolio-item-title"><?php the_title(); ?></h2>
												<div class="borderless-elementor-portfolio-item-button-container">
													<a class="borderless-elementor-portfolio-item-button borderless-btn borderless-btn--primary" href="<?php the_permalink(); ?>">
														<?php esc_html_e( 'Read More', 'borderless' ); ?>
													</a>
												</div>
											</div><!-- .borderless-elementor-portfolio-item-content-inner -->
										</div><!-- .borderless-elementor-portfolio-item-content -->
									</div><!-- .borderless-elementor-portfolio-item-inner -->
								</div><!-- .borderless-elementor-portfolio-item -->
								<?php
							}
							?>
						</div><!-- .borderless-elementor-portfolio-items -->
					</div><!-- .borderless-elementor-portfolio -->
				</div><!-- .borderless-elementor-portfolio-widget -->
				<?php
			}
			wp_reset_postdata();
			return;
		}

		/**
		 * STATIC MODE
		 */
		if ( ! empty( $settings['borderless_elementor_portfolio_item_strings'] ) ) {
			$filter_title_items  = [];
			$filter_classe_items = [];
			foreach ( $settings['borderless_elementor_portfolio_item_strings'] as $portfolio_string ) {
				$filters = explode( ',', $portfolio_string['borderless_elementor_portfolio_item_filter'] );
				$filters = array_map( 'trim', $filters );
				foreach ( $filters as $filter_title ) {
					$filter_title_items[]  = $filter_title;
				}
				foreach ( $filters as $filter_classe ) {
					$filter_classe_items[] = strtolower( str_replace( ' ', '', $filter_classe ) );
				}
			}
			$filter_title_items  = array_unique( $filter_title_items );
			$filter_classe_items = array_unique( $filter_classe_items );
			?>
			<div class="borderless-elementor-portfolio-widget">
				<div class="borderless-elementor-portfolio borderless-container" data-portfolio-gutter="<?php echo esc_attr( $settings['borderless_elementor_portfolio_item_gap']['size'] ); ?>">
					<?php
					// Render filter block only if enabled.
					if ( 'yes' === $settings['borderless_elementor_enable_filter'] ) {
						?>
						<div class="borderless-elementor-portfolio-filters">
							<div class="borderless-elementor-portfolio-filter" data-portfolio-filter-group="filter">
								<div class="borderless-elementor-portfolio-filter-item is-checked" data-portfolio-filter="">
									<span class="borderless-elementor-portfolio-filter-item-title"><?php echo esc_html( $settings['borderless_elementor_portfolio_default_filter_label'] ); ?></span>
								</div>
								<?php
								if ( ! empty( $settings['borderless_elementor_portfolio_item_strings'] ) ) {
									foreach ( array_combine( $filter_title_items, $filter_classe_items ) as $filter_title_item => $filter_classe_item ) {
										?>
										<div class="borderless-elementor-portfolio-filter-item" data-portfolio-filter=".<?php echo esc_attr( $filter_classe_item ); ?>">
											<span class="borderless-elementor-portfolio-filter-item-title"><?php echo esc_html( $filter_title_item ); ?></span>
										</div>
										<?php
									}
								}
								?>
							</div>
						</div><!-- .borderless-elementor-portfolio-filters -->
						<?php
					}
					?>
					<div class="borderless-elementor-portfolio-items borderless-grid">
						<?php
						foreach ( $settings['borderless_elementor_portfolio_item_strings'] as $portfolio_string ) {
							$filter = strtolower( str_replace( ',', ' ', $portfolio_string['borderless_elementor_portfolio_item_filter'] ) );
							$filter = strtolower( str_replace( ' ', '', $filter ) );
							?>
							<div class="borderless-elementor-portfolio-item <?php echo esc_attr( $settings['borderless_elementor_portfolio_item_columns'] . ' ' . $filter ); ?>">
								<div class="borderless-elementor-portfolio-item-inner">
									<img src="<?php echo esc_url( $portfolio_string['borderless_elementor_portfolio_item_image']['url'] ); ?>" alt="">
									<div class="borderless-elementor-portfolio-item-content">
										<div class="borderless-elementor-portfolio-item-content-inner">
											<h2 class="borderless-elementor-portfolio-item-title"><?php echo wp_kses( $portfolio_string['borderless_elementor_portfolio_item_title'], [] ); ?></h2>
											<span class="borderless-elementor-portfolio-item-description"><?php echo wp_kses( $portfolio_string['borderless_elementor_portfolio_item_description'], [] ); ?></span>
											<div class="borderless-elementor-portfolio-item-button-container">
												<a class="borderless-elementor-portfolio-item-button borderless-btn borderless-btn--primary" href="<?php echo esc_url( $portfolio_string['borderless_elementor_portfolio_item_button_link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
													<?php echo wp_kses( $portfolio_string['borderless_elementor_portfolio_item_button_text'], [] ); ?>
												</a>
											</div>
										</div><!-- .borderless-elementor-portfolio-item-content-inner -->
									</div><!-- .borderless-elementor-portfolio-item-content -->
								</div><!-- .borderless-elementor-portfolio-item-inner -->
							</div><!-- .borderless-elementor-portfolio-item -->
							<?php
						}
						?>
					</div><!-- .borderless-elementor-portfolio-items -->
				</div><!-- .borderless-elementor-portfolio -->
			</div><!-- .borderless-elementor-portfolio-widget -->
			<?php
		}
	}

	protected function content_template() {}
}

<?php
namespace Borderless\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Pricing_Table extends Widget_Base {

	// Widget Name
	public function get_name() {
		return 'borderless_pricing_table';
	}

	// Widget Title
	public function get_title() {
		return esc_html__( 'Pricing Table', 'borderless' );
	}

	// Widget Icon
	public function get_icon() {
		return 'eicon-price-table';
	}

	// Widget Categories
	public function get_categories() {
		return [ 'borderless' ];
	}

	// Widget Style Dependencies
	public function get_style_depends() {
		return [ 'elementor-widget-pricing-table' ];
	}

	protected function register_controls() {

		// HEADER (Content Tab) - Header settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_section_header',
			[
				'label' => esc_html__( 'Header', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_pricing_table_title',
				[
					'label'   => esc_html__( 'Title', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Basic Plan', 'borderless' ),
					'dynamic' => [ 'active' => true ],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_subtitle',
				[
					'label'   => esc_html__( 'Subtitle', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Best for startups', 'borderless' ),
					'dynamic' => [ 'active' => true ],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_media_type',
				[
					'label'     => esc_html__( 'Media Type', 'borderless' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'icon'  => [
							'title' => esc_html__( 'Icon', 'borderless' ),
							'icon'  => 'eicon-star',
						],
						'image' => [
							'title' => esc_html__( 'Image', 'borderless' ),
							'icon'  => 'eicon-image',
						],
					],
					'default'   => 'icon',
					'toggle'    => false,
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_icon',
				[
					'label'     => esc_html__( 'Icon', 'borderless' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => [
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					],
					'condition' => [
						'borderless_elementor_pricing_table_media_type' => 'icon',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_image',
				[
					'label'     => esc_html__( 'Image', 'borderless' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => [
						'url' => \Elementor\Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'borderless_elementor_pricing_table_media_type' => 'image',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_icon_position',
				[
					'label'   => esc_html__( 'Media Position', 'borderless' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'before_title' => esc_html__( 'Before Title', 'borderless' ),
						'after_title'  => esc_html__( 'After Title', 'borderless' ),
					],
					'default' => 'before_title',
				]
			);
		$this->end_controls_section();

		// PRICING (Content Tab) - Pricing settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_section_price',
			[
				'label' => esc_html__( 'Pricing', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_pricing_table_price',
				[
					'label'   => esc_html__( 'Price', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( '49', 'borderless' ),
					'dynamic' => [ 'active' => true ],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_currency',
				[
					'label'   => esc_html__( 'Currency Symbol', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( '$', 'borderless' ),
					'dynamic' => [ 'active' => true ],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_period',
				[
					'label'   => esc_html__( 'Price Period', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( '/month', 'borderless' ),
					'dynamic' => [ 'active' => true ],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_on_sale',
				[
					'label'        => esc_html__( 'On Sale?', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'borderless' ),
					'label_off'    => esc_html__( 'No', 'borderless' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_sale_price',
				[
					'label'       => esc_html__( 'Sale Price', 'borderless' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( '39', 'borderless' ),
					'condition'   => [
						'borderless_elementor_pricing_table_on_sale' => 'yes',
					],
					'dynamic'     => [ 'active' => true ],
				]
			);
		$this->end_controls_section();

		// FEATURES (Content Tab) - Features list settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_section_features',
			[
				'label' => esc_html__( 'Features', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_pricing_table_features_title',
				[
					'label'   => esc_html__( 'Title', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Features', 'borderless' ),
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'borderless_elementor_pricing_table_feature_text',
				[
					'label'   => esc_html__( 'Feature', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Feature', 'borderless' ),
					'dynamic' => [ 'active' => true ],
				]
			);
			$repeater->add_control(
				'borderless_elementor_pricing_table_feature_icon',
				[
					'label'   => esc_html__( 'Feature Icon', 'borderless' ),
					'type'    => Controls_Manager::ICONS,
					'default' => [
						'value'   => 'fas fa-check',
						'library' => 'fa-solid',
					],
				]
			);
			$repeater->add_control(
				'borderless_elementor_pricing_table_feature_tooltip',
				[
					'label'        => esc_html__( 'Enable Tooltip', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'borderless' ),
					'label_off'    => esc_html__( 'No', 'borderless' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$repeater->add_control(
				'borderless_elementor_pricing_table_feature_tooltip_text',
				[
					'label'     => esc_html__( 'Tooltip Text', 'borderless' ),
					'type'      => Controls_Manager::TEXTAREA,
					'default'   => esc_html__( 'More details about this feature', 'borderless' ),
					'condition' => [
						'borderless_elementor_pricing_table_feature_tooltip' => 'yes',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_features_list',
				[
					'label'     => esc_html__( 'Features List', 'borderless' ),
					'type'      => Controls_Manager::REPEATER,
					'fields'    => $repeater->get_controls(),
					'default'   => [
						[ 'borderless_elementor_pricing_table_feature_text' => esc_html__( 'Responsive Design', 'borderless' ) ],
						[ 'borderless_elementor_pricing_table_feature_text' => esc_html__( 'Unlimited Bandwidth', 'borderless' ) ],
						[ 'borderless_elementor_pricing_table_feature_text' => esc_html__( '24/7 Support', 'borderless' ) ],
					],
					'title_field' => '{{{ borderless_elementor_pricing_table_feature_text }}}',
				]
			);
		$this->end_controls_section();

		// DESCRIPTION (Content Tab) - Description settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_section_description',
			[
				'label' => esc_html__( 'Description', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_pricing_table_description_enable',
				[
					'label'        => esc_html__( 'Show Description', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'borderless' ),
					'label_off'    => esc_html__( 'No', 'borderless' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_description',
				[
					'label'   => esc_html__( 'Description Text', 'borderless' ),
					'type'    => Controls_Manager::WYSIWYG,
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'borderless' ),
					'condition' => [
						'borderless_elementor_pricing_table_description_enable' => 'yes',
					],
				]
			);
		$this->end_controls_section();

		// RIBBON / BADGE (Content Tab) - Ribbon settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_section_ribbon',
			[
				'label' => esc_html__( 'Ribbon / Badge', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_pricing_table_featured',
				[
					'label'        => esc_html__( 'Show Ribbon / Badge', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'borderless' ),
					'label_off'    => esc_html__( 'No', 'borderless' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_ribbon_text',
				[
					'label'     => esc_html__( 'Ribbon Text', 'borderless' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( 'Featured', 'borderless' ),
					'condition' => [
						'borderless_elementor_pricing_table_featured' => 'yes',
					],
				]
			);
		$this->end_controls_section();

		// BUTTON (Content Tab) - Button settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_section_button',
			[
				'label' => esc_html__( 'Button', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_pricing_table_button_text',
				[
					'label'   => esc_html__( 'Button Text', 'borderless' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Buy Now', 'borderless' ),
					'dynamic' => [ 'active' => true ],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_button_link',
				[
					'label'   => esc_html__( 'Button Link', 'borderless' ),
					'type'    => Controls_Manager::URL,
					'default' => [
						'url' => '#',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_button_icon',
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
				'borderless_elementor_pricing_table_button_icon_alignment',
				[
					'label'   => esc_html__( 'Button Icon Alignment', 'borderless' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'left'  => esc_html__( 'Before Text', 'borderless' ),
						'right' => esc_html__( 'After Text', 'borderless' ),
					],
					'default' => 'right',
				]
			);
		$this->end_controls_section();

		// BLOCKS ORDER (Content Tab) - Blocks order settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_section_blocks_order',
			[
				'label' => esc_html__( 'Blocks Order', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
			$this->add_control(
				'borderless_elementor_pricing_table_header_order',
				[
					'label'   => esc_html__( 'Header Order', 'borderless' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 1,
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_price_order',
				[
					'label'   => esc_html__( 'Pricing Order', 'borderless' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 2,
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_features_order',
				[
					'label'   => esc_html__( 'Features Order', 'borderless' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 3,
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_description_order',
				[
					'label'   => esc_html__( 'Description Order', 'borderless' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 4,
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_button_order',
				[
					'label'   => esc_html__( 'Button Order', 'borderless' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 5,
				]
			);
		$this->end_controls_section();

		// CONTAINER (Style Tab) - Container style settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_container_style',
			[
				'label' => esc_html__( 'Container', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_container_background',
					'label'    => esc_html__( 'Background', 'borderless' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .borderless-pricing-table',
				]
			);
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'borderless_elementor_pricing_table_container_border',
                    'label'    => esc_html__( 'Border', 'borderless' ),
                    'selector' => '{{WRAPPER}} .borderless-pricing-table',
                    'default'  => [
                        'width' => [
                            'top'    => '1',
                            'right'  => '1',
                            'bottom' => '1',
                            'left'   => '1',
                        ],
                        'style' => 'solid',
                        'color' => '#eaeaea',
                    ],
                ]
            );
            $this->add_responsive_control(
                'borderless_elementor_pricing_table_container_border_radius',
                [
                    'label'      => esc_html__( 'Border Radius', 'borderless' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'default'    => [
                        'top'    => '4',
                        'right'  => '4',
                        'bottom' => '4',
                        'left'   => '4',
                        'unit'   => 'px',
                    ],
                    'selectors'  => [
                        '{{WRAPPER}} .borderless-pricing-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_container_padding',
				[
					'label'      => esc_html__( 'Padding', 'borderless' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .borderless-pricing-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'borderless_elementor_pricing_table_container_box_shadow',
                    'label'    => esc_html__( 'Box Shadow', 'borderless' ),
                    'selector' => '{{WRAPPER}} .borderless-pricing-table',
                ]
            );
		$this->end_controls_section();

		// HEADER (Style Tab) - Header style settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_header_style',
			[
				'label' => esc_html__( 'Header', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_header_position',
				[
					'label' => esc_html__( 'Position', 'borderless' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'borderless' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'borderless' ),
							'icon' => 'eicon-h-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'borderless' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-header' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_header_title_color',
				[
					'label'     => esc_html__( 'Title Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#333333',
					'selectors' => [
						'{{WRAPPER}} .pricing-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_header_title_typography',
					'label'    => esc_html__( 'Title Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-title',
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_header_subtitle_color',
				[
					'label'     => esc_html__( 'Subtitle Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#777777',
					'selectors' => [
						'{{WRAPPER}} .pricing-subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_header_subtitle_typography',
					'label'    => esc_html__( 'Subtitle Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-subtitle',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_header_icon_size',
				[
					'label' => esc_html__( 'Icon Size', 'borderless' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 6,
							'max' => 200,
						],
					],
					'default' => [
						'size' => 40,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-header .pricing-media i'  => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .pricing-header .pricing-media svg' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'borderless_elementor_pricing_table_media_type' => 'icon',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_header_icon_color',
				[
					'label' => esc_html__( 'Icon Color', 'borderless' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#333333',
					'selectors' => [
						'{{WRAPPER}} .pricing-header .pricing-media i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .pricing-header .pricing-media svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'borderless_elementor_pricing_table_media_type' => 'icon',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_header_padding',
				[
					'label' => esc_html__( 'Padding', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .pricing-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		// PRICING (Style Tab) - Pricing style settings with new grouping
		$this->start_controls_section(
			'borderless_elementor_pricing_table_price_style',
			[
				'label' => esc_html__( 'Pricing', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_price_position',
				[
					'label' => esc_html__( 'Position', 'borderless' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'flex-start',
					'options' => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'borderless' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'borderless' ),
							'icon' => 'eicon-h-align-center',
						],
						'flex-end' => [
							'title' => esc_html__( 'Right', 'borderless' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-price' => 'justify-content: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_price_padding',
				[
					'label' => esc_html__( 'Padding', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .pricing-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			// Group: Currency Symbol
			$this->add_control(
				'borderless_elementor_pricing_table_currency_symbol_heading',
				[
					'label' => esc_html__( 'Currency Symbol', 'borderless' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'after',
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_currency_symbol_color',
				[
					'label' => esc_html__( 'Color', 'borderless' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#e74c3c',
					'selectors' => [
						'{{WRAPPER}} .pricing-price .sale-price .currency-symbol' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'borderless_elementor_pricing_table_currency_symbol_typography',
					'label' => esc_html__( 'Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-price .sale-price .currency-symbol',
				]
			);
			// Group: Price
			$this->add_control(
				'borderless_elementor_pricing_table_price_heading',
				[
					'label' => esc_html__( 'Price', 'borderless' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_price_color',
				[
					'label'     => esc_html__( 'Color', 'borderless' ),
					'type' => Controls_Manager::COLOR,
					'default'   => '#e74c3c',
					'selectors' => [
						'{{WRAPPER}} .pricing-price .sale-price .price-value' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_price_typography',
					'label'    => esc_html__( 'Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-price .sale-price .price-value',
				]
			);
			// Group: Sales Price
			$this->add_control(
				'borderless_elementor_pricing_table_price_sales_price_heading',
				[
					'label' => esc_html__( 'Sales Price', 'borderless' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_sales_price_color',
				[
					'label'     => esc_html__( 'Color', 'borderless' ),
					'type' => Controls_Manager::COLOR,
					'default'   => '#333333',
					'selectors' => [
						'{{WRAPPER}} .pricing-price .original-price .currency-symbol, 
						{{WRAPPER}} .pricing-price .price:not(.sale-price) .currency-symbol, 
						{{WRAPPER}} .pricing-price .original-price, 
						{{WRAPPER}} .pricing-price .original-price .price-value, 
						{{WRAPPER}} .pricing-price .price:not(.sale-price) .price-value' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_sales_price_typography',
					'label'    => esc_html__( 'Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-price .original-price .currency-symbol, {{WRAPPER}} .pricing-price .original-price .price-value, {{WRAPPER}} .pricing-price .price:not(.sale-price) .currency-symbol, {{WRAPPER}} .pricing-price .price:not(.sale-price) .price-value',
				]
			);
			// Group: Period
			$this->add_control(
				'borderless_elementor_pricing_table_price_period_heading',
				[
					'label' => esc_html__( 'Period', 'borderless' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_price_period_color',
				[
					'label'     => esc_html__( 'Color', 'borderless' ),
					'type' => Controls_Manager::COLOR,
					'default'   => '#999999',
					'selectors' => [
						'{{WRAPPER}} .price-period' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_price_period_typography',
					'label'    => esc_html__( 'Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .price-period',
				]
			);
		$this->end_controls_section();

		// FEATURES (Style Tab) - Features style settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_features_style',
			[
				'label' => esc_html__( 'Features', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_features_position',
				[
					'label' => esc_html__( 'Position', 'borderless' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'borderless' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'borderless' ),
							'icon' => 'eicon-h-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'borderless' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-features' => 'text-align: {{VALUE}};',
						'{{WRAPPER}} .pricing-features ul li' => 'justify-content: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_features_text_color',
				[
					'label'     => esc_html__( 'Features Text Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#555555',
					'selectors' => [
						'{{WRAPPER}} .pricing-features ul li' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_features_typography',
					'label'    => esc_html__( 'Features Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-features ul li',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_features_title_typography',
					'label'    => esc_html__( 'Title Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .features-title',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_features_icon_spacing',
				[
					'label'   => esc_html__( 'Icon Spacing', 'borderless' ),
					'type'    => Controls_Manager::SLIDER,
					'range'   => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'default' => [
						'size' => 8,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-features ul li i'  => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .pricing-features ul li svg' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_features_icon_size',
				[
					'label'   => esc_html__( 'Icon Size', 'borderless' ),
					'type'    => Controls_Manager::SLIDER,
					'range'   => [
						'px' => [
							'min' => 6,
							'max' => 100,
						],
					],
					'default' => [
						'size' => 18,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-features ul li i'  => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .pricing-features ul li svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_features_items_gap',
				[
					'label' => esc_html__( 'Gap Between Items', 'borderless' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'default' => [
						'size' => 10,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-features ul li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'borderless_elementor_pricing_table_features_divider' => '',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_features_divider',
				[
					'label' => esc_html__( 'Show Item Dividers', 'borderless' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'borderless' ),
					'label_off' => esc_html__( 'No', 'borderless' ),
					'return_value' => 'yes',
					'default' => 'no',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_features_divider_thickness',
				[
					'label' => esc_html__( 'Divider Thickness', 'borderless' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'default' => [
						'size' => 1,
						'unit' => 'px',
					],
					'condition' => [
						'borderless_elementor_pricing_table_features_divider' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-features ul li:not(:last-child)' => 'border-bottom-style: solid; border-bottom-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_features_divider_gap',
				[
					'label' => esc_html__( 'Divider Gap', 'borderless' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'default' => [
						'size' => 10,
						'unit' => 'px',
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-features ul li:not(:last-child)' => 'padding-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .pricing-features ul li:not(:first-child)' => 'padding-top: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'borderless_elementor_pricing_table_features_divider' => 'yes',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_features_divider_color',
				[
					'label' => esc_html__( 'Divider Color', 'borderless' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#eaeaea',
					'condition' => [
						'borderless_elementor_pricing_table_features_divider' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-features ul li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_features_padding',
				[
					'label' => esc_html__( 'Padding', 'borderless' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .pricing-features' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		// DESCRIPTION (Style Tab) - Description style settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_description_style',
			[
				'label' => esc_html__( 'Description', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_description_position',
				[
					'label' => esc_html__( 'Position', 'borderless' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'borderless' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'borderless' ),
							'icon' => 'eicon-h-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'borderless' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-description' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_description_color',
				[
					'label'     => esc_html__( 'Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#555555',
					'selectors' => [
						'{{WRAPPER}} .pricing-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_description_typography',
					'label'    => esc_html__( 'Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-description',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_description_padding',
				[
					'label' => esc_html__( 'Padding', 'borderless' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'default' => [
						'top'    => 0,
						'right'  => 0,
						'bottom' => 0,
						'left'   => 0,
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		$this->end_controls_section();

		// BUTTON (Style Tab) - Button style settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_button_style',
			[
				'label' => esc_html__( 'Button', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_button_position',
				[
					'label' => esc_html__( 'Position', 'borderless' ),
					'type' => Controls_Manager::CHOOSE,
					'default' => 'left',
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'borderless' ),
							'icon' => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'borderless' ),
							'icon' => 'eicon-h-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'borderless' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-footer' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_button_typography',
					'label'    => esc_html__( 'Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-button',
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_button_text_shadow',
					'label'    => __( 'Text Shadow', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-button',
				]
			);
			$this->start_controls_tabs( 'borderless_elementor_pricing_table_button_color_tabs' );

			// Tab Normal
			$this->start_controls_tab(
				'borderless_elementor_pricing_table_button_normal',
				[
					'label' => esc_html__( 'Normal', 'borderless' ),
				]
			);
				$this->add_control(
					'borderless_elementor_pricing_table_button_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'borderless' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .pricing-button' => 'color: {{VALUE}};',
							'{{WRAPPER}} .button-icon'    => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'borderless_elementor_pricing_table_button_background_color',
					[
						'label'     => esc_html__( 'Background Color', 'borderless' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .pricing-button' => 'background-color: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();

			// Tab Hover
			$this->start_controls_tab(
				'borderless_elementor_pricing_table_button_hover',
				[
					'label' => esc_html__( 'Hover', 'borderless' ),
				]
			);
				$this->add_control(
					'borderless_elementor_pricing_table_button_text_color_hover',
					[
						'label'     => esc_html__( 'Text Color', 'borderless' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#ffffff',
						'selectors' => [
							'{{WRAPPER}} .pricing-button:hover'          => 'color: {{VALUE}};',
							'{{WRAPPER}} .pricing-button:hover .button-icon' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'borderless_elementor_pricing_table_button_background_color_hover',
					[
						'label'     => esc_html__( 'Background Color', 'borderless' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#000000',
						'selectors' => [
							'{{WRAPPER}} .pricing-button:hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'borderless_elementor_pricing_table_button_border_color_hover',
					[
						'label'     => esc_html__( 'Border Color', 'borderless' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '#cccccc',
						'selectors' => [
							'{{WRAPPER}} .pricing-button:hover' => 'border-color: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();

		$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_button_border',
					'label'    => esc_html__( 'Border', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-button',
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'borderless' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'default'    => [
						'size' => 6,
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .pricing-button' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_button_padding',
				[
					'label'      => esc_html__( 'Padding', 'borderless' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'default'    => [
						'top'      => 10,
						'right'    => 24,
						'bottom'   => 10,
						'left'     => 24,
						'isLinked' => false,
					],
					'selectors'  => [
						'{{WRAPPER}} .pricing-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_button_margin',
				[
					'label'      => esc_html__( 'Margin', 'borderless' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .pricing-footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'borderless_elementor_pricing_table_button_icon_size',
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
				'borderless_elementor_pricing_table_button_full_width',
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

		// RIBBON / BADGE (Style Tab) - Ribbon style settings
		$this->start_controls_section(
			'borderless_elementor_pricing_table_ribbon_style',
			[
				'label' => esc_html__( 'Ribbon / Badge', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
			$this->add_control(
				'borderless_elementor_pricing_table_ribbon_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffffff',
					'selectors' => [
						'{{WRAPPER}} .pricing-ribbon' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'borderless_elementor_pricing_table_ribbon_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#e74c3c',
					'selectors' => [
						'{{WRAPPER}} .pricing-ribbon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_pricing_table_ribbon_typography',
					'label'    => esc_html__( 'Typography', 'borderless' ),
					'selector' => '{{WRAPPER}} .pricing-ribbon',
				]
			);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Build Pricing HTML based on sale enabled or not
		if ( 'yes' === $settings['borderless_elementor_pricing_table_on_sale'] && ! empty( $settings['borderless_elementor_pricing_table_sale_price'] ) ) {
			$price_html = '<div class="original-price"><span class="currency-symbol">' . esc_html( $settings['borderless_elementor_pricing_table_currency'] ) . '</span><span class="price-value">' . esc_html( $settings['borderless_elementor_pricing_table_price'] ) . '</span></div>';
			$price_html .= '<span class="sale-price"><span class="currency-symbol">' . esc_html( $settings['borderless_elementor_pricing_table_currency'] ) . '</span><span class="price-value">' . esc_html( $settings['borderless_elementor_pricing_table_sale_price'] ) . '</span></span>';
		} else {
			$price_html = '<span class="price"><span class="currency-symbol">' . esc_html( $settings['borderless_elementor_pricing_table_currency'] ) . '</span><span class="price-value">' . esc_html( $settings['borderless_elementor_pricing_table_price'] ) . '</span></span>';
		}
		$price_block_html = '<div class="pricing-price">' . $price_html . '<span class="price-period">' . esc_html( $settings['borderless_elementor_pricing_table_period'] ) . '</span></div>';

		// Build Header HTML
		$header_html = '<div class="pricing-header">';
		if ( 'before_title' === $settings['borderless_elementor_pricing_table_icon_position'] ) {
			$header_html .= '<div class="pricing-media">';
			if ( 'icon' === $settings['borderless_elementor_pricing_table_media_type'] ) {
				ob_start();
				Icons_Manager::render_icon( $settings['borderless_elementor_pricing_table_icon'], [ 'aria-hidden' => 'true' ] );
				$header_html .= ob_get_clean();
			} else {
				$header_html .= '<img src="' . esc_url( $settings['borderless_elementor_pricing_table_image']['url'] ) . '" alt="">';
			}
			$header_html .= '</div>';
		}
		$header_html .= '<h2 class="pricing-title">' . esc_html( $settings['borderless_elementor_pricing_table_title'] ) . '</h2>';
		if ( ! empty( $settings['borderless_elementor_pricing_table_subtitle'] ) ) {
			$header_html .= '<span class="pricing-subtitle">' . esc_html( $settings['borderless_elementor_pricing_table_subtitle'] ) . '</span>';
		}
		if ( 'after_title' === $settings['borderless_elementor_pricing_table_icon_position'] ) {
			$header_html .= '<div class="pricing-media">';
			if ( 'icon' === $settings['borderless_elementor_pricing_table_media_type'] ) {
				ob_start();
				Icons_Manager::render_icon( $settings['borderless_elementor_pricing_table_icon'], [ 'aria-hidden' => 'true' ] );
				$header_html .= ob_get_clean();
			} else {
				$header_html .= '<img src="' . esc_url( $settings['borderless_elementor_pricing_table_image']['url'] ) . '" alt="">';
			}
			$header_html .= '</div>';
		}
		$header_html .= '</div>';

		// Build Features HTML
		$features_html = '<div class="pricing-features">';
		$features_html .= '<h3 class="features-title">' . esc_html( $settings['borderless_elementor_pricing_table_features_title'] ) . '</h3>';
		$features_html .= '<ul>';
		if ( ! empty( $settings['borderless_elementor_pricing_table_features_list'] ) ) {
			foreach ( $settings['borderless_elementor_pricing_table_features_list'] as $item ) {
				$tooltip = '';
				if ( 'yes' === $item['borderless_elementor_pricing_table_feature_tooltip'] && ! empty( $item['borderless_elementor_pricing_table_feature_tooltip_text'] ) ) {
					$tooltip = ' title="' . esc_attr( $item['borderless_elementor_pricing_table_feature_tooltip_text'] ) . '"';
				}
				$features_html .= '<li' . $tooltip . '>';
				ob_start();
				Icons_Manager::render_icon( $item['borderless_elementor_pricing_table_feature_icon'], [ 'aria-hidden' => 'true' ] );
				$features_html .= ob_get_clean();
				$features_html .= ' ' . esc_html( $item['borderless_elementor_pricing_table_feature_text'] );
				$features_html .= '</li>';
			}
		}
		$features_html .= '</ul></div>';

		// Build Button HTML
		$button_html  = '<div class="pricing-footer">';
		$button_class = 'pricing-button';
		if ( 'yes' === $settings['borderless_elementor_pricing_table_button_full_width'] ) {
			$button_class .= ' full-width-button';
		}
		$button_html .= '<a href="' . esc_url( $settings['borderless_elementor_pricing_table_button_link']['url'] ) . '" class="' . esc_attr( $button_class ) . '">';
		$button_html .= '<span class="button-content" style="display: inline-flex; align-items: center;">';
		if ( 'left' === $settings['borderless_elementor_pricing_table_button_icon_alignment'] ) {
			$button_html .= '<span class="button-icon" style="margin-right: 8px;">';
			ob_start();
			Icons_Manager::render_icon( $settings['borderless_elementor_pricing_table_button_icon'], [ 'aria-hidden' => 'true' ] );
			$button_html .= ob_get_clean();
			$button_html .= '</span>';
		}
		$button_html .= '<span class="button-text">' . esc_html( $settings['borderless_elementor_pricing_table_button_text'] ) . '</span>';
		if ( 'right' === $settings['borderless_elementor_pricing_table_button_icon_alignment'] ) {
			$button_html .= '<span class="button-icon" style="margin-left: 8px;">';
			ob_start();
			Icons_Manager::render_icon( $settings['borderless_elementor_pricing_table_button_icon'], [ 'aria-hidden' => 'true' ] );
			$button_html .= ob_get_clean();
			$button_html .= '</span>';
		}
		$button_html .= '</span></a></div>';

		// Assemble Blocks based on user defined order
		$blocks = [
			[
				'order' => $settings['borderless_elementor_pricing_table_header_order'],
				'html'  => $header_html,
			],
			[
				'order' => $settings['borderless_elementor_pricing_table_price_order'],
				'html'  => $price_block_html,
			],
			[
				'order' => $settings['borderless_elementor_pricing_table_features_order'],
				'html'  => $features_html,
			],
		];

		if ( 'yes' === $settings['borderless_elementor_pricing_table_description_enable'] ) {
			$description_html = '<div class="pricing-description">' . wp_kses_post( $settings['borderless_elementor_pricing_table_description'] ) . '</div>';
			$blocks[] = [
				'order' => $settings['borderless_elementor_pricing_table_description_order'],
				'html'  => $description_html,
			];
		}

		$blocks[] = [
			'order' => $settings['borderless_elementor_pricing_table_button_order'],
			'html'  => $button_html,
		];

		usort( $blocks, function( $a, $b ) {
			return $a['order'] - $b['order'];
		});

		$ribbon_class = '';
		if ( 'yes' === $settings['borderless_elementor_pricing_table_featured'] ) {
			$ribbon_class = ' pricing-featured ' . esc_attr( $settings['borderless_elementor_pricing_table_ribbon_style'] );
		}

		echo '<div class="borderless-pricing-table' . $ribbon_class . '" style="text-align: left;">';
		foreach ( $blocks as $block ) {
			echo $block['html'];
		}
		if ( 'yes' === $settings['borderless_elementor_pricing_table_featured'] ) {
			echo '<div class="pricing-ribbon">' . esc_html( $settings['borderless_elementor_pricing_table_ribbon_text'] ) . '</div>';
		}
		echo '</div>';
	}
}
?>

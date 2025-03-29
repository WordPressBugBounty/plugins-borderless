<?php

namespace Borderless\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use \Elementor\Repeater;
use Elementor\Utils;

class Marquee_Text extends Widget_Base {

	public function get_name() {
		return 'borderless-elementor-marquee-text';
	}

	public function get_title() {
		return 'Marquee Text';
	}

	public function get_icon() {
		return 'borderless-icon-marquee-text';
	}

	public function get_categories() {
		return [ 'borderless' ];
	}

	public function get_style_depends() {
		return [ 'elementor-widget-marquee-text' ];
	}

	public function get_script_depends() {
		return [ 'borderless-elementor-marquee-script' ];
	}

	protected function _register_controls() {

		/*-----------------------------------------------------------------------------------*/
		/*  Marquee Text - Content
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'borderless_elementor_section_marquee_text_content',
			[
				'label' => esc_html__( 'Content', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'borderless_elementor_marquee_text_content_type',
				[
					'label'   => esc_html__( 'Content Type', 'borderless' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'editor',
					'options' => [
						'editor' => esc_html__( 'Editor', 'borderless' ),
						'image'  => esc_html__( 'Image', 'borderless' ),
						'icon'   => esc_html__( 'Icon', 'borderless' ),
					],
				]
			);

			$repeater->add_control(
				'borderless_elementor_marquee_text_editor_content',
				[
					'label'     => esc_html__( 'Editor Content', 'borderless' ),
					'type'      => Controls_Manager::WYSIWYG,
					'default'   => '',
					'condition' => [
						'borderless_elementor_marquee_text_content_type' => 'editor',
					],
				]
			);

			$repeater->add_control(
				'borderless_elementor_marquee_text_image_content',
				[
					'label'     => esc_html__( 'Image', 'borderless' ),
					'type'      => Controls_Manager::MEDIA,
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'borderless_elementor_marquee_text_content_type' => 'image',
					],
				]
			);

			$repeater->add_control(
				'borderless_elementor_marquee_text_image_resolution',
				[
					'label'     => esc_html__( 'Image Resolution', 'borderless' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'full',
					'options'   => [
						'full'      => esc_html__( 'Full', 'borderless' ),
						'thumbnail' => esc_html__( 'Thumbnail', 'borderless' ),
						'medium'    => esc_html__( 'Medium', 'borderless' ),
						'large'     => esc_html__( 'Large', 'borderless' ),
					],
					'condition' => [
						'borderless_elementor_marquee_text_content_type' => 'image',
					],
				]
			);

			$repeater->add_control(
				'borderless_elementor_marquee_text_image_link',
				[
					'label'       => esc_html__( 'Link', 'borderless' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'borderless' ),
					'default'     => [
						'url' => '',
					],
					'condition'   => [
						'borderless_elementor_marquee_text_content_type' => 'image',
					],
				]
			);

			$repeater->add_control(
				'borderless_elementor_marquee_text_icon_content',
				[
					'label'     => esc_html__( 'Icon', 'borderless' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => [
						'value'   => '',
						'library' => 'fa-solid',
					],
					'condition' => [
						'borderless_elementor_marquee_text_content_type' => 'icon',
					],
				]
			);
			
			$repeater->add_control(
				'borderless_elementor_marquee_text_icon_link',
				[
					'label'       => esc_html__( 'Link', 'borderless' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'borderless' ),
					'default'     => [
						'url' => '',
					],
					'condition'   => [
						'borderless_elementor_marquee_text_content_type' => 'icon',
					],
				]
			);

			$this->add_control(
				'borderless_elementor_marquee_item_strings',
				[
					'type'        => Controls_Manager::REPEATER,
					'show_label'  => true,
					'fields'      => $repeater->get_controls(),
					'title_field' => '{{ borderless_elementor_marquee_text_content_type }}',
					'default'     => [
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #1', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #2', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #3', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #4', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #5', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #6', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #7', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #8', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #9', 'borderless' ),
						],
						[
							'borderless_elementor_marquee_text_content_type'   => 'editor',
							'borderless_elementor_marquee_text_editor_content' => esc_html__( 'Item #10', 'borderless' ),
						],
					],
				]
			);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  Marquee Text/Settings - Content (Settings Tab)
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'borderless_elementor_section_marquee_text_settings',
			[
				'label' => esc_html__( 'Settings', 'borderless' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_start_visible',
				[
					'label'        => __( 'Start Visible', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'true',
					'default'      => 'true',
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_pause_on_hover',
				[
					'label'        => __( 'Pause On Hover', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'true',
					'default'      => 'false',
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_duplicated',
				[
					'label'        => __( 'Duplicated', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'true',
					'default'      => 'true',
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_number_of_duplicates',
				[
					'label'   => __( 'Number Of Duplicates', 'borderless' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 1,
					'max'     => 10,
					'step'    => 1,
					'default' => 2,
					'condition' => [
						'borderless_elementor_marquee_text_duplicated' => 'true',
					],
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_gap_between_duplicates',
				[
					'label'     => __( 'Gap Between Duplicates', 'borderless' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'max'       => 99999,
					'step'      => 1,
					'default'   => 24,
					'condition' => [
						'borderless_elementor_marquee_text_duplicated' => 'true',
					],
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_direction',
				[
					'label'   => __( 'Direction', 'borderless' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'left',
					'options' => [
						'left'  => __( 'Left', 'borderless' ),
						'right' => __( 'Right', 'borderless' ),
					],
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_duration',
				[
					'label'   => __( 'Duration', 'borderless' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 100,
					'max'     => 100000,
					'step'    => 100,
					'default' => 5000,
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_delay_before_start',
				[
					'label'   => __( 'Delay Before Start', 'borderless' ),
					'type'    => Controls_Manager::NUMBER,
					'min'     => 0,
					'max'     => 99999,
					'step'    => 1,
					'default' => 0,
				]
			);
			
			$this->add_control(
				'borderless_elementor_marquee_text_divider_enable',
				[
					'label'        => __( 'Enable Divider', 'borderless' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Yes', 'borderless' ),
					'label_off'    => __( 'No', 'borderless' ),
					'return_value' => 'true',
					'default'      => 'false',
				]
			);

			$this->add_control(
				'borderless_elementor_marquee_text_divider_icon',
				[
					'label'     => __( 'Divider Icon', 'borderless' ),
					'type'      => Controls_Manager::ICONS,
					'default'   => [
						'value'   => '',
						'library' => 'fa-solid',
					],
					'condition' => [
						'borderless_elementor_marquee_text_divider_enable' => 'true',
					],
				]
			);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  General - Style
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'borderless_elementor_section_general',
			[
				'label' => esc_html__( 'General', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_angle',
				[
					'label'      => esc_html__( 'Angle', 'borderless' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],
					'range'      => [
						'deg' => [
							'min' => -45,
							'max' => 45,
						],
					],
					'default'    => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors'  => [
						'{{WRAPPER}} .borderless-elementor-marquee-text' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_gap_between_items',
				[
					'label'     => __( 'Gap Between Items', 'borderless' ),
					'type'      => Controls_Manager::NUMBER,
					'min'       => 0,
					'max'       => 99999,
					'step'      => 1,
					'default'   => 24,
					'selectors' => [
						'{{WRAPPER}} .borderless-elementor-marquee-text .js-marquee' => 'gap: {{VALUE}}px',
					],
				]
			);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  Divider - Style
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'borderless_elementor_section_divider',
			[
				'label' => esc_html__( 'Divider', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_divider_icon_width',
				[
					'label'      => esc_html__( 'Width', 'borderless' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', '%', 'rem' ],
					'range'      => [
						'px'  => [
							'min' => 10,
							'max' => 100,
						],
						'em'  => [
							'min' => 1,
							'max' => 10,
						],
						'%'   => [
							'min' => 10,
							'max' => 100,
						],
						'rem' => [
							'min' => 1,
							'max' => 10,
						],
					],
					'default'    => [
						'size' => 16,
						'unit' => 'px',
					],
					'condition'  => [
						'borderless_elementor_marquee_text_divider_icon[value]!' => '',
					],
				]
			);

		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  Marquee Text - Item (Style Tab)
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section(
			'borderless_elementor_section_marquee_text_item',
			[
				'label' => esc_html__( 'Marquee Text Item', 'borderless' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'borderless_elementor_marquee_text_typography',
					'label'    => __( 'Typography', 'borderless' ),
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .borderless-elementor-marquee-text *',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'borderless_elementor_marquee_text_shadow',
					'label'    => __( 'Text Shadow', 'borderless' ),
					'selector' => '{{WRAPPER}} .borderless-elementor-marquee-text *',
				]
			);

			$this->add_control(
				'borderless_elementor_marquee_text_color',
				[
					'label'     => __( 'Color', 'borderless' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .borderless-elementor-marquee-text *' => 'color: {{VALUE}}; fill: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'borderless_elementor_marquee_text_background',
					'label'    => __( 'Background', 'borderless' ),
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .borderless-elementor-marquee-text .borderless-elementor-marquee-text-item',
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_padding',
				[
					'label'      => esc_html__( 'Padding', 'borderless' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%', 'rem' ],
					'selectors'  => [
						'{{WRAPPER}} .js-marquee .borderless-elementor-marquee-text-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_margin',
				[
					'label'      => esc_html__( 'Margin', 'borderless' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%', 'rem' ],
					'selectors'  => [
						'{{WRAPPER}} .js-marquee .borderless-elementor-marquee-text-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'borderless_elementor_marquee_text_border',
					'label'    => esc_html__( 'Border', 'borderless' ),
					'selector' => '{{WRAPPER}} .js-marquee .borderless-elementor-marquee-text-item',
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_radius',
				[
					'label'     => esc_html__( 'Border Radius', 'borderless' ),
					'type'      => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} .js-marquee .borderless-elementor-marquee-text-item' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'    => 'borderless_elementor_marquee_text_box_shadow',
					'exclude' => [
						'box_shadow_position',
					],
					'selector'=> '{{WRAPPER}} .js-marquee .borderless-elementor-marquee-text-item',
				]
			);
			
			$this->add_control(
				'borderless_elementor_marquee_text_icons_divider',
				[
					'label'     => esc_html__( 'Icons', 'borderless' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'borderless_elementor_marquee_text_icon_width',
				[
					'label'      => esc_html__( 'Width', 'borderless' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'em', '%', 'rem' ],
					'range'      => [
						'px'  => [
							'min' => 16,
							'max' => 320,
						],
						'em'  => [
							'min' => 1,
							'max' => 20,
						],
						'%'   => [
							'min' => 10,
							'max' => 100,
						],
						'rem' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'default'    => [
						'size' => 16,
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .borderless-elementor-marquee-text .icon' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'marquee-text', 'data-direction', $settings['borderless_elementor_marquee_text_direction'] );
		$this->add_render_attribute( 'marquee-text', 'data-duration', $settings['borderless_elementor_marquee_text_duration'] );
		$this->add_render_attribute( 'marquee-text', 'data-delayBeforeStart', $settings['borderless_elementor_marquee_text_delay_before_start'] );
		$this->add_render_attribute( 'marquee-text', 'data-gap', $settings['borderless_elementor_marquee_text_gap_between_duplicates'] );
		$this->add_render_attribute( 'marquee-text', 'data-startVisible', $settings['borderless_elementor_marquee_text_start_visible'] );
		$this->add_render_attribute( 'marquee-text', 'data-duplicated', $settings['borderless_elementor_marquee_text_duplicated'] );
		$this->add_render_attribute( 'marquee-text', 'data-duplicateCount', $settings['borderless_elementor_marquee_text_number_of_duplicates'] );
		$this->add_render_attribute( 'marquee-text', 'data-pauseOnHover', $settings['borderless_elementor_marquee_text_pause_on_hover'] );
		
		$divider = '';
		if ( ! empty( $settings['borderless_elementor_marquee_text_divider_enable'] ) && 'true' === $settings['borderless_elementor_marquee_text_divider_enable'] && ! empty( $settings['borderless_elementor_marquee_text_divider_icon']['value'] ) ) {
			$divider_style = '';
			if ( ! empty( $settings['borderless_elementor_marquee_text_divider_icon_width']['size'] ) ) {
				$divider_style .= 'width:' . $settings['borderless_elementor_marquee_text_divider_icon_width']['size'] . $settings['borderless_elementor_marquee_text_divider_icon_width']['unit'] . ';';
			}		
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['borderless_elementor_marquee_text_divider_icon'], [ 'aria-hidden' => 'true', 'style' => $divider_style ] );
			$divider = ob_get_clean();
		}

		?>

			<div class="borderless-elementor-marquee-text-widget">
				<div class="borderless-elementor-marquee-text">
					<div class="marquee" <?php echo $this->get_render_attribute_string( 'marquee-text' ); ?>>
						<?php
							$items = $settings['borderless_elementor_marquee_item_strings'];
							$count = count( $items );
							foreach ( $items as $index => $item ) {
								$output = '';
								switch( $item['borderless_elementor_marquee_text_content_type'] ) {
									case 'editor':
										$output = wp_kses_post( $item['borderless_elementor_marquee_text_editor_content'] );
										break;
									case 'image':
										if ( ! empty( $item['borderless_elementor_marquee_text_image_content']['id'] ) ) {
											$image = wp_get_attachment_image( $item['borderless_elementor_marquee_text_image_content']['id'], $item['borderless_elementor_marquee_text_image_resolution'] );
										} else {
											$image = '<img src="' . esc_url( $item['borderless_elementor_marquee_text_image_content']['url'] ) . '" alt="">';
										}
										if ( ! empty( $item['borderless_elementor_marquee_text_image_link']['url'] ) ) {
											$output = '<a href="' . esc_url( $item['borderless_elementor_marquee_text_image_link']['url'] ) . '" target="' . ( ! empty( $item['borderless_elementor_marquee_text_image_link']['is_external'] ) ? '_blank' : '_self' ) . '" rel="' . ( ! empty( $item['borderless_elementor_marquee_text_image_link']['nofollow'] ) ? 'nofollow' : '' ) . '">' . $image . '</a>';
										} else {
											$output = $image;
										}
										break;
									case 'icon':
										if ( ! empty( $item['borderless_elementor_marquee_text_icon_content']['value'] ) ) {
											$style = '';
											// Use global style settings for icon color, width and height
											if ( ! empty( $settings['borderless_elementor_marquee_text_icon_width']['size'] ) ) {
												$style .= 'width:' . $settings['borderless_elementor_marquee_text_icon_width']['size'] . $settings['borderless_elementor_marquee_text_icon_width']['unit'] . ';';
											}
											if ( ! empty( $settings['icon_height']['size'] ) ) {
												$style .= 'height:' . $settings['icon_height']['size'] . $settings['icon_height']['unit'] . ';';
											}
											$icon_attributes = [ 'aria-hidden' => 'true', 'class' => 'icon' ];
											if ( ! empty( $style ) ) {
												$icon_attributes['style'] = $style;
											}
											ob_start();
											\Elementor\Icons_Manager::render_icon( $item['borderless_elementor_marquee_text_icon_content'], $icon_attributes );
											$output = ob_get_clean();
											
											// Wrap with link if icon_link is set
											if ( ! empty( $item['borderless_elementor_marquee_text_icon_link']['url'] ) ) {
												$output = '<a href="' . esc_url( $item['borderless_elementor_marquee_text_icon_link']['url'] ) . '" target="' . ( ! empty( $item['borderless_elementor_marquee_text_icon_link']['is_external'] ) ? '_blank' : '_self' ) . '" rel="' . ( ! empty( $item['borderless_elementor_marquee_text_icon_link']['nofollow'] ) ? 'nofollow' : '' ) . '">' . $output . '</a>';
											}
										}
										break;
								}
								echo '<div class="borderless-elementor-marquee-text-item">' . $output . '</div>';
								
								if ( $index < $count - 1 && ! empty( $divider ) ) {
									echo '<div class="borderless-elementor-marquee-divider">' . $divider . '</div>';
								}
							}
						?>
					</div>
				</div>
			</div>

		<?php
	}

	protected function _content_template() {

    }
}

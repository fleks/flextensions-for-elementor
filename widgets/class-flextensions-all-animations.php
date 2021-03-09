<?php
/**
 * Flextensions_AllAnimations class.
 *
 * @category   Class
 * @package    Flextensions
 * @subpackage WordPress
 * @author     Felix Herzog
 * @copyright  2021 
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://github.com/fleks/flextensions-for-elementor,
 *             Flextensions for Elementor on GitHub)
 * @since      1.0.0
 * php version 7.1
 */

namespace Flextensions\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Color;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Flextensions_AllAnimations widget class.
 *
 * @since 1.0.0
 */
class Flextensions_AllAnimations extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'flextensions-all-animations', plugins_url( '/assets/css/flextensions-all-animations.css', FLEXTENSIONS ), array(), '1.0.0' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'flextensions-all-animations';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'All Animations', 'flextensions' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-expand-arrows-alt';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'flextensions-category' );
	}
	
	/**
	 * Enqueue styles.
	 */
	public function get_style_depends() {
		return array( 'flextensions-all-animations' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'flextensions' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'flextensions_aa_icon',
			[
				'label' => __( 'Icon', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'flextensions_aa_image',
			[
				'label' => __( 'Choose Image', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'flextensions_aa_thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);
		
		$this->add_control(
			'flextensions_animation_duration',
			[
				'label' => __( 'Animation Duration', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'animated-slow' => __( 'Slow', 'elementor' ),
					'' => __( 'Normal', 'elementor' ),
					'animated-fast' => __( 'Fast', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'flextensions_animation_delay',
			[
				'label' => __( 'Animation Delay', 'elementor' ) . ' (ms)',
				'type' => Controls_Manager::NUMBER,
				'default' => '0',
				'min' => 0,
				'step' => 100,
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dimensions',
			[
				'label' => __( 'Dimensions', 'flextensions' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 32,
				],
				'selectors' => [
					'{{WRAPPER}} i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'flextensions_aa_image!' => [],
				],
			]
		);

		$this->add_control(
			'margin',
			[
				'label' => __( 'Margin', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],	
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .flextensions-icon, {{WRAPPER}} .flextensions-image' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => __( 'Padding', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],	
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .flextensions-icon, {{WRAPPER}} .flextensions-image' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'box_width',
			[
				'label' => __( 'Box Width', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 50,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],	
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .flextensions-all-animations-hover-box' => 'flex-basis: {{SIZE}}{{UNIT}};',
				],
			]
		);			

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
			  'label' => __( 'Icon Style', 'elementor' ),
			  'tab' => Controls_Manager::TAB_STYLE,
			]
		  );
		  
		$this->add_control(
			'color',
			[
				'label' => __( 'Color', 'flextensions' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .flextensions-icon' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'label' => __( 'Shadow', 'flextensions' ),
				'selector' => '{{WRAPPER}} .flextensions-icon',
			]
		);	
			
			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'text_shadow_hover',
					'label' => __( 'Shadow Hover', 'flextensions' ),
					'selector' => '{{WRAPPER}} .flextensions-icon:hover',
					]
				);	
				
			$this->add_control(
				'hover_color',
				[
					'label' => __( 'Color Hover', 'flextensions' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#000000',
					'scheme' => [
						'type' => Color::get_type(),
						'value' => Color::COLOR_1,
					],
					'selectors' => [
						'{{WRAPPER}} .flextensions-icon:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->end_controls_section();

		}			  
			
			/**
			 * Render the widget output on the frontend.
			 *
			 * Written in PHP and used to generate the final HTML.
			 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo '<h1>Animations</h1><h2>Hover Animations</h2>';
		echo '<div class="flextensions-all-animations-hover-container">';
		foreach ( \Elementor\Control_Hover_Animation::get_animations() as $animation_class => $animation_name) {
			echo '<div class="flextensions-all-animations-hover-box"><h3 style="margin-top: 20px;">' . $animation_name . '</h3>
			<div class="flextensions-icon flextensions-image elementor-icon elementor-animation-' . $animation_class . '">';
			if ( $settings['flextensions_aa_image']['url'] != '' ) {
				echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'flextensions_aa_thumbnail', 'flextensions_aa_image' );
			} else {
				\Elementor\Icons_Manager::render_icon( $settings['flextensions_aa_icon'], [ 'aria-hidden' => 'true' ] );
			}
			echo '</div></div>';	
		}
		echo '</div>';
		echo '<h2>Entrance Animations</h2>';
		echo '<div class="flextensions-all-animations-motion-container">';
		foreach ( \Elementor\Control_Animation::get_animations() as $animations) {
			foreach ( $animations as $animation_class => $animation_name) {
			echo '<div style="text-align: center; margin-top: 20px;"><h3>' . $animation_name . '</h3></div>';
			echo '<div class="elementor-element elementor-invisible elementor-widget elementor-widget-image ' . $settings['flextensions_animation_duration'] . '" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;' . $animation_class . '&quot;, &quot;_animation_delay&quot;: ' . $settings['flextensions_animation_delay'] . '}" data-widget_type="image.default">
		<div class="elementor-widget-container">';
			if ( $settings['flextensions_aa_image']['url'] != '' ) {
				echo '<div class="flextensions-image elementor-image">' . 
					\Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'flextensions_aa_thumbnail', 'flextensions_aa_image' );
			} else {
				echo '<div class="flextensions-icon icon-elementor">';
				\Elementor\Icons_Manager::render_icon( $settings['flextensions_aa_icon'], [ 'aria-hidden' => 'true' ] );
			}
			echo '</div></div></div>';	
			}
		}
		echo '</div>';		
		//<i aria-hidden="true" class="elementor-icon "></i>
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		if ( settings.flextensions_aa_image != '' ) {
			var image = {
				id: settings.flextensions_aa_image.id,
				url: settings.flextensions_aa_image.url,
				size: settings.flextensions_aa_thumbnail_size,
				dimension: settings.flextensions_aa_thumbnail_custom_dimension,
				model: view.getEditModel()
			};
			var image_url = elementor.imagesManager.getImageUrl( image );
		#>
			<img src="{{{ image_url }}}" />
		<#
		} else {
		#>
			{{{ flextensions_aa_iconHTML.value }}}
		<#
		}
		#>
		<img src="{{{ image_url }}}" />	
		<?php
		//<i aria-hidden="true" class="elementor-icon {{ settings.icon_social }}"></i>
	}
}
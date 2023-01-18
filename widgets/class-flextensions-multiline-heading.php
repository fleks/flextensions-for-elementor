<?php
/**
 * Flextensions_MultilineHeading class.
 *
 * @category   Class
 * @package    Flextensions
 * @subpackage WordPress
 * @author     Felix Herzog
 * @copyright  2021 
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://github.com/fleks/flextensions-for-elementor,
 *             Flextensions for Elementor on GitHub)
 * @since      1.0.3
 * php version 7.2
 */

namespace Flextensions\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Flextensions_MultilineHeading widget class.
 *
 * @since 1.0.3
 */
class Flextensions_MultilineHeading extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	 public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		//wp_register_style( 'flextensions-multiline-heading', plugins_url( '/assets/css/flextensions-multiline-heading.css', FLEXTENSIONS ), array(), '1.0.0' );
		//wp_register_script( 'flextensions-multiline-heading', plugins_url( '/assets/js/flextensions-multiline-heading.js', FLEXTENSIONS ), array(), '1.0.0' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.3
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'flextensions-multiline-heading';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.3
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Multiline Heading', 'flextensions' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.3
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-heading';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.3
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
	 *//*
	public function get_style_depends() {
		return array( 'flextensions-multiline-heading' );
	}

    /**
	 * Enqueue scripts.
	 */ /*
	public function get_script_depends() {
		return array( 'flextensions-multiline-heading' );
	} */

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.3
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'heading', 'title', 'multi', 'multiline' ];
	}    

	/**
	 * Setting different types of titles
	 */
	private $title_types = ['topline', 'heading', 'subheading'];


	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.3
	 *
	 * @access protected
	 */
	protected function register_controls() {

		$title_types = $this->title_types;

		foreach( $this->title_types as $title_type ) {

		$this->start_controls_section(
			'section_' . $title_type,
			[
				'label' => __( ucfirst($title_type), 'flextensions' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			$title_type,
			[
				'label' => __( ucfirst($title_type), 'flextensions' ),
				'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Default ' . ucfirst($title_type), 'flextensions' ),
            ]
		);

		$this->add_control(
			$title_type . '_tag',
			[
				'label' => __( 'HTML Tag', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
                'condition' => [
                    $title_type . '!' => '',
                ],
			]
		);

		$this->add_responsive_control(
			$title_type . '_align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .' . $title_type => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .' . $title_type . '-container' => 'flex: 1 1 100%; display: flex;',
					'{{WRAPPER}} .elementor-widget-container' => 'display: flex; flex-direction: row; flex-wrap: wrap;',
				],
                'condition' => [
                    $title_type . '!' => '',
				],
			]
		);

        $this->add_responsive_control(
			$title_type . '_position',
			[
				'label' => __( 'Position', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-container' => 'justify-content: {{VALUE}};',
				],
                'condition' => [
                    $title_type . '!' => '',
                ],
			]
		);		

		$this->add_responsive_control(
			$title_type . '_width',
			[
				'label' => __( 'Width', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 90,
				],
				'selectors' => [
                    '{{WRAPPER}}' => '--' . $title_type . '-flex-basis: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .' . $title_type => 'flex: 0 0 {{SIZE}}{{UNIT}}',
				],
                'condition' => [
                    $title_type . '!' => '',
				],
			]
		);

        $this->add_responsive_control(
			$title_type . '_width_min',
			[
				'label' => __( 'Min Width', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 10,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 300,
				],
				'selectors' => [
					'{{WRAPPER}} .' . $title_type => 'min-width: {{SIZE}}{{UNIT}}',
				],
                'condition' => [
					$title_type . '!' => '',
                    $title_type . '_width[unit]' => '%',
                ]
			]
		);

        $this->add_responsive_control(
			$title_type . '_width_max',
			[
				'label' => __( 'Max Width', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 10,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .' . $title_type => 'max-width: {{SIZE}}{{UNIT}}',
				],
                'condition' => [
					$title_type . '!' => '',
                    $title_type . '_width[unit]' => '%',
                ]
			]
		);		

		$this->add_control(
			$title_type . '_wordwrap',
			[
				'label' => __( 'Word Wrap', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'No', 'flextensions' ),
				'label_off' => __( 'Yes', 'flextensions' ),
				'default' => 'yes',
                'selectors' => [
					'{{WRAPPER}} .' . $title_type => 'white-space: nowrap;',
				],
                'condition' => [
                    $title_type . '!' => '',
				],
			]
		);        
   
		$this->add_responsive_control(
			$title_type . '_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .' . $title_type => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => [
                    $title_type . '!' => '',
				],
			]
		);

		$this->add_responsive_control(
			$title_type . '_z_index',
			[
				'label' => __( 'Z-Index', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'selectors' => [
					'{{WRAPPER}} .' . $title_type => 'z-index: {{VALUE}};',
				],
                'condition' => [
                    $title_type . '!' => '',
				],
			]
		);
		$this->end_controls_section();
	}

	$this->start_controls_section(
		'section_container',
		[
			'label' => __( 'Container', 'elementor' ),
			'tab' => Controls_Manager::TAB_CONTENT,
		]
	);

	$this->add_control(
		'container_show',
		[
			'label' => __('Show Container', 'flextensions'),
			'type' => Controls_Manager::SWITCHER,
			'default' => '',
			'label_on'     => __( 'Yes', 'elementor' ),
			'label_off'    => __( 'No', 'elementor' ),
			'return_value' => 'yes',
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container div' => 'background-color: rgba(0, 0, 0, 0.1);'
			],
		]
	);

	$this->add_responsive_control(
		'container_align',
		[
			'label' => __( 'Alignment', 'elementor' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'0 auto 0 0' => [
					'title' => __( 'Left', 'elementor' ),
					'icon' => 'eicon-text-align-left',
				],
				'0 auto' => [
					'title' => __( 'Center', 'elementor' ),
					'icon' => 'eicon-text-align-center',
				],
				'0 0 0 auto' => [
					'title' => __( 'Right', 'elementor' ),
					'icon' => 'eicon-text-align-right',
				],
			],
			'default' => '0 auto',
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'margin: {{VALUE}}',
			],
		]
	);		

	$this->add_responsive_control(
		'container_width',
		[
			'label' => __( 'Width', 'flextensions' ),
			'type' => Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 2000,
					'step' => 10,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'default' => [
				'unit' => '%',
				'size' => 90,
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'width: {{SIZE}}{{UNIT}}',
			],
		]
	);

	$this->add_responsive_control(
		'container_width_min',
		[
			'label' => __( 'Min Width', 'flextensions' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vw' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 2000,
					'step' => 10,
				],
				'vw' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 320,
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'min-width: {{SIZE}}{{UNIT}}',
			],
			'condition' => [
				'container_width[size]!' => '',
				'container_width[unit]' => '%',
			]
		]
	);

	$this->add_responsive_control(
		'container_width_max',
		[
			'label' => __( 'Max Width', 'flextensions' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vw' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 2000,
					'step' => 10,
				],
				'vw' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => '',
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-widget-container' => 'max-width: {{SIZE}}{{UNIT}}',
			],
			'condition' => [
				'container_width[size]!' => '',
				'container_width[unit]' => '%',
			]
		]
	);

       $this->end_controls_section();
	   
	   foreach( $this->title_types as $title_type ) {

		$this->start_controls_section(
			'section_style_' . $title_type,
			[
				'label' => __( ucfirst($title_type), 'flextensions' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					$title_type . '!' => '',
				]
			]
		);

		$this->add_control(
			$title_type . '_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $title_type . '_typography',
				'selector' => '{{WRAPPER}} .' . $title_type . '-content',
			]
		);

		$this->start_controls_tabs( $title_type . '_shadow' );

		$this->start_controls_tab(
			$title_type . '_shadow_normal',
			[
				'label' => __( 'Shadow', 'elementor' ),
			]
		);
	
		$this->add_control(
			$title_type . '_text_border',
			[
				'label' => __( 'Text Border (px)', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => '0',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => 'text-shadow: -{{VALUE}}px -{{VALUE}}px {{' . $title_type . '_text_border_blur.VALUE}}px {{' . $title_type . '_text_border_color.VALUE}}, -{{VALUE}}px 0px {{' . $title_type . '_text_border_blur.VALUE}}px {{' . $title_type . '_text_border_color.VALUE}}, -{{VALUE}}px {{VALUE}}px {{' . $title_type . '_text_border_blur.VALUE}}px {{' . $title_type . '_text_border_color.VALUE}}, 0px -{{VALUE}}px {{' . $title_type . '_text_border_blur.VALUE}}px {{' . $title_type . '_text_border_color.VALUE}}, 0px {{VALUE}}px {{' . $title_type . '_text_border_blur.VALUE}}px {{' . $title_type . '_text_border_color.VALUE}}, {{VALUE}}px -{{VALUE}}px {{' . $title_type . '_text_border_blur.VALUE}}px {{' . $title_type . '_text_border_color.VALUE}}, {{VALUE}}px 0px {{' . $title_type . '_text_border_blur.VALUE}}px {{' . $title_type . '_text_border_color.VALUE}}, {{VALUE}}px {{VALUE}}px {{' . $title_type . '_text_border_blur.VALUE}}px {{' . $title_type . '_text_border_color.VALUE}};',
				],
			]
		);

		$this->add_control(
			$title_type . '_text_border_color',
			[
				'label' => __( 'Text Border Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0F0',
				'condition' => [
					$title_type . '_text_border!' => '',
				],
			]
		);

		$this->add_control(
			$title_type . '_text_border_blur',
			[
				'label' => __( 'Text Border Blur (px)', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => '0',
				'default' => 0,
				'condition' => [
					$title_type . '_text_border!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => $title_type . '_text_shadow',
				'selector' => '{{WRAPPER}} .' . $title_type . '-content',
				'condition' => [
					$title_type . '_text_border' => '',
				],			
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			$title_type . '_shadow_stroke',
			  [
				  'label' => __( 'Stroke', 'elementor' ),
			  ]
		);		

		$this->add_control(
			$title_type . '_text_stroke',
			[
				'label' => __( 'Text Stroke (px)', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => '0',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => '-webkit-text-stroke-width: {{VALUE}}px',
				],
			]
		);			
		
		$this->add_control(
			$title_type . '_text_stroke_color',
			[
				'label' => __( 'Text Stroke Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0F0',
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => '-webkit-text-stroke-color: {{VALUE}};',
				],				
				'condition' => [
					$title_type . '_text_stroke!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			$title_type . '_transform',
			[
				'label' => __( 'Transform', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'No', 'elementor' ),
				'label_off' => __( 'Yes', 'elementor' ),
				'default' => '',
			]
		);
					

		$this->add_responsive_control(
			$title_type . '_rotate',
			[
				'label' => __( 'Rotate', 'flextensions' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -180,
				'max' => 180,
				'default' => 0,
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => '--title-rotate: {{VALUE}}deg;',
				],	
				'condition' => [
					$title_type . '_transform' => 'yes',
                ],
			]
		);

		$this->add_responsive_control(
			$title_type . '_skew',
			[
				'label' => __( 'Skew', 'flextensions' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -90,
				'max' => 90,
				'default' => 0,
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => '--title-skew: {{VALUE}}deg;',
				],								
				'condition' => [
					$title_type . '_transform' => 'yes',
                ],
			]
		);

    	$this->add_responsive_control(
			$title_type . '_translateX',
			[
				'label' => __( 'Move', 'flextensions' ) . ' <i class="eicon-exchange" style="transform: rotate(90deg)"></i>',
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
					],					
				],
				'default' => [
					'unit' => 'px',
					'size' => '0',
				],
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => '--title-translateX: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$title_type . '_transform' => 'yes',
                ],
			]
		);

		$this->add_responsive_control(
			$title_type . '_translateY',
			[
				'label' => __( 'Move', 'flextensions' ) . ' <i class="eicon-exchange"></i>',
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'vh' => [
						'min' => -100,
						'max' => 100,
					],					
				],
				'default' => [
					'unit' => 'px',
					'size' => '0',
				],
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => '--title-translateY: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
					$title_type . '_transform' => 'yes',
                ],				
			]
		);		

        $this->add_responsive_control(
			$title_type . '_transform_origin',
			[
				'label' => __( 'Transform Anchor', 'flextensions' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'center',
				'toogle' => 'false',
				'selectors' => [
					'{{WRAPPER}} .' . $title_type . '-content' => 'transform-origin: {{VALUE}}; transform: rotate(var(--title-rotate, 0)) skewX(var(--title-skew, 0)) translateX(var(--title-translateX, 0)) translateY(var(--title-translateY, 0));',
				//	'(desktop){{WRAPPER}} .' . $title_type . '-content' => 'transform-origin: {{VALUE}}; transform: rotate({{' . $title_type . '_rotate.VALUE}}deg) skewX({{' . $title_type . '_skew.VALUE}}deg) translateX({{' . $title_type . '_translateX.SIZE}}{{' . $title_type . '_translateX.UNIT}}) translateY({{' . $title_type . '_translateY.SIZE}}{{' . $title_type . '_translateY.UNIT}})',
				//	'(tablet){{WRAPPER}} .' . $title_type . '-content' => 'transform-origin: {{VALUE}}; transform: rotate({{' . $title_type . '_rotate_tablet.VALUE || ' . $title_type . '_rotate.VALUE}}deg) skewX({{' . $title_type . '_skew_tablet.VALUE || ' . $title_type . '_skew.VALUE}}deg) translateX({{' . $title_type . '_translateX_tablet.SIZE || ' . $title_type . '_translateX.SIZE}}{{' . $title_type . '_translateX_tablet.UNIT || ' . $title_type . '_translateX.UNIT}}) translateY({{' . $title_type . '_translateY_tablet.SIZE || ' . $title_type . '_translateY.SIZE}}{{' . $title_type . '_translateY_tablet.UNIT || ' . $title_type . '_translateY.UNIT}})',
				//	'(mobile){{WRAPPER}} .' . $title_type . '-content' => 'transform-origin: {{VALUE}}; transform: rotate({{(' . $title_type . '_rotate_mobile.VALUE || ' . $title_type . '_rotate_tablet.VALUE) || ' . $title_type . '_rotate.VALUE }}deg);', // skewX({{' . $title_type . '_skew.VALUE}}deg) translateX({{' . $title_type . '_translateX.SIZE}}{{' . $title_type . '_translateX.UNIT}}) translateY({{' . $title_type . '_translateY.SIZE}}{{' . $title_type . '_translateY.UNIT}})',
				],
                'condition' => [
					$title_type . '_transform' => 'yes',
                ],
			]
		);				

		$this->end_controls_section();

		}
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.3
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
        
		$title_types = $this->title_types;

        foreach( $title_types as $type ) {
            $title = $settings[$type];
			$this->add_render_attribute( $type, 'class', $type . '-content' );

            if( ! empty( $title ) ) {
                $title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings[$type . '_tag'] ), $this->get_render_attribute_string( $type ), $title );
                echo '<div class="' . $type . '-container">';
                echo '<div class="' . $type . '_before"></div>';
                echo '<div class="' . $type . '">';
                echo $title_html;
                echo '</div>';            
                echo '<div class="' . $type . '_after"></div>';
                echo '</div>';
            }
        }
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.3
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
        <#
        var title_types = ['topline', 'heading', 'subheading'];

        _.each( title_types, function( type, index ) {
            var title = settings[ type ];
			view.addRenderAttribute( type, 'class', type + '-content' );
			view.addInlineEditingAttributes( type );
        
			var title_tag = type + '_tag';
            var headerSizeTag = elementor.helpers.validateHTMLTag( settings[ title_tag ] );
			title_html = '<' + headerSizeTag  + ' ' + view.getRenderAttributeString( type ) + '>' + title + '</' + headerSizeTag + '>'; #>
            <div class="{{ type }}-container">
            <div class="{{ type }}_before"></div>
            <div class="{{ type }}">
			<# print( title_html ); #>
            </div>
            <div class="{{ type }}_after"></div>
            </div>
		<# }); #>
    	<?php
	}
}

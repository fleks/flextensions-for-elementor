<?php
/**
 * Flextensions_FlexGallery class.
 *
 * @category   Class
 * @package    Flextensions
 * @subpackage WordPress
 * @author     Felix Herzog
 * @copyright  2021 
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       link(https://github.com/fleks/flextensions-for-elementor,
 *             Flextensions for Elementor on GitHub)
 * @since      1.0.2
 * php version 7.1
 */

namespace Flextensions\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Flextensions_FlexGallery widget class.
 *
 * @since 1.0.2
 */
class Flextensions_FlexGallery extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	 public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		wp_register_style( 'flextensions-flex-gallery', plugins_url( '/assets/css/flextensions-flex-gallery.css', FLEXTENSIONS ), array(), '1.0.0' );
		//wp_register_script( 'flextensions-flex-gallery', plugins_url( '/assets/js/flextensions-flex-gallery.js', FLEXTENSIONS ), array(), '1.0.0' );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.2
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'flextensions-flex-gallery';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.2
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Flex Gallery', 'flextensions' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.2
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-shape';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.2
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
		return array( 'flextensions-flex-gallery' );
	}

    /**
	 * Enqueue scripts.
	 */ /*
	public function get_script_depends() {
		return array( 'flextensions-flex-gallery' );
	} */

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'icon list', 'icon', 'list' ];
	}    

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.2
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'description',
			[
				'raw' => __( 'Optimized for four images', 'flextensions' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);		

        $repeater = new Repeater();

		$repeater->add_control(
			'title',
            [
				'label' => __( 'Title', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'List Item', 'elementor' ),
				'default' => __( 'List Item', 'elementor' ),
                'dynamic' => [
					'active' => true,
				],
			]
		);		

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		); 

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'include' => [],
				'default' => 'medium',
			]
		);		

		$repeater->add_responsive_control(
			'flex_basis',
			[
				'label' => __( 'Flex-Basis', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh', ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],					
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],                
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'display: flex; flex-basis: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $repeater->add_control(
			'text_align',
			[
				'label' => __( 'Alignment Horizontal', 'flextensions' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],                
				],
				'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'justify-content: {{VALUE}};',
                ],
			]
		);      
        
		$repeater->add_control(
			'vertical_align',
			[
				'label' => __( 'Alignment Vertical', 'flextensions' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Top', 'elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Middle', 'elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Bottom', 'elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'align-items: {{VALUE}};',
                ],
			]
		); 		

    	$repeater->add_responsive_control(
			'translateX',
			[
				'label' => __( 'TranslateX', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vw' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.1,
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
			]
		);

		$repeater->add_responsive_control(
			'translateY',
			[
				'label' => __( 'TranslateY', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vh' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.1,
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
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'transform: translate({{translateX.SIZE}}{{translateX.UNIT}}, {{SIZE}}{{UNIT}})',
				]
			]
		);

		$repeater->add_control(
			'link',
            [
				'label' => __( 'Link', 'elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'dynamic' => [
					'active' => true,
				],                
			]
		);

		$repeater->add_control(
			'css_class',
			[
				'label' => __( 'Link CSS Class', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'prefix_class' => '',
				'title' => __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'elementor' ),
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Images', 'elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' =>  __( 'Image Title', 'flextensions' ),
					],
	    		],
				'title_field' => '{{{ title }}}',
		    ]
		);		

        $this->end_controls_section();

		$this->start_controls_section(
			'section_flexbox',
			[
				'label' => __( 'Toolbox', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'width_max',
			[
				'label' => __( 'Container Max Width', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
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
				]
			]
		);
		
		$this->add_responsive_control(
			'height_max',
			[
				'label' => __( 'Container Max Height', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
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
					'{{WRAPPER}} .elementor-widget-container' => 'max-height: {{SIZE}}{{UNIT}}',
				]
			]
		);			

		$this->add_control(
			'flex_direction',
			[
				'label' => __( 'Alignment Vertical', 'flextensions' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => __( 'Row', 'elementor' ),
						'icon' => 'eicon-arrow-right',
					],
					'column' => [
						'title' => __( 'Column', 'elementor' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'row',
				'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'display: flex; flex-direction: {{VALUE}}; flex-wrap: wrap; justify-content: center;',
					'{{WRAPPER}} .elementor-widget-container div' => 'line-height: 0px;',
                ],
				'classes' => 'elementor-control-start-end',
				'prefix_class' => 'direction-'
			]
		);
		
		$this->add_responsive_control(
			'translate_all',
			[
				'label' => __( 'Translate All', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vh' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.1,
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
					'{{WRAPPER}} .elementor-widget-container div:nth-child(1)' => 'transform: translate( {{SIZE}}{{UNIT}}, {{SIZE}}{{UNIT}} )',
					'{{WRAPPER}} .elementor-widget-container div:nth-child(2)' => 'transform: translate( calc( {{SIZE}}{{UNIT}} * (-1) ), {{SIZE}}{{UNIT}} )',
					'{{WRAPPER}} .elementor-widget-container div:nth-child(3)' => 'transform: translate( {{SIZE}}{{UNIT}}, calc( {{SIZE}}{{UNIT}} * (-1) ) )',
					'{{WRAPPER}} .elementor-widget-container div:nth-child(4)' => 'transform: translate( calc( {{SIZE}}{{UNIT}} * (-1) ), calc( {{SIZE}}{{UNIT}} * (-1) ) )',
				]
			]
		);		

        $this->end_controls_section();

		$this->start_controls_section(
			'section_frame',
			[
				'label' => __( 'Frame', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->start_controls_tabs( 'colors' );

		$this->start_controls_tab(
			'colors_normal',
			[
				'label' => __( 'Normal', 'elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} img',
			]
		);		

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'elementor' ),
				'selector' => '{{WRAPPER}} img',
			]
		);	        

		$this->end_controls_tab();

		$this->start_controls_tab(
			  'colors_hover',
			  [
				  'label' => __( 'Hover', 'elementor' ),
			  ]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_hover',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} img:hover',
				'default' => '{{border_}}',
			]
		);			


		$this->add_control(
			'border_radius_hover',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} img:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

	    $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'label' => __( 'Box Shadow', 'elementor' ),
				'selector' => '{{WRAPPER}} img:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_section();        

		$this->start_controls_section(
			'dimension_section',
			[
			  'label' => __( 'Dimension', 'elementor' ),
			  'tab' => Controls_Manager::TAB_STYLE,
			]
		);
        
        $this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height Max', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1500,
						'step' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
                    '{{WRAPPER}} img' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => __( 'Width Max', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],                
				'selectors' => [
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

   	$this->add_responsive_control(
			'margin',
			[
				'label' => __( 'Margin', 'flextensions' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
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
					'em' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.1,
					],	
				],
				'default' => [
					'unit' => 'px',
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
		);        

		$this->end_controls_section();

		$this->start_controls_section(
			'animation_section',
			[
			  'label' => __( 'Animation', 'elementor' ),
			  'tab' => Controls_Manager::TAB_STYLE,
			]
		);
/*
		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        ); */

		$this->end_controls_section();

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.2
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['list'] ) {
			foreach (  $settings['list'] as $item ) {
				echo '<div class="elementor-repeater-item-' . $item['_id'] . '">';
				echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $item, 'image_size', 'image' );
				echo '</div>';
			}
		}
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.2
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<# _.each( settings.list, function( item ) {
		var image = {
			id: item.image.id,
			url: item.image.url,
			size: item.image_size,
			dimension: item.image_custom_dimension,
			model: view.getEditModel()
		};
		var image_url = elementor.imagesManager.getImageUrl( image );
		#>
		<div class="elementor-repeater-item-{{ item._id }}">
			<img src="{{{ image_url }}}" {{{ item.image_size }}}/>	
		</div>
		<# }); #>
	<?php
	}
}
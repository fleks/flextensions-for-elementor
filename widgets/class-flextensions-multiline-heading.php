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
 * php version 7.1
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

		wp_register_style( 'flextensions-multiline-heading', plugins_url( '/assets/css/flextensions-multiline-heading.css', FLEXTENSIONS ), array(), '1.0.0' );
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
	 */
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
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.3
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_topline',
			[
				'label' => __( 'Topline', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'topline',
			[
				'label' => __( 'Topline', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Default Topline', 'flextensions' ),
            ]
		);

		$this->add_control(
			'topline_tag',
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
                    'topline!' => '',
                ],
			]
		);

		$this->add_responsive_control(
			'topline_align',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .topline' => 'text-align: {{VALUE}};',
				],
                'condition' => [
                    'topline!' => '',
                ]
			]
		);

		$this->add_responsive_control(
			'topline_width',
			[
				'label' => __( 'Width', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 50,
				],
				'selectors' => [
                    '{{WRAPPER}}' => '--topline-flex-basis: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .topline' => 'flex: 0 0 {{SIZE}}{{UNIT}}',
				],
                'condition' => [
                    'topline!' => '',
                ]
			]
		);

        $this->add_responsive_control(
			'topline_width_min',
			[
				'label' => __( 'Min Width', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
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
					'unit' => 'px',
					'size' => 320,
				],
				'selectors' => [
					'{{WRAPPER}} .topline' => 'min-width: 0 0 {{SIZE}}{{UNIT}}',
				],
                'condition' => [
                    'topline_width[unit]' => '%',
                ]
			]
		);

		$this->add_control(
			'topline_wordwrap',
			[
				'label' => __( 'Word Wrap', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'No', 'flextensions' ),
				'label_off' => __( 'Yes', 'flextensions' ),
				'default' => 'yes',
                'selectors' => [
					'{{WRAPPER}} .topline' => 'white-space: nowrap;',
				],
			]
		);        

        $this->add_responsive_control(
			'topline_position',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .topline-container' => 'justify-content: {{VALUE}};',
				],
                'condition' => [
                    'topline!' => '',
                ],
			]
		);
        
		$this->add_responsive_control(
			'topline_margin',
			[
				'label' => __( 'Margin', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .topline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'topline_z_index',
			[
				'label' => __( 'Z-Index', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'selectors' => [
					'{{WRAPPER}} .topline' => 'z-index: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_heading',
			[
				'label' => __( 'Heading', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);        
        
        $this->add_control(
			'heading',
			[
				'label' => __( 'Heading', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Default Heading', 'flextensions' ),
				'separator' => 'before',
                'selectors' => [
                '{{WRAPPER}} .elementor-widget-container' => 'display: flex; flex-direction: row; flex-wrap: wrap; justify-content: {{VALUE}};',
                '{{WRAPPER}} .topline-container, {{WRAPPER}} .heading-container, {{WRAPPER}} .subheading-container' => 'flex: 1 1 100%; display: flex;',
                ],
            ]
		);

		$this->add_control(
			'heading_tag',
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
				'default' => 'h2',
            ]
        );

		$this->add_responsive_control(
			'heading_align',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_width',
			[
				'label' => __( 'Width', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 100,
				],
				'selectors' => [
                    '{{WRAPPER}}' => '--heading-flex-basis: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .heading' => 'flex: 0 0 {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_wordwrap',
			[
				'label' => __( 'Word Wrap', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'No', 'flextensions' ),
				'label_off' => __( 'Yes', 'flextensions' ),
				'default' => 'yes',
                'selectors' => [
					'{{WRAPPER}} .heading' => 'white-space: nowrap;',
				],
			]
		);             

		$this->add_responsive_control(
			'heading_position',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .heading-container' => 'justify-content: {{VALUE}};',
				],
                'condition' => [
                    'heading!' => '',
                ],
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_subheading',
			[
				'label' => __( 'Subheading', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);         

		$this->add_control(
			'subheading',
			[
				'label' => __( 'Subheading', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Default Subheading', 'flextensions' ),
				'separator' => 'before',
			]
		);
        
		$this->add_control(
			'subheading_tag',
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
				'default' => 'h4',
            ]
        );
    
		$this->add_responsive_control(
			'subheading_align',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .subheading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'subheading_width',
			[
				'label' => __( 'Width', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
					'size' => 50,
				],
				'selectors' => [
                    '{{WRAPPER}}' => '--subheading-flex-basis: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .subheading' => 'flex: 0 0 {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'subheading_wordwrap',
			[
				'label' => __( 'Word Wrap', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'No', 'flextensions' ),
				'label_off' => __( 'Yes', 'flextensions' ),
				'default' => 'yes',
                'selectors' => [
					'{{WRAPPER}} .subheading' => 'white-space: nowrap;',
				],
			]
		);            
        
		$this->add_responsive_control(
			'subheading_position',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .subheading-container' => 'justify-content: {{VALUE}};',
				],
                'condition' => [
                    'subheading!' => '',
                ],
			]
		);        

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style_topline',
			[
				'label' => __( 'Topline', 'elementor' ),
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
	
		$this->end_controls_tab();

		$this->start_controls_tab(
			  'colors_hover',
			  [
				  'label' => __( 'Hover', 'elementor' ),
			  ]
		);

		$this->end_controls_tab();

		$this->end_controls_section();
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
        
        $title_types = ['topline', 'heading', 'subheading'];
        foreach( $title_types as $type ) {
            $title = $settings[$type];
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
	protected function _content_template() {
		?>
        <#
        var title_types = ['topline', 'heading', 'subheading'];

        _.each( title_types, function( type, index ) {
            var title = settings[ type ];
            
            var title_tag = type + '_tag';
            var headerSizeTag = elementor.helpers.validateHTMLTag( settings[ title_tag ] ); #>
            <div class="{{ type }}-container">
            <div class="{{ type }}_before"></div>
            <div class="{{ type }}">
			<{{ headerSizeTag }}>{{{ title }}}<{{ headerSizeTag }}>
            </div>
            <div class="{{ type }}_after"></div>
            </div>
		<# }); #>
    	<?php
	}
}

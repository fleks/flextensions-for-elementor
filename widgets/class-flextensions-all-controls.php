<?php
/**
 * Flextensions_AllControls class.
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
 * php version 7.3
 */

namespace Flextensions\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined( 'ABSPATH' ) || die();

/**
 * Flextensions_AllControls widget class.
 *
 * @since 1.0.0
 */
class Flextensions_AllControls extends Widget_Base {
	/**
	 * Class constructor.
	 *
	 * @param array $data Widget data.
	 * @param array $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );

		// wp_register_style( 'flextensions-all-controls', plugins_url( '/assets/css/flextensions-all-controls.css', FLEXTENSIONS ), array(), '1.0.0' );
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
		return 'flextensions-all-controls';
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
		return __( 'All Controls', 'flextensions' );
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
		return 'fa fa-arrow-up';
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
		return array( 'flextensions-all-controls' );
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

		/**
		 * Heading Control
		 * https://developers.elementor.com/elementor-controls/heading-control/
		 */

		$this->add_control(
			'more_options',
			[
				'label' => __( 'Additional Options', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		/**
		 * Raw HTML Control
		 * https://developers.elementor.com/elementor-controls/raw-html-control/
		 */

		$this->add_control(
			'important_note',
			[
				'label' => __( 'Important Note', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'A very important message to show in the panel.', 'flextensions' ),
				'content_classes' => 'your-class',
			]
		);

		/**
		 * Button Control
		 * https://developers.elementor.com/elementor-controls/button-control/
		 */

		$this->add_control(
			'delete_content',
			[
				'label' => __( 'Delete Content', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'button_type' => 'success',
				'text' => __( 'Delete', 'flextensions' ),
				'event' => 'namespace:editor:delete',
			]
		);

		/**
		 * Divider Control
		 * https://developers.elementor.com/elementor-controls/divider-control/
		 */
		
		 $this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		/**
		 * Text Control
		 * https://developers.elementor.com/elementor-controls/text-control/
		 */

		$this->add_control(
			'widget_title',
			[
				'label' => __( 'Title', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'flextensions' ),
				'placeholder' => __( 'Type your title here', 'flextensions' ),
			]
		);

		/**
		 * Number Control
		 * https://developers.elementor.com/elementor-controls/number-control/
		 */

		$this->add_control(
			'price',
			[
				'label' => __( 'Price', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 100,
				'step' => 5,
				'default' => 10,
			]
		);

		/**
		 * Textarea Control
		 * https://developers.elementor.com/elementor-controls/textarea-control/
		 */

		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Default description', 'flextensions' ),
				'placeholder' => __( 'Type your description here', 'flextensions' ),
			]
		);

		/**
		 * WYSIWYG Control
		 * https://developers.elementor.com/elementor-controls/wysiwyg-control/
		 */

		$this->add_control(
			'item_description_wysiwyg',
			[
				'label' => __( 'Description', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Default description', 'flextensions' ),
				'placeholder' => __( 'Type your description here', 'flextensions' ),
			]
		);

		 /**
		 * Code Control
		 * https://developers.elementor.com/elementor-controls/code-control/
		 */

		$this->add_control(
			'custom_html',
			[
				'label' => __( 'Custom HTML', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::CODE,
				'language' => 'html',
				'rows' => 20,
			]
		);

		/**
		 * Hidden Control
		 * https://developers.elementor.com/elementor-controls/hidden-control/
		 */

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'Hidden Control',
			]
		);

		/**
		 * Switcher Control
		 * https://developers.elementor.com/elementor-controls/switcher-control/
		 */

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'flextensions' ),
				'label_off' => __( 'Hide', 'flextensions' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Default title', 'flextensions' ),
			]
		);

		/**
		 * Popover Toggle Control
		 * https://developers.elementor.com/elementor-controls/popover-toggle-control/
		 */

		$this->add_control(
			'border_popover_toggle',
			[
				'label' => __( 'Border', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'flextensions' ),
				'label_on' => __( 'Custom', 'flextensions' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		 /**
		 * Select Control
		 * https://developers.elementor.com/elementor-controls/select-control/
		 */

		$this->add_control(
			'border_style',
			[
				'label' => __( 'Border Style', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid'  => __( 'Solid', 'flextensions' ),
					'dashed' => __( 'Dashed', 'flextensions' ),
					'dotted' => __( 'Dotted', 'flextensions' ),
					'double' => __( 'Double', 'flextensions' ),
					'none' => __( 'None', 'flextensions' ),
				],
			]
		);

		/**
		 * Select2 Control
		 * https://developers.elementor.com/elementor-controls/select2-control/
		 */

		$this->add_control(
			'show_elements',
			[
				'label' => __( 'Show Elements', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => [
					'title'  => __( 'Title', 'flextensions' ),
					'description' => __( 'Description', 'flextensions' ),
					'button' => __( 'Button', 'flextensions' ),
				],
				'default' => [ 'title', 'description' ],
			]
		);

		 /**
		 * Choose Control
		 * https://developers.elementor.com/elementor-controls/choose-control/
		 */

		$this->add_control(
			'text_align',
			[
				'label' => __( 'Alignment', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'flextensions' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'flextensions' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'flextensions' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
			]
		);

		/**
		 * Color Control
		 * https://developers.elementor.com/elementor-controls/color-control/
		 */

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .title' => 'color: {{VALUE}}',
				],
			]
		);

		 /**
		 * Icon Control
		 * https://developers.elementor.com/elementor-controls/icon-control/
		 */

		$this->add_control(
			'icon_social',
			[
				'label' => __( 'Social Icon', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::ICON,
				'label_block' => true,
				'include' => [
					'fa fa-facebook',
					'fa fa-flickr',
					'fa fa-google-plus',
					'fa fa-instagram',
					'fa fa-linkedin',
					'fa fa-pinterest',
					'fa fa-reddit',
					'fa fa-twitch',
					'fa fa-twitter',
					'fa fa-vimeo',
					'fa fa-youtube',
				],
				'default' => 'fa fa-facebook',
			]
		);

		/**
		 * Font Control
		 * https://developers.elementor.com/elementor-controls/font-control/
		 */

		$this->add_control(
			'font_family',
			[
				'label' => __( 'Font Family', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::FONT,
				'default' => "'Open Sans', sans-serif",
				'selectors' => [
					'{{WRAPPER}} .title2' => 'font-family: {{VALUE}}',
				],
			]
		);

		 /**
		 * Date Time Control
		 * https://developers.elementor.com/elementor-controls/date-time-control/
		 */


		$this->add_control(
			'due_date',
			[
				'label' => __( 'Due Date', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
			]
		);

		/**
		 * Entrance Animation Control
		 * https://developers.elementor.com/elementor-controls/entrance-animation-control/
		 */

		$this->add_control(
			'flextensions_entrance_animation',
			[
				'label' => __( 'Entrance Animation', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
			]
		);

		 /**
		 * Hover Animation Control
		 * https://developers.elementor.com/elementor-controls/hover-animation-control/
		 */

		$this->add_control(
			'flextensions_hover_animation',
			[
				'label' => __( 'Hover Animation', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'prefix_class' => 'elementor-animation-',
			]
		);

		/**
		 * Gallery Control
		 * https://developers.elementor.com/elementor-controls/gallery-control/
		 */

		$this->add_control(
			'gallery',
			[
				'label' => __( 'Add Images', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		 /**
		 * Repeater Control
		 * https://developers.elementor.com/elementor-controls/repeater-control/
		 */

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'flextensions' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'List Content' , 'flextensions' ),
				'show_label' => false,
			]
		);

		$repeater->add_control(
			'list_color',
			[
				'label' => __( 'Color', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Repeater List', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => __( 'Title #1', 'flextensions' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'flextensions' ),
					],
					[
						'list_title' => __( 'Title #2', 'flextensions' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'flextensions' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);


		/**
		 * URL Control
		 * https://developers.elementor.com/elementor-controls/url-control/
		 */

		$this->add_control(
			'website_link',
			[
				'label' => __( 'Link', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'flextensions' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);


		 /**
		 * Media Control
		 * https://developers.elementor.com/elementor-controls/media-control/
		 */

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		/**
		 * Image Dimensions Control
		 * https://developers.elementor.com/elementor-controls/image-dimensions-control/
		 */

		$this->add_control(
			'custom_dimension',
			[
				'label' => __( 'Image Dimension', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::IMAGE_DIMENSIONS,
				'description' => __( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'flextensions' ),
				'default' => [
					'width' => '',
					'height' => '',
				],
			]
		);

		 /**
		 * Icons Control
		 * https://developers.elementor.com/elementor-controls/icons-control/
		 */

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		/**
		 * Slider Control
		 * https://developers.elementor.com/elementor-controls/slider-control/
		 */

		$this->add_control(
			'width',
			[
				'label' => __( 'Width', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
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
					'{{WRAPPER}} .box' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		 /**
		 * Dimensions Control
		 * https://developers.elementor.com/elementor-controls/dimensions-control/
		 */

		$this->add_control(
			'flextensions-margin',
			[
				'label' => __( 'Margin', 'flextensions' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .your-class' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		/**
		 * Typography Control
		 * https://developers.elementor.com/elementor-controls/typography-control/
		 */

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'flextensions' ),
				'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .text',
			]
		);

		 /**
		 * Text Shadow Control
		 * https://developers.elementor.com/elementor-controls/text-shadow-control/
		 */

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'label' => __( 'Text Shadow', 'flextensions' ),
				'selector' => '{{WRAPPER}} .wrapper',
			]
		);

		/**
		 * Box Shadow Control
		 * https://developers.elementor.com/elementor-controls/box-shadow-control/
		 */

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'flextensions' ),
				'selector' => '{{WRAPPER}} .wrapper2',
			]
		);

		/**
		 * Border Control
		 * https://developers.elementor.com/elementor-controls/border-control/
		 */

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'flextensions' ),
				'selector' => '{{WRAPPER}} .wrapper3',
			]
		);

		/**
		 * Background Control
		 * https://developers.elementor.com/elementor-controls/background-control/
		 */		 

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'flextensions' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .wrapper4',
			]
		);		 

		/**
		 * Image Size Control
		 * https://developers.elementor.com/elementor-controls/image-size-control/
		 */

		$this->add_control(
			'image3',
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
				'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 'custom' ],
				'include' => [],
				'default' => 'large',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
			  'label' => __( 'Style Section', 'flextensions' ),
			  'tab' => \Elementor\Controls_Manager::TAB_STYLE,
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
		echo '<h2>' . $settings['widget_title'] . '</h2>';
		echo '<span class="price">' . $settings['price'] . '</span>';
		echo '<p>' . $settings['item_description'] . '</p>';
		echo '<div class="description">' . $settings['item_description_wysiwyg'] . '</div>';
		echo $settings['custom_html'];
		echo $settings['view'];
		if ( 'yes' === $settings['show_title'] ) {
			echo '<h2>' . $settings['title'] . '</h2>';
		}		
		echo '<div style="border-style: ' . $settings['border_style'] . '">Blind Text</div>';		
		foreach ( $settings['show_elements'] as $element ) {
			echo '<div>' . $element . '</div>';
		}
		echo '<div style="text-align: ' . $settings['text_align'] . '">Blind Text</div>';
		echo '<h2 class="title" style="color: ' . $settings['title_color'] . '">Blind Text</h2>';
		echo '<i class="' . $settings['icon_social'] . '" aria-hidden="true"></i>';
		echo '<h2 class="title2" style="font-family: ' . $settings['font_family'] . '">Blind Text</h2>';
		$due_date = strtotime( $this->get_settings( 'due_date' ) );
		$due_date_in_days = $due_date / DAY_IN_SECONDS;
		echo '<p>' . sprintf( __( 'Something will happen in %s days.', 'flextensions' ), $due_date_in_days ) . '</p>';
		echo '<div class="' . $settings['flextensions_entrance_animation'] . '">entrance_animation</div>';
		echo '<div class="' . $settings['flextensions_hover_animation'] . '">hover_animation </div>';
		foreach ( $settings['gallery'] as $image ) {
			echo '<img src="' . $image['url'] . '">';
		}
		if ( $settings['list'] ) {
			echo '<dl>';
			foreach (  $settings['list'] as $item ) {
				echo '<dt class="elementor-repeater-item-' . $item['_id'] . '">' . $item['list_title'] . '</dt>';
				echo '<dd>' . $item['list_content'] . '</dd>';
			}
			echo '</dl>';
		}
		$target = $settings['website_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = $settings['website_link']['nofollow'] ? ' rel="nofollow"' : '';
		echo '<a href="' . $settings['website_link']['url'] . '"' . $target . $nofollow . '>Blind Text</a>';	
		// Get image URL
		echo '<img src="' . $settings['image']['url'] . '">';
		// Get image 'thumbnail' by ID
		echo wp_get_attachment_image( $settings['image']['id'], 'thumbnail' );
		// Get image HTML
		echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings );
		?>
		<div class="my-icon-wrapper">
			<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
		</div>
		<?php
		echo '<div class="box" style="width: ' . $settings['width']['size'] . $settings['width']['unit'] . '">Blind Text</div>';
		echo '<div class="your-class">Blind Text</div>';
		echo '<div class="text">Blind Text</div>';
		echo '<div class="wrapper">Blind Text</div>';
		echo '<div class="wrapper2">Blind Text</div>';
		echo '<div class="wrapper3">Blind Text</div>';
		echo '<div class="wrapper4">Blind Text</div>';
		echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image3' );
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
		#>
		<h2>{{{ settings.widget_title }}}</h2>
		<span class="price">{{{ settings.price}}}</span>
		<p>{{{ settings.item_description }}}</p>
		<div class="description">{{{ settings.item_description_wysiwyg }}}</div>
		{{{ settings.custom_html }}}
		{{{ settings.view }}}
		<# if ( 'yes' === settings.show_title ) { #>
			<h2>{{{ settings.title }}}</h2>
		<# } #>
		<div style="border-style: {{ settings.border_style }}">Blind Text</div>
		<# _.each( settings.show_elements, function( element ) { #>
			<div>{{{ element }}}</div>
		<# }); #>
		<div style="text-align: {{ settings.text_align }}">Blind Text</div>
		<h2 class="title" style="color: {{ settings.title_color }}">Blind Text</h2>
		<i class="{{ settings.icon_social }}" aria-hidden="true"></i>
		<h2 class="title2" style="font-family: {{ settings.font_family }}">Blind Text</h2>
		<#
		var due_date = new Date( settings.due_date ),
		    now_date = new Date(),
		    due_date_in_days = Math.floor( ( due_date - now_date ) / 86400000 ); // 86400000 milliseconds in one Day.
		#>
		<p>Something will happen in {{{ due_date_in_days }}} days. </p>
		<div class="{{ settings.flextensions_entrance_animation }}">entrance_animation</div>
		<div class="{{ settings.flextensions_hover_animation }}">hover_animation</div>
		<# _.each( settings.gallery, function( image ) { #>
			<img src="{{ image.url }}">
		<# }); #>
		<# if ( settings.list.length ) { #>
		<dl>
			<# _.each( settings.list, function( item ) { #>
				<dt class="elementor-repeater-item-{{ item._id }}">{{{ item.list_title }}}</dt>
				<dd>{{{ item.list_content }}}</dd>
			<# }); #>
			</dl>
		<# } #>
		<#
		var target = settings.website_link.is_external ? ' target="_blank"' : '';
		var nofollow = settings.website_link.nofollow ? ' rel="nofollow"' : '';
		#>
		<a href="{{ settings.website_link.url }}"{{ target }}{{ nofollow }}>Blind Text</a>
		<img src="{{ settings.image.url }}">
		<div class="my-icon-wrapper">
		<# /*	{{{ iconHTML.value }}} */#>
		</div>
		<div class="box" style="width: {{ settings.width.size }}{{ settings.width.unit }};">Blind Text</div>';
		<div class="your-class">Blind Text</div>
		<div class="text">Blind Text</div>
		<div class="wrapper">Blind Text</div>
		<div class="wrapper2">Blind Text</div>
		<div class="wrapper3">Blind Text</div>
		<div class="wrapper4">Blind Text</div>
		<#
		var image = {
			id: settings.image3.id,
			url: settings.image3.url,
			size: settings.thumbnail_size,
			dimension: settings.thumbnail_custom_dimension,
			model: view.getEditModel()
		};
		var image_url = elementor.imagesManager.getImageUrl( image );
		#>
		<img src="{{{ image_url }}}" />	
		<?php
	}
}

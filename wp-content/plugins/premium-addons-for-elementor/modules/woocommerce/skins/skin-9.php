<?php
/**
 * PA Skin 9
 *
 * @package PA
 */

namespace PremiumAddons\Modules\Woocommerce\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;


use PremiumAddons\Modules\Woocommerce\TemplateBlocks\Skin_Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

/**
 * Class Skin_9
 *
 * @property Products $parent
 */
class Skin_9 extends Skin_Base {

	/**
	 * Get ID.
	 *
	 * @since 4.7.0
	 * @access public
	 */
	public function get_id() {
		return 'grid-9';
	}

	/**
	 * Get title.
	 *
	 * @since 4.7.0
	 * @access public
	 */
	public function get_title() {
		return apply_filters( 'pa_pro_woo_skins', __( 'Skin 8 ( PRO )', 'premium-addons-for-elementor' ) );
	}

	/**
	 * Register control actions.
	 *
	 * @since 4.7.0
	 * @access protected
	 */
	protected function _register_controls_actions() {

		$papro_activated = apply_filters( 'papro_activated', false );

		if ( ! $papro_activated ) {
			return;
		}

		// Content Controls.
		add_action( 'elementor/element/premium-woo-products/section_pagination_options/after_section_end', array( $this, 'register_display_options_controls' ) );

		// Quick View Controls.
		add_action( 'elementor/element/premium-woo-products/section_pagination_options/after_section_end', array( $this, 'register_quick_view_controls' ) );

		// Image Style.
		add_action( 'elementor/element/premium-woo-products/section_image_style/after_section_end', array( $this, 'register_product_content_style' ) );

		// Product CTA Style.
		add_action( 'elementor/element/premium-woo-products/section_image_style/after_section_end', array( $this, 'register_product_cta_style' ) );

		// Product Featured Ribbon Style.
		add_action( 'elementor/element/premium-woo-products/section_image_style/after_section_end', array( $this, 'register_quick_style_controls' ), 30 );

		parent::_register_controls_actions();
	}

	/**
	 * Register content control section.
	 *
	 * @since 4.7.0
	 * @access public
	 */
	public function register_display_options_controls() {

		$this->start_controls_section(
			'section_content_field',
			array(
				'label' => __( 'Display Options', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'product_image',
			array(
				'label'   => __( 'Image', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'product_title',
			array(
				'label'   => __( 'Title', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'product_category',
			array(
				'label'   => __( 'Category', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'product_rating',
			array(
				'label'   => __( 'Rating', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_control(
			'product_price',
			array(
				'label'   => __( 'Price', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		// $this->add_control(
		// 'product_excerpt',
		// array(
		// 'label' => __( 'Excerpt', 'premium-addons-for-elementor' ),
		// 'type'  => Controls_Manager::SWITCHER,
		// )
		// );

		$this->add_control(
			'product_cta',
			array(
				'label'   => __( 'Add To Cart', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Product Content Style Controls.
	 *
	 * @since 4.7.0
	 * @access public
	 */
	public function register_product_content_style() {

		$this->start_controls_section(
			'section_product_style',
			array(
				'label' => __( 'Product', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'content_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .premium-woo-product-wrapper',
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woo-products-details-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Product CTA Style.
	 *
	 * @since 4.7.0
	 * @access protected
	 */
	public function register_product_cta_style() {

		$this->start_controls_section(
			'section_button_style',
			array(
				'label'     => __( 'Add To Cart', 'premium-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					$this->get_control_id( 'product_cta' ) => 'yes',
				),

			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cta_typography',
				'selector' => '{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
			)
		);

		$this->add_control(
			'cta_underline_color',
			array(
				'label'     => __( 'Underline Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button:after' => 'background: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'cta_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'cta_style_tabs' );

		$this->start_controls_tab(
			'cta_style_tab_normal',
			array(
				'label' => __( 'Normal', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'cta_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cta_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cta_shadow',
				'selector' => '{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cta_border',
				'selector' => '{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button',
			)
		);

		$this->add_control(
			'cta_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'cta_style_tab_hover',
			array(
				'label' => __( 'Hover', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'cta_color_hover',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'cta_background_hover',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .premium-woocommerce .premium-woo-products-details-wrap .premium-woo-atc-button .button:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'cta_shadow_hover',
				'selector' => '{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'cta_border_hover',
				'selector' => '{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button:hover',
			)
		);

		$this->add_control(
			'cta_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woo-products-details-wrap .premium-woo-atc-button .button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Register Quick View Controls.
	 *
	 * @since 4.7.0
	 * @access protected
	 */
	public function register_quick_view_controls() {

		$this->start_controls_section(
			'section_content_quick_view',
			array(
				'label' => __( 'Quick View', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'quick_view',
			array(
				'label'   => __( 'Enable Quick View', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Register Style Quick View Controls.
	 *
	 * @since 4.7.0
	 * @access public
	 */
	public function register_quick_style_controls() {

		$this->start_controls_section(
			'section_quick_view_style',
			array(
				'label'     => __( 'Quick View Button', 'premium-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					$this->get_control_id( 'quick_view' ) => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'qv_typography',
				'selector' => '{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
			)
		);

		$this->add_responsive_control(
			'qv_right',
			array(
				'label'      => __( 'Position', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woocommerce li:hover .premium-woo-qv-btn' => 'right: calc( -40px - {{SIZE}}px );',
				),
			)
		);

		$this->add_responsive_control(
			'qv_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'qv_style_tabs' );

		$this->start_controls_tab(
			'qv_style_tab_normal',
			array(
				'label' => __( 'Normal', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'qv_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'           => 'qv_background',
				'types'          => array( 'classic', 'gradient' ),
				'selector'       => '{{WRAPPER}} .premium-woocommerce.premium-woo-skin-grid-9 .premium-woo-product-wrapper .premium-woo-qv-btn',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'global' => array(
							'default' => Global_Colors::COLOR_SECONDARY,
						),
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'qv_shadow',
				'selector' => '{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'qv_border',
				'selector' => '{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn',
			)
		);

		$this->add_control(
			'qv_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'qv_style_tab_hover',
			array(
				'label' => __( 'Hover', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'qv_color_hover',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'qv_background_hover',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'qv_shadow_hover',
				'selector' => '{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'qv_border_hover',
				'selector' => '{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn:hover',
			)
		);

		$this->add_control(
			'qv_radius_hover',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-woocommerce .premium-woo-product-wrapper .premium-woo-qv-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render Main HTML.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	public function render() {

		$papro_activated = apply_filters( 'papro_activated', false );

		if ( ! $papro_activated ) { ?>
			<div class="premium-error-notice">
				<?php echo esc_html( __( 'This is a PRO skin. Please make sure you have Premium Addons Pro installed and activated.', 'premium-addons-for-elementor' ) ); ?>
			</div>
			<?php
		} else {

			$settings = $this->parent->get_settings();

			$skin = Skin_Init::get_instance( $this->get_id() );

			echo $skin->render( $this->get_id(), $settings, $this->parent->get_id() );
		}
	}
}

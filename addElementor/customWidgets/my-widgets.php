<?php
/**
 * Plugin base class
 *
 * @package Elementwoo
 */
namespace Elementwoo;

use Elementor\Plugin as Elementor;

defined( 'ABSPATH' ) || die();

class Base {

    const VERSION = '1.0.0';

    const MINIMUM_ELEMENTOR_VERSION = '1.0.0';

    const MINIMUM_PHP_VERSION = '5.4';

    private static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );
    }

    public function i18n() {
        load_plugin_textdomain( 'elementwoo' );
    }

    public function init() {
        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        if ( ! did_action( 'woocommerce_loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_woocommerce_missing' ] );
            return;
	      }

        $this->includes();

        // Register custom category
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_category' ] );

        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }


    public function add_category( $elements_manager ) {
        $elements_manager->add_category(
            'elementwoo',
            [
                'title' => __( 'Elementwoo', 'elementwoo' ),
                'icon' => 'fa fa-bars',
            ]
        );
    }


    public function admin_notice_missing_elementor() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementwoo' ),
            '<strong>' . esc_html__( 'Elementwoo', 'elementwoo' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementwoo' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function admin_notice_woocommerce_missing() {
        	        $message = sprintf(
            	        /* translators: 1: Plugin name 2: WooCommerce */
	            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementwoo' ),
	            '<strong>' . esc_html__( 'Elementwoo', 'elementwoo' ) . '</strong>',
	            '<strong>' . esc_html__( 'WooCommerce', 'elementwoo' ) . '</strong>'
	        );

	        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	    }


    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementwoo' ),
            '<strong>' . esc_html__( 'Elementwoo', 'elementwoo' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementwoo' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }


    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementwoo' ),
            '<strong>' . esc_html__( 'Elementwoo', 'elementwoo' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'elementwoo' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }


    public function init_widgets() {
        $widgets = [
            'widget1',
            'widget2',
        ];

        foreach ( $widgets as $widget ) {

            require( __DIR__ . '/widgets/'. $widget . '.php');
            $class_name = str_replace( '-', '_', $widget );
            $class_name = __NAMESPACE__ . '\Widgets\\' . $class_name;
            Elementor::instance()->widgets_manager->register_widget_type( new $class_name() );
        }
    }

    public function includes() {
        require(__DIR__ . '/inc/functions.php');
    }
}

<?php
/**
 * Plugin Name: Komodo Custom Team Element
 * Plugin URI: https://movuent.com
 * Description: This is a Custom team element for Komodo website based on Gentium Theme
 * Version: 1.0
 * Author: Alvin Novian
 * Author URI: http://movuent.com
 */

/**
 * Checking the set ups and the environment
 */

if( !function_exists('add_action') ) {
    // if WordPress not installed kill the page.
	die('WordPress not Installed');
}

if( !defined( 'ABSPATH' ) ) exit; // No access of directly access


define( 'KCTE_ADDONS_VERSION', '1.0.0' );
define( 'KCTE_ADDONS_URL', plugins_url('/', __FILE__ ) );


final class Elementor_Test_Extension {	
    /**
    * Plugin Version
    */
    const VERSION = '1.0.0';

   /**
    * Minimum Elementor Version
    */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

   /**
    * Minimum PHP Version

    * @var string Minimum PHP version required to run the plugin.
    */
    const MINIMUM_PHP_VERSION = '7.0';

   /**
    * Instance
    *
    * @access private
    * @static
    *
    * @var Elementor_Test_Extension The single instance of the class.
    */
    private static $_instance = null;

   /**
    * Instance
    *
    * Ensures only one instance of the class is loaded or can be loaded.
    *
    * @access public
    * @static
    *
    * @return Elementor_Test_Extension An instance of the class.
    */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;

    }

   /**
    * Constructor
    *
    * @access public
    */
    public function __construct() {

        add_action( 'plugins_loaded', [ $this, 'init' ] );
        add_action('elementor/frontend/after_register_scripts', array($this, 'kcte_register_scripts'));
        add_action( 'elementor/frontend/after_register_styles', array($this, 'kcte_register_styles'));
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'kcte_enqueue_styles'));

    }

   /**
    * Initialize the plugin
    *
    * Load the plugin only after Elementor (and other plugins) are loaded.
    * Checks for basic plugin requirements, if one check fail don't continue,
    * if all check have passed load the files required to run the plugin.
    *
    * Fired by `plugins_loaded` action hook.
    *
    * @access public
    */
    public function init() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
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

        // Add Plugin actions
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
        // add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
    }

    
    /**
    * Register all frontend stylesheets
    */
    public function kcte_register_styles(){
        wp_register_style('kcte_styles', KCTE_ADDONS_URL . 'assets/css/kcte-widget.css', array(), KCTE_ADDONS_VERSION, 'all');
    }


    /*
    * Enqueue all frontend stylesheets
    */
    public function kcte_enqueue_styles(){
        wp_enqueue_style('kcte_styles');
    }

    /**
     * Register all frontend scripts
     */
    public function kcte_register_scripts(){
        wp_register_script( 'kcte_widget', KCTE_ADDONS_URL . 'assets/js/kcte-widget.js', array( 'jquery', 'elementor-frontend' ), KCTE_ADDONS_VERSION, true );
        // wp_enqueue_scripts( 'kcte_scripts' );
    }

   /**
    * Admin notice
    *
    * Warning when the site doesn't have Elementor installed or activated.
    *
    * @access public
    */
    public function admin_notice_missing_main_plugin() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-test-extension' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

   /**
    * Admin notice
    *
    * Warning when the site doesn't have a minimum required Elementor version.
    *
    * @access public
    */
    public function admin_notice_minimum_elementor_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'elementor-test-extension' ) . '</strong>',
                self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

   /**
    * Admin notice
    *
    * Warning when the site doesn't have a minimum required PHP version.
    *
    * @access public
    */
    public function admin_notice_minimum_php_version() {

        if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

        $message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension' ),
            '<strong>' . esc_html__( 'Elementor Test Extension', 'elementor-test-extension' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'elementor-test-extension' ) . '</strong>',
                self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

    }

   /**
    * Init Widgets
    *
    * Include widgets files and register them
    *
    * @access public
    */
    public function init_widgets() {

        // Include Widget files
        require_once( __DIR__ . '/widgets/kcte-widget.php' );

        // Register widget
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Test_Widget() );

    }

    /**
     * Init Controls
     *
     * Include controls files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    // public function init_controls() {

    //     // Include Control files
    //     require_once( __DIR__ . '/controls/test-control.php' );

    //     // Register control
    //     \Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

    // }

}

Elementor_Test_Extension::instance();
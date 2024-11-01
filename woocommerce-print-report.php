<?php
/**
 * Plugin Name: WooCommerce Print Report
 * Description: Adds print link to the reports screen
 * Version: 1.1
 * Author: IQComputing
 * Author URI: http://www.iqcomputing.com/
 * License: GPL2
 */


defined( 'ABSPATH' ) or die( 'You cannot be here.' );


/**
 * Print Report Controller
 */
Class IQC_WC_Print_Report {
	
	
	/**
	 * Plugin Version
	 * 
	 * @var String
	 */
	public static $version = '1.1';
	
	
	/**------------------------------------------------------------------------------------------------ **/
	/**	:: Class Methods :: **/
	/**------------------------------------------------------------------------------------------------ **/
	/**
	 * Initialize Plugin
	 * Call the private function to add hooks and filters
	 * 
	 * @return void
	 */
	public static function initialization() {
		
		$class = new self();
		$class->action_hooks();
		
	}
	
	
	/**
	 * Check if we're currently viewing the reports screen
	 * 
	 * @return Boolean
	 */
	public function is_screen_reports() {
		
		$is_screen = false;
		
		if( ! function_exists( 'get_current_screen' ) ) {
			return $is_screen;
		}
		
		$screen 	= get_current_screen();
		$is_screen 	= ( is_a( $screen, 'WP_Screen' ) && 'woocommerce_page_wc-reports' === $screen->id );
		
		return $is_screen;
		
	}
	
	
	/**
	 * Add any necessary action hooks
	 * 
	 * @return void
	 */
	private function action_hooks() {
		
		// Is we're not viewing a reports screen, bail out
		if( ! $this->is_screen_reports() ) {
			return;
		}
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );
		
	}
	
	
	/**------------------------------------------------------------------------------------------------ **/
	/**	:: Action Hook Callbacks :: **/
	/**------------------------------------------------------------------------------------------------ **/
	/**
	 * Add necessary styles and scripts
	 * 
	 * @hooked admin_enqueue_scripts
	 * 
	 * @return void
	 */
	public function enqueue_styles_scripts() {
		
		// Enqueue CSS
		wp_enqueue_style( 'wcprb', plugins_url( 'assets/css/wcprb.css', __FILE__ ), false, self::$version. 'all' );
		
		// Enqueue Javascript
		wp_enqueue_script( 'html2canvas', plugins_url( 'assets/js/html2canvas.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'wcprb', plugins_url( 'assets/js/wcprb.js', __FILE__ ), array( 'jquery' ), self::$version, true );
		wp_localize_script( 'wcprb', 'wcprb', array(
			'labels' => array(
				'print' => esc_html__( 'Print Report' ),
			),
		) );
		
	}
	
	
} // END IQC_WC_Print_Report Class


/**
 * Initialize plugin
 * 
 * @return void
 */
function iqc_wc_print_report_init() {
	
	IQC_WC_Print_Report::initialization();
	
}
add_action( 'current_screen', 'iqc_wc_print_report_init' );
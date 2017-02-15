<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    A4sForms
 * @subpackage A4sForms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    A4sForms
 * @subpackage A4sForms/public
 * @author     Your Name <email@example.com>
 */
class A4sForms_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $a4sforms    The ID of this plugin.
	 */
	private $a4sforms;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $a4sforms       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $a4sforms, $version ) {

		$this->a4sforms = $a4sforms;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in A4sForms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The A4sForms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->a4sforms, plugin_dir_url( __FILE__ ) . 'css/a4sforms-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in A4sForms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The A4sForms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->a4sforms, plugin_dir_url( __FILE__ ) . 'js/a4sforms-public.js', array( 'jquery' ), $this->version, false );

	}

}

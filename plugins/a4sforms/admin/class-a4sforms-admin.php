<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    A4sForms
 * @subpackage A4sForms/admin
 * @author     Robertas Reiciunas <accesspc@gmail.com>
 */
class A4sForms_Admin {

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
	 * @param      string    $a4sforms       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $a4sforms, $version ) {

		$this->a4sforms = $a4sforms;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->a4sforms, plugin_dir_url( __FILE__ ) . 'css/a4sforms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->a4sforms, plugin_dir_url( __FILE__ ) . 'js/a4sforms-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	public function admin_menu_add() {
		add_menu_page(
			__('A4s', 'a4sforms'),
			__('A4s Forms', 'a4sforms'),
			'manage_options',
			'a4sforms',
			'A4sForms_Admin::admin_menu_page_general'
		);
		
		add_submenu_page(
			'a4sforms',
			__( 'A4s Forms', 'a4sforms' ),
			__( 'Forms', 'a4sforms' ),
			'manage_options',
			'a4sforms',
			'A4sForms_Admin::admin_menu_page_general'
		);
		
		add_submenu_page(
			'a4sforms',
			__( 'A4s Forms Settings', 'a4sforms' ),
			__( 'Settings', 'a4sforms' ),
			'manage_options',
			'a4sforms_settings',
			'A4sForms_Admin::admin_menu_page_settings'
			);
	}
	
	public function admin_menu_init() {
		register_setting('a4sforms_settings', 'a4sforms');
		
		add_settings_section(
			'a4sforms_settings_section',
			__('Settings section', 'a4sforms'),
			'A4sForms_Admin::settings_section_callback',
			'a4sforms_settings'
		);
		
		add_settings_field(
			'a4sforms_settings_field',
			__('Settings field', 'a4sforms'),
			'A4sForms_Admin::settings_field_callback',
			'a4sforms_settings',
			'a4sforms_settings_section'
		);
	}
	
	public function admin_menu_page_general() {
		?>
		<div class='a4sforms-page-general'>
			<form action='options.php' method='post'>
				<?php 
				settings_fields('a4sforms_settings');
				do_settings_sections('a4sforms_settings');
				submit_button();
				?>
			</form>
		</div>
		<?php
	}
	
	public function admin_menu_page_settings() {
		echo 'admin_menu_page_settings';
		echo '<pre>';
		print_r(get_post_types());
		echo '</pre>';
	}
	
	public function settings_field_callback() {
		echo 'settings_field_callback';
	}
	
	public function settings_section_callback() {
		echo 'settings_section_callback';
	}

}

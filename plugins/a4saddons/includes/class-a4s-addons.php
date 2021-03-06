<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    A4s_Addons
 * @subpackage A4s_Addons/includes
 * @author     robertas@reiciunas.lt
 */
class A4s_Addons {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      A4s_Addons_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $a4s_addons    The string used to uniquely identify this plugin.
	 */
	protected $a4s_addons;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($plugin_data = array()) {
		
		$this->a4s_addons = (isset($plugin_data['TextDomain'])) ? $plugin_data['TextDomain'] : 'a4s-addons';
		$this->version = (isset($plugin_data['Version'])) ? $plugin_data['Version'] : '1.0.0';
		
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - A4s_Addons_Loader. Orchestrates the hooks of the plugin.
	 * - A4s_Addons_i18n. Defines internationalization functionality.
	 * - A4s_Addons_Admin. Defines all hooks for the admin area.
	 * - A4s_Addons_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4s-addons-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4s-addons-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-a4s-addons-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-a4s-addons-public.php';
		
		// Robertas
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4s-addons-widget-cpt.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4s-addons-widget-pwgen.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4s-addons-ad-contacts.php';

		$this->loader = new A4s_Addons_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the A4s_Addons_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new A4s_Addons_i18n();
		$plugin_i18n->set_domain( $this->get_a4s_addons() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new A4s_Addons_Admin( $this->get_a4s_addons(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		// Robertas
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'a4s_addons_admin_menu_add' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'a4s_addons_admin_menu_init' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new A4s_Addons_Public( $this->get_a4s_addons(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		// Robertas
		$options = get_option( 'a4s-addons' );
		
		if ( isset($options['cpt']) && $options['cpt'] == 1 ) {
			$plugin_widget_cpt = new A4s_Addons_Widget_CPT();
			$this->loader->add_action( 'widgets_init', $plugin_widget_cpt, 'register_widget' );
		}
		
		if ( isset($options['pwgen']) && $options['pwgen'] == 1 ) {
			$plugin_widget_pwgen = new A4s_Addons_Widget_PwGen();
			$this->loader->add_action( 'widgets_init', $plugin_widget_pwgen, 'register_widget' );
		}
		
		if ( isset($options['adcontacts']) && $options['adcontacts'] == 1 ) {
			$plugin_addon_adcontacts = new A4s_Addons_AD_Contacts();
			$this->loader->add_action( 'init', $plugin_addon_adcontacts, 'register_shortcodes' );
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_a4s_addons() {
		return $this->a4s_addons;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    A4s_Addons_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

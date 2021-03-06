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
 * @package    A4sForms
 * @subpackage A4sForms/includes
 * @author     Robertas Reiciunas <accesspc@gmail.com>
 */
class A4sForms {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      A4sForms_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $a4sforms    The string used to uniquely identify this plugin.
	 */
	protected $a4sforms;

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
	public function __construct() {

		$this->a4sforms = (isset($plugin_data['TextDomain'])) ? $plugin_data['TextDomain'] : 'a4sforms';
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
	 * - A4sForms_Loader. Orchestrates the hooks of the plugin.
	 * - A4sForms_i18n. Defines internationalization functionality.
	 * - A4sForms_Admin. Defines all hooks for the admin area.
	 * - A4sForms_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4sforms-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4sforms-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-a4sforms-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-a4sforms-public.php';

		// extra loaded here
		/*
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4s-addons-widget-cpt.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4s-addons-widget-pwgen.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-a4s-addons-ad-contacts.php';
		 */
		
		$this->loader = new A4sForms_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the A4sForms_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new A4sForms_i18n();
		$plugin_i18n->set_domain($this->get_a4sforms());

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

		$plugin_admin = new A4sForms_Admin( $this->get_a4sforms(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Extra
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu_add' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_menu_init' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new A4sForms_Public( $this->get_a4sforms(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// Extra
		$this->loader->add_action( 'init', $this, 'register_form_post_type' );
		
		
		/*
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
		 */
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
	public function get_a4sforms() {
		return $this->a4sforms;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    A4sForms_Loader    Orchestrates the hooks of the plugin.
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
	
	public function register_form_post_type() {
		$labels = array(
			'name'               => _x( 'Forms', 'post type general name', 'a4sforms' ),
			'singular_name'      => _x( 'Form', 'post type singular name', 'a4sforms' ),
			'menu_name'          => _x( 'Forms', 'admin menu', 'a4sforms' ),
			'name_admin_bar'     => _x( 'Form', 'add new on admin bar', 'a4sforms' ),
			'add_new'            => _x( 'Add New', 'form', 'a4sforms' ),
			'add_new_item'       => __( 'Add New Form', 'a4sforms' ),
			'new_item'           => __( 'New Form', 'a4sforms' ),
			'edit_item'          => __( 'Edit Form', 'a4sforms' ),
			'view_item'          => __( 'View Form', 'a4sforms' ),
			'all_items'          => __( 'All Forms', 'a4sforms' ),
			'search_items'       => __( 'Search Forms', 'a4sforms' ),
			'parent_item_colon'  => __( 'Parent Forms:', 'a4sforms' ),
			'not_found'          => __( 'No forms found.', 'a4sforms' ),
			'not_found_in_trash' => __( 'No forms found in Trash.', 'a4sforms' )
		);
		
		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'a4sforms' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'form' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);
		
		register_post_type( 'a4sform', $args );
	}

}

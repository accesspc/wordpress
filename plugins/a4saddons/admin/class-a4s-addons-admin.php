<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    A4s_Addons
 * @subpackage A4s_Addons/admin
 * @author     robertas@reiciunas.lt
 */
class A4s_Addons_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $a4s_addons    The ID of this plugin.
	 */
	private $a4s_addons;

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
	 * @param      string    $a4s_addons       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $a4s_addons, $version ) {

		$this->a4s_addons = $a4s_addons;
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
		 * defined in A4s_Addons_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The A4s_Addons_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->a4s_addons, plugin_dir_url( __FILE__ ) . 'css/a4s-addons-admin.css', array(), $this->version, 'all' );

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
		 * defined in A4s_Addons_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The A4s_Addons_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->a4s_addons, plugin_dir_url( __FILE__ ) . 'js/a4s-addons-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	public function a4s_addons_admin_menu_add() {
		add_menu_page(
			__( 'General Settings', 'a4s-addons' ),
			__( 'A4s settings', 'a4s-addons' ),
			'manage_options',
			'a4s_addons_admin_menu',
			'A4s_Addons_Admin::a4s_addons_admin_menu_page_general'
		);
		
		add_submenu_page(
			'a4s_addons_admin_menu',
			__( 'Widget Settings', 'a4s-addons' ),
			__( 'Widget Settings', 'a4s-addons' ),
			'manage_options',
			'a4s_addons_admin_menu_widgets',
			'A4s_Addons_Admin::a4s_addons_admin_menu_page_widget'
		);
	}
	
	public function a4s_addons_admin_menu_init() {
		register_setting('widgetSettings', 'a4s-addons');
	
		// Section: Widgets
		add_settings_section(
			'a4s_addons_section_widget',
			__( 'Widget options', 'a4s-addons' ),
			'A4s_Addons_Admin::a4s_addons_section_widget_callback',
			'widgetSettings'
		);
	
		// Widget: CPT
		add_settings_field(
			'a4s_addons_addons_list',
			__( 'Enabled addons list', 'a4s-addons' ),
			'A4s_Addons_Admin::a4s_addons_widget_render_list',
			'widgetSettings',
			'a4s_addons_section_widget'
		);
	
	}
	
	public function a4s_addons_admin_menu_page_general() {
		?>
			<div class="a4s-addons-admin">
				<form action='options.php' method='post'>
				<h2><?php _e( 'A4s settings page', 'a4s-addons' ); ?></h2>
				<div><?php /*echo wp_get_theme()->__get( 'name' ); ?> v<?php echo //wp_get_theme()->__get( 'version' );*/ ?></div>
				<dl>
					<dt>some title text</dt>
					<dl>some content text</dl>
				</dl>
				<?php 
					
					submit_button();
				?>
			</form>
			</div>
			<?php 
		}
	
	public function a4s_addons_admin_menu_page_widget() {
		?>
		<div class="a4s-addons-general">
			<form action="options.php" method="post">
				<?php 
					settings_fields('widgetSettings');
					do_settings_sections('widgetSettings');
					submit_button();
				?>
			</form>
		</div>
		<?php 
	}
	
	public function a4s_addons_widget_render_list() {
		$options = get_option( 'a4s-addons' );
		
		$addons = array(
				'cpt' => 'Category & Post Tree',
				'pwgen' => 'Password Generator',
				'adcontacts' => 'AD Contacts list',
		);
		
		?><fieldset><legend class="screen-reader-text"><span>Widget list</span></legend><?php 
		
		foreach ($addons as $addon => $title) {
			printf( '<label for="%s"><input name="a4s-addons[%s]" type="checkbox" id="%s" value="1" %s>%s</label><br />',
					$addon, $addon, $addon,
					( isset($options[$addon]) && $options[$addon] == '1') ? 'checked' : '' ,
					$title
			);
		}
		
		?></fieldset><?php 
	}
	
	public function a4s_addons_section_widget_callback() {
		echo '<hr />';
		_e( 'This section is for widgets', 'a4s-addons' );
	}
	

}


<?php
/**
 * Adds A4s_Addons_AD_Contacts user information shortcodes
 * 
 * @author Robertas
 * @since 1.2.10
 */
class A4s_Addons_AD_Contacts {
	/**
	 * Users not shown in contact list
	 * 
	 * @var array
	 */
	private $not_shown_users = array(
		'admin',
		'grete',
		'rytis_adm',
		'test',
		'test101',
		'test102',
		'test2',
	);
	
	/**
	 * Register class with Wordpress
	 * 
	 * @since 1.2.10
	 */
	public function __construct() {
		
	}
	
	/**
	 * Return link with an email
	 * 
	 * @since 1.2.12
	 * 
	 * @param string $email
	 * @return string
	 */
	public function get_email_link($email) {
		if (!empty($email)) {
			return sprintf('<a href="mailto:%s">%s</a>', $email, $email);
		}
		return "";
	}
	
	/**
	 * Return link with a phone
	 * 
	 * @since 1.2.11
	 * 
	 * @param string $phone
	 * @return string
	 */
	public function get_phone_link($phone) {
		if (!empty($phone)) {
			return sprintf('<a href="callto:%s">%s</a>', $phone, $phone); 
		}
		return "";
	}
	
	/**
	 * Print user block
	 * 
	 * @since 1.2.10
	 * 
	 * @param WP_User $user
	 * @param array $user_meta
	 */
	public function print_user($user, $user_meta) {
		?>
		<div class="col-sm-3">
			<div class="employee list-group user user-<?php echo $user->data->ID; ?>">
				<div class="list-group-item name active"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $user->data->display_name; ?></div>
				<div class="list-group-item email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <a href="mailto:<?php echo $user->data->user_email; ?>"><?php echo $user->data->user_email; ?></a></div>
				<div class="list-group-item mobile"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span> <?php 
					if (isset($user_meta['adi_mobile']) && !empty($user_meta['adi_mobile'][0])) {
						echo $this->get_phone_link($user_meta['adi_mobile'][0]);
					}
				?></div>
				<div class="list-group-item s4b"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> <?php 
					if (isset($user_meta['adi_telephonenumber']) && !empty($user_meta['adi_telephonenumber'][0])) {
						echo $this->get_phone_link($user_meta['adi_telephonenumber'][0]);
					}
				?></div>
				<div class="list-group-item manager"><span class="glyphicon glyphicon-tower" aria-hidden="true"></span> <?php
				$managerdn = get_user_meta($user->data->ID, 'adi_manager', true);
				if (strlen($managerdn) > 0) {
					$manager = explode('=', explode(',', $managerdn)[0])[1];
					echo $manager;
				}
				
				?></div>
			</div>
		</div>
		<?php
	}
	
	/**
	 * Register shortcodes
	 * 
	 * @since 1.2.10
	 */
	public function register_shortcodes() {
		add_shortcode('a4s-addons-ad-contacts', array($this, 'shortcode_print_contacts'));
		add_shortcode('ad-user-mobile', array($this, 'shortcode_print_user_mobile'));
	}
	
	/**
	 * Shortcode function for printing contacts
	 * 
	 * @since 1.2.10
	 * 
	 * @param array $atts
	 */
	public function shortcode_print_contacts($atts) {
		//https://codex.wordpress.org/Function_Reference/get_users
		$users = get_users();
		
		ob_start();
		?><div class="row"><?php 
		foreach ($users as $user) {
			
			if (!in_array($user->data->user_login, $this->not_shown_users)) {
				$user_meta = get_user_meta($user->data->ID);
				if ($user_meta['adi_user_disabled'][0] != 1) {
					$this->print_user($user, $user_meta);
				}
			}
		}
		?></div><?php 
		return ob_get_clean();
	}
	
	/**
	 * Shortcode function for printing user mobile phone
	 * 
	 * @since 1.2.10
	 * 
	 * @param array $atts
	 */
	public function shortcode_print_user_mobile($atts) {
		$a4s_atts = shortcode_atts(
			array(
				'login' => '',
			),
			$atts
		);
		
		$user = get_user_by('login', $a4s_atts['login']);
		return sprintf('<span class="ad-user"><span class="name">%s</span> <span class="mobile">%s</span></span>', 
			$user->data->display_name, 
			$this->get_phone_link(get_user_meta($user->ID, 'adi_mobile', true))
		);
	}
	
}

<?php
/**
 * Install and Deactivate Plugin Functions
 * @package WP_EASY_CONTACT
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
if (!class_exists('Wp_Easy_Contact_Install_Deactivate')):
	/**
	 * Wp_Easy_Contact_Install_Deactivate Class
	 * @since WPAS 4.0
	 */
	class Wp_Easy_Contact_Install_Deactivate {
		private $option_name;
		/**
		 * Hooks for install and deactivation and create options
		 * @since WPAS 4.0
		 */
		public function __construct() {
			$this->option_name = 'wp_easy_contact';
			add_action('admin_init', array(
				$this,
				'check_update'
			));
			register_activation_hook(WP_EASY_CONTACT_PLUGIN_FILE, array(
				$this,
				'install'
			));
			register_deactivation_hook(WP_EASY_CONTACT_PLUGIN_FILE, array(
				$this,
				'deactivate'
			));
			add_action('wp_head', array(
				$this,
				'version_in_header'
			));
			add_action('admin_init', array(
				$this,
				'setup_pages'
			));
			add_action('admin_notices', array(
				$this,
				'install_notice'
			));
			add_action('admin_init', array(
				$this,
				'register_settings'
			) , 0);
			add_action('wp_ajax_emd_load_file', 'emd_load_file');
			add_action('wp_ajax_nopriv_emd_load_file', 'emd_load_file');
			add_action('wp_ajax_emd_delete_file', 'emd_delete_file');
			add_action('wp_ajax_nopriv_emd_delete_file', 'emd_delete_file');
			add_action('init', array(
				$this,
				'init_extensions'
			) , 99);
			do_action('emd_ext_actions', $this->option_name);
			add_filter('tiny_mce_before_init', array(
				$this,
				'tinymce_fix'
			));
		}
		public function check_update() {
			$curr_version = get_option($this->option_name . '_version', 1);
			$new_version = constant(strtoupper($this->option_name) . '_VERSION');
			if (version_compare($curr_version, $new_version, '<')) {
				$this->set_options();
				$this->set_roles_caps();
				if (!get_option($this->option_name . '_activation_date')) {
					$triggerdate = mktime(0, 0, 0, date('m') , date('d') + 7, date('Y'));
					add_option($this->option_name . '_activation_date', $triggerdate);
				}
				set_transient($this->option_name . '_activate_redirect', true, 30);
				do_action($this->option_name . '_upgrade', $new_version);
				update_option($this->option_name . '_version', $new_version);
			}
		}
		public function version_in_header() {
			$version = constant(strtoupper($this->option_name) . '_VERSION');
			$name = constant(strtoupper($this->option_name) . '_NAME');
			echo '<meta name="generator" content="' . $name . ' v' . $version . ' - https://emdplugins.com" />' . "\n";
		}
		public function init_extensions() {
			do_action('emd_ext_init', $this->option_name);
		}
		/**
		 * Runs on plugin install to setup custom post types and taxonomies
		 * flushing rewrite rules, populates settings and options
		 * creates roles and assign capabilities
		 * @since WPAS 4.0
		 *
		 */
		public function install() {
			$this->set_options();
			Emd_Contact::register();
			flush_rewrite_rules();
			$this->set_roles_caps();
			set_transient($this->option_name . '_activate_redirect', true, 30);
			do_action('emd_ext_install_hook', $this->option_name);
		}
		/**
		 * Runs on plugin deactivate to remove options, caps and roles
		 * flushing rewrite rules
		 * @since WPAS 4.0
		 *
		 */
		public function deactivate() {
			flush_rewrite_rules();
			$this->remove_caps_roles();
			$this->reset_options();
			do_action('emd_ext_deactivate', $this->option_name);
		}
		/**
		 * Register notification and/or license settings
		 * @since WPAS 4.0
		 *
		 */
		public function register_settings() {
			do_action('emd_ext_register', $this->option_name);
			if (!get_transient($this->option_name . '_activate_redirect')) {
				return;
			}
			// Delete the redirect transient.
			delete_transient($this->option_name . '_activate_redirect');
			$query_args = array(
				'page' => $this->option_name
			);
			wp_safe_redirect(add_query_arg($query_args, admin_url('admin.php')));
		}
		/**
		 * Sets caps and roles
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function set_roles_caps() {
			global $wp_roles;
			$cust_roles = Array();
			update_option($this->option_name . '_cust_roles', $cust_roles);
			$add_caps = Array(
				'configure_recent_dash_contacts' => Array(
					'administrator'
				) ,
				'edit_dashboard' => Array(
					'administrator'
				) ,
				'view_single_contact' => Array(
					'administrator'
				) ,
				'assign_contact_tag' => Array(
					'administrator'
				) ,
				'edit_contact_tag' => Array(
					'administrator'
				) ,
				'assign_contact_state' => Array(
					'administrator'
				) ,
				'edit_emd_contacts' => Array(
					'administrator'
				) ,
				'view_recent_dash_contacts' => Array(
					'administrator'
				) ,
				'edit_others_emd_contacts' => Array(
					'administrator'
				) ,
				'delete_contact_topic' => Array(
					'administrator'
				) ,
				'delete_contact_country' => Array(
					'administrator'
				) ,
				'view_wp_easy_contact_dashboard' => Array(
					'administrator'
				) ,
				'delete_contact_tag' => Array(
					'administrator'
				) ,
				'manage_contact_topic' => Array(
					'administrator'
				) ,
				'delete_others_emd_contacts' => Array(
					'administrator'
				) ,
				'edit_contact_state' => Array(
					'administrator'
				) ,
				'delete_emd_contacts' => Array(
					'administrator'
				) ,
				'read_private_emd_contacts' => Array(
					'administrator'
				) ,
				'delete_published_emd_contacts' => Array(
					'administrator'
				) ,
				'view_recent_contacts' => Array(
					'administrator'
				) ,
				'delete_private_emd_contacts' => Array(
					'administrator'
				) ,
				'assign_contact_topic' => Array(
					'administrator'
				) ,
				'manage_contact_country' => Array(
					'administrator'
				) ,
				'publish_emd_contacts' => Array(
					'administrator'
				) ,
				'edit_published_emd_contacts' => Array(
					'administrator'
				) ,
				'manage_operations_emd_contacts' => Array(
					'administrator'
				) ,
				'assign_contact_country' => Array(
					'administrator'
				) ,
				'delete_contact_state' => Array(
					'administrator'
				) ,
				'edit_private_emd_contacts' => Array(
					'administrator'
				) ,
				'manage_contact_state' => Array(
					'administrator'
				) ,
				'manage_contact_tag' => Array(
					'administrator'
				) ,
				'edit_contact_topic' => Array(
					'administrator'
				) ,
				'edit_contact_country' => Array(
					'administrator'
				) ,
			);
			update_option($this->option_name . '_add_caps', $add_caps);
			if (class_exists('WP_Roles')) {
				if (!isset($wp_roles)) {
					$wp_roles = new WP_Roles();
				}
			}
			if (is_object($wp_roles)) {
				if (!empty($cust_roles)) {
					foreach ($cust_roles as $krole => $vrole) {
						$myrole = get_role($krole);
						if (empty($myrole)) {
							$myrole = add_role($krole, $vrole);
						}
					}
				}
				$this->set_reset_caps($wp_roles, 'add');
			}
		}
		/**
		 * Removes caps and roles
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function remove_caps_roles() {
			global $wp_roles;
			if (class_exists('WP_Roles')) {
				if (!isset($wp_roles)) {
					$wp_roles = new WP_Roles();
				}
			}
			if (is_object($wp_roles)) {
				$this->set_reset_caps($wp_roles, 'remove');
			}
		}
		/**
		 * Set  capabilities
		 *
		 * @since WPAS 4.0
		 * @param object $wp_roles
		 * @param string $type
		 *
		 */
		public function set_reset_caps($wp_roles, $type) {
			$caps['enable'] = get_option($this->option_name . '_add_caps', Array());
			$caps['enable'] = apply_filters('emd_ext_get_caps', $caps['enable'], $this->option_name);
			foreach ($caps as $stat => $role_caps) {
				foreach ($role_caps as $mycap => $roles) {
					foreach ($roles as $myrole) {
						if (($type == 'add' && $stat == 'enable') || ($stat == 'disable' && $type == 'remove')) {
							$wp_roles->add_cap($myrole, $mycap);
						} else if (($type == 'remove' && $stat == 'enable') || ($type == 'add' && $stat == 'disable')) {
							$wp_roles->remove_cap($myrole, $mycap);
						}
					}
				}
			}
		}
		/**
		 * Set app specific options
		 *
		 * @since WPAS 4.0
		 *
		 */
		private function set_options() {
			$access_views = Array();
			if (get_option($this->option_name . '_setup_pages', 0) == 0) {
				update_option($this->option_name . '_setup_pages', 1);
			}
			$access_views['single'] = Array(
				Array(
					'name' => 'single_contact',
					'obj' => 'emd_contact'
				) ,
			);
			$access_views['widgets'] = Array(
				'recent_contacts'
			);
			update_option($this->option_name . '_access_views', $access_views);
			$ent_list = Array(
				'emd_contact' => Array(
					'label' => __('Contacts', 'wp-easy-contact') ,
					'rewrite' => 'contacts',
					'archive_view' => 0,
					'rest_api' => 0,
					'sortable' => 0,
					'searchable' => 1,
					'class_title' => Array(
						'emd_contact_id'
					) ,
					'unique_keys' => Array(
						'emd_contact_id'
					) ,
					'req_blt' => Array(
						'blt_title' => Array(
							'msg' => __('Subject', 'wp-easy-contact')
						) ,
						'blt_content' => Array(
							'msg' => __('Message', 'wp-easy-contact')
						) ,
					) ,
				) ,
			);
			update_option($this->option_name . '_ent_list', $ent_list);
			$shc_list['app'] = 'WP Easy Contact';
			$shc_list['has_gmap'] = 0;
			$shc_list['has_form_lite'] = 1;
			$shc_list['has_lite'] = 1;
			$shc_list['has_bs'] = 0;
			$shc_list['has_autocomplete'] = 0;
			$shc_list['remove_vis'] = 1;
			$shc_list['forms']['contact_submit'] = Array(
				'name' => 'contact_submit',
				'type' => 'submit',
				'ent' => 'emd_contact',
				'targeted_device' => 'desktops',
				'label_position' => 'top',
				'element_size' => 'large',
				'display_inline' => '0',
				'noaccess_msg' => 'You are not allowed to access to this area. Please contact the site administrator.',
				'disable_submit' => '0',
				'submit_status' => 'publish',
				'visitor_submit_status' => 'publish',
				'submit_button_type' => 'btn-info',
				'submit_button_label' => 'Send',
				'submit_button_size' => 'btn-large',
				'submit_button_block' => '0',
				'submit_button_fa' => '',
				'submit_button_fa_size' => '',
				'submit_button_fa_pos' => 'left',
				'show_captcha' => 'show-to-visitors',
				'disable_after' => '0',
				'confirm_method' => 'text',
				'confirm_url' => '',
				'confirm_success_txt' => 'Thanks for your submission.',
				'confirm_error_txt' => 'There has been an error when submitting your entry. Please contact the site administrator.',
				'enable_ajax' => '0',
				'after_submit' => 'show',
				'schedule_start' => '',
				'schedule_end' => '',
				'enable_operators' => '0',
				'ajax_search' => '0',
				'result_templ' => '',
				'result_fields' => '',
				'noresult_msg' => '',
				'view_name' => '',
				'honeypot' => '1',
				'login_reg' => 'none',
				'page_title' => __('Contact Form', 'wp-easy-contact')
			);
			if (!empty($shc_list)) {
				update_option($this->option_name . '_shc_list', $shc_list);
			}
			$attr_list['emd_contact']['emd_contact_first_name'] = Array(
				'label' => __('First Name', 'wp-easy-contact') ,
				'display_type' => 'text',
				'required' => 1,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_contact_info_emd_contact_0',
				'desc' => __('Please enter your first name.', 'wp-easy-contact') ,
				'type' => 'char',
			);
			$attr_list['emd_contact']['emd_contact_last_name'] = Array(
				'label' => __('Last Name', 'wp-easy-contact') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_contact_info_emd_contact_0',
				'desc' => __('Please enter your last name.', 'wp-easy-contact') ,
				'type' => 'char',
			);
			$attr_list['emd_contact']['emd_contact_email'] = Array(
				'label' => __('Email', 'wp-easy-contact') ,
				'display_type' => 'text',
				'required' => 1,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_contact_info_emd_contact_0',
				'desc' => __('Please enter your email address.', 'wp-easy-contact') ,
				'type' => 'char',
				'email' => true,
			);
			$attr_list['emd_contact']['emd_contact_phone'] = Array(
				'label' => __('Phone', 'wp-easy-contact') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_contact_info_emd_contact_0',
				'desc' => __('Please enter your phone or mobile.', 'wp-easy-contact') ,
				'type' => 'char',
			);
			$attr_list['emd_contact']['emd_contact_address'] = Array(
				'label' => __('Address', 'wp-easy-contact') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_contact_info_emd_contact_0',
				'desc' => __('Please enter your mailing address.', 'wp-easy-contact') ,
				'type' => 'char',
			);
			$attr_list['emd_contact']['emd_contact_city'] = Array(
				'label' => __('City', 'wp-easy-contact') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_contact_info_emd_contact_0',
				'desc' => __('Please enter your city.', 'wp-easy-contact') ,
				'type' => 'char',
			);
			$attr_list['emd_contact']['emd_contact_zipcode'] = Array(
				'label' => __('Zip Code', 'wp-easy-contact') ,
				'display_type' => 'text',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_contact_info_emd_contact_0',
				'desc' => __('Please enter your zip code.', 'wp-easy-contact') ,
				'type' => 'char',
			);
			$attr_list['emd_contact']['emd_contact_id'] = Array(
				'label' => __('ID', 'wp-easy-contact') ,
				'display_type' => 'hidden',
				'required' => 0,
				'srequired' => 1,
				'filterable' => 0,
				'list_visible' => 1,
				'mid' => 'emd_contact_info_emd_contact_0',
				'desc' => __('Unique contact id incremented by one to keep tract of communications', 'wp-easy-contact') ,
				'autoinc_start' => 1,
				'autoinc_incr' => 1,
				'type' => 'char',
				'hidden_func' => 'autoinc',
				'uniqueAttr' => true,
			);
			$attr_list['emd_contact']['wpas_form_name'] = Array(
				'label' => __('Form Name', 'wp-easy-contact') ,
				'display_type' => 'hidden',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 0,
				'mid' => 'emd_contact_info_emd_contact_0',
				'type' => 'char',
				'options' => array() ,
				'no_update' => 1,
				'std' => 'admin',
			);
			$attr_list['emd_contact']['wpas_form_submitted_by'] = Array(
				'label' => __('Form Submitted By', 'wp-easy-contact') ,
				'display_type' => 'hidden',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 0,
				'mid' => 'emd_contact_info_emd_contact_0',
				'type' => 'char',
				'options' => array() ,
				'hidden_func' => 'user_login',
				'no_update' => 1,
			);
			$attr_list['emd_contact']['wpas_form_submitted_ip'] = Array(
				'label' => __('Form Submitted IP', 'wp-easy-contact') ,
				'display_type' => 'hidden',
				'required' => 0,
				'srequired' => 0,
				'filterable' => 1,
				'list_visible' => 0,
				'mid' => 'emd_contact_info_emd_contact_0',
				'type' => 'char',
				'options' => array() ,
				'hidden_func' => 'user_ip',
				'no_update' => 1,
			);
			$attr_list = apply_filters('emd_ext_attr_list', $attr_list, $this->option_name);
			if (!empty($attr_list)) {
				update_option($this->option_name . '_attr_list', $attr_list);
			}
			update_option($this->option_name . '_glob_init_list', Array());
			$glob_forms_list['contact_submit']['captcha'] = 'show-to-visitors';
			$glob_forms_list['contact_submit']['noaccess_msg'] = 'You are not allowed to access to this area. Please contact the site administrator.';
			$glob_forms_list['contact_submit']['error_msg'] = 'There has been an error when submitting your entry. Please contact the site administrator.';
			$glob_forms_list['contact_submit']['success_msg'] = 'Thanks for your submission.';
			$glob_forms_list['contact_submit']['login_reg'] = 'none';
			$glob_forms_list['contact_submit']['csrf'] = 1;
			$glob_forms_list['contact_submit']['emd_contact_first_name'] = Array(
				'show' => 1,
				'row' => 1,
				'req' => 1,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['emd_contact_last_name'] = Array(
				'show' => 1,
				'row' => 2,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['emd_contact_email'] = Array(
				'show' => 1,
				'row' => 3,
				'req' => 1,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['emd_contact_phone'] = Array(
				'show' => 1,
				'row' => 4,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['emd_contact_address'] = Array(
				'show' => 1,
				'row' => 5,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['emd_contact_city'] = Array(
				'show' => 1,
				'row' => 6,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['contact_state'] = Array(
				'show' => 1,
				'row' => 7,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['emd_contact_zipcode'] = Array(
				'show' => 1,
				'row' => 8,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['contact_country'] = Array(
				'show' => 1,
				'row' => 9,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['contact_topic'] = Array(
				'show' => 1,
				'row' => 10,
				'req' => 0,
				'size' => 12,
			);
			$glob_forms_list['contact_submit']['blt_title'] = Array(
				'show' => 1,
				'row' => 11,
				'req' => 1,
				'size' => 12,
				'label' => __('Subject', 'wp-easy-contact')
			);
			$glob_forms_list['contact_submit']['blt_content'] = Array(
				'show' => 1,
				'row' => 12,
				'req' => 1,
				'size' => 12,
				'label' => __('Message', 'wp-easy-contact')
			);
			$glob_forms_list['contact_submit']['emd_contact_id'] = Array(
				'show' => 1,
				'row' => 14,
				'req' => 0,
				'size' => 12,
			);
			if (!empty($glob_forms_list)) {
				update_option($this->option_name . '_glob_forms_init_list', $glob_forms_list);
				if (get_option($this->option_name . '_glob_forms_list') === false) {
					update_option($this->option_name . '_glob_forms_list', $glob_forms_list);
				}
			}
			$tax_list['emd_contact']['contact_state'] = Array(
				'archive_view' => 0,
				'label' => __('States', 'wp-easy-contact') ,
				'single_label' => __('State', 'wp-easy-contact') ,
				'default' => '',
				'type' => 'single',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'contact_state',
				'init_values' => Array(
					Array(
						'name' => __('AL', 'wp-easy-contact') ,
						'slug' => sanitize_title('AL') ,
						'desc' => __('Alabama', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('AK', 'wp-easy-contact') ,
						'slug' => sanitize_title('AK') ,
						'desc' => __('Alaska', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('AZ', 'wp-easy-contact') ,
						'slug' => sanitize_title('AZ') ,
						'desc' => __('Arizona', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('AR', 'wp-easy-contact') ,
						'slug' => sanitize_title('AR') ,
						'desc' => __('Arkansas', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('CA', 'wp-easy-contact') ,
						'slug' => sanitize_title('CA') ,
						'desc' => __('California', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('CO', 'wp-easy-contact') ,
						'slug' => sanitize_title('CO') ,
						'desc' => __('Colorado', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('CT', 'wp-easy-contact') ,
						'slug' => sanitize_title('CT') ,
						'desc' => __('Connecticut', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('DE', 'wp-easy-contact') ,
						'slug' => sanitize_title('DE') ,
						'desc' => __('Delaware', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('DC', 'wp-easy-contact') ,
						'slug' => sanitize_title('DC') ,
						'desc' => __('District of Columbia', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('FL', 'wp-easy-contact') ,
						'slug' => sanitize_title('FL') ,
						'desc' => __('Florida', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('GA', 'wp-easy-contact') ,
						'slug' => sanitize_title('GA') ,
						'desc' => __('Georgia', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('HI', 'wp-easy-contact') ,
						'slug' => sanitize_title('HI') ,
						'desc' => __('Hawaii', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('ID', 'wp-easy-contact') ,
						'slug' => sanitize_title('ID') ,
						'desc' => __('Idaho', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('IL', 'wp-easy-contact') ,
						'slug' => sanitize_title('IL') ,
						'desc' => __('Illinois', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('IN', 'wp-easy-contact') ,
						'slug' => sanitize_title('IN') ,
						'desc' => __('Indiana', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('IA', 'wp-easy-contact') ,
						'slug' => sanitize_title('IA') ,
						'desc' => __('Iowa', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('KS', 'wp-easy-contact') ,
						'slug' => sanitize_title('KS') ,
						'desc' => __('Kansas', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('KY', 'wp-easy-contact') ,
						'slug' => sanitize_title('KY') ,
						'desc' => __('Kentucky', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('LA', 'wp-easy-contact') ,
						'slug' => sanitize_title('LA') ,
						'desc' => __('Louisiana', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('ME', 'wp-easy-contact') ,
						'slug' => sanitize_title('ME') ,
						'desc' => __('Maine', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('MD', 'wp-easy-contact') ,
						'slug' => sanitize_title('MD') ,
						'desc' => __('Maryland', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('MA', 'wp-easy-contact') ,
						'slug' => sanitize_title('MA') ,
						'desc' => __('Massachusetts', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('MI', 'wp-easy-contact') ,
						'slug' => sanitize_title('MI') ,
						'desc' => __('Michigan', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('MN', 'wp-easy-contact') ,
						'slug' => sanitize_title('MN') ,
						'desc' => __('Minnesota', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('MS', 'wp-easy-contact') ,
						'slug' => sanitize_title('MS') ,
						'desc' => __('Mississippi', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('MO', 'wp-easy-contact') ,
						'slug' => sanitize_title('MO') ,
						'desc' => __('Missouri', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('MT', 'wp-easy-contact') ,
						'slug' => sanitize_title('MT') ,
						'desc' => __('Montana', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('NE', 'wp-easy-contact') ,
						'slug' => sanitize_title('NE') ,
						'desc' => __('Nebraska', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('NV', 'wp-easy-contact') ,
						'slug' => sanitize_title('NV') ,
						'desc' => __('Nevada', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('NH', 'wp-easy-contact') ,
						'slug' => sanitize_title('NH') ,
						'desc' => __('New Hampshire', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('NJ', 'wp-easy-contact') ,
						'slug' => sanitize_title('NJ') ,
						'desc' => __('New Jersey', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('NM', 'wp-easy-contact') ,
						'slug' => sanitize_title('NM') ,
						'desc' => __('New Mexico', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('NY', 'wp-easy-contact') ,
						'slug' => sanitize_title('NY') ,
						'desc' => __('New York', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('NC', 'wp-easy-contact') ,
						'slug' => sanitize_title('NC') ,
						'desc' => __('North Carolina', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('ND', 'wp-easy-contact') ,
						'slug' => sanitize_title('ND') ,
						'desc' => __('North Dakota', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('OH', 'wp-easy-contact') ,
						'slug' => sanitize_title('OH') ,
						'desc' => __('Ohio', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('OK', 'wp-easy-contact') ,
						'slug' => sanitize_title('OK') ,
						'desc' => __('Oklahoma', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('OR', 'wp-easy-contact') ,
						'slug' => sanitize_title('OR') ,
						'desc' => __('Oregon', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('PA', 'wp-easy-contact') ,
						'slug' => sanitize_title('PA') ,
						'desc' => __('Pennsylvania', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('RI', 'wp-easy-contact') ,
						'slug' => sanitize_title('RI') ,
						'desc' => __('Rhode Island', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('SC', 'wp-easy-contact') ,
						'slug' => sanitize_title('SC') ,
						'desc' => __('South Carolina', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('SD', 'wp-easy-contact') ,
						'slug' => sanitize_title('SD') ,
						'desc' => __('South Dakota', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('TN', 'wp-easy-contact') ,
						'slug' => sanitize_title('TN') ,
						'desc' => __('Tennessee', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('TX', 'wp-easy-contact') ,
						'slug' => sanitize_title('TX') ,
						'desc' => __('Texas', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('UT', 'wp-easy-contact') ,
						'slug' => sanitize_title('UT') ,
						'desc' => __('Utah', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('VT', 'wp-easy-contact') ,
						'slug' => sanitize_title('VT') ,
						'desc' => __('Vermont', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('VA', 'wp-easy-contact') ,
						'slug' => sanitize_title('VA') ,
						'desc' => __('Virginia', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('WA', 'wp-easy-contact') ,
						'slug' => sanitize_title('WA') ,
						'desc' => __('Washington', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('WV', 'wp-easy-contact') ,
						'slug' => sanitize_title('WV') ,
						'desc' => __('West Virginia', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('WI', 'wp-easy-contact') ,
						'slug' => sanitize_title('WI') ,
						'desc' => __('Wisconsin', 'wp-easy-contact')
					) ,
					Array(
						'name' => __('WY', 'wp-easy-contact') ,
						'slug' => sanitize_title('WY') ,
						'desc' => __('Wyoming', 'wp-easy-contact')
					)
				)
			);
			$tax_list['emd_contact']['contact_country'] = Array(
				'archive_view' => 0,
				'label' => __('Countries', 'wp-easy-contact') ,
				'single_label' => __('Country', 'wp-easy-contact') ,
				'default' => '',
				'type' => 'single',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'contact_country',
				'init_values' => Array(
					Array(
						'name' => __('Afghanistan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Afghanistan')
					) ,
					Array(
						'name' => __('Åland Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Åland Islands')
					) ,
					Array(
						'name' => __('Albania', 'wp-easy-contact') ,
						'slug' => sanitize_title('Albania')
					) ,
					Array(
						'name' => __('Algeria', 'wp-easy-contact') ,
						'slug' => sanitize_title('Algeria')
					) ,
					Array(
						'name' => __('American Samoa', 'wp-easy-contact') ,
						'slug' => sanitize_title('American Samoa')
					) ,
					Array(
						'name' => __('Andorra', 'wp-easy-contact') ,
						'slug' => sanitize_title('Andorra')
					) ,
					Array(
						'name' => __('Angola', 'wp-easy-contact') ,
						'slug' => sanitize_title('Angola')
					) ,
					Array(
						'name' => __('Anguilla', 'wp-easy-contact') ,
						'slug' => sanitize_title('Anguilla')
					) ,
					Array(
						'name' => __('Antarctica', 'wp-easy-contact') ,
						'slug' => sanitize_title('Antarctica')
					) ,
					Array(
						'name' => __('Antigua And Barbuda', 'wp-easy-contact') ,
						'slug' => sanitize_title('Antigua And Barbuda')
					) ,
					Array(
						'name' => __('Argentina', 'wp-easy-contact') ,
						'slug' => sanitize_title('Argentina')
					) ,
					Array(
						'name' => __('Armenia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Armenia')
					) ,
					Array(
						'name' => __('Aruba', 'wp-easy-contact') ,
						'slug' => sanitize_title('Aruba')
					) ,
					Array(
						'name' => __('Australia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Australia')
					) ,
					Array(
						'name' => __('Austria', 'wp-easy-contact') ,
						'slug' => sanitize_title('Austria')
					) ,
					Array(
						'name' => __('Azerbaijan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Azerbaijan')
					) ,
					Array(
						'name' => __('Bahamas', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bahamas')
					) ,
					Array(
						'name' => __('Bahrain', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bahrain')
					) ,
					Array(
						'name' => __('Bangladesh', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bangladesh')
					) ,
					Array(
						'name' => __('Barbados', 'wp-easy-contact') ,
						'slug' => sanitize_title('Barbados')
					) ,
					Array(
						'name' => __('Belarus', 'wp-easy-contact') ,
						'slug' => sanitize_title('Belarus')
					) ,
					Array(
						'name' => __('Belgium', 'wp-easy-contact') ,
						'slug' => sanitize_title('Belgium')
					) ,
					Array(
						'name' => __('Belize', 'wp-easy-contact') ,
						'slug' => sanitize_title('Belize')
					) ,
					Array(
						'name' => __('Benin', 'wp-easy-contact') ,
						'slug' => sanitize_title('Benin')
					) ,
					Array(
						'name' => __('Bermuda', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bermuda')
					) ,
					Array(
						'name' => __('Bhutan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bhutan')
					) ,
					Array(
						'name' => __('Bolivia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bolivia')
					) ,
					Array(
						'name' => __('Bosnia And Herzegovina', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bosnia And Herzegovina')
					) ,
					Array(
						'name' => __('Botswana', 'wp-easy-contact') ,
						'slug' => sanitize_title('Botswana')
					) ,
					Array(
						'name' => __('Bouvet Island', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bouvet Island')
					) ,
					Array(
						'name' => __('Brazil', 'wp-easy-contact') ,
						'slug' => sanitize_title('Brazil')
					) ,
					Array(
						'name' => __('British Indian Ocean Territory', 'wp-easy-contact') ,
						'slug' => sanitize_title('British Indian Ocean Territory')
					) ,
					Array(
						'name' => __('Brunei Darussalam', 'wp-easy-contact') ,
						'slug' => sanitize_title('Brunei Darussalam')
					) ,
					Array(
						'name' => __('Bulgaria', 'wp-easy-contact') ,
						'slug' => sanitize_title('Bulgaria')
					) ,
					Array(
						'name' => __('Burkina Faso', 'wp-easy-contact') ,
						'slug' => sanitize_title('Burkina Faso')
					) ,
					Array(
						'name' => __('Burundi', 'wp-easy-contact') ,
						'slug' => sanitize_title('Burundi')
					) ,
					Array(
						'name' => __('Cambodia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cambodia')
					) ,
					Array(
						'name' => __('Cameroon', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cameroon')
					) ,
					Array(
						'name' => __('Canada', 'wp-easy-contact') ,
						'slug' => sanitize_title('Canada')
					) ,
					Array(
						'name' => __('Cape Verde', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cape Verde')
					) ,
					Array(
						'name' => __('Cayman Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cayman Islands')
					) ,
					Array(
						'name' => __('Central African Republic', 'wp-easy-contact') ,
						'slug' => sanitize_title('Central African Republic')
					) ,
					Array(
						'name' => __('Chad', 'wp-easy-contact') ,
						'slug' => sanitize_title('Chad')
					) ,
					Array(
						'name' => __('Chile', 'wp-easy-contact') ,
						'slug' => sanitize_title('Chile')
					) ,
					Array(
						'name' => __('China', 'wp-easy-contact') ,
						'slug' => sanitize_title('China')
					) ,
					Array(
						'name' => __('Christmas Island', 'wp-easy-contact') ,
						'slug' => sanitize_title('Christmas Island')
					) ,
					Array(
						'name' => __('Cocos (Keeling) Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cocos (Keeling) Islands')
					) ,
					Array(
						'name' => __('Colombia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Colombia')
					) ,
					Array(
						'name' => __('Comoros', 'wp-easy-contact') ,
						'slug' => sanitize_title('Comoros')
					) ,
					Array(
						'name' => __('Congo', 'wp-easy-contact') ,
						'slug' => sanitize_title('Congo')
					) ,
					Array(
						'name' => __('Congo, The Democratic Republic Of The', 'wp-easy-contact') ,
						'slug' => sanitize_title('Congo, The Democratic Republic Of The')
					) ,
					Array(
						'name' => __('Cook Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cook Islands')
					) ,
					Array(
						'name' => __('Costa Rica', 'wp-easy-contact') ,
						'slug' => sanitize_title('Costa Rica')
					) ,
					Array(
						'name' => __('Cote D\'ivoire', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cote D\'ivoire')
					) ,
					Array(
						'name' => __('Croatia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Croatia')
					) ,
					Array(
						'name' => __('Cuba', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cuba')
					) ,
					Array(
						'name' => __('Cyprus', 'wp-easy-contact') ,
						'slug' => sanitize_title('Cyprus')
					) ,
					Array(
						'name' => __('Czech Republic', 'wp-easy-contact') ,
						'slug' => sanitize_title('Czech Republic')
					) ,
					Array(
						'name' => __('Denmark', 'wp-easy-contact') ,
						'slug' => sanitize_title('Denmark')
					) ,
					Array(
						'name' => __('Djibouti', 'wp-easy-contact') ,
						'slug' => sanitize_title('Djibouti')
					) ,
					Array(
						'name' => __('Dominica', 'wp-easy-contact') ,
						'slug' => sanitize_title('Dominica')
					) ,
					Array(
						'name' => __('Dominican Republic', 'wp-easy-contact') ,
						'slug' => sanitize_title('Dominican Republic')
					) ,
					Array(
						'name' => __('Ecuador', 'wp-easy-contact') ,
						'slug' => sanitize_title('Ecuador')
					) ,
					Array(
						'name' => __('Egypt', 'wp-easy-contact') ,
						'slug' => sanitize_title('Egypt')
					) ,
					Array(
						'name' => __('El Salvador', 'wp-easy-contact') ,
						'slug' => sanitize_title('El Salvador')
					) ,
					Array(
						'name' => __('Equatorial Guinea', 'wp-easy-contact') ,
						'slug' => sanitize_title('Equatorial Guinea')
					) ,
					Array(
						'name' => __('Eritrea', 'wp-easy-contact') ,
						'slug' => sanitize_title('Eritrea')
					) ,
					Array(
						'name' => __('Estonia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Estonia')
					) ,
					Array(
						'name' => __('Ethiopia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Ethiopia')
					) ,
					Array(
						'name' => __('Falkland Islands (Malvinas)', 'wp-easy-contact') ,
						'slug' => sanitize_title('Falkland Islands (Malvinas)')
					) ,
					Array(
						'name' => __('Faroe Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Faroe Islands')
					) ,
					Array(
						'name' => __('Fiji', 'wp-easy-contact') ,
						'slug' => sanitize_title('Fiji')
					) ,
					Array(
						'name' => __('Finland', 'wp-easy-contact') ,
						'slug' => sanitize_title('Finland')
					) ,
					Array(
						'name' => __('France', 'wp-easy-contact') ,
						'slug' => sanitize_title('France')
					) ,
					Array(
						'name' => __('French Guiana', 'wp-easy-contact') ,
						'slug' => sanitize_title('French Guiana')
					) ,
					Array(
						'name' => __('French Polynesia', 'wp-easy-contact') ,
						'slug' => sanitize_title('French Polynesia')
					) ,
					Array(
						'name' => __('French Southern Territories', 'wp-easy-contact') ,
						'slug' => sanitize_title('French Southern Territories')
					) ,
					Array(
						'name' => __('Gabon', 'wp-easy-contact') ,
						'slug' => sanitize_title('Gabon')
					) ,
					Array(
						'name' => __('Gambia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Gambia')
					) ,
					Array(
						'name' => __('Georgia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Georgia')
					) ,
					Array(
						'name' => __('Germany', 'wp-easy-contact') ,
						'slug' => sanitize_title('Germany')
					) ,
					Array(
						'name' => __('Ghana', 'wp-easy-contact') ,
						'slug' => sanitize_title('Ghana')
					) ,
					Array(
						'name' => __('Gibraltar', 'wp-easy-contact') ,
						'slug' => sanitize_title('Gibraltar')
					) ,
					Array(
						'name' => __('Greece', 'wp-easy-contact') ,
						'slug' => sanitize_title('Greece')
					) ,
					Array(
						'name' => __('Greenland', 'wp-easy-contact') ,
						'slug' => sanitize_title('Greenland')
					) ,
					Array(
						'name' => __('Grenada', 'wp-easy-contact') ,
						'slug' => sanitize_title('Grenada')
					) ,
					Array(
						'name' => __('Guadeloupe', 'wp-easy-contact') ,
						'slug' => sanitize_title('Guadeloupe')
					) ,
					Array(
						'name' => __('Guam', 'wp-easy-contact') ,
						'slug' => sanitize_title('Guam')
					) ,
					Array(
						'name' => __('Guatemala', 'wp-easy-contact') ,
						'slug' => sanitize_title('Guatemala')
					) ,
					Array(
						'name' => __('Guernsey', 'wp-easy-contact') ,
						'slug' => sanitize_title('Guernsey')
					) ,
					Array(
						'name' => __('Guinea', 'wp-easy-contact') ,
						'slug' => sanitize_title('Guinea')
					) ,
					Array(
						'name' => __('Guinea-bissau', 'wp-easy-contact') ,
						'slug' => sanitize_title('Guinea-bissau')
					) ,
					Array(
						'name' => __('Guyana', 'wp-easy-contact') ,
						'slug' => sanitize_title('Guyana')
					) ,
					Array(
						'name' => __('Haiti', 'wp-easy-contact') ,
						'slug' => sanitize_title('Haiti')
					) ,
					Array(
						'name' => __('Heard Island And Mcdonald Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Heard Island And Mcdonald Islands')
					) ,
					Array(
						'name' => __('Holy See (Vatican City State)', 'wp-easy-contact') ,
						'slug' => sanitize_title('Holy See (Vatican City State)')
					) ,
					Array(
						'name' => __('Honduras', 'wp-easy-contact') ,
						'slug' => sanitize_title('Honduras')
					) ,
					Array(
						'name' => __('Hong Kong', 'wp-easy-contact') ,
						'slug' => sanitize_title('Hong Kong')
					) ,
					Array(
						'name' => __('Hungary', 'wp-easy-contact') ,
						'slug' => sanitize_title('Hungary')
					) ,
					Array(
						'name' => __('Iceland', 'wp-easy-contact') ,
						'slug' => sanitize_title('Iceland')
					) ,
					Array(
						'name' => __('India', 'wp-easy-contact') ,
						'slug' => sanitize_title('India')
					) ,
					Array(
						'name' => __('Indonesia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Indonesia')
					) ,
					Array(
						'name' => __('Iran, Islamic Republic Of', 'wp-easy-contact') ,
						'slug' => sanitize_title('Iran, Islamic Republic Of')
					) ,
					Array(
						'name' => __('Iraq', 'wp-easy-contact') ,
						'slug' => sanitize_title('Iraq')
					) ,
					Array(
						'name' => __('Ireland', 'wp-easy-contact') ,
						'slug' => sanitize_title('Ireland')
					) ,
					Array(
						'name' => __('Isle Of Man', 'wp-easy-contact') ,
						'slug' => sanitize_title('Isle Of Man')
					) ,
					Array(
						'name' => __('Israel', 'wp-easy-contact') ,
						'slug' => sanitize_title('Israel')
					) ,
					Array(
						'name' => __('Italy', 'wp-easy-contact') ,
						'slug' => sanitize_title('Italy')
					) ,
					Array(
						'name' => __('Jamaica', 'wp-easy-contact') ,
						'slug' => sanitize_title('Jamaica')
					) ,
					Array(
						'name' => __('Japan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Japan')
					) ,
					Array(
						'name' => __('Jersey', 'wp-easy-contact') ,
						'slug' => sanitize_title('Jersey')
					) ,
					Array(
						'name' => __('Jordan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Jordan')
					) ,
					Array(
						'name' => __('Kazakhstan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Kazakhstan')
					) ,
					Array(
						'name' => __('Kenya', 'wp-easy-contact') ,
						'slug' => sanitize_title('Kenya')
					) ,
					Array(
						'name' => __('Kiribati', 'wp-easy-contact') ,
						'slug' => sanitize_title('Kiribati')
					) ,
					Array(
						'name' => __('Korea, Democratic People\'s Republic Of', 'wp-easy-contact') ,
						'slug' => sanitize_title('Korea, Democratic People\'s Republic Of')
					) ,
					Array(
						'name' => __('Korea, Republic Of', 'wp-easy-contact') ,
						'slug' => sanitize_title('Korea, Republic Of')
					) ,
					Array(
						'name' => __('Kuwait', 'wp-easy-contact') ,
						'slug' => sanitize_title('Kuwait')
					) ,
					Array(
						'name' => __('Kyrgyzstan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Kyrgyzstan')
					) ,
					Array(
						'name' => __('Lao People\'s Democratic Republic', 'wp-easy-contact') ,
						'slug' => sanitize_title('Lao People\'s Democratic Republic')
					) ,
					Array(
						'name' => __('Latvia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Latvia')
					) ,
					Array(
						'name' => __('Lebanon', 'wp-easy-contact') ,
						'slug' => sanitize_title('Lebanon')
					) ,
					Array(
						'name' => __('Lesotho', 'wp-easy-contact') ,
						'slug' => sanitize_title('Lesotho')
					) ,
					Array(
						'name' => __('Liberia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Liberia')
					) ,
					Array(
						'name' => __('Libyan Arab Jamahiriya', 'wp-easy-contact') ,
						'slug' => sanitize_title('Libyan Arab Jamahiriya')
					) ,
					Array(
						'name' => __('Liechtenstein', 'wp-easy-contact') ,
						'slug' => sanitize_title('Liechtenstein')
					) ,
					Array(
						'name' => __('Lithuania', 'wp-easy-contact') ,
						'slug' => sanitize_title('Lithuania')
					) ,
					Array(
						'name' => __('Luxembourg', 'wp-easy-contact') ,
						'slug' => sanitize_title('Luxembourg')
					) ,
					Array(
						'name' => __('Macao', 'wp-easy-contact') ,
						'slug' => sanitize_title('Macao')
					) ,
					Array(
						'name' => __('Macedonia, The Former Yugoslav Republic Of', 'wp-easy-contact') ,
						'slug' => sanitize_title('Macedonia, The Former Yugoslav Republic Of')
					) ,
					Array(
						'name' => __('Madagascar', 'wp-easy-contact') ,
						'slug' => sanitize_title('Madagascar')
					) ,
					Array(
						'name' => __('Malawi', 'wp-easy-contact') ,
						'slug' => sanitize_title('Malawi')
					) ,
					Array(
						'name' => __('Malaysia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Malaysia')
					) ,
					Array(
						'name' => __('Maldives', 'wp-easy-contact') ,
						'slug' => sanitize_title('Maldives')
					) ,
					Array(
						'name' => __('Mali', 'wp-easy-contact') ,
						'slug' => sanitize_title('Mali')
					) ,
					Array(
						'name' => __('Malta', 'wp-easy-contact') ,
						'slug' => sanitize_title('Malta')
					) ,
					Array(
						'name' => __('Marshall Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Marshall Islands')
					) ,
					Array(
						'name' => __('Martinique', 'wp-easy-contact') ,
						'slug' => sanitize_title('Martinique')
					) ,
					Array(
						'name' => __('Mauritania', 'wp-easy-contact') ,
						'slug' => sanitize_title('Mauritania')
					) ,
					Array(
						'name' => __('Mauritius', 'wp-easy-contact') ,
						'slug' => sanitize_title('Mauritius')
					) ,
					Array(
						'name' => __('Mayotte', 'wp-easy-contact') ,
						'slug' => sanitize_title('Mayotte')
					) ,
					Array(
						'name' => __('Mexico', 'wp-easy-contact') ,
						'slug' => sanitize_title('Mexico')
					) ,
					Array(
						'name' => __('Micronesia, Federated States Of', 'wp-easy-contact') ,
						'slug' => sanitize_title('Micronesia, Federated States Of')
					) ,
					Array(
						'name' => __('Moldova, Republic Of', 'wp-easy-contact') ,
						'slug' => sanitize_title('Moldova, Republic Of')
					) ,
					Array(
						'name' => __('Monaco', 'wp-easy-contact') ,
						'slug' => sanitize_title('Monaco')
					) ,
					Array(
						'name' => __('Mongolia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Mongolia')
					) ,
					Array(
						'name' => __('Montenegro', 'wp-easy-contact') ,
						'slug' => sanitize_title('Montenegro')
					) ,
					Array(
						'name' => __('Montserrat', 'wp-easy-contact') ,
						'slug' => sanitize_title('Montserrat')
					) ,
					Array(
						'name' => __('Morocco', 'wp-easy-contact') ,
						'slug' => sanitize_title('Morocco')
					) ,
					Array(
						'name' => __('Mozambique', 'wp-easy-contact') ,
						'slug' => sanitize_title('Mozambique')
					) ,
					Array(
						'name' => __('Myanmar', 'wp-easy-contact') ,
						'slug' => sanitize_title('Myanmar')
					) ,
					Array(
						'name' => __('Namibia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Namibia')
					) ,
					Array(
						'name' => __('Nauru', 'wp-easy-contact') ,
						'slug' => sanitize_title('Nauru')
					) ,
					Array(
						'name' => __('Nepal', 'wp-easy-contact') ,
						'slug' => sanitize_title('Nepal')
					) ,
					Array(
						'name' => __('Netherlands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Netherlands')
					) ,
					Array(
						'name' => __('Netherlands Antilles', 'wp-easy-contact') ,
						'slug' => sanitize_title('Netherlands Antilles')
					) ,
					Array(
						'name' => __('New Caledonia', 'wp-easy-contact') ,
						'slug' => sanitize_title('New Caledonia')
					) ,
					Array(
						'name' => __('New Zealand', 'wp-easy-contact') ,
						'slug' => sanitize_title('New Zealand')
					) ,
					Array(
						'name' => __('Nicaragua', 'wp-easy-contact') ,
						'slug' => sanitize_title('Nicaragua')
					) ,
					Array(
						'name' => __('Niger', 'wp-easy-contact') ,
						'slug' => sanitize_title('Niger')
					) ,
					Array(
						'name' => __('Nigeria', 'wp-easy-contact') ,
						'slug' => sanitize_title('Nigeria')
					) ,
					Array(
						'name' => __('Niue', 'wp-easy-contact') ,
						'slug' => sanitize_title('Niue')
					) ,
					Array(
						'name' => __('Norfolk Island', 'wp-easy-contact') ,
						'slug' => sanitize_title('Norfolk Island')
					) ,
					Array(
						'name' => __('Northern Mariana Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Northern Mariana Islands')
					) ,
					Array(
						'name' => __('Norway', 'wp-easy-contact') ,
						'slug' => sanitize_title('Norway')
					) ,
					Array(
						'name' => __('Oman', 'wp-easy-contact') ,
						'slug' => sanitize_title('Oman')
					) ,
					Array(
						'name' => __('Pakistan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Pakistan')
					) ,
					Array(
						'name' => __('Palau', 'wp-easy-contact') ,
						'slug' => sanitize_title('Palau')
					) ,
					Array(
						'name' => __('Palestinian Territory, Occupied', 'wp-easy-contact') ,
						'slug' => sanitize_title('Palestinian Territory, Occupied')
					) ,
					Array(
						'name' => __('Panama', 'wp-easy-contact') ,
						'slug' => sanitize_title('Panama')
					) ,
					Array(
						'name' => __('Papua New Guinea', 'wp-easy-contact') ,
						'slug' => sanitize_title('Papua New Guinea')
					) ,
					Array(
						'name' => __('Paraguay', 'wp-easy-contact') ,
						'slug' => sanitize_title('Paraguay')
					) ,
					Array(
						'name' => __('Peru', 'wp-easy-contact') ,
						'slug' => sanitize_title('Peru')
					) ,
					Array(
						'name' => __('Philippines', 'wp-easy-contact') ,
						'slug' => sanitize_title('Philippines')
					) ,
					Array(
						'name' => __('Pitcairn', 'wp-easy-contact') ,
						'slug' => sanitize_title('Pitcairn')
					) ,
					Array(
						'name' => __('Poland', 'wp-easy-contact') ,
						'slug' => sanitize_title('Poland')
					) ,
					Array(
						'name' => __('Portugal', 'wp-easy-contact') ,
						'slug' => sanitize_title('Portugal')
					) ,
					Array(
						'name' => __('Puerto Rico', 'wp-easy-contact') ,
						'slug' => sanitize_title('Puerto Rico')
					) ,
					Array(
						'name' => __('Qatar', 'wp-easy-contact') ,
						'slug' => sanitize_title('Qatar')
					) ,
					Array(
						'name' => __('Reunion', 'wp-easy-contact') ,
						'slug' => sanitize_title('Reunion')
					) ,
					Array(
						'name' => __('Romania', 'wp-easy-contact') ,
						'slug' => sanitize_title('Romania')
					) ,
					Array(
						'name' => __('Russian Federation', 'wp-easy-contact') ,
						'slug' => sanitize_title('Russian Federation')
					) ,
					Array(
						'name' => __('Rwanda', 'wp-easy-contact') ,
						'slug' => sanitize_title('Rwanda')
					) ,
					Array(
						'name' => __('Saint Helena', 'wp-easy-contact') ,
						'slug' => sanitize_title('Saint Helena')
					) ,
					Array(
						'name' => __('Saint Kitts And Nevis', 'wp-easy-contact') ,
						'slug' => sanitize_title('Saint Kitts And Nevis')
					) ,
					Array(
						'name' => __('Saint Lucia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Saint Lucia')
					) ,
					Array(
						'name' => __('Saint Pierre And Miquelon', 'wp-easy-contact') ,
						'slug' => sanitize_title('Saint Pierre And Miquelon')
					) ,
					Array(
						'name' => __('Saint Vincent And The Grenadines', 'wp-easy-contact') ,
						'slug' => sanitize_title('Saint Vincent And The Grenadines')
					) ,
					Array(
						'name' => __('Samoa', 'wp-easy-contact') ,
						'slug' => sanitize_title('Samoa')
					) ,
					Array(
						'name' => __('San Marino', 'wp-easy-contact') ,
						'slug' => sanitize_title('San Marino')
					) ,
					Array(
						'name' => __('Sao Tome And Principe', 'wp-easy-contact') ,
						'slug' => sanitize_title('Sao Tome And Principe')
					) ,
					Array(
						'name' => __('Saudi Arabia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Saudi Arabia')
					) ,
					Array(
						'name' => __('Senegal', 'wp-easy-contact') ,
						'slug' => sanitize_title('Senegal')
					) ,
					Array(
						'name' => __('Serbia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Serbia')
					) ,
					Array(
						'name' => __('Seychelles', 'wp-easy-contact') ,
						'slug' => sanitize_title('Seychelles')
					) ,
					Array(
						'name' => __('Sierra Leone', 'wp-easy-contact') ,
						'slug' => sanitize_title('Sierra Leone')
					) ,
					Array(
						'name' => __('Singapore', 'wp-easy-contact') ,
						'slug' => sanitize_title('Singapore')
					) ,
					Array(
						'name' => __('Slovakia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Slovakia')
					) ,
					Array(
						'name' => __('Slovenia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Slovenia')
					) ,
					Array(
						'name' => __('Solomon Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Solomon Islands')
					) ,
					Array(
						'name' => __('Somalia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Somalia')
					) ,
					Array(
						'name' => __('South Africa', 'wp-easy-contact') ,
						'slug' => sanitize_title('South Africa')
					) ,
					Array(
						'name' => __('South Georgia And The South Sandwich Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('South Georgia And The South Sandwich Islands')
					) ,
					Array(
						'name' => __('Spain', 'wp-easy-contact') ,
						'slug' => sanitize_title('Spain')
					) ,
					Array(
						'name' => __('Sri Lanka', 'wp-easy-contact') ,
						'slug' => sanitize_title('Sri Lanka')
					) ,
					Array(
						'name' => __('Sudan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Sudan')
					) ,
					Array(
						'name' => __('Suriname', 'wp-easy-contact') ,
						'slug' => sanitize_title('Suriname')
					) ,
					Array(
						'name' => __('Svalbard And Jan Mayen', 'wp-easy-contact') ,
						'slug' => sanitize_title('Svalbard And Jan Mayen')
					) ,
					Array(
						'name' => __('Swaziland', 'wp-easy-contact') ,
						'slug' => sanitize_title('Swaziland')
					) ,
					Array(
						'name' => __('Sweden', 'wp-easy-contact') ,
						'slug' => sanitize_title('Sweden')
					) ,
					Array(
						'name' => __('Switzerland', 'wp-easy-contact') ,
						'slug' => sanitize_title('Switzerland')
					) ,
					Array(
						'name' => __('Syrian Arab Republic', 'wp-easy-contact') ,
						'slug' => sanitize_title('Syrian Arab Republic')
					) ,
					Array(
						'name' => __('Taiwan, Province Of China', 'wp-easy-contact') ,
						'slug' => sanitize_title('Taiwan, Province Of China')
					) ,
					Array(
						'name' => __('Tajikistan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Tajikistan')
					) ,
					Array(
						'name' => __('Tanzania, United Republic Of', 'wp-easy-contact') ,
						'slug' => sanitize_title('Tanzania, United Republic Of')
					) ,
					Array(
						'name' => __('Thailand', 'wp-easy-contact') ,
						'slug' => sanitize_title('Thailand')
					) ,
					Array(
						'name' => __('Timor-leste', 'wp-easy-contact') ,
						'slug' => sanitize_title('Timor-leste')
					) ,
					Array(
						'name' => __('Togo', 'wp-easy-contact') ,
						'slug' => sanitize_title('Togo')
					) ,
					Array(
						'name' => __('Tokelau', 'wp-easy-contact') ,
						'slug' => sanitize_title('Tokelau')
					) ,
					Array(
						'name' => __('Tonga', 'wp-easy-contact') ,
						'slug' => sanitize_title('Tonga')
					) ,
					Array(
						'name' => __('Trinidad And Tobago', 'wp-easy-contact') ,
						'slug' => sanitize_title('Trinidad And Tobago')
					) ,
					Array(
						'name' => __('Tunisia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Tunisia')
					) ,
					Array(
						'name' => __('Turkey', 'wp-easy-contact') ,
						'slug' => sanitize_title('Turkey')
					) ,
					Array(
						'name' => __('Turkmenistan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Turkmenistan')
					) ,
					Array(
						'name' => __('Turks And Caicos Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('Turks And Caicos Islands')
					) ,
					Array(
						'name' => __('Tuvalu', 'wp-easy-contact') ,
						'slug' => sanitize_title('Tuvalu')
					) ,
					Array(
						'name' => __('Uganda', 'wp-easy-contact') ,
						'slug' => sanitize_title('Uganda')
					) ,
					Array(
						'name' => __('Ukraine', 'wp-easy-contact') ,
						'slug' => sanitize_title('Ukraine')
					) ,
					Array(
						'name' => __('United Arab Emirates', 'wp-easy-contact') ,
						'slug' => sanitize_title('United Arab Emirates')
					) ,
					Array(
						'name' => __('United Kingdom', 'wp-easy-contact') ,
						'slug' => sanitize_title('United Kingdom')
					) ,
					Array(
						'name' => __('United States', 'wp-easy-contact') ,
						'slug' => sanitize_title('United States')
					) ,
					Array(
						'name' => __('United States Minor Outlying Islands', 'wp-easy-contact') ,
						'slug' => sanitize_title('United States Minor Outlying Islands')
					) ,
					Array(
						'name' => __('Uruguay', 'wp-easy-contact') ,
						'slug' => sanitize_title('Uruguay')
					) ,
					Array(
						'name' => __('Uzbekistan', 'wp-easy-contact') ,
						'slug' => sanitize_title('Uzbekistan')
					) ,
					Array(
						'name' => __('Vanuatu', 'wp-easy-contact') ,
						'slug' => sanitize_title('Vanuatu')
					) ,
					Array(
						'name' => __('Venezuela', 'wp-easy-contact') ,
						'slug' => sanitize_title('Venezuela')
					) ,
					Array(
						'name' => __('Viet Nam', 'wp-easy-contact') ,
						'slug' => sanitize_title('Viet Nam')
					) ,
					Array(
						'name' => __('Virgin Islands, British', 'wp-easy-contact') ,
						'slug' => sanitize_title('Virgin Islands, British')
					) ,
					Array(
						'name' => __('Virgin Islands, U.S.', 'wp-easy-contact') ,
						'slug' => sanitize_title('Virgin Islands, U.S.')
					) ,
					Array(
						'name' => __('Wallis And Futuna', 'wp-easy-contact') ,
						'slug' => sanitize_title('Wallis And Futuna')
					) ,
					Array(
						'name' => __('Western Sahara', 'wp-easy-contact') ,
						'slug' => sanitize_title('Western Sahara')
					) ,
					Array(
						'name' => __('Yemen', 'wp-easy-contact') ,
						'slug' => sanitize_title('Yemen')
					) ,
					Array(
						'name' => __('Zambia', 'wp-easy-contact') ,
						'slug' => sanitize_title('Zambia')
					) ,
					Array(
						'name' => __('Zimbabwe', 'wp-easy-contact') ,
						'slug' => sanitize_title('Zimbabwe')
					)
				)
			);
			$tax_list['emd_contact']['contact_tag'] = Array(
				'archive_view' => 0,
				'label' => __('Contact Tags', 'wp-easy-contact') ,
				'single_label' => __('Contact Tag', 'wp-easy-contact') ,
				'default' => '',
				'type' => 'multi',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'contact_tag'
			);
			$tax_list['emd_contact']['contact_topic'] = Array(
				'archive_view' => 0,
				'label' => __('Topics', 'wp-easy-contact') ,
				'single_label' => __('Topic', 'wp-easy-contact') ,
				'default' => '',
				'type' => 'single',
				'hier' => 0,
				'sortable' => 0,
				'list_visible' => 0,
				'required' => 0,
				'srequired' => 0,
				'rewrite' => 'contact_topic',
				'init_values' => Array(
					Array(
						'name' => __('Customer Service', 'wp-easy-contact') ,
						'slug' => sanitize_title('Customer Service')
					) ,
					Array(
						'name' => __('Product Information', 'wp-easy-contact') ,
						'slug' => sanitize_title('Product Information')
					) ,
					Array(
						'name' => __('My Account', 'wp-easy-contact') ,
						'slug' => sanitize_title('My Account')
					) ,
					Array(
						'name' => __('Customer Feedback', 'wp-easy-contact') ,
						'slug' => sanitize_title('Customer Feedback')
					)
				)
			);
			$tax_list = apply_filters('emd_ext_tax_list', $tax_list, $this->option_name);
			if (!empty($tax_list)) {
				update_option($this->option_name . '_tax_list', $tax_list);
			}
			$emd_activated_plugins = get_option('emd_activated_plugins');
			if (!$emd_activated_plugins) {
				update_option('emd_activated_plugins', Array(
					'wp-easy-contact'
				));
			} elseif (!in_array('wp-easy-contact', $emd_activated_plugins)) {
				array_push($emd_activated_plugins, 'wp-easy-contact');
				update_option('emd_activated_plugins', $emd_activated_plugins);
			}
			//conf parameters for incoming email
			$has_incoming_email = Array(
				'emd_contact' => Array(
					'label' => 'Contacts',
					'status' => 'publish',
					'vis_submit' => 1,
					'vis_status' => 'publish',
					'tax' => 'contact_tag',
					'subject' => 'blt_title',
					'date' => Array(
						'post_date'
					) ,
					'body' => 'emd_blt_content',
					'att' => '',
					'email' => 'emd_contact_email',
					'name' => Array(
						'emd_contact_first_name',
						'emd_contact_last_name',
					)
				)
			);
			update_option($this->option_name . '_has_incoming_email', $has_incoming_email);
			$emd_inc_email_apps = get_option('emd_inc_email_apps');
			$emd_inc_email_apps[$this->option_name] = $this->option_name . '_inc_email_conf';
			update_option('emd_inc_email_apps', $emd_inc_email_apps);
			//conf parameters for inline entity
			//conf parameters for calendar
			//conf parameters for mailchimp
			$has_mailchimp = Array(
				'contact_submit' => Array(
					'entity' => 'emd_contact',
					'tax' => Array(
						'contact_topic'
					)
				)
			);
			update_option($this->option_name . '_has_mailchimp', $has_mailchimp);
			//action to configure different extension conf parameters for this plugin
			do_action('emd_ext_set_conf', 'wp-easy-contact');
		}
		/**
		 * Reset app specific options
		 *
		 * @since WPAS 4.0
		 *
		 */
		private function reset_options() {
			delete_option($this->option_name . '_shc_list');
			$incemail_settings = get_option('emd_inc_email_apps', Array());
			unset($incemail_settings[$this->option_name]);
			update_option('emd_inc_email_apps', $incemail_settings);
			delete_option($this->option_name . '_has_incoming_email');
			delete_option($this->option_name . '_has_mailchimp');
			do_action('emd_ext_reset_conf', 'wp-easy-contact');
		}
		/**
		 * Show admin notices
		 *
		 * @since WPAS 4.0
		 *
		 * @return html
		 */
		public function install_notice() {
			if (isset($_GET[$this->option_name . '_adm_notice1'])) {
				update_option($this->option_name . '_adm_notice1', true);
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_adm_notice1') != 1) {
?>
<div class="updated">
<?php
				printf('<p><a href="%1s" target="_blank"> %2$s </a>%3$s<a style="float:right;" href="%4$s"><span class="dashicons dashicons-dismiss" style="font-size:15px;"></span>%5$s</a></p>', 'https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/?pk_campaign=wpeasycontact&pk_source=plugin&pk_medium=link&pk_content=notice', __('New To WP Easy Contact? Review the documentation!', 'wpas') , __('&#187;', 'wpas') , esc_url(add_query_arg($this->option_name . '_adm_notice1', true)) , __('Dismiss', 'wpas'));
?>
</div>
<?php
			}
			if (isset($_GET[$this->option_name . '_adm_notice2'])) {
				update_option($this->option_name . '_adm_notice2', true);
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_adm_notice2') != 1) {
?>
<div class="updated">
<?php
				printf('<p><a href="%1s" target="_blank"> %2$s </a>%3$s<a style="float:right;" href="%4$s"><span class="dashicons dashicons-dismiss" style="font-size:15px;"></span>%5$s</a></p>', 'https://emdplugins.com/plugins/wp-easy-contact-wordpress-plugin?pk_campaign=wpeasycontact&pk_source=plugin&pk_medium=link&pk_content=notice', __('Grow Your Contacts Faster Now!', 'wpas') , __('&#187;', 'wpas') , esc_url(add_query_arg($this->option_name . '_adm_notice2', true)) , __('Dismiss', 'wpas'));
?>
</div>
<?php
			}
			if (current_user_can('manage_options') && get_option($this->option_name . '_setup_pages') == 1) {
				echo "<div id=\"message\" class=\"updated\"><p><strong>" . __('Welcome to WP Easy Contact', 'wp-easy-contact') . "</strong></p>
           <p class=\"submit\"><a href=\"" . add_query_arg('setup_wp_easy_contact_pages', 'true', admin_url('index.php')) . "\" class=\"button-primary\">" . __('Setup WP Easy Contact Pages', 'wp-easy-contact') . "</a> <a class=\"skip button-primary\" href=\"" . add_query_arg('skip_setup_wp_easy_contact_pages', 'true', admin_url('index.php')) . "\">" . __('Skip setup', 'wp-easy-contact') . "</a></p>
         </div>";
			}
		}
		/**
		 * Setup pages for components and redirect to dashboard
		 *
		 * @since WPAS 4.0
		 *
		 */
		public function setup_pages() {
			if (!is_admin()) {
				return;
			}
			if (!empty($_GET['setup_' . $this->option_name . '_pages'])) {
				$shc_list = get_option($this->option_name . '_shc_list');
				emd_create_install_pages($this->option_name, $shc_list);
				update_option($this->option_name . '_setup_pages', 2);
				wp_redirect(admin_url('admin.php?page=' . $this->option_name . '_settings&wp-easy-contact-installed=true'));
				exit;
			}
			if (!empty($_GET['skip_setup_' . $this->option_name . '_pages'])) {
				update_option($this->option_name . '_setup_pages', 2);
				wp_redirect(admin_url('admin.php?page=' . $this->option_name . '_settings'));
				exit;
			}
		}
		public function tinymce_fix($init) {
			global $post;
			$ent_list = get_option($this->option_name . '_ent_list', Array());
			if (!empty($post) && in_array($post->post_type, array_keys($ent_list))) {
				$init['wpautop'] = false;
				$init['indent'] = true;
			}
			return $init;
		}
	}
endif;
return new Wp_Easy_Contact_Install_Deactivate();
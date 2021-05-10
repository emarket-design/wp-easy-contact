<?php
/**
 * Entity Widget Classes
 *
 * @package WP_EASY_CONTACT
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * Entity widget class extends Emd_Widget class
 *
 * @since WPAS 4.0
 */
class wp_easy_contact_recent_contacts_widget extends Emd_Widget {
	public $title;
	public $text_domain = 'wp-easy-contact';
	public $class_label;
	public $class = 'emd_contact';
	public $type = 'entity';
	public $has_pages = false;
	public $css_label = 'recent-contacts';
	public $id = 'wp_easy_contact_recent_contacts_widget';
	public $query_args = array(
		'post_type' => 'emd_contact',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'context' => 'wp_easy_contact_recent_contacts_widget',
	);
	public $filter = '';
	public $header = '';
	public $footer = '';
	/**
	 * Instantiate entity widget class with params
	 *
	 * @since WPAS 4.0
	 */
	public function __construct() {
		parent::__construct($this->id, __('Recent Contacts', 'wp-easy-contact') , __('Contacts', 'wp-easy-contact') , __('The most recent contacts', 'wp-easy-contact'));
	}
	/**
	 * Get header and footer for layout
	 *
	 * @since WPAS 4.6
	 */
	protected function get_header_footer() {
		ob_start();
		emd_get_template_part('wp_easy_contact', 'widget', 'recent-contacts-header');
		$this->header = ob_get_clean();
		ob_start();
		emd_get_template_part('wp_easy_contact', 'widget', 'recent-contacts-footer');
		$this->footer = ob_get_clean();
	}
	/**
	 * Enqueue css and js for widget
	 *
	 * @since WPAS 4.5
	 */
	protected function enqueue_scripts() {
		wp_easy_contact_enq_custom_css_js();
	}
	/**
	 * Returns widget layout
	 *
	 * @since WPAS 4.0
	 */
	public static function layout() {
		ob_start();
		emd_get_template_part('wp_easy_contact', 'widget', 'recent-contacts-content');
		$layout = ob_get_clean();
		return $layout;
	}
}
$access_views = get_option('wp_easy_contact_access_views', Array());
if (empty($access_views['widgets']) || (!empty($access_views['widgets']) && in_array('recent_contacts', $access_views['widgets']) && current_user_can('view_recent_contacts'))) {
	register_widget('wp_easy_contact_recent_contacts_widget');
}
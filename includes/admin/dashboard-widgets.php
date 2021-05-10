<?php
/**
 * Admin Dashboard Functions
 *
 * @package WP_EASY_CONTACT
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * WP Dashboard setup function
 * @since WPAS 4.0
 *
 */
function wp_easy_contact_register_dashb_widgets() {
	if (current_user_can('configure_recent_dash_contacts')) {
		wp_add_dashboard_widget('wp_easy_contact_recent_dash_contacts', __('Recent Contacts', 'wp-easy-contact') , 'wp_easy_contact_recent_dash_contacts_dwidget', 'wp_easy_contact_recent_dash_contacts_dwidget_control');
	} else if (current_user_can('view_recent_dash_contacts')) {
		wp_add_dashboard_widget('wp_easy_contact_recent_dash_contacts', __('Recent Contacts', 'wp-easy-contact') , 'wp_easy_contact_recent_dash_contacts_dwidget', '');
	}
}
add_action('wp_dashboard_setup', 'wp_easy_contact_register_dashb_widgets');
/**
 * Dashboard entity widget display
 * @since WPAS 4.0
 *
 */
function wp_easy_contact_recent_dash_contacts_dwidget() {
	$args['has_pages'] = false;
	$args['class'] = 'emd_contact';
	$args['query_args'] = Array(
		'post_type' => 'emd_contact',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'context' => 'wp_easy_contact_recent_dash_contacts_widget',
	);
	$args['fname'] = 'wp_easy_contact_recent_dash_contacts_layout';
	$args['app'] = 'wp_easy_contact';
	$args['filter'] = '';
	$args['header'] = '';
	$args['footer'] = '';
	emd_dashboard_widget('wp_easy_contact_recent_dash_contacts', 'entity', $args);
}
/**
 * Dashboard entity widget control
 * @since WPAS 4.0
 *
 */
function wp_easy_contact_recent_dash_contacts_dwidget_control() {
	emd_dashboard_widget_control('wp_easy_contact_recent_dash_contacts', 'Contacts', 'entity');
}
/**
 * Dashboard entity widget layout
 * @since WPAS 4.0
 *
 */
function wp_easy_contact_recent_dash_contacts_layout() {
	ob_start();
	emd_get_template_part('wp_easy_contact', 'widget', 'recent-dash-contacts-content');
	$layout = ob_get_clean();
	return $layout;
}
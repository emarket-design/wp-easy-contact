<?php
/**
 * Plugin Page Feedback Functions
 *
 * @package WP_EASY_CONTACT
 * @since WPAS 5.3
 */
if (!defined('ABSPATH')) exit;
add_filter('plugin_row_meta', 'wp_easy_contact_plugin_row_meta', 10, 2);
add_filter('plugin_action_links', 'wp_easy_contact_plugin_action_links', 10, 2);
add_action('wp_ajax_wp_easy_contact_send_deactivate_reason', 'wp_easy_contact_send_deactivate_reason');
global $pagenow;
if ('plugins.php' === $pagenow) {
	add_action('admin_footer', 'wp_easy_contact_deactivation_feedback_box');
}
add_action('wp_ajax_wp_easy_contact_show_rateme', 'wp_easy_contact_show_rateme_action');
add_action('admin_notices', 'wp_easy_contact_show_optin');
add_action('admin_post_wp-easy-contact_check_optin', 'wp_easy_contact_check_optin');
function wp_easy_contact_check_optin() {
	if (!empty($_POST['wp-easy-contact_optin'])) {
		if (!function_exists('wp_get_current_user')) {
			require_once (ABSPATH . 'wp-includes/pluggable.php');
		}
		$current_user = wp_get_current_user();
		if (!empty($_POST['optin-email']) && is_email($_POST['optin-email'])) {
			$data['email'] = sanitize_email($_POST['optin-email']);
			$data['plugin_name'] = 'wp_easy_contact';
			$data['plugin_version'] = WP_EASY_CONTACT_VERSION;
			$data['wp_version'] = get_bloginfo('version');
			$data['php_version'] = phpversion();
			$data['server'] = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '';
			if (!empty($current_user->user_firstname)) {
				$data['first_name'] = $current_user->user_firstname;
			}
			if (!empty($current_user->user_lastname)) {
				$data['last_name'] = $current_user->user_lastname;
			}
			$data['nick_name'] = $current_user->user_nicename;
			$data['site_name'] = get_bloginfo('name');
			$data['site_url'] = home_url();
			$data['language'] = get_bloginfo('language');
			$resp = wp_remote_post('https://api.emarketdesign.com/optin_info.php', array(
				'body' => $data,
			));
			update_option('wp_easy_contact_tracking_optin', 1);
		} else {
			//opt-out
			update_option('wp_easy_contact_tracking_optin', -1);
		}
	} elseif (!empty($_POST['wp-easy-contact_no_optin'])) {
		//opt-out
		update_option('wp_easy_contact_tracking_optin', -1);
	}
	wp_redirect(admin_url('admin.php?page=wp_easy_contact'));
	exit;
}
function wp_easy_contact_show_optin() {
	if (!current_user_can('manage_options')) {
		return;
	}
	if (!get_option('wp_easy_contact_tracking_optin')) {
		$tr_title = __('Please help us improve WP Easy Contact', 'wp-easy-contact');
		$tr_msg = implode('<br />', array(
			__('Allow eMDPlugins to collect your usage of WP Easy Contact. This will help you to get a better, more compatible plugin in the future.', 'wp-easy-contact') ,
			__('If you skip this, that\'s okay! WP Easy Contact will still work just fine.', 'wp-easy-contact') ,
		));
		$tr_link = implode(' ', array(
			'<input type="submit" value="' . __('Do not allow', 'wp-easy-contact') . '" class="button-secondary" name="wp-easy-contact_no_optin" id="wp-easy-contact-do-not-allow-tracking"></input>',
			'<input type="submit" value="' . __('Allow', 'wp-easy-contact') . '" class="button-primary" name="wp-easy-contact_optin" id="wp-easy-contact-allow-tracking"></input>',
		));
		echo '<form method="post" action="' . admin_url('admin-post.php') . '">';
		echo '<input type="hidden" name="action" value="wp-easy-contact_check_optin">';
		echo '<div class="update-nag emd-admin-notice">';
		echo '<h3 class="emd-notice-title"><span class="dashicons dashicons-smiley"></span>' . $tr_title . '<span class="dashicons dashicons-smiley"></span></h3><p class="emd-notice-body">';
		echo $tr_msg . '</p>';
		echo '<p>' . __('Please confirm your email address below to start receiving emails from us.', 'wp-easy-contact') . '</p>';
		$current_user = wp_get_current_user();
		if (!empty($current_user->user_email)) {
			$email = $current_user->user_email;
		} else {
			$email = get_option('admin_email');
		}
		echo '<input id="optin-email" name="optin-email" type="text" value="' . $email . '">';
		echo '<ul class="emd-notice-body nf-red">';
		echo $tr_link . '</ul><div class="emd-permissions"><a href="#" class="emd-perm-trigger"><span class="dashicons dashicons-info" style="text-decoration:none;"></span>' . __('What permissions are being granted?', 'wp-easy-contact') . '</a><ul class="emd-permissions-list" style="display:none;">';
		echo '<li class="emd-permission"><i class="dashicons dashicons-nametag"></i><div><span>' . __('Your Profile Overview', 'wp-easy-contact') . '</span><p>' . __('Name and email address', 'wp-easy-contact') . '</p></div></li>';
		echo '<li class="emd-permission"><i class="dashicons dashicons-admin-settings"></i><div><span>' . __('Your Site Overview', 'wp-easy-contact') . '</span><p>' . __('Site URL, WP version and PHP info', 'wp-easy-contact') . '</p></div></li>';
		echo '<li class="emd-permission"><i class="dashicons dashicons-email-alt"></i><div><span>' . __('Newsletter', 'wp-easy-contact') . '</span><p>' . __('Updates, announcements, marketing, no spam', 'wp-easy-contact') . ', <a href="https://emdplugins.smartlamb.com/subscription-preferences/" target="_blank">unsubscribe anytime</a></p></div></li>';
		echo '</ul></div></div></form>';
	} else {
		//check min entity count if its not -1 then show notice
		$min_trigger = get_option('wp_easy_contact_show_rateme_plugin_min', 10);
		if ($min_trigger != - 1) {
			wp_easy_contact_show_rateme_notice();
		}
	}
}
function wp_easy_contact_show_rateme_action() {
	if (!wp_verify_nonce($_POST['rateme_nonce'], 'wp_easy_contact_rateme_nonce')) {
		exit;
	}
	$min_trigger = get_option('wp_easy_contact_show_rateme_plugin_min', 10);
	if ($min_trigger == - 1) {
		die;
	}
	if (10 === $min_trigger) {
		$response['redirect'] = "https://wordpress.org/support/plugin/wp-easy-contact/reviews/#postform";
		$min_trigger = 20;
	} else {
		$response['redirect'] = "https://emdplugins.com/plugins/wp-easy-contact-wordpress-plugin/";
		$min_trigger = - 1;
	}
	update_option('wp_easy_contact_show_rateme_plugin_min', $min_trigger);
	echo json_encode($response);
	die;
}
function wp_easy_contact_show_rateme_notice() {
	if (!current_user_can('manage_options')) {
		return;
	}
	$min_count = 0;
	$ent_list = get_option('wp_easy_contact_ent_list');
	$min_trigger = get_option('wp_easy_contact_show_rateme_plugin_min', 10);
	$triggerdate = get_option('wp_easy_contact_activation_date', false);
	$installed_date = (!empty($triggerdate) ? $triggerdate : '999999999999999');
	$today = mktime(0, 0, 0, date('m') , date('d') , date('Y'));
	$label = $ent_list['emd_contact']['label'];
	$count_posts = wp_count_posts('emd_contact');
	if ($count_posts->publish > $min_trigger) {
		$min_count = $count_posts->publish;
	}
	if ($min_count > 10 || ($min_trigger == 10 && $installed_date <= $today)) {
		$message_start = '<div class="emd-show-rateme update-nag success" style="border-radius:40px;">
                        <br>
                        <div>';
		if ($min_count > 5) {
			$message_start.= sprintf(__("Hi, I noticed you just crossed the %d %s milestone - that's awesome!", "wp-easy-contact") , $min_trigger, $label);
		} elseif ($installed_date <= $today) {
			$message_start.= __("Hi, I just noticed you have been using WP Easy Contact for about a week now - that's awesome!", "wp-easy-contact");
		}
		$message_level1 = __('Give <b>WP Easy Contact</b> a <span style="color:red" class="dashicons dashicons-heart"></span> 5 star review <span style="color:red" class="dashicons dashicons-heart"></span> to help fellow WordPress users like YOU find it faster! <u>Your 5 star review</u> brings YOU a better FREE product and faster, motivated support when YOU need help.', 'wp-easy-contact');
		$message_level2 = sprintf(__("Would you like to upgrade now to get more out of your %s?", "wp-easy-contact") , $label);
		$message_end = '<br/><br/>
                        <strong>Safiye Duman</strong><br>eMarket Design Cofounder<br><a data-rate-action="twitter" style="text-decoration:none" href="https://twitter.com/safiye_emd" target="_blank"><span class="dashicons dashicons-twitter"></span>@safiye_emd</a>
                        </div>
                        <div style="background-color: #f0f8ff;padding: 0 0 10px 10px;width: 400px;border: 1px solid;border-radius: 10px;margin: 14px 0;"><br><strong>Thank you</strong> <span class="dashicons dashicons-smiley"></span>
                        <ul data-nonce="' . wp_create_nonce('wp_easy_contact_rateme_nonce') . '">';
		$message_end1 = '<li><a data-rate-action="do-rate" data-plugin="wp_easy_contact" href="#">' . __('Yes, I want a better FREE product and faster support', 'wp-easy-contact') . '</a>
       </li>
        <li><a data-rate-action="done-rating" data-plugin="wp_easy_contact" href="#">' . __('I already did - Thank you', 'wp-easy-contact') . '</a></li>
        <li><a data-rate-action="not-enough" data-plugin="wp_easy_contact" href="#">' . __('No, I don\'t want a better FREE product and faster support', 'wp-easy-contact') . '</a></li>';
		$message_end2 = '<li><a data-rate-action="upgrade-now" data-plugin="wp_easy_contact" href="#">' . __('I want to upgrade', 'wp-easy-contact') . '</a>
       </li>
        <li><a data-rate-action="not-enough" data-plugin="wp_easy_contact" href="#">' . __('Maybe later', 'wp-easy-contact') . '</a></li>';
	}
	if ($min_count > 20 && $min_trigger == 20) {
		echo $message_start . '<br><br>' . $message_level2 . ' ' . $message_end . ' ' . $message_end2 . '</ul></div></div>';
	} elseif ($min_count > 10 || ($min_trigger == 10 && $installed_date <= $today)) {
		echo $message_start . '<br><br>' . $message_level1 . ' ' . $message_end . ' ' . $message_end1 . '</ul></div></div>';
	}
}
/**
 * Adds links under plugin description
 *
 * @since WPAS 5.3
 * @param array $input
 * @param string $file
 * @return array $input
 */
function wp_easy_contact_plugin_row_meta($input, $file) {
	if ($file != 'wp-easy-contact/wp-easy-contact.php') return $input;
	$links = array(
		'<a href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/">' . __('Docs', 'wp-easy-contact') . '</a>',
		'<a href="https://emdplugins.com/plugins/wp-easy-contact-wordpress-plugin/">' . __('Pro Version', 'wp-easy-contact') . '</a>'
	);
	$input = array_merge($input, $links);
	return $input;
}
/**
 * Adds links under plugin description
 *
 * @since WPAS 5.3
 * @param array $input
 * @param string $file
 * @return array $input
 */
function wp_easy_contact_plugin_action_links($links, $file) {
	if ($file != 'wp-easy-contact/wp-easy-contact.php') return $links;
	foreach ($links as $key => $link) {
		if ('deactivate' === $key) {
			$links[$key] = $link . '<i class="wp_easy_contact-deactivate-slug" data-slug="wp_easy_contact-deactivate-slug"></i>';
		}
	}
	$new_links['settings'] = '<a href="' . admin_url('admin.php?page=wp_easy_contact_settings') . '">' . __('Settings', 'wp-easy-contact') . '</a>';
	$links = array_merge($new_links, $links);
	return $links;
}
function wp_easy_contact_deactivation_feedback_box() {
	$is_long_term_user = true;
	$feedback_vars['utype'] = 0;
	$trigger_time = get_option('wp_easy_contact_activation_date');
	//7 days before trigger
	$activation_time = $trigger_time - 604800;
	$date_diff = time() - $activation_time;
	$date_diff_days = floor($date_diff / (60 * 60 * 24));
	if ($date_diff_days < 2) {
		$feedback_vars['utype'] = 1;
		$is_long_term_user = false;
	}
	wp_enqueue_style("emd-plugin-modal", WP_EASY_CONTACT_PLUGIN_URL . 'assets/css/emd-plugin-modal.css');
	$feedback_vars['header'] = __('If you have a moment, please let us know why you are deactivating', 'wp-easy-contact');
	$feedback_vars['submit'] = __('Submit & Deactivate', 'wp-easy-contact');
	$feedback_vars['skip'] = __('Skip & Deactivate', 'wp-easy-contact');
	$feedback_vars['cancel'] = __('Cancel', 'wp-easy-contact');
	$feedback_vars['ask_reason'] = __('Please share the reason so we can improve', 'wp-easy-contact');
	$feedback_vars['ticket'] = __('Would you like to open a support ticket?', 'wp-easy-contact');
	$feedback_vars['emplach'] = __('Please enter your email address.', 'wp-easy-contact');
	$feedback_vars['nonce'] = wp_create_nonce('wp_easy_contact_deactivate_nonce');
	if ($is_long_term_user) {
		$reasons[1] = __('I no longer need the plugin', 'wp-easy-contact');
		$reasons[3] = __('I only needed the plugin for a short period', 'wp-easy-contact');
		$reasons[9] = __('The plugin update did not work as expected', 'wp-easy-contact');
		$reasons[5] = __('The plugin suddenly stopped working', 'wp-easy-contact');
		$reasons[2] = __('I found a better plugin', 'wp-easy-contact');
	} else {
		$reasons[21] = __('I couldn\'t understand how to make it work', 'wp-easy-contact');
		$reasons[22] = __('The plugin is not working', 'wp-easy-contact');
		$reasons[23] = __('It\'s not what I was looking for', 'wp-easy-contact');
		$reasons[24] = __('The plugin didn\'t work as expected', 'wp-easy-contact');
		$reasons[8] = __('The plugin is great, but I need a specific feature that is not currently supported', 'wp-easy-contact');
		$reasons[2] = __('I found a better plugin', 'wp-easy-contact');
	}
	$shuffle_keys = array_keys($reasons);
	shuffle($shuffle_keys);
	foreach ($shuffle_keys as $key) {
		$new_reasons[$key] = $reasons[$key];
	}
	$reasons = $new_reasons;
	//all
	$reasons[6] = __('It\'s a temporary deactivation. I\'m just debugging an issue', 'wp-easy-contact');
	$reasons[7] = __('Other', 'wp-easy-contact');
	$feedback_vars['disclaimer'] = __('No private information is sent during your submission. Thank you very much for your help improving our plugin.', 'wp-easy-contact');
	$feedback_vars['reasons'] = '';
	foreach ($reasons as $key => $reason) {
		$feedback_vars['reasons'].= '<li class="reason';
		if (in_array($key, Array(
			2,
			7,
			8,
			9,
			5,
			22,
			23,
			24
		))) {
			$feedback_vars['reasons'].= ' has-input';
		}
		$feedback_vars['reasons'].= '"';
		switch ($key) {
			case 2:
				$feedback_vars['reasons'].= 'data-input-type="textfield"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share the plugin name.', 'wp-easy-contact') . '"';
			break;
			case 8:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share the feature that you were looking for so that we can develop it in the future releases.', 'wp-easy-contact') . '"';
			break;
			case 9:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('We are sorry to hear that. Please share your previous version number before update, new updated version number and detailed description of what happened.', 'wp-easy-contact') . '"';
			break;
			case 5:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('We are sorry to hear that. Please share the detailed description of what happened.', 'wp-easy-contact') . '"';
			break;
			case 22:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share what didn\'t work so we can fix it in the future releases.', 'wp-easy-contact') . '"';
			break;
			case 23:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share what you were looking for.', 'wp-easy-contact') . '"';
			break;
			case 24:
				$feedback_vars['reasons'].= 'data-input-type="textarea"';
				$feedback_vars['reasons'].= 'data-input-placeholder="' . __('Please share what you expected.', 'wp-easy-contact') . '"';
			break;
			default:
			break;
		}
		$feedback_vars['reasons'].= '><label><span>
                                        <input type="radio" name="selected-reason" value="' . $key . '"/>
                                        </span><span>' . $reason . '</span></label></li>';
	}
	wp_enqueue_script('emd-plugin-feedback', WP_EASY_CONTACT_PLUGIN_URL . 'assets/js/emd-plugin-feedback.js');
	wp_localize_script("emd-plugin-feedback", 'plugin_feedback_vars', $feedback_vars);
	wp_enqueue_script('wp-easy-contact-feedback', WP_EASY_CONTACT_PLUGIN_URL . 'assets/js/wp-easy-contact-feedback.js');
	$wp_easy_contact_vars['plugin'] = 'wp_easy_contact';
	wp_localize_script("wp-easy-contact-feedback", 'wp_easy_contact_vars', $wp_easy_contact_vars);
}
function wp_easy_contact_send_deactivate_reason() {
	if (empty($_POST['deactivate_nonce']) || !isset($_POST['reason_id'])) {
		exit;
	}
	if (!wp_verify_nonce($_POST['deactivate_nonce'], 'wp_easy_contact_deactivate_nonce')) {
		exit;
	}
	$uemail = '';
	$reason_info = isset($_POST['reason_info']) ? sanitize_text_field($_POST['reason_info']) : '';
	if (!empty($_POST['email']) && is_email($_POST['email'])) {
		$uemail = sanitize_email($_POST['email']);
	}
	if (!empty($uemail)) {
		$postfields['uemail'] = $uemail;
	}
	$postfields['utype'] = intval($_POST['utype']);
	$postfields['reason_id'] = intval($_POST['reason_id']);
	$postfields['plugin_name'] = sanitize_text_field($_POST['plugin_name']);
	if (!empty($reason_info)) {
		$postfields['reason_info'] = $reason_info;
	}
	$args = array(
		'body' => $postfields,
		'sslverify' => false,
		'timeout' => 15,
	);
	$resp = wp_remote_post('https://api.emarketdesign.com/deactivate_info.php', $args);
	echo 1;
	exit;
}
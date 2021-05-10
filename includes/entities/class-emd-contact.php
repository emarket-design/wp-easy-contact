<?php
/**
 * Entity Class
 *
 * @package WP_EASY_CONTACT
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
/**
 * Emd_Contact Class
 * @since WPAS 4.0
 */
class Emd_Contact extends Emd_Entity {
	protected $post_type = 'emd_contact';
	protected $textdomain = 'wp-easy-contact';
	protected $sing_label;
	protected $plural_label;
	protected $menu_entity;
	protected $id;
	/**
	 * Initialize entity class
	 *
	 * @since WPAS 4.0
	 *
	 */
	public function __construct() {
		add_action('init', array(
			$this,
			'set_filters'
		) , 1);
		add_action('admin_init', array(
			$this,
			'set_metabox'
		));
		add_filter('post_updated_messages', array(
			$this,
			'updated_messages'
		));
		add_action('admin_menu', array(
			$this,
			'add_menu_link'
		));
		add_action('admin_head-edit.php', array(
			$this,
			'add_opt_button'
		));
		$is_adv_filt_ext = apply_filters('emd_adv_filter_on', 0);
		if ($is_adv_filt_ext === 0) {
			add_action('manage_emd_contact_posts_custom_column', array(
				$this,
				'custom_columns'
			) , 10, 2);
			add_filter('manage_emd_contact_posts_columns', array(
				$this,
				'column_headers'
			));
		}
		add_filter('is_protected_meta', array(
			$this,
			'hide_attrs'
		) , 10, 2);
		add_filter('postmeta_form_keys', array(
			$this,
			'cust_keys'
		) , 10, 2);
		add_filter('emd_get_cust_fields', array(
			$this,
			'get_cust_fields'
		) , 10, 2);
		add_filter('enter_title_here', array(
			$this,
			'change_title_text'
		));
		add_action('admin_init', array(
			$this,
			'set_single_taxs'
		));
		add_filter('post_row_actions', array(
			$this,
			'duplicate_link'
		) , 10, 2);
		add_action('admin_action_emd_duplicate_entity', array(
			$this,
			'duplicate_entity'
		));
	}
	public function set_single_taxs() {
		global $pagenow;
		if ('post-new.php' === $pagenow || 'post.php' === $pagenow) {
			if ((isset($_REQUEST['post_type']) && $this->post_type === $_REQUEST['post_type']) || (isset($_REQUEST['post']) && get_post_type($_REQUEST['post']) === $this->post_type)) {
				$this->stax = new Emd_Single_Taxonomy('wp-easy-contact');
			}
		}
	}
	public function change_title_disable_emd_temp($title, $id) {
		$post = get_post($id);
		if ($this->post_type == $post->post_type && (!empty($this->id) && $this->id == $id)) {
			return '';
		}
		return $title;
	}
	/**
	 * Get custom attribute list
	 * @since WPAS 4.9
	 *
	 * @param array $cust_fields
	 * @param string $post_type
	 *
	 * @return array $new_keys
	 */
	public function get_cust_fields($cust_fields, $post_type) {
		global $wpdb;
		if ($post_type == $this->post_type) {
			$sql = "SELECT DISTINCT meta_key
               FROM $wpdb->postmeta a
               WHERE a.post_id IN (SELECT id FROM $wpdb->posts b WHERE b.post_type='" . $this->post_type . "')";
			$keys = $wpdb->get_col($sql);
			if (!empty($keys)) {
				foreach ($keys as $i => $mkey) {
					if (!preg_match('/^(_|wpas_|emd_)/', $mkey)) {
						$ckey = str_replace('-', '_', sanitize_title($mkey));
						$cust_fields[$ckey] = $mkey;
					}
				}
			}
		}
		return $cust_fields;
	}
	/**
	 * Set new custom attributes dropdown in admin edit entity
	 * @since WPAS 4.9
	 *
	 * @param array $keys
	 * @param object $post
	 *
	 * @return array $keys
	 */
	public function cust_keys($keys, $post) {
		global $post_type, $wpdb;
		if ($post_type == $this->post_type) {
			$sql = "SELECT DISTINCT meta_key
                FROM $wpdb->postmeta a
                WHERE a.post_id IN (SELECT id FROM $wpdb->posts b WHERE b.post_type='" . $this->post_type . "')";
			$keys = $wpdb->get_col($sql);
		}
		return $keys;
	}
	/**
	 * Hide all emd attributes
	 * @since WPAS 4.9
	 *
	 * @param bool $protected
	 * @param string $meta_key
	 *
	 * @return bool $protected
	 */
	public function hide_attrs($protected, $meta_key) {
		if (preg_match('/^(emd_|wpas_)/', $meta_key)) return true;
		if (!empty($this->boxes)) {
			foreach ($this->boxes as $mybox) {
				if (!empty($mybox['fields'])) {
					foreach ($mybox['fields'] as $fkey => $mybox_field) {
						if ($meta_key == $fkey) return true;
					}
				}
			}
		}
		return $protected;
	}
	/**
	 * Get column header list in admin list pages
	 * @since WPAS 4.0
	 *
	 * @param array $columns
	 *
	 * @return array $columns
	 */
	public function column_headers($columns) {
		$ent_list = get_option(str_replace("-", "_", $this->textdomain) . '_ent_list');
		if (!empty($ent_list[$this->post_type]['featured_img'])) {
			$columns['featured_img'] = __('Featured Image', $this->textdomain);
		}
		foreach ($this->boxes as $mybox) {
			foreach ($mybox['fields'] as $fkey => $mybox_field) {
				if (!in_array($fkey, Array(
					'wpas_form_name',
					'wpas_form_submitted_by',
					'wpas_form_submitted_ip'
				)) && !in_array($mybox_field['type'], Array(
					'textarea',
					'wysiwyg'
				)) && $mybox_field['list_visible'] == 1) {
					$columns[$fkey] = $mybox_field['name'];
				}
			}
		}
		$taxonomies = get_object_taxonomies($this->post_type, 'objects');
		if (!empty($taxonomies)) {
			$tax_list = get_option(str_replace("-", "_", $this->textdomain) . '_tax_list');
			foreach ($taxonomies as $taxonomy) {
				if (!empty($tax_list[$this->post_type][$taxonomy->name]) && $tax_list[$this->post_type][$taxonomy->name]['list_visible'] == 1) {
					$columns[$taxonomy->name] = $taxonomy->label;
				}
			}
		}
		$rel_list = get_option(str_replace("-", "_", $this->textdomain) . '_rel_list');
		if (!empty($rel_list)) {
			foreach ($rel_list as $krel => $rel) {
				if ($rel['from'] == $this->post_type && in_array($rel['show'], Array(
					'any',
					'from'
				))) {
					$columns[$krel] = $rel['from_title'];
				} elseif ($rel['to'] == $this->post_type && in_array($rel['show'], Array(
					'any',
					'to'
				))) {
					$columns[$krel] = $rel['to_title'];
				}
			}
		}
		return $columns;
	}
	/**
	 * Get custom column values in admin list pages
	 * @since WPAS 4.0
	 *
	 * @param int $column_id
	 * @param int $post_id
	 *
	 * @return string $value
	 */
	public function custom_columns($column_id, $post_id) {
		if (taxonomy_exists($column_id) == true) {
			$terms = get_the_terms($post_id, $column_id);
			$ret = array();
			if (!empty($terms)) {
				foreach ($terms as $term) {
					$url = add_query_arg(array(
						'post_type' => $this->post_type,
						'term' => $term->slug,
						'taxonomy' => $column_id
					) , admin_url('edit.php'));
					$a_class = preg_replace('/^emd_/', '', $this->post_type);
					$ret[] = sprintf('<a href="%s"  class="' . $a_class . '-tax ' . $term->slug . '">%s</a>', $url, $term->name);
				}
			}
			echo implode(', ', $ret);
			return;
		}
		$rel_list = get_option(str_replace("-", "_", $this->textdomain) . '_rel_list');
		if (!empty($rel_list) && !empty($rel_list[$column_id])) {
			$rel_arr = $rel_list[$column_id];
			if ($rel_arr['from'] == $this->post_type) {
				$other_ptype = $rel_arr['to'];
			} elseif ($rel_arr['to'] == $this->post_type) {
				$other_ptype = $rel_arr['from'];
			}
			$column_id = str_replace('rel_', '', $column_id);
			if (function_exists('p2p_type') && p2p_type($column_id)) {
				$rel_args = apply_filters('emd_ext_p2p_add_query_vars', array(
					'posts_per_page' => - 1
				) , Array(
					$other_ptype
				));
				$connected = p2p_type($column_id)->get_connected($post_id, $rel_args);
				$ptype_obj = get_post_type_object($this->post_type);
				$edit_cap = $ptype_obj->cap->edit_posts;
				$ret = array();
				if (empty($connected->posts)) return '&ndash;';
				foreach ($connected->posts as $myrelpost) {
					$rel_title = get_the_title($myrelpost->ID);
					$rel_title = apply_filters('emd_ext_p2p_connect_title', $rel_title, $myrelpost, '');
					$url = get_permalink($myrelpost->ID);
					$url = apply_filters('emd_ext_connected_ptype_url', $url, $myrelpost, $edit_cap);
					$ret[] = sprintf('<a href="%s" title="%s" target="_blank">%s</a>', $url, $rel_title, $rel_title);
				}
				echo implode(', ', $ret);
				return;
			}
		}
		$value = get_post_meta($post_id, $column_id, true);
		$type = "";
		foreach ($this->boxes as $mybox) {
			foreach ($mybox['fields'] as $fkey => $mybox_field) {
				if ($fkey == $column_id) {
					$type = $mybox_field['type'];
					break;
				}
			}
		}
		if ($column_id == 'featured_img') {
			$type = 'featured_img';
		}
		switch ($type) {
			case 'featured_img':
				$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($post_id) , 'thumbnail');
				if (!empty($thumb_url)) {
					$value = "<img style='max-width:100%;height:auto;' src='" . $thumb_url[0] . "' >";
				}
			break;
			case 'plupload_image':
			case 'image':
			case 'thickbox_image':
				$image_list = emd_mb_meta($column_id, 'type=image');
				$value = "";
				if (!empty($image_list)) {
					$myimage = current($image_list);
					$value = "<img style='max-width:100%;height:auto;' src='" . $myimage['url'] . "' >";
				}
			break;
			case 'user':
			case 'user-adv':
				$user_id = emd_mb_meta($column_id);
				if (!empty($user_id)) {
					$user_info = get_userdata($user_id);
					$value = $user_info->display_name;
				}
			break;
			case 'file':
				$file_list = emd_mb_meta($column_id, 'type=file');
				if (!empty($file_list)) {
					$value = "";
					foreach ($file_list as $myfile) {
						$fsrc = wp_mime_type_icon($myfile['ID']);
						$value.= "<a style='margin:5px;' href='" . $myfile['url'] . "' target='_blank'><img src='" . $fsrc . "' title='" . $myfile['name'] . "' width='20' /></a>";
					}
				}
			break;
			case 'radio':
			case 'checkbox_list':
			case 'select':
			case 'select_advanced':
				$value = emd_get_attr_val(str_replace("-", "_", $this->textdomain) , $post_id, $this->post_type, $column_id);
			break;
			case 'checkbox':
				if ($value == 1) {
					$value = '<span class="dashicons dashicons-yes"></span>';
				} elseif ($value == 0) {
					$value = '<span class="dashicons dashicons-no-alt"></span>';
				}
			break;
			case 'rating':
				$value = apply_filters('emd_get_rating_value', $value, Array(
					'meta' => $column_id
				) , $post_id);
			break;
		}
		if (is_array($value)) {
			$value = "<div class='clonelink'>" . implode("</div><div class='clonelink'>", $value) . "</div>";
		}
		echo $value;
	}
	/**
	 * Register post type and taxonomies and set initial values for taxs
	 *
	 * @since WPAS 4.0
	 *
	 */
	public static function register() {
		$labels = array(
			'name' => __('Contacts', 'wp-easy-contact') ,
			'singular_name' => __('Contact', 'wp-easy-contact') ,
			'add_new' => __('Add New', 'wp-easy-contact') ,
			'add_new_item' => __('Add New Contact', 'wp-easy-contact') ,
			'edit_item' => __('Edit Contact', 'wp-easy-contact') ,
			'new_item' => __('New Contact', 'wp-easy-contact') ,
			'all_items' => __('All Contacts', 'wp-easy-contact') ,
			'view_item' => __('View Contact', 'wp-easy-contact') ,
			'search_items' => __('Search Contacts', 'wp-easy-contact') ,
			'not_found' => __('No Contacts Found', 'wp-easy-contact') ,
			'not_found_in_trash' => __('No Contacts Found In Trash', 'wp-easy-contact') ,
			'menu_name' => __('Contacts', 'wp-easy-contact') ,
		);
		$ent_map_list = get_option('wp_easy_contact_ent_map_list', Array());
		$myrole = emd_get_curr_usr_role('wp_easy_contact');
		if (!empty($ent_map_list['emd_contact']['rewrite'])) {
			$rewrite = $ent_map_list['emd_contact']['rewrite'];
		} else {
			$rewrite = 'contacts';
		}
		$supports = Array();
		if (empty($ent_map_list['emd_contact']['attrs']['blt_title']) || $ent_map_list['emd_contact']['attrs']['blt_title'] != 'hide') {
			if (empty($ent_map_list['emd_contact']['edit_attrs'])) {
				$supports[] = 'title';
			} elseif ($myrole == 'administrator') {
				$supports[] = 'title';
			} elseif ($myrole != 'administrator' && !empty($ent_map_list['emd_contact']['edit_attrs'][$myrole]['blt_title']) && $ent_map_list['emd_contact']['edit_attrs'][$myrole]['blt_title'] == 'edit') {
				$supports[] = 'title';
			}
		}
		if (empty($ent_map_list['emd_contact']['attrs']['blt_content']) || $ent_map_list['emd_contact']['attrs']['blt_content'] != 'hide') {
			if (empty($ent_map_list['emd_contact']['edit_attrs'])) {
				$supports[] = 'editor';
			} elseif ($myrole == 'administrator') {
				$supports[] = 'editor';
			} elseif ($myrole != 'administrator' && !empty($ent_map_list['emd_contact']['edit_attrs'][$myrole]['blt_content']) && $ent_map_list['emd_contact']['edit_attrs'][$myrole]['blt_content'] == 'edit') {
				$supports[] = 'editor';
			}
		}
		register_post_type('emd_contact', array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'description' => __('', 'wp-easy-contact') ,
			'show_in_menu' => true,
			'menu_position' => 6,
			'has_archive' => true,
			'exclude_from_search' => false,
			'rewrite' => array(
				'slug' => $rewrite
			) ,
			'can_export' => true,
			'show_in_rest' => false,
			'hierarchical' => false,
			'menu_icon' => 'dashicons-groups',
			'map_meta_cap' => 'true',
			'taxonomies' => array() ,
			'capability_type' => 'emd_contact',
			'supports' => $supports,
		));
		$tax_settings = get_option('wp_easy_contact_tax_settings', Array());
		$myrole = emd_get_curr_usr_role('wp_easy_contact');
		$contact_tag_nohr_labels = array(
			'name' => __('Contact Tags', 'wp-easy-contact') ,
			'singular_name' => __('Contact Tag', 'wp-easy-contact') ,
			'search_items' => __('Search Contact Tags', 'wp-easy-contact') ,
			'popular_items' => __('Popular Contact Tags', 'wp-easy-contact') ,
			'all_items' => __('All', 'wp-easy-contact') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit Contact Tag', 'wp-easy-contact') ,
			'update_item' => __('Update Contact Tag', 'wp-easy-contact') ,
			'add_new_item' => __('Add New Contact Tag', 'wp-easy-contact') ,
			'new_item_name' => __('Add New Contact Tag Name', 'wp-easy-contact') ,
			'separate_items_with_commas' => __('Seperate Contact Tags with commas', 'wp-easy-contact') ,
			'add_or_remove_items' => __('Add or Remove Contact Tags', 'wp-easy-contact') ,
			'choose_from_most_used' => __('Choose from the most used Contact Tags', 'wp-easy-contact') ,
			'menu_name' => __('Contact Tags', 'wp-easy-contact') ,
		);
		if (empty($tax_settings['contact_tag']['hide']) || (!empty($tax_settings['contact_tag']['hide']) && $tax_settings['contact_tag']['hide'] != 'hide')) {
			if (!empty($tax_settings['contact_tag']['rewrite'])) {
				$rewrite = $tax_settings['contact_tag']['rewrite'];
			} else {
				$rewrite = 'contact_tag';
			}
			$targs = array(
				'hierarchical' => false,
				'labels' => $contact_tag_nohr_labels,
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_tagcloud' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array(
					'slug' => $rewrite,
				) ,
				'show_in_rest' => false,
				'capabilities' => array(
					'manage_terms' => 'manage_contact_tag',
					'edit_terms' => 'edit_contact_tag',
					'delete_terms' => 'delete_contact_tag',
					'assign_terms' => 'assign_contact_tag'
				) ,
			);
			if ($myrole != 'administrator' && !empty($tax_settings['contact_tag']['edit'][$myrole]) && $tax_settings['contact_tag']['edit'][$myrole] != 'edit') {
				$targs['meta_box_cb'] = false;
			}
			register_taxonomy('contact_tag', array(
				'emd_contact'
			) , $targs);
		}
		$contact_topic_nohr_labels = array(
			'name' => __('Topics', 'wp-easy-contact') ,
			'singular_name' => __('Topic', 'wp-easy-contact') ,
			'search_items' => __('Search Topics', 'wp-easy-contact') ,
			'popular_items' => __('Popular Topics', 'wp-easy-contact') ,
			'all_items' => __('All', 'wp-easy-contact') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit Topic', 'wp-easy-contact') ,
			'update_item' => __('Update Topic', 'wp-easy-contact') ,
			'add_new_item' => __('Add New Topic', 'wp-easy-contact') ,
			'new_item_name' => __('Add New Topic Name', 'wp-easy-contact') ,
			'separate_items_with_commas' => __('Seperate Topics with commas', 'wp-easy-contact') ,
			'add_or_remove_items' => __('Add or Remove Topics', 'wp-easy-contact') ,
			'choose_from_most_used' => __('Choose from the most used Topics', 'wp-easy-contact') ,
			'menu_name' => __('Topics', 'wp-easy-contact') ,
		);
		if (empty($tax_settings['contact_topic']['hide']) || (!empty($tax_settings['contact_topic']['hide']) && $tax_settings['contact_topic']['hide'] != 'hide')) {
			if (!empty($tax_settings['contact_topic']['rewrite'])) {
				$rewrite = $tax_settings['contact_topic']['rewrite'];
			} else {
				$rewrite = 'contact_topic';
			}
			$targs = array(
				'hierarchical' => false,
				'labels' => $contact_topic_nohr_labels,
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_tagcloud' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array(
					'slug' => $rewrite,
				) ,
				'show_in_rest' => false,
				'capabilities' => array(
					'manage_terms' => 'manage_contact_topic',
					'edit_terms' => 'edit_contact_topic',
					'delete_terms' => 'delete_contact_topic',
					'assign_terms' => 'assign_contact_topic'
				) ,
			);
			if ($myrole != 'administrator' && !empty($tax_settings['contact_topic']['edit'][$myrole]) && $tax_settings['contact_topic']['edit'][$myrole] != 'edit') {
				$targs['meta_box_cb'] = false;
			}
			register_taxonomy('contact_topic', array(
				'emd_contact'
			) , $targs);
		}
		$contact_state_nohr_labels = array(
			'name' => __('States', 'wp-easy-contact') ,
			'singular_name' => __('State', 'wp-easy-contact') ,
			'search_items' => __('Search States', 'wp-easy-contact') ,
			'popular_items' => __('Popular States', 'wp-easy-contact') ,
			'all_items' => __('All', 'wp-easy-contact') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit State', 'wp-easy-contact') ,
			'update_item' => __('Update State', 'wp-easy-contact') ,
			'add_new_item' => __('Add New State', 'wp-easy-contact') ,
			'new_item_name' => __('Add New State Name', 'wp-easy-contact') ,
			'separate_items_with_commas' => __('Seperate States with commas', 'wp-easy-contact') ,
			'add_or_remove_items' => __('Add or Remove States', 'wp-easy-contact') ,
			'choose_from_most_used' => __('Choose from the most used States', 'wp-easy-contact') ,
			'menu_name' => __('States', 'wp-easy-contact') ,
		);
		if (empty($tax_settings['contact_state']['hide']) || (!empty($tax_settings['contact_state']['hide']) && $tax_settings['contact_state']['hide'] != 'hide')) {
			if (!empty($tax_settings['contact_state']['rewrite'])) {
				$rewrite = $tax_settings['contact_state']['rewrite'];
			} else {
				$rewrite = 'contact_state';
			}
			$targs = array(
				'hierarchical' => false,
				'labels' => $contact_state_nohr_labels,
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_tagcloud' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array(
					'slug' => $rewrite,
				) ,
				'show_in_rest' => false,
				'capabilities' => array(
					'manage_terms' => 'manage_contact_state',
					'edit_terms' => 'edit_contact_state',
					'delete_terms' => 'delete_contact_state',
					'assign_terms' => 'assign_contact_state'
				) ,
			);
			if ($myrole != 'administrator' && !empty($tax_settings['contact_state']['edit'][$myrole]) && $tax_settings['contact_state']['edit'][$myrole] != 'edit') {
				$targs['meta_box_cb'] = false;
			}
			register_taxonomy('contact_state', array(
				'emd_contact'
			) , $targs);
		}
		$contact_country_nohr_labels = array(
			'name' => __('Countries', 'wp-easy-contact') ,
			'singular_name' => __('Country', 'wp-easy-contact') ,
			'search_items' => __('Search Countries', 'wp-easy-contact') ,
			'popular_items' => __('Popular Countries', 'wp-easy-contact') ,
			'all_items' => __('All', 'wp-easy-contact') ,
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __('Edit Country', 'wp-easy-contact') ,
			'update_item' => __('Update Country', 'wp-easy-contact') ,
			'add_new_item' => __('Add New Country', 'wp-easy-contact') ,
			'new_item_name' => __('Add New Country Name', 'wp-easy-contact') ,
			'separate_items_with_commas' => __('Seperate Countries with commas', 'wp-easy-contact') ,
			'add_or_remove_items' => __('Add or Remove Countries', 'wp-easy-contact') ,
			'choose_from_most_used' => __('Choose from the most used Countries', 'wp-easy-contact') ,
			'menu_name' => __('Countries', 'wp-easy-contact') ,
		);
		if (empty($tax_settings['contact_country']['hide']) || (!empty($tax_settings['contact_country']['hide']) && $tax_settings['contact_country']['hide'] != 'hide')) {
			if (!empty($tax_settings['contact_country']['rewrite'])) {
				$rewrite = $tax_settings['contact_country']['rewrite'];
			} else {
				$rewrite = 'contact_country';
			}
			$targs = array(
				'hierarchical' => false,
				'labels' => $contact_country_nohr_labels,
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus' => true,
				'show_in_menu' => true,
				'show_tagcloud' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'rewrite' => array(
					'slug' => $rewrite,
				) ,
				'show_in_rest' => false,
				'capabilities' => array(
					'manage_terms' => 'manage_contact_country',
					'edit_terms' => 'edit_contact_country',
					'delete_terms' => 'delete_contact_country',
					'assign_terms' => 'assign_contact_country'
				) ,
			);
			if ($myrole != 'administrator' && !empty($tax_settings['contact_country']['edit'][$myrole]) && $tax_settings['contact_country']['edit'][$myrole] != 'edit') {
				$targs['meta_box_cb'] = false;
			}
			register_taxonomy('contact_country', array(
				'emd_contact'
			) , $targs);
		}
		$tax_list = get_option('wp_easy_contact_tax_list');
		$init_tax = get_option('wp_easy_contact_init_tax', Array());
		if (!empty($tax_list['emd_contact'])) {
			foreach ($tax_list['emd_contact'] as $keytax => $mytax) {
				if (!empty($mytax['init_values']) && (empty($init_tax['emd_contact']) || (!empty($init_tax['emd_contact']) && !in_array($keytax, $init_tax['emd_contact'])))) {
					$set_tax_terms = Array();
					foreach ($mytax['init_values'] as $myinit) {
						$set_tax_terms[] = $myinit;
					}
					self::set_taxonomy_init($set_tax_terms, $keytax);
					$init_tax['emd_contact'][] = $keytax;
				}
			}
			update_option('wp_easy_contact_init_tax', $init_tax);
		}
	}
	/**
	 * Set metabox fields,labels,filters, comments, relationships if exists
	 *
	 * @since WPAS 4.0
	 *
	 */
	public function set_filters() {
		do_action('emd_ext_class_init', $this);
		$search_args = Array();
		$filter_args = Array();
		$this->sing_label = __('Contact', 'wp-easy-contact');
		$this->plural_label = __('Contacts', 'wp-easy-contact');
		$this->menu_entity = 'emd_contact';
		$this->boxes['emd_contact_info_emd_contact_0'] = array(
			'id' => 'emd_contact_info_emd_contact_0',
			'title' => __('Contact Info', 'wp-easy-contact') ,
			'app_name' => 'wp_easy_contact',
			'pages' => array(
				'emd_contact'
			) ,
			'context' => 'normal',
		);
		$this->boxes['emd_cust_field_meta_box'] = array(
			'id' => 'emd_cust_field_meta_box',
			'title' => __('Custom Fields', 'wp-easy-contact') ,
			'app_name' => 'wp_easy_contact',
			'pages' => array(
				'emd_contact'
			) ,
			'context' => 'normal',
			'priority' => 'low'
		);
		list($search_args, $filter_args) = $this->set_args_boxes();
		if (empty($this->boxes['emd_cust_field_meta_box']['fields'])) {
			unset($this->boxes['emd_cust_field_meta_box']);
		}
		if (!post_type_exists($this->post_type) || in_array($this->post_type, Array(
			'post',
			'page'
		))) {
			self::register();
		}
		do_action('emd_set_adv_filtering', $this->post_type, $search_args, $this->boxes, $filter_args, $this->textdomain, $this->plural_label);
		add_action('admin_notices', array(
			$this,
			'show_lite_filters'
		));
		$ent_map_list = get_option(str_replace('-', '_', $this->textdomain) . '_ent_map_list');
	}
	/**
	 * Initialize metaboxes
	 * @since WPAS 4.5
	 *
	 */
	public function set_metabox() {
		if (class_exists('EMD_Meta_Box') && is_array($this->boxes)) {
			foreach ($this->boxes as $meta_box) {
				new EMD_Meta_Box($meta_box);
			}
		}
	}
	/**
	 * Change content for created frontend views
	 * @since WPAS 4.0
	 * @param string $content
	 *
	 * @return string $content
	 */
	public function change_content($content) {
		global $post;
		$layout = "";
		$this->id = $post->ID;
		$tools = get_option('wp_easy_contact_tools');
		if (!empty($tools['disable_emd_templates'])) {
			add_filter('the_title', array(
				$this,
				'change_title_disable_emd_temp'
			) , 10, 2);
		}
		if (get_post_type() == $this->post_type && is_single()) {
			ob_start();
			do_action('emd_single_before_content', $this->textdomain, $this->post_type);
			emd_get_template_part($this->textdomain, 'single', 'emd-contact');
			do_action('emd_single_after_content', $this->textdomain, $this->post_type);
			$layout = ob_get_clean();
		}
		if ($layout != "") {
			$content = $layout;
		}
		if (!empty($tools['disable_emd_templates'])) {
			remove_filter('the_title', array(
				$this,
				'change_title_disable_emd_temp'
			) , 10, 2);
		}
		return $content;
	}
	/**
	 * Add operations and add new submenu hook
	 * @since WPAS 4.4
	 */
	public function add_menu_link() {
		add_submenu_page(null, __('CSV Import/Export', 'wp-easy-contact') , __('CSV Import/Export', 'wp-easy-contact') , 'manage_operations_emd_contacts', 'operations_emd_contact', array(
			$this,
			'get_operations'
		));
	}
	/**
	 * Display operations page
	 * @since WPAS 4.0
	 */
	public function get_operations() {
		if (current_user_can('manage_operations_emd_contacts')) {
			$myapp = str_replace("-", "_", $this->textdomain);
			if (!function_exists('emd_operations_entity')) {
				emd_lite_get_operations('opr', $this->plural_label, $this->textdomain);
			} else {
				do_action('emd_operations_entity', $this->post_type, $this->plural_label, $this->sing_label, $myapp, $this->menu_entity);
			}
		}
	}
	public function change_title_text($title) {
		$screen = get_current_screen();
		if ($this->post_type == $screen->post_type) {
			$title = __('Enter Subject here', 'wp-easy-contact');
		}
		return $title;
	}
	public function show_lite_filters() {
		if (class_exists('EMD_AFC')) {
			return;
		}
		global $pagenow;
		if (get_post_type() == $this->post_type && $pagenow == 'edit.php') {
			emd_lite_get_filters($this->textdomain);
		}
	}
}
new Emd_Contact;
<?php $real_post = $post;
$ent_attrs = get_option('wp_easy_contact_attr_list');
?>
<div id="single-emd-contact-<?php echo get_the_ID(); ?>" class="emd-container emd-contact-wrap single-wrap">
<?php $is_editable = 0; ?>
<?php
if (emd_is_item_visible('emd_contact_first_name', 'wp_easy_contact', 'attribute')) {
	$emd_contact_first_name = emd_mb_meta('emd_contact_first_name');
	if (!empty($emd_contact_first_name)) { ?>
   <div id="emd-contact-emd-contact-first-name-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-first-name-key" class="emd-single-title">
<?php _e('First Name', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-emd-contact-first-name-val" class="emd-single-val">
<?php echo $emd_contact_first_name; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_last_name', 'wp_easy_contact', 'attribute')) {
	$emd_contact_last_name = emd_mb_meta('emd_contact_last_name');
	if (!empty($emd_contact_last_name)) { ?>
   <div id="emd-contact-emd-contact-last-name-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-last-name-key" class="emd-single-title">
<?php _e('Last Name', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-emd-contact-last-name-val" class="emd-single-val">
<?php echo $emd_contact_last_name; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_email', 'wp_easy_contact', 'attribute')) {
	$emd_contact_email = emd_mb_meta('emd_contact_email');
	if (!empty($emd_contact_email)) { ?>
   <div id="emd-contact-emd-contact-email-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-email-key" class="emd-single-title">
<?php _e('Email', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-emd-contact-email-val" class="emd-single-val">
<?php echo $emd_contact_email; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_phone', 'wp_easy_contact', 'attribute')) {
	$emd_contact_phone = emd_mb_meta('emd_contact_phone');
	if (!empty($emd_contact_phone)) { ?>
   <div id="emd-contact-emd-contact-phone-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-phone-key" class="emd-single-title">
<?php _e('Phone', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-emd-contact-phone-val" class="emd-single-val">
<?php echo $emd_contact_phone; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_address', 'wp_easy_contact', 'attribute')) {
	$emd_contact_address = emd_mb_meta('emd_contact_address');
	if (!empty($emd_contact_address)) { ?>
   <div id="emd-contact-emd-contact-address-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-address-key" class="emd-single-title">
<?php _e('Address', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-emd-contact-address-val" class="emd-single-val">
<?php echo $emd_contact_address; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_city', 'wp_easy_contact', 'attribute')) {
	$emd_contact_city = emd_mb_meta('emd_contact_city');
	if (!empty($emd_contact_city)) { ?>
   <div id="emd-contact-emd-contact-city-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-city-key" class="emd-single-title">
<?php _e('City', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-emd-contact-city-val" class="emd-single-val">
<?php echo $emd_contact_city; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_zipcode', 'wp_easy_contact', 'attribute')) {
	$emd_contact_zipcode = emd_mb_meta('emd_contact_zipcode');
	if (!empty($emd_contact_zipcode)) { ?>
   <div id="emd-contact-emd-contact-zipcode-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-zipcode-key" class="emd-single-title">
<?php _e('Zip Code', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-emd-contact-zipcode-val" class="emd-single-val">
<?php echo $emd_contact_zipcode; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php
if (emd_is_item_visible('emd_contact_id', 'wp_easy_contact', 'attribute')) {
	$emd_contact_id = emd_mb_meta('emd_contact_id');
	if (!empty($emd_contact_id)) { ?>
   <div id="emd-contact-emd-contact-id-div" class="emd-single-div">
   <div id="emd-contact-emd-contact-id-key" class="emd-single-title">
<?php _e('ID', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-emd-contact-id-val" class="emd-single-val">
<?php echo $emd_contact_id; ?>
   </div>
   </div>
<?php
	}
}
?>
<?php $blt_title = $post->post_title;
if (!empty($blt_title)) { ?>
   <div id="emd-contact-blt-title-div" class="emd-single-div">
   <div id="emd-contact-blt-title-key" class="emd-single-title">
   <?php _e('Subject', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-blt-title-val" class="emd-single-val">
   <?php echo $blt_title; ?>
   </div>
   </div>
<?php
} ?>
<?php $blt_content = $post->post_content;
if (!empty($blt_content)) { ?>
   <div id="emd-contact-blt-content-div" class="emd-single-div">
   <div id="emd-contact-blt-content-key" class="emd-single-title">
   <?php _e('Message', 'wp-easy-contact'); ?>
   </div>
   <div id="emd-contact-blt-content-val" class="emd-single-val">
   <?php echo $blt_content; ?>
   </div>
   </div>
<?php
} ?>
<?php
$cust_fields = get_metadata('post', get_the_ID());
$real_cust_fields = Array();
$ent_map_list = get_option('wp_easy_contact_ent_map_list', Array());
foreach ($cust_fields as $ckey => $cval) {
	if (empty($ent_attrs['emd_contact'][$ckey]) && !preg_match('/^(_|wpas_|emd_)/', $ckey)) {
		$cust_key = str_replace('-', '_', sanitize_title($ckey));
		if (!empty($ent_map_list) && empty($ent_map_list['emd_contact']['cust_fields'][$cust_key])) {
			$real_cust_fields[$ckey] = $cval;
		}
	}
}
if (!empty($real_cust_fields)) {
	$fcount = 0;
	foreach ($real_cust_fields as $rkey => $rval) {
		$val = implode($rval, " ");
		$fcount++;
?>
<div id="cust-field-<?php echo $fcount; ?>-div" class="emd-single-div">
<div id="cust-field-<?php echo $fcount; ?>-key" class="emd-single-title">
<?php echo $rkey; ?>
</div>
   <div id="cust-field-<?php echo $fcount; ?>-val" class="emd-single-val">
<?php echo $val; ?>
</div>
</div>
<?php
	}
}
?>
<?php
$taxlist = get_object_taxonomies(get_post_type() , 'objects');
foreach ($taxlist as $taxkey => $mytax) {
	$termlist = get_the_term_list(get_the_ID() , $taxkey, '', ' , ', '');
	if (!empty($termlist)) {
		if (emd_is_item_visible('tax_' . $taxkey, 'wp_easy_contact', 'taxonomy')) { ?>
      <div id="emd-contact-<?php echo esc_attr($taxkey); ?>-div" class="emd-single-div">
      <div id="emd-contact-<?php echo esc_attr($taxkey); ?>-key" class="emd-single-title">
      <?php echo esc_html($mytax->labels->singular_name); ?>
      </div>
      <div id="emd-contact-<?php echo esc_attr($taxkey); ?>-val" class="emd-single-val">
      <?php echo $termlist; ?>
      </div>
      </div>
   <?php
		}
	}
} ?>
</div><!--container-end-->
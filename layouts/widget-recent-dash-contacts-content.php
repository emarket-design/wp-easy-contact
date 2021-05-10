<?php $real_post = $post;
$ent_attrs = get_option('wp_easy_contact_attr_list');
?>
* <a href="<?php echo get_permalink(); ?>" title="<?php echo esc_html(emd_mb_meta('emd_contact_email')); ?>
"><?php echo esc_html(emd_mb_meta('emd_contact_first_name')); ?>
 <?php echo esc_html(emd_mb_meta('emd_contact_last_name')); ?>
</a> <br>
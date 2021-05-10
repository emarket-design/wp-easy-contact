<?php
/**
 * Settings Glossary Functions
 *
 * @package WP_EASY_CONTACT
 * @since WPAS 4.0
 */
if (!defined('ABSPATH')) exit;
add_action('wp_easy_contact_settings_glossary', 'wp_easy_contact_settings_glossary');
/**
 * Display glossary information
 * @since WPAS 4.0
 *
 * @return html
 */
function wp_easy_contact_settings_glossary() {
	global $title;
?>
<div class="wrap">
<h2><?php echo $title; ?></h2>
<p><?php _e('WP Easy Contact provides a contact form and stores the collected information in WordPress.', 'wp-easy-contact'); ?></p>
<p><?php _e('The below are the definitions of entities, attributes, and terms included in WP Easy Contact.', 'wp-easy-contact'); ?></p>
<div id="glossary" class="accordion-container">
<ul class="outer-border">
<li id="emd_contact" class="control-section accordion-section open">
<h3 class="accordion-section-title hndle" tabindex="1"><?php _e('Contacts', 'wp-easy-contact'); ?></h3>
<div class="accordion-section-content">
<div class="inside">
<table class="form-table"><p class"lead"><?php _e('', 'wp-easy-contact'); ?></p><tr><th style='font-size: 1.1em;color:cadetblue;border-bottom: 1px dashed;padding-bottom: 10px;' colspan=2><div><?php _e('Attributes', 'wp-easy-contact'); ?></div></th></tr>
<tr>
<th><?php _e('Subject', 'wp-easy-contact'); ?></th>
<td><?php _e(' Subject is a required field. Subject does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Message', 'wp-easy-contact'); ?></th>
<td><?php _e(' Message is a required field. Message does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('First Name', 'wp-easy-contact'); ?></th>
<td><?php _e('Please enter your first name. First Name is a required field. First Name does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Last Name', 'wp-easy-contact'); ?></th>
<td><?php _e('Please enter your last name. Last Name does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Email', 'wp-easy-contact'); ?></th>
<td><?php _e('Please enter your email address. Email is a required field. Email does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Phone', 'wp-easy-contact'); ?></th>
<td><?php _e('Please enter your phone or mobile. Phone does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Address', 'wp-easy-contact'); ?></th>
<td><?php _e('Please enter your mailing address. Address does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('City', 'wp-easy-contact'); ?></th>
<td><?php _e('Please enter your city. City does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Zip Code', 'wp-easy-contact'); ?></th>
<td><?php _e('Please enter your zip code. Zip Code does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('ID', 'wp-easy-contact'); ?></th>
<td><?php _e('Unique contact id incremented by one to keep tract of communications Being a unique identifier, it uniquely distinguishes each instance of Contact entity. ID does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Form Name', 'wp-easy-contact'); ?></th>
<td><?php _e(' Form Name is filterable in the admin area. Form Name has a default value of <b>admin</b>.', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Form Submitted By', 'wp-easy-contact'); ?></th>
<td><?php _e(' Form Submitted By is filterable in the admin area. Form Submitted By does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<th><?php _e('Form Submitted IP', 'wp-easy-contact'); ?></th>
<td><?php _e(' Form Submitted IP is filterable in the admin area. Form Submitted IP does not have a default value. ', 'wp-easy-contact'); ?></td>
</tr><tr><th style='font-size:1.1em;color:cadetblue;border-bottom: 1px dashed;padding-bottom: 10px;' colspan=2><div><?php _e('Taxonomies', 'wp-easy-contact'); ?></div></th></tr>
<tr>
<th><?php _e('State', 'wp-easy-contact'); ?></th>

<td><?php _e('Please enter your state you reside in. State accepts multiple values like tags', 'wp-easy-contact'); ?>. <?php _e('State does not have a default value', 'wp-easy-contact'); ?>.<div class="taxdef-block"><p><?php _e('The following are the preset values and value descriptions for <b>State:</b>', 'wp-easy-contact'); ?></p>
<table class="table tax-table form-table"><tr><td><?php _e('AL', 'wp-easy-contact'); ?></td>
<td><?php _e('Alabama', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('AK', 'wp-easy-contact'); ?></td>
<td><?php _e('Alaska', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('AZ', 'wp-easy-contact'); ?></td>
<td><?php _e('Arizona', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('AR', 'wp-easy-contact'); ?></td>
<td><?php _e('Arkansas', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('CA', 'wp-easy-contact'); ?></td>
<td><?php _e('California', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('CO', 'wp-easy-contact'); ?></td>
<td><?php _e('Colorado', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('CT', 'wp-easy-contact'); ?></td>
<td><?php _e('Connecticut', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('DE', 'wp-easy-contact'); ?></td>
<td><?php _e('Delaware', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('DC', 'wp-easy-contact'); ?></td>
<td><?php _e('District of Columbia', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('FL', 'wp-easy-contact'); ?></td>
<td><?php _e('Florida', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('GA', 'wp-easy-contact'); ?></td>
<td><?php _e('Georgia', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('HI', 'wp-easy-contact'); ?></td>
<td><?php _e('Hawaii', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('ID', 'wp-easy-contact'); ?></td>
<td><?php _e('Idaho', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('IL', 'wp-easy-contact'); ?></td>
<td><?php _e('Illinois', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('IN', 'wp-easy-contact'); ?></td>
<td><?php _e('Indiana', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('IA', 'wp-easy-contact'); ?></td>
<td><?php _e('Iowa', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('KS', 'wp-easy-contact'); ?></td>
<td><?php _e('Kansas', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('KY', 'wp-easy-contact'); ?></td>
<td><?php _e('Kentucky', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('LA', 'wp-easy-contact'); ?></td>
<td><?php _e('Louisiana', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('ME', 'wp-easy-contact'); ?></td>
<td><?php _e('Maine', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('MD', 'wp-easy-contact'); ?></td>
<td><?php _e('Maryland', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('MA', 'wp-easy-contact'); ?></td>
<td><?php _e('Massachusetts', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('MI', 'wp-easy-contact'); ?></td>
<td><?php _e('Michigan', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('MN', 'wp-easy-contact'); ?></td>
<td><?php _e('Minnesota', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('MS', 'wp-easy-contact'); ?></td>
<td><?php _e('Mississippi', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('MO', 'wp-easy-contact'); ?></td>
<td><?php _e('Missouri', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('MT', 'wp-easy-contact'); ?></td>
<td><?php _e('Montana', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('NE', 'wp-easy-contact'); ?></td>
<td><?php _e('Nebraska', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('NV', 'wp-easy-contact'); ?></td>
<td><?php _e('Nevada', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('NH', 'wp-easy-contact'); ?></td>
<td><?php _e('New Hampshire', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('NJ', 'wp-easy-contact'); ?></td>
<td><?php _e('New Jersey', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('NM', 'wp-easy-contact'); ?></td>
<td><?php _e('New Mexico', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('NY', 'wp-easy-contact'); ?></td>
<td><?php _e('New York', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('NC', 'wp-easy-contact'); ?></td>
<td><?php _e('North Carolina', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('ND', 'wp-easy-contact'); ?></td>
<td><?php _e('North Dakota', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('OH', 'wp-easy-contact'); ?></td>
<td><?php _e('Ohio', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('OK', 'wp-easy-contact'); ?></td>
<td><?php _e('Oklahoma', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('OR', 'wp-easy-contact'); ?></td>
<td><?php _e('Oregon', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('PA', 'wp-easy-contact'); ?></td>
<td><?php _e('Pennsylvania', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('RI', 'wp-easy-contact'); ?></td>
<td><?php _e('Rhode Island', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('SC', 'wp-easy-contact'); ?></td>
<td><?php _e('South Carolina', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('SD', 'wp-easy-contact'); ?></td>
<td><?php _e('South Dakota', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('TN', 'wp-easy-contact'); ?></td>
<td><?php _e('Tennessee', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('TX', 'wp-easy-contact'); ?></td>
<td><?php _e('Texas', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('UT', 'wp-easy-contact'); ?></td>
<td><?php _e('Utah', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('VT', 'wp-easy-contact'); ?></td>
<td><?php _e('Vermont', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('VA', 'wp-easy-contact'); ?></td>
<td><?php _e('Virginia', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('WA', 'wp-easy-contact'); ?></td>
<td><?php _e('Washington', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('WV', 'wp-easy-contact'); ?></td>
<td><?php _e('West Virginia', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('WI', 'wp-easy-contact'); ?></td>
<td><?php _e('Wisconsin', 'wp-easy-contact'); ?></td>
</tr>
<tr>
<td><?php _e('WY', 'wp-easy-contact'); ?></td>
<td><?php _e('Wyoming', 'wp-easy-contact'); ?></td>
</tr>
</table>
</div></td>
</tr>

<tr>
<th><?php _e('Country', 'wp-easy-contact'); ?></th>

<td><?php _e('Please enter your country you reside in. Country accepts multiple values like tags', 'wp-easy-contact'); ?>. <?php _e('Country does not have a default value', 'wp-easy-contact'); ?>.<div class="taxdef-block"><p><?php _e('The following are the preset values for <b>Country:</b>', 'wp-easy-contact'); ?></p><p class="taxdef-values"><?php _e('Afghanistan', 'wp-easy-contact'); ?>, <?php _e('Åland Islands', 'wp-easy-contact'); ?>, <?php _e('Albania', 'wp-easy-contact'); ?>, <?php _e('Algeria', 'wp-easy-contact'); ?>, <?php _e('American Samoa', 'wp-easy-contact'); ?>, <?php _e('Andorra', 'wp-easy-contact'); ?>, <?php _e('Angola', 'wp-easy-contact'); ?>, <?php _e('Anguilla', 'wp-easy-contact'); ?>, <?php _e('Antarctica', 'wp-easy-contact'); ?>, <?php _e('Antigua And Barbuda', 'wp-easy-contact'); ?>, <?php _e('Argentina', 'wp-easy-contact'); ?>, <?php _e('Armenia', 'wp-easy-contact'); ?>, <?php _e('Aruba', 'wp-easy-contact'); ?>, <?php _e('Australia', 'wp-easy-contact'); ?>, <?php _e('Austria', 'wp-easy-contact'); ?>, <?php _e('Azerbaijan', 'wp-easy-contact'); ?>, <?php _e('Bahamas', 'wp-easy-contact'); ?>, <?php _e('Bahrain', 'wp-easy-contact'); ?>, <?php _e('Bangladesh', 'wp-easy-contact'); ?>, <?php _e('Barbados', 'wp-easy-contact'); ?>, <?php _e('Belarus', 'wp-easy-contact'); ?>, <?php _e('Belgium', 'wp-easy-contact'); ?>, <?php _e('Belize', 'wp-easy-contact'); ?>, <?php _e('Benin', 'wp-easy-contact'); ?>, <?php _e('Bermuda', 'wp-easy-contact'); ?>, <?php _e('Bhutan', 'wp-easy-contact'); ?>, <?php _e('Bolivia', 'wp-easy-contact'); ?>, <?php _e('Bosnia And Herzegovina', 'wp-easy-contact'); ?>, <?php _e('Botswana', 'wp-easy-contact'); ?>, <?php _e('Bouvet Island', 'wp-easy-contact'); ?>, <?php _e('Brazil', 'wp-easy-contact'); ?>, <?php _e('British Indian Ocean Territory', 'wp-easy-contact'); ?>, <?php _e('Brunei Darussalam', 'wp-easy-contact'); ?>, <?php _e('Bulgaria', 'wp-easy-contact'); ?>, <?php _e('Burkina Faso', 'wp-easy-contact'); ?>, <?php _e('Burundi', 'wp-easy-contact'); ?>, <?php _e('Cambodia', 'wp-easy-contact'); ?>, <?php _e('Cameroon', 'wp-easy-contact'); ?>, <?php _e('Canada', 'wp-easy-contact'); ?>, <?php _e('Cape Verde', 'wp-easy-contact'); ?>, <?php _e('Cayman Islands', 'wp-easy-contact'); ?>, <?php _e('Central African Republic', 'wp-easy-contact'); ?>, <?php _e('Chad', 'wp-easy-contact'); ?>, <?php _e('Chile', 'wp-easy-contact'); ?>, <?php _e('China', 'wp-easy-contact'); ?>, <?php _e('Christmas Island', 'wp-easy-contact'); ?>, <?php _e('Cocos (Keeling) Islands', 'wp-easy-contact'); ?>, <?php _e('Colombia', 'wp-easy-contact'); ?>, <?php _e('Comoros', 'wp-easy-contact'); ?>, <?php _e('Congo', 'wp-easy-contact'); ?>, <?php _e('Congo, The Democratic Republic Of The', 'wp-easy-contact'); ?>, <?php _e('Cook Islands', 'wp-easy-contact'); ?>, <?php _e('Costa Rica', 'wp-easy-contact'); ?>, <?php _e('Cote D\'ivoire', 'wp-easy-contact'); ?>, <?php _e('Croatia', 'wp-easy-contact'); ?>, <?php _e('Cuba', 'wp-easy-contact'); ?>, <?php _e('Cyprus', 'wp-easy-contact'); ?>, <?php _e('Czech Republic', 'wp-easy-contact'); ?>, <?php _e('Denmark', 'wp-easy-contact'); ?>, <?php _e('Djibouti', 'wp-easy-contact'); ?>, <?php _e('Dominica', 'wp-easy-contact'); ?>, <?php _e('Dominican Republic', 'wp-easy-contact'); ?>, <?php _e('Ecuador', 'wp-easy-contact'); ?>, <?php _e('Egypt', 'wp-easy-contact'); ?>, <?php _e('El Salvador', 'wp-easy-contact'); ?>, <?php _e('Equatorial Guinea', 'wp-easy-contact'); ?>, <?php _e('Eritrea', 'wp-easy-contact'); ?>, <?php _e('Estonia', 'wp-easy-contact'); ?>, <?php _e('Ethiopia', 'wp-easy-contact'); ?>, <?php _e('Falkland Islands (Malvinas)', 'wp-easy-contact'); ?>, <?php _e('Faroe Islands', 'wp-easy-contact'); ?>, <?php _e('Fiji', 'wp-easy-contact'); ?>, <?php _e('Finland', 'wp-easy-contact'); ?>, <?php _e('France', 'wp-easy-contact'); ?>, <?php _e('French Guiana', 'wp-easy-contact'); ?>, <?php _e('French Polynesia', 'wp-easy-contact'); ?>, <?php _e('French Southern Territories', 'wp-easy-contact'); ?>, <?php _e('Gabon', 'wp-easy-contact'); ?>, <?php _e('Gambia', 'wp-easy-contact'); ?>, <?php _e('Georgia', 'wp-easy-contact'); ?>, <?php _e('Germany', 'wp-easy-contact'); ?>, <?php _e('Ghana', 'wp-easy-contact'); ?>, <?php _e('Gibraltar', 'wp-easy-contact'); ?>, <?php _e('Greece', 'wp-easy-contact'); ?>, <?php _e('Greenland', 'wp-easy-contact'); ?>, <?php _e('Grenada', 'wp-easy-contact'); ?>, <?php _e('Guadeloupe', 'wp-easy-contact'); ?>, <?php _e('Guam', 'wp-easy-contact'); ?>, <?php _e('Guatemala', 'wp-easy-contact'); ?>, <?php _e('Guernsey', 'wp-easy-contact'); ?>, <?php _e('Guinea', 'wp-easy-contact'); ?>, <?php _e('Guinea-bissau', 'wp-easy-contact'); ?>, <?php _e('Guyana', 'wp-easy-contact'); ?>, <?php _e('Haiti', 'wp-easy-contact'); ?>, <?php _e('Heard Island And Mcdonald Islands', 'wp-easy-contact'); ?>, <?php _e('Holy See (Vatican City State)', 'wp-easy-contact'); ?>, <?php _e('Honduras', 'wp-easy-contact'); ?>, <?php _e('Hong Kong', 'wp-easy-contact'); ?>, <?php _e('Hungary', 'wp-easy-contact'); ?>, <?php _e('Iceland', 'wp-easy-contact'); ?>, <?php _e('India', 'wp-easy-contact'); ?>, <?php _e('Indonesia', 'wp-easy-contact'); ?>, <?php _e('Iran, Islamic Republic Of', 'wp-easy-contact'); ?>, <?php _e('Iraq', 'wp-easy-contact'); ?>, <?php _e('Ireland', 'wp-easy-contact'); ?>, <?php _e('Isle Of Man', 'wp-easy-contact'); ?>, <?php _e('Israel', 'wp-easy-contact'); ?>, <?php _e('Italy', 'wp-easy-contact'); ?>, <?php _e('Jamaica', 'wp-easy-contact'); ?>, <?php _e('Japan', 'wp-easy-contact'); ?>, <?php _e('Jersey', 'wp-easy-contact'); ?>, <?php _e('Jordan', 'wp-easy-contact'); ?>, <?php _e('Kazakhstan', 'wp-easy-contact'); ?>, <?php _e('Kenya', 'wp-easy-contact'); ?>, <?php _e('Kiribati', 'wp-easy-contact'); ?>, <?php _e('Korea, Democratic People\'s Republic Of', 'wp-easy-contact'); ?>, <?php _e('Korea, Republic Of', 'wp-easy-contact'); ?>, <?php _e('Kuwait', 'wp-easy-contact'); ?>, <?php _e('Kyrgyzstan', 'wp-easy-contact'); ?>, <?php _e('Lao People\'s Democratic Republic', 'wp-easy-contact'); ?>, <?php _e('Latvia', 'wp-easy-contact'); ?>, <?php _e('Lebanon', 'wp-easy-contact'); ?>, <?php _e('Lesotho', 'wp-easy-contact'); ?>, <?php _e('Liberia', 'wp-easy-contact'); ?>, <?php _e('Libyan Arab Jamahiriya', 'wp-easy-contact'); ?>, <?php _e('Liechtenstein', 'wp-easy-contact'); ?>, <?php _e('Lithuania', 'wp-easy-contact'); ?>, <?php _e('Luxembourg', 'wp-easy-contact'); ?>, <?php _e('Macao', 'wp-easy-contact'); ?>, <?php _e('Macedonia, The Former Yugoslav Republic Of', 'wp-easy-contact'); ?>, <?php _e('Madagascar', 'wp-easy-contact'); ?>, <?php _e('Malawi', 'wp-easy-contact'); ?>, <?php _e('Malaysia', 'wp-easy-contact'); ?>, <?php _e('Maldives', 'wp-easy-contact'); ?>, <?php _e('Mali', 'wp-easy-contact'); ?>, <?php _e('Malta', 'wp-easy-contact'); ?>, <?php _e('Marshall Islands', 'wp-easy-contact'); ?>, <?php _e('Martinique', 'wp-easy-contact'); ?>, <?php _e('Mauritania', 'wp-easy-contact'); ?>, <?php _e('Mauritius', 'wp-easy-contact'); ?>, <?php _e('Mayotte', 'wp-easy-contact'); ?>, <?php _e('Mexico', 'wp-easy-contact'); ?>, <?php _e('Micronesia, Federated States Of', 'wp-easy-contact'); ?>, <?php _e('Moldova, Republic Of', 'wp-easy-contact'); ?>, <?php _e('Monaco', 'wp-easy-contact'); ?>, <?php _e('Mongolia', 'wp-easy-contact'); ?>, <?php _e('Montenegro', 'wp-easy-contact'); ?>, <?php _e('Montserrat', 'wp-easy-contact'); ?>, <?php _e('Morocco', 'wp-easy-contact'); ?>, <?php _e('Mozambique', 'wp-easy-contact'); ?>, <?php _e('Myanmar', 'wp-easy-contact'); ?>, <?php _e('Namibia', 'wp-easy-contact'); ?>, <?php _e('Nauru', 'wp-easy-contact'); ?>, <?php _e('Nepal', 'wp-easy-contact'); ?>, <?php _e('Netherlands', 'wp-easy-contact'); ?>, <?php _e('Netherlands Antilles', 'wp-easy-contact'); ?>, <?php _e('New Caledonia', 'wp-easy-contact'); ?>, <?php _e('New Zealand', 'wp-easy-contact'); ?>, <?php _e('Nicaragua', 'wp-easy-contact'); ?>, <?php _e('Niger', 'wp-easy-contact'); ?>, <?php _e('Nigeria', 'wp-easy-contact'); ?>, <?php _e('Niue', 'wp-easy-contact'); ?>, <?php _e('Norfolk Island', 'wp-easy-contact'); ?>, <?php _e('Northern Mariana Islands', 'wp-easy-contact'); ?>, <?php _e('Norway', 'wp-easy-contact'); ?>, <?php _e('Oman', 'wp-easy-contact'); ?>, <?php _e('Pakistan', 'wp-easy-contact'); ?>, <?php _e('Palau', 'wp-easy-contact'); ?>, <?php _e('Palestinian Territory, Occupied', 'wp-easy-contact'); ?>, <?php _e('Panama', 'wp-easy-contact'); ?>, <?php _e('Papua New Guinea', 'wp-easy-contact'); ?>, <?php _e('Paraguay', 'wp-easy-contact'); ?>, <?php _e('Peru', 'wp-easy-contact'); ?>, <?php _e('Philippines', 'wp-easy-contact'); ?>, <?php _e('Pitcairn', 'wp-easy-contact'); ?>, <?php _e('Poland', 'wp-easy-contact'); ?>, <?php _e('Portugal', 'wp-easy-contact'); ?>, <?php _e('Puerto Rico', 'wp-easy-contact'); ?>, <?php _e('Qatar', 'wp-easy-contact'); ?>, <?php _e('Reunion', 'wp-easy-contact'); ?>, <?php _e('Romania', 'wp-easy-contact'); ?>, <?php _e('Russian Federation', 'wp-easy-contact'); ?>, <?php _e('Rwanda', 'wp-easy-contact'); ?>, <?php _e('Saint Helena', 'wp-easy-contact'); ?>, <?php _e('Saint Kitts And Nevis', 'wp-easy-contact'); ?>, <?php _e('Saint Lucia', 'wp-easy-contact'); ?>, <?php _e('Saint Pierre And Miquelon', 'wp-easy-contact'); ?>, <?php _e('Saint Vincent And The Grenadines', 'wp-easy-contact'); ?>, <?php _e('Samoa', 'wp-easy-contact'); ?>, <?php _e('San Marino', 'wp-easy-contact'); ?>, <?php _e('Sao Tome And Principe', 'wp-easy-contact'); ?>, <?php _e('Saudi Arabia', 'wp-easy-contact'); ?>, <?php _e('Senegal', 'wp-easy-contact'); ?>, <?php _e('Serbia', 'wp-easy-contact'); ?>, <?php _e('Seychelles', 'wp-easy-contact'); ?>, <?php _e('Sierra Leone', 'wp-easy-contact'); ?>, <?php _e('Singapore', 'wp-easy-contact'); ?>, <?php _e('Slovakia', 'wp-easy-contact'); ?>, <?php _e('Slovenia', 'wp-easy-contact'); ?>, <?php _e('Solomon Islands', 'wp-easy-contact'); ?>, <?php _e('Somalia', 'wp-easy-contact'); ?>, <?php _e('South Africa', 'wp-easy-contact'); ?>, <?php _e('South Georgia And The South Sandwich Islands', 'wp-easy-contact'); ?>, <?php _e('Spain', 'wp-easy-contact'); ?>, <?php _e('Sri Lanka', 'wp-easy-contact'); ?>, <?php _e('Sudan', 'wp-easy-contact'); ?>, <?php _e('Suriname', 'wp-easy-contact'); ?>, <?php _e('Svalbard And Jan Mayen', 'wp-easy-contact'); ?>, <?php _e('Swaziland', 'wp-easy-contact'); ?>, <?php _e('Sweden', 'wp-easy-contact'); ?>, <?php _e('Switzerland', 'wp-easy-contact'); ?>, <?php _e('Syrian Arab Republic', 'wp-easy-contact'); ?>, <?php _e('Taiwan, Province Of China', 'wp-easy-contact'); ?>, <?php _e('Tajikistan', 'wp-easy-contact'); ?>, <?php _e('Tanzania, United Republic Of', 'wp-easy-contact'); ?>, <?php _e('Thailand', 'wp-easy-contact'); ?>, <?php _e('Timor-leste', 'wp-easy-contact'); ?>, <?php _e('Togo', 'wp-easy-contact'); ?>, <?php _e('Tokelau', 'wp-easy-contact'); ?>, <?php _e('Tonga', 'wp-easy-contact'); ?>, <?php _e('Trinidad And Tobago', 'wp-easy-contact'); ?>, <?php _e('Tunisia', 'wp-easy-contact'); ?>, <?php _e('Turkey', 'wp-easy-contact'); ?>, <?php _e('Turkmenistan', 'wp-easy-contact'); ?>, <?php _e('Turks And Caicos Islands', 'wp-easy-contact'); ?>, <?php _e('Tuvalu', 'wp-easy-contact'); ?>, <?php _e('Uganda', 'wp-easy-contact'); ?>, <?php _e('Ukraine', 'wp-easy-contact'); ?>, <?php _e('United Arab Emirates', 'wp-easy-contact'); ?>, <?php _e('United Kingdom', 'wp-easy-contact'); ?>, <?php _e('United States', 'wp-easy-contact'); ?>, <?php _e('United States Minor Outlying Islands', 'wp-easy-contact'); ?>, <?php _e('Uruguay', 'wp-easy-contact'); ?>, <?php _e('Uzbekistan', 'wp-easy-contact'); ?>, <?php _e('Vanuatu', 'wp-easy-contact'); ?>, <?php _e('Venezuela', 'wp-easy-contact'); ?>, <?php _e('Viet Nam', 'wp-easy-contact'); ?>, <?php _e('Virgin Islands, British', 'wp-easy-contact'); ?>, <?php _e('Virgin Islands, U.S.', 'wp-easy-contact'); ?>, <?php _e('Wallis And Futuna', 'wp-easy-contact'); ?>, <?php _e('Western Sahara', 'wp-easy-contact'); ?>, <?php _e('Yemen', 'wp-easy-contact'); ?>, <?php _e('Zambia', 'wp-easy-contact'); ?>, <?php _e('Zimbabwe', 'wp-easy-contact'); ?></p></div></td>
</tr>

<tr>
<th><?php _e('Contact Tag', 'wp-easy-contact'); ?></th>

<td><?php _e(' Contact Tag accepts multiple values like tags', 'wp-easy-contact'); ?>. <?php _e('Contact Tag does not have a default value', 'wp-easy-contact'); ?>.<div class="taxdef-block"><p><?php _e('There are no preset values for <b>Contact Tag.</b>', 'wp-easy-contact'); ?></p></div></td>
</tr>

<tr>
<th><?php _e('Topic', 'wp-easy-contact'); ?></th>

<td><?php _e(' Topic accepts multiple values like tags', 'wp-easy-contact'); ?>. <?php _e('Topic does not have a default value', 'wp-easy-contact'); ?>.<div class="taxdef-block"><p><?php _e('The following are the preset values for <b>Topic:</b>', 'wp-easy-contact'); ?></p><p class="taxdef-values"><?php _e('Customer Service', 'wp-easy-contact'); ?>, <?php _e('Product Information', 'wp-easy-contact'); ?>, <?php _e('My Account', 'wp-easy-contact'); ?>, <?php _e('Customer Feedback', 'wp-easy-contact'); ?></p></div></td>
</tr>
</table>
</div>
</div>
</li>
</ul>
</div>
</div>
<?php
}
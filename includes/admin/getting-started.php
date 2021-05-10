<?php
/**
 * Getting Started
 *
 * @package WP_EASY_CONTACT
 * @since WPAS 5.3
 */
if (!defined('ABSPATH')) exit;
add_action('wp_easy_contact_getting_started', 'wp_easy_contact_getting_started');
/**
 * Display getting started information
 * @since WPAS 5.3
 *
 * @return html
 */
function wp_easy_contact_getting_started() {
	global $title;
	list($display_version) = explode('-', WP_EASY_CONTACT_VERSION);
?>
<style>
.about-wrap img{
max-height: 200px;
}
div.comp-feature {
    font-weight: 400;
    font-size:20px;
}
.ent-com {
    display: none;
}
.green{
color: #008000;
font-size: 30px;
}
#nav-compare:before{
    content: "\f179";
}
#emd-about .nav-tab-wrapper a:before{
    position: relative;
    box-sizing: content-box;
padding: 0px 3px;
color: #4682b4;
    width: 20px;
    height: 20px;
    overflow: hidden;
    white-space: nowrap;
    font-size: 20px;
    line-height: 1;
    cursor: pointer;
font-family: dashicons;
}
#nav-getting-started:before{
content: "\f102";
}
#nav-release-notes:before{
content: "\f348";
}
#nav-resources:before{
content: "\f118";
}
#nav-features:before{
content: "\f339";
}
#emd-about .embed-container { 
	position: relative; 
	padding-bottom: 56.25%;
	height: 0;
	overflow: hidden;
	max-width: 100%;
	height: auto;
	} 

#emd-about .embed-container iframe,
#emd-about .embed-container object,
#emd-about .embed-container embed { 
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	}
#emd-about ul li:before{
    content: "\f522";
    font-family: dashicons;
    font-size:25px;
 }
#gallery {
display: -webkit-box;
display: -ms-flexbox;
display: flex;
-ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
#gallery .gallery-item {
	margin-top: 10px;
	margin-right: 10px;
	text-align: center;
        cursor:pointer;
}
#gallery img {
	border: 2px solid #cfcfcf; 
height: 405px; 
width: auto; 
}
#gallery .gallery-caption {
	margin-left: 0;
}
#emd-about .top{
text-decoration:none;
}
#emd-about .toc{
    background-color: #fff;
    padding: 25px;
    border: 1px solid #add8e6;
    border-radius: 8px;
}
#emd-about h3,
#emd-about h2{
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0.6em;
    margin-left: 0px;
}
#emd-about p,
#emd-about .emd-section li{
font-size:18px
}
#emd-about a.top:after{
content: "\f342";
    font-family: dashicons;
    font-size:25px;
text-decoration:none;
}
#emd-about .toc a,
#emd-about a.top{
vertical-align: top;
}
#emd-about li{
list-style-type: none;
line-height: normal;
}
#emd-about ol li {
    list-style-type: decimal;
}
#emd-about .quote{
    background: #fff;
    border-left: 4px solid #088cf9;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    margin-top: 25px;
    padding: 1px 12px;
}
#emd-about .tooltip{
    display: inline;
    position: relative;
}
#emd-about .tooltip:hover:after{
    background: #333;
    background: rgba(0,0,0,.8);
    border-radius: 5px;
    bottom: 26px;
    color: #fff;
    content: 'Click to enlarge';
    left: 20%;
    padding: 5px 15px;
    position: absolute;
    z-index: 98;
    width: 220px;
}
</style>

<?php add_thickbox(); ?>
<div id="emd-about" class="wrap about-wrap">
<div id="emd-header" style="padding:10px 0" class="wp-clearfix">
<div style="float:right"><img src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/wp-contact-logo-300x45.png"; ?>"></div>
<div style="margin: .2em 200px 0 0;padding: 0;color: #32373c;line-height: 1.2em;font-size: 2.8em;font-weight: 400;">
<?php printf(__('Welcome to WP Easy Contact Community %s', 'wp-easy-contact') , $display_version); ?>
</div>

<p class="about-text">
<?php printf(__("Provides easy to use contact management", 'wp-easy-contact') , $display_version); ?>
</p>
<div style="display: inline-block;"><a style="height: 50px; background:#ff8484;padding:10px 12px;color:#ffffff;text-align: center;font-weight: bold;line-height: 50px; font-family: Arial;border-radius: 6px; text-decoration: none;" href="https://emdplugins.com/plugin-pricing/wp-easy-contact-wordpress-plugin-pricing/?pk_campaign=wp-easy-contact-upgradebtn&amp;pk_kwd=wp-easy-contact-resources"><?php printf(__('Upgrade Now', 'wp-easy-contact') , $display_version); ?></a></div>
<div style="display: inline-block;margin-bottom: 20px;"><a style="height: 50px; background:#f0ad4e;padding:10px 12px;color:#ffffff;text-align: center;font-weight: bold;line-height: 50px; font-family: Arial;border-radius: 6px; text-decoration: none;" href="https://wpeasycontact.emdplugins.com//?pk_campaign=wp-easy-contact-buybtn&amp;pk_kwd=wp-easy-contact-resources"><?php printf(__('Visit Pro Demo Site', 'wp-easy-contact') , $display_version); ?></a></div>
<?php
	$tabs['getting-started'] = __('Getting Started', 'wp-easy-contact');
	$tabs['release-notes'] = __('Release Notes', 'wp-easy-contact');
	$tabs['resources'] = __('Resources', 'wp-easy-contact');
	$tabs['features'] = __('Features', 'wp-easy-contact');
	$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'getting-started';
	echo '<h2 class="nav-tab-wrapper wp-clearfix">';
	foreach ($tabs as $ktab => $mytab) {
		$tab_url[$ktab] = esc_url(add_query_arg(array(
			'tab' => $ktab
		)));
		$active = "";
		if ($active_tab == $ktab) {
			$active = "nav-tab-active";
		}
		echo '<a href="' . esc_url($tab_url[$ktab]) . '" class="nav-tab ' . $active . '" id="nav-' . $ktab . '">' . $mytab . '</a>';
	}
	echo '</h2>';
?>
<?php echo '<div class="tab-content" id="tab-getting-started"';
	if ("getting-started" != $active_tab) {
		echo 'style="display:none;"';
	}
	echo '>';
?>
<div style="height:25px" id="rtop"></div><div class="toc"><h3 style="color:#0073AA;text-align:left;">Quickstart</h3><ul><li><a href="#gs-sec-275">Live Demo Site</a></li>
<li><a href="#gs-sec-277">Need Help?</a></li>
<li><a href="#gs-sec-278">Learn More</a></li>
<li><a href="#gs-sec-276">Installation, Configuration & Customization Service</a></li>
<li><a href="#gs-sec-122">WP Easy Contact Community Introduction</a></li>
<li><a href="#gs-sec-128">Upgrade to WP Easy Contact Pro - Best Contact Management System for WordPress</a></li>
<li><a href="#gs-sec-124">EMD CSV Import Export Extension helps you get your data in and out of WordPress quickly, saving you ton of time</a></li>
<li><a href="#gs-sec-123">EMD Advanced Filters and Columns Extension for finding what's important faster</a></li>
<li><a href="#gs-sec-127">EMD MailChimp Extension for building email list through WP Easy Contact</a></li>
<li><a href="#gs-sec-129">Incoming Email WordPress Plugin - Create contacts from emails</a></li>
</ul></div><div class="quote">
<p class="about-description">The secret of getting ahead is getting started - Mark Twain</p>
</div>
<div id="gs-sec-275"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Live Demo Site</div><div class="changelog emd-section getting-started-275" style="margin:0;background-color:white;padding:10px"><div id="gallery"></div><div class="sec-desc"><p>Feel free to check out our <a target="_blank" href="https://wpeasycontactcom.emdplugins.com/?pk_campaign=wp-easy-contact-gettingstarted&pk_kwd=wp-easy-contact-livedemo">live demo site</a> to learn how to use WP Easy Contact Community starter edition. The demo site will always have the latest version installed.</p>
<p>You can also use the demo site to identify possible issues. If the same issue exists in the demo site, open a support ticket and we will fix it. If a WP Easy Contact Community feature is not functioning or displayed correctly in your site but looks and works properly in the demo site, it means the theme or a third party plugin or one or more configuration parameters of your site is causing the issue.</p>
<p>If you'd like us to identify and fix the issues specific to your site, purchase a work order to get started.</p>
<p><a target="_blank" style="
    padding: 16px;
    background: coral;
    border: 1px solid lightgray;
    border-radius: 12px;
    text-decoration: none;
    color: white;
    margin: 10px 0;
    display: inline-block;" href="https://emdplugins.com/expert-service-pricing/?pk_campaign=wp-easy-contact-gettingstarted&pk_kwd=wp-easy-contact-livedemo">Purchase Work Order</a></p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-277"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Need Help?</div><div class="changelog emd-section getting-started-277" style="margin:0;background-color:white;padding:10px"><div id="gallery"></div><div class="sec-desc"><p>There are many resources available in case you need help:</p>
<ul>
<li>Search our <a target="_blank" href="https://emdplugins.com/support">knowledge base</a></li>
<li><a href="https://emdplugins.com/kb_tags/wp-easy-contact" target="_blank">Browse our WP Easy Contact Community articles</a></li>
<li><a href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation" target="_blank">Check out WP Easy Contact Community documentation for step by step instructions.</a></li>
<li><a href="https://emdplugins.com/emdplugins-support-introduction/" target="_blank">Open a support ticket if you still could not find the answer to your question</a></li>
</ul>
<p>Please read <a href="https://emdplugins.com/questions/what-to-write-on-a-support-ticket-related-to-a-technical-issue/" target="_blank">"What to write to report a technical issue"</a> before submitting a support ticket.</p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-278"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Learn More</div><div class="changelog emd-section getting-started-278" style="margin:0;background-color:white;padding:10px"><div id="gallery"></div><div class="sec-desc"><p>The following articles provide step by step instructions on various concepts covered in WP Easy Contact Community.</p>
<ul><li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article219">Concepts</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article463">Quick Start</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article220">Working with Contacts</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article221">Widgets</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article222">Forms</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article227">Roles and Capabilities</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article223">Administration</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article225">Screen Options</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article224">Localization(l10n)</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation/#article226">Glossary</a>
</li></ul>
</div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-276"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Installation, Configuration & Customization Service</div><div class="changelog emd-section getting-started-276" style="margin:0;background-color:white;padding:10px"><div id="gallery"></div><div class="sec-desc"><p>Get the peace of mind that comes from having WP Easy Contact Community properly installed, configured or customized by eMarket Design.</p>
<p>Being the developer of WP Easy Contact Community, we understand how to deliver the best value, mitigate risks and get the software ready for you to use quickly.</p>
<p>Our service includes:</p>
<ul>
<li>Professional installation by eMarket Design experts.</li>
<li>Configuration to meet your specific needs</li>
<li>Installation completed quickly and according to best practice</li>
<li>Knowledge of WP Easy Contact Community best practices transferred to your team</li>
</ul>
<p>Pricing of the service is based on the complexity of level of effort, required skills or expertise. To determine the estimated price and duration of this service, and for more information about related services, purchase a work order.  
<p><a target="_blank" style="
    padding: 16px;
    background: coral;
    border: 1px solid lightgray;
    border-radius: 12px;
    text-decoration: none;
    color: white;
    margin: 10px 0;
    display: inline-block;" href="https://emdplugins.com/expert-service-pricing/?pk_campaign=wp-easy-contact-gettingstarted&pk_kwd=wp-easy-contact-livedemo">Purchase Work Order</a></p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-122"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">WP Easy Contact Community Introduction</div><div class="changelog emd-section getting-started-122" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="wXaxzip-92M" data-ratio="16:9">loading...</div><div class="sec-desc"><p>Watch WP Easy Contact Community introduction video to learn about the plugin features and configuration.</p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-128"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Upgrade to WP Easy Contact Pro - Best Contact Management System for WordPress</div><div class="changelog emd-section getting-started-128" style="margin:0;background-color:white;padding:10px"><div id="gallery"><div class="sec-img gallery-item"><a class="thickbox tooltip" rel="gallery-128" href="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/montage_wpeasy_contact_pro.jpg"; ?>"><img src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/montage_wpeasy_contact_pro.jpg"; ?>"></a></div></div><div class="sec-desc"><p>WP Easy Contact Pro --> easy to use and powerful contact management system for WordPress with best in class features.</p><div style="margin:25px"><a href="https://emdplugins.com/plugins/wp-easy-contact-wordpress-plugin/?pk_campaign=wpec-pro-buybtn&pk_kwd=wp-easy-contact-resources"><img style="width: 154px;" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></div></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-124"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">EMD CSV Import Export Extension helps you get your data in and out of WordPress quickly, saving you ton of time</div><div class="changelog emd-section getting-started-124" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="tJDQbU3jS0c" data-ratio="16:9">loading...</div><div class="sec-desc"><p><b>This feature is included in WP Easy Contact Pro edition.</b></p>
<p>EMD CSV Import Export Extension helps bulk import, export, update entries from/to CSV files. You can also reset(delete) all data and start over again without modifying database. The export feature is also great for backups and archiving old or obsolete data.</p>
<p><a href="https://emdplugins.com/plugin-features/wp-easy-contact-importexport-addon/?pk_campaign=emdimpexp-buybtn&pk_kwd=wp-easy-contact-resources"><img style="width: 154px;" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-123"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">EMD Advanced Filters and Columns Extension for finding what's important faster</div><div class="changelog emd-section getting-started-123" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="JDIHIibWyR0" data-ratio="16:9">loading...</div><div class="sec-desc"><p><b>This feature is included in WP Easy Contact Pro edition.</b></p>
<p>EMD Advanced Filters and Columns Extension for WP Easy Contact Community edition helps you:</p><ul><li>Filter entries quickly to find what you're looking for</li><li>Save your frequently used filters so you do not need to create them again</li><li>Sort entry columns to see what's important faster</li><li>Change the display order of columns </li>
<li>Enable or disable columns for better and cleaner look </li><li>Export search results to PDF or CSV for custom reporting</li></ul><div style="margin:25px"><a href="https://emdplugins.com/plugin-features/wp-easy-contact-smart-search-and-columns-addon/?pk_campaign=emd-afc-buybtn&pk_kwd=wp-easy-contact-resources"><img style="width: 154px;" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></div></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-127"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">EMD MailChimp Extension for building email list through WP Easy Contact</div><div class="changelog emd-section getting-started-127" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="Oi_c-0W1Sdo" data-ratio="16:9">loading...</div><div class="sec-desc"><p>EMD MailChimp Extension helps you build MailChimp email list based on the contact information collected through WP Easy Contact Community form.</p><div style="margin:25px"><a href="https://emdplugins.com/plugin-features/wp-easy-contact-mailchimp-addon/?pk_campaign=emd-mailchimp-buybtn&pk_kwd=wp-easy-contact-resources"><img style="width: 154px;" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></div></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-129"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Incoming Email WordPress Plugin - Create contacts from emails</div><div class="changelog emd-section getting-started-129" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="I4Ou1NptL9k" data-ratio="16:9">loading...</div><div class="sec-desc"><p>Incoming Email WordPress Plugin allows to create contact records from emails opening up another channel to grow your list or generate leads.</p>

<p><a href="https://emdplugins.com/plugin-features/wp-easy-contact-incoming-email-addon/?pk_campaign=wpasincemail-buybtn&pk_kwd=wp-easy-contact-resources"><img style="width: 154px;" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px">

<?php echo '</div>'; ?>
<?php echo '<div class="tab-content" id="tab-release-notes"';
	if ("release-notes" != $active_tab) {
		echo 'style="display:none;"';
	}
	echo '>';
?>
<p class="about-description">This page lists the release notes from every production version of WP Easy Contact Community.</p>


<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.7.3 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1285" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
tested with WP 5.7</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.7.2 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1218" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
multi-select form component missing scroll bars when the content overflows its fixed height.</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.7.1 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1161" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
tested with WP 5.5.1</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1160" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
updates to translation strings and libraries</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1159" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added version numbers to js and css files for caching purposes</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.7.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1080" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
updates and improvements to libraries</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1079" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added previous and next buttons for the edit screens of contacts</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.6.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1017" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Emd templates</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1016" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
updates and improvements to form library</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1015" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added support for Emd Custom Field Builder when upgraded to premium editions</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.5.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-957" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
Session cleanup workflow by creating a custom table to process records.</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-956" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added Emd form builder support.</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-955" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
XSS related issues.</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-954" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Cleaned up unnecessary code and optimized the library file content.</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.4.1 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-894" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
misc. library updates for better compatibility and stability</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.4.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-858" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Emd templating system to match modern web standards</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-857" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Created a new shortcode page which displays all available shortcodes. You can access this page under the plugin settings.</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.3.1 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-765" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
misc. library updates for better compatibility and stability</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.3.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-584" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
library updates</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.2.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-321" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Updated codemirror libraries for custom CSS and JS options in plugin settings page</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-320" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
PHP 7 compatibility</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-319" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added container type field in the plugin settings</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-318" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added custom JavaScript option in plugin settings under Tools tab</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.1.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-226" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
WP Sessions security vulnerability</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">3.0.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-213" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Configured to work with EMD Advanced Filters and Columns Extension for finding what’s important faster</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-212" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Configured to work with EMD CSV Import Export Extension for bulk import/export</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-211" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Configured to work with EMD MailChimp extension</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-210" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added a getting started page for plugin introduction, tips and resources</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-209" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added topic taxonomy to contact form</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-152" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Template System</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<?php echo '</div>'; ?>
<?php echo '<div class="tab-content" id="tab-resources"';
	if ("resources" != $active_tab) {
		echo 'style="display:none;"';
	}
	echo '>';
?>
<div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Extensive documentation is available</div><div class="emd-section changelog resources resources-121" style="margin:0;background-color:white;padding:10px"><div style="height:40px" id="gs-sec-121"></div><div id="gallery" class="wp-clearfix"></div><div class="sec-desc"><a href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation">WP Easy Contact Community Documentation</a></div></div><div style="margin-top:15px"><a href="#ptop" class="top">Go to top</a></div><hr style="margin-top:40px"><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">How to customize WP Easy Contact Community</div><div class="emd-section changelog resources resources-126" style="margin:0;background-color:white;padding:10px"><div style="height:40px" id="gs-sec-126"></div><div class="emd-yt" data-youtube-id="4wcFcIfHhPA" data-ratio="16:9">loading...</div><div class="sec-desc"><p><strong><span class="dashicons dashicons-arrow-up-alt"></span> Watch the customization video to familiarize yourself with the customization options. </strong>. The video shows one of our plugins as an example. The concepts are the same and all our plugins have the same settings.</p>
<p>WP Easy Contact Community is designed and developed using <a href="https://wpappstudio.com">WP App Studio (WPAS) Professional WordPress Development platform</a>. All WPAS plugins come with extensive customization options from plugin settings without changing theme template files. Some of the customization options are listed below:</p>
<ul>
	<li>Enable or disable all fields, taxonomies and relationships from backend and/or frontend</li>
        <li>Use the default EMD or theme templating system</li>
	<li>Set slug of any entity and/or archive base slug</li>
	<li>Set the page template of any entity, taxonomy and/or archive page to sidebar on left, sidebar on right or no sidebar (full width)</li>
	<li>Hide the previous and next post links on the frontend for single posts</li>
	<li>Hide the page navigation links on the frontend for archive posts</li>
	<li>Display or hide any custom field</li>
	<li>Display any sidebar widget on plugin pages using EMD Widget Area</li>
	<li>Set custom CSS rules for all plugin pages including plugin shortcodes</li>
</ul>
<div class="quote">
<p>If your customization needs are more complex, you’re unfamiliar with code/templates and resolving potential conflicts, we strongly suggest you to <a href="https://emdplugins.com/open-a-support-ticket/?pk_campaign=wp-easy-contact-hireme-custom&ticket_topic=pre-sales-questions">hire us</a>, we will get your site up and running in no time.
</p>
</div></div></div><div style="margin-top:15px"><a href="#ptop" class="top">Go to top</a></div><hr style="margin-top:40px"><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">How to resolve theme related issues</div><div class="emd-section changelog resources resources-125" style="margin:0;background-color:white;padding:10px"><div style="height:40px" id="gs-sec-125"></div><div id="gallery" class="wp-clearfix"><div class="sec-img gallery-item"><a class="thickbox tooltip" rel="gallery-125" href="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/emd_templating_system.png"; ?>"><img src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/emd_templating_system.png"; ?>"></a></div></div><div class="sec-desc"><p>If your theme is not coded based on WordPress theme coding standards, does have an unorthodox markup or its style.css is messing up how WP Easy Contact Community pages look and feel, you will see some unusual changes on your site such as sidebars not getting displayed where they are supposed to or random text getting displayed on headers etc. after plugin activation.</p>
<p>The good news is WP Easy Contact Community plugin is designed to minimize theme related issues by providing two distinct templating systems:</p>
<ul>
<li>The EMD templating system is the default templating system where the plugin uses its own templates for plugin pages.</li>
<li>The theme templating system where WP Easy Contact Community uses theme templates for plugin pages.</li>
</ul>
<p>The EMD templating system is the recommended option. If the EMD templating system does not work for you, you need to check "Disable EMD Templating System" option at Settings > Tools tab and switch to theme based templating system.</p>
<p>Please keep in mind that when you disable EMD templating system, you loose the flexibility of modifying plugin pages without changing theme template files.</p>
<p>If none of the provided options works for you, you may still fix theme related conflicts following the steps in <a href="https://docs.emdplugins.com/docs/wp-easy-contact-community-documentation">WP Easy Contact Community Documentation - Resolving theme related conflicts section.</a></p>

<div class="quote">
<p>If you’re unfamiliar with code/templates and resolving potential conflicts, <a href="https://emdplugins.com/open-a-support-ticket/?pk_campaign=raq-hireme&ticket_topic=pre-sales-questions"> do yourself a favor and hire us</a>. Sometimes the cost of hiring someone else to fix things is far less than doing it yourself. We will get your site up and running in no time.</p>
</div></div></div><div style="margin-top:15px"><a href="#ptop" class="top">Go to top</a></div><hr style="margin-top:40px">
<?php echo '</div>'; ?>
<?php echo '<div class="tab-content" id="tab-features"';
	if ("features" != $active_tab) {
		echo 'style="display:none;"';
	}
	echo '>';
?>
<h3>Start driving success on every deal, every day</h3>
<p>Explore the full list of features available in the the latest version of WP Easy Contact. Click on a feature title to learn more.</p>
<table class="widefat features striped form-table" style="width:auto;font-size:16px">
<tr><td><a href="https://emdplugins.com/?p=10509&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/contacts.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10509&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Centralize all your contacts in one location to minimize conflicts, dupes or errors.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10510&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/responsive.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10510&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Allow submissions from any device any time.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10515&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/widgets.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10515&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Display recent contacts on your sidebar.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10511&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/customize.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10511&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Fully customize your contact form from the plugin settings.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10514&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/shop.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10514&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Categorize and group contacts to  better qualify them.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10512&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/no-spam.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10512&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Powerful spam protection system.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10513&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/custom-fields.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10513&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Add additional fields to your contact management database using EMD Custom Field Builder.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10516&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/task-list.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10516&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Create and assign tasks to your team.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10522&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/google-map.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10522&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Google map field to display your  location on the contact form.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10518&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/megaphone.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10518&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Powerful notification system for you and contacts.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10989&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/empower-users.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10989&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Expand what contact managers can do from plugin settings.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10526&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/check.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10526&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">See completed tasks on your sidebar.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10523&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/social-media.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10523&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Display your social media links in the contact form.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10639&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/key.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10639&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Contact manager role to manage contact lists.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10525&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/upload.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10525&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Allow contacts to upload files with ease.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10524&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/terms-cond.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10524&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Ask contacts to accept your terms and conditions before submission.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10519&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/rgb.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10519&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Create relationships between contacts.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10521&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/settings.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10521&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Customize with ease.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10517&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/dashboard.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10517&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Powerful contact management dashboard.</a></td><td> - Premium feature (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10531&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/email.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10531&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Create contact records from the incoming emails.</a></td><td> - Add-on</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10641&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/mailchimp.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10641&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Add contacts to your MailChimp list automatically.</a></td><td> - Add-on</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10640&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/zoomin.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10640&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Search contacts, create segments and export the results to PDF or CSV in WordPress Dashboard.</a></td><td> - Add-on (included in Pro)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10529&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo WP_EASY_CONTACT_PLUGIN_URL . "assets/img/csv-impexp.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10529&pk_campaign=wp-easy-contact-com&pk_kwd=getting-started">Powerful import, export and update contact lists from or to CSV.</a></td><td> - Add-on (included in Pro)</td></tr>
</table>
<?php echo '</div>'; ?>
<?php echo '</div>';
}
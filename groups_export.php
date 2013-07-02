<?php 
/*
Plugin Name: Groups Export
Plugin URI: 
Description: 1-click CSV export for Groups (First Name, Last Name, First Last Name, ID, Email)
Author: Steve Stone
Version: 1.0
Author URI: 
*/

function oscimp_getproducts($product_cnt=1) {

	//Connect to the OSCommerce database
	$oscommercedb = new wpdb(get_option('ge_group_id'),get_option('ge_export_id'),get_option('ge_export_fname'),get_option('ge_export_lname'),get_option('ge_export_flname'),get_option('ge_export_email'));

	$retval = '';
	
	
	return $retval;
}

//*************** Admin function ***************
function groups_export_admin() {
	include('groups_export_admin.php');
}

function oscimp_admin_actions() {
    add_options_page("Groups Export", "Groups Export", 1, "groups-export", "groups_export_admin");
}

add_action('admin_menu', 'oscimp_admin_actions');

?>
<?php 
/*
Plugin Name: Groups Export
Plugin URI: http://steveostudios.tv/groups-export
Description: 1-click CSV export for Groups (First Name, Last Name, First and Last Name, ID, Email)
Author: Steve Stone
Version: 1.0
Author URI: http://steveostudios.tv
*/


//*************** Admin function ***************
function groups_export_admin() {
  include('groups_export_admin.php');
}

add_action('admin_menu', 'groups_export_admin_actions');

function groups_export_admin_actions() {
	add_options_page('Groups Export', 'Groups Export', 'manage_options', 'groups_export_admin.php', 'groups_export_admin');
}

?>
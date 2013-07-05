<?php
  header("Content-type: text/csv");  
  header("Cache-Control: no-store, no-cache");  
  header('Content-Disposition: attachment; filename="groups-export.csv"');
  include_once( "../../../wp-load.php" );

  function ge_csv_export() {
    $outstream = fopen("php://output",'w');
    $ge_group_id = (isset($_POST['ge_group_id']))? $_POST['ge_group_id'] : null;
		$ge_export_id = (isset($_POST['ge_export_id']))? $_POST['ge_export_id'] : null;
		$ge_export_fname = (isset($_POST['ge_export_fname']))? $_POST['ge_export_fname'] : null;
		$ge_export_lname = (isset($_POST['ge_export_lname']))? $_POST['ge_export_lname'] : null;
		$ge_export_flname = (isset($_POST['ge_export_flname']))? $_POST['ge_export_flname'] : null;
		$ge_export_email = (isset($_POST['ge_export_email']))? $_POST['ge_export_email'] : null;
  
    global $wpdb;
    
    $user_ids = $wpdb->get_results( 
    	"
    	SELECT * 
    	FROM `wp_groups_user_group` 
    	WHERE `group_id` = $ge_group_id
    	"
    );
    $result = array();
    foreach ( $user_ids as $user_id ) {
      $result[$user_id->user_id] = array();
      // ID
      if(isset($ge_export_id) && $ge_export_id == 'on') {
        $result[$user_id->user_id]['id'] = $user_id->user_id;
      }
      // First and/or Last Name
      if((isset($ge_export_fname) && $ge_export_fname == 'on')) {
        $user_name = $wpdb->get_row(
          "
          SELECT 
            (SELECT `meta_value` FROM `wp_usermeta` WHERE `user_id` = $user_id->user_id AND `meta_key` = 'first_name') AS first_name,
            (SELECT `meta_value` FROM `wp_usermeta` WHERE `user_id` = $user_id->user_id AND `meta_key` = 'last_name') AS last_name
          "
        );
        if((isset($ge_export_fname) && $ge_export_fname == 'on')) {
          $result[$user_id->user_id]['fname'] = $user_name->first_name;
        }
        if((isset($ge_export_lname) && $ge_export_lname == 'on')) {
          $result[$user_id->user_id]['lname'] = $user_name->last_name;
        }
        if((isset($ge_export_flname) && $ge_export_flname == 'on')) {
          $result[$user_id->user_id]['flname'] = $user_name->first_name . ' ' . $user_name->last_name;
        }
      }
      // Email
      if(isset($ge_export_email) && $ge_export_email == 'on') {    
        $user_email = $wpdb->get_var(
          "
          SELECT `user_email` 
          FROM  `wp_users` 
          WHERE  `ID` =  $user_id->user_id
          "
        );  
        $result[$user_id->user_id]['email'] = $user_email;
      }
    }

    foreach ($result as $row) {
      fputcsv($outstream, $row, ',', '"');
    }
    fclose($outstream);
  }
  ob_end_clean();
  ge_csv_export();
?>
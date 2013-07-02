<?php
  $ge_group_id = $_POST['ge_group_id'];
	$ge_export_id = $_POST['ge_export_id'];
	$ge_export_fname = $_POST['ge_export_fname'];
	$ge_export_lname = $_POST['ge_export_lname'];
	$ge_export_flname = $_POST['ge_export_flname'];
	$ge_export_email = $_POST['ge_export_email'];
	
  include_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );
  
  header("Content-type: text/csv");  
  header("Cache-Control: no-store, no-cache");  
  header('Content-Disposition: attachment; filename="group-email.csv"');  
    
  $outstream = fopen("php://output",'w');  

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
    $user = $wpdb->get_results(
      "
      SELECT * 
      FROM  `wp_users` 
      WHERE  `ID` =  $user_id->user_id
      "
    );

    array_push($result, $user);
  }


  foreach ($result as $row) {
    $row_inner = array();
    if ($ge_export_id == 'on') {
      array_push($row_inner, $row[0]->ID);
    }
    if ($ge_export_email == 'on') {
      array_push($row_inner, $row[0]->user_email);
    }
    
    //$row_inner = array($row[0]->ID,$row[0]->user_email);

    fputcsv($outstream, $row_inner, ',', '"');
  } 
    
  fclose($outstream);
?>
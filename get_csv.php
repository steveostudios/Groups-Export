<?php
  $ge_group_id = $_POST['ge_group_id'];
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
    $user_email = $wpdb->get_var(
      "
      SELECT `user_email` 
      FROM  `wp_users` 
      WHERE  `ID` =  $user_id->user_id
      "
    );
    $email_result = array('email',$user_email);
    array_push($result, $email_result);
  }  
  foreach ($result as $row) {
    fputcsv($outstream, $row, ',', '"');
  } 
  
  
  fclose($outstream);
?>
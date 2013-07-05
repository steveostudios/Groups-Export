<?php
  global $wpdb;
	if(isset($_POST['oscimp_hidden']) && $_POST['oscimp_hidden'] == 'Y') { // Save button
		
		$ge_group_id = (isset($_POST['ge_group_id']))? $_POST['ge_group_id'] : null;
		$ge_export_id = (isset($_POST['ge_export_id']))? $_POST['ge_export_id'] : null;
		$ge_export_fname = (isset($_POST['ge_export_fname']))? $_POST['ge_export_fname'] : null;
		$ge_export_lname = (isset($_POST['ge_export_lname']))? $_POST['ge_export_lname'] : null;
		$ge_export_flname = (isset($_POST['ge_export_flname']))? $_POST['ge_export_flname'] : null;
		$ge_export_email = (isset($_POST['ge_export_email']))? $_POST['ge_export_email'] : null;		
		
		update_option('ge_group_id', $ge_group_id);
		update_option('ge_export_id', $ge_export_id);
		update_option('ge_export_fname', $ge_export_fname);
		update_option('ge_export_lname', $ge_export_lname);
		update_option('ge_export_flname', $ge_export_flname);
		update_option('ge_export_email', $ge_export_email);
    
		?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
		<?php
	} else { // Everything else
		
		$ge_group_id = get_option('ge_group_id');
		$ge_export_id = get_option('ge_export_id');
		$ge_export_fname = get_option('ge_export_fname');
		$ge_export_lname = get_option('ge_export_lname');
		$ge_export_flname = get_option('ge_export_flname');
		$ge_export_email = get_option('ge_export_email');

	}
	
	$checked_id = ' ';
	$checked_fname = ' ';
	$checked_lname = ' ';
	$checked_flname = ' ';
	$checked_email = ' ';
	
	if($ge_export_id == 'on') {$checked_id = 'checked ';}
	if($ge_export_fname == 'on') {$checked_fname = 'checked ';}
	if($ge_export_lname == 'on') {$checked_lname = 'checked ';}
	if($ge_export_flname == 'on') {$checked_flname = 'checked ';}
	if($ge_export_email == 'on') {$checked_email = 'checked ';}
	
?>

<div class="wrap">
<?php    echo "<h2>" . __( 'Group Export Options', 'oscimp_trdom' ) . "</h2>"; ?>

<form id="ge_form" name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input id="ge_hidden" type="hidden" name="oscimp_hidden" value="Y">
	<input type="hidden" name="server_root" value="<?php echo get_option("siteurl"); ?>" />
	<h4>Export Group</h4>
	<select id="ge_group_id" class="ge_input" name="ge_group_id">
	  <option value="">--- Select a Group ---</option>
	  <?php
	    $groups = $wpdb->get_results(
  	    "
  	    SELECT `group_id`, `parent_id`, `name`, `description` 
  	    FROM `wp_groups_group`
  	    "
      );
      foreach($groups as $group) {
        $selected = '';
        if($ge_group_id == $group->group_id) {
          $selected = ' selected="selected"';
        }
        echo '<option value="' . $group->group_id . '"' . $selected . '>' . $group->name . '</option>';
      }
	    
	  ?>
	</select>
	<!-- <p><?php _e("Group ID: " ); ?><input type="text" id="ge_group_id" class="ge_input" name="ge_group_id" value="<?php echo $ge_group_id; ?>" size="20"><?php _e(" ex: 2"); ?></p> -->
	<h4>Export Columns</h4>
	<p><input type="checkbox" id="ge_export_id" class="ge_input" name="ge_export_id" <?php echo($checked_id); ?>/><?php _e(' ID') ?></p>
	<p><input type="checkbox" id="ge_export_fname" class="ge_input" name="ge_export_fname" <?php echo($checked_fname); ?>/><?php _e(' First Name') ?></p> 
	<p><input type="checkbox" id="ge_export_lname" class="ge_input" name="ge_export_lname" <?php echo($checked_lname); ?>/><?php _e(' Last Name') ?></p>
	<p><input type="checkbox" id="ge_export_flname" class="ge_input" name="ge_export_flname" <?php echo($checked_flname); ?>/><?php _e(' First & Last Name') ?></p>
  <p><input type="checkbox" id="ge_export_email" class="ge_input" name="ge_export_email" <?php echo($checked_email); ?>/><?php _e(' Email') ?></p>
	<p class="submit">
  	<input type="submit" name="Submit" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" />
  	<input type='button' id='ge_download' name='ge_download' value='Download CSV' />
	</p>
</form>


</div>
<script type="text/javascript">
var $j = jQuery.noConflict();


$j(document).ready(function() {
  $j(document).on('change', '.ge_input', function() {
    checkInputs();
  });
  
  checkInputs();

  function checkInputs() {
    if((!$j('#ge_export_id').attr('checked') && !$j('#ge_export_fname').attr('checked') && !$j('#ge_export_lname').attr('checked') && !$j('#ge_export_flname').attr('checked') && !$j('#ge_export_email').attr('checked') ) || $j('#ge_group_id').val().length == 0){
      $j("#ge_download").attr("disabled", "disabled");
    } else {
      $j("#ge_download").removeAttr("disabled");
    }
  } 
});


var form = document.getElementById('ge_form');
form.onsubmit = function() {
    form.target = '_self';
};

document.getElementById('ge_download').onclick = function() {
    document.getElementById('ge_hidden').value = 'generate';
    form.target = '_self';
    form.action = "<?php echo plugin_dir_url(__FILE__); ?>get_csv.php";
    form.submit();
    
}
</script>
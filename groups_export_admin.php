<?php
  global $wpdb;
	if(isset($_POST['ge_action']) && $_POST['ge_action'] == 'update') { // Save button
		
		$ge_group_id = (isset($_POST['ge_group_id']))? $_POST['ge_group_id'] : null;
		$ge_export_id = (isset($_POST['ge_export_id']))? $_POST['ge_export_id'] : null;
		$ge_export_fname = (isset($_POST['ge_export_fname']))? $_POST['ge_export_fname'] : null;
		$ge_export_lname = (isset($_POST['ge_export_lname']))? $_POST['ge_export_lname'] : null;
		$ge_export_flname = (isset($_POST['ge_export_flname']))? $_POST['ge_export_flname'] : null;
		$ge_export_email = (isset($_POST['ge_export_email']))? $_POST['ge_export_email'] : null;		
		$ge_field_delimitor = (isset($_POST['ge_field_delimitor']))? $_POST['ge_field_delimitor'] : null;
    $ge_oneline = (isset($_POST['ge_oneline']))? $_POST['ge_oneline'] : null;
		
		update_option('ge_group_id', $ge_group_id);
		update_option('ge_export_id', $ge_export_id);
		update_option('ge_export_fname', $ge_export_fname);
		update_option('ge_export_lname', $ge_export_lname);
		update_option('ge_export_flname', $ge_export_flname);
		update_option('ge_export_email', $ge_export_email);
		update_option('ge_field_delimitor', $ge_field_delimitor);
		update_option('ge_oneline', $ge_oneline);
    
		?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
		<?php
	} else { // Everything else
		if(isset($_POST['ge_action']) && $_POST['ge_action'] == 'download') {
		?>
		  <div class="updated"><p><strong><?php _e('Export Downloaded. Check your downloads locataion.' ); ?></strong></p></div>
		<?php
		}
		
		$ge_group_id = get_option('ge_group_id');
		$ge_export_id = get_option('ge_export_id');
		$ge_export_fname = get_option('ge_export_fname');
		$ge_export_lname = get_option('ge_export_lname');
		$ge_export_flname = get_option('ge_export_flname');
		$ge_export_email = get_option('ge_export_email');
		$ge_field_delimitor = get_option('ge_field_delimitor');
		$ge_oneline = get_option('ge_oneline');

	}
	
	unset($_POST['ge_action']);
	
	$checked_id = ' ';
	$checked_fname = ' ';
	$checked_lname = ' ';
	$checked_flname = ' ';
	$checked_email = ' ';
	$checked_oneline = ' ';
	
	if($ge_export_id == 'on') {$checked_id = 'checked ';}
	if($ge_export_fname == 'on') {$checked_fname = 'checked ';}
	if($ge_export_lname == 'on') {$checked_lname = 'checked ';}
	if($ge_export_flname == 'on') {$checked_flname = 'checked ';}
	if($ge_export_email == 'on') {$checked_email = 'checked ';}
	if($ge_oneline == 'on') {$checked_oneline = 'checked ';}
	
?>

<div class="wrap">
<?php    echo "<h2>" . __( 'Group Export Options', 'groups_export' ) . "</h2>"; ?>
<form id="ge_form" name="ge_form" method="post">
	<input id="ge_hidden" type="hidden" name="ge_action" value="Y">
	<input type="hidden" name="server_root" value="<?php echo get_option("siteurl"); ?>" />
	<h4>Export Group</h4>
	
	<p>Group to export: 
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
	</p>
	<!-- <p><?php _e("Group ID: " ); ?><input type="text" id="ge_group_id" class="ge_input" name="ge_group_id" value="<?php echo $ge_group_id; ?>" size="20"><?php _e(" ex: 2"); ?></p> -->
	<h4>Export Columns</h4>
	<p><input type="checkbox" id="ge_export_id" class="ge_input" name="ge_export_id" <?php echo($checked_id); ?>/><?php _e(' ID') ?></p>
	<p><input type="checkbox" id="ge_export_fname" class="ge_input" name="ge_export_fname" <?php echo($checked_fname); ?>/><?php _e(' First Name') ?></p> 
	<p><input type="checkbox" id="ge_export_lname" class="ge_input" name="ge_export_lname" <?php echo($checked_lname); ?>/><?php _e(' Last Name') ?></p>
	<p><input type="checkbox" id="ge_export_flname" class="ge_input" name="ge_export_flname" <?php echo($checked_flname); ?>/><?php _e(' First & Last Name') ?></p>
  <p><input type="checkbox" id="ge_export_email" class="ge_input" name="ge_export_email" <?php echo($checked_email); ?>/><?php _e(' Email') ?></p>
  <h4>CSV Options</h4>
  <p>Field Delimitor: 
    <select name="ge_field_delimitor">
      <?php
        $delimitors = array(
          "comma"=>"Comma (,)",
          "colon"=>"Colon (:)",
          "semicolon"=>"Semi-colon (;)",
          "pipe"=>"Pipe (|)",
          "caret"=>"Caret (^)",
          "tab"=>"Tab"
        );
        foreach($delimitors as $key => $delimitor) {
          $selected = '';
          if($key == $ge_field_delimitor) {
            $selected = ' selected="selected"';
          }
          echo '<option value="' . $key . '"' . $selected . '>' . $delimitor . '</option>';
        }
      ?>
    </select>
  </p>
  <div id="oneline">
  <p><input type="checkbox" id="ge_oneline" class="ge_input" name="ge_oneline" <?php echo($checked_oneline); ?>/><?php _e(' Export as one-line') ?></p>
  <p class="description">This will export the list as one comma separated line (i.e. email1@domain.com, email2@domain.org, email3@domain.net)</p>
  </div>
	<p class="submit">
  	<input type="submit" name="Submit" value="<?php _e('Update Options', 'groups_export' ) ?>" />
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
    if((!$j('#ge_export_id').prop('checked') && !$j('#ge_export_fname').prop('checked') && !$j('#ge_export_lname').prop('checked') && !$j('#ge_export_flname').prop('checked') && !$j('#ge_export_email').prop('checked') ) || $j('#ge_group_id').val().length == 0){
      $j("#ge_download").attr("disabled", "disabled");
    } else {
      $j("#ge_download").removeAttr("disabled");
    }
    var check_count = 0;
    if($j('#ge_export_id').prop('checked')) {check_count++;}
    if($j('#ge_export_fname').prop('checked')) {check_count++;}
    if($j('#ge_export_lname').prop('checked')) {check_count++;}
    if($j('#ge_export_flname').prop('checked')) {check_count++;}
    if($j('#ge_export_email').prop('checked')) {check_count++;}
    if(check_count == 1) {
      $j('#oneline').show();
      
      //alert ('there is '+check_count);
    } else {
      $j('#oneline').hide();
      $j('#ge_oneline').prop("checked", false);
    }
    
  } 
});

  var form = document.getElementById('ge_form');
form.onsubmit = function() {
    document.getElementById('ge_hidden').value = 'update';
    form.target = '_self';
    form.action = "<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>";
};

document.getElementById('ge_download').onclick = function() {
    document.getElementById('ge_hidden').value = 'download';
    form.target = '_self';
    form.action = "<?php echo plugin_dir_url(__FILE__); ?>get_csv.php";
    form.submit();    
}
</script>
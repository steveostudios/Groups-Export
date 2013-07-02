<?php 
	if($_POST['oscimp_hidden'] == 'Y') { // Save button
		$ge_group_id = $_POST['ge_group_id'];
		update_option('ge_group_id', $ge_group_id);
    
		?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
		<?php
	} else if($_POST['oscimp_hidden'] == 'generate') { // Generate button
	  header('Location: '.plugins_url( 'get_csv.php' , __FILE__ ));
	  header('HTTP/1.1 307 Temporary Redirect');
	  ?>
		<div class="updated"><p><strong><?php _e('Finished. Check your downloads location.' ); ?></strong></p></div>
		<?php
	} else { // Everything else
		$ge_group_id = get_option('ge_group_id');


	}	
?>

<div class="wrap">
<?php    echo "<h2>" . __( 'Group Export Options', 'oscimp_trdom' ) . "</h2>"; ?>

<form id="ge_form" name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input id="ge_hidden" type="hidden" name="oscimp_hidden" value="Y">
	<p><?php _e("Member group: " ); ?><input type="text" name="ge_group_id" value="<?php echo $ge_group_id; ?>" size="20"><?php _e(" ex: 2"); ?></p>
	<h4>THESE CHECKBOXES DO NOT WORK</h4>
	<p><?php _e('ID') ?><input type="checkbox" /></p>
	<p><?php _e('First Name') ?><input type="checkbox" /></p>
	<p><?php _e('Last Name') ?><input type="checkbox" /></p>
	<p><?php _e('First & Last Name') ?><input type="checkbox" /></p>
  <p><?php _e('Email') ?><input type="checkbox" /></p>
	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options', 'oscimp_trdom' ) ?>" />
	<input type='button' id='ge_download' name='ge_download' value='Download CSV' />
	</p>
</form>

<!-- <?php echo '<a href="' . plugins_url( 'get_csv.php' , __FILE__ ) . '" >Download CSV</a> '; ?><?php _e(" <------- CLICK HERE" ); ?> -->
</div>
<script type="text/javascript">
var form = document.getElementById('ge_form');
form.onsubmit = function() {
    form.target = '_self';
};

document.getElementById('ge_download').onclick = function() {
    document.getElementById('ge_hidden').value = 'generate';
    form.target = '_self';
    form.submit();
}
</script>
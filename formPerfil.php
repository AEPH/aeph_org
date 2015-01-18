<?php
/*
Template Name: Actualizar Perfil
*/
 
global $userdata; 
get_currentuserinfo();

if(!empty($_POST['action'])){
 
	require_once(ABSPATH . 'wp-admin/includes/user.php');
	require_once(ABSPATH . WPINC . '/registration.php');
 
	check_admin_referer('update-profile_' . $user_ID);
 
	$errors = edit_user($user_ID);
 
	if ( is_wp_error( $errors ) ) {
		foreach( $errors->get_error_messages() as $message )
			$errmsg = "$message";
	}
 
	if($errmsg == '')
	{
		do_action('personal_options_update',$user_ID);
		$d_url = $_POST['dashboard_url'];
		wp_redirect( get_option("http://embajadas.eu/miembros/").'?page_id='.$post->ID.'&updated=true' );
	}
	else{
		$errmsg = '<div class="box-red">' . $errmsg . '</div>';
		$errcolor = 'style="background-color:#FFEBE8;border:1px solid #CC0000;"';
 
	}


get_currentuserinfo();


}
?>

<body class="page page-id-6 page-template-default">
<?php
    get_header();
?>
<div id=primary class=content-area>
<center>
<form name="profile" action="" method="post" enctype="multipart/form-data" class="form">
  <?php wp_nonce_field('update-profile_' . $user_ID) ?>
  <input type="hidden" name="from" value="profile" />
  <input type="hidden" name="action" value="update" />
  <input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />
  <input type="hidden" name="dashboard_url" value="<?php echo get_option("dashboard_url"); ?>" />
  <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
  
<h3><?php _e("Extra Fields", "aeph-es"); ?></h3>
 
<table class="form-table table">
   <tr>
      <th><label for="address"><?php _e("Address", "aeph-es"); ?></label></th>
      <td>
         <input    type="text" name="address" id="address" 
               value="<?php echo esc_attr( get_the_author_meta( 'address', $user_ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your address", "aeph-es"); ?></span>
      </td>
   </tr>
   <tr>
      <th><label for="city"><?php _e("City", "aeph-es"); ?></label></th>
      <td>
         <input type="text" name="city" id="city" 
               value="<?php echo esc_attr( get_the_author_meta( 'city', $user_ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your city", "aeph-es"); ?></span>
      </td>
   </tr>
   <tr>
      <th><label for="postal_code"><?php _e("Postal Code", "aeph-es"); ?></label></th>
      <td>
         <input type="text" name="postal_code" id="postal_code" 
               value="<?php echo esc_attr( get_the_author_meta( 'postal_code', $user_ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your postal code", "aeph-es"); ?></span>
      </td>
   </tr>
   <tr>
      <th><label for="country"><?php _e("Country", "aeph-es"); ?></label></th>
      <td>
         <input type="text" name="country" id="country" 
               value="<?php echo esc_attr( get_the_author_meta( 'country', $user_ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your country", "aeph-es"); ?></span>
      </td>
   </tr>
   <tr>
     <th><label for="nationality"><?php _e("Nationality", "aeph-es"); ?></label></th>
      <td>
         <input type="text" name="nationality" id="nationality" 
               value="<?php echo esc_attr( get_the_author_meta( 'nationality', $user_ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your nationality", "aeph-es"); ?></span>
      </td>
   </tr>
    <tr>
     <th><label for="telephone"><?php _e("Telephone", "aeph-es"); ?></label></th>
      <td>
         <input type="text" name="telephone" id="telephone" 
               value="<?php echo esc_attr( get_the_author_meta( 'telephone', $user_ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your telephone", "aeph-es"); ?></span>
      </td>
   </tr>
    <tr>
     <th><label for="company"><?php _e("Company", "aeph-es"); ?></label></th>
      <td>
         <input type="text" name="company" id="company" 
               value="<?php echo esc_attr( get_the_author_meta( 'company', $user_ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your company name", "aeph-es"); ?></span>
      </td>
   </tr>
    <tr>
     <th><label for="job"><?php _e("Job", "aeph-es"); ?></label></th>
      <td>
         <input type="text" name="job" id="job" 
               value="<?php echo esc_attr( get_the_author_meta( 'job', $user_ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your job in the company", "aeph-es"); ?></span>
      </td>
   </tr>
  <tr>
	  <td align="center" colspan="2"><input type="submit" value="Update" /></td>
	</tr>
</table>
  <input type="hidden" name="action" value="update" />
</form>
</center>
</div>
<?php get_footer();?>
</body>
 
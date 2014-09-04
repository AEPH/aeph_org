<?php

/*---------------------------------------------------*/
/* Agregar campos nuevos a la pagina de configuracion de perfil
/*---------------------------------------------------*/
add_action( 'show_user_profile', 'extended_user_profil_fields' );
add_action( 'edit_user_profile', 'extended_user_profil_fields' );
 
function extended_user_profil_fields( $user ) { ?>

<h3><?php _e("Adictional Fields", "blank"); ?></h3>
 
<table class="form-table">
   <tr>
      <th><label for="address"><?php _e("Address"); ?></label></th>
      <td>
         <input    type="text" name="address" id="address" 
               value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your address"); ?></span>
      </td>
   </tr>
   <tr>
      <th><label for="city"><?php _e("City"); ?></label></th>
      <td>
         <input type="text" name="city" id="city" 
               value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your city"); ?></span>
      </td>
   </tr>
   <tr>
      <th><label for="postal_code"><?php _e("Postal Code"); ?></label></th>
      <td>
         <input type="text" name="postal_code" id="postal_code" 
               value="<?php echo esc_attr( get_the_author_meta( 'postal_code', $user->ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your postal code"); ?></span>
      </td>
   </tr>
   <tr>
      <th><label for="country"><?php _e("Country"); ?></label></th>
      <td>
         <input type="text" name="country" id="country" 
               value="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your country"); ?></span>
      </td>
   </tr>
   <tr>
     <th><label for="nationality"><?php _e("Nationality"); ?></label></th>
      <td>
         <input type="text" name="nationality" id="nationality" 
               value="<?php echo esc_attr( get_the_author_meta( 'nationality', $user->ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your nationality"); ?></span>
      </td>
   </tr>
    <tr>
     <th><label for="telephone"><?php _e("Telephone"); ?></label></th>
      <td>
         <input type="text" name="telephone" id="telephone" 
               value="<?php echo esc_attr( get_the_author_meta( 'telephone', $user->ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your telephone"); ?></span>
      </td>
   </tr>
    <tr>
     <th><label for="company"><?php _e("Company"); ?></label></th>
      <td>
         <input type="text" name="company" id="company" 
               value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your company name"); ?></span>
      </td>
   </tr>
    <tr>
     <th><label for="job"><?php _e("Job"); ?></label></th>
      <td>
         <input type="text" name="job" id="job" 
               value="<?php echo esc_attr( get_the_author_meta( 'job', $user->ID ) ); ?>" 
               class="regular-text" /><br />
         <span class="description"><?php _e("Insert your job in the company"); ?></span>
      </td>
   </tr>
</table>

<?php }
 
add_action( 'personal_options_update', 'save_extended_user_profil_fields' );
add_action( 'edit_user_profile_update', 'save_extended_user_profil_fields' );

//Función que guarda los cambios 
function save_extended_user_profil_fields( $user_id ) {
 
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
 
update_user_meta( $user_id, 'address', $_POST['address'] );
update_user_meta( $user_id, 'city', $_POST['city'] );
update_user_meta( $user_id, 'postal_code', $_POST['postal_code'] );
update_user_meta( $user_id, 'country', $_POST['country'] );
update_user_meta( $user_id, 'nationality', $_POST['nationality'] );
update_user_meta( $user_id, 'telephone', $_POST['telephone'] );
update_user_meta( $user_id, 'company', $_POST['company'] );
update_user_meta( $user_id, 'job', $_POST['job'] );
}
?>
<?php
/*
Plugin Name: AEPH Plugin
Plugin URI: 
Description: Este plugin contiene las funciones necesarias para la comprobacion periodica de la membresia de usuarios,
asi como un shortcode para indicarle al usuario el tiempo restante de membresía.
Version: 0.4
Author: Rodrigo Serrano Gonzalez
Colaborador 1: Daniel Ramos
Colaborador 2:
Author URI: rodrigoserrano.es
License: GPL2
*/

if ( !class_exists('AephPlugin') ){

	class AephPlugin
	{
		var $plugin_url;
		var $db_option = 'Aeph_Options';
		const $EMAILporDEFECTO='r.serrano@profesionalesholanda.org';
		
		//Constructor
		function AephPlugin(){
			$this->plugin_url=trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
			
			// add shortcode handler
			add_shortcode('mostrarCaducidad', array(&$this, 'aeph_mostrarCaducidad'));
			add_shortcode('mostrarPerfil',array(&$this,'doMostrarPerfil'));
			
			// add options Page
			add_action('admin_menu', array(&$this, 'admin_menu'));
			
			//Añadir la accion cuando se pague correctamente la renovacion, realizar la funcion aeph_renovarMembresia()
			//add_action('admin_menu', array(&$this, 'admin_menu'));

		}
		
		function install(){
		
			// set default options
			$this->get_options();
		}
		
		function doMostrarPerfil(){
		
			do_action('edit_user_profile');
		}
		
		// hook the options page
		function admin_menu(){
			add_options_page('AEPH Options', 'AEPH Plugin',1, basename(__FILE__), array(&$this, 'handle_options'));
		}
		
		//Renueva la membresia del usuario actual
		function aeph_renovarMembresia(){
			global $current_user;
			get_currentuserinfo();
			
			$expiracion=get_the_author_meta( 'exp_date', $current_user->ID );
			$nuevaExpiracion = strtotime('+1 years', $expiracion);
			
			aeph_set_member_role($current_user->id,'Miembro');			
			update_user_meta( $current_user->id, "exp_date", $nuevaExpiracion);
		}
		
		//Renueva la membresia de un usuario dado por ID
		function aeph_renovarMembresiaConId($id_usuario){
			
			$expiracion=(int)get_the_author_meta( 'exp_date', $id_usuario );
			$nuevaExpiracion = strtotime('+1 years', $expiracion);
			
			$this->aeph_set_member_role($id_usuario,'Miembro');			
			update_user_meta( $id_usuario, "exp_date",$nuevaExpiracion);
			echo '<div class="updated fade"><p>'.'ID: '.$id_usuario.'Vieja Fecha: '.$expiracion.' Nueva Fecha:'.$nuevaExpiracion.'</p></div>';
		}
		
		
		// handle plugin options
		function get_options()
		{
			// default values
			$options = array
			(

				'emailLog' => $EMAILPORDEFECTO,
				'mensaje30' => '',
				'mensaje15' => '',
				'mensaje7' => '',
				'mensaje0' => ''
			);
			
			// get saved options
			$saved = get_option($this->db_option);
			
			// assign them
			if (!empty($saved)){
				foreach ($saved as $key => $option)
				$options[$key] = $option;
			}
			
			// update the options if necessary
			if ($saved != $options)update_option($this->db_option, $options);
			
			//return the options
			return $options;
		}
		
		// handle the options page
		function handle_options()
		{
			$options = $this->get_options();
	
			if ( isset($_POST['renovar'])){
				//check security
				check_admin_referer('aeph-nonce');
				$id_del_usuario=filter_var($_POST['IdUsuario'],FILTER_SANITIZE_NUMBER_INT);
				$this->aeph_renovarMembresiaConId($id_del_usuario);
				echo '<div class="updated fade"><p>Membresia renovada.</p></div>';
			}

			if ( isset($_POST['submitted'])){
				//check security
				check_admin_referer('aeph-nonce');
				$options = array();
				$options['mensaje30']=filter_var($_POST['mensaje30'],FILTER_SANITIZE_STRING);
				$options['mensaje15']=filter_var($_POST['mensaje15'],FILTER_SANITIZE_STRING);
				$options['mensaje7']=filter_var($_POST['mensaje7'],FILTER_SANITIZE_STRING);
				$options['mensaje0']=filter_var($_POST['mensaje0'],FILTER_SANITIZE_STRING);
				$options['emailLog']=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
				update_option($this->db_option, $options);
				echo '<div class="updated fade"><p>Plugin settings saved.</p></div>';
			}

			$mensaje30 = $options['mensaje30'];
			$mensaje15 = $options['mensaje15'];
			$mensaje7 = $options['mensaje7'];
			$mensaje0 = $options['mensaje0'];
			$email = $options['emailLog'];
			
			// URL for form submit, equals our current page
			$action_url = $_SERVER['REQUEST_URI'];
			include('aeph_options_page.php');
		}

		
		//Obtiene un usuario del sistema
		function get_member($userID){
			
			//Obtengo el usuario deseado
			$user = get_userdata($userID );
			
			//Compruebo si existe
			if($user){

				echo _e("User is not valid", "aeph-es");
				return NULL;
			}
			else {return $user;}

		}

		//Averigua si un usuario es miembro o no
		function aeph_is_active_member($userID){

			if($user=get_member($userID)){
			
				//Compruebo cada uno de los roles
				foreach($rol as $user->roles){
					
					if($rol == 'Miembro'){return true;}
				
				}
			}
			return false;
		}

		//Establece el rol a un usuario
		function aeph_set_member_role($userID, $rol){
			
			if($user=get_member($userID)){
			
				//Obtengo el rol
				$role = get_role( $rol );
				
				if($role){
				
					echo _e("Rol is not valid", "aeph-es");
					return false;
				}
				else{
					$user->set_role($role);
					return true;
				}
			}
			return false;
		}

		//Envia un correo electronico recordando que tiene que actualizar su membresía a un usuario dado
		function aeph_send_membership_reminder($userID,$opcion){

			$configuracion=get_options();
			
			if($user=get_member($userID)){
				
				switch($opcion){
					case 0: mail ( $user->user_email , "Aviso Membresia AEPH", $configuracion['mensaje30']);
					break;
					case 1: mail ( $user->user_email , "Aviso Membresia AEPH", $configuracion['mensaje15']);
					break;
					case 2: mail ( $user->user_email , "Aviso Membresia AEPH", $configuracion['mensaje7']);
					break;
					case 3: mail ( $user->user_email , "Aviso Membresia AEPH", $configuracion['mensaje0']);
					break;					
				}
				return true;
			}
			return false;
		}

		function aeph_set_log($subject, $event, $status){

			global $wpdb;
			
			if(!isset($wpdb)){
				require_once('../../../wp-config.php');
				require_once('../../../wp-load.php');
				require_once('../../../wp-includes/wp-db.php');
			}

			$wpdb->insert( 
					'aeph_log', 
					array( 
						'subject' => $subject, 
						'event' => $event,
						'status' => $status 
					)
				);


		}
		
		//Esta funcion se encarga de guardar el historial de bajas y altas de miembros
		function aeph_set_user_history_log($id, $login, $fecha, $activo){

			global $wpdb;
			
			if(!isset($wpdb)){
				require_once('../../../wp-config.php');
				require_once('../../../wp-load.php');
				require_once('../../../wp-includes/wp-db.php');
			}

			$wpdb->insert( 
					'aeph_fechas_expiracion', 
					array( 
						'id_usuario' => $id, 
						'user_login' => $login,
						'fecha_exp' => $fecha,
						'activo' => $activo
					)
				);
		}
		


		//Mostrará la fecha de caducidad de la membresía del usuario logeado en el sistema en su area privada
		function aeph_mostrarCaducidad(){
			
			$ahora=time();

			global $current_user;
			get_currentuserinfo();
			
			$expiracion=get_the_author_meta( 'exp_date', $current_user->ID );


			if($ahora>$expiracion){
				return "<b>La fecha de expiración era:</b><font style='color:red;margin:0px'> ".date("d/m/Y",$expiracion)." </font>.<br>
				<b><font style='color:red;margin:0px'>Su membresía ha concluido</font></b><br>";							
			}

			else{
			
				$diferencia=$ahora-$expiracion;
				$diferencia=$diferencia*(-1);
				$diferencia=$diferencia/86400;
				if($diferencia<15){
					return "<b>La fecha de expiración es:</b><font style='color:orange;margin:0px'> ".date("d/m/Y",$expiracion)." </font>.<br>
					<b><font style='color:orange;margin:0px'>Le quedan ".$diferencia." días de membresía</font></b><br>";
				}
				else{
					return "<b>La fecha de expiración es:</b><font style='color:green;margin:0px'> ".date("d/m/Y",$expiracion)." </font>.<br>
					<b><font style='margin:0px'>Le quedan ".$diferencia." días de membresía</font></b><br>";
				}
			}
		}
		
		

	}
}
else{
	exit ("Class AephPlugin already declared!");
}

$aephplugin = new AephPlugin();
if (isset($aephplugin)){
	register_activation_hook( __FILE__, array(&$aephplugin,'install') );
}
?>
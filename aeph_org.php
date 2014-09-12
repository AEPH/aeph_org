<?php
/*
Plugin Name: AEPH Plugin
Plugin URI: 
Description: Este plugin tiene distintas funcionalidades para el sitio de la asociacion en wordpress
Version: 0.2
Author: Rodrigo Serrano Gonzalez
Colaborador 1: Daniel Ramos
Colaborador 2:
Author URI: rodrigoserrano.es
License: GPL2
*/



if ( !class_exists('AephPlugin') ) :

	class AephPlugin
	{
		var $plugin_url;
		
		//Constructor
		function AephPlugin(){
			$this->plugin_url=trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
			
			// add shortcode handler
			add_shortcode('mostrarCaducidad', array(&$this, 'aeph_mostrarCaducidad'));

		}
		
		function install(){
		
		}
		
		//Obtiene un usuario del sistema
		function get_member($userID){
			
			//Obtengo el usuario deseado
			$user = get_userdata($userID );
			
			//Compruebo si existe
			if(!isset($user)){

				echo _e("User is not valid");
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
				
				if(!isset($role)){
				
					echo _e("Rol is not valid");
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
		function aeph_send_membership_reminder($userID){

			if($user=get_member($userID)){
				
				mail ( $user->user_email , "Aviso Membresía AEPH", file_get_contents(http://embajadas.eu/recordatorio_membresia/) );
				
				return true;
			}
			return false;
		}

		function aeph_set_log($subject, $event, $status){




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
				$diferencia=$diferencia/86400;
				if($diferencia<15){
					return "<b>La fecha de expiración es:</b><font style='color:orange;margin:0px'> ".date("d/m/Y",$expiracion)." </font>.<br>
					<b><font style='color:orange;margin:0px'>Le quedan ".$diferencia." de membresía</font></b><br>";
				}
				else{
					return "<b>La fecha de expiración es:</b><font style='margin:0px'> ".date("d/m/Y",$expiracion)." </font>.<br>
					<b><font style='margin:0px'>Le quedan ".$diferencia." de membresía</font></b><br>";
				}
			}
		}

	}

else :
	exit ("Class AephPlugin already declared!");
endif;
?>
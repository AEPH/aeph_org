<?php

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

function aeph_is_active_member($userID){

	if($user=get_member($userID)){
	
		//Compruebo cada uno de los roles
		foreach($rol as $user->roles){
			
			if($rol == 'Miembro'){return true;}
		
		}
	}
	return false;
}

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

function aeph_send_membership_reminder($userID){

	if($user=get_member($userID)){
		
		mail ( $user->user_email , "Aviso Membresía AEPH", file_get_contents(http://embajadas.eu/recordatorio_membresia/) );
		
		return true;
	}
	return false;
}



?>
<?php

aeph_is_active_member($userID){

	//Obtengo el usuario deseado
	$user = get_userdata($userID );
	
	//Compruebo si existe
	if(!isset($user)){

		echo "El usuario no es válido";
		return false;
	}
	
	//Compruebo cada uno de los roles
	foreach($rol as $user->roles){
		
		if($rol == 'Miembro'){return true;}
	
	}
	
	return false;
}

aeph_set_member_role($userID, $rol){
	
	//Obtengo el usuario deseado
	$user = get_userdata($userID );
	
	//Compruebo si existe
	if(!isset($user)){
		echo "El usuario no es válido";
		return false;
	}
	
	//Obtengo el rol
	$role = get_role( $rol );
	
	if(!isset($role)){
	
		echo "El rol no es válido";
		return false;
	}
	else{
		$user->set_role($role);
		return true;
	}

}

aeph_send_membership_reminder(){

	//Obtengo el usuario deseado
	$user = get_userdata($userID );
	
	//Compruebo si existe
	if(!isset($user)){

		echo "El usuario no es válido";
		return false;
	}
	
	mail ( $user->user_email , "Aviso Membresía AEPH", "Hola, queriamos informarle de que su membresía en la asociacion española de profesionales en holanda
	acabará pronto. Si lo desea puede pasarse por nuestra web http://profesionalesholanda.org para renovar su membresía. Un cordial saludo. Muchas Gracias.");

}



?>
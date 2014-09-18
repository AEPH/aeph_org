<?php
require_once("../wp-load.php");

function aeph_controlPeriodico(){
	$handler=new AephPlugin();
	
	$query_args = array();
	$query_args['fields'] ='all_with_meta';
	$query_args['role'] = 'Miembro';

	$todos=get_users($query_args);
	
	foreach ( $todos as $uno ){

		$ahora=time();
		if($ahora>$uno->exp_date){
			$handler->aeph_set_member_role($uno->ID,'Suscriber');
			$handler->aeph_send_membership_reminder($uno->ID,3);
		}

		else{
			
			$diferencia=$ahora-$uno->exp_date;
			$diferencia=$diferencia/86400;
			if($diferencia==30){
				$handler->aeph_send_membership_reminder($uno->ID,0);
			}
			if($diferencia==15){
				$handler->aeph_send_membership_reminder($uno->ID,1);
			}
			if($diferencia==7){
				$handler->aeph_send_membership_reminder($uno->ID,2);
			}

		}
	}

}
?>
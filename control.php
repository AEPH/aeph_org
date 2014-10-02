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
			$handler->aeph_set_member_role($uno->ID,'subscriber');
			if($handler->aeph_send_membership_reminder($uno->ID,3)){
				$handler->aeph_set_log("Membresia", "Membership ended", "OK");
			}
			else{$handler->aeph_set_log("Membresia", "Membership ended", "FAIL");}
			$handler->aeph_set_user_history_log($uno->ID, $uno->user_login, time(), "NO");
		}

		else{
			
			$diferencia=$ahora-$uno->exp_date;
			$diferencia=$diferencia/86400;
			if($diferencia==30){
				if($handler->aeph_send_membership_reminder($uno->ID,0)){
					$handler->aeph_set_log("Membresia", "Reminder 30 days", "OK");
				}
				else{$handler->aeph_set_log("Membresia", "Reminder 30 days", "FAIL");}
			}
			if($diferencia==15){
				if($handler->aeph_send_membership_reminder($uno->ID,1)){
					$handler->aeph_set_log("Membresia", "Reminder 15 days", "OK");
				}
				else{$handler->aeph_set_log("Membresia", "Reminder 15 days", "FAIL");}
			}
			if($diferencia==7){
				if($handler->aeph_send_membership_reminder($uno->ID,2)){
					$handler->aeph_set_log("Membresia", "Reminder 7 days", "OK");
				}
				else{$handler->aeph_set_log("Membresia", "Reminder 7 days", "FAIL");}
			}

		}
	}

}
?>
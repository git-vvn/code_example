<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////пример реализации функции вывода формы для определенного пользователя (запрос в базу ВордПресс для определения прав)
function request_form($req_number) {
	global $user_id, $user_status;

	$user_id = get_current_user_id();
	$userdata_array = $wpdb->get_row( 
		"
			SELECT * FROM ".$wpdb->prefix."table1_name 
			WHERE (user_id = '$user_id') 
		",
		ARRAY_A
		);
	
	$user_status = $userdata_array['user_status'];	
	$user_type = $userdata_array['user_type'];	
	
	if($user_type == 'allowed'){
		if ($user_status == 3){
		echo '
		<div align="left" id="form_block" class="form_block" >
			<form action="' . $_SERVER['REQUEST_URI'] . '" method="POST" name="form_request">
				<input class="form_input" type="text" id="req_vin" name="req_vin" maxlength="17" value="" placeholder="Введите запрос" required /> <span class="wppb-description-delimiter">&nbsp</span>
				<input type="submit" class="form_button" name="submit_vin" value="Выполнить запрос"/> 
			</form>
		</div>
			
		';
		} 

	}
}
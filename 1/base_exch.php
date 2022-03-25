<?php
//////////////////////////////////////////////////////
/////Взаимодействие с базой - ПДО, минуя ВордПресс
//////////////////////////////////////////////////////
require_once("cfg.php");

try {
  $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->exec("set names utf8");
}
catch(PDOException $e) {
    echo $e->getMessage();
}

$req_user_id = 191;
$user_data_req = $db->prepare('SELECT user_login, user_email from wp_users WHERE ID = ?');
$user_data_req->bindParam(1, $req_user_id, PDO::PARAM_INT);
$user_data_req->execute();
	
$user_data_arr = $user_data_req->fetch(PDO::FETCH_ASSOC);
if(!empty($user_data_arr)){
	$username = $user_data_arr['user_login'];
	$user_email = $user_data_arr['user_email'];
	}
//////////////////////////////////////////////
//Блок обработки данных пользователя, например:
	$user_status 		= 3;
	$expiration_time 	= time()+2592000;
//////////////////////////////////////////////
$usr_update = $db->prepare(
		'
		UPDATE wp_atf_users SET user_status = :user_status, activation_datetime = CURRENT_TIMESTAMP, expiration_time = :expiration_time 
		WHERE user_id = :req_user_id
		'
		); // запрос в базу пользователей

	$usr_update->bindValue(':user_status', $user_status);
	$usr_update->bindValue(':expiration_time', $expiration_time);
	$usr_update->bindValue(':req_user_id', $req_user_id);
	$usr_update->execute();
?>
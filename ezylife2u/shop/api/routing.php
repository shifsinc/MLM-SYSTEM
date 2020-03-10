<?php
require_once("../connection/PDO_db_function.php");
$db = new DB_Functions();


if(isset($_REQUEST['login_key'])){
	
	if(strlen($_REQUEST['login_key'])>=16){

		$uid = $_REQUEST['login_key'];
		$uid = str_replace('_','+',$uid);
			
		$key = 'mv_enc_uid';
		$enc_id = $uid;
		$data = base64_decode($enc_id);
		$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

		$uid = rtrim(
			mcrypt_decrypt(
				MCRYPT_RIJNDAEL_128,
				hash('sha256', $key, true),
				substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
				MCRYPT_MODE_CBC,
				$iv
			),
				"\0"
		);

		if(is_numeric($uid)){

			$_SESSION['id']=$uid;
			$type = $db->where('mv_user_type','mv_user','mv_user_id',$uid);
			$user_type = $type[0]['mv_user_type'];
			
			if($user_type == 1){
			   header("Location: ../index.php"); 
			}else if($user_type == 2){
			   header("Location: ../userindex.php"); 
			}else if($user_type == 3){
			   header("Location: ../seller_item.php"); 
			}else if($user_type == 4){
			   header("Location: ../merindex.php"); 
			}
			
		}
	}
}
?>
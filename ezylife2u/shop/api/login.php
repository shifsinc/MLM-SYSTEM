<?php
require_once("../connection/PDO_db_function.php");
$db = new DB_Functions();


if(isset($_REQUEST['Uname'])){
	$username = $_REQUEST['Uname'];
	$username = addslashes($username);
}
else{
	$username = "";
}
if(isset($_REQUEST['Pword'])){
	$password = $_REQUEST['Pword'];
}else{
	$password = "";
}
if(!empty($username)&&!empty($password)){
	$key = 'mumuls1314';
	$col = "*";
	$tablename = "mv_user";
	$opt = "mv_user_name = ? AND mv_user_status = ? AND (mv_user_type = ? OR mv_user_type = ?)";
	$arr = array($username,1,1,2);
	$result = $db->advwhere($col,$tablename,$opt,$arr);
	if (!empty($result)) {
		foreach($result as $row)
		{
			$encpass = $row['mv_user_pword'];
			$data = base64_decode($encpass);
			$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

			$decpass = rtrim(
				mcrypt_decrypt(
					MCRYPT_RIJNDAEL_128,
					hash('sha256', $key, true),
					substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
					MCRYPT_MODE_CBC,
					$iv
				),
					"\0"
			);
			if($password == $decpass)
			{
				$log = true;
				$uid = $row['mv_user_id'];
				$key = 'mv_enc_uid';
				
				$iv = mcrypt_create_iv(
					mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
					MCRYPT_DEV_URANDOM
				);
				$uid = base64_encode(
					$iv .
					mcrypt_encrypt(
						MCRYPT_RIJNDAEL_128,
						hash('sha256', $key, true),
						$uid,
						MCRYPT_MODE_CBC,
						$iv
					)
				);
				
				$uid = str_replace('+','_',$uid);
				
			}
			else
			{	$log = false;
				$uid = "";
			}
		}

	} else {
	   $log = false;
	   $uid = "";
	}
}else{
	$log = false;
	$uid = "";
}
$arr = array($log,$uid,$username,$password);
echo json_encode($arr);
?>
<?php
include_once ('PDO_conn.php');



date_default_timezone_set('Singapore');
$date = date('Y-m-d H:i:s');
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}
//token
function getToken(){
  $token = sha1(mt_rand());
  if(!isset($_SESSION['tokens'])){
    $_SESSION['tokens'] = array($token => 1);
  }
  else{
    $_SESSION['tokens'][$token] = 1;
  }
  return $token;
}
function isTokenValid($token){
  if(!empty($_SESSION['tokens'][$token])){
    unset($_SESSION['tokens'][$token]);
    return true;
  }
  return false;
}

$token = getToken();

class DB_FUNCTIONS{
	protected $conn;
	function where($col,$tablename,$data,$opt){
		global $conn;
		$stmt = $conn->prepare("SELECT $col FROM $tablename WHERE $data= :opt");
		$stmt->bindValue(":opt", $opt, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	function advwhere($col,$tablename,$opt,$arr){
		global $conn;
		$stmt = $conn->prepare("SELECT $col FROM $tablename WHERE $opt");
		$stmt->execute($arr);
		$result = $stmt->fetchAll();
		return $result;
	}
	function get($col,$tablename,$opt){
		global $conn;
		$stmt = $conn->prepare("SELECT $col FROM $tablename WHERE :opt");
		$stmt->bindValue(":opt", $opt, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	function update($tablename,$data,$array){
		global $conn;
		$stmt = $conn->prepare("UPDATE `$tablename` SET $data");
		$array = array_map('trim', $array);
		$result = $stmt->execute($array);
		return $result;
	}
	function insert1($tablename,$colname,$array){
		global $conn;
		$datacount = count($colname);
		if($datacount != 0 && is_array($colname)){
    		$datamark = array();
    		for($i=0;$i<$datacount;$i++){
    		    $datamark[] = '?';
    		}
    		$colname = implode(',',$colname);
    		$datamark = implode(',',$datamark);
    		$stmt = $conn->prepare("INSERT INTO $tablename ($colname) VALUES ($datamark)");
    		$array = array_map('trim', $array);
    		$result = $stmt->execute($array);
    		return $result;
		}else{
		    exit('Data Parse Error');   
		}
	}
	
	function insert2($tablename2,$colname2,$array2){
		global $conn;
		$datacount = count($colname2);
		if($datacount != 0 && is_array($colname2)){
    		$datamark = array();
    		for($i=0;$i<$datacount;$i++){
    		    $datamark[] = '?';
    		}
    		$colname2 = implode(',',$colname2);
    		$datamark = implode(',',$datamark);
    		$stmt = $conn->prepare("INSERT INTO $tablename2 ($colname2) VALUES ($datamark)");
    		$array2 = array_map('trim', $array2);
    		$result = $stmt->execute($array2);
    		return $result;
		}else{
		    exit('Data Parse Error');   
		}
	}
		function insert3($tablename3,$colname3,$array3){
		global $conn;
		$datacount = count($colname3);
		if($datacount != 0 && is_array($colname3)){
    		$datamark = array();
    		for($i=0;$i<$datacount;$i++){
    		    $datamark[] = '?';
    		}
    		$colname3 = implode(',',$colname3);
    		$datamark = implode(',',$datamark);
    		$stmt = $conn->prepare("INSERT INTO $tablename3 ($colname3) VALUES ($datamark)");
    		$array3 = array_map('trim', $array3);
    		$result = $stmt->execute($array3);
    		return $result;
		}else{
		    exit('Data Parse Error');   
		}
	}
	function del($tablename,$data,$array){
		global $conn;
		$stmt = $conn->prepare("DELETE FROM `$tablename` WHERE $data = $array");
		$result = $stmt->execute();
		return $result;
	}
	
		function advdel($tablename,$opt,$arr){
		global $conn;
		$stmt = $conn->prepare("DELETE FROM `$tablename` WHERE $opt");
		$stmt->execute($arr);
		$result = $stmt->fetchAll();
		return $result;
	}
	function getuser($col,$tablename){
		global $conn;	
		$stmt = $conn->prepare("SELECT $col FROM $tablename");
		//$stmt->bindValue(":opt", $opt, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	
	function select($col,$tablename,$opt){
		global $conn;
		$stmt = $conn->prepare("SELECT $col FROM $tablename ORDER BY $opt DESC LIMIT 1");
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}

}
?>
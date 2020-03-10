<?php
    require_once('connection/PDO_db_function.php');
    $db = new DB_FUNCTIONS();
    require_once('inc/level_controller.php');
    
    function createLog($type,$table,$data = false, $arr = false){
        
        $cont_flag = true;
        
        switch ($table){
            
            case 'user':
                $col = "max(mv_user_id) as maxid";
                $tb = "mv_user";
                $getcol = "mv_user_id";
                break;  
            case 'wallet':
                $col = "max(mv_wallet_id) as maxid";
                $tb = "mv_wallet";
                $getcol = "mv_wallet_id";
                break;
            case 'transaction':
                $col = "max(mv_transaction_id) as maxid";
                $tb = "mv_transaction";
                $getcol = "mv_transaction_id";
                break;
            default:
                $cont_flag = false;
            
        }
        
        if($cont_flag){
            if($type == 1){
                //$get_max_id = $db->get($col,$tb,1);
                //$table_id = $get_max_id[0]['maxid'];
                print_r($db);
            }else if($type == 2){
                $col = "*";
                if($data&&$arr){
                    $result = $db->advwhere($col,$tb,$data,$arr);
                    if($result){
                        $table_id = $result[0][$getcol];
                    }else{
                        $table_id = 0;
                    }
                }
            }else if($type == 3){
                
            }else{
                
            }
        }
        if(isset($table_id)){
            $uid = $_SESSION['id'];
            $tb = 'mv_log';
            $data = array('mv_log_type','mv_log_table','mv_log_table_id','mv_log_datetime','mv_user_id');
            $arr = array($type,$table,$table_id,$date,$uid);
            $result = $db->insert1($tb,$data,$arr);
        }
    }
?>
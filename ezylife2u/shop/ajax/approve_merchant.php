<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
    //echo 'ID:'.$id;
    $user1 = $db->where('*','mv_user','mv_user_id',$id);
    $user1= $user1[0]
?>
<form role="form" id="form" action="soap_func.php?type=pendingmerchant&tb=user" method="post" enctype="multipart/form-data">
							 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                <div class="modal-header">
                    
                    <div class="m-b-md">
                        <i class="fa fa-shield fa-4x"></i>
                     
                    </div>
                </div>
                <div class="modal-body text-center">
                    
                    <h2><strong>Are Your Sure To Approve?</strong></h2>
                    
                    <button type="button" class="btn btn-white btn-lg-dim" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary  btn-lg-dim" name="btnmerchant" value="<?php echo $user1["mv_user_id"]; ?>">Yes! Approve!</button>
                </div>
                <div class="modal-footer">
                    
                </div>
	</form>
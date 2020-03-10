<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
    //echo 'ID:'.$id;
    $user = $db->where('*','mv_item','mv_item_id',$id);
    $user = $user[0]
?>
 <form role="form" id="form" action="soap_func.php?type=deleteitem&tb=user" method="post" enctype="multipart/form-data">
								<input type="hidden" name="token" value="<?php echo $token; ?>" />
                <div class="modal-header">
                    
                    <div class="m-b-md">
                        <i class="fa fa-shield fa-4x"></i>
                     
                    </div>
                </div>
                <div class="modal-body text-center">
                    
                    <h2><strong>Are Your Sure To Delete?</strong></h2>
                    
                    <button type="button" class="btn btn-white btn-lg-dim" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary  btn-lg-dim" name="btndeleteitem" value="<?php echo $user["mv_item_id"]; ?>">Yes! Delete!</button>
                </div>
                <div class="modal-footer">
                    
                </div>
	</form>
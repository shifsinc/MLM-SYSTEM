<?php
    include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $order = $db->where('*','mv_order','mv_order_id',$id);
    $order = $order[0];
    
    $status = $order["mv_order_status"];
    //echo $status;
    if($status == 0){
        $message = "This order is pending. Once you cancel your order, the order will not be recoverable. Are you sure to cancel this order?";
        $button = "Yes! Cancel!";
    }
    
?>
 <form role="form" id="form" action="soap_func.php?type=usercancelorder&tb=user" method="post" enctype="multipart/form-data">
							 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <i class="fa fa-laptop modal-icon"></i>
    <h4 class="modal-title">Cancel Order</h4>
    
</div>
<div class="modal-body text-center">
   <h2><strong><?php echo $message; ?></h2>
            
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary  btn-lg-dim" name="userbtnCancel" value="<?php echo $id ?>"><?php echo $button; ?></button>
</div>
</form>
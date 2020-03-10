<?php
	include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
    //echo 'ID:'.$id;
    $request = $db->where('*','mv_request','mv_request_id',$id);
    $request = $request[0]
?>
<form role="form" id="form" action="soap_func.php?type=pendingrequest&tb=user" method="post" enctype="multipart/form-data">
	<input type="hidden" name="token" value="<?php echo $token; ?>" />
	<div class="modal-header">
		
		<div class="lightBoxGallery">
			<?php if($request["mv_request_img"]!="") {?>
				<a href="img/receipt/<?php echo $request["mv_request_img"]; ?>"  data-gallery=""><img class=" w-50" src="img/receipt/<?php echo $request["mv_request_img"]; ?>"></a>
				<?php } 
				else{
				?>
				<td>No Image</td>
				<?php
				}
			?>
		</div>
	</div>
	<div class="modal-body text-center">
		
		<h2><strong>Are Your Sure To Approve?</strong></h2>
		
		<button type="button" class="btn btn-white btn-lg-dim" data-dismiss="modal">Cancel</button>
		<button type="submit" class="btn btn-primary  btn-lg-dim" name="btnrequest" value="<?php echo $request["mv_request_id"]; ?>">Yes! Approve!</button>
	</div>
	<div class="modal-footer">
		
	</div>
</form>
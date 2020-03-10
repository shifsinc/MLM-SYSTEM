<?php
	include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	

    
?>
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Forget Password</h4>
	
</div>


<div class="modal-body">
	
	<div class="row">
		<div class="col-lg-12 ">
			
			<form role="form" id="form_edit" action="api/register.php?type=forgetpassword&tb=user&success=1" method="post" enctype="multipart/form-data">
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<div class="hr-line-dashed"></div>
			
				<div class="form-group"><label>Username</label> <input type="text" placeholder="Enter username" class="form-control" name="uname"  ></div>
				<div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name="email" ></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-white" name="btnforgetuser" >Submit</button>
					
					
				</div>
			</form>
		</div>
		
	</div>
</div>
<script src="js/plugins/iCheck/icheck.min.js"></script>
        <script>
           
            
            
            
           
            
           
		
</script>


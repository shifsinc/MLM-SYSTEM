<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
    //echo 'ID:'.$id;
    $user1 = $db->where('*','mv_user','mv_user_id',$id);
    $user1= $user1[0];
    
   
?>
<form role="form" id="form" action="soap_func.php?type=pendingmerchantbill&tb=user" method="post" enctype="multipart/form-data">
 <input type="hidden" name="token" value="<?php echo $token; ?>" />
    <div class="modal-header">
    
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    		
    		<h4 class="modal-title">Merchant Sale</h4>
    	</div>
    	<div class="modal-body">
    		
    		<div class="form-group"><label>Amount</label> <input type="number" placeholder="Enter amount" class="form-control" name="amt" id="amt" step=".01"></div>
    		
    		<div class="form-group"><label>User Code</label> <input type="text" placeholder="Enter user code" class="form-control" name="usercode" id="chkRefname" value="<?php echo $user1['mv_user_code']; ?>" readonly></div>
    		
    	    
    	   
    	   
    	 
    		
    	</div>
    	<div class="modal-footer">
    		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" href="#confirm" id="get_amt" onclick="pass_amt()">Approve</button>
    	</div>
    	
    	
    	
        <div class="modal inmodal" id="confirm" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content animated fadeIn">
                        <div class="modal-header">

                        </div>
                        <div class="modal-body text-center">
                            
                        <table class="table">
		        	    
        			    	<thead>
        			    	</thead>
        			    	
        			    	<tbody>
        			    	    
        			    	    
            					<tr>
                					<td>Merchant Name</td>
                					<td><?php echo $user1["mv_user_fullname"];  ?></td>
                				</tr>

        						<tr>
        							<td>Amount</td>
        							<td><p id="show_amt"></p></td>
        						</tr>
    						</tbody>
    						
    					</table>
                            

                            <h4><strong>Please confirm your bill amount and merchant name.</strong></h4>
                            
                        	
                        </div>
                        <div class="modal-footer">
                    		<button type="button" class="btn btn-white" data-dismiss="modal">No</button>
                    		<button type="submit" class="btn btn-primary" name="btnmerchant" value="<?php echo $user1["mv_user_id"]; ?>"><strong>Yes! Confirm</strong></button>
                        </div>

				</div>
			</div>
		</div>
    	
    	
    	
	</form>

<script>
    

   function pass_amt(){
      $("#show_amt").text($('#amt').val());
    };

</script>
	
	
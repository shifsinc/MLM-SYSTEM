<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
    //echo 'ID:'.$id;
    $user1 = $db->where('*','mv_user','mv_user_id',$id);
    $user1= $user1[0];
    
    $wallet1 = $db->where('*','mv_wallet','mv_user_id',$id);
    $wallet1= $wallet1[0];
    
      $bankamt=$wallet1["mv_wallet_pending_amt"]*0.98;
?>
<form role="form" id="form1" action="soap_func.php?type=pendingsellersale&tb=user" method="post" enctype="multipart/form-data">
							 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                <div class="modal-header">
                    
                  	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Wholesaler Sale</h4>
								</div>
								<div class="modal-body">
									
									<div class="form-group"><label>Bank Slip (Optional)</label> 
									<div class="custom-file">
										<input id="logo" id="myfile" type="file" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff">
										<label for="logo" class="custom-file-label">Choose file...</label>
									</div>
									</div>
									<br><br>
								    
								     <div class="contact-box ">
								    <table class="table">
		        	    
                			    	<thead>
                			    	</thead>
                			    	
                			    	<tbody>
                			    	   
                			    	 
                    					<tr>
                        					<td>Sale Amount</td>
                        					<td>: <?php echo $wallet1['mv_wallet_pending_amt']; ?></td>
                        				</tr>
                        					<tr>
                        					<td>Bank in Amount</td>
                        					<td>: <?php echo $wallet1['mv_wallet_pending_amt']; ?> MYR</td>
                        				</tr>
                        				<tr>
                        					<td>Bank Detail</td>
                        					<td>: <?php echo $user1['mv_merchant_bank']; ?></td>
                        				</tr>
                        				

            						</tbody>
            						
            					</table>
								 </div>
								   
								 
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnseller" value="<?php echo $user1["mv_user_id"]; ?>"><strong>Approve</strong></button>
								</div>
	</form>
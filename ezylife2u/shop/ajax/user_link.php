<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
    //echo 'ID:'.$id;
    $user1 = $db->where('*','mv_user','mv_user_id',$id);
    $user1= $user1[0];
    
   
?>

<link href="css/plugins/jsTree/style.min.css" rel="stylesheet">
    <div class="modal-header">
    
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    		
    		<h4 class="modal-title">Get Link</h4>
    		<br>
    		<p>Please select your downline to add user.</p>
    	</div>
    	
    	<div class="modal-body">
    		
            <div class="ibox ">
				<div class="ibox-title">
					<h5>Relationship &nbsp; </h5>
					
				</div>
				<div class="ibox-content">
					<!-- 需要看有几个上线和几个下线再loop  -->
					<?php 
						    
					    $currentID1 = $user1["mv_user_id"];
                        $status1 = $db->where('*','mv_user','mv_user_id',$currentID1); 
                        $current_status1 = $status1[0]['mv_user_status'];


                        if($current_status1 == 2){
                            $color1 = "text-muted";
                        }else if($current_status1 == 1){
                             $color1 = "text-info";
                        }
				    
				    ?>
					

					<i class="fa fa-user-md text-muted" ></i> : Inactive &nbsp;
					<i class="fa fa-user-md text-info" ></i> : Active
					<br><br>
					<div id="jstree1">
						<ul>
						    
							<?php 
							    $no = 0;
							    
							 
							    
							    function printTree($level=0, $parentID=null)
                                {   
                                    global $db;
                                    global $no;
                                    // Create the query
                                    $sql = "SELECT id FROM tree WHERE ";
                                    $col = "*";
                                    $tb = "mv_user";
                                    $chkcol = "mv_user_referral";
                                    if($parentID == null) {
                                        $opt = null;
                                    }
                                    else {
                                        $opt = intval($parentID);
                                    }
                                    // Execute the query and go through the results.
                                    $result = $db->where($col,$tb,$chkcol,$opt);
                                    if($result)
                                    {
                                        foreach($result as $row)
                                        {
                                            $no++;
                                            
                                            if($row['mv_user_type']==1){ $utype = 'Admin'; }else{ $utype = 'User'; }
                                            
                                            // Print the current ID;
                                            $currentID = $row['mv_user_id'];
                                            $status = $db->where('*','mv_user','mv_user_id',$currentID); 
                                            $current_status = $status[0]['mv_user_status'];

                                            if($current_status == 2){
                                                $color = "text-muted";
                                            }
                                            else if($current_status == 1){
                                                $color = "text-info";
                                            }
                                            
                                                
        							    	$col = "*";
                                        	$tb = "mv_default";
                                        	$opt = 1;
                                        	$default = $db->get($col,$tb,$opt);
                                        	$default = $default[0];
                                        	
                                        	// get maximum downline
                                            $max_downline = $default['mv_default_max_ref'];
    			                            
    			                            
    			                            // check number of user's downline
                                        	$col = "*";
                                        	$tb = "mv_user";
                                        	$chkcol = "mv_user_referral";
                                        	$opt = $row["mv_user_id"];
           
                                            $result = $db->where($col,$tb,$chkcol,$opt);
                                            
                                            if(count($result) < $max_downline){
                                            
                                                //if downline less then max_downline
                                                $check_ref_status = true;
                                                
                                                
                                                
                                        	
                                            }else{
                                                
                                                $check_ref_status = false;
                                            }
                                            
                                            
                                            
                                           
                                            echo "	<li class='jstree $color' >  <span class='text-dark'>$row[mv_user_fullname]</span> <span class='text-white'>l</span> ";
                                            
                                            
                                            
                                            echo "<span data-remote='ajax/getlink.php?p=$currentID' class='badge badge-primary' data-toggle='modal' data-target='#getlink'>Get Link</span>";
										   
                                            // echo "<span class='text-white'>l</span>"."<button type='button' class='badge badge-primary' value='$row[mv_user_code]' onclick='pushRef(this.value)' data-toggle='modal' data-target='#adduser'>Add User</button>";    
                                            echo "<ul>";   
                                            
                                            // Print all children of the current ID
                                            printTree($level+1, $currentID);
                                            echo "</ul>";   
                                            echo "</li>";  
                                            
                                          
                                        }
                                    }
                                    else {
                                        //die("Failed to execute query! ($level / $parentID)");
                                    }
                                   
                                }
                                
                                
							
							    printTree(0,$_SESSION['id']);
							   
						    	?>
							
							
							</li>
						</ul>
					</div>
					
					
					
					
					<br>
					
					<p>Total Downline: <?php echo $no; ?></p>
				</div>
			</div>    		
    		
    	    
    	   
    	   
    	 
    		
    	</div>
    	<div class="modal-footer">
    		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    	</div>

    	
    	
    	
    	
    	
<script src="js/plugins/jsTree/jstree.min.js"></script>

<style>
	.jstree-open > .jstree-anchor > .fa-folder:before {
	content: "\f07c";
	}
	
	.jstree-default .jstree-icon.none {
	width: 0;
	}
</style>    	
<script>

    
		$(document).ready(function(){
			
			$('#jstree1').jstree({
				'core' : {
					'check_callback' : true
				},
				'plugins' : [ 'types', 'dnd' ],
				'types' : {
					'default' : {
						'icon' : 'fa fa-user-md'
					},
					'html' : {
						'icon' : 'fa fa-bus'
					},
					'svg' : {
						'icon' : 'fa fa-file-picture-o'
					},
					'css' : {
						'icon' : 'fa fa-file-code-o'
					},
					'img' : {
						'icon' : 'fa fa-file-image-o'
					},
					'js' : {
						'icon' : 'fa fa-file-text-o'
					}
					
				}
			});

		});
    
    
</script>

	
	
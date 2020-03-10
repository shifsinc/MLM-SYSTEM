<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $cate = $db->where('*','mv_category','mv_category_id',$id);
    $cate = $cate[0];

    
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title">Category Details</h4>

</div>
<div class="modal-body">


    <div class="ibox-content">
    	<div class="col-lg-12">
    		<div class="contact-box ">
			
		    	<h2 class="m-b-xs"><strong><?php echo $cate["mv_category_name"]; ?></strong></h2>
			

		    	<br>
		        	<table class="table">
		        	    
    			    	<thead>
    			    	</thead>
    			    	
    			    	<tbody>

        					
        					<tr>
            					<td>Image</td>
            					<?php if($cate['mv_category_icon']!="") {?>
            					<td>
            					     
            						<div class="lightBoxGallery">
            						   
            							<a href="img/sellercate/<?php echo $cate["mv_category_icon"]; ?>"  data-gallery=""><img class="d-block w-50" src="img/sellercate/<?php echo $cate["mv_category_icon"]; ?>"></a>
            								<?php } 
            									else{
						?>
						<td>No Image</td>
						<?php
						}
					?>
            						</div>
            					</td>
            				</tr>
										        <?php 
										        
										            $cate_status = $cate["mv_category_status"]; 
										            if($cate_status == 1){
										                $show = 'Unblock';
										                $color = 'label label-primary';
										            }else{
										                $show = 'Block';
										                $color = 'label label-danger';
										            }
										            
										        
										        ?>
            				
            				
        						<tr>
        							<td>Status</td>
        							<td><p class="btn btn-white  btn-xs <?php echo $color;  ?>" ><?php echo $show;?></p></td>
        						</tr>
        						<tr>
        							<td></td>
        							<td></td>
        						</tr>
						</tbody>
						
					</table>	
					
				
					
					
					
				</div>
			</div>
		</div>
		
		
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
		
	</div>
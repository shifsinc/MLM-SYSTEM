<?php
    require_once('inc/init.php');
    $PageName = "userindex";
    require_once('inc/header.php');

    //createLog(1,'user');
    
    $pointname = $db->get('mv_default_point_name','mv_default',1);
    $pointname = $pointname[0]['mv_default_point_name'];

?>

<!-- FooTable -->



<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
		<?php require_once('inc/top_nav.php'); ?>
		<!-- Content write here START -->
		<?php 
            if($onpage == 2){
        
         ?>
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2>Home</h2>
				<ol class="breadcrumb">
					<li class="breadcrumb-item active">
						<a href="userindex.php">Home</a>
					</li>
					
				</ol>
			</div>
			<div class="col-lg-2">

			</div>
		</div>
		
        <div class="wrapper wrapper-content">
                <div class="row">

                    
                    
                    <div class="col-lg-4">
                        <div class="widget style1 red-bg">
                            <div class="row">
                                <div class="col-4">
                                    <a href="logo_cate.php"><i class="fa fa-shopping-cart fa-5x text-white"></i></a>
                                </div>
                                <div class="col-8 text-right">
                                    <span> Shopping </span>
                                    <h3 class="font-bold">Click <i class="fa fa-shopping-cart "></i> to Shopping</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
				     <?php

        		    $anno = $db->get('mv_default_anno',"mv_default",1);
        		    $anno = $anno[0]['mv_default_anno'];
        		    
        		    
        		  ?>
        		    
        		    <div class="col-lg-4">
        
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                           <strong>Announcement</strong> 
                        </div>
                        <div class="panel-body">
                            <p><?php echo $anno; ?></p>
                        </div>

                        
        
                    </div>
        		    
        		</div>
                    

                    
                    
                </div>
                <div class="row">
					
					<?php   
					
					    $thisid = $user["mv_user_id"];
					    $wallet = $db->where('*','mv_wallet','mv_user_id',$thisid);
					    $wallet = $wallet[0];
					    
					    
					    $thisid = $user["mv_user_id"];
					    $point = $db->where('*','mv_user','mv_user_id',$thisid);
					    $point = $point[0];
					    
					    $col="mv_user_id";
        				$opt= 'mv_order_status = ? AND mv_user_id = ?';
        				
        				$arr=array(0,$thisid);
        				$order = $db->advwhere($col,'mv_order',$opt,$arr);
					    $count_order = count($order);
					?>
					
                    <div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title bg-primary">
                                
                                <h5>Wallet</h5>
							</div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $wallet["mv_wallet_amt"]; ?> <span class="badge badge-danger "><?php echo $pointname; ?></span></h1>
                                
                                <small>Total Balance</small>
							</div>
						</div>
						
					</div>
					<div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title bg-info">
                                
                                <h5>Pending Wallet</h5>
							</div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $wallet["mv_wallet_pending_amt"]; ?> <span class="badge badge-danger "><?php echo $pointname; ?></span></h1>
                                
                                <small>In this month</small>
							</div>
						</div>
						
					</div>
					<div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title bg-warning">
                                
                                <h5>Your Order</h5>
							</div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $count_order; ?> <span class="badge badge-danger "><a href="checkorder.php" style="color:white;">in Pending</a></span></h1>
                                
                                <small>Total Order</small>
							</div>
						</div>
						
					</div>
					
				</div>
		
				
				
				
                
            

                    
                <div class="row">
					

					<div class="col-lg-4">
						
						<div class="ibox ">
							<div class="ibox-title bg-primary">
								<h5> <?php echo $pointname; ?> Request</h5>

							</div>
							
							<div class="ibox-content">
							    
								<input type="text" class="form-control form-control-sm m-b-xs" id="filter"
								placeholder="Search in table">
								
								<table class="footable table table-stripped" data-page-size="5" data-filter=#filter>
									<thead>
										<tr>
											<th>No</th>
											<th>Date Time</th>
											<th>Amount</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									        
									        
									        $userid = $user['mv_user_id'];
								            $i=1;
											$col="*";
                            				$opt= 'mv_request_activity = ? AND mv_request_status = ? AND mv_user_id = ?';
                            				$arr=array(1,1,$userid);
                            				$result = $db->advwhere($col,'mv_request',$opt,$arr);
											foreach($result as $with){
											?>
											 
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $with["mv_request_datetime"]; ?></td>
											<td><?php echo $with["mv_request_amt"]; ?></td>
											<?php    
											    
											    if($with['mv_request_status' == 1]){
											        $show = 'pending';
											    }else{
											        $show = 'status error';
											    }
											    
											?>
											<td class="text text-warning "><?php echo $show; ?></td>
											
										</tr>
										
											<?php $i++; } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<ul class="pagination float-right"></ul>
											</td>
										</tr>
									</tfoot>
								</table>
								
							</div>
						</div>
						
					</div>
					
					
					
					
					<!--div class="col-lg-4">
						
						<div class="ibox ">
							<div class="ibox-title bg-info">
								<h5> Redeem Request</h5>

							</div>
							
							<div class="ibox-content">
							    
								<input type="text" class="form-control form-control-sm m-b-xs" id="filter1"
								placeholder="Search in table">
								
								<table class="footable table table-stripped" data-page-size="5" data-filter=#filter1>
									<thead>
										<tr>
											<th>No</th>
											<th>Date Time</th>
											<th>Amount</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									        
									        
									        $userid = $user['mv_user_id'];
								            $i=1;
											$col="*";
                            				$opt= 'mv_request_activity = ? AND mv_request_status = ? AND mv_user_id = ?';
                            				$arr=array(2,1,$userid);
                            				$result = $db->advwhere($col,'mv_request',$opt,$arr);
											foreach($result as $with){
											?>
											 
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $with["mv_request_datetime"]; ?></td>
											<td><?php echo $with["mv_request_amt"]; ?></td>
											<?php    
											    
											    if($with['mv_request_status' == 1]){
											        $show = 'pending';
											    }else{
											        $show = 'status error';
											    }
											    
											?>
											<td class="text text-warning "><?php echo $show; ?></td>
											
										</tr>
										
											<?php $i++; } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<ul class="pagination float-right"></ul>
											</td>
										</tr>
									</tfoot>
								</table>
								
							</div>
						</div>
						
					</div-->
					
					
					<div class="col-lg-4">
						
						<div class="ibox ">
							<div class="ibox-title bg-info">
								<h5>Withdraw Request</h5>

							</div>
							
							<div class="ibox-content">
							    
								<input type="text" class="form-control form-control-sm m-b-xs" id="filter2"
								placeholder="Search in table">
								
								<table class="footable table table-stripped" data-page-size="5" data-filter=#filter2>
									<thead>
										<tr>
											<th>No</th>
											<th>Date Time</th>
											<th>Amount</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									        
									        
									        $userid = $user['mv_user_id'];
								            $i=1;
											$col="*";
                            				$opt= 'mv_request_activity = ? AND mv_request_status = ? AND mv_user_id = ?';
                            				$arr=array(3,1,$userid);
                            				$result = $db->advwhere($col,'mv_request',$opt,$arr);
											foreach($result as $with){
											?>
											 
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $with["mv_request_datetime"]; ?></td>
											<td><?php echo $with["mv_request_amt"]; ?></td>
											<?php    
											    
											    if($with['mv_request_status' == 1]){
											        $show = 'pending';
											    }else{
											        $show = 'status error';
											    }
											    
											?>
											<td class="text text-warning "><?php echo $show; ?></td>
											
										</tr>
										
											<?php $i++; } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<ul class="pagination float-right"></ul>
											</td>
										</tr>
									</tfoot>
								</table>
								
							</div>
						</div>
						
					</div>
					
					

					
				</div>
                

		
		
		
        </div>
        
        <?php  
		    }
		    else
		    {
		        echo "YOU ARE NOT USER, U CANNOT LANDING THIS PAGE";
		    }
		?>
		<!-- Content write here END -->
		<?php require_once('inc/footer.php'); ?>
	</div>
	
	
	</div>
	
    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- FooTable -->
    <script src="js/plugins/footable/footable.all.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();

        });

    </script>
        
        
        
    </script>
</body>
</html>

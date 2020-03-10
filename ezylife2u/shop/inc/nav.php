<?php 


    $your_id = $_SESSION['id'];
    $user = $db->where('*','mv_user','mv_user_id',$your_id);
    $user = $user[0];
    
    $point = $db->get('mv_default_point_name','mv_default',1);
    $point = $point[0]['mv_default_point_name'];

	$onpage = $user['mv_user_type'];

	if($onpage == "1")
	{
		$adminopen = "";
		$adminclose = "";
		
		$useropen = "<!--";
		$userclose = "-->";
		
		$shopopen = "<!--";
		$shopclose = "-->";
		
		$merchantopen = "<!--";
		$merchantclose = "-->";
		
	}else if ($onpage == "2")
	{	
		$adminopen = "<!--";
		$adminclose = "-->";
		
		$useropen = "";
		$userclose = "";
		
		$shopopen = "<!--";
		$shopclose = "-->";
		
		$merchantopen = "<!--";
		$merchantclose = "-->";
	}
	else if ($onpage == "3")
	{	
		$adminopen = "<!--";
		$adminclose = "-->";
		
		$useropen  = "<!--";
		$userclose = "-->";
		
		$shopopen = "";
		$shopclose = "";
		
		$merchantopen = "<!--";
		$merchantclose = "-->";
	}
	
	else if ($onpage == "4")
	{	
		$adminopen = "<!--";
		$adminclose = "-->";
		
		$useropen  = "<!--";
		$userclose = "-->";
		
		$shopopen = "<!--";
		$shopclose = "-->";
		
		$merchantopen = "";
		$merchantclose = "";
	}
	


?>

<nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                           <?php if($user['mv_user_image']!="") {?>
						<img alt="image" class="rounded-circle" src="img/userprofile/<?php echo $user["mv_user_image"]; ?>" style="width:48px;height:48px;"/>
						<?php }
						else{
						?>
						<img alt="image" class="rounded-circle" src="img/userprofile/img.jpg" style="width:48px;height:48px;"/>
						<?php
						}
					?>
                            
                                <h3><span class="block m-t-xs font-bold text-light"><?php echo $user['mv_user_fullname']; ?></span></h3>
                                
                            
                            
                        </div>
                        <div class="logo-element">
                            VEGE
                        </div>
                    </li>
					
					
					<?php echo $adminopen?>
                    <li <?php if($PageName == 'index')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					
					class="<?php echo $classshow ?>">		 
                        <a href="index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Homepage</span></a>                   
                    </li>
					<?php echo $adminclose?>
					
					
					
					<?php echo $useropen?>
					<li <?php if($PageName == 'userindex')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="userindex.php"><i class="fa fa-th-large"></i> <span class="nav-label">Homepage</span></a>
                    </li>
					<?php echo $userclose?>
					
					
					
					<?php echo $adminopen?>
					<li <?php if($PageName == 'userlist')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="userlist.php"><i class="fa fa-list-ol"></i> <span class="nav-label">User List</span></a>
                    </li>
					<?php echo $adminclose?>
					
					
					
					<?php echo $adminopen?>
					<li <?php if($PageName == 'packagelist')
						{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="packagelist.php"><i class="fa fa-database"></i> <span class="nav-label">Add Package</span></a>
                    </li>
                    <?php echo $adminclose?>

                    
                    
					<?php echo $useropen?>
					<li <?php if($PageName == 'userprofile')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="userprofile.php"><i class="fa fa-address-book"></i> <span class="nav-label">Profile</span></a>
                    </li>
					<?php echo $userclose?>
					
					
					
					<?php echo $adminopen?>
					<li <?php if($PageName == 'Transaction')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="transaction.php"><i class="fa fa-send"></i> <span class="nav-label">Transaction</span></a>
                    </li>
					<?php echo $adminclose?>
					
					
					
					<?php echo $adminopen?>
					<li <?php if($PageName == 'request')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="request.php"><i class="fa fa-bell"></i> <span class="nav-label">Request</span></a>
                    </li>
					<?php echo $adminclose?>
					
					
					
					
					
					<?php echo $adminopen?>
					<li <?php if($PageName == 'catelist')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="catelist.php"><i class="">IC</i> <span class="nav-label">Item Category</span></a>
                    </li>
					<?php echo $adminclose?>
					
						<?php echo $adminopen?>
					<li <?php if($PageName == 'category')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="category.php"><i class="">SC</i> <span class="nav-label">Seller Category</span></a>
                    </li>
					<?php echo $adminclose?>
					
					
					
					<?php echo $adminopen?>
					<li <?php if($PageName == 'itemlist')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="itemlist.php"><i class="fa fa-dropbox"></i> <span class="nav-label">Item</span></a>
                    </li>
					<?php echo $adminclose?>
					
					<?php echo $shopopen?>
					<li <?php if($PageName == 'sellindex')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="sellindex.php"><i class="fa fa-th-large"></i> <span class="nav-label">Homepage</span></a>
                    </li>
					<?php echo $shopclose?>
					
					<?php echo $shopopen?>
					<li <?php if($PageName == 'sellprofile')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="sellprofile.php"><i class="fa fa-address-book"></i> <span class="nav-label">Profile</span></a>
                    </li>
					<?php echo $shopclose?>
					
					
					<?php echo $shopopen?>
					<li <?php if($PageName == 'shopitem')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="shopitem.php"><i class="fa fa-dropbox"></i> <span class="nav-label">Item</span></a>
                    </li>
					<?php echo $shopclose?>
					
					
					
					<?php echo $adminopen?>
					<li <?php if($PageName == 'pending')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="pending.php"><i class="fa fa-edit"></i> <span class="nav-label">Request/Withdraw</span></a>
                    </li>
					<?php echo $adminclose?>
					
						<?php echo $adminopen?>
					<li <?php if($PageName == 'sale')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="sale.php"><i class="fa fa-bank"></i> <span class="nav-label">Merchant/Wholesaler</span></a>
                    </li>
					<?php echo $adminclose?>
					
					
					<?php echo $adminopen?>
					<li <?php if($PageName == 'orderlist')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="orderlist.php"><i class="fa fa-book"></i> <span class="nav-label">Order</span></a>
                    </li>
					<?php echo $adminclose?>
					
					
					
					
					<?php echo $useropen?>
					<li <?php if($PageName == 'member')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="member.php"><i class="fa fa-list-ol"></i> <span class="nav-label">Member</span></a>
                    </li>
                    <?php echo $userclose?>
                    
                    
                    <?php echo $useropen?>
					<li <?php if($PageName == 'package')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="logo_cate.php"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Shopping</span></a>
                    </li>
                    <?php echo $userclose?>
                    
                    
                    <?php echo $useropen?>
					<li <?php if($PageName == 'user_merchant')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="user_merchant.php"><i class="fa fa-bank"></i> <span class="nav-label">Merchant</span></a>
                    </li>
                    <?php echo $userclose?>
                    
                    
                    <?php echo $useropen?>
					<li <?php if($PageName == 'checkorder')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="checkorder.php"><i class="fa fa-book"></i> <span class="nav-label">Order</span></a>
                    </li>
                    <?php echo $userclose?>
                  
                    
                    
                    <?php echo $useropen?>
                    <li <?php if($PageName == 'wallet')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="wallet.php"><i class="fa fa-money"></i> <span class="nav-label">Wallet</span></a>
                    </li>
                   <?php echo $userclose?>
                   
                   
                   
                   
                   <?php echo $useropen?>
                    <li <?php if($PageName == 'checkrequest')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="checkrequest.php"><i class="fa fa-bell"></i> <span class="nav-label">Request</span></a>
                    </li>
                   <?php echo $userclose?>
                   
                   	<?php echo $merchantopen?>
					<li <?php if($PageName == 'merindex')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="merindex.php"><i class="fa fa-th-large"></i> <span class="nav-label">Homepage</span></a>
                    </li>
					<?php echo $merchantclose?>
                   
                    <?php echo $merchantopen?>
                    <li <?php if($PageName == 'merchantprofile')
					{
						$classshow = 'active';
					}else
					{
						$classshow = '';
					}
					?> 
					class="<?php echo $classshow ?>">
                        <a href="merchantprofile.php"><i class="fa fa-address-book"></i> <span class="nav-label">Profile</span></a>
                    </li>
                   <?php echo $merchantclose?>

					
					
					
                    
                    
                    
                </ul>

            </div>
        </nav>
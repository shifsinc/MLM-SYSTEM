<?php
    require_once('inc/init.php');
    $PageName = "merindex";
    require_once('inc/header.php');

    //createLog(1,'user');

?>

<!-- FooTable -->



<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
		<?php require_once('inc/top_nav.php'); ?>
		<!-- Content write here START -->
		<?php 
            if($onpage == 4){
        
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
            
		    COMMING SOON
		
        </div>
        
        <?php  
		    }
		    else
		    {
		        echo "YOU ARE NOT MERCHANT, U CANNOT LANDING THIS PAGE";
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

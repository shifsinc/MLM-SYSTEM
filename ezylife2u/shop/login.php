<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ezylife2u | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
</head>

<body class="gray-bg">
        <div class="navbar-wrapper">
            <nav class="navbar-header page-scroll" role="navigation">
                <div class="container">
                    <a class="navbar-brand" href="../index.php">HOME</a>
                  
                    
                </div>
            </nav>
    </div>
    <div class="text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">Ezylife2u</h1>

            </div>
			<div class="middle-box">
				<h3>Welcome to Ezylife2u</h3>
				<p>Login in. To see it in action.</p>
				<form class="m-t" role="form">
					<div class="form-group">
						<input type="text" class="form-control" id="uname" placeholder="Username" required="">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="pword" placeholder="Password" required="">
					</div>
					<div class="form-group">
						<span class="text-danger" id="error_msg"></span>
					</div>
					<button type="submit" id="btnsubmit" class="btn btn-primary block full-width m-b">Login</button>
					
					<a href="forget_password.php"><small>Forgot password?</small></a>
				</form>
				<p class="m-t"> <small>Developed By Ezylife2u &copy; 2018</small> </p>
			</div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>

<script>

	$('body').on('click', '[data-toggle="modal"]', function(){
                $($(this).data("target")+' .modal-content').load($(this).data("remote"));
            });  
            
$('#btnsubmit').click(function(e){
	var uname = $('#uname').val();
	var pword = $('#pword').val();
	
	if(uname!="" && pword!=""){
		e.preventDefault();
		
		$.post('api/login.php', { Uname: uname, Pword: pword }, function(data){
		    data = JSON.parse( data );
			if(data[0]){
			    window.location.replace('api/routing.php?login_key='+data[1]);
			}else{
			    $('#error_msg').html('<b>Wrong Username Or Password</b>');
			}
		});
		
	}
	
})
</script>
<!DOCTYPE html>
<?php
    include_once ('shop/connection/PDO_conn.php');
    
    
class DB_FUNCTIONS{
	protected $conn;

	function get($col,$tablename,$opt){
		global $conn;
		$stmt = $conn->prepare("SELECT $col FROM $tablename WHERE :opt");
		$stmt->bindValue(":opt", $opt, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	
}
    
	$db = new DB_Functions(); 
	$result = $db->get('*',"mv_default",1);
	$img = $result[0];
    
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EZYLIFE2U - Landing Page </title>

    <!-- Bootstrap core CSS -->
    <link href="shop/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="shop/css/animate.css" rel="stylesheet">
    <link href="shop/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="shop/css/style.css" rel="stylesheet">
	
<style>
	
.landing-page .header-back {
  height: 470px;
  width: 100%;
}
.landing-page .header-back.one {
  background: url('shop/img/landing/<?php echo $img['mv_pic1'] ?>') 50% 0 no-repeat;
}
.landing-page .header-back.two {
  background: url('shop/img/landing/<?php echo $img['mv_pic2'] ?>') 50% 0 no-repeat;
}
.landing-page .header-back.three {
  background: url('shop/img/landing/<?php echo $img['mv_pic3'] ?>') 50% 0 no-repeat;
}
	
</style>
</head>
<body id="page-top" class="landing-page no-skin-config">
<div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md" role="navigation">
            <div class="container">
                
                <a class="navbar-brand" data-toggle="modal" href="#login">LOGIN</a>
                <a class="navbar-brand" href="shop/landing_register.php">SIGN UP</a>
                <div class="navbar-header page-scroll">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="nav-link page-scroll" href="#page-top">Home</a></li>
                        <li><a class="nav-link page-scroll" href="#aboutus">About Us</a></li>
                        <li><a class="nav-link page-scroll" href="#contact">Contact</a></li>
                        
                    </ul>
                </div>
            </div>
        </nav>
</div>
<div id="inSlider" class="carousel slide" data-ride="carousel" >
    <ol class="carousel-indicators">
        <li data-target="#inSlider" data-slide-to="0" class="active"></li>
        <li data-target="#inSlider" data-slide-to="1"></li>
        <li data-target="#inSlider" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <div class="container">
                <!--<div class="carousel-caption">-->
                <!--    <h1><span class="text-muted">Ezylife2u</span><br/>-->
                <!--        The Best Vegetables Vendor<br/>-->
                <!--        Cost<br/>-->
                <!--        Time-saving</h1>-->
                <!--    <p></p>-->
                <!--    <p>-->
                        
                        
                <!--    </p>-->
                <!--</div>-->
                <!--<div class="carousel-image wow zoomIn">-->
                <!--    <img src="shop/img/landing/laptop1.png" alt="laptop"/>-->
                <!--</div>-->
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back one"></div>

        </div>
        <div class="carousel-item">
            <div class="container ">
			
                <!--<div class="carousel-caption blank" >-->
                <!--    <h1>Earn Money <br/> When You Buy Vegetables From US! </h1>-->
                <!--    <p>You can refer consumer to us to earn commission</p>-->
                <!--    <p><a class="btn btn-lg btn-primary page-scroll" href="#more" role="button">Learn more</a></p>-->
                <!--</div>-->
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back two"></div>
        </div>
        <div class="carousel-item">
            <div class="container ">
			
                
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back three"></div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#inSlider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#inSlider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>




<section id="more" class="container features">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1><span class="navy">Cost & Time-saving<br/>   </span> </h1>
            <h4>Don’t have to get stucked in the traffic and face payment issues. </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center wow fadeInLeft">
            <div>
                <i class="fa fa-mobile features-icon"></i>
                <h2>Convenient to access</h2>
                <p>Members only have to log on to www.ezylife2u.com
					All cooking ingredients will be sent to you within a click.</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-gift features-icon"></i>
                <h2>Fresh ingredients</h2>
                <p>Immediate professional treatment after getting them (using the vacuum sealing technique). Fresh and hygienic food being sent to our clients.</p>
            </div>
        </div>
        <div class="col-md-6 text-center  wow zoomIn">
            <img src="shop/img/landing/vege.jpg" alt="dashboard" class="img-fluid">
        </div>
        <div class="col-md-3 text-center wow fadeInRight">
            <div>
                <i class="fa fa-truck features-icon"></i>
                <h2>Delivery</h2>
                <p>lowest free delivery package: minimum spending of RM 175 (any area which is within the coverage of Ezylife2u)</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-handshake-o features-icon"></i>
                <h2>Consumer benefits</h2>
                <p>Our members might get free food or even stable extra income every month!</p>
            </div>
        </div>
    </div>

</section>

<section id="aboutus" class="gray-section team">
    <div class="container">
        
        
		<div class="row">
			<div class="col-lg-12 text-center">
				<div class="navy-line"></div>
				<h1>About Ezylife2u</h1>
				<p style="font-size:17px">Ezylife2u is an online grocery website convenient for every household to solve financial problems. </p>
			</div>
		</div>
		<div class="row features-block">
			<div class="col-lg-6 features-text wow fadeInLeft">
				<small>Ezylife2u</small>
				<h1 class="text-info">Modernization </h1>
				<p style="color:black;">Using the internet to replace traditional business mode. Fresh ingredients including vegetables, seafood, fruit, meat, dry food and etc.</p>
				<p style="color:black;">More than a hundred household ingredients for you to chose. Other than that, Ezylife2u also has an additional benefit for our members. Not only that you can conveniently get fresh ingredients, you can also get free food and also chances to earn extra income.</p>
				
			</div>
			<div class="col-lg-6 text-right  fadeInRight">
				<!--<img src="shop/img/landing/vege8.png" alt="dashboard" class="img-fluid float-right">-->
				<figure>

                    
                    <video  width="425" height="349" controls="controls" preload="" onclick="this.play()" controls controlsList="nodownload">
                        <source type="video/mp4" src="shop/video/mrvege.mp4">
                    </video>
                </figure>
			</div>
		</div>
        <div class="row">
            <div class="col-lg-12 text-center m-t-lg m-b-lg">
                </div>
        </div>
    </div>
</section>

<section id="contact" class="section contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Contact Us</h1>
                <p>Have questions? I have answers.</p>
            </div>
        </div>
       
        <div class="row">
            <div class="col-lg-12 text-center">
                <a data-toggle="modal" href="#email" class="btn btn-primary">Send us mail</a>
                <p class="m-t-sm">
                    Or follow us on social platform
                </p>
                <ul class="list-inline social-icon">
                    
                    <li class="list-inline-item"><a href="https://www.facebook.com/EzyLife-%E7%94%9F%E6%B4%BB%E6%B7%98-450695445684048/"><i class="fa fa-facebook"></i></a>
                    </li>
                    
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center m-t-lg m-b-lg">
                <p><strong>Copyright &copy; Ezylife2u 2018</strong><br/> </p>
            </div>
        </div>
    </div>
</section>

            


                <div class="modal inmodal" id="login" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog ">
						<div class="modal-content animated fadeIn">
						
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Login</h4>
								</div>
								<div class="modal-body">
								    
									<body class="gray-bg">
                                    
                                    <div class="text-center loginscreen animated fadeInDown">
                                        <div>
                                            <div>
                                
                                                <img src="shop/img/landing/ezy.jpg" alt="logo" class="w-50">
                                
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
                                					
                                						<a href="shop/forget_password.php"><small>Forgot password?</small></a>
                                				</form>
                                				<p class="m-t"> <small>Developed By Ezylife2u &copy; 2018</small> </p>
                                			</div>
                                        </div>
                                    </div>
                                
                                </body>
										
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									
								</div>
						</div>
					</div>
				</div>
				
				<div class="modal inmodal" id="email" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
						
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Contact Us</h4>
								</div>
								<div class="modal-body">
								    
									<body class="gray-bg">
                                    
                                    <div class="text-center loginscreen animated fadeInDown">
                                        <div>
                                          
                                			<div class="middle-box">
                                				<h3>Welcome to Ezylife2u</h3>
                                				<p>Question? Write down your name and email.</p>
                                				<form class="m-t" role="form">
                                					<div class="form-group">
                                						<input type="text" class="form-control" id="name" placeholder="Enter Your Name" required="">
                                					</div>
                                					<div class="form-group">
                                						<input type="email" class="form-control" id="email" placeholder="Enter Your Email" required="">
                                					</div>
                                					<div class="form-group">
                                						<input type="text" class="form-control" id="comment" placeholder="Enter Your Comment" required="">
                                				
                                					<div class="form-group">
                                						<span class="text-danger" id="error_msg"></span>
                                					</div>
                                					
                                					
                                					<button type="submit" id="btnsubmitemail" class="btn btn-primary block full-width m-b">Submit</button>
                                					
                                					
                                				</form>
                                				<p class="m-t"> <small>Developed By Ezylife2u &copy; 2018</small> </p>
                                			</div>
                                        </div>
                                    </div>
                                
                               
                                </body>
										
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									
								</div>
						</div>
					</div>
				</div>
			</div>

<?php

if(isset($_POST['btnsubmitsubcategory'])){
    
    
    // Check for empty fields
    if(empty($_POST['name'])      ||
       empty($_POST['email'])     ||
       empty($_POST['phone'])     ||
       empty($_POST['message'])   ||
       !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
       {
       echo "No arguments Provided!";
       return false;
       }
       
    $name = strip_tags(htmlspecialchars($_POST['name']));
    $email_address = strip_tags(htmlspecialchars($_POST['email']));
    $message = strip_tags(htmlspecialchars($_POST['message']));
       
    // Create the email and send the message
    $to = 'mrvege@mrvege777.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
    $email_subject = "Website Contact Form:  $name";
    $email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\n";
    $headers = "From: noreply@mrvege777.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
    $headers .= "Reply-To: $email_address";   
    mail($to,$email_subject,$email_body,$headers);
    return true;     
        
}
    
?>


<!-- Mainly scripts -->
<script src="shop/js/jquery-3.1.1.min.js"></script>
<script src="shop/js/popper.min.js"></script>
<script src="shop/js/bootstrap.js"></script>
<script src="shop/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="shop/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="shop/js/inspinia.js"></script>
<script src="shop/js/plugins/pace/pace.min.js"></script>
<script src="shop/js/plugins/wow/wow.min.js"></script>


<script>

    $(document).ready(function () {

        $('body').scrollspy({
            target: '#navbar',
            offset: 80
        });

        // Page scrolling feature
        $('a.page-scroll').bind('click', function(event) {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
            $("#navbar").collapse('hide');
        });
    });

    var cbpAnimatedHeader = (function() {
        var docElem = document.documentElement,
                header = document.querySelector( '.navbar-default' ),
                didScroll = false,
                changeHeaderOn = 200;
        function init() {
            window.addEventListener( 'scroll', function( event ) {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 250 );
                }
            }, false );
        }
        function scrollPage() {
            var sy = scrollY();
            if ( sy >= changeHeaderOn ) {
                $(header).addClass('navbar-scroll')
            }
            else {
                $(header).removeClass('navbar-scroll')
            }
            didScroll = false;
        }
        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }
        init();

    })();

    // Activate WOW.js plugin for animation on scrol
    new WOW().init();

        
        $('#btnsubmit').click(function(e){
        	var uname = $('#uname').val();
        	var pword = $('#pword').val();
        	
        	if(uname!="" && pword!=""){
        		e.preventDefault();
        		
        		$.post('shop/api/login.php', { Uname: uname, Pword: pword }, function(data){
        		    data = JSON.parse( data );
        			if(data[0]){
        			    window.location.replace('shop/api/routing.php?login_key='+data[1]);
        			}else{
        			    $('#error_msg').html('<b>Wrong Username Or Password</b>');
        			}
        		});
        		
        	}
        	
        })
</script>

</body>
</html>

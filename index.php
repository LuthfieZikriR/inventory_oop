<?php 

	include 'config/koneksi.php';
	include 'controllers/controllers.php';

	$msg="";

	$perintah = new oop();
	@$user = $_POST['username'];
	@$pass = $_POST['password'];
	@$level = $_POST['level'];
	if (isset($_POST['masuk'])) {
		# code...
		if ($user!=null && $pass!=null && $level!="") {
			# code...
			if ($level=="admin") {
				$perintah->login($con,"tbl_user",$user,$pass,$level,"admin_form.php");
			}elseif ($level=="1"){
				$perintah->login($con,"tbl_user",$user,$pass,$level,"manager.php");
			}else{
				$perintah->login($con,"tbl_user",$user,$pass,$level,"kasir.php");
			}
		}else{
			$msg="isi semua data!";
		}
	}


 ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forms</title>

<link href="asset/css/bootstrap.min.css" rel="stylesheet">
<link href="asset/css/datepicker3.css" rel="stylesheet">
<link href="asset/css/styles.css" rel="stylesheet">

</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Log in</div>
				<div class="panel-body">
					<form role="form" method="post">
						<p style="color: red"><?php if ($msg!=null) {
									echo $msg;
								} ?></p>
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
							<div class="form-group">
								<div class="log-input-left">
									   <select class="form-control1" name="level">
									   		<option value="">--Login As--</option>
									   		<option value="admin">Admin</option>
									   		<option value="manager">Manager</option>
									   		<option value="cashier">Cashier</option>
									   </select>
								</div>
							</div>
							<input type="submit" name="masuk" class="btn btn-primary" value="Login">
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

	<script src="asset/js/jquery-1.11.1.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/chart.min.js"></script>
	<script src="asset/js/chart-data.js"></script>
	<script src="asset/js/easypiechart.js"></script>
	<script src="asset/js/easypiechart-data.js"></script>
	<script src="asset/js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>

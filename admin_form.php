<?php 
	include "config/koneksi.php";
	include "controllers/controllers.php";

	@$menu = $_GET['menu'];
	@$aksi = $_GET['aksi'];
	$perintah = new oop();

	@session_start();
	@$user = $_SESSION['user'];
	if ($user==null) {
		?>
		<script>window.location.href="index.php"</script>
		<?php
	}else{
		if ($user!="admin") {
			if ($user=="kasir") {
				?>
				<script>window.location.href="kasir.php"</script>
				<?php
			}else{
				?>
				<script>window.location.href="manager.php"</script>
				<?php
			}
		}
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		?>
		<script>window.location.href="index.php"</script>
		<?php
	}
?>
 ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Inventory</title>

<link href="asset/css/bootstrap.min.css" rel="stylesheet">
<link href="asset/css/datepicker3.css" rel="stylesheet">
<link href="asset/css/styles.css" rel="stylesheet">
<link href="asset/css/bootstrap-table.css" rel="stylesheet">


<!--Icons-->
<script src="asset/js/lumino.glyphs.js"></script>

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>Inventory</span>Admin</a>
				<ul class="user-menu">
					<div class="profile_details">
						<ul>
							<li class="dropdown profile_details_drop">
								<a href="admin_form.php?logout" class="btn btn-danger" onclick="return confirm('are you sure bradah?')" name="logout">Logout</a>
							</li>
							<div class="clearfix"> </div>
						</ul>
					</div>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
		<ul class="nav menu">
			<li class="active"><a href="admin_form.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a></li>
			<li class="active"><a href="admin_form.php?menu=barang"><i class="lnr lnr-power-switch"></i><span>Barang</span></a></li>
			<li class="active"><a href="admin_form.php?menu=distributor"><i class="lnr lnr-power-switch"></i><span>Distributor</span></a></li>
			<li class="active"><a href="admin_form.php?menu=merek"><i class="lnr lnr-power-switch"></i><span>Merek</span></a></li>
			<li class="active"><a href="admin_form.php?menu=transaksi"><i class="lnr lnr-power-switch"></i><span>Data transaksi</span></a></li>
		</ul>
		<div class="attribution"><a href="http://www.medialoot.com/item/lumino-admin-bootstrap-template/">Medialoot</a><br/><a href="http://www.glyphs.co" style="color: #333;">Icons by Glyphs</a></div>
	</div><!--/.sidebar-->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			

	<?php 

	if (@$_GET['menu']==null) {
		include "home.php";
	} elseif($_GET['menu']=="barang") {
		include "barang.php";
	}
	

	 ?>
	</div>
	<script src="asset/js/jquery-1.11.1.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script src="asset/js/chart.min.js"></script>
	<script src="asset/js/chart-data.js"></script>
	<script src="asset/js/easypiechart.js"></script>
	<script src="asset/js/easypiechart-data.js"></script>
	<script src="asset/js/bootstrap-datepicker.js"></script>
		<script src="asset/js/bootstrap-table.js"></script>

	<script>
		$('#calendar').datepicker({
		});

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

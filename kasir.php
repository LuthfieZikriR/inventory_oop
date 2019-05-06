<?php 
	include "config/koneksi.php";
	include "controllers/controllers.php";

	@$menu = $_GET['menu'];
	@$aksi = $_GET['aksi'];
	$perintah = new oop();

	@session_start();
		if ($_SESSION['user']==null ) {
		?>
		<script>window.location.href="index.php"</script>
		<?php
	}else{
	if ($_SESSION['user']!="kasir"){
		if ($_SESSION['user']=="admin") {
			?>
		<script>window.location.href="admin_form.php"</script>
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

<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="asset/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="asset/css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" type="text/css" href="asset/css/datatables.bootstrap.min">
<!-- Graph CSS -->
<link href="asset/css/font-awesome.css" rel="stylesheet">
<!-- jQuery -->
<!-- lined-icons -->
<link rel="stylesheet" href="asset/css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
<!-- chart -->
<script src="asset/js/Chart.js"></script>
<!-- //chart -->
<!--animate-->
<link href="asset/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="asset/js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!----webfonts--->
<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<!---//webfonts--->
 <!-- Meters graphs -->
<script src="js/jquery-1.10.2.min.js"></script>
<!-- Placed js at the end of the document so the pages load faster -->

</head>

 <body class="sticky-header left-side-collapsed"  onload="initMap()">
    <section>
    	<div class="left-side sticky-left-side">

			<!--logo and iconic logo start-->
			<div class="logo">
				<h1><a href="index.php">Happy <span>Mart</span></a></h1>
			</div>
			<div class="logo-icon text-center">
				<a href="admin_form.php"><i class="lnr lnr-home"></i> </a>
			</div>

			<!--logo and iconic logo end-->
			<div class="left-side-inner">

				<!--sidebar nav start-->
					<ul class="nav nav-pills nav-stacked custom-nav">
						<li class="active"><a href="kasir.php"><i class="lnr lnr-power-switch"></i><span>Transaksi</span></a></li>
					</ul>
				<!--sidebar nav end-->
			</div>
		</div>
		<div class="main-content">
			<!-- header-starts -->
			<div class="header-section">

			<!--toggle button start-->
			<a class="toggle-btn  menu-collapsed"><i class="fa fa-bars"></i></a>
			<!--toggle button end-->

			<!--notification menu start -->
			<div class="menu-right">
				<div class="user-panel-top">
					<div class="profile_details_left">
						<ul class="nofitications-dropdown">
							
							<div class="clearfix"></div>
						</ul>
					</div>
					<div class="profile_details">
						<ul>
							<li class="dropdown profile_details_drop">
								<a href="admin_form.php?logout" class="btn btn-danger" onclick="return confirm('are you sure bradah?')" name="logout">Logout</a>
							</li>
							<div class="clearfix"> </div>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			  </div>
			<!--notification menu end -->
			</div>
   <?php
@$msg = ""; 
@$total_harga =0;
@$merek       = "";
@$nama_barang = $_POST['nama_barang'];
@$nama_merek  = $_POST['merek'];
@$jumlah      = $_POST['jumlah'];
@$total       = $_POST['total'];
@$kd          = $_SESSION['kd'];
@$nama_pembeli= $_SESSION['nama_pembeli'];

if (isset($_POST['proses'])) {
  if ($_POST['bayar']!=null) {
    $nama = $perintah->tampilwhere($con,"tbl_tmp_transaksi","kd_tmp='$kd'");
    $nama = mysqli_fetch_array($nama);
    $isi = array(
      'server'      =>@$_SESSION['user'],
      'total_harga' =>@$_POST['total_tagihan'],
      'tanggal_beli'=>date('Ymd'),
      'nama_pembeli'=>$nama['nama_pembeli']
      );
    $data = $perintah->simpan($con,"tbl_transaksi",$isi,"admin_form.php?menu=transaksi");
  }
}

if (isset($_POST['tambah'])) {
    if ($_POST['jumlah']!=null && $_POST['nama_barang']) {
      $data = $perintah->tampilwhere($con,"tbl_barang","kd_barang='$nama_barang'");
      $cek = mysqli_fetch_array($data);
      if ($jumlah>$cek['stok_barang']) {
              $kd="ada";
       $msg ="Stok Kurang.. Stok saat ini =".$cek['stok_barang'];
      }else{
      $kd="ada";
      $isi = array(
        'kd_barang'   =>$nama_barang,
        'jumlah_beli' =>$jumlah,
        'sub_total'   =>$total,);
      $perintah->simpan($con,"tbl_tmp_transaksi",$isi,"");
      }
}else{
  ?>
  <script>alert("isi semya inputan")</script>
  <?php
}
}
if (isset($_POST['proses'])) {
    if ($_POST['total_tagihan']<=$_POST['bayar']) {
    $daa =mysqli_query($con,"select * from tbl_tmp_transaksi");
    $kode = $perintah->auto($con,"tbl_transaksi","kd_transaksi","KT");
    $num = mysqli_num_rows($daa);
    for ($i=0; $num >= $i ; $i++) { 
        $cek = $perintah->tampilwhere($con,"tbl_tmp_transaksi","kd_tmp='$i'");
    while ($data = mysqli_fetch_array($cek)) {
        $isi = array(
          'kd_transaksi' => $kode,
          'kd_barang'    =>$data['kd_barang'],
          'kd_user'      =>$_SESSION['user'],
          'jumlah'       =>$data['jumlah_beli'],
          'total_harga ' =>$data['sub_total'],
          'tanggal_beli' =>date('ymd'));
        $e = $perintah->simpan($con,"tbl_transaksi",$isi,"");
    }
    }
          mysqli_query($con,"truncate table tbl_tmp_transaksi");
    }else{
      $kd="ds";
      $msg = "Bayar kurang";
    }
}
if (isset($_POST['batal'])) {
      mysqli_query($con,"truncate table tbl_tmp_transaksi");
      ?>
      <script>window.location.href="admin_form.php?menu=transaksi"</script>
      <?php
 }

 ?>
<!-- start: content -->
            <div id="content">
                <div class="panel">
                  <div class="panel-body">
                      <div class="col-md-6 col-sm-12">
                        <h3 class="animated fadeInLeft">Customer Service</h3>
                        <p class="animated fadeInDown"><span class="fa  fa-map-marker"></span> Batavia,Indonesia</p>

                        <ul class="nav navbar-nav">
                            <li><a href="" >Impedit</a></li>
                            <li><a href="" class="active">Virtute</a></li>
                            <li><a href="">Euismod</a></li>
                            <li><a href="">Explicar</a></li>
                            <li><a href="">Rebum</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="col-md-6 col-sm-6 text-right" style="padding-left:10px;">
                          <h3 style="color:#DDDDDE;"><span class="fa  fa-map-marker"></span> Banyumas</h3>
                          <h1 style="margin-top: -10px;color: #ddd;">30<sup>o</sup></h1>
                        </div>
                        <div class="col-md-6 col-sm-6">
                           <div class="wheather">
                            <div class="stormy rainy animated pulse infinite">
                              <div class="shadow">
                                
                              </div>
                            </div>
                            <div class="sub-wheather">
                              <div class="thunder">
                                
                              </div>
                              <div class="rain">
                                  <div class="droplet droplet1"></div>
                                  <div class="droplet droplet2"></div>
                                  <div class="droplet droplet3"></div>
                                  <div class="droplet droplet4"></div>
                                  <div class="droplet droplet5"></div>
                                  <div class="droplet droplet6"></div>
                                </div>
                            </div>
                          </div>
                        </div>                   
                    </div>
                  </div>                    
                </div>

                <div class="col-md-12" style="padding:20px;">
                    <div class="col-md-12 padding-0">
                        <div class="col-md-8 padding-0">
                            <div class="col-md-12">
                                <div class="panel box-v4">
                                		
                                    <div class="panel-heading bg-white border-none">
                                      <h4>Transaksi</h4>
                                    </div>
                                    <div class="panel-body padding-0">
                                        <div class="col-md-12 col-xs-12 col-md-12 padding-0 box-v4-alert">
									<div class="form-group">
               	<form method="POST">
											<div class="form-group">
                        <p><?php if ($msg!=null) {
                          echo $msg;
                        } ?></p>
												<select class="form-control" name="merek" id="merek">
													<option value="">--Pilih Merek--</option>
													<?php  
													$daata = $perintah->tampil($con,"tbl_merek");
													while ($data = mysqli_fetch_array($daata)) {
														?>
														<option value="<?php echo $data['kd_merek'] ?>" <?php 
														if ($merek!=null) {
														 	if ($merek==$data['kd_merek']) {
															echo "selected";
														 	}
														 } ?>><?php echo $data['merek'] ?></option>
														<?php
													}
													?>
												</select>
											</div>
											<div class="form-group">
												<select class="form-control" name="nama_barang" id="nama_barang">
													<option value="">--Pilih Barang--</option>
													<?php  
													if ($merek!=null) {
														
													$daata = $perintah->tampilwhere($con,"tbl_barang","kd_merek='$merek'");
													while ($data = mysqli_fetch_array($daata)) {
														?>
														<option value="<?php echo $data['kd_barang'] ?>"><?php echo $data['nama_barang'] ?></option>
														<?php
													}
													}
													?>
												</select>
											</div>
											<div class="form-group">
												<input type="text" readonly="" class="form-control" name="harga_barang" placeholder="Harga Barang" id="harga_barang" >
											</div>
											<div class="form-group">
												<input type="number" class="form-control" name="jumlah" placeholder="Jumlah Barang" id="jumlah">
											</div>
                      <div class="form-group">
                        <input type="text" name="total" placeholder="Sub Total Harga" id="total" readonly="" value="" class="form-control">
                                      </div>
											<button name="reset" class="btn btn-danger pull-right" style="height: 40px;">Reset</button>
											<button class="btn btn-success pull-right" style="margin-right: 10px" name="tambah" >Tambah</button>
										<div class="clearfix"></div>
									</div>
                                 </div>
                                    </div>
                                </div> 
                                	</form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12 padding-0">
                              <div class="panel box-v2">
                                  <div class="panel-heading padding-0">
                                   	<h2>Total Harga</h2>
                                  </div>
                                  <div class="panel-body">
                                    <form method="POST">
                                      <div class="form-group">
                        <input type="text" readonly="" class="form-control" name="total_tagihan" id="total_tagihan" placeholder="Total Tagihan Barang" value="<?php if($kd!=null){$query = mysqli_query($con,"select sum(sub_total) as total from tbl_tmp_transaksi");$data = mysqli_fetch_array($query);echo $data['total'];} ?>">
                      </div>
                                    	<div class="form-group">
                                    		<input type="number" name="bayar" placeholder="Total Bayar" id="bayar" class="form-control">
                                    	</div>
                                    	<div class="form-group">
                                    		<input type="text" name="kembali" placeholder="Total Kembali" id="kembali" readonly="" class="form-control">
                                    	</div>
                                      
                                       <button class="btn btn-success" name="proses">Process</button>
                                    	 <button class="btn btn-danger" style="height: 40px" <?php if ($kd==null) {
                                        echo "disabled=''";
                                      } ?>onclick="return confirm('Are you sure?')" name="batal">Batal Transaksi</button>
                                  </div>
                              </div>
                            </div>
                    </div>
                </div>

        <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Data Transaksi</h3></div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                           <th>#</th>
                            <th style="width: 30%">Pelayan</th>
                            <th style="width: 20%">Total Harga</th>
                            <th>Tanggal Pembelian</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php   
                $no=0;
                $query = $perintah->tampil($con,"tbl_transaksi");
                while ($data = mysqli_fetch_assoc($query)) {
                  $no++;
                  if ($no%2==0) {
                    ?>
                  <tr class="active">
                    <td><p><?php echo $no ?></p></td>
                    <td><p ><?php echo $data['kd_user'] ?></p></td>
                    <td><?php echo $data['total_harga'] ?></td>
                    <td><?php echo $data['tanggal_beli'] ?></td>
                </tr>
                    <?php   
                  }else{
                    ?>
                    <tr class="success">
                     <td><p><?php echo $no ?></p></td>
                    <td><p ><?php echo $data['kd_user'] ?></p></td>
                    <td><?php echo $data['total_harga'] ?></td>
                    <td><?php echo $data['tanggal_beli'] ?></td>
                </tr>
                <?php
                  }
                }
                 ?>
                         </form>
                      </tbody>
                        </table>
                     <form id="fftgpelamar" method="POST" action="lap-data.php?data=transaksi">
                        <div class="col-md-12">
                        <a href="export.php?data=transaksi" class="btn btn-success">Export to Excel</a> 
                        <p>Dari</p>
                              <input type="date" class="form-control1" name="Dari" data-options="formatter:myformatter,parser:myparser" style="width:200px;height:25px">
                              <p>Sampai</p>
                              <input type="date" class="form-control1" name="Sampai" data-options="formatter:myformatter,parser:myparser" style="width:200px;height:25px">
              <input class="btn btn-success" type="submit" name="Submit"  value="Export To Pdf" >
                        </div>
                 </form>
                      </div>
                  </div>
                </div>
              </div>  
              </div>
            </div>
<script>
  $(document).ready(function(){

    $('#nama_barang').change(function(){
      var barang = $(this).val();
      $.ajax({
        type:"POST",
        url:'ajax_transaksi.php',
        data:{'selectData':$(this).val()},
        success: function(data){
          $("#harga_barang").val(data);
          $("#jumlah").val(data);
          var jum = $("#jumlah").val();
          var kali = data * jum;
          $("#total").val(kali);
        }
      })
    });
    $("#merek").change(function(){
      $.ajax({
        type:"POST",
        url:'ajax_barang.php',
        data:{'selectData':$(this).val()},
        dataType:'html',
        success: function(data){
          $("#nama_barang").html(data);
        },
        error:function(e){
          alert(e);
        }
      })
    });
    $("#jumlah").keyup(function(){
      var jumlah = $(this).val();
      var harga_barang = $("#harga_barang").val();
      var kali = harga_barang*jumlah;
      $("#total").val(kali);
    });
    $("#bayar").keyup(function(){
      var bayar = $(this).val();
      var total = $("#total_tagihan").val();
      var kembali = bayar - total;
      $("#kembali").val(kembali);
    })
  })
</script>
        <!--footer section end-->

      <!-- main content end-->
   </section>
<!-- start: Javascript -->
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/jquery.ui.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>



<!-- plugins -->
<script src="asset/js/plugins/moment.min.js"></script>
<script src="asset/js/plugins/jquery.datatables.min.js"></script>
<script src="asset/js/plugins/datatables.bootstrap.min.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>


<!-- custom -->
<script src="asset/js/main.js"></script>
<script type="asset/text/javascript">
  $(document).ready(function(){
    $('#datatables-example').DataTable();
  });
</script>
<!-- end: Javascript -->
</body>
</html>
<script src="asset/js/jquery.nicescroll.js"></script>
<script src="asset/js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="asset/js/bootstrap.min.js"></script>
</body>
</html>

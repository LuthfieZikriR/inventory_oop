<?php 

	@$aksi = $_GET['aksi'];
	@$id = $_GET['id'];
	@$where = "kd_barang='$id'";
	@$msg="";
	@$barang =$_POST['barang'];
	@$nama = $_POST['nama'];
	@$harga = $_POST['harga'];
	@$merek = $_POST['merek'];
	@$distributor = $_POST['distributor'];
	@$stok = $_POST['stok'];
	@$keterangan = $_POST['keterangan'];

	if (@$aski=="hapus") {
		# code...
		$perintah->hapus($con,"tbl_barang",$where,"admin_form.php?menu=barang");
	}
	if (isset($_POST['batal'])) {
		?>
		<script>
			window.location.href="admin_form.php?menu=barang";
		</script>
		<?php
	}
	if (isset($_POST['ubah'])) {
		if ($nama!=null && $merek!="--Pilih Merek--" && $distributor!="--Pilih Distributor--" && $harga!=null && $stok!=null && $_FILES['foto']['name']!=null && $keterangan!=null){

			$cek = $perintah->tampilwhere($con,"tbl_barang","nama_barang='$nama'");
			$cek = mysqli_num_rows($cek);
			if ($cek<1) {
				
				$foto = $_FILES['foto']['name'];
				$tmp = $_FILES['foto']['tmp_name'];
				$fotobaru = date('dmYHis').$foto;
				$path = "images/".$fotobaru;

				if (move_uploaded_file($tmp, $path)) {
					$isi = array(
						'nama_barang' => $nama,
						'kd_merek' => $merek,
						'kd_distributor' => $distributor,
						'tanggal_masuk' => date('y-m-d'),
						'harga_barang' => $harga,
						'stok_barang' => $stok,
						'gambar' => $fotobaru,
						'keterangan' => $keterangan
					);
					$perintah->ubah($con,"tbl_barang",$isi,$where,"admin_form.php?menu=barang");
				}
			} else {
				$msg = "Barang Sudah Ada!";
			}
				
		} else {
			$msg = "Isi Semua Inputan!";
			}
			
		}
	if (isset($_POST['tambah'])) {
		if ($nama!=null && $merek!="--Pilih Merek--" && $distributor!="--Pilh Distributor--" && $harga!=null && $stok!=null && $_FILES['foto']['name']!=null && $keterangan!=null) {
		$cek = $perintah->tampilwhere($con,"tbl_barang","nama_barang='$nama'");
		$cek =mysqli_num_rows($cek);
		if ($cek<1) {
			$foto = $_FILES['foto']['name'];
			$tmp = $_FILES['foto']['tmp_name'];
			$fotobaru = date('dmYHis').$foto;
			$path = "images/".$fotobaru;

			if(move_uploaded_file($tmp, $path)){
				$isi = array(
					'nama_barang' =>$nama,
					'kd_merek'=>$merek,
					'kd_distributor'=>$distributor,
					'tanggal_masuk'=>date('y-m-d'),
					'harga_barang'=>$harga,
					'stok_barang'=>$stok,
					'gambar'=>$fotobaru,
					'keterangan'=>$keterangan
					 );
				$perintah->simpan($con,"tbl_barang",$isi,"admin_form.php?menu=barang");
			}
		}else{
		$msg="Barang Sudah ada";
		}
	}else{
			$msg="Isi semua Inputan";
	}
	}
	
?>w

		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Tambah Barang</h1>
			</div>
		</div><!--/.row-->
				
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Advanced Table</div>
	<form method="post">
		<div class="form-group">
			<label for="nama_barang">Nama barang</label>
			<input type="text" name="nama_barang" value="" required class="form-control">
		</div>
		<div class="form-group">
			<label>Nama Merek</label><br>
			<select class="form-control1" name="merek">
							<option>--Pilih Merek--</option>
							<?php 
								$data = $perintah->tampil($con,"tbl_merek");
								while ($key=mysqli_fetch_array($data)) {
									?>
										<option value="<?php echo $key['kd_merek'] ?>" <?php
						if($aksi=="edit"){
							$data = mysqli_fetch_assoc($perintah->tampilwhere($con,"tbl_merek","kd_merek='$key[kd_merek]'"));
							if ($data['kd_merek']==$key['kd_merek']) {
								echo "selected";		
							}
						} 	
											 ?>><?php echo $key['merek'] ?></option>
									<?php
								}
							 ?>
						</select>
		</div>
		<div class="form-group">
			<label for="kd_distributor">Kode Distributor</label><br>
			<select class="form-control1" name="distributor">
							<option>--Pilih Distributor--</option>
							<?php 
								$data = $perintah->tampil($con,"tbl_distributor");
								while ($key=mysqli_fetch_array($data)) {
									?>
										<option value="<?php echo $key['kd_distributor'] ?>"<?php
						if($aksi=="edit"){
							$data = mysqli_fetch_assoc($perintah->tampilwhere($con,"tbl_distributor","kd_distributor='$key[kd_distributor]'"));
							if ($data['kd_distributor']==$key['kd_distributor']) {
								echo "selected";		
							}
						} 	
											 ?>><?php echo $key['nama_distributor'] ?></option>
									<?php
								}
							 ?>
						</select>
		</div>
		<div class="form-group">
			<label for="tgl_masuk">Tanggal Masuk</label>
			<input type="date" name="tgl_masuk" required class="form-control">
		</div>
		<div class="form-group">
			<label for="harga">Harga Barang</label>
			<input type="text" name="harga_barang" value="" required class="form-control">
		</div>		
		<div class="form-group">
			<label for="stok_barang">Stok barang  </label>
			<input type="text" name="stok_barang" value="" required class="form-control">
		</div>
		<div class="form-group">
			<label for="alamat">Gambar</label>
			<input type="file" name="gambar" class="form-control" >
		</div>
		<div class="input-group">
						<span class="input-group-addon">
						</span>
							<textarea name="keterangan" class="form-control1" style="margin-bottom: -6px"><?php 
						if($aksi=="edit"){
							$data = mysqli_fetch_assoc($perintah->tampilwhere($con,"tbl_barang",$where));
							echo $data['keterangan'];
						}
						 ?></textarea>
						</div><br>
						<?php 	
							if ($aksi=="edit") {
								?>
						<button class="btn btn-primary" style="margin-left: 10px" name="ubah">Update</button><button class="btn btn-danger" style="margin-left: 10px" name="batal">Batal</button>		<?php
							}else{
								?>
						<button class="btn btn-primary" style="margin-left: 10px" name="tambah">Tambah Barang</button>
						<?php
							}
						 ?>
				</div>
		</form>	
						<script>
						    $(function () {
						        $('#hover, #striped, #condensed').click(function () {
						            var classes = 'table';
						
						            if ($('#hover').prop('checked')) {
						                classes += ' table-hover';
						            }
						            if ($('#condensed').prop('checked')) {
						                classes += ' table-condensed';
						            }
						            $('#table-style').bootstrapTable('destroy')
						                .bootstrapTable({
						                    classes: classes,
						                    striped: $('#striped').prop('checked')
						                });
						        });
						    });
						
						    function rowStyle(row, index) {
						        var classes = ['active', 'success', 'info', 'warning', 'danger'];
						
						        if (index % 2 === 0 && index / 2 < classes.length) {
						            return {
						                classes: classes[index / 2]
						            };
						        }
						        return {};
						    }
						</script>
					</div>
				</div>
			</div>
		</div><!--/.row-->	
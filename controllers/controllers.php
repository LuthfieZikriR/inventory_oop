<?php 
    class oop
    {
        function simpan($con, $table, array $field)
        {
        $sql = "INSERT INTO $table SET";
        foreach ($field as $key => $value) {
            $sql.=" $key = '$value',";
        }
        $sql = rtrim($sql, ',');
        $query = mysqli_query($con, $sql);
    
        }
        
        function hapus($con, $table, $where, $redirect){
            $sql = "DELETE FROM $table WHERE $where";
            $query = mysqli_query($con, $sql);
            if ($query){
                echo "<script>alert('Succes');document.location.href='$redirect'</script>";
            } else {
                echo $sql.mysqli_error($con);
            }
        }

        function tampilwhere($con, $table, $where){
            $sql = "SELECT * FROM $table WHERE $where";
            $query = mysqli_query($con, $sql);
            if ($query) {
            return $query;
            }else{
                echo $sql." ".mysqli_error($con);
            }
        }
        function tampil($con, $table){
            $sql = "SELECT * FROM $table";
            $query = mysqli_query($con, $sql);
            return $query;
        }

        function ubah($con, $table, array $field, $where, $redirect){
            $sql = "UPDATE $table SET";
            foreach ($field as $key => $value) {
                $sql.=" $key = '$value',";
            }
            $sql = rtrim($sql, ',');
            $sql.=" WHERE $where";
            $query = mysqli_query($con, $sql);
            if ($query){
                echo "<script>alert('Succes');document.location.href='$redirect'</script>";
            } else {
                echo $sql.mysqli_error($con);
            }
        }

        function upload($foto, $folder){
            $tmp = $foto['tmp_name'];
            $namafile = date('y-m-d H:i:s').$foto;
            move_uploaded_file($tmp, "$folder/$namafile");
            return $namafile;
        }
        

        function login($con, $table, $username, $password,$level, $redirect){
            @session_start();
            $sql = "SELECT * FROM $table WHERE username = '$username' and password = '$password' and level ='$level'";
            $query = mysqli_query($con, $sql);
            $tampil = mysqli_fetch_array($query);
            $cek = mysqli_num_rows($query);
            if ($cek > 0) {
                $_SESSION['user'] = $username;
                echo "<script>alert('Succes');document.location.href='$redirect'</script>";
            } else              echo "<script>alert('Login gagal cek username dan password !!')</script>";
            }
        function logout(){
            @session_destroy();
            echo "<script>alert('keluar');window.location.href='index.php'</script>";
        }
        function auto($con,$table,$field,$pre){
            $sql       = "select count($field) as jumlah from $table";
            $query     = mysqli_query($con,$sql);
            $number    = mysqli_fetch_array($query);
            if ($number['jumlah']>0) {
                $sql   = "select max($field) as kode from $table";
                $query =mysqli_query($con,$sql);
                $number=mysqli_fetch_array($query);
                $strnum=substr($number['kode'], 2,3);
                $strnum =$strnum+1;
                if (strlen($strnum)==3) {
                    $kode = $pre.$strnum;
                }elseif(strlen($strnum)==2){
                    $kode = $pre."0".$strnum;
                }elseif(strlen($strnum)==1){
                    $kode = $pre."00".$strnum;
                }
            }else{
                $kode=$pre."001";
            }
            return $kode;
        }
    

        }
 ?>



<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");

    $temp = "upload/";
    if (!file_exists($temp)){
        mkdir($temp);
    }

    

    $kategori = $_POST['kategori'];
    $start_date = strtotime($_POST['start_date']);
    $fixstart_date = date("d-m-Y", $start_date);
    $last_date = strtotime($_POST['last_date']);
    $fixlast_date = date("d-m-Y", $last_date);
    $keterangan = $_POST['keterangan'];
    $notelp = $_POST['notelp'];
    date_default_timezone_set('Asia/Jakarta');
    $date = date("d-m-Y H:i:s");
    // $images = $_POST['images'];

    if($kategori == 'cuti'){
        $NewImageName = "";
    }else{
        $fileupload      = $_FILES['images']['tmp_name'];
        $ImageName       = $_FILES['images']['name'];
        $ImageType       = $_FILES['images']['type'];

        if(!empty($fileupload)){
            $acak           = rand(11111111, 99999999);
            $ImageExt       = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt       = str_replace('.','',$ImageExt); // Extension
            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName   = str_replace(' ', '', $acak.'.'.$ImageExt);
            move_uploaded_file($_FILES["images"]["tmp_name"], $temp.$NewImageName);
        }
    }
    // if($images != ""){
    //     $folderPath = "upload/";
    //     $image_parts = explode(";base64,", $images);
    //     $image_type_aux = explode("image/", $image_parts[0]);
    //     $image_type = $image_type_aux[1];
    
    //     $image_base64 = base64_decode($image_parts[1]);
    //     $fileName = uniqid() . '.png';

    //     $file = $folderPath . $fileName;
    //     file_put_contents($file, $image_base64);
    // }

    $hariawal = date("d", $start_date) * 1;
    $bulanawal = date("m", $start_date) * 30.4167;
    $tahunawal = date("Y", $start_date) * 365.25;
    $totalawal = $hariawal + $bulanawal + $tahunawal;

    $hariakhir = date("d", $last_date) * 1;
    $bulanakhir = date("m", $last_date) * 30.4167;
    $tahunakhir= date("Y", $last_date) * 365.25;
    $totalakhir = $hariakhir + $bulanakhir + $tahunakhir;

    if($totalawal > $totalakhir){
        $hasil = "Tanggal yang diinputkan tidak valid";
    }else{
        if($kategori == "terlambat"){
            $fixstart_date = date("d-m-Y");
        }

        if($kategori == "cuti")
        {
            $status = "proses";
            $fileName = "";
        }else{
            $status = "";
        }
        
        $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelp'");
        $cekuser = mysqli_fetch_assoc($user);
        if ($cekuser > 0) {
            $id_users = $cekuser['id'];
            $pengajuan = mysqli_query($con, "INSERT INTO pengajuan VALUES(null,'$id_users','$keterangan','$NewImageName','$fixstart_date','$fixlast_date','$date','$kategori','$status')");
            $hasil = "Proses pengajuan telah berhasil";
        }else{
            $hasil = "Proses pengajuan gagal";
        }
    }

    
    
    echo $hasil;
?>
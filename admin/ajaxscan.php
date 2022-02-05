<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    $notelp = $_POST['notelp'];
    date_default_timezone_set('Asia/Jakarta');
    $time = date("H:i:s");
    $date = date("d-m-Y");

    $menit = date("i") * 60;
    $jam = date("H") * 3600;
    $totalnow = $jam + $menit;

    $maxmenit = 30 * 60;
    $maxjam = 8 * 3600;
    $totalmax = $maxjam + $maxmenit;

    // $menitmasuksiang = 30 * 60;
    // $jammasuksiang = 12 * 3600;
    // $totalmasuksiang = 


    
    $user = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp='$notelp'");
    $cekuser = mysqli_fetch_assoc($user);
    if ($cekuser > 0) {
        $id_users = $cekuser['id'];
        if($totalnow > $totalmax){
            $pengajuan = mysqli_query($con, "SELECT * FROM pengajuan WHERE id_users ='$id_users' AND tanggal_awal = '$date' AND kategori = 'Terlambat'");
            $cekpengajuan = mysqli_fetch_assoc($pengajuan);
            if($cekpengajuan > 0){
                $status = "Izin";
            }else{
                $status = "Terlambat";
            }
            
        }else if($totalnow <= $totalmax){
            $status = "Tepat Waktu";
        }
        $absen = mysqli_query($con, "SELECT COUNT(*) as total FROM absensi WHERE id_users = '$id_users' AND tanggal = '$date'");
        $cekabsen = mysqli_fetch_assoc($absen);
        $jumlahabsen = $cekabsen['total'];
        if($jumlahabsen == 1){
            $keterangan = "Keluar Istirahat"; 
            $absensi = mysqli_query($con, "INSERT INTO absensi VALUES(null,'$id_users','$date','$time','-','$keterangan')");
            $hasil = "Absensi sukses";
        }else if($jumlahabsen == 2){  
            $keterangan = "Masuk Setelah Istirahat";
            $absensi = mysqli_query($con, "INSERT INTO absensi VALUES(null,'$id_users','$date','$time','-','$keterangan')");
            $hasil = "Absensi sukses";
        }else if($jumlahabsen == 0){
            $keterangan = "Masuk Pagi"; 
            $absensi = mysqli_query($con, "INSERT INTO absensi VALUES(null,'$id_users','$date','$time','$status','$keterangan')");
            $hasil = "Absensi sukses";
        }else if($jumlahabsen == 3){
            $hasil = "Absensi Melebihi Batas per Hari";
        }
    }else{
        $hasil = "Absensi gagal";
    }
    
    echo $hasil;
?>
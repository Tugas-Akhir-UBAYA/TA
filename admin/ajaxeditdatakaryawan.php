<?php
    $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
    date_default_timezone_set('Asia/Jakarta');
    $id_users = $_POST['id_users'];
    $idusers = $_POST['idusers'];
    $jabatan = $_POST['jabatan'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $notelp = $_POST['notelp'];
    $alamat_tinggal = $_POST['alamat_tinggal'];
    $tgl_awal = strtotime($_POST['tgl_awal']);
    $fixtanggal_awal = date("d-m-Y", $tgl_awal);
    $norek = $_POST['norek'];
    $gaji = $_POST['gaji'];
    $kerja = $_POST['kerja'];
    $akses_kamera = $_POST['akses_kamera'];
    $fixgaji = preg_replace("/[^0-9]/", "", $gaji);
    $datenow = date("d-m-Y");
    $bpjsketenagakerjaan = $_POST['bpjsketenagakerjaan'];
    $bpjskesehatan = $_POST['bpjskesehatan'];
    if($bpjskesehatan != 0 || $bpjsketenagakerjaan != 0){
        $bpjs = 1;
    }else{
        $bpjs = 0;
    }
    
    $users = mysqli_query($con, "SELECT * FROM users WHERE id ='$id_users'");
    $cekusers = mysqli_fetch_assoc($users);
    if ($cekusers > 0) {
        $jabatans = $cekusers['jabatan'];
        $gajis = $cekusers['gaji_pokok'];
        $notelps = mysqli_query($con, "SELECT * FROM users WHERE id != '$id_users' AND  nomor_telp ='$notelp'");
        $ceknotelp = mysqli_fetch_assoc($notelps);
        if($ceknotelp > 0){
            $hasil = "Nomor Telepon Sudah di Gunakan";
        }else{
            $niks = mysqli_query($con, "SELECT * FROM users WHERE id != '$id_users' AND nik ='$nik'");
            $ceknik = mysqli_fetch_assoc($niks);
            if($ceknik > 0){
                $hasil = "NIK Sudah di Gunakan";
            }else{
                $nomor_rekenings = mysqli_query($con, "SELECT * FROM users WHERE id != '$id_users' AND nomor_rekening ='$norek'");
                $ceknorek = mysqli_fetch_assoc($nomor_rekenings);
                if($ceknorek > 0){
                    $hasil = "No. Rekening Sudah di Gunakan";
                }else{
                    $cookies = mysqli_query($con, "SELECT * FROM cookies WHERE id_users = '$id_users' AND nomor_telepon != ''");
                    $cekcookies = mysqli_fetch_assoc($cookies);
                    if($cekcookies > 0){
                        $nomor_telepons = $cekcookies['nomor_telepon'];
                        if($nomor_telepons != $notelp){
                            $updatecookies = mysqli_query($con, "UPDATE cookies SET nomor_telepon = '', time = 0 WHERE id_users ='$id_users'");
                            $updatestatus = mysqli_query($con, "UPDATE users SET status = 0 WHERE id ='$id_users'");

                        }
                    }

                    if($bpjskesehatan != 0){
                        $bpjskesehatans  = mysqli_query($con, "SELECT * FROM bpjs WHERE nama_bpjs = 'BPJS Kesehatan'");
                        $cekbpjskesehatans = mysqli_fetch_assoc($bpjskesehatans );
                        if($cekbpjskesehatans > 0){
                            $id_bpjskesehatan = $cekbpjskesehatans['id'];
                            $detail_bpjskesehatan  = mysqli_query($con, "SELECT * FROM detail_bpjs WHERE id_bpjs = '$id_bpjskesehatan' AND id_users = '$id_users'");
                            $cekdetail_bpjskesehatan = mysqli_fetch_assoc($detail_bpjskesehatan );
                            if($cekdetail_bpjskesehatan > 0){
                                $updatebpjskesehatan = "";
                            }else{
                                $tambahbpjskesehatan = mysqli_query($con, "INSERT INTO detail_bpjs VALUES(null,'$id_bpjskesehatan','$id_users')");
                            }
                        }
                    }else{
                        $bpjskesehatans  = mysqli_query($con, "SELECT * FROM bpjs WHERE nama_bpjs = 'BPJS Kesehatan'");
                        $cekbpjskesehatans = mysqli_fetch_assoc($bpjskesehatans );
                        if($cekbpjskesehatans > 0){
                            $id_bpjskesehatan = $cekbpjskesehatans['id'];
                            $detail_bpjskesehatan  = mysqli_query($con, "SELECT * FROM detail_bpjs WHERE id_bpjs = '$id_bpjskesehatan' AND id_users = '$id_users'");
                            $cekdetail_bpjskesehatan = mysqli_fetch_assoc($detail_bpjskesehatan );
                            if($cekdetail_bpjskesehatan > 0){
                                $hapusbpjskesehatan = mysqli_query($con, "DELETE FROM detail_bpjs WHERE id_bpjs = '$id_bpjskesehatan' AND id_users = '$id_users'");
                            }
                        }
                    }

                    if($bpjsketenagakerjaan != 0){
                        $bpjsketenagakerjaans  = mysqli_query($con, "SELECT * FROM bpjs WHERE nama_bpjs = 'BPJS Ketenagakerjaan'");
                        $cekbpjsketenagakerjaans = mysqli_fetch_assoc($bpjsketenagakerjaans );
                        if($cekbpjsketenagakerjaans > 0){
                            $id_bpjsketenagakerjaan = $cekbpjsketenagakerjaans['id'];
                            $detail_bpjsketenagakerjaan  = mysqli_query($con, "SELECT * FROM detail_bpjs WHERE id_bpjs = '$id_bpjsketenagakerjaan' AND id_users = '$id_users'");
                            $cekdetail_bpjsketenagakerjaan = mysqli_fetch_assoc($detail_bpjsketenagakerjaan );
                            if($cekdetail_bpjsketenagakerjaan > 0){
                                $updatebpjsketenagakerjaan = "";
                            }else{
                                $tambahbpjsketenagakerjaan = mysqli_query($con, "INSERT INTO detail_bpjs VALUES(null,'$id_bpjsketenagakerjaan','$id_users')");
                            }
                            
                        }
                    }else{
                        $bpjsketenagakerjaans  = mysqli_query($con, "SELECT * FROM bpjs WHERE nama_bpjs = 'BPJS Ketenagakerjaan'");
                        $cekbpjsketenagakerjaans = mysqli_fetch_assoc($bpjsketenagakerjaans );
                        if($cekbpjsketenagakerjaans > 0){
                            $id_bpjsketenagakerjaan = $cekbpjsketenagakerjaans['id'];
                            $detail_bpjsketenagakerjaan  = mysqli_query($con, "SELECT * FROM detail_bpjs WHERE id_bpjs = '$id_bpjsketenagakerjaan' AND id_users = '$id_users'");
                            $cekdetail_bpjsketenagakerjaan = mysqli_fetch_assoc($detail_bpjsketenagakerjaan );
                            if($cekdetail_bpjsketenagakerjaan > 0){
                                $hapusbpjskesehatan = mysqli_query($con, "DELETE FROM detail_bpjs WHERE id_bpjs = '$id_bpjsketenagakerjaan' AND id_users = '$id_users'");
                            }
                        }
                    }

                    if($kerja == 0){
                        $updatecookiess = mysqli_query($con, "UPDATE cookies SET nomor_telepon = '', time = 0 WHERE id_users ='$id_users'");
                        $updatestatuss = mysqli_query($con, "UPDATE users SET status = 0 WHERE id ='$id_users'");
                    }

                    if($jabatan != $jabatans){
                        $updatecookiesss = mysqli_query($con, "UPDATE cookies SET nomor_telepon = '', time = 0 WHERE id_users ='$id_users'");
                        $updatestatusss = mysqli_query($con, "UPDATE users SET status = 0 WHERE id ='$id_users'");
                    }

                    if($fixgaji != $gajis){
                        $gajipokokdetail = mysqli_query($con, "SELECT * FROM gaji_pokok_detail WHERE id_users = '$id_users' AND  tanggal_input = '$datenow'");
                        $cekgajipokokdetail = mysqli_fetch_assoc($gajipokokdetail);
                        if($cekgajipokokdetail > 0){
                            $gaji_sebelumnya = $cekgajipokokdetail['gaji_sebelumnya'];
                            $selisih = intval($fixgaji) - intval($gaji_sebelumnya);
                            $updategajipokokdetail = mysqli_query($con, "UPDATE gaji_pokok_detail SET id_pengedit = $idusers, gaji_sekarang = '$fixgaji', selisih = '$selisih' WHERE id_users = '$id_users' AND  tanggal_input = '$datenow'");
                        }else{
                            $selisih = $fixgaji - $gajis;
                            $addgajipokokdetail = mysqli_query($con, "INSERT INTO gaji_pokok_detail VALUES(null,$id_users,'$gajis','$selisih','$fixgaji','$idusers','$datenow')");
                        }
                    }
                    $update = mysqli_query($con, "UPDATE users SET nama = '$nama', nomor_telp = '$notelp', nik = '$nik', jabatan = $jabatan, tgl_awalkerja = '$fixtanggal_awal', nomor_rekening = '$norek', alamat_tinggal = '$alamat_tinggal', status_bpjs = $bpjs, status_kerja = $kerja, akses_kamera = $akses_kamera, gaji_pokok = '$fixgaji' WHERE id ='$id_users'");
                    $hasil = "Data Karyawan Berhasil di Ubah";
                }
            }
        }
    }else{
        $hasil = "Gagal Mengubah Data Karyawan";
    }
    
    echo $hasil;
?>
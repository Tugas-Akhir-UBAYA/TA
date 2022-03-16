<?php
    $notelp = $_POST['notelp'];
    $pencatat = $_POST['pencatat'];
    $hasil = '';
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
    if(isset($notelp)){
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $users = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp = '$notelp'");
        
        date_default_timezone_set('Asia/Jakarta');
        $bulan = date("F Y");
        $datenow = date("m-Y");
        if (mysqli_num_rows($users) > 0) {
            while ($data = mysqli_fetch_array($users)) {
                $id = $data['id'];
                $nik = $data['nik'];
                $nomor_telp = $data['nomor_telp'];
                $nama = $data['nama'];
                $jabatan = $data['jabatan'];
                if($jabatan == 1){
                    $fixjabatan = "Admin";
                }else if($jabatan == 0){
                    $fixjabatan = "Karyawan";
                }
                $status = $data['status'];
                $tgl_awalkerja = strtotime($data['tgl_awalkerja']);
                $fixtgl_awalkerja = date("d M Y", $tgl_awalkerja);
                $nomor_rekening = $data['nomor_rekening'];
                $alamat_tinggal = $data['alamat_tinggal'];
                $gaji_pokok = $data['gaji_pokok'];
                $status_bpjs = $data['status_bpjs'];
                $status_kerja = $data['status_kerja'];
                $akses_kamera = $data['akses_kamera'];
                if($status_bpjs == 1){
                    $fixbpjs = "Aktif";
                }else if($status_bpjs == 0){
                    $fixbpjs = "Tidak Aktif";
                }

                $absensi_detail = mysqli_query($con, "SELECT SUM(denda) AS denda FROM detail_absensi_terlambat WHERE id_users = $id AND tanggal_input LIKE '%$datenow%'");
                $cekabsensi_detail = mysqli_fetch_assoc($absensi_detail);
                if($cekabsensi_detail > 0){
                    $denda = $cekabsensi_detail['denda'];
                }else{
                    $denda = 0;
                }

                $absensi_detail = mysqli_query($con, "SELECT SUM(denda) AS denda FROM detail_absensi_terlambat WHERE id_users = $id AND tanggal_input LIKE '%$datenow%'");
                $cekabsensi_detail = mysqli_fetch_assoc($absensi_detail);
                if($cekabsensi_detail > 0){
                    $denda = $cekabsensi_detail['denda'];
                }else{
                    $denda = 0;
                }

                $bpjsketenagakerjaan = 0;
                $bpjskesehatan = 0;
                $detail_bpjs = mysqli_query($con, "SELECT * FROM detail_bpjs as db INNER JOIN bpjs as b ON db.id_bpjs = b.id  WHERE db.id_users = '$id'");
                if (mysqli_num_rows($detail_bpjs) > 0) {
                    while ($datas = mysqli_fetch_array($detail_bpjs)) {
                        $id_bpjs = $datas['id_bpjs'];
                        $nama_bpjs = $datas['nama_bpjs'];
                        $nominal = $datas['nominal'];
                        if($nama_bpjs == 'BPJS Ketenagakerjaan'){
                            $bpjsketenagakerjaan = $nominal;
                        }else if($nama_bpjs == 'BPJS Kesehatan'){
                            $bpjskesehatan = $nominal;
                        }
                    }
                }

                $totalbpjs = intval($bpjskesehatan) + intval($bpjsketenagakerjaan);

                $gaji_pokok = $data['gaji_pokok'];
                $totalgaji = intval($gaji_pokok) - intval($denda) - $totalbpjs;
            }
            $hasil .= '<div>
                            <input type="text" class="form-control id_users" id="id_users" hidden name="id_users" style="font-size: 12px;" value="'. $id.'" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">NIK</label><div class="form-control nik" id="nik" name="nik" style="font-size: 12px;" readonly>' . $nik . '</div> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama</label><div class="form-control nama" id="nama" name="nama" style="font-size: 12px;" readonly>' . $nama . '</div> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Telepon</label><div class="form-control no_telp" id="no_telp" name="no_telp" style="font-size: 12px;" readonly>' . $nomor_telp . '</div> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Rekening</label><div class="form-control no_rekening" id="no_rekening" name="no_rekening" style="font-size: 12px;" readonly>' . $nomor_rekening . '</div> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="form-label" style="font-size: 14px;">BPJS Ketenagakerjaan</label>
                                        <div name="bpjs_ketenagakerjaan" id="bpjs_ketenagakerjaan" class="form-control bpjs_ketenagakerjaan" style="font-size: 12px;" readonly>' . rupiah($bpjsketenagakerjaan) . '</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                    <label class="form-label" style="font-size: 14px;">BPJS Kesehatan</label>
                                    <div name="bpjs_kesehatan" id="bpjs_kesehatan" class="form-control bpjs_kesehatan" style="font-size: 12px;" readonly>' . rupiah($bpjskesehatan) . '</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 alamat">
                                <label class="form-label" style="font-size: 14px;">Alamat Tinggal</label>
                                <div class="form-control alamat_tinggal" id="alamat_tinggal" style="font-size: 12px;"readonly>' . $alamat_tinggal . '</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="form-label" style="font-size: 14px;">Gaji Pokok</label>
                                        <div name="gaji_pokok" id="gaji_pokok" class="form-control gaji_pokok" style="font-size: 12px;" readonly>' . rupiah($gaji_pokok) . '</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                    <label class="form-label" style="font-size: 14px;">Total Denda</label>
                                    <div name="total_denda" id="total_denda" class="form-control total_denda" style="font-size: 12px;" readonly>' . rupiah($denda) . '</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 totalgaji">
                                <label class="form-label" style="font-size: 14px;"><b>Total Gaji Bulan '.$bulan.'</b></label>
                                <div class="form-control total_gaji" id="total_gaji" name="total_gaji" style="font-size: 12px;" readonly>' . rupiah($totalgaji) . '</div> 
                            </div>
                            <hr>
                            <h5>Histori Absensi Terlambat</h5>
                            <table id="table" class="table table-striped table-bordered" style="width:100%">
                                <thead style="font-size: 14px;">
                                    <tr style="text-align: center;">
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Durasi Terlambat</th>
                                        <th>Denda</th>
                                    </tr>
                                </thead>
                            
                            <tbody style="font-size: 12px;">';
                            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
                            date_default_timezone_set('Asia/Jakarta');
                            $datenow = date("m-Y");
                            $detail_absensi = mysqli_query($con, "SELECT * FROM `detail_absensi_terlambat` AS det INNER JOIN absensi AS ab ON det.`id_absensi` = ab.`id` WHERE det.`id_users` = $id AND tanggal_input LIKE '%$datenow%'");
                            if (mysqli_num_rows($detail_absensi) > 0) {
                                $row = 1;
                                while ($data = $detail_absensi->fetch_assoc()) {
                                    $id_users = $data['id_users'];
                                    $tanggal_input =  $data['tanggal_input'];
                                    $waktu =  $data['waktu'];
                                    $terlambat =  $data['terlambat'];
                                    $denda =  $data['denda'];
                            
                                    
            $hasil .= '
            <tr style="" >
                <td style="text-align: center;"><b>'.$row++.'</b></td>
                <td>'.$tanggal_input.'</td>
                <td>'.$waktu.'</td>
                <td>'.$terlambat.' Menit</td>
                <td>'.rupiah($denda).'</td>
            </tr>
            
            <input class="notelp" hidden value="<?php echo $notelp ?>">
                </div>';
            }}else{
                $hasil .= '
                <tr style="" >
                    <td style="text-align: center;" colspan=5 ><b>Data Terlambat Bulan Ini Tidak Ada</b></td>
                </tr>
                </table>
                ';
            }
        }
    }

echo $hasil;
?>
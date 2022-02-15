<?php
    $notelp = $_POST['notelp'];
    $hasil = '';
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
    if(isset($notelp)){
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $users = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp = '$notelp'");
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

                if($status_kerja == 1){
                    $fixkerja = "Aktif";
                }else if($status_kerja == 0){
                    $fixkerja = "Tidak Aktif";
                }

                if($akses_kamera == 1){
                    $fixkamera = "Aktif";
                }else if($akses_kamera == 0){
                    $fixkamera = "Tidak Aktif";
                }
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
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Awal Mulai Kerja</label><div class="form-control tgl_awal" id="tgl_awal" name="tgl_awal" style="font-size: 12px;" readonly>' . $fixtgl_awalkerja . '</div></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Rekening</label><div class="form-control no_rekening" id="no_rekening" name="no_rekening" style="font-size: 12px;" readonly>' . $nomor_rekening . '</div> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Gaji Pokok</label><div class="form-control gaji" id="gaji" name="gaji" style="font-size: 12px;" readonly>' . rupiah($gaji_pokok) . '</div> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Telepon</label><div class="form-control no_telp" id="no_telp" name="no_telp" style="font-size: 12px;" readonly>' . $nomor_telp . '</div> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="form-label" style="font-size: 14px;">Jabatan</label>
                                        <div name="jabatan" id="jabatan" class="form-control jabatan" style="font-size: 12px;" readonly>' . $fixjabatan . '</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="form-label" style="font-size: 14px;">Status BPJS</label>
                                        <div name="bpjs" id="bpjs" class="form-control bpjs" style="font-size: 12px;" readonly>' . $fixbpjs . '</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                    <label class="form-label" style="font-size: 14px;">Status Kerja</label>
                                    <div class="form-control statuskerja" id="statuskerja" style="font-size: 12px;"readonly>' . $fixkerja . '</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="form-label" style="font-size: 14px;">Akses Kamera</label>
                                        <div name="kamera" id="kamera" class="form-control kamera" style="font-size: 12px;" readonly>' . $fixkamera . '</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 alamat">
                                <label class="form-label" style="font-size: 14px;">Alamat Tinggal</label>
                                <div class="form-control alamat_tinggal" id="alamat_tinggal" style="font-size: 12px;"readonly>' . $alamat_tinggal . '</div>
                            </div>
                            <input class="notelp" hidden value="<?php echo $notelp ?>">
                        </div>';
        }
    }

echo $hasil;
?>
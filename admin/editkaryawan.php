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
                $status = $data['status'];
                $tgl_awalkerja = strtotime($data['tgl_awalkerja']);
                $fixtgl_awalkerja = date("Y-m-d", $tgl_awalkerja);
                $nomor_rekening = $data['nomor_rekening'];
                $alamat_tinggal = $data['alamat_tinggal'];
                $gaji_pokok = $data['gaji_pokok'];
                $status_bpjs = $data['status_bpjs'];
                $status_kerja = $data['status_kerja'];

                if($jabatan == 1){
                    $jabatantext = "Admin";
                    $jabatanlain = 0;
                    $jabatanlaintext = "Karyawan";
                }else if($jabatan == 0){
                    $jabatantext = "Karyawan";
                    $jabatanlain = 1;
                    $jabatanlaintext = "Admin";
                }
                
                if($status_bpjs == 1){
                    $status_bpjstext = "Aktif";
                    $status_bpjslain = 0;
                    $status_bpjslainetext = "Tidak Aktif";
                }else if($status_bpjs == 0){
                    $status_bpjstext = "Tidak Aktif";
                    $status_bpjslain = 1;
                    $status_bpjslainetext = "Aktif"; 
                }

                if($status_kerja == 1){
                    $status_kerjatext = "Aktif";
                    $status_kerjalain = 0;
                    $status_kerjalainetext = "Tidak Aktif";
                }else if($status_kerja == 0){
                    $status_kerjatext = "Tidak Aktif";
                    $status_kerjalain = 1;
                    $status_kerjalainetext = "Aktif"; 
                }

            }
            $hasil .= '<div> 
                            <input type="text" class="form-control id_users" id="id_users" hidden name="id_users" style="font-size: 12px;" value="'. $id.'" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">NIK<span class="text-danger">*</span> </label> <input type="text" class="form-control nik" id="nik" onkeypress="return hanyaAngka(event)" name="nik" style="font-size: 12px;" value="'. $nik.'" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama<span class="text-danger">*</span> </label> <input type="text" class="form-control nama" id="nama" name="nama" style="font-size: 12px;" value="'. $nama.'" /> </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Awal Mulai Kerja<span class="text-danger">*</span> </label> <input type="date" class="form-control tgl_awal" id="tgl_awal" name="tgl_awal" style="font-size: 12px;" value="'. $fixtgl_awalkerja.'" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Rekening<span class="text-danger">*</span> </label> <input type="text" class="form-control no_rekening" id="no_rekening" name="no_rekening" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" value="'. $nomor_rekening.'" /> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Gaji Pokok<span class="text-danger">*</span> </label> <input type="text" class="form-control gaji" id="gaji" name="gaji" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" value="'. rupiah($gaji_pokok).'" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Telepon<span class="text-danger">*</span> </label> <input type="text" class="form-control no_telp" id="no_telp" name="no_telp" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" value="'. $nomor_telp.'" /> </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="form-label" style="font-size: 14px;">Jabatan<span class="text-danger">*</span></label>
                                        <select name="jabatan" id="jabatan" class="form-control jabatan" style="font-size: 12px;" >
                                            <option value="'.$jabatan.'">'.$jabatantext.'</option>
                                            <option value="'.$jabatanlain.'">'.$jabatanlaintext.'</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="form-label" style="font-size: 14px;">Status BPJS<span class="text-danger">*</span></label> 
                                        <select name="bpjs" id="bpjs" class="form-control bpjs" style="font-size: 12px;">
                                            <option value="'.$status_bpjs.'">'.$status_bpjstext.'</option>
                                            <option value="'.$status_bpjslain.'">'.$status_bpjslainetext.'</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 alamat">
                                <div class="form-group"> 
                                    <label class="form-label" style="font-size: 14px;">Status Kerja<span class="text-danger">*</span></label> 
                                    <select name="kerja" id="kerja" class="form-control kerja" style="font-size: 12px;">
                                        <option value="'.$status_kerja.'">'.$status_kerjatext.'</option>
                                        <option value="'.$status_kerjalain.'">'.$status_kerjalainetext.'</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 alamat">
                                <label class="form-label" style="font-size: 14px;">Alamat Tinggal<span class="text-danger">*</span></label>
                                <textarea class="form-control alamat_tinggal" id="alamat_tinggal" style="font-size: 12px;">'. $alamat_tinggal.'</textarea>
                            </div>
                            <div class="modal-footer d-block">
                                <button type="submit" class="btn float-right blues ubah" style="font-size: 14px;">Edit</button>
                            </div>
                            <input class="notelp" hidden value="<?php echo $notelp ?>">
                        </div>';
        }
    }

echo $hasil;
?>
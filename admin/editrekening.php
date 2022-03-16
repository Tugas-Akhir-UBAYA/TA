<?php
    $id_rekening = $_POST['id_rekening'];
    $notelp = $_POST['notelp'];
    $hasil = '';
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
    if(isset($notelp)){
        if(isset($id_rekening)){
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $rekening = mysqli_query($con, "SELECT * FROM rekening WHERE id = '$id_rekening'");
            if (mysqli_num_rows($rekening) > 0) {
                while ($data = mysqli_fetch_array($rekening)) {
                    $id = $data['id'];
                    $nama_bank = $data['nama_bank'];
                    $atas_nama = $data['atas_nama'];
                    $no_rekening = $data['no_rekening'];
                    date_default_timezone_set('Asia/Jakarta');
                    $datenow = date("d-m-Y");
                    $users = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp = '$notelp'");
                    if (mysqli_num_rows($users) > 0) {
                        while ($datas = mysqli_fetch_array($users)) {
                            $id_user = $datas['id'];
                        }
                    }
                    $hasil .= '<div> 
                                <input type="text" class="form-control id_users" id="id_users" hidden name="id_users" style="font-size: 12px;" value="'. $id_user.'" />
                                <input type="text" class="form-control tgl_input" id="tgl_input" hidden name="tgl_input" style="font-size: 12px;" value="'. $datenow.'" />
                                <input type="text" class="form-control id_rekening" id="id_rekening" hidden name="id_rekening" style="font-size: 12px;" value="'. $id.'" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama Bank</label> <input type="text" class="form-control nama_bank" id="nama_bank" name="nama_bank" style="font-size: 12px;" value="'. $nama_bank.'" disabled readonly/> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Atas Nama<span class="text-danger">*</span> </label> <input type="text" class="form-control atas_nama" id="atas_nama" name="atas_nama" style="font-size: 12px;" value="'. $atas_nama.'" /> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Rekening<span class="text-danger">*</span> </label> <input type="text" class="form-control no_rekening" id="no_rekening" name="no_rekening" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" value="'. $no_rekening.'" /> </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-block">
                                    <button type="submit" class="btn float-right blues ubah" style="font-size: 14px;">Edit</button>
                                </div>
                            </div>';

                }
            }
        }
    }

echo $hasil;
?>
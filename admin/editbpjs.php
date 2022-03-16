<?php
    $id_bpjs = $_POST['id_bpjs'];
    $notelp = $_POST['notelp'];
    $hasil = '';
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
    if(isset($notelp)){
        if(isset($id_bpjs)){
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $bpjs = mysqli_query($con, "SELECT * FROM bpjs WHERE id = '$id_bpjs'");
            if (mysqli_num_rows($bpjs) > 0) {
                while ($data = mysqli_fetch_array($bpjs)) {
                    $id = $data['id'];
                    $nama_bpjs = $data['nama_bpjs'];
                    $nominal = $data['nominal'];
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
                                <input type="text" class="form-control id_bpjs" id="id_bpjs" hidden name="id_bpjs" style="font-size: 12px;" value="'. $id.'" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama BPJS</label> <input type="text" class="form-control nama_bpjs" id="nama_bpjs" name="nama_bpjs" style="font-size: 12px;" value="'. $nama_bpjs.'" disabled readonly/> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Biaya<span class="text-danger">*</span> </label> <input type="text" class="form-control nominal" id="nominal" name="nominal" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" value="'. rupiah($nominal).'" /> </div>
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
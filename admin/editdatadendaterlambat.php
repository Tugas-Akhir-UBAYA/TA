<?php
    $id_dendaterlambat = $_POST['id_dendaterlambat'];
    $notelp = $_POST['notelp'];
    $hasil = '';
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
    if(isset($id_dendaterlambat)){
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $datadendaterlambat = mysqli_query($con, "SELECT * FROM denda_terlambat WHERE id = '$id_dendaterlambat'");
        if (mysqli_num_rows($datadendaterlambat) > 0) {
            while ($data = mysqli_fetch_array($datadendaterlambat)) {
                $id = $data['id'];
                $durasi = $data['durasi'];
                $denda = $data['denda'];
                $id_pencatat = $data['id_pencatat'];
                $tanggal_input = $data['tanggal_input'];

                $users = mysqli_query($con, "SELECT * FROM users WHERE nomor_telp = '$notelp'");
                if (mysqli_num_rows($users) > 0) {
                    while ($datas = mysqli_fetch_array($users)) {
                        $idpencatat = $datas['id'];
                    }
                }

            }
            $hasil .= '<div>
                            <input type="text" class="form-control id_denda_terlambat" id="id_denda_terlambat" hidden name="id_denda_terlambat" style="font-size: 12px;" value="'. $id.'" />
                            <input type="text" class="form-control idpencatat" id="idpencatat" hidden name="idpencatat" style="font-size: 12px;" value="'. $idpencatat.'" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Durasi Terlambat (menit)<span class="text-danger">*</span> </label> <input type="text" class="form-control durasi" id="durasi" name="durasi" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" value="'.$durasi.'" /> </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nominal Denda<span class="text-danger">*</span> </label> <input type="text" class="form-control nominal" id="nominal" name="nominal" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" value="'.rupiah($denda).'" /> </div>
                                </div>
                            </div>
                            <div class="modal-footer d-block">
                                <button type="submit" class="btn float-right blues ubah" style="font-size: 14px;">Edit</button>
                            </div>
                        </div>';
        }
    }

echo $hasil;
?>
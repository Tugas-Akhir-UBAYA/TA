<?php
    $id = $_POST['id'];
    $hasil = '';
    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }
    if(isset($id)){
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $datadendalainlain = mysqli_query($con, "SELECT * FROM datadenda_lainlain WHERE id = '$id'");
        if (mysqli_num_rows($datadendalainlain) > 0) {
            while ($data = mysqli_fetch_array($datadendalainlain)) {
                $id = $data['id'];
                $keterangan = $data['keterangan'];
                $nominal = $data['nominal'];
                $id_karyawan = $data['id_users'];
                $status = $data['status'];

                if($status == 1){
                    $disabled = "disabled";
                    $karyawan1 = "";
                    $karyawan2 = "none";
                }else{
                    $disabled = "";
                    $karyawan1 = "none";
                    $karyawan2 = "";
                }

                $users = mysqli_query($con, "SELECT * FROM users WHERE id = '$id_karyawan'");
                if (mysqli_num_rows($users) > 0) {
                    while ($datas = mysqli_fetch_array($users)) {
                        $nama = $datas['nama'];
                        $nomor_telp = $datas['nomor_telp'];
                    }
                }

            }
            $hasil .= '<div>
                            <input type="text" class="form-control id_dendalain" id="id_dendalain" hidden name="id_dendalain" style="font-size: 12px;" value="'. $id.'" />
                            <div class="mb-3 id_karyawans" style="display: '.$karyawan1.'">
                                <div class="form-group"> 
                                    <label class="form-label" style="font-size: 14px;">Karyawan</label> 
                                    <input type="text" class="form-control id_karyawan" id="id_karyawan" name="id_karyawan" style="font-size: 12px;" value="'.$nomor_telp.' - '.$nama.'" '.$disabled.' /> 
                                </div>
                            </div>
                            <div class="mb-3 users" style="display: '.$karyawan2.'">
                                <label class="form-label" style="font-size: 14px; width: 100%;">Karyawan<span class="text-danger">*</span></label>
                                <select name="karyawan" id="karyawan" class="form-control karyawan" style="width: 100%; font-size: 12px;">
                                    <option value="">-- Pilih Karyawan --</option>';
                                    $users = mysqli_query($con, "SELECT * FROM users WHERE jabatan = 0 AND status_kerja = 1");
                                    if (mysqli_num_rows($users) > 0) {
                                        while ($d = $users->fetch_assoc()) {
                                            $id_users = $d['id'];
                                            $namas = $d['nama'];
                                            $nomor_telp = $d['nomor_telp'];
                                            if($namas == $nama){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                            $hasil .='<option '.$selected.' value="'.$id_users.'">'.$nomor_telp.' - '.$namas.'</option>';
                                        }}
                            $hasil .= '</select>
                            </div><div class="mb-3 nominals">
                                <div class="form-group"> 
                                    <label class="form-label" style="font-size: 14px;">Nominal Denda<span class="text-danger">*</span> </label> 
                                    <input type="text" class="form-control nominal" id="nominal" name="nominal" onkeypress="return hanyaAngka(event)" style="font-size: 12px;" '.$disabled.' value = "'.rupiah($nominal).'" /> 
                                </div>
                            </div>
                            <div class="mb-3 keterangan">
                                <label class="form-label" style="font-size: 14px;">Keterangan<span class="text-danger">*</span></label>
                                <textarea class="form-control keterangans" id="keterangans" style="font-size: 12px;">'.$keterangan.'</textarea>
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
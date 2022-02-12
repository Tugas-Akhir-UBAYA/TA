<?php
    $id = $_POST['id'];
    $hasil = '';

    if(isset($id)){
        $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
        $pengajuan = mysqli_query($con, "SELECT * FROM pengajuan WHERE id = '$id'");
        if (mysqli_num_rows($pengajuan) > 0) {
            while ($data = mysqli_fetch_array($pengajuan)) {
                $id = $data['id'];
                $id_users = $data['id_users'];
                $user = mysqli_query($con, "SELECT * FROM users WHERE id = '$id_users'");
                if (mysqli_num_rows($user) > 0) {
                    while ($datas = mysqli_fetch_array($user)) {
                        $nama = $datas['nama'];
                        $notelp = $datas['nomor_telp'];
                    }
                }
                $keterangan = $data['keterangan'];
                $images = $data['images'];
                $tanggal_awal = strtotime($data['tanggal_awal']);
                $fixtanggal_awal = date("d M Y", $tanggal_awal);

                if($data['tanggal_akhir'] == ""){
                    $fixtanggal_akhir = "";
                }else{
                    $tanggal_akhir = strtotime($data['tanggal_akhir']);
                    $fixtanggal_akhir = date("d M Y", $tanggal_akhir);
                }

                $tanggal_input = strtotime($data['tanggal_input']);
                $fixtanggal_input = date("d M Y || H:i:s", $tanggal_input);
                $kategori = $data['kategori'];
                $status = $data['status'];
                if($kategori == "cuti"){
                    $images = "noimages.jpg";
                }
                if($status == ""){
                    $status = "-";
                }

                if($kategori == "lainlain"){
                    $kategori = "Lain - Lain";
                }

                if($kategori == "cuti"){
                    $hasil.='<div>
                                <input type="text" class="form-control id_users" id="id_users" hidden name="id_users" style="font-size: 12px;" value="'. $id.'" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama</label><div class="form-control nama" id="nama" name="nama" style="font-size: 12px;" readonly>' . $nama . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Telepon</label><div class="form-control notelp" id="notelp" name="notelp" style="font-size: 12px;" readonly>' . $notelp . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Mulai Cuti</label><div class="form-control tgl_awal" id="tgl_awal" name="tgl_awal" style="font-size: 12px;" readonly>' . $fixtanggal_awal . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Akhir Cuti</label><div class="form-control tgl_akhir" id="tgl_akhir" name="tgl_akhir" style="font-size: 12px;" readonly>' . $fixtanggal_akhir . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Kategori</label><div class="form-control kategori" id="kategori" name="kategori" style="font-size: 12px;" readonly>' . ucwords($kategori) . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Status</label><div class="form-control status" id="status" name="status" style="font-size: 12px;" readonly>' . ucwords($status) . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Input</label><div class="form-control tgl_input" id="tgl_input" name="tgl_input" style="font-size: 12px;" readonly>' . $fixtanggal_input . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Keterangan</label><div class="form-control keterangan" id="keterangan" name="keterangan" style="font-size: 12px;" readonly>' . ucfirst($keterangan ) . '</div> </div>
                                    </div>
                                </div>
                            </div>';
                }else if($kategori == "terlambat"){
                    $hasil.='<div>
                                <input type="text" class="form-control id_users" id="id_users" hidden name="id_users" style="font-size: 12px;" value="'. $id.'" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <label class="form-label" style="font-size: 14px;">Bukti Foto</label>
                                            <div class="divimg">
                                                <img class="img" src="assets/upload/'.$images.'">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama</label><div class="form-control nama" id="nama" name="nama" style="font-size: 12px;" readonly>' . $nama . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Telepon</label><div class="form-control notelp" id="notelp" name="notelp" style="font-size: 12px;" readonly>' . $notelp . '</div> </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Kategori</label><div class="form-control kategori" id="kategori" name="kategori" style="font-size: 12px;" readonly>' . ucwords($kategori) . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Status</label><div class="form-control status" id="status" name="status" style="font-size: 12px;" readonly>' . ucwords($status) . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Input</label><div class="form-control tgl_input" id="tgl_input" name="tgl_input" style="font-size: 12px;" readonly>' . $fixtanggal_input . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Terlambat</label><div class="form-control tgl_awal" id="tgl_awal" name="tgl_awal" style="font-size: 12px;" readonly>' . $fixtanggal_awal . '</div> </div>
                                    </div>
                                </div>
                                <div class="mb-3 ket">
                                    <label class="form-label" style="font-size: 14px;">Keterangan</label>
                                    <div class="form-control keterangan" id="keterangan" style="font-size: 12px;"readonly>' . ucfirst($keterangan ) . '</div>
                                </div>
                            </div>';
                }else if($kategori == "sakit"){
                    $hasil.='<div>
                                <input type="text" class="form-control id_users" id="id_users" hidden name="id_users" style="font-size: 12px;" value="'. $id.'" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <label class="form-label" style="font-size: 14px;">Bukti Foto</label>
                                            <div class="divimg">
                                                <img class="img" src="assets/upload/'.$images.'">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama</label><div class="form-control nama" id="nama" name="nama" style="font-size: 12px;" readonly>' . $nama . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Telepon</label><div class="form-control notelp" id="notelp" name="notelp" style="font-size: 12px;" readonly>' . $notelp . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Mulai Sakit</label><div class="form-control tgl_awal" id="tgl_awal" name="tgl_awal" style="font-size: 12px;" readonly>' . $fixtanggal_awal . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Akhir Sakit</label><div class="form-control tgl_akhir" id="tgl_akhir" name="tgl_akhir" style="font-size: 12px;" readonly>' . $fixtanggal_akhir . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Kategori</label><div class="form-control kategori" id="kategori" name="kategori" style="font-size: 12px;" readonly>' . ucwords($kategori) . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Status</label><div class="form-control status" id="status" name="status" style="font-size: 12px;" readonly>' . ucwords($status) . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Input</label><div class="form-control tgl_input" id="tgl_input" name="tgl_input" style="font-size: 12px;" readonly>' . $fixtanggal_input . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Keterangan</label><div class="form-control keterangan" id="keterangan" name="keterangan" style="font-size: 12px;" readonly>' . ucfirst($keterangan ) . '</div> </div>
                                    </div>
                                </div>
                            </div>';
                }else if($kategori == "Lain - Lain"){
                    $hasil.='<div>
                                <input type="text" class="form-control id_users" id="id_users" hidden name="id_users" style="font-size: 12px;" value="'. $id.'" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <label class="form-label" style="font-size: 14px;">Bukti Foto</label>
                                            <div class="divimg">
                                                <img class="img" src="assets/upload/'.$images.'">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nama</label><div class="form-control nama" id="nama" name="nama" style="font-size: 12px;" readonly>' . $nama . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Nomor Telepon</label><div class="form-control notelp" id="notelp" name="notelp" style="font-size: 12px;" readonly>' . $notelp . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Mulai Izin</label><div class="form-control tgl_awal" id="tgl_awal" name="tgl_awal" style="font-size: 12px;" readonly>' . $fixtanggal_awal . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Akhir Izin</label><div class="form-control tgl_akhir" id="tgl_akhir" name="tgl_akhir" style="font-size: 12px;" readonly>' . $fixtanggal_akhir . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Kategori</label><div class="form-control kategori" id="kategori" name="kategori" style="font-size: 12px;" readonly>' . ucwords($kategori) . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Status</label><div class="form-control status" id="status" name="status" style="font-size: 12px;" readonly>' . ucwords($status) . '</div> </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Tanggal Input</label><div class="form-control tgl_input" id="tgl_input" name="tgl_input" style="font-size: 12px;" readonly>' . $fixtanggal_input . '</div> </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group"> <label class="form-label" style="font-size: 14px;">Keterangan</label><div class="form-control keterangan" id="keterangan" name="keterangan" style="font-size: 12px;" readonly>' . ucfirst($keterangan ) . '</div> </div>
                                    </div>
                                </div>
                            </div>';
                }
                
            }
            
        }
    }

echo $hasil;
?>
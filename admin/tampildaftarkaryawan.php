<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 16px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Alamat Tinggal</th>
            <th>Status BPJS</th>
            <!-- <th>Jabatan</th> -->
            <th>Detail</th>
            <th>Edit</th>
            <!-- <th>Hapus</th> -->
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $users = mysqli_query($con, "SELECT * FROM users");
            if (mysqli_num_rows($users) > 0) {
                $row = 1;
                while ($data = $users->fetch_assoc()) {
                    $nama = $data['nama'];
                    $no_telp = $data['nomor_telp'];
                    $jabatan = $data['jabatan'];
                    if($jabatan == 1){
                        $jabatan = "Admin";
                    }else if($jabatan == 0){
                        $jabatan = "Karyawan";
                    }
                    $nik = $data['nik'];
                    $alamat_tinggal = $data['alamat_tinggal'];
                    $tgl_awalkerja = $data['tgl_awalkerja'];
                    $no_rekening = $data['nomor_rekening'];
                    $gaji_pokok = $data['gaji_pokok'];
                    $status_bpjs = $data['status_bpjs'];
                    $status_kerja = $data['status_kerja'];
                    if($status_bpjs == 1){
                        $status_bpjs = "Aktif";
                    }else if($status_bpjs == 0){
                        $status_bpjs = "Tidak Aktif";
                    }

                    if($status_kerja == 1){
                        $status_kerja = "Aktif";
                        $color = "";
                        
                    }else if($status_kerja == 0){
                        $status_kerja = "Tidak Aktif";
                        $color = "background-color: rgb(204, 204, 204); color: rgb(126, 126, 126);";
                    }
        ?>
        <tr style="<?php echo $color ?>" >
            <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
            <td><?php echo $nik ?></td>
            <td><?php echo $nama ?></td>
            <td><?php echo $no_telp ?></td>
            <td><?php echo $alamat_tinggal ?></td>
            <td><?php echo $status_bpjs ?></td>
            <!-- <td><?php echo $jabatan ?></td> -->
            <td style="text-align: center;"><button class="btn btn-info detail" id="<?php echo $no_telp ?>" value="<?php echo $no_telp ?>" name="detail"><img style="width: 25px; height: 30px;" src="../images/icon-deatail.png"></button></td>
            <td style="text-align: center;"><button class="btn btn-primary edit" id="<?php echo $no_telp ?>" value="<?php echo $no_telp ?>" name="edit"><img style="width: 25px; height: 30px;" src="../images/icon-edit.png"></button></td>
            <!-- <td style="text-align: center;"><button class="btn btn-danger delete" id="<?php echo $no_telp ?>" value="<?php echo $no_telp ?>" name="delete"><img style="width: 25px; height: 30px;" src="../images/icon-delete2.png"></button></td> -->
        </tr>
        <?php 
            }} 
        ?>
    </tbody>
</table>
<div class="modal fade" id="modalForm1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detail_karyawan">
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalForm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit_karyawan">
                
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "order": [],
            "language": {
                "lengthMenu": "Tampilkan  _MENU_ Baris per Halaman",
                "zeroRecords": "Tidak ada data ditemukan",
                "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "",
                "infoFiltered": "",
                "search": "Pencarian:",
                "paginate": {
                    "previous": "Halaman Sebelumnya",
                    "next": "Halaman Berikutnya"
                }
            },
        });

        $('.detail').click(function(){
            var notelp = $(this).attr('id');
            $.ajax({
                url: 'detailkaryawan.php',
                method: 'post',
                data: {
                    notelp: notelp
                },
                success: function(data) {

                    $('#detail_karyawan').html(data);
                    $("#modalForm1").modal('show');
                    $('.close').click(function(){
                        $("#modalForm1").modal('hide');
                    });
                },
            })
        });

        $('.edit').click(function(){
            var notelp = $(this).attr('id');
            $.ajax({
                url: 'editkaryawan.php',
                method: 'post',
                data: {
                    notelp: notelp
                },
                success: function(data) {
                    $('#edit_karyawan').html(data);
                    $("#modalForm2").modal('show');
                    var rupiah = document.getElementById('gaji');
                    rupiah.addEventListener('keyup', function(e){
                        rupiah.value = formatRupiah(this.value, 'Rp. ');
                    });
            
                    /* Fungsi formatRupiah */
                    function formatRupiah(angka, prefix){
                        var number_string = angka.replace(/[^,\d]/g, '').toString(),
                        split   		= number_string.split(','),
                        sisa     		= split[0].length % 3,
                        rupiah     		= split[0].substr(0, sisa),
                        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

                        if(ribuan){
                            separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }
            
                        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                    }
                    $('.ubah').click(function(){
                        var idusers = $('.id_users').val();
                        var id_users = $('#id_users').val();
                        var nik = $('#nik').val();
                        var nama = $('#nama').val();
                        var tgl_awal = $('#tgl_awal').val();
                        var norek = $('#no_rekening').val();
                        var gaji = $('#gaji').val();
                        var notelp = $('#no_telp').val();
                        var jabatan = $('#jabatan').val();
                        var bpjsketenagakerjaan = document.getElementById("bpjsketenagakerjaan").checked;
                        var bpjskesehatan = document.getElementById("bpjskesehatan").checked;
                        var kerja = document.getElementById("status_kerja").checked;
                        var akses_kamera = document.getElementById("akses_kamera").checked;

                        if(bpjsketenagakerjaan == true){
                            bpjsketenagakerjaan = 1;
                        }else if(bpjsketenagakerjaan == false){
                            bpjsketenagakerjaan = 0;
                        }

                        if(bpjskesehatan == true){
                            bpjskesehatan = 1;
                        }else if(bpjskesehatan == false){
                            bpjskesehatan = 0;
                        }

                        if(kerja == true){
                            kerja = 1;
                        }else if(kerja == false){
                            kerja = 0;
                        }

                        if(akses_kamera == true){
                            akses_kamera = 1;
                        }else if(akses_kamera == false){
                            akses_kamera = 0;
                        }
                        
                        var alamat_tinggal = $('#alamat_tinggal').val();
                        if(nik == "" || nama == "" || tgl_awal == "" || norek == "" || gaji == "" || notelp == "" || jabatan == "" || alamat_tinggal == ""){
                            Swal.fire({
                                title: 'Ups...',
                                html: 'Semua Data Harus di Isi !!!',
                                type: 'error'
                            })
                        }else{
                            $.ajax({
                                url: 'ajaxeditdatakaryawan.php',
                                method: 'post',
                                data: {
                                    id_users: id_users,
                                    nik: nik,
                                    nama: nama,
                                    tgl_awal: tgl_awal,
                                    norek: norek,
                                    gaji: gaji,
                                    notelp: notelp,
                                    jabatan: jabatan,
                                    bpjsketenagakerjaan: bpjsketenagakerjaan,
                                    bpjskesehatan: bpjskesehatan,
                                    alamat_tinggal: alamat_tinggal,
                                    kerja: kerja,
                                    akses_kamera: akses_kamera,
                                    idusers: idusers
                                },
                                success: function(data) {
                                    // $("#modalForm2").modal('hide');
                                    if(data == "Data Karyawan Berhasil di Ubah"){
                                        $("#modalForm2").modal('hide');
                                        Swal.fire({
                                            title: 'Berhasil',
                                            html: 'Data Karyawan Berhasil di Ubah',
                                            type: 'success'
                                        }).then((result) => {
                                            if (result.value) {
                                                $('.tabledaftarkaryawan').load("tampildaftarkaryawan.php");
                                            }
                                        })
                                    }else if( data == "Nomor Telepon Sudah di Gunakan"){
                                        Swal.fire({
                                            title: 'Ups...',
                                            html: 'Nomor Telepon Sudah di Gunakan',
                                            type: 'error'
                                        })
                                    }else if( data == "NIK Sudah di Gunakan"){
                                        Swal.fire({
                                            title: 'Ups...',
                                            html: 'NIK Sudah di Gunakan',
                                            type: 'error'
                                        })
                                    }else if( data == "No. Rekening Sudah di Gunakan"){
                                        Swal.fire({
                                            title: 'Ups...',
                                            html: 'No. Rekening Sudah di Gunakan',
                                            type: 'error'
                                        })
                                    }else if( data == "Gagal Mengubah Data Karyawan"){
                                        Swal.fire({
                                            title: 'Gagal Mengubah Data Karyawan',
                                            html: 'Data Karyawan Tidak di Temukan',
                                            type: 'error'
                                        })
                                    }
                                },
                            })
                        }
                    });
                },
            })
        });

        $('.delete').click(function(){
            var notelp = $(this).attr('id');
            Swal.fire({
                title: 'Hapus Data Karyawan',
                text: "Yakin ingin Menghapus Data Karyawan ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'ajaxdeletekaryawan.php',
                        method: 'post',
                        data: {
                            notelp: notelp
                        },
                        success: function(data) {
                            if(data == "Data Karyawan Berhasil di Hapus"){
                                Swal.fire({
                                    title: 'Berhasil',
                                    html: 'Data Karyawan Berhasil di Hapus',
                                    type: 'success'
                                }).then((result) => {
                                    if (result.value) {
                                        $('.tabledaftarkaryawan').load("tampildaftarkaryawan.php");
                                    }
                                })
                            }else if( data == "Data Karyawan Gagal di Hapus"){
                                Swal.fire({
                                    title: 'Ups...',
                                    html: 'Data Karyawan Gagal di Hapus',
                                    type: 'error'
                                })
                            }
                        },
                    })
                }
            })
        });
    });
</script>
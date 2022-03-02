<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 16px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Tanggal Input</th>
            <th>Gaji Sebelumnya</th>
            <th>Gaji Sekarang</th>
            <th>Selisih</th>
            <th>Pencatat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $gajipokokdetail = mysqli_query($con, "SELECT * FROM gaji_pokok_detail ORDER BY id DESC");
            if (mysqli_num_rows($gajipokokdetail) > 0) {
                $row = 1;
                function rupiah($angka)
                {
                    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                    return $hasil_rupiah;
                }
                while ($data = $gajipokokdetail->fetch_assoc()) {
                    $id_users = $data['id_users'];
                    $tanggal_input = strtotime($data['tanggal_input']);
                    $fixtanggal_input = date("d M Y", $tanggal_input);
                    $gaji_sebelumnya = $data['gaji_sebelumnya'];
                    $gaji_sekarang = $data['gaji_sekarang'];
                    $selisih = preg_replace("/[^0-9]/", "", $data['selisih']);
                    $pencatat = $data['id_pengedit'];
                    if($gaji_sekarang > $gaji_sebelumnya){
                        $keterangan = "Naik";
                        $color = "green";
                    }else if($gaji_sekarang < $gaji_sebelumnya){
                        $keterangan = "Turun";
                        $color = "red";
                    }else{
                        $color = "grey";
                        $keterangan = "Tetap";
                    }
                    $user = mysqli_query($con, "SELECT * FROM users WHERE id = $id_users");
                    if (mysqli_num_rows($user) > 0) {
                        while ($datas = $user->fetch_assoc()) {
                            $no_telp = $datas['nomor_telp'];
                            $nama = $datas['nama'];
                        }
                    }

                    $user_pencatat = mysqli_query($con, "SELECT * FROM users WHERE id = $pencatat");
                    if (mysqli_num_rows($user_pencatat) > 0) {
                        while ($rows = $user_pencatat->fetch_assoc()) {
                            $name = $rows['nama'];
                        }
                    }
        ?>
        <tr style="<?php echo $color ?>" >
            <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
            <td><?php echo $nama ?></td>
            <td><?php echo $no_telp ?></td>
            <td><?php echo $fixtanggal_input ?></td>
            <td><?php echo rupiah($gaji_sebelumnya) ?></td>
            <td><?php echo rupiah($gaji_sekarang) ?></td>
            <td><?php echo rupiah($selisih) ?></td>
            <td><?php echo $name ?></td>
            <td style="text-align: center; color: <?php echo $color ?>;"><b><?php echo $keterangan ?></b></td>
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
                        var bpjs = document.getElementById("bpjs").checked;
                        var kerja = document.getElementById("status_kerja").checked;
                        var akses_kamera = document.getElementById("akses_kamera").checked;

                        if(bpjs == true){
                            bpjs = 1;
                        }else if(bpjs == false){
                            bpjs = 0;
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
                                    bpjs: bpjs,
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
<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 14px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Tanggal Input</th>
            <th>Nama Bank</th>
            <th>Atas Nama</th>
            <th>Nomor Rekening</th>
            <th>Pencatat</th>
            <th>Ubah</th>
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $rekening = mysqli_query($con, "SELECT * FROM rekening");
            if (mysqli_num_rows($rekening) > 0) {
                $row = 1;
                function rupiah($angka)
                {
                    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
                    return $hasil_rupiah;
                }
                while ($data = $rekening->fetch_assoc()) {
                    $id_rekening = $data['id'];
                    $nama_bank = $data['nama_bank'];
                    $tanggal_input = strtotime($data['tanggal_input']);
                    $fixtanggal_input = date("d F Y", $tanggal_input);
                    $atas_nama = $data['atas_nama'];
                    $no_rekening = $data['no_rekening'];
                    $id_pencatat = $data['id_pencatat'];

                    $users = mysqli_query($con, "SELECT * FROM users WHERE id = '$id_pencatat'");
                    if (mysqli_num_rows($users) > 0) {
                        while($datas = $users->fetch_assoc()){
                            $nama_pencatat = $datas['nama'];
                        }
                    }else{
                        $nama_pencatat = "Misteri";
                    }
        ?>
        <tr style="<?php echo $color ?>" >
            <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
            <td><?php echo $fixtanggal_input ?></td>
            <td><?php echo $nama_bank ?></td>
            <td><?php echo $atas_nama ?></td>
            <td><?php echo $no_rekening ?></td>
            <td><?php echo $nama_pencatat ?></td>
            <td style="text-align: center;"><button class="btn btn-primary edit" id="<?php echo $id_rekening ?>" value="<?php echo $no_telp ?>" name="ubah"><img style="width: 25px; height: 30px;" src="../images/icon-edit.png"></button></td>
        </tr>
        <?php 
            }} 
        ?>
    </tbody>
</table>
<input hidden class="notelp" value="<?php echo $_COOKIE['notelp'] ?>">
<div class="modal fade" id="modalForm1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Rekening Perusahaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="edit_rekening">
                
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

        $('.edit').click(function(){
            var id_rekening = $(this).attr('id');
            var notelp = $('.notelp').val();
            $.ajax({
                url: 'editrekening.php',
                method: 'post',
                data: {
                    id_rekening: id_rekening,
                    notelp: notelp,
                },
                success: function(data) {
                    $('#edit_rekening').html(data);
                    $("#modalForm1").modal('show');

                    $('.ubah').click(function(){
                        var id_users = $('.id_users').val();
                        var tgl_input = $('.tgl_input').val();
                        var id_rekening = $('.id_rekening').val();
                        var nama_bank = $('.nama_bank').val();
                        var atas_nama = $('.atas_nama').val();
                        var no_rekening = $('.no_rekening').val();
                        if(atas_nama == "" || no_rekening == ""){
                            Swal.fire({
                                title: 'Ups...',
                                html: 'Semua Data Harus di Isi !!!',
                                type: 'error'
                            })
                        }else{
                            $.ajax({
                                url: 'ajaxeditrekening.php',
                                method: 'post',
                                data: {
                                    id_users: id_users,
                                    id_rekening: id_rekening,
                                    tgl_input: tgl_input,
                                    nama_bank: nama_bank,
                                    no_rekening: no_rekening,
                                    atas_nama: atas_nama,
                                },
                                success: function(data) {
                                    $("#modalForm1").modal('hide');
                                    if(data == "Berhasil Merubah Data Rekening"){
                                        Swal.fire
                                        ({
                                            title: 'Berhasil',
                                            html: 'Data Rekening Perusahaan Berhasil Di Ubah',
                                            type: 'success'
                                        }).then((result) => {
                                            if (result.value) {
                                                $('.tablerekening').load("tampildaftarrekening.php");
                                            }
                                        })
                                    }
                                    else if(data == "Nomor Rekening Sudah Ada"){
                                        Swal.fire
                                        ({
                                            title: 'Ups...',
                                            html: 'Nomor Rekening Sudah Ada',
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

    });
</script>
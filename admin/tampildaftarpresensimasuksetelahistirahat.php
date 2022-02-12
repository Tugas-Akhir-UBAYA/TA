<table id="table" class="table table-striped table-bordered" style="width:100%">
    <thead style="font-size: 16px;">
        <tr style="text-align: center;">
            <th>#</th>
            <th>Nama</th>
            <th>Nomor Telepon</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <!-- <th>Status</th> -->
        </tr>
    </thead>
    <tbody style="font-size: 12px;">
        <?php
            $con =  mysqli_connect("localhost", "root", "", "kelola_karyawan");
            $absensi = mysqli_query($con, "SELECT * FROM absensi WHERE keterangan = 'Masuk Setelah Istirahat' ORDER BY id DESC");
            if (mysqli_num_rows($absensi) > 0) {
                $row = 1;
                while ($data = $absensi->fetch_assoc()) {
                    $id_users = $data['id_users'];
                    $tanggal = strtotime($data['tanggal']);
                    $fixtanggal = date("d M Y", $tanggal);
                    $waktu = $data['waktu'];
                    // $status = $data['status'];
                    $users = mysqli_query($con, "SELECT * FROM users WHERE id = $id_users");
                    if (mysqli_num_rows($users) > 0) {
                        while ($datas = $users->fetch_assoc()) {
                            $nama = $datas['nama'];
                            $no_telp = $datas['nomor_telp'];
                        }}
        ?>
        <tr>
            <td style="text-align: center;"><b><?php echo $row++ ?></b></td>
            <td><?php echo $nama ?></td>
            <td><?php echo $no_telp ?></td>
            <td><?php echo $fixtanggal ?></td>
            <td><?php echo $waktu ?></td>
            <!-- <td><b><?php echo $status ?></b></td> -->
        </tr>
        <?php 
            }} 
        ?>
    </tbody>
</table>
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
                        var id_users = $('#id_users').val();
                        var nik = $('#nik').val();
                        var nama = $('#nama').val();
                        var tgl_awal = $('#tgl_awal').val();
                        var norek = $('#no_rekening').val();
                        var gaji = $('#gaji').val();
                        var notelp = $('#no_telp').val();
                        var jabatan = $('#jabatan').val();
                        var bpjs = $('#bpjs').val();
                        var alamat_tinggal = $('#alamat_tinggal').val();
                        if(nik == "" || nama == "" || tgl_awal == "" || norek == "" || gaji == "" || notelp == "" || jabatan == "" || bpjs == ""|| alamat_tinggal == ""){
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
                                    alamat_tinggal: alamat_tinggal
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
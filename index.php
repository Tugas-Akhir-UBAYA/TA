<?php
$notelp = "";
	if (isset($_COOKIE['notelp'])) {
        $notelp = $_COOKIE['notelp'];
   }
?>
<!DOCTYPE html>
<html lang="en">
<script type = "text/javascript" >
    function preventBack(){window.history.forward();}
    setTimeout("preventBack()", 0);
    window.onunload=function(){null};
</script>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <link rel="stylesheet" href="css/index.css">
    <title>Karyawan PT. Aman Samudera Lines</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm blue">
        <div class="container-fluid">
            <a class="navbar-brand white" href="index.php">PT. AMAN SAMUDERA LINES</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
            </div>
        </div>
    </nav>
    
    <div class="wrapper">
        <div class="logo"> <img src="images/icon-people2.png" alt=""> </div>
        <div class="text-center mt-4 name"> Login </div>
        <div class="p-3 mt-3">
            <div class="form-field d-flex align-items-center"> <span class="far fa-user"></span>
            <?php
                if($notelp != '' && $notelp != 0){
                    ?>
                        <input class="notelps" type="text" name="notelps" id="notelps" placeholder="No. Telepon" value="<?php echo $notelp ?>"></div>
                        
                        <?php
                }else{
                    ?>
                        <input class="notelp" type="text" name="notelp" id="notelp" placeholder="No. Telepon" onkeypress="return hanyaAngka(event)"></div>
                        <?php
                }
                ?>
            <div class="btn mt-3 signin">Sign In</div>
        </div>
    </div>
    <input class="notelps" type="text" name="notelps" id="notelps" placeholder="No. Telepon" hidden value="<?php $notelp ?>"></div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
            var notelps = $('.notelps').val();
            if(notelps != ""){
                $.ajax({
                    url: "ajaxlogin.php",
                    method: "post",
                    data: {
                        notelps: notelps
                    },
                    success: function(data) {
                        if(data == "Login berhasil karyawan")
                        {
                            document.location.href = 'home/home.php';
                        }else if(data == "Login berhasil admin"){
                            document.location.href = 'admin/home.php';
                        }
					}
				})
            }else{
                $('.signin').click(function() {
                    var notelp = $('.notelp').val();
                    if(notelp != "" && notelp != 0)
                    {
                        
					$.ajax({
						url: "ajaxlogin.php",
						method: "post",
						data: {
							notelp: notelp
						},
						success: function(data) {
							if(data == "Login berhasil karyawan")
							{
								Swal.fire({
									title: 'Yeah',
									html: 'Login Berhasil',
									type: 'success'
								}).then((result) => {
									if (result.value) {
										document.location.href = 'home/home.php';
									}
								})
							}else if(data == "Login berhasil admin"){
								Swal.fire({
									title: 'Yeah',
									html: 'Login Berhasil',
									type: 'success'
								}).then((result) => {
									if (result.value) {
										document.location.href = 'admin/home.php';
									}
								})
							}else if(data == "Nomor telepon tidak terdaftar"){
								Swal.fire({
									title: 'Login Gagal',
									html: 'Nomor telepon tidak terdaftar',
									type: 'error'
								})
							}else if(data == "Akun sedang login di perangkat lain"){
								Swal.fire({
									title: 'Login Gagal',
									html: 'Akun sedang login di perangkat lain',
									type: 'error'
								})
							}
						}
					})
				}else{
                    Swal.fire({
						title: 'Login Gagal',
						html: 'Nomor telepon tidak boleh kosong',
					    type: 'error'
					})
                }
			});
            }	
		});
	</script>
    
    <script>
		function hanyaAngka(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode
		   if (charCode > 31 && (charCode < 48 || charCode > 57))
 
		    return false;
		  return true;
		}
	</script>

</body>
</html>
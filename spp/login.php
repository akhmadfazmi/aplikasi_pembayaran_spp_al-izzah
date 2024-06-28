<?php
session_start();
if(isset($_SESSION['admin'])) {
    header('location: index.php');
    exit;
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include 'koneksi.php';
if (isset($_POST['login'])) {
    $user = htmlentities(strip_tags($_POST['user']));
    $pass = htmlentities(strip_tags($_POST['pass']));

    $query = "SELECT * FROM admin WHERE user_admin='$user'";
    $exec = mysqli_query($conn,$query);

    if (mysqli_num_rows($exec) !== 0) {
        $query = "SELECT * FROM admin WHERE pass_admin ='$pass'";
        $exec = mysqli_query($conn,$query);
        if(mysqli_num_rows($exec) !==0){
            $res = mysqli_fetch_assoc($exec);
            $_SESSION['admin']= $res['id_admin'];
            $_SESSION['nama_admin']= $res['nama_admin'];
            header('location: index.php');

        }else {
            echo "<script>alert('password admin salah')  
            document.location = 'login.php'; 
            </script>";

        }
    }else {
        echo "<script>alert('user admin tidak tersedia')  
        document.location = 'login.php'; 
        </script>";
    }
}
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <link href="foto/logo.png" rel="icon" type="image/x-icon">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .bg-login-image {
            background: url('img/logo.jpeg') no-repeat center center;
            background-size: contain;
        }
    </style>
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1>
                                </div>
                                <form class="user" method="post" action="">
                                    <div class="form-group">
                                        <input type="text" autocomplete="off" required name="user" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Username..">
                                    </div>
                                    <div class="form-group">
                                        <input autocomplete="off" type="password" required name="pass" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
                                    <hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>

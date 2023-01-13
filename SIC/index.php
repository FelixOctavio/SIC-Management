<?php
session_start();
if(isset($_SESSION['UserID'])){
    if($_SESSION['role'] == 'admin'){
        header("location:adminUI/index.php");
    }
    else if($_SESSION['role'] == 'guru'){
        header("location:guruUI/index.php");
    }
}

include("connection.php");
$userid = "";
$password = "";
$err = "";
if(isset($_POST['submitbtn'])){
    $userid = $_POST['id'];
    $password = $_POST['pw'];
    if(empty($err)){
        $check = mysqli_query($koneksi,"select * from userlogin where iduser='$userid'");
        $userdata = mysqli_fetch_array($check);
        if(empty($userdata)){
            $err .= "UserID not found";
        }
        else if($userdata['UserPassword'] != md5($password)){
            $err .= "Password Incorrect";
        }
    }
    if(empty($err)){
        $role = $userdata['Role'];
        if($role=='Admin'){
            $_SESSION['UserID'] = $userid;
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'admin';
            header("location:adminUI/index.php");
        }
        else if($role=='Guru'){
            $_SESSION['UserID'] = $userid;
            $_SESSION['log'] = 'Logged';
            $_SESSION['role'] = 'guru';
            header("location:guruUI/index.php");
        }
        else{
            $err .= "You don't have access to this page";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css" rel="stylesheet">
    <link rel="icon" href="logo.png">
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="main">
                <div class="form">
                    <h1>welcome</h1>
                    <form action="" method="post">
                        <div class="inputform">
                            <input type="text" name="id" required="requaired">
                            <span>UserID</span>
                        </div>
                        <div class="inputform">
                            <input type="password" name="pw" required="requaired">
                            <span>Password</span>
                        </div>
                        <div class="errormessage">
                            <h2><?php if($err){
                                echo $err;
                            }
                            ?> </h2>
                        </div>
                        <div class="submitbutton">
                            <input type="submit" name="submitbtn" value="LOGIN">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
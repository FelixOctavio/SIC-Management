<?php 
include("../UserRole.php");
if($_SESSION['role'] != "guru"){
    header("location:../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../logo.png">
</head>
<body>
<header>
        <nav class="navbar">
            <ul>
                <li>
                    <a href="tambah_nilai_ulangan.php">Memasukkan Nilai Ulangan</a>
                </li>
                <li>
                    <a href="tambah_nilai_tugas.php">Memasukkan Nilai Tugas</a>
                </li>
                <li>
                    <a href="attendance.php">Kehadiran</a>
                </li>
                <li>
                    <a href="../logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
</body>
</html>
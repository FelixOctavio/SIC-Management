<?php
include("../UserRole.php");
if ($_SESSION['role'] != "admin") {
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
                    <a href="tambah_siswa.php">Memasukkan Siswa</a>
                </li>
                <li>
                    <a href="tambah_guru.php">Memasukkan Guru</a>
                </li>
                <li>
                    <a href="assign_siswa.php">Memasukkan Siswa ke dalam Kelas</a>
                </li>
                <li>
                    <a href="tambah_sesi.php">Membuat Sesi</a>
                </li>
                <li>
                    <a href="tambah_poin.php">Memberi poin siswa</a>
                </li>
                <li>
                    <a href="../logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
</body>

</html>
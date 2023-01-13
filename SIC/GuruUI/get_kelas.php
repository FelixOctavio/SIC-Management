<?php 
include("../UserRole.php");
if($_SESSION['role'] != "guru"){
    header("location:../index.php");
    exit();
}
?>

<?php 
    include "../Conection.php"; 
    $guru_id = $_SESSION['UserID'];
    $jurusan_id = $_POST["jurusan_id"];
    $tingkat_id = $_POST["tingkat_id"];
    $kelas = $_POST["kelas"];

    $sql=mysqli_query($koneksi, "SELECT DISTINCT kelas.KodeKelas, kelas.Jurusan, kelas.KodeKelas
    FROM sesimapel
    JOIN kelas ON (sesimapel.IDKelas = kelas.IDKelas)
    WHERE sesimapel.IDGuru = '$guru_id' AND kelas.Tingkat = '$tingkat_id' AND kelas.Jurusan='$jurusan_id' ORDER BY kelas.IDKelas");
?>
    <option disabled selected> Pilih Kelas </option>
<?php 
   while ($data=mysqli_fetch_array($sql)) {
?>
   <option value="<?=$data['KodeKelas']?>" <?php if ($data['KodeKelas'] == "$kelas")
          echo "selected" ?>><?=$data['KodeKelas']?></option>
<?php
   }
?>
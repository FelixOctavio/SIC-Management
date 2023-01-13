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
    $kelas_id = $_POST["kelas_id"];
    $tahun = $_POST["tahun"];

    $sql=mysqli_query($koneksi, "SELECT DISTINCT sesiMapel.Tahun
    FROM sesimapel
    JOIN kelas ON (sesimapel.IDKelas = kelas.IDKelas)
    WHERE kelas.Jurusan='$jurusan_id' AND kelas.Tingkat='$tingkat_id' AND kelas.KodeKelas='$kelas_id' AND sesimapel.IDGuru='$guru_id' ORDER BY kelas.IDKelas");
?>
    <option disabled selected> Pilih Tahun </option>
<?php 
   while ($data=mysqli_fetch_array($sql)) {
?>
   <option value="<?=$data['Tahun']?>" <?php if ($data['Tahun'] == "$tahun")
          echo "selected" ?>><?=$data['Tahun']?></option>
<?php
   }
?>
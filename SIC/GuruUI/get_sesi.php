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
    $semester_id = $_POST["semester_id"];
    $tahun_id = $_POST["tahun_id"];
    $sesi = $_POST["sesi"];

    $sql=mysqli_query($koneksi, "SELECT DISTINCT sesimapel.IDSesi
        FROM sesimapel
        JOIN kelas ON (sesimapel.IDKelas = kelas.IDKelas)
        WHERE sesimapel.IDGuru = '$guru_id' AND kelas.KodeKelas='$kelas_id' AND kelas.Tingkat = '$tingkat_id' AND kelas.Jurusan='$jurusan_id' AND sesimapel.Tahun='$tahun_id' AND sesimapel.Semester='$semester_id' ORDER BY sesimapel.IDSesi;");
?>
    <option disabled selected> Pilih Sesi </option>
<?php 
   while ($data=mysqli_fetch_array($sql)) {
?>
   <option value="<?=$data['IDSesi']?>" <?php if ($data['IDSesi'] == "$sesi")
          echo "selected" ?>><?=$data['IDSesi']?></option>
<?php
   }
?>
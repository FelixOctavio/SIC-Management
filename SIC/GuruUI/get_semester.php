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
    $tahun_id = $_POST["tahun_id"];
    $semester = $_POST["semester"];

    $sql=mysqli_query($koneksi, "SELECT DISTINCT sesiMapel.Semester
    FROM sesimapel
    JOIN kelas ON (sesimapel.IDKelas = kelas.IDKelas)
    WHERE kelas.Jurusan='$jurusan_id' AND kelas.Tingkat='$tingkat_id' AND kelas.KodeKelas='$kelas_id' AND sesimapel.IDGuru='$guru_id' AND sesimapel.Tahun='$tahun_id' ORDER BY kelas.IDKelas");
?>
    <option disabled selected> Pilih Semester </option>
<?php 
   while ($data=mysqli_fetch_array($sql)) {
?>
   <option value="<?=$data['Semester']?>" <?php if ($data['Semester'] == "$semester")
          echo "selected" ?>><?php if ($data['Semester']%2 == 1) echo "Ganjil" ?><?php if ($data['Semester']%2 == 0) echo "Genap" ?></option>
<?php
   }
?>
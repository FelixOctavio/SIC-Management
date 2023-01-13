<?php 
include("../UserRole.php");
if($_SESSION['role'] != "guru"){
    header("location:../index.php");
    exit();
}
?>

<?php 
    include "../Connection.php"; 
    $guru_id = $_SESSION['UserID'];
    $jurusan_id = $_POST["jurusan_id"];
    $tingkat_id = $_POST["tingkat_id"];
    $kelas_id = $_POST["kelas_id"];
    $tahun_id = $_POST["tahun_id"];
    $semester_id = $_POST["semester_id"];
    $nama = $_POST["nama"];

    $sql=mysqli_query($koneksi, "SELECT DISTINCT datasiswa.Nama
    FROM datasiswa
    JOIN listsiswa ON listsiswa.IDSiswa=datasiswa.IDSiswa
    JOIN kelas ON (listsiswa.IDKelas = kelas.IDKelas)
    JOIN sesimapel ON kelas.IDKelas = sesimapel.IDKelas
    WHERE kelas.Jurusan='$jurusan_id' AND kelas.Tingkat='$tingkat_id' AND kelas.KodeKelas='$kelas_id' AND sesimapel.IDGuru='$guru_id' AND listsiswa.Tahun='$tahun_id' AND sesimapel.Semester='$semester_id' ORDER BY datasiswa.Nama;");
?>
    <option disabled selected> Pilih Nama </option>
<?php 
   while ($data=mysqli_fetch_array($sql)) {
?>
   <option value="<?=$data['Nama']?>" <?php if ($data['Nama'] == "$nama")
          echo "selected" ?>><?=$data['Nama']?></option>
<?php
   }
?>
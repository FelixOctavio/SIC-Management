<?php
include("../UserRole.php");
if ($_SESSION['role'] != "admin") {
    header("location:../index.php");
    exit();
}
?>

<?php
include "../connection.php";
$jurusan_id = $_POST["jurusan_id"];
$tingkat_id = $_POST["tingkat_id"];
$kelas = $_POST["kelas"];

$sql = mysqli_query($koneksi, "SELECT KodeKelas FROM kelas WHERE Tingkat='$tingkat_id' AND Jurusan='$jurusan_id'");
?>
<option disabled selected> Pilih Kelas </option>
<?php
while ($data = mysqli_fetch_array($sql)) {
    ?>
    <option value="<?= $data['KodeKelas'] ?>" <?php if ($data['KodeKelas'] == "$kelas")
          echo "selected" ?>>
        <?= $data['KodeKelas'] ?>
    </option>
    <?php
}
?>
<?php
include("../UserRole.php");
if ($_SESSION['role'] != "admin") {
    header("location:../index.php");
    exit();
}
?>

<?php
include "../Connection.php";
$jurusan_id = $_POST["jurusan_id"];
$tingkat_id = $_POST["tingkat_id"];
$mapel = $_POST["mapel"];

$sql = mysqli_query($koneksi, "SELECT IDMapel, NamaMapel FROM mapel WHERE Tingkat=$tingkat_id AND Jurusan='$jurusan_id'");
?>
<option disabled selected> Pilih Mapel </option>
<?php
while ($data = mysqli_fetch_array($sql)) {
    ?>
    <option value="<?= $data['IDMapel'] ?>" <?php if ($data['IDMapel'] == "$mapel")
          echo "selected" ?>>
    <?= $data['NamaMapel'] ?>
    </option>
    <?php
}
?>
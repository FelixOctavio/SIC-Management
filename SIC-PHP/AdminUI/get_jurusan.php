<?php
include("../UserRole.php");
if ($_SESSION['role'] != "admin") {
    header("location:../index.php");
    exit();
}
?>

<?php
include "../Connection.php";
$tingkat_id = $_POST["tingkat_id"];
$jurusan = $_POST["jurusan"];

$sql = mysqli_query($koneksi, "SELECT DISTINCT Jurusan FROM kelas WHERE Tingkat=$tingkat_id ORDER BY Jurusan ASC");
?>
<option disabled selected> Pilih Jurusan </option>
<?php
while ($data = mysqli_fetch_array($sql)) {
    ?>
    <option value="<?= $data['Jurusan'] ?>" <?php if ($data['Jurusan'] == "$jurusan")
          echo "selected" ?>>
        <?= $data['Jurusan'] ?>
    </option>
    <?php
}
?>
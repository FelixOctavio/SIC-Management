<?php
include("../UserRole.php");
if ($_SESSION['role'] != "guru") {
    header("location:../index.php");
    exit();
}
?>

<?php
include "../Connection.php";
$tingkat_id = $_POST["tingkat_id"];
$jurusan = $_POST["jurusan"];
$guru_id = $_SESSION['UserID'];

$sql = mysqli_query($koneksi, "SELECT DISTINCT mapel.Jurusan
    FROM sesimapel
    JOIN mapel ON (mapel.IDMapel = sesimapel.IDMapel)
    WHERE sesimapel.IDGuru = '$guru_id' AND mapel.Tingkat = '$tingkat_id' ORDER BY mapel.Jurusan ASC");
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
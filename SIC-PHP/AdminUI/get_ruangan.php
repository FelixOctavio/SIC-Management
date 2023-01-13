<?php
include("../UserRole.php");
if ($_SESSION['role'] != "admin") {
    header("location:../index.php");
    exit();
}
?>

<?php
include "../Connection.php";
$lantai_id = $_POST["lantai_id"];
$ruangan = $_POST["ruangan"];

$sql = mysqli_query($koneksi, "SELECT IDRuangan, NamaRuangan
FROM ruangan WHERE Lantai='$lantai_id'");
?>
<option disabled selected> Pilih Ruangan </option>
<?php
while ($data = mysqli_fetch_array($sql)) {
    ?>
    <option value="<?= $data['IDRuangan'] ?>" <?php if ($data['IDRuangan'] == $ruangan)
                                      echo "selected" ?>>
        <?= $data['IDRuangan'] ?>  -  <?= $data['NamaRuangan'] ?>
    </option>
    <?php
}
?>
<?php
include("../UserRole.php");
if ($_SESSION['role'] != "admin") {
    header("location:../index.php");
    exit();
}
?>

<?php
include "../Conection.php";
$tingkat_id = $_POST["tingkat_id"];
$ganjil = $tingkat_id - 9 + $tingkat_id - 9 - 1;
$genap = $tingkat_id - 9 + $tingkat_id - 9;
$semester = $_POST["semester"];

?>
<option disabled selected> Pilih Semester </option>
<option value="<?php echo $ganjil ?>" <?php if ($semester == $ganjil)
        echo "selected" ?>>Ganjil</option>
    <option value=" <?php echo $genap ?>" <?php if ($semester == $genap)
            echo "selected" ?>>Genap</option>

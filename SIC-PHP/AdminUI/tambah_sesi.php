<?php
include("../UserRole.php");
if ($_SESSION['role'] != "admin") {
    header("location:../index.php");
    exit();
}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Tambah Sesi</title>
    <link href="style.css" type="text/css" rel="stylesheet">
    <link rel="icon" href="../logo.png">
</head>

<body>
    <header>
        <nav class="navbar">
            <ul>
                <li>
                    <a href="tambah_siswa.php">Memasukkan Siswa</a>
                </li>
                <li>
                    <a href="tambah_guru.php">Memasukkan Guru</a>
                </li>
                <li>
                    <a href="assign_siswa.php">Memasukkan Siswa ke dalam Kelas</a>
                </li>
                <li>
                    <a href="tambah_sesi.php#" class="active">Membuat Sesi</a>
                </li>
                <li>
                    <a href="tambah_poin.php">Memberi poin siswa</a>
                </li>
                <li>
                    <a href="../logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php
        if (!(empty($_POST["tingkat-dropdown"]) || empty($_POST["jurusan-dropdown"]) || empty($_POST["kelas-dropdown"]) || empty($_POST["mapel-dropdown"]) || empty($_POST["semester-dropdown"]) || empty($_POST["tahun"]) || empty($_POST["guru-dropdown"]) || empty($_POST["lantai-dropdown"]) || empty($_POST["ruangan-dropdown"]) || empty($_POST["namaSesi"]) || empty($_POST["sesi"]) || empty($_POST["tanggal"]) || empty($_POST["mulai"]) || empty($_POST["selesai"]))) {
            include "../Connection.php";

            $tingkat = $_POST['tingkat-dropdown'];
            $jurusan = $_POST['jurusan-dropdown'];
            $kelas = $_POST['kelas-dropdown'];
            $mapel = $_POST['mapel-dropdown'];
            $semester = $_POST['semester-dropdown'];
            $tahun = $_POST['tahun'];
            $guru = $_POST['guru-dropdown'];
            $lantai = $_POST['lantai-dropdown'];
            $ruangan = $_POST['ruangan-dropdown'];
            $nama = $_POST['namaSesi'];
            $sesi = $_POST['sesi'];
            $tanggal = $_POST['tanggal'];
            $mulai = $_POST['mulai'];
            $selesai = $_POST['selesai'];

            $queryKelas = mysqli_query($koneksi, "SELECT IDKelas FROM kelas WHERE Tingkat='$tingkat' AND Jurusan='$jurusan' AND KodeKelas='$kelas'") or die(mysqli_error($koneksi));

            while ($data = mysqli_fetch_array($queryKelas)) { //Hasil output querynya masih berupa object, jadi harus difetch
                $idKelas = ($data['IDKelas']);
            }

            $cancel = 0;

            $check = mysqli_query($koneksi, "SELECT * FROM sesimapel
            WHERE IDSesi='$sesi' AND IDMapel='$mapel' AND IDKelas='$idKelas' AND Semester='$semester' AND Tahun='$tahun' AND IDGuru='$guru' AND IDRuangan='$ruangan' AND NamaSesi='$nama' AND Tanggal='$tanggal' AND JamMulai='$mulai' AND JamBerakhir='$selesai'") or die(mysqli_error($koneksi));
            while ($data = mysqli_fetch_array($check)) { //Kalo ketemu data yang sama di tabel
                echo "<script>alert('Terdapat duplikat data!');</script>";
                $cancel = 1;
                break;
            }

            if (!($cancel)) {
                $query = mysqli_query($koneksi, "INSERT INTO sesimapel (IDSesi, IDMapel, IDKelas, Semester, Tahun, IDGuru, IDRuangan, NamaSesi, Tanggal, JamMulai, JamBerakhir)
            VALUES ('$sesi', '$mapel', '$idKelas', '$semester', '$tahun', '$guru', '$ruangan', '$nama', '$tanggal', '$mulai', '$selesai')") or die(mysqli_error($koneksi));
                if ($query)
                    echo "<script>alert('Sesi berhasil ditambahkan');</script>";
                else
                    echo "<script>alert('Gagal menambahkan sesi');</script>";
            }
        }
        ?>

        <?php
        include "../Connection.php";
        ?>

        <isi>
            <?php
            $tingkatErr = $jurusanErr = $kelasErr = $mapelErr = $semesterErr = $tahunErr = $guruErr = $lantaiErr = $ruanganErr = $sesiErr = $sesiKeErr = $tanggalErr = $mulaiErr = $selesaiErr = "";
            $tingkat = $jurusan = $kelas = $mapel = $semester = $tahun = $guru = $lantai = $ruangan = $sesi = $sesiKeErr = $tanggal = $mulai = $selesai = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["tingkat-dropdown"])) {
                    $tingkatErr = "Tingkat tidak boleh kosong";
                } else {
                    $tingkat = test_input($_POST["tingkat-dropdown"]);
                }

                if (empty($_POST["jurusan-dropdown"])) {
                    $jurusanErr = "Jurusan tidak boleh kosong";
                } else {
                    $jurusan = test_input($_POST["jurusan-dropdown"]);
                }

                if (empty($_POST["kelas-dropdown"])) {
                    $kelasErr = "Kelas tidak boleh kosong";
                } else {
                    $kelas = test_input($_POST["kelas-dropdown"]);
                }

                if (empty($_POST["mapel-dropdown"])) {
                    $mapelErr = "Mapel tidak boleh kosong";
                } else {
                    $mapel = test_input($_POST["mapel-dropdown"]);
                }

                if (empty($_POST["semester-dropdown"])) {
                    $semesterErr = "Semester tidak boleh kosong";
                } else {
                    $semester = test_input($_POST["semester-dropdown"]);
                }

                if (empty($_POST["tahun"])) {
                    $tahunErr = "Tahun tidak boleh kosong";
                } else {
                    $tahun = test_input($_POST["tahun"]);
                }

                if (empty($_POST["guru-dropdown"])) {
                    $guruErr = "Guru tidak boleh kosong";
                } else {
                    $guru = test_input($_POST["guru-dropdown"]);
                }

                if (empty($_POST["lantai-dropdown"])) {
                    $lantaiErr = "Lantai tidak boleh kosong";
                } else {
                    $lantai = test_input($_POST["lantai-dropdown"]);
                }

                if (empty($_POST["ruangan-dropdown"])) {
                    $ruanganErr = "Ruangan tidak boleh kosong";
                } else {
                    $ruangan = test_input($_POST["ruangan-dropdown"]);
                }

                if (empty($_POST["namaSesi"])) {
                    $sesiErr = "Nama Sesi tidak boleh kosong";
                } else {
                    $sesi = test_input($_POST["namaSesi"]);
                }

                if (empty($_POST["sesi"])) {
                    $sesiKeErr = "Sesi tidak boleh kosong";
                } else {
                    $sesiKe = test_input($_POST["sesi"]);
                }

                if (empty($_POST["tanggal"])) {
                    $tanggalErr = "Tanggal tidak boleh kosong";
                } else {
                    $tanggal = test_input($_POST["tanggal"]);
                }

                if (empty($_POST["mulai"])) {
                    $mulaiErr = "Jam Mulai tidak boleh kosong";
                } else {
                    $mulai = test_input($_POST["mulai"]);
                }

                if (empty($_POST["selesai"])) {
                    $selesaiErr = "Jam Selesai tidak boleh kosong";
                } else {
                    $selesai = test_input($_POST["selesai"]);
                }
            }

            function test_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            ?>
            <table align="left">
                <tr>
                    <td>Tingkat</td>
                    <td>:</td>
                    <td>
                        <select name="tingkat-dropdown" id="tingkat-dropdown">
                            <option disabled selected> Pilih Tingkat </option>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT DISTINCT Tingkat FROM mapel");
                            while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                <option value="<?= $data['Tingkat'] ?>" <?php if ($data['Tingkat'] == "$tingkat")
                                      echo "selected" ?>>
                                    <?= $data['Tingkat'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="error">
                            <?php echo $tingkatErr; ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>Semester</td>
                    <td>:</td>
                    <td>
                        <select name="semester-dropdown" id="semester-dropdown">
                            <option disabled selected> Pilih Semester </option>
                        </select>
                        <span class="error">
                            <?php echo $semesterErr; ?>
                        </span>
                    </td>
                </tr>

                <?php
                if (!(empty($tingkat))) {
                    echo ('<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>');
                    echo ('<script>');
                    echo ('$(document).ready(function () {');
                    echo ("var tingkat_id = '$tingkat';");
                    echo ("var semester = '$semester';");
                    echo ('$.ajax({');
                    echo ('url: "get_semester.php",');
                    echo ('type: "POST",');
                    echo ('data: {');
                    echo ('tingkat_id: tingkat_id,');
                    echo ('semester: semester');
                    echo ('},');
                    echo ('cache: false,');
                    echo ('success: function (result) {');
                    echo ('$("#semester-dropdown").html(result);');
                    echo ('}');
                    echo ('});');
                    echo ('});');
                    echo ('</script>');
                }
                ?>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
                <script>
                    $(document).ready(function () {
                        $('#tingkat-dropdown').on('change', function () {
                            var tingkat_id = this.value;
                            $.ajax({
                                url: "get_semester.php",
                                type: "POST",
                                data: {
                                    tingkat_id: $("#tingkat-dropdown").val()
                                },
                                cache: false,
                                success: function (result) {
                                    $("#semester-dropdown").html(result);
                                }
                            });
                        });
                    });
                </script>

                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td>
                        <select name="jurusan-dropdown" id="jurusan-dropdown">
                            <option disabled selected> Pilih Jurusan </option>
                        </select>
                        <span class="error">
                            <?php echo $jurusanErr; ?>
                        </span>
                    </td>
                </tr>

                <?php
                if (!(empty($tingkat))) {
                    echo ('<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>');
                    echo ('<script>');
                    echo ('$(document).ready(function () {');
                    echo ("var tingkat_id = '$tingkat';");
                    echo ("var jurusan = '$jurusan';");
                    echo ('$.ajax({');
                    echo ('url: "get_jurusan.php",');
                    echo ('type: "POST",');
                    echo ('data: {');
                    echo ('tingkat_id: tingkat_id,');
                    echo ('jurusan: jurusan');
                    echo ('},');
                    echo ('cache: false,');
                    echo ('success: function (result) {');
                    echo ('$("#jurusan-dropdown").html(result);');
                    echo ('}');
                    echo ('});');
                    echo ('});');
                    echo ('</script>');
                }
                ?>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
                <script>
                    $(document).ready(function () {
                        $('#tingkat-dropdown').on('change', function () {
                            var tingkat_id = this.value;
                            $.ajax({
                                url: "get_jurusan.php",
                                type: "POST",
                                data: {
                                    tingkat_id: tingkat_id
                                },
                                cache: false,
                                success: function (result) {
                                    $("#jurusan-dropdown").html(result);
                                }
                            });
                        });
                    });
                </script>

                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>
                        <select name="kelas-dropdown" id="kelas-dropdown">
                            <option disabled selected> Pilih Kelas </option>
                        </select>
                        <span class="error">
                            <?php echo $kelasErr; ?>
                        </span>
                    </td>
                </tr>

                <?php
                if (!(empty($jurusan))) {
                    echo ('<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>');
                    echo ('<script>');
                    echo ('$(document).ready(function () {');
                    echo ("var jurusan_id = '$jurusan';");
                    echo ("var tingkat_id = '$tingkat';");
                    echo ("var kelas = '$kelas';");
                    echo ('$.ajax({');
                    echo ('url: "get_kelas.php",');
                    echo ('type: "POST",');
                    echo ('data: {');
                    echo ('tingkat_id: tingkat_id,');
                    echo ('jurusan_id: jurusan_id,');
                    echo ('kelas: kelas');
                    echo ('},');
                    echo ('cache: false,');
                    echo ('success: function (result) {');
                    echo ('$("#kelas-dropdown").html(result);');
                    echo ('}');
                    echo ('});');
                    echo ('});');
                    echo ('</script>');
                }
                ?>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
                <script>
                    $(document).ready(function () {
                        $('#jurusan-dropdown').on('change', function () {
                            var jurusan_id = this.value;
                            $.ajax({
                                url: "get_kelas.php",
                                type: "POST",
                                data: {
                                    jurusan_id: jurusan_id,
                                    tingkat_id: $("#tingkat-dropdown").val()
                                },
                                cache: false,
                                success: function (result) {
                                    $("#kelas-dropdown").html(result);
                                }
                            });
                        });
                    });
                </script>

                <tr>
                    <td>Mapel</td>
                    <td>:</td>
                    <td>
                        <select name="mapel-dropdown" id="mapel-dropdown">
                            <option disabled selected> Pilih Mapel </option>
                        </select>
                        <span class="error">
                            <?php echo $mapelErr; ?>
                        </span>
                    </td>
                </tr>

                <?php
                if (!(empty($kelas))) {
                    echo ('<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>');
                    echo ('<script>');
                    echo ('$(document).ready(function () {');
                    echo ("var jurusan_id = '$jurusan';");
                    echo ("var tingkat_id = '$tingkat';");
                    echo ("var mapel = '$mapel';");
                    echo ('$.ajax({');
                    echo ('url: "get_mapel.php",');
                    echo ('type: "POST",');
                    echo ('data: {');
                    echo ('tingkat_id: tingkat_id,');
                    echo ('jurusan_id: jurusan_id,');
                    echo ('mapel: mapel');
                    echo ('},');
                    echo ('cache: false,');
                    echo ('success: function (result) {');
                    echo ('$("#mapel-dropdown").html(result);');
                    echo ('}');
                    echo ('});');
                    echo ('});');
                    echo ('</script>');
                }
                ?>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
                <script>
                    $(document).ready(function () {
                        $('#jurusan-dropdown').on('change', function () {
                            var jurusan_id = this.value;
                            $.ajax({
                                url: "get_mapel.php",
                                type: "POST",
                                data: {
                                    jurusan_id: jurusan_id,
                                    tingkat_id: $("#tingkat-dropdown").val()
                                },
                                cache: false,
                                success: function (result) {
                                    $("#mapel-dropdown").html(result);
                                }
                            });
                        });
                    });
                </script>

                <tr>
                    <td>Tahun</td>
                    <td>:</td>
                    <td><input type="number" min="<?php echo date("Y"); ?>" name="tahun" size="30"
                            value="<?php echo $tahun; ?>"> <span class="error">
                            <?php echo $tahunErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Guru</td>
                    <td>:</td>
                    <td>
                        <select name="guru-dropdown" id="guru-dropdown">
                            <option disabled selected> Pilih Guru </option>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT IDGuru, Nama FROM dataguru");
                            while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                <option value="<?= $data['IDGuru'] ?>" <?php if ($data['IDGuru'] == $guru)
                                      echo "selected" ?>>
                                    <?= $data['Nama'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="error">
                            <?php echo $guruErr; ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>Lantai</td>
                    <td>:</td>
                    <td>
                        <select name="lantai-dropdown" id="lantai-dropdown">
                            <option disabled selected> Pilih Lantai </option>
                            <option value="1" <?php if ($lantai == 1)
                                echo "selected" ?>>1</option>
                                <option value="2" <?php if ($lantai == 2)
                                echo "selected" ?>>2</option>
                                <option value="3" <?php if ($lantai == 3)
                                echo "selected" ?>>3</option>
                            </select>
                            <span class="error">
                            <?php echo $lantaiErr; ?>
                        </span>
                    </td>
                </tr>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
                <script>
                    $(document).ready(function () {
                        $('#lantai-dropdown').on('change', function () {
                            var lantai_id = this.value;
                            $.ajax({
                                url: "get_ruangan.php",
                                type: "POST",
                                data: {
                                    lantai_id: lantai_id
                                },
                                cache: false,
                                success: function (result) {
                                    $("#ruangan-dropdown").html(result);
                                }
                            });
                        });
                    });
                </script>

                <tr>
                    <td>Ruangan</td>
                    <td>:</td>
                    <td>
                        <select name="ruangan-dropdown" id="ruangan-dropdown">
                            <option disabled selected> Pilih Ruangan </option>
                        </select>
                        <span class="error">
                            <?php echo $ruanganErr; ?>
                        </span>
                    </td>
                </tr>

                <?php
                if (!(empty($lantai))) {
                    echo ('<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>');
                    echo ('<script>');
                    echo ('$(document).ready(function () {');
                    echo ("var lantai_id = '$lantai';");
                    echo ("var ruangan = '$ruangan';");
                    echo ('$.ajax({');
                    echo ('url: "get_ruangan.php",');
                    echo ('type: "POST",');
                    echo ('data: {');
                    echo ('lantai_id: lantai_id,');
                    echo ('ruangan: ruangan');
                    echo ('},');
                    echo ('cache: false,');
                    echo ('success: function (result) {');
                    echo ('$("#ruangan-dropdown").html(result);');
                    echo ('}');
                    echo ('});');
                    echo ('});');
                    echo ('</script>');
                }
                ?>

                <tr>
                    <td>Nama Sesi</td>
                    <td>:</td>
                    <td><input type="text" name="namaSesi" size="30" value="<?php echo $sesi; ?>"> <span class="error">
                            <?php echo $sesiErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Sesi Ke</td>
                    <td>:</td>
                    <td><input type="number" min="1" name="sesi" size="30" value="<?php echo $sesiKe; ?>"> <span
                            class="error">
                            <?php echo $sesiKeErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><input type="date" name="tanggal" size="30" value="<?php echo $tanggal; ?>"> <span
                            class="error">
                            <?php echo $tanggalErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Jam Mulai</td>
                    <td>:</td>
                    <td><input type="time" name="mulai" step="1" size="30" value="<?php echo $mulai; ?>"> <span
                            class="error">
                            <?php echo $mulaiErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Jam Selesai</td>
                    <td>:</td>
                    <td><input type="time" name="selesai" step="1" size="30" value="<?php echo $selesai; ?>"> <span
                            class="error">
                            <?php echo $selesaiErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" value="Add">
                    </td>
                </tr>
            </table>
    </form>
    </isi>
</body>

</html>
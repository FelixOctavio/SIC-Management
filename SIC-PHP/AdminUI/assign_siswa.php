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
    <title>Assign Siswa</title>
    <link rel="stylesheet" href="style.css">
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
                    <a href="assign_siswa.php#" class="active">Memasukkan Siswa ke dalam Kelas</a>
                </li>
                <li>
                    <a href="tambah_sesi.php">Membuat Sesi</a>
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
        if (!(empty($_POST["nama-dropdown"]) || empty($_POST["tingkat-dropdown"]) || empty($_POST["jurusan-dropdown"]) || empty($_POST["kelas-dropdown"]) || empty($_POST["tahunAjaran"]))) {
            $nama = $_POST['nama-dropdown'];
            $tingkat = $_POST['tingkat-dropdown'];
            $jurusan = $_POST['jurusan-dropdown'];
            $kelas = $_POST['kelas-dropdown'];
            $tahun = $_POST['tahunAjaran'];

            $queryKelas = mysqli_query($koneksi, "SELECT IDKelas FROM kelas WHERE Tingkat='$tingkat' AND Jurusan='$jurusan' AND KodeKelas='$kelas'") or die(mysqli_error($koneksi));

            while ($data = mysqli_fetch_array($queryKelas)) { //Hasil output querynya masih berupa object, jadi harus difetch
                $idKelas = ($data['IDKelas']);
            }

            $check = mysqli_query($koneksi, "SELECT * FROM listsiswa WHERE IDKelas='$idKelas' AND IDSiswa='$nama' AND Tahun='$tahun'") or die(mysqli_error($koneksi));
            while ($data = mysqli_fetch_array($check)) { //Kalo ketemu data yang sama di tabel
                echo "<script>alert('Terdapat duplikat data!');</script>";
                $cancel = 1;
                break;
            }

            if (!($cancel)) {
                $query = mysqli_query($koneksi, "INSERT INTO listsiswa (IDKelas, IDSiswa, Tahun)
                VALUES ('$idKelas', '$nama', '$tahun')") or die(mysqli_error($koneksi));

                if ($query)
                    echo "<script>alert('Assign siswa berhasil');</script>";
                else
                    echo "<script>alert('Gagal assign siswa');</script>";
            }
        }
        ?>

        <?php
        include "../Connection.php";
        ?>

        <isi>
            <?php
            $namaErr = $tingkatErr = $jurusanErr = $kelasErr = $tahunErr = "";
            $nama = $tingkat = $jurusan = $kelas = $tahun = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["nama-dropdown"])) {
                    $namaErr = "Nama tidak boleh kosong";
                } else {
                    $nama = test_input($_POST["nama-dropdown"]);
                }

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

                if (empty($_POST["tahunAjaran"])) {
                    $tahunErr = "Tahun tidak boleh kosong";
                } else {
                    $tahun = test_input($_POST["tahunAjaran"]);
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
                    <td>Nama</td>
                    <td>:</td>
                    <td>
                        <select name="nama-dropdown" id="nama-dropdown">
                            <option disabled selected> Pilih Nama </option>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT IDSiswa, Nama FROM datasiswa ORDER BY IDSiswa DESC;");
                            while ($data = mysqli_fetch_array($sql)) {
                                ?>
                                <option value="<?= $data['IDSiswa'] ?>" <?php if ($data['IDSiswa'] == "$nama")
                                      echo "selected" ?>>
                                    <?= $data['IDSiswa'] ?> - <?= $data['Nama'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="error">
                            <?php echo $namaErr; ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>Tingkat</td>
                    <td>:</td>
                    <td>
                        <select name="tingkat-dropdown" id="tingkat-dropdown">
                            <option disabled selected> Pilih Tingkat </option>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT DISTINCT Tingkat FROM kelas");
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
                    <td>Tahun Ajaran</td>
                    <td>:</td>
                    <td><input type="number" name="tahunAjaran" min="<?php echo date("Y") ?>" size="30" value="<?php echo $tahun; ?>"> <span class="error"><?php echo $tahunErr; ?></span></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" value="Add"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>
    </form>
    </isi>
</body>

</html>
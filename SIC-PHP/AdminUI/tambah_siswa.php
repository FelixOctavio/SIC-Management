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
    <title>Tambah siswa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../logo.png">
</head>

<body>
    <header>
        <nav class="navbar">
            <ul>
                <li>
                    <a href="tambah_siswa.php#" class="active">Memasukkan Siswa</a>
                </li>
                <li>
                    <a href="tambah_guru.php">Memasukkan Guru</a>
                </li>
                <li>
                    <a href="assign_siswa.php">Memasukkan Siswa ke dalam Kelas</a>
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
        if (!(empty($_POST["Nama"]) || empty($_POST["NomorTelepon"]) || empty($_POST["Alamat"]) || empty($_POST["TempatLahir"]) || empty($_POST["TanggalLahir"]) || empty($_POST["NamaOrtu"]))) {
            ?>
            <?php
            include "../Connection.php";

            $nama = $_POST['Nama'];
            $noTelp = $_POST['NomorTelepon'];
            $alamat = $_POST['Alamat'];
            $tempatLahir = $_POST['TempatLahir'];
            $tanggalLahir = $_POST['TanggalLahir'];
            $namaOrtu = $_POST['NamaOrtu'];

            $cancel = 0;

            $check = mysqli_query($koneksi, "SELECT Nama, NomorTelepon, Alamat, TempatLahir, TanggalLahir, NamaOrtu FROM datasiswa WHERE Nama='$nama' AND NomorTelepon='$noTelp' AND Alamat='$alamat' AND TempatLahir='$tempatLahir' AND TanggalLahir='$tanggalLahir' AND NamaOrtu='$namaOrtu'") or die(mysqli_error($koneksi));
            while ($data = mysqli_fetch_array($check)) { //Kalo ketemu data yang sama di tabel
                echo "<script>alert('Terdapat duplikat data!');</script>";
                $cancel = 1;
                break;
            }

            if (!($cancel)) {
                $queryTahun = mysqli_query($koneksi, "SELECT IDSiswa FROM datasiswa WHERE IDSiswa LIKE CONCAT ((SELECT YEAR(CURDATE())), '%') ORDER BY IDSiswa DESC LIMIT 1") or die(mysqli_error($koneksi));
                $idSiswa = date("Y") . "001";

                while ($data = mysqli_fetch_array($queryTahun)) { //Hasil output querynya masih berupa object, jadi harus difetch
                    $idSiswa = ($data['IDSiswa']) + 1;
                }

                $query = mysqli_query($koneksi, "INSERT INTO datasiswa(IDSiswa, Nama, NomorTelepon, Alamat, TempatLahir, TanggalLahir, NamaOrtu)
                VALUES ('$idSiswa', '$nama', '$noTelp', '$alamat', '$tempatLahir', '$tanggalLahir', '$namaOrtu')") or die(mysqli_error($koneksi));

                $query = mysqli_query($koneksi, "INSERT INTO userlogin(IDUser, UserPassword, Role)
                VALUES ('$idSiswa', MD5('password'), 'Siswa')") or die(mysqli_error($koneksi));

                if ($query)
                    echo "<script>alert('Siswa berhasil ditambahkan');</script>";
                else
                    echo "<script>alert('Gagal menambahkan siswa');</script>";
            }
        }
        ?>
        <isi>
            <?php
            $namaErr = $telpErr = $alamatErr = $tempatLahirErr = $tanggalLahirErr = $namaOrtuErr = "";
            $nama = $telp = $alamat = $tempatLahir = $tanggalLahir = $namaOrtu = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["Nama"])) {
                    $namaErr = "Nama tidak boleh kosong";
                } else {
                    $nama = test_input($_POST["Nama"]);
                }

                if (empty($_POST["NomorTelepon"])) {
                    $telpErr = "Nomor telepon tidak boleh kosong";
                } else {
                    $telp = test_input($_POST["NomorTelepon"]);
                }

                if (empty($_POST["Alamat"])) {
                    $alamatErr = "Alamat tidak boleh kosong";
                } else {
                    $alamat = test_input($_POST["Alamat"]);
                }

                if (empty($_POST["TempatLahir"])) {
                    $tempatLahirErr = "Tempat lahir tidak boleh kosong";
                } else {
                    $tempatLahir = test_input($_POST["TempatLahir"]);
                }

                if (empty($_POST["TanggalLahir"])) {
                    $tanggalLahirErr = "Tanggal lahir tidak boleh kosong";
                } else {
                    $tanggalLahir = test_input($_POST["TanggalLahir"]);
                }

                if (empty($_POST["NamaOrtu"])) {
                    $namaOrtuErr = "Nama ortu tidak boleh kosong";
                } else {
                    $namaOrtu = test_input($_POST["Nama"]);
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
                    <td>Nama Siswa</td>
                    <td>:</td>
                    <td><input type="text" name="Nama" size="30" value="<?php echo $nama; ?>"> <span class="error">
                            <?php echo $namaErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Nomor Telepon</td>
                    <td>:</td>
                    <td><input type="number" min="0" name="NomorTelepon" size="30" value="<?php echo $telp; ?>"> <span
                            class="error">
                            <?php echo $telpErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><input type="text" name="Alamat" size="30" value="<?php echo $alamat; ?>"> <span class="error">
                            <?php echo $alamatErr; ?>
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>Tempat Lahir</td>
                    <td>:</td>
                    <td><input type="text" name="TempatLahir" size="30" value="<?php echo $tempatLahir; ?>"> <span
                            class="error">
                            <?php echo $tempatLahirErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td><input type="date" name="TanggalLahir" size="30" value="<?php echo $tanggalLahir; ?>"> <span
                            class="error">
                            <?php echo $tanggalLahirErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Nama Ortu</td>
                    <td>:</td>
                    <td><input type="text" name="NamaOrtu" size="30" value="<?php echo $namaOrtu; ?>"> <span class="error">
                            <?php echo $namaOrtuErr; ?>
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
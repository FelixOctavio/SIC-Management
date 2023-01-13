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
    <title>Tambah poin siswa</title>
    <link rel="stylesheet" href="style.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
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
                    <a href="tambah_sesi.php">Membuat Sesi</a>
                </li>
                <li>
                    <a href="tambah_poin.php#" class="active">Memberi poin siswa</a>
                </li>
                <li>
                    <a href="../logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php
        if (!(empty($_POST["Nama"]) || empty($_POST["Keterangan"]) || empty($_POST["Poin"]) || empty($_POST["Tanggal"]))) {
            ?>
            <?php
            include "../Connection.php";

            $IDSiswa = $_POST['Nama'];
            $JudulPoin = $_POST['Keterangan'];
            $JumlahPoin = $_POST['Poin'];
            $Tanggal = $_POST['Tanggal'];

            $IDPoin = '1';
            $QueryPoin = mysqli_query($koneksi, "SELECT IDPoin FROM poinsiswa WHERE IDSiswa='$IDSiswa'");
            while ($data = mysqli_fetch_array($QueryPoin)) {
                $IDPoin = ($data['IDPoin']) + 1;
            }

            $query = mysqli_query($koneksi, "INSERT INTO poinsiswa (IDPoin, IDSiswa, JudulPoin, JumlahPoin, Tanggal)
            VALUES ('$IDPoin', '$IDSiswa', '$JudulPoin', '$JumlahPoin', '$Tanggal')") or die(mysqli_error($koneksi));

            if ($query)
                echo "<script>alert('Poin siswa berhasil ditambahkan');</script>";
            else
                echo "<script>alert('Gagal menambahkan Poin siswa');</script>";
        }
        ?>

        <?php
        include "../Connection.php";
        ?>
        <isi>
            <?php
            $namaErr = $poinErr = $judulErr = $tanggalErr = "";
            $nama = $poin = $judul = $tanggal = "";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST["Nama"])) {
                    $namaErr = "Nama tidak boleh kosong";
                } else {
                    $nama = test_input($_POST["Nama"]);
                }

                if (empty($_POST["Poin"])) {
                    $poinErr = "Poin tidak boleh kosong";
                } else {
                    $poin = test_input($_POST["Poin"]);
                }

                if (empty($_POST["Keterangan"])) {
                    $judulErr = "Judul tidak boleh kosong";
                } else {
                    $judul = test_input($_POST["Keterangan"]);
                }

                if (empty($_POST["Tanggal"])) {
                    $tanggalErr = "Tanggal tidak boleh kosong";
                } else {
                    $tanggal = test_input($_POST["Tanggal"]);
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
                        <form method="POST">
                            <select name="Nama" id="Nama">
                                <option disabled selected> Pilih nama </option>
                                <?php
                                $sql = mysqli_query($koneksi, "SELECT IDSiswa, Nama FROM datasiswa ORDER BY Nama");
                                while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                    <option value="<?= $data['IDSiswa'] ?>" <?php if ($data['IDSiswa'] == "$nama")
                                          echo "selected" ?>>
                                        <?= $data['Nama'] ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="error">
                                <?php echo $namaErr; ?>
                            </span>
                        </form>
                    </td>

                    <!-- kode di bawah ini buat bikin dropdown yang ada search nya, tapi kalo pake itu, malah ga bisa deteksi index terpilih. jadi ga ku pake -->
                    <!-- <script type="text/javascript">
  $(document).ready(function() {
      $('#nama').select2({
      placeholder: 'Pilih Nama',
      allowClear: false
     });
  });
 </script> -->
                </tr>

                <tr>
                    <td>Jumlah Poin</td>
                    <td>:</td>
                    <td><input type="number" id="Poin" name="Poin" size="30" value="<?php echo $poin; ?>"> <span
                            class="error">
                            <?php echo $poinErr; ?>
                        </span></td>
                </tr>

                <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
                <script>
                    $(document).ready(function () {
                        $('#Poin').on('change', function () {
                            if (this.value == 0) alert('Poin tidak boleh 0');
                        });
                    });
                </script>

                <tr>
                    <td>Judul Poin</td>
                    <td>:</td>
                    <td><input type="text" name="Keterangan" size="30" value="<?php echo $judul; ?>"> <span
                            class="error">
                            <?php echo $judulErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><input type="date" name="Tanggal" size="30" value="<?php echo $tanggal; ?>"> <span
                            class="error">
                            <?php echo $tanggalErr; ?>
                        </span></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td><input type="submit" value="Add"></td>
                </tr>
            </table>
    </form>
    </isi>
</body>

</html>
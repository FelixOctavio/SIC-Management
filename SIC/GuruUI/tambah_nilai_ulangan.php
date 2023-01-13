<?php
include("../UserRole.php");
if ($_SESSION['role'] != "guru") {
   header("location:../index.php");
   exit();
}
?>

<html>

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <title>Tambah Nilai Ulangan</title>
   <link href="style.css" type="text/css" rel="stylesheet">
   <link rel="icon" href="../logo.png">
</head>

<body>
   <header>
      <nav class="navbar">
         <ul>
            <li>
               <a href="tambah_nilai_ulangan.php#" class="active">Memasukkan Nilai Ulangan</a>
            </li>
            <li>
               <a href="tambah_nilai_tugas.php">Memasukkan Nilai Tugas</a>
            </li>
            <li>
               <a href="attendance.php">Kehadiran</a>
            </li>
            <li>
               <a href="../logout.php">Logout</a>
            </li>
         </ul>
      </nav>
   </header>
   <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <?php
      if (!(empty($_POST["idulangan"]) || empty($_POST["nama-dropdown"]) || empty($_POST["jurusan-dropdown"]) || empty($_POST["tingkat-dropdown"]) || empty($_POST["semester-dropdown"]) || empty($_POST["mapel-dropdown"]) || empty($_POST["tipe-dropdown"]) || empty($_POST["ulangan"]) || empty($_POST["nilai"]))) {
         ?>
         <?php
         include "../Connection.php";

         $id_ulangan = $_POST['idulangan'];
         $nama = $_POST['nama-dropdown'];
         $jurusan = $_POST['jurusan-dropdown'];
         $tingkat = $_POST['tingkat-dropdown'];
         $tahun = $_POST['tahun-dropdown'];
         $semester = $_POST['semester-dropdown'];
         $mapel = $_POST['mapel-dropdown'];
         $tipe = $_POST['tipe-dropdown'];
         $ulangan = $_POST['ulangan'];
         $nilai = $_POST['nilai'];

         $querySiswa = mysqli_query($koneksi, "SELECT IDSiswa FROM datasiswa WHERE Nama='$nama'") or die(mysqli_error($koneksi));

         while ($data = mysqli_fetch_array($querySiswa)) { //Hasil output querynya masih berupa object, jadi harus difetch
            $idSiswa = ($data['IDSiswa']);
         }

         $queryMapel = mysqli_query($koneksi, "SELECT IDMapel FROM mapel WHERE Tingkat='$tingkat' AND Jurusan='$jurusan' AND NamaMapel='$mapel' ") or die(mysqli_error($koneksi));

         while ($data = mysqli_fetch_array($queryMapel)) { //Hasil output querynya masih berupa object, jadi harus difetch
            $idMapel = ($data['IDMapel']);
         }

         $check = mysqli_query($koneksi, "SELECT IDUlangan, IDMapel, IDSiswa, Semester, Tahun, TipeUlangan, NamaUlangan FROM nilaiulangan
         WHERE IDUlangan='$id_ulangan' AND IDMapel='$idMapel' AND IDSiswa='$idSiswa' AND Semester='$semester' AND Tahun='$tahun'AND TipeUlangan='$tipe' AND NamaUlangan='$ulangan'") or die(mysqli_error($koneksi));
         while ($data = mysqli_fetch_array($check)) { //Kalo ketemu data yang sama di tabel
            echo "<script>alert('Terdapat duplikat data!');</script>";
            $cancel = 1;
            break;
        }

         if (!($cancel)) {
            $query = mysqli_query($koneksi, "INSERT INTO nilaiulangan (IDUlangan, IDMapel, IDSiswa, Semester, Tahun, TipeUlangan, NamaUlangan, Nilai)
            VALUES ('$id_ulangan', '$idMapel', '$idSiswa', '$semester', '$tahun', '$tipe', '$ulangan', '$nilai')") or die(mysqli_error($koneksi));

            if ($query)
               echo "<script>alert('Nilai ulangan berhasil ditambahkan');</script>";
            else
               echo "<script>alert('Gagal menambahkan nilai ulangan siswa');</script>";
         }
      }
      ?>

      <?php
      include "../Connection.php";
      ?>

      <isi>
         <?php
         $idulanganErr = $namaErr = $jurusanErr = $tahunErr = $semesterErr = $mapelErr = $tipeErr = $ulanganErr = $nilaiErr = $tingkatErr = $kelasErr = $ulanganErr = "";
         $idulangan = $nama = $jurusan = $tahun = $semester = $mapel = $tipe = $ulangan = $nilai = $tingkat = $kelas = $ulanganErr = "";
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["idulangan"])) {
               $idulanganErr = "Ulangan ke tidak boleh kosong";
            } else {
               $idulangan = test_input($_POST["idulangan"]);
            }

            if (empty($_POST["nama-dropdown"])) {
               $namaErr = "Nama tidak boleh kosong";
            } else {
               $nama = test_input($_POST["nama-dropdown"]);
            }

            if (empty($_POST["jurusan-dropdown"])) {
               $jurusanErr = "Jurusan tidak boleh kosong";
            } else {
               $jurusan = test_input($_POST["jurusan-dropdown"]);
            }

            if (empty($_POST["tingkat-dropdown"])) {
               $tingkatErr = "Tingkat tidak boleh kosong";
            } else {
               $tingkat = test_input($_POST["tingkat-dropdown"]);
            }

            if (empty($_POST["tahun-dropdown"])) {
               $tahunErr = "Tahun tidak boleh kosong";
            } else {
               $tahun = test_input($_POST["tahun-dropdown"]);
            }

            if (empty($_POST["semester-dropdown"])) {
               $semesterErr = "Semester tidak boleh kosong";
            } else {
               $semester = test_input($_POST["semester-dropdown"]);
            }

            if (empty($_POST["mapel-dropdown"])) {
               $mapelErr = "Mapel tidak boleh kosong";
            } else {
               $mapel = test_input($_POST["mapel-dropdown"]);
            }

            if (empty($_POST["tipe-dropdown"])) {
               $tipeErr = "Tipe tidak boleh kosong";
            } else {
               $tipe = test_input($_POST["tipe-dropdown"]);
            }

            if (empty($_POST["ulangan"])) {
               $ulanganErr = "Ulangan tidak boleh kosong";
            } else {
               $ulangan = test_input($_POST["ulangan"]);
            }

            if (empty($_POST["nilai"])) {
               $nilaiErr = "Nilai tidak boleh kosong";
            } else {
               $nilai = test_input($_POST["nilai"]);
            }

            if (empty($_POST["kelas-dropdown"])) {
               $kelasErr = "Kelas tidak boleh kosong";
            } else {
               $kelas = test_input($_POST["kelas-dropdown"]);
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
               <td>Nama Mapel</td>
               <td>:</td>
               <td>
                  <select name="mapel-dropdown" id="mapel-dropdown">
                     <?php
                     $idguru = $_SESSION['UserID'];
                     $sql = mysqli_query($koneksi, "SELECT DISTINCT mapel.NamaMapel
                     FROM sesimapel
                     JOIN mapel ON (mapel.IDMapel = sesimapel.IDMapel)
                     WHERE sesimapel.IDGuru = '$idguru' ORDER BY mapel.NamaMapel ASC;");
                     while ($data = mysqli_fetch_array($sql)) {
                        ?>
                        <option selected value="<?= $data['NamaMapel'] ?>">
                           <?= $data['NamaMapel'] ?>
                        </option>
                        <?php
                     }
                     ?>
                  </select>
               </td>
            </tr>

            <tr>
               <td>Tingkat</td>
               <td>:</td>
               <td>
                  <select name="tingkat-dropdown" id="tingkat-dropdown">
                     <option disabled selected> Pilih Tingkat </option>
                     <?php
                     $sql = mysqli_query($koneksi, "SELECT DISTINCT mapel.Tingkat
                     FROM sesimapel
                     JOIN mapel ON (mapel.IDMapel = sesimapel.IDMapel)
                     WHERE sesimapel.IDGuru = $idguru ORDER BY mapel.Tingkat");
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
               <td>Tahun</td>
               <td>:</td>
               <td>
                  <select name="tahun-dropdown" id="tahun-dropdown">
                     <option disabled selected> Pilih Tahun </option>
                  </select>
                  <span class="error">
                     <?php echo $tahunErr; ?>
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
               echo ("var kelas_id = '$kelas';");
               echo ("var tahun = '$tahun';");
               echo ('$.ajax({');
               echo ('url: "get_tahun.php",');
               echo ('type: "POST",');
               echo ('data: {');
               echo ('tingkat_id: tingkat_id,');
               echo ('jurusan_id: jurusan_id,');
               echo ('kelas_id: kelas_id,');
               echo ('tahun: tahun');
               echo ('},');
               echo ('cache: false,');
               echo ('success: function (result) {');
               echo ('$("#tahun-dropdown").html(result);');
               echo ('}');
               echo ('});');
               echo ('});');
               echo ('</script>');
            }
            ?>

            <script>
               $(document).ready(function () {
                  $('#kelas-dropdown').on('change', function () {
                     var kelas_id = this.value;
                     $.ajax({
                        url: "get_tahun.php",
                        type: "POST",
                        data: {
                           jurusan_id: $("#jurusan-dropdown").val(),
                           tingkat_id: $("#tingkat-dropdown").val(),
                           kelas_id: kelas_id
                        },
                        cache: false,
                        success: function (result) {
                           $("#tahun-dropdown").html(result);
                        }
                     });
                  });
               });
            </script>

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
            if (!(empty($tahun))) {
               echo ('<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>');
               echo ('<script>');
               echo ('$(document).ready(function () {');
               echo ("var jurusan_id = '$jurusan';");
               echo ("var tingkat_id = '$tingkat';");
               echo ("var kelas_id = '$kelas';");
               echo ("var tahun_id = '$tahun';");
               echo ("var semester = '$semester';");
               echo ('$.ajax({');
               echo ('url: "get_semester.php",');
               echo ('type: "POST",');
               echo ('data: {');
               echo ('tingkat_id: tingkat_id,');
               echo ('jurusan_id: jurusan_id,');
               echo ('kelas_id: kelas_id,');
               echo ('tahun_id: tahun_id,');
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

            <script>
               $(document).ready(function () {
                  $('#tahun-dropdown').on('change', function () {
                     var tahun_id = this.value;
                     $.ajax({
                        url: "get_semester.php",
                        type: "POST",
                        data: {
                           jurusan_id: $("#jurusan-dropdown").val(),
                           tingkat_id: $("#tingkat-dropdown").val(),
                           kelas_id: $("#kelas-dropdown").val(),
                           tahun_id: tahun_id
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
               <td>Nama</td>
               <td>:</td>
               <td>
                  <select name="nama-dropdown" id="nama-dropdown">
                     <option disabled selected> Pilih Nama </option>
                  </select>
                  <span class="error">
                     <?php echo $namaErr; ?>
                  </span>
               </td>
            </tr>

            <?php
            if (!(empty($semester))) {
               echo ('<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>');
               echo ('<script>');
               echo ('$(document).ready(function () {');
               echo ("var jurusan_id = '$jurusan';");
               echo ("var tingkat_id = '$tingkat';");
               echo ("var kelas_id = '$kelas';");
               echo ("var tahun_id = '$tahun';");
               echo ("var semester_id = '$semester';");
               echo ("var nama = '$nama';");
               echo ('$.ajax({');
               echo ('url: "get_nama.php",');
               echo ('type: "POST",');
               echo ('data: {');
               echo ('tingkat_id: tingkat_id,');
               echo ('jurusan_id: jurusan_id,');
               echo ('kelas_id: kelas_id,');
               echo ('tahun_id: tahun_id,');
               echo ('semester_id: semester_id,');
               echo ('nama: nama');
               echo ('},');
               echo ('cache: false,');
               echo ('success: function (result) {');
               echo ('$("#nama-dropdown").html(result);');
               echo ('}');
               echo ('});');
               echo ('});');
               echo ('</script>');
            }
            ?>

            <script>
               $(document).ready(function () {
                  $('#semester-dropdown').on('change', function () {
                     var semester_id = this.value;
                     $.ajax({
                        url: "get_nama.php",
                        type: "POST",
                        data: {
                           jurusan_id: $("#jurusan-dropdown").val(),
                           tingkat_id: $("#tingkat-dropdown").val(),
                           kelas_id: $("#kelas-dropdown").val(),
                           semester_id: semester_id,
                           tahun_id: $("#tahun-dropdown").val(),
                        },
                        cache: false,
                        success: function (result) {
                           $("#nama-dropdown").html(result);
                        }
                     });
                  });
               });
            </script>

            <tr>
               <td>Tipe Ulangan</td>
               <td>:</td>
               <td>
                  <select name="tipe-dropdown" id="tipe-dropdown">
                     <option disabled <?php if ($tipe == "")
                        echo "selected" ?>> Pilih Tipe Ulangan </option>
                        <option value="UTS" <?php if ($tipe == "UTS")
                        echo "selected" ?>>UTS</option>
                        <option value="UAS" <?php if ($tipe == "UAS")
                        echo "selected" ?>>UAS</option>
                     </select>
                     <span class="error">
                     <?php echo $tipeErr; ?>
                  </span>
               </td>
            </tr>

            <tr>
               <td>Ulangan ke</td>
               <td>:</td>
               <td><input type="number" min="1" name="idulangan" value="<?php echo $idulangan; ?>"> <span class="error">
                     <?php echo $idulanganErr; ?>
                  </span></td>
            </tr>

            <tr>
               <td>Nama Ulangan</td>
               <td>:</td>
               <td><input type="text" name="ulangan" value="<?php echo $ulangan; ?>"><span class="error">
                     <?php echo $ulanganErr; ?>
                  </span> </td>
            </tr>

            <tr>
               <td>Nilai</td>
               <td>:</td>
               <td><input type="number" min="0" max="100" name="nilai" value="<?php echo $nilai; ?>"> <span
                     class="error">
                     <?php echo $nilaiErr; ?>
                  </span> </td>
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
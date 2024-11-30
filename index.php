<?php 
include "koneksi.php";

//menyimpan data
$nim = "";
$nama = "";
$alamat = "";
$fakultas = "";
$error = "";
$sukses = "";

//proses crud 
if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

//delete
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM mahasiswa WHERE id = '$id'";
    $query = mysqli_query($koneksi,$sql);
    $sukses = $query ? "Data berhasil di hapus" : "Gagal menghapus data";
}

// edit 
if ($op == 'edit'){
    $id = $_GET['id'];
    $sql = "SELECT * FROM mahasiswa WHERE id = '$id'";
    $query = mysqli_query($koneksi, $sql);
    $data = mysqli_fetch_array($query);
    if ($data) {
        $nim = $data ['nim'];
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $fakultas = $data['fakultas'];
    }else {
        $error = "Data tidak ditemeukan";
    }
}

//create / Update

if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $fakultas = $_POST['fakultas'];

    if ($nim && $nama && $alamat && $fakultas) {
        if ($op == 'edit') {
            $sql = "UPDATE mahasiswa SET nim='$nim', nama='$nama', alamat='$alamat', fakultas='$fakultas' WHERE id='$id'";
        } else { 
            mysqli_report(MYSQLI_REPORT_OFF); // Nonaktifkan error otomatis
            $sql = "INSERT INTO mahasiswa (nim, nama, alamat, fakultas) VALUES ('$nim', '$nama', '$alamat', '$fakultas')";

        }
        $query = mysqli_query($koneksi, $sql);
        $sukses = $query ? "Data berhasil di simpan" : "Gagal menyimpan data "; 
    } else {
        $error = "Harap isi semua data";

    }
}

?>
<!--  form ceate/edit -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
</head>
<body>
    <div class="card">
        <div class="card-header">From input data</div>
        <div class="card-body">
            <?php if ($error) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
               <?php  }?>
               <?php if  ($sukses){ ?>
                <div class="alert alert-succes"><?php echo $sukses; ?></div>
                <?php } ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim;?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama;?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat;?>">
                    </div>
                    <div class="mb-3">
                    <label for="fakultas">fakultas</label>
                    <select class="form-control" name="fakultas" id="fakultas">
                        <option value="">Pilih Fakultas</option>
                        <option value="saintek" <?php echo ($fakultas == "saintek") ? "selected" : ""; ?>>Saintek</option>
                        <option value="soshum" <?php echo ($fakultas == "soshum") ? "selected" : ""; ?>>Soshum</option>
                    </select>
                    </div>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
        </div>
    </div>
<!--  Tabel untuk Menampilkan Data -->

<div class="card mt-3">
    <div class="card-header">Data Mahasiswa</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Fakultas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT * FROM mahasiswa ORDER BY id DESC";
                $query = mysqli_query($koneksi, $sql);
                $no = 1;
                while ($data = mysqli_fetch_array($query)){
                    echo " <tr>
                    <td>$no </td>
                    <td>{$data['nim']}</td>
                    <td>{$data['nama']} </td>
                    <td>{$data['alamat']} </td>
                    <td>{$data['fakultas']} </td>
                    <td> 
                    <a href='index.php?op=edit&id={$data['id']}' class='btn btn-warning'>Edit </a>
                    <a href='index.php?op=delete&id={$data['id']}' onclick='return confirm(\"Hapus data?\")' class='btb btn=danger'>Delete </a>
                    </td>
                     </tr>";
                     $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
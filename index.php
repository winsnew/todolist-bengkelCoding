<?php
include_once('./connect/connect.php');
include './connect/skrip.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>To Do List</title> <!--Judul Halaman-->
</head>

<body>
    <div class="container">
        <h3 class="text-center">
            TO DO LIST
            <small class="text-muted">Catat Kegiatan</small>
        </h3>
        <hr>
        <form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
            <!-- Kode php untuk menghubungkan form dengan database -->
            <?php
            $isi = '';
            $tgl_awal = '';
            $tgl_akhir = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query(
                    $mysqli,
                    "SELECT * FROM kegiatan 
        WHERE id='" . $_GET['id'] . "'"
                );
                while ($row = mysqli_fetch_array($ambil)) {
                    $isi = $row['isi'];
                    $tgl_awal = $row['tgl_awal'];
                    $tgl_akhir = $row['tgl_akhir'];
                }
            ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php
            }
            ?>
            <div class="col">
                <label for="inputIsi" class="form-label fw-bold">
                    Kegiatan
                </label>
                <input type="text" class="form-control" name="isi" id="inputIsi" placeholder="Kegiatan" value="<?php echo $isi ?>">
            </div>
            <div class="col">
                <label for="inputTanggalAwal" class="form-label fw-bold">
                    Tanggal Awal
                </label>
                <input type="date" class="form-control" name="tgl_awal" id="inputTanggalAwal" placeholder="Tanggal Awal" value="<?php echo $tgl_awal ?>">
            </div>
            <div class="col mb-2">
                <label for="inputTanggalAkhir" class="form-label fw-bold">
                    Tanggal Akhir
                </label>
                <input type="date" class="form-control" name="tgl_akhir" id="inputTanggalAkhir" placeholder="Tanggal Akhir" value="<?php echo $tgl_akhir ?>">
            </div>
            <div class="row">
                <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
            </div>
        </form>

        <!-- Table-->
<table class="table table-hover">
    <!--thead atau baris judul-->
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Kegiatan</th>
            <th scope="col">Awal</th>
            <th scope="col">Akhir</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!--tbody berisi isi tabel sesuai dengan judul atau head-->
    <tbody>
        <!-- Kode PHP untuk menampilkan semua isi dari tabel urut
        berdasarkan status dan tanggal awal-->
        <?php
        $result = mysqli_query(
            $mysqli,"SELECT * FROM kegiatan ORDER BY status,tgl_awal"
            );
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <th scope="row"><?php echo $no++ ?></th>
                <td><?php echo $data['isi'] ?></td>
                <td><?php echo $data['tgl_awal'] ?></td>
                <td><?php echo $data['tgl_akhir'] ?></td>
                <td>
                    <?php
                    if ($data['status'] == '1') {
                    ?>
                        <a class="btn btn-success rounded-pill px-3" type="button" 
                        href="index.php?id=<?php echo $data['id'] ?>&aksi=ubah_status&status=0">
                        Sudah
                        </a>
                    <?php
                    } else {
                    ?>
                        <a class="btn btn-warning rounded-pill px-3" type="button" 
                        href="index.php?id=<?php echo $data['id'] ?>&aksi=ubah_status&status=1">
                        Belum</a>
                    <?php
                    }
                    ?>
                </td>
                <td>
                    <a class="btn btn-info rounded-pill px-3" 
                    href="index.php?id=<?php echo $data['id'] ?>">Ubah
                    </a>
                    <a class="btn btn-danger rounded-pill px-3" 
                    href="index.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
    </div>
</body>

</html>
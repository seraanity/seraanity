<?php
require 'function.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail Artikel - Seraanity</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="http://localhost/pemrograman%20web/blog.php">Seraanity</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="http://localhost/pemrograman%20web/blog.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Post content-->
                    <article>
                        <?php
                        $data_id_kontributor = $_GET['id_kontributor'];
                        $data_id_kategori = $_GET['id_kategori'];
                        $sql = "SELECT
                        kontributor.id_kontributor,
                        kontributor.id_kategori,
                        artikel.tanggal,
                        artikel.isi,
                        kategori.id_kategori,
                        artikel.judul,
                        penulis.nama_penulis,
                        kategori.nama_kategori,
                        artikel.gambar
                    FROM 
                        kontributor
                    JOIN
                        artikel ON kontributor.id_artikel = artikel.id_artikel
                    JOIN
                        penulis ON kontributor.id_penulis = penulis.id_penulis
                    JOIN
                        kategori ON kontributor.id_kategori = kategori.id_kategori
                    WHERE kontributor.id_kontributor='$data_id_kontributor'&& kontributor.id_kategori='$data_id_kategori'";
            $result = mysqli_query($conn, $sql);
            $nomor_urut = 0;
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)) {
                $nomor_urut ++;
                $data_tanggal = $row['tanggal'];
                $data_judul = $row['judul'];
                $data_kategori = $row['nama_kategori'];
                $data_penulis = $row['nama_penulis'];
                $data_gambar = $row['gambar'];
                $data_id_kontributor = $row['id_kontributor'];
                $data_id_kategori = $row['id_kategori'];
                $data_isi = $row['isi'];
                        ?>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1"><?php echo $data_judul; ?></h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2"><?php echo $data_tanggal; ?> by <?php echo $data_penulis; ?></div>
                            <!-- Post categories-->
                            <a class="badge bg-secondary text-decoration-none link-light" href="pilihan.php?id_kategori=<?php echo $data_id_kategori; ?>"><?php echo $data_kategori; ?></a>
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" src="<?php echo $data_gambar; ?>" alt="..." /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <?php echo $data_isi; ?>
                            <div class="d-flex justify-content-end">
                            <button class="btn btn-outline-primary" onclick="history.back()">Kembali</button>
                            </div>
                        </section>
                        <?php
                                        }
                                    }else{
                                        
                                    }
                        ?>
                    </article>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Masukkan Kata Kunci" aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                            </div>
                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Artikel Terkait</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group">
                                        <?php
                                        $data_id_kontributor = $_GET['id_kontributor'];
                                        $data_id_kategori = $_GET['id_kategori'];
                                        $sql = "SELECT
                                        kontributor.id_kontributor,
                                        kontributor.id_kategori,
                                        artikel.tanggal,
                                        artikel.isi,
                                        kategori.id_kategori,
                                        artikel.judul,
                                        penulis.nama_penulis,
                                        kategori.nama_kategori,
                                        artikel.gambar
                                    FROM 
                                        kontributor
                                    JOIN
                                        artikel ON kontributor.id_artikel = artikel.id_artikel
                                    JOIN
                                        penulis ON kontributor.id_penulis = penulis.id_penulis
                                    JOIN
                                        kategori ON kontributor.id_kategori = kategori.id_kategori
                                    WHERE kontributor.id_kategori='$data_id_kategori' && kontributor.id_kontributor < '$data_id_kontributor'
                                    ORDER BY kontributor.id_kontributor DESC";
                            $result = mysqli_query($conn, $sql);
                            $nomor_urut = 0;
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)) {
                                $nomor_urut ++;
                                $data_tanggal = $row['tanggal'];
                                $data_judul = $row['judul'];
                                $data_kategori = $row['nama_kategori'];
                                $data_penulis = $row['nama_penulis'];
                                $data_gambar = $row['gambar'];
                                $data_id_kontributor = $row['id_kontributor'];
                                $data_id_kategori = $row['id_kategori'];
                                $data_isi = $row['isi'];
                                $data_potongan_isi = potong_isi($data_isi, 20);
                                        ?>
                                        <a href="detail.php?id_kontributor=<?php echo $data_id_kontributor; ?>&id_kategori=<?php echo $data_id_kategori; ?>" class="list-group-item list-group-item-action"><?php echo $data_judul; ?></a>
                                        <?php
                                                            }
                                                        }else{
                                                            
                                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>

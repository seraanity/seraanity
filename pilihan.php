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
        <title>Home - Blog Seraanity</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <style type="text/css">
            .TentangKami{
                text-align: justify;
            }
        </style>
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="http://localhost/PROJEKUAS/blog.php">Seraanity</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="http://localhost/PROJEKUAS/blog.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Kontak</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Blog</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Selamat Datang di Blog Seraanity</h1>
                    <p class="lead mb-0">Artikel seputar Pariwisata, Makanan, Teknologi, dan lainnya.</p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                     <?php
                     $id_kategori_terpilih = $_GET['id_kategori']; 
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
                     WHERE kontributor.id_kategori ='$id_kategori_terpilih'
                 ORDER BY kontributor.id_kategori DESC";
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
             $data_potongan_isi = potong_isi($data_isi, 250);
                     ?>
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="<?php echo $data_gambar; ?>" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted"><?php echo $data_tanggal; ?></div>
                            <h2 class="card-title"><?php echo $data_judul; ?></h2>
                            <p class="card-text"><?php echo $data_potongan_isi; ?></p>
                            <a class="btn btn-primary" href="detail.php?id_kontributor=<?php echo $data_id_kontributor; ?>&id_kategori=<?php echo $data_id_kategori; ?>">Read more</a>
                        </div>
                    </div>
                    <?php 
                        }
                        } else {
                            
                        }
                    ?>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Cari</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Masukkan Kata Kunci..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Ayo!</button>
                            </div>
                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Kategori</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                <div class="list-group">
                                <?php
                                            $sql = "SELECT id_kategori, nama_kategori, keterangan FROM kategori ORDER BY id_kategori DESC";
                                            $result = mysqli_query($conn, $sql);
                                            
                                            if (mysqli_num_rows($result) > 0) {
                                                $nomor_urut = 0;
                                              // output data of each row
                                              while($row = mysqli_fetch_assoc($result)) {
                                                $nomor_urut++;
                                                $data_id_kategori = $row['id_kategori'];
                                                $data_nama = $row['nama_kategori'];
                                                $data_keterangan = $row['keterangan'];
                                            ?>
                                        <a href="pilihan.php?id_kategori=<?php echo $data_id_kategori; ?>" class="list-group-item list-group-item-action"><?php echo $data_nama; ?></a>
                                        <?php
                                              } 
                                            }else {

                                            }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">Tentang Kami</div>
                        <div class="card-body TentangKami">Sekedar publikasi mengenai kejadian yang ada di dunia maya. 
                            Jika ada komentar dan saran silahkan kontak kami.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Seraanity 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>

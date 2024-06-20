<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webpage";

$conn = mysqli_connect($servername, $username, $password, $dbname);
 if (!$conn) {
    die("connection failed: " . mysqli_connect_error());
 }
 else {

 }

 if(isset($_POST['btn_login'])) {
    $data_email = $_POST['email'];
    $data_password = $_POST['password'];

    $sql = "SELECT * FROM penulis WHERE email='$data_email' AND password= '$data_password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $_SESSION["email"] = $data_email;
            $_SESSION["password"] = $data_password;
            $_SESSION['idpenulis'] = $row['id_penulis'];
        } 
        header('location:index.php');
    } else {
       
    }
 }

if(isset($_POST['btn_hapus_artikel'])){
  $id_hapus = $_POST['id_hapus_artikel'];

    // sql to delete a record
  $sql_hapus_artikel = "DELETE FROM artikel WHERE id_artikel IN (SELECT id_artikel FROM kontributor WHERE id_kontributor = '$id_hapus' )";
  $sql_hapus_kontributor = "DELETE FROM kontributor WHERE id_kontributor = '$id_hapus'";

  if (mysqli_query($conn, $sql_hapus_artikel)) {
    if (mysqli_query($conn, $sql_hapus_kontributor)) {
      header('location:artikel.php');
    
    } else {
      echo "Error deleting record: " . mysqli_error($conn);
    }
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }

}

if(isset($_POST['btn_simpan'])){

    $target_dir = "picture/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["gambar"]["size"] > 50000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["gambar"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }

    $data_tanggal = $_POST['tanggal'];
    $data_judul = $_POST['judul'];
    $data_isi = $_POST['isi'];
    $data_kategori = $_POST['kategori'];
    $data_gambar = $target_file;

    $sql = "INSERT INTO artikel (tanggal, judul, isi, gambar) VALUES ('$data_tanggal', '$data_judul', '$data_isi', '$data_gambar')";

    if (mysqli_query($conn, $sql)) {
      $sql = "SELECT * FROM artikel ORDER BY id_artikel DESC LIMIT 1";
      $result = mysqli_query($conn, $sql);
      $data_id_artikel = "";

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $data_id_artikel = $row['id_artikel'];
        }


      } else {
        echo "0 results";
      }

      $data_id_penulis = $_SESSION['idpenulis'];

      $sql = "INSERT INTO kontributor (id_penulis, id_kategori, id_artikel) VALUES ('$data_id_penulis', '$data_kategori', '$data_id_artikel')";

      if (mysqli_query($conn, $sql)) {
        header('location:artikel.php');
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

    } else {
      
    }
  }

if(isset($_POST['btn_ubah_artikel'])){
  $target_dir = "picture/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["gambar"]["size"] > 50000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["gambar"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }

    $data_tanggal = $_POST['tanggal'];
    $data_judul = $_POST['judul'];
    $data_isi = $_POST['isi'];
    $data_kategori = $_POST['kategori'];
    $data_gambar = $target_file;
    $id_ubah = $_POST['id_kontributor_ubah'];
  
    $sql_update_artikel = "UPDATE artikel 
                            INNER JOIN kontributor ON artikel.id_artikel = kontributor.id_artikel 
                            SET 
                              artikel.judul = '$data_judul', 
                              artikel.isi = '$data_isi', 
                              artikel.gambar = '$data_gambar' 
                            WHERE 
                              kontributor.id_kontributor = '$id_ubah'";

    $sql_update_kontributor = "UPDATE kontributor SET id_kategori = '$data_kategori' WHERE id_kontributor = '$id_ubah'";
    
    if (mysqli_query($conn, $sql_update_artikel)) {
      if (mysqli_query($conn, $sql_update_kontributor)) {
        header('location:artikel.php');
      }  else  {
        
      } 
    }  else  {
      

    }               
}

if(isset($_POST['btn_simpan_kategori'])){
  $data_nama = $_POST['nama'];
  $data_keterangan = $_POST['keterangan'];
  $sql = "INSERT INTO kategori (nama_kategori, keterangan)
  VALUES ('$data_nama', '$data_keterangan')";

  if (mysqli_query($conn, $sql)) {
    header('location:kategori.php');
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  }

  if(isset($_POST['btn_ubah_kategori'])){
    $data_nama = $_POST['nama'];
    $data_keterangan = $_POST['keterangan'];
    $id_update = $_POST['id_kategori_update'];
    $sql = "UPDATE kategori SET nama_kategori='$data_nama', keterangan='$data_keterangan' WHERE id_kategori='$id_update'";

    if (mysqli_query($conn, $sql)) {
      header('location:kategori.php');
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }

  if(isset($_POST['btn_hapus_kategori'])){
    $id_hapus = $_POST['id_hapus_kategori'];
    $sql = "DELETE FROM kategori WHERE id_kategori='$id_hapus'";
    if(mysqli_query($conn,$sql)){
      header('location:kategori.php');;
    }else{
      echo "error deleting record : ".mysqli_error($conn);
    }
  }
   
if(isset($_POST['btn_ubah_penulis'])){
    $data_nama_penulis = $_POST['nama'];
    $data_email = $_POST['email'];
    $data_password = md5($_POST['password']);
    $id_update = $_POST['id_penulis_update'];

    $sql = "UPDATE penulis SET nama_penulis='$data_nama_penulis', email='$data_email', password='$data_password' WHERE id_penulis='$id_update'";

    if (mysqli_query($conn, $sql)) {
      header('location:penulis.php');
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
}

if(isset($_POST['btn_hapus_penulis'])){
  $id_hapus = $_POST['id_hapus_penulis'];
  $sql = "DELETE FROM penulis WHERE id_penulis='$id_hapus'";
  if(mysqli_query($conn,$sql)){
    header('location:penulis.php');
  }else{
    echo "error deleting record : " . mysqli_error($conn);
  }
}

if(isset($_POST['btn_simpan_penulis'])){
  $data_nama_penulis = $_POST['nama'];
  $data_email = $_POST['email'];
  $data_password = md5($_POST['password']);

  $sql = "INSERT INTO penulis (nama_penulis, email, password)
  VALUES ('$data_nama_penulis', '$data_email', '$data_password')";

  if (mysqli_query($conn, $sql)) {
    header('location:penulis.php');
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

function potong_isi($isiartikel, $jumlahkarakter){
  while($isiartikel[$jumlahkarakter] != " "){
    --$jumlahkarakter;
  }
  $potongan_isi = substr($isiartikel,0,$jumlahkarakter);
  $isi_potongan_artikel = $potongan_isi."...";
  return $isi_potongan_artikel;
}

//terjemah hari
function hariIndonesia($namahari){
    $hari = $namahari;
 switch ($hari) {
  case "Sunday":
    $hari = "minggu";
    return $hari;
  case "Monday":
    $hari = "senin";
    return $hari;
  case "Tuesday":
    $hari = "selasa";
    return $hari;
  case "Wednesday":
    $hari = "rabu";
    return $hari;
  case "Thursday":
    $hari = "kamis";
    return $hari;
  case "Friday":
    $hari = "jumat";
    return $hari;
  case "Saturday":
    $hari = "sabtu";
    return $hari;
                        
  default:
    $hari = "nama hari";
}

}
 ?>
 
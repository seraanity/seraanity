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

 }  // file ini berisi koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_email = $_POST['email'];
    $data_password = $_POST['password'];

    $sql = "SELECT * FROM penulis WHERE email='$data_email' AND password= '$data_password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)){
            $_SESSION["email"] = $data_email;
            $_SESSION["password"] = $data_password;
            
        } 
        header('location:index.php');
    } else {
       
    }
}
?>
